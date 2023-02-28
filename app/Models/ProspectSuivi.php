<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adherant;

class ProspectSuivi extends Model
{
    use HasFactory;

    protected $fillable = [
        'adherant_id',
        'audio',
        'audio_status',
        'motif',
    ];

    public function adherant(){
        return $this->belongsTo(Adherant::class);
    }
}
