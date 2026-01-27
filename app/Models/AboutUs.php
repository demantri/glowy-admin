<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    
    protected $fillable = [
        'title',
        'description',
        'image',
        'vision_title',
        'vision_content',
        'mission_title',
    ];

    public function missions()
    {
        return $this->hasMany(AboutMission::class, 'about_id')
            ->orderBy('position');
    }
}
