<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdherantCardOverview extends BaseWidget
{

    protected static ?int $sort = -2;

    protected static string $view = 'filament.widgets.adherant-info';

    protected int | string | array $columnSpan = '2';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('Adherant');
    }


    // protected function getCards(): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
