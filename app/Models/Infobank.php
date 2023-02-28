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
        'iban',
        'bic',
        'prelevement',
        'prelevement_date',
    ];
}
