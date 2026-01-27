<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseItem extends Model
{
    protected $table = 'why_choose_items';
    
    protected $fillable = [
        'why_choose_id',
        'title',
        'position'
    ];
}
