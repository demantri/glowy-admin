<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
    protected $table = 'service_sections';
    
    protected $fillable = [
        'title',
        'subtitle', 
    ];

    public function services()
    {
        return $this->hasMany(Service::class)->orderBy('sort_order');
    }
}
