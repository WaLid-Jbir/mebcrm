<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adherant;

class AdherantFamille extends Model
{
    use HasFactory;

    protected $fillable = [
        'adherant_id',
        'nom',
        'prenom',
        'naissance',
        'parente',
        'sexe'
    ];

    // public function adherant(){
    //     return $this->belongsTo(Adherant::class);
    // }
}
