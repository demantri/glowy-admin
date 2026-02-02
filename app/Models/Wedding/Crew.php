<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crew extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(CrewMember::class)->orderBy('sort_order');
    }
}
