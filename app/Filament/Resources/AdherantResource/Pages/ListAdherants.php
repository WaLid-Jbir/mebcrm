<?php

namespace App\Filament\Resources\AdherantResource\Pages;

use App\Filament\Resources\AadherantResource\Widgets\AdherantStatsOverview;
use App\Filament\Resources\AdherantResource;
use App\Models\Adherant;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListAdherants extends ListRecords
{
    protected static string $resource = AdherantResource::class;

    protected function getTitle(): string
    {
        return 'Prospects';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $id = Auth::user()->id;
        $user = Auth::user();

        if($user->hasRole('Admin')){
            return Adherant::query()->orderBy('created_at', 'desc');
        }
        else{
            return Adherant::where('user_id',$id)->orderBy('created_at', 'desc');
        }
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 75, 100];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AdherantStatsOverview::class,
        ];
    }
    
}
