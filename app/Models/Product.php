<?php

namespace App\Models;

use App\Models\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFile;

    const IMAGE_WIDTH = 210;

    protected $fillable = [
        'name',
        'price',
        'old_price',
        'image',
        'review_count',
        'review',
        'is_popular',
        'description',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
