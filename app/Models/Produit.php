<?php

namespace App\Models;

use Attribute;
use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produit extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'produits';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'banner',
        'content',
        'phone',
    ];

    // /**
    //  * @var array<string>
    //  */
    // protected $appends = [
    //     'banner_url',
    // ];

    // public function scopePublished(Builder $query)
    // {
    //     return $query->whereNotNull('published_at');
    // }

    // public function scopeDraft(Builder $query)
    // {
    //     return $query->whereNull('published_at');
    // }
}
