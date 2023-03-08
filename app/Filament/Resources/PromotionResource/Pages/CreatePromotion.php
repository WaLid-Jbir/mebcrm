<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use App\Filament\Resources\PromotionResource;
use App\Mail\PromotionNewsletter;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

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
        $coupon = $this->record->coupon;
        $remise = $this->record->remise;
        $lien = $this->record->lien;

        if (!empty($adherants)) {
            foreach ($adherants as $adh) {
                Mail::to($adh->email)->send(new PromotionNewsletter($adh->name, $title, $coupon, $remise, $lien));
            }
            Notification::make()
                ->title('Post')
                ->body('La promotion a été envoyé à tout les adhérents de la société.')
                ->success()
                ->send();
        }
    }
}
