<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AadherantResource\Widgets\AdherantStatsOverview;
use App\Filament\Resources\AdherantResource\Pages;
use App\Filament\Resources\AdherantResource\RelationManagers;
use App\Http\Controllers\DocusignController;
use App\Http\Controllers\EnvelopeController;
use App\Models\Adherant;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\Form;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Http\Controllers\PDFController;
use Filament\Notifications\Notification;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class AdherantResource extends Resource
{
    protected static ?string $model = Adherant::class;

    protected static ?string $navigationLabel = 'Prospects';

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    protected static ?string $navigationGroup = 'Prospects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\Select::make('civilite')
                    ->options([
                        'mr' => 'Mr',
                        'mme' => 'Mme',
                    ])
                    ->required(),
                    Forms\Components\TextInput::make('nom')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('prenom')
                    ->label('Prénom')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('naissance')
                    ->required()
                    ->label('Date de naissance'),
                    Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                    Forms\Components\TextInput::make('adresse')
                    ->required(),
                    Forms\Components\TextInput::make('ville')
                    ->required(),
                    Forms\Components\TextInput::make('zip')->label('Code Postal')
                    ->required(),
                    // Forms\Components\TextInput::make('pays')
                    // ->required(),
                    Forms\Components\TextInput::make('telephone')
                    ->required()
                    ->tel()
                    ->label('Téléphone'),
                    Forms\Components\TextInput::make('fixe')
                    ->required()
                    ->tel(),
                    Forms\Components\Select::make('flag')
                    ->options([
                        'devis cree' => 'Devis Crée',
                        'devis envoye' => 'Devis Envoyé',
                        // 'devis accepte' => 'Devis Accepté',
                        // 'devis rejete' => 'Devis Rejeté',
                    ])
                    ->default('devis cree')
                    ->label('Flag')
                    ->hiddenOn(['create','edit'])
                    ->required(),
                ])
                ->columns(2),

                Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('Composition Familiale'),

                    Forms\Components\Repeater::make('adherantfamilles')->label('')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('nom')
                            ->required(),
                            Forms\Components\TextInput::make('prenom')
                            ->required()
                            ->label('Prénom'),
                            Forms\Components\DatePicker::make('naissance')
                            ->required()
                            ->label('Date de naissance'),
                            Forms\Components\Select::make('parente')
                            ->options([
                                'conjoint' => 'Conjoint',
                                'enfant' => 'Enfant',
                            ])
                            ->required()
                            ->label('Parenté'),
                            Forms\Components\Radio::make('sexe')
                            ->options([
                                'homme' => 'Homme',
                                'femme' => 'Femme',
                                'autre' => 'Autre'
                            ])
                            ->required()
                            ->inline()
                        ])
                        ->columns(2)
                        ->createItemButtonLabel('+ Ajouter membre de famille')
                    ]),

                Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('Compte bancaire'),

                    Forms\Components\Repeater::make('infobank')->label('')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('titulaire')
                            ->required(),
                            Forms\Components\TextInput::make('iban')
                            ->required(),
                            Forms\Components\TextInput::make('bic')
                            ->required(),
                            Forms\Components\Select::make('prelevement')
                            ->label('Mode Prélèvement')
                            ->options([
                                'mensuel' => 'Mensuel',
                                'annuel' => 'Annuel',
                            ])
                            ->required(),
                            Forms\Components\DatePicker::make('prelevement_date')
                            ->label('Date Prélèvement')
                            ->minDate(now())
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        ])
                        ->minItems(1)
                        ->maxItems(1)
                        ->columns(2)
                        ->createItemButtonLabel('+ Ajouter compte bancaire'),
                            ]),

                Card::make()
                ->schema([
                    Forms\Components\Placeholder::make('Divers'),

                    Forms\Components\Repeater::make('diver')->label('')
                        ->relationship()
                        ->schema([
                            Forms\Components\Radio::make('question1')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ])
                            ->required()
                            ->label('Acceptez-vous le principe d\'une communication numérique ?'),

                            Forms\Components\Radio::make('question2')
                            ->options([
                                'oui' => 'Oui',
                                'non' => 'Non',
                            ])
                            ->required()
                            ->label('Souhaitez-vous l\'inscription sur Bloctel ?'),
                            Forms\Components\Textarea::make('commentaire')
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        ])
                        ->minItems(1)
                        ->maxItems(1)
                        ->columns(2),
                ])
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
                Tables\Columns\BadgeColumn::make('flag')
                ->label('Status')
                ->color(static function ($state): string {
                    if ($state === 'devis cree') {
                        return 'secondary';
                    }
                    if($state === 'devis envoye') {
                        return 'primary';
                    }
                    // if($state === 'devis accepte'){
                    //     return 'success';
                    // }
                    // if($state === 'devis rejete'){
                    //     return 'danger';
                    // }
                    //just added in saturday 18/02/2023
                    return 'secondary';
                }),
                Tables\Columns\TextColumn::make('user.name')->label('Crée par')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Envoyer devis par mail')
                ->action(function (Adherant $record): void {
                    $adherant_id = $record->id;
                    $foo = new PDFController();
                    $foo->index($adherant_id);

                    $envolope = new DocusignController();
                    $envolope->signDocument($adherant_id);
                    
                    Notification::make() 
                    ->title('Message envoyé')
                    ->success()
                    ->send();
                    
                    // $mail = new EnvelopeController();
                    // $mail->createEnvelopeAndSendEmail($adherant_id);
                })
                ->color('success')
                ->icon('heroicon-o-mail'),



                // Tables\Actions\Action::make('Changer Status')
                // ->color('success')
                // ->modalHeading(fn (Adherant $record): string => "Changer status de ({$record->nom} {$record->prenom})")
                // ->icon('heroicon-o-pencil')
                // ->size('sm')
                // ->mountUsing(fn (Forms\ComponentContainer $form, Adherant $record) => $form->fill([
                //     'flag' => $record,
                // ]))
                // ->action(function (Adherant $record, array $data): void {
                //     $record->flag = ($data['flag']);
                //     $record->save();
                // })
                // ->form([
                //     Forms\Components\Select::make('flag')
                //         ->label('Status')
                //         ->options([
                //             'devis cree' => 'Devis Créé',
                //             'devis envoye' => 'Devis Envoyé',
                //             // 'devis accepte' => 'Devis Accepté',
                //             // 'devis rejete' => 'Devis Rejeté',
                //         ])
                //         ->required(),
                // ])
                
                //===========================================================

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AdherantStatsOverview::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdherants::route('/'),
            'create' => Pages\CreateAdherant::route('/create'),
            'edit' => Pages\EditAdherant::route('/{record}/edit'),
        ];
    }    
}
