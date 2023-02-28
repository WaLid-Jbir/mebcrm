<?php

namespace App\Filament\Resources\ProspectSuiviResource\Pages;

use App\Filament\Resources\ProspectSuiviResource;
use App\Models\Adherant;
use App\Models\ProspectSuivi;
use Filament\Forms\Components\Builder;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;


class ListProspectSuivis extends ListRecords
{
    protected static string $resource = ProspectSuiviResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return 'Suivi des prospects';
    }

    protected function getTableQuery(): EloquentBuilder
    {
        $id = Auth::user()->id;
        $user = Auth::user();

        if($user->hasRole('Admin')){
            return Adherant::query()->where(['flag' => 'devis envoye'])->orderBy('created_at', 'desc');
        }
        else{
            return Adherant::where(['user_id' => $id, 'flag' => 'devis envoye'])->orderBy('created_at', 'desc');
        }
    }

}
