<?php

use Illuminate\Support\Facades\Auth;

return [

    'buttons' => [

        'logout' => [
            'label' => 'Déconnexion',
        ],

    ],

    'welcome' => 'Bonjour :user de '.' '. Auth::user()->entreprise->name,

];
