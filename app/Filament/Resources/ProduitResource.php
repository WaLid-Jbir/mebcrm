<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProduitResource\Pages;
use App\Filament\Resources\ProduitResource\RelationManagers;
use App\Models\Produit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProduitResource extends Resource
{
    protected static ?string $model = Produit::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Les produits';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Titre'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label(__('Slug'))
                            ->disabled()
                            ->required()
                            ->unique(Produit::class, 'slug', fn ($record) => $record),

                        
                        Forms\Components\FileUpload::make('banner')
                            ->label(__('Image'))
                            ->image()
                            ->maxSize(5120)
                            ->imageCropAspectRatio('16:9')
                            ->directory('produits'),
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Publié le'),

                        Forms\Components\RichEditor::make('content')
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Tables\Columns\ImageColumn::make('banner')
                        ->label(__('Image'))
                        ->grow(false)
                        ->circular(),

                    Tables\Columns\TextColumn::make('title')
                        ->searchable()
                        ->weight('bold')
                        ->copyable()
                        ->label(__('Titre')),

                    Stack::make([
                        Tables\Columns\TextColumn::make('contactez l\'un de nos experts')
                        ->default('Contactez l\'un de nos experts'),

                        Tables\Columns\TextColumn::make('contact')
                        ->label('Contactez un expert')
                        ->icon('heroicon-s-phone')
                        ->color('secondary')
                        ->default('0651487963'),
                    ])->visibleFrom('md'),
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProduits::route('/'),
            'create' => Pages\CreateProduit::route('/create'),
            'view' => Pages\ViewProduit::route('/{record}'),
            'edit' => Pages\EditProduit::route('/{record}/edit'),
        ];
    }    
}
