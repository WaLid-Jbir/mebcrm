<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AdherantFamille;
use App\Models\Infobank;
use App\Models\Diver;
use App\Models\Envolope;
use App\Models\ProspectSuivi;


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
        'telephone',
        'fixe',
        'flag',
        'user_id'
    ];
    
    protected $casts = [ 'naissance'=>'date'];


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

    public function envolopes(){
        return $this->hasOne(Envolope::class);
    }

    public function prospectsuivis(){
        return $this->hasMany(ProspectSuivi::class);
    }
}
