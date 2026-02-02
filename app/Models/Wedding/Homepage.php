<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Homepage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(HomepageImage::class)->orderBy('sort_order');
    }
}
