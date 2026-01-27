<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    protected $table = 'why_choose_us';

    protected $fillable = [
        'title',
        'description',
        'image_main',
        'image_top',
        'image_bottom'
    ];

    public function items()
    {
        return $this->hasMany(
            WhyChooseItem::class,
            'why_choose_id', // foreign key di table items
            'id'             // local key
        )->orderBy('position');
    }
}
