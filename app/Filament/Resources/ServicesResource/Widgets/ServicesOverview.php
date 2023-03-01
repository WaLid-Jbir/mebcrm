<?php

namespace App\Filament\Resources\ServicesResource\Widgets;

use Filament\Widgets\Widget;

class ServicesOverview extends Widget
{
    protected static string $view = 'filament.resources.services-resource.widgets.services-overview';

    protected int | string | array $columnSpan = 'full';
    
    public static function canView(): bool
    {
        return auth()->user()->hasRole('Adherant');
    }
}
