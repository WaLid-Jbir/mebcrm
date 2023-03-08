<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Mon profil')
                    ->url(route('filament.pages.my-profile'))
                    ->icon('heroicon-s-cog'),
                // ...
            ]);
        });
    }
}
