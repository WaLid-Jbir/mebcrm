<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = ['name','address','country','city'];

    public function users(){
        return $this->hasMany(User::class);
    }

}
