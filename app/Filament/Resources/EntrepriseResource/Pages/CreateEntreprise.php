<?php

namespace App\Filament\Resources\EntrepriseResource\Pages;

use App\Filament\Resources\EntrepriseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEntreprise extends CreateRecord
{
    protected static string $resource = EntrepriseResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
