<?php

namespace App\Filament\Resources\AdherantResource\Pages;

use App\Filament\Resources\AdherantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdherant extends EditRecord
{
    protected static string $resource = AdherantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
