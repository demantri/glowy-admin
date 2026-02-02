<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'favicon',
        'logo',
        'company_name',
        'address',
        'whatsapp',
        'tiktok',
        'linkedin',
        'instagram',
        'youtube',
    ];
}
