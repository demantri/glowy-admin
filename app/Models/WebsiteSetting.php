<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $table = 'website_settings';
    
    protected $fillable = [
        'company_name',
        'logo',
        'favicon',
        'email',
        'phone',
        'address',
        'instagram',
        'tiktok',
        'youtube',
        'subtitle',
        'tagline',
    ];
}
