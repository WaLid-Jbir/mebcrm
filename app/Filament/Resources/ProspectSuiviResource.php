<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProspectSuiviResource\Pages;
use App\Filament\Resources\ProspectSuiviResource\RelationManagers;
use App\Mail\AdherantMail;
use App\Models\Adherant;
use App\Models\Envolope;
use App\Models\ProspectSuivi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use PhpParser\Node\Expr\Cast\String_;
use Psy\VersionUpdater\Downloader;
use Symfony\Polyfill\Intl\Idn\Resources\unidata\DisallowedRanges;

class ProspectSuiviResource extends Resource
{
    protected static ?string $model = Adherant::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Suivi des prospects';

    protected static ?string $navigationGroup = 'Prospects';

    protected static ?string $slug = 'prospects-suivis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')->searchable()->label('Nom'),
                Tables\Columns\TextColumn::make('prenom')->searchable()->label('Prénom'),
                Tables\Columns\TextColumn::make('created_at')->label('Ajouté le')
                ->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Crée par'),
                //Tables\Columns\TextColumn::make('')->label(' status')
                Tables\Columns\BadgeColumn::make('prospectsuivis.audio_status')
                ->default('en attent de fichier')
                // ->formatStateUsing(fn (string $state): string => __(strtok($state, ',')))
                ->getStateUsing(function (Adherant $record) {
                    if(!empty($record->prospectsuivis()->get()->first()->audio_status)){
                        return $record->prospectsuivis()->get()->first()->audio_status;
                    }
                    else{
                        return 'en attent de fichier';
                    }
                })
                ->label('Status')
                ->color(static function ($state): string {
                    // if($state === null){
                    //     return 'secondary';
                    // }
                    if ($state === 'en attent de fichier') {
                        return 'secondary';
                    }
                    if($state === 'en attent de confirmation') {
                        return 'primary';
                    }
                    if($state === 'lead confirme'){
                        return 'success';
                    }
                    if($state === 'lead rejete'){
                        return 'danger';
                    }
                    return 'secondary';
                }),
                Tables\Columns\TextColumn::make('prospectsuivis.motif')
                ->label('Motif')
                ->default('aucun')
                //->formatStateUsing(fn (string $state): string => __(strtok($state, ','))),
                ->getStateUsing(function (Adherant $record) {
                    if(!empty($record->prospectsuivis()->get()->first()->motif)){
                        return $record->prospectsuivis()->get()->first()->motif;
                    }
                    else{
                        return 'aucun';
                    }
                })
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Importer le fichier d appel')
                ->color('success')
                ->modalHeading(fn (Adherant $record): string => "Importer l'audio de conversation avec (".ucfirst($record->civilite).' '.ucfirst($record->nom).' '.ucfirst($record->prenom).")")
                ->icon('heroicon-o-upload')
                ->size('sm')
                ->mountUsing(fn (Forms\ComponentContainer $form, ProspectSuivi $re1) => $form->fill([
                    'audio' => $re1,
                ]))
                ->action(function (Adherant $record, ProspectSuivi $prospectsuivi, array $data): void {
                    Notification::make() 
                        ->title('Fichier importé')
                        ->body('fichier importé avec succès')
                        ->success()
                        ->send();
                })
                ->form([
                    Repeater::make('prospectsuivis')->label('Audio')
                    ->relationship()
                    ->required()
                    ->schema([
                        FileUpload::make('audio')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend(str_replace(['/',':',' '],'',date("Y/m/d H:m:s")).'_');
                        })
                        ->acceptedFileTypes(['audio/ogg','audio/mpeg','audio/wav','audio/x-wav','audio/x-wav-6khz','audio/x-wav-11khz'])
                        //->minFiles(1)
                        //->disc('')
                        ->enableDownload()
                        ->required(),
                        //====== Status de fichier =====
                        Forms\Components\Hidden::make('audio_status')->default('en attent de confirmation'),
                    ])
                    ->createItemButtonLabel('+ Ajouter fichier de l\'appel'),
                ]),

                Tables\Actions\Action::make('Télécharger devis')
                ->color('secondary')
                ->icon('heroicon-o-download')
                ->size('sm')
                ->action(function (Adherant $record, array $data) {
                    $id = $record->id;
                    if(!empty($record->envolopes()->where(['adherant_id' => $id])->first()->name)){
                        $pdf = $record->envolopes()->where(['adherant_id' => $id])->first()->name;
                        $filePath = public_path('contracts/'.$pdf);
                        return response()->download($filePath);
                    }else{
                        Notification::make() 
                        ->title('Devis n\'existe pas!')
                        ->body('Vous devez envoyer **le devis** au prospect pour le télécharger')
                        ->danger()
                        ->send();
                    }
                }),

                // Tables\Actions\Action::make('Download audio')
                // ->color('secondary')
                // ->icon('heroicon-o-download')
                // ->size('sm')
                // ->action(function (Adherant $record,ProspectSuivi $prospect ,array $data,) {
                //     $audio = $prospect->audio;
                //     dd($audio);
                    
                // })

                Tables\Actions\Action::make('Changer status')
                ->color('success')
                ->icon('heroicon-o-pencil-alt')
                ->modalHeading(fn (Adherant $record): string => "Changer status de fichier de conversation avec (".ucfirst($record->civilite).' '.ucfirst($record->nom).' '.ucfirst($record->prenom).")")
                ->size('sm')
                ->visible(auth()->user()->hasRole('Admin'))
                ->mountUsing(fn (Forms\ComponentContainer $form, ProspectSuivi $re2) => $form->fill([
                    'audio_status' => $re2,
                ]))
                ->action(function (Adherant $record, ProspectSuivi $prospectsuivi, array $data): void {
                    $rec = $record->prospectsuivis()->get();
                    foreach ($rec as $r) {
                        $r->audio_status = ($data['audio_status']);
                        $r->motif = ($data['motif']);
                        $r->save();
                    }
                    
                    //Create user from adherant when status = lead confirme
                    
                    if ($data['audio_status'] == 'lead confirme') {
                        if (User::where('email', '=', $record->email)->count() > 0) {
                            Notification::make() 
                            ->title('Error')
                            ->body('Adherant exist déja comme un utilisateur')
                            ->danger()
                            ->send();
                        }else{
                            $password = Str::random(8);
                            $user = User::create([
                                'name' => $record->nom,
                                'email' => $record->email,
                                'entreprise_id' => 1,
                                'password' => Hash::make($password),
                            ]);
                            $user->assignRole('Adherant');
                            
                            Mail::to($record->email)->send(new AdherantMail($record->email, $password));
                        }
                    }
                })
                ->form([
                    card::make()
                    ->schema([
                        Forms\Components\Select::make('audio_status')
                        ->label('Status')
                        ->options([
                            // 'en attent de fichier' => 'En attent de fichier',
                            // 'en attent de confirmation' => 'En attent de confirmation',
                            'lead confirme' => 'Lead confirmé',
                            'lead rejete' => 'Lead rejeté',
                        ])
                        ->required(),
                        Forms\Components\Textarea::make('motif')
                    ])
                ]),

                //Admin area

                Tables\Actions\Action::make('Télécharger fichier d appel')
                ->color('primary')
                ->modalHeading(fn (Adherant $record): string => "Les fichiers de conversation avec (".ucfirst($record->civilite).' '.ucfirst($record->nom).' '.ucfirst($record->prenom).")")
                ->size('sm')
                ->icon('heroicon-o-download')
                ->visible(function (Adherant $record){
                    if (auth()->user()->hasRole('Admin') && !empty($record->prospectsuivis()->get()->first())) {
                        return true;
                    }
                    else{
                        return false;
                    }
                })
                ->mountUsing(fn (Forms\ComponentContainer $form, ProspectSuivi $re1) => $form->fill([
                    'audio' => $re1,
                ]))
                ->action(function (Adherant $record, ProspectSuivi $prospectsuivi, array $data) {
                    Notification::make() 
                        ->title('Error')
                        ->body('vous n\'avez pas la permission')
                        ->danger()
                        ->send();
                    return false;
                })
                ->form([
                    Repeater::make('prospectsuivis')->label('Audio')
                    ->relationship()
                    ->required()
                    ->schema([
                        FileUpload::make('audio')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend(str_replace(['/',':',' '],'',date("Y/m/d H:m:s")).'_');
                        })
                        ->acceptedFileTypes(['audio/ogg','audio/mpeg','audio/wav','audio/x-wav','audio/x-wav-6khz','audio/x-wav-11khz'])
                        //->minFiles(1)
                        ->enableDownload()
                        ->disabled()
                        ->enableOpen()
                        ->required(),
                        //====== Status de fichier =====
                        // Forms\Components\Hidden::make('audio_status')->default('en attent de confirmation'),
                    ])
                    ->disableItemDeletion()
                    ->disableItemCreation()
                ]),


            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProspectSuivis::route('/'),
            'create' => Pages\CreateProspectSuivi::route('/create'),
            //'edit' => Pages\EditProspectSuivi::route('/{record}/edit'),
        ];
    }    
}
