<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->required()
                            ->unique(Post::class, 'slug', fn ($record) => $record),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->helperText('Ce champ représente le contenu de l\'e-mail envoyé aux adhérants de la société')
                            ->required()
                            ->rows(2)
                            ->minLength(50)
                            ->maxLength(600)
                            ->columnSpan([
                                'sm' => 2,
                            ]),

                        Forms\Components\FileUpload::make('banner')
                            ->label('Image')
                            ->required()
                            ->image()
                            ->maxSize(5120)
                            ->imageCropAspectRatio('16:9')
                            ->directory('blog')
                            ->columnSpan([
                                'sm' => 2,
                            ]),

                            Forms\Components\RichEditor::make('content')
                            ->label('Contenu')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                            ]),

                            Forms\Components\DatePicker::make('published_at')
                            ->label('Publié à')
                            ->default(now())
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé à')
                            ->content(fn (
                                ?Post $record
                            ): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modifié à')
                            ->content(fn (
                                ?Post $record
                            ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('banner')
                    ->label('Image')
                    ->extraImgAttributes(['class' => 'rounded-lg mb-3'])
                    ->size('full'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->weight('bold')
                    ->extraAttributes(['class' => 'mb-2'])
                    ->size('lg')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publié à')
                    ->color('secondary')
                    ->size('sm')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()
                ->label('Voir plus'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
        ];
    }
}
