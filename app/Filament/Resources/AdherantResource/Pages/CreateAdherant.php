<?php

namespace App\Filament\Resources\AdherantResource\Pages;

use App\Filament\Resources\AdherantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAdherant extends CreateRecord
{
    protected static string $resource = AdherantResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        
        return $data;
    }

    // protected function afterCreate(): void
    // {
    //     // Runs after the form fields are saved to the database.
    // }
}
