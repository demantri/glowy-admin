<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
    ];
}
