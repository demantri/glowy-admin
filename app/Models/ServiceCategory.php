<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'icon',
        'order',
        'is_active',
    ];

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
