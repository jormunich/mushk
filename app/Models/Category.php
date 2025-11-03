<?php

namespace App\Models;

use App\Models\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFile, SoftDeletes;

    const IMAGE_WIDTH = 160;

    protected $fillable = [
      'name',
      'image',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
