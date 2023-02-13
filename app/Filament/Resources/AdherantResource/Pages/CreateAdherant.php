<?php

namespace App\Filament\Resources\AdherantResource\Pages;

use App\Filament\Resources\AdherantResource;
use App\Http\Controllers\PDFController;
use App\Models\Adherant;
use App\Models\Envolope;
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

    // protected function afterCreate(array $data): void
    // {
    //     // $adherant_id = $data['id'];
    //     // $foo = new PDFController();
    //     // $foo->index($adherant_id);
    // }
}
