<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMission extends Model
{
    protected $fillable = [
        'about_id',
        'content',
        'position'
    ];
}
