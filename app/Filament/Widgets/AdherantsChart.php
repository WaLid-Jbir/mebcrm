<?php

namespace App\Filament\Widgets;

use App\Models\Adherant;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\Auth;

class AdherantsChart extends BarChartWidget
{
    protected static ?string $heading = 'Prospects';

    public static function canView(): bool
    {
        if (Auth::user()->hasRole(['Admin','Manager'])) {
            return true;
        } else {
            return false;
        }
    }

    protected function getData(): array{

    $id = Auth::user()->id;

        if (Auth::user()->hasRole('Admin')) {
            $adherants = Adherant::select('created_at')->get()->groupBy(function ($adherants){
                return Carbon::parse($adherants->created_at)->format('l');
            });
            $quantities = [];
            foreach ($adherants as $adherant => $value) {
                array_push($quantities, $value->count());
            }
            return [
                'datasets' => [
                    [
                        'label' => 'Prospects ajouté',
                        'data' => $quantities,
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        'borderColor' => [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        'borderWidth' => 1
                    ],
                ],
                'labels' => $adherants->keys(),
            ];
        }


        if(Auth::user()->hasRole('Manager')){
            $adherants = Adherant::select('created_at')->where('user_id', $id)->get()->groupBy(function ($adherants){
                return Carbon::parse($adherants->created_at)->format('l');
            });
            $quantities = [];
            foreach ($adherants as $adherant => $value) {
                array_push($quantities, $value->count());
            }
            return [
                'datasets' => [
                    [
                        'label' => 'Prospects ajouté',
                        'data' => $quantities,
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        'borderColor' => [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        'borderWidth' => 1
                    ],
                ],
                'labels' => $adherants->keys(),
            ];
        }
        return [
            //
        ];
    }
}
