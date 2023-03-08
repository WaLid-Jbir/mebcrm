<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Mail\PostNewsletter;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

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
        $excerpt = $this->record->excerpt;
        $image = $this->record->banner;

        if (!empty($adherants)) {
            foreach ($adherants as $adh) {
                Mail::to($adh->email)->send(new PostNewsletter($adh->name, $title, $excerpt, $image));
            }
            Notification::make()
                ->title('Post')
                ->body('Le poste a été envoyé à tout les adhérents de la société.')
                ->success()
                ->send();
        }
    }
}
