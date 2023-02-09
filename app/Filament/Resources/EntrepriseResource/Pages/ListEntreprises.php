<?php

namespace App\Filament\Resources\EntrepriseResource\Pages;

use App\Filament\Resources\EntrepriseResource;
use App\Models\Entreprise;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListEntreprises extends ListRecords
{
    protected static string $resource = EntrepriseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getTableQuery(): Builder
    // {
    //     $id = Auth::user()->entreprise_id;
    //     $user = Auth::user();

    //     if($user->hasRole('Admin')){
    //         return Entreprise::query();
    //     }
    //     else{
    //         return Entreprise::where('id',$id);
    //     }
    // }
}
