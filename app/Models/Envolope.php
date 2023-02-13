<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adherant;

class Envolope extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'adherant_id'
    ];

    public function adherant(){
        return $this->belongsTo(Adherant::class);
    }
}
