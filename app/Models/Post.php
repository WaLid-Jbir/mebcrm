<?php

namespace App\Models;

use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'banner',
        'content',
        'published_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];

    // /**
    //  * @var array<string>
    //  */
    // protected $appends = [
    //     'banner_url',
    // ];

    // public function bannerUrl(): Attribute
    // {
    //     return Attribute::get(fn () => asset(Storage::url($this->banner)));
    // }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeDraft(Builder $query)
    {
        return $query->whereNull('published_at');
    }
}
