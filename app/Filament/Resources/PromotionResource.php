<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Filament\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-euro';

    protected static ?string $navigationGroup = 'Les Promotions';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Titre de Promotion'))
                    ->required(),
                    Forms\Components\TextInput::make('remise')
                    ->label(__('Montant de remise'))
                    ->required(),
                    // ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                // Forms\Components\TextInput::make('slug')
                //     ->label(__('Slug'))
                //     ->disabled()
                //     ->required()
                //     ->unique(Promotion::class, 'slug', fn ($record) => $record),
                Forms\Components\TextInput::make('coupon')
                ->label(__('coupon'))
                ->required(),
                Forms\Components\TextInput::make('lien')
                ->label(__('lien'))
                ->url()
                ->required(),
                
                    // Forms\Components\FileUpload::make('banner')
                    // ->label(__('Image'))
                    // ->image()
                    // ->maxSize(5120)
                    // ->imageCropAspectRatio('16:9')
                    // ->directory('blog'),
                Forms\Components\DatePicker::make('published_at')
                ->label('Publié le'),

                // RichEditor::make('content') 
                // ->required()               
                // ->columnSpan([
                //     'sm' => 2,
                // ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->weight('bold'),

                Tables\Columns\TextColumn::make('remise')
                ->extraAttributes(['class' => 'text-2xl'])
                ->color('success')
                ->weight('bold'),
                Tables\Columns\TextColumn::make('coupon')
                
                ->copyable()
                ->copyMessage('Vous avez coupier votre coupon')
                ->copyMessageDuration(3000)

                ->weight('bold')

                ->icon('heroicon-o-duplicate'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Ajouté le'),
                // ->size('lg'),
                Tables\Columns\TextColumn::make('lien'),
                ViewColumn::make('lien')->view('filament.tables.lien'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromotions::route('/'),
            // 'create' => Pages\CreatePromotion::route('/create'),
            // 'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }    
}
