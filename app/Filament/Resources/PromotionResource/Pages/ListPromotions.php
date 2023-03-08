<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use App\Filament\Resources\PromotionResource;
use App\Mail\PromotionNewsletter;
use App\Models\Promotion;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;

class ListPromotions extends ListRecords
{
    protected static string $resource = PromotionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
}
