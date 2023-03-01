<x-filament::widget class="filament-account-widget">
    <x-filament::card>
        @php
            $user_email = \Filament\Facades\Filament::auth()->user()->email;

            if(!empty(App\Models\Adherant::join('infobanks', 'adherants.id', '=', 'infobanks.adherant_id')->where(['adherants.email' => $user_email])->first()->prelevement_date)){
                $date = App\Models\Adherant::join('infobanks', 'adherants.id', '=', 'infobanks.adherant_id')->where(['adherants.email' => $user_email])->first()->prelevement_date;
            }
            else{
                $date = now();
            }

            if(!empty(App\Models\Adherant::join('infobanks', 'adherants.id', '=', 'infobanks.adherant_id')->where(['adherants.email' => $user_email])->first()->prelevement)){
                $plan = App\Models\Adherant::join('infobanks', 'adherants.id', '=', 'infobanks.adherant_id')->where(['adherants.email' => $user_email])->first()->prelevement;
            }
            else{
                $plan = 'aucun';
            }
            
        @endphp

        <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            <div>
                <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                    Le plan d'adhésion : {{ ucfirst($plan) }}
                </h2>
                <p class="text-sm text-gray-600">
                    Votre date d'adésion : {{ Carbon\Carbon::parse($date)->format('d-m-Y') }}
                </p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
