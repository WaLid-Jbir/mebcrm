<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infobank extends Model
{
    use HasFactory;

    protected $fillable = [
        'adherant_id',
        'titulaire',
        'adresse',
        'ville',
        'zip',
        'pays',
        'email',
        'telephone',
        'fixe',
        'iban',
        'bic',
        'prelevement',
    ];
}
