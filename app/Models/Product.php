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

    public function getRoundedRatingAttribute(): float
    {
        return ceil($this->review * 2) / 2;
    }

    public function getStarsAttribute(): string
    {
        $rating = $this->rounded_rating;
        $fullStars = floor($rating); // full stars
        $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0; // half star
        $emptyStars = 5 - $fullStars - $halfStar;
        $html = '<span class="rating">';

        $html .= str_repeat('<svg width="18" height="18" class="text-warning"><use xlink:href="#star-full"></use></svg>', $fullStars);

        if ($halfStar) {
            $html .= '<svg width="18" height="18" class="text-warning"><use xlink:href="#star-half"></use></svg>';
        }

        $html .= str_repeat('<svg width="18" height="18" class="text-warning"><use xlink:href="#star"></use></svg>', $emptyStars);

        $html .= '</span>';

        return $html;
    }

    public function getOldPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->old_price, 2, '.');
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->price, 2, '.');
    }

    public function getSalePercentAttribute(): int
    {
        if ($this->old_price) {
            $percent = (($this->old_price - $this->price) / $this->old_price) * 100;

            return round($percent);
        }

        return 0;
    }
}
