<?php

use Illuminate\Support\Facades\Auth;

if (auth()->user()->hasRole(['Admin','Manager'])) {
    return [
        
        'buttons' => [
            
            'logout' => [
                'label' => 'Déconnexion',
            ],
            
        ],
        
        'welcome' => 'Bienvenue :user de '.' '. Auth::user()->entreprise->name,
        
    ];
}
else{
    return [
        
        'buttons' => [
            
            'logout' => [
                'label' => 'Déconnexion',
            ],
            
        ],
        
        'welcome' => 'Bienvenue dans votre espace d\'adhésion',
        
    ];
}