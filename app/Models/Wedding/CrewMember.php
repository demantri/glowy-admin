<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrewMember extends Model
{
    protected $fillable = [
        'crew_id',
        'name',
        'description',
        'photo',
        'sort_order',
    ];

    public function crew(): BelongsTo
    {
        return $this->belongsTo(Crew::class);
    }
}
