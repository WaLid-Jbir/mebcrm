<?php

namespace App\Filament\Resources\ProduitResource\Pages;

use App\Filament\Resources\ProduitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduit extends ViewRecord
{
    protected static string $resource = ProduitResource::class;

    protected function getHeading():String
    {
        $title = $this->data['title'];
        return $title;
    }

    protected static string $view = 'filament.resources.produits-resource.pages.view-produit';
}
