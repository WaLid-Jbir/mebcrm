<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeading():String
    {
        $title = $this->data['title'];
        return $title;
    }

    protected static string $view = 'filament.resources.prospects-suivi-resource.pages.view-post';
}
