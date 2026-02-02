<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'icon',
        'header_services',
        'description',
        'is_recommend',
        'sort_order',
    ];

    protected $casts = [
        'is_recommend' => 'boolean',
    ];
}
