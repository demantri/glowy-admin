<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageImage extends Model
{
    protected $fillable = [
        'homepage_id',
        'image_path',
        'sort_order',
    ];

    public function homepage(): BelongsTo
    {
        return $this->belongsTo(Homepage::class);
    }
}
