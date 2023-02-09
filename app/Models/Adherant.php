<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AdherantFamille;
use App\Models\Infobank;
use App\Models\Diver;

class Adherant extends Model
{
    use HasFactory;

    protected $fillable = [
        'civilite',
        'nom',
        'prenom',
        'naissance',
        'email',
        'adresse',
        'ville',
        'zip',
        'pays',
        'telephone',
        'fixe',
        'flag',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function adherantfamilles(){
        return $this->hasMany(AdherantFamille::class);
    }

    public function infobank(){
        return $this->hasOne(Infobank::class);
    }

    public function diver(){
        return $this->hasOne(Diver::class);
    }
}
