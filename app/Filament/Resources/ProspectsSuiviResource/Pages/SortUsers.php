<?php

namespace App\Filament\Resources\ProspectsSuiviResource\Pages;

use App\Filament\Resources\ProspectsSuiviResource;
use Doctrine\DBAL\Schema\Table;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;

class SortUsers extends Page
{
    protected static string $resource = ProspectsSuiviResource::class;

    protected static string $view = 'filament.resources.prospects-suivi-resource.pages.sort-users';

    public static function getPages(): array
    {
        return [
            // ...
            'sort' => Pages\SortUsers::route('/sort'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columnsAreIndexed([
                TextColumn::make('nom')->searchable()->label('Nom'),
            ]);
    }
}
