<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'service_section_id',
        'icon',
        'title',
        'description',
        'is_recommend',
        'sort_order',
    ];

    protected $casts = [
        'is_recommend' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(ServiceSection::class, 'service_section_id');
    }
}
