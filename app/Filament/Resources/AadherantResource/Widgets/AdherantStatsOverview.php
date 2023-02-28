<?php

namespace App\Filament\Resources\AadherantResource\Widgets;

use App\Models\Adherant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class AdherantStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $id = Auth::user()->id;
        $user = Auth::user();

        if($user->hasRole('Admin')){
            return [
                Card::make('Total', Adherant::all()->count()),
                Card::make('Devis Envoyé', Adherant::where(['flag' => 'devis envoye'])->count()),
                Card::make('Lead Confirmé', Adherant::join('prospect_suivis', 'adherants.id', '=', 'prospect_suivis.adherant_id')->where(['prospect_suivis.audio_status' => 'lead confirme'])->distinct('prospect_suivis.adherant_id')->count()),
                Card::make('Lead Rejeté', Adherant::join('prospect_suivis', 'adherants.id', '=', 'prospect_suivis.adherant_id')->where(['prospect_suivis.audio_status' => 'lead rejete'])->distinct('prospect_suivis.adherant_id')->count()),
            ];
        }
        elseif($user->hasRole(['Manager'])){
            return [
                Card::make('Total', Adherant::where(['user_id' => $id])->count()),
                Card::make('Devis Envoyé', Adherant::where(['user_id' => $id, 'flag' => 'devis envoye'])->count()),
                Card::make('Lead Confirmé', Adherant::join('prospect_suivis', 'adherants.id', '=', 'prospect_suivis.adherant_id')->where(['prospect_suivis.audio_status' => 'lead confirme', 'adherants.user_id' => $id])->distinct('prospect_suivis.adherant_id')->count()),
                Card::make('Lead Rejeté', Adherant::join('prospect_suivis', 'adherants.id', '=', 'prospect_suivis.adherant_id')->where(['prospect_suivis.audio_status' => 'lead rejete', 'adherants.user_id' => $id])->distinct('prospect_suivis.adherant_id')->count()),
            ];
        }
        else{
            return [
                //
            ];
        }
    }
}
