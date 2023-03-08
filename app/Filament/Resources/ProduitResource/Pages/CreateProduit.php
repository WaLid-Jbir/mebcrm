<?php

namespace App\Filament\Resources\ProduitResource\Pages;

use App\Filament\Resources\ProduitResource;
use App\Mail\ProduitNewsletter;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateProduit extends CreateRecord
{
    protected static string $resource = ProduitResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $adherants = User::whereHas("roles", function($r) {
            $r->where("name", "Adherant");
        })->get();

        $title = $this->record->title;
        $content = $this->record->content;
        $image = $this->record->banner;

        if (!empty($adherants)) {
            foreach ($adherants as $adh) {
                Mail::to($adh->email)->send(new ProduitNewsletter($title, $content, $image));
            }
            Notification::make()
                ->title('Post')
                ->body('Le produit a été envoyé à tout les adhérents de la société.')
                ->success()
                ->send();
        }
    }
}
