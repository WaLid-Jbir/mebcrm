<?php

namespace App\Filament\Resources\ProspectSuiviResource\Pages;

use App\Filament\Resources\ProspectSuiviResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProspectSuivi extends EditRecord
{
    protected static string $resource = ProspectSuiviResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }

}
