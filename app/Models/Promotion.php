<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

        /**
     * @var string
     */
    protected $table = 'promotions';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'coupon',
        'lien',
        'remise',
        'published_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];
}
