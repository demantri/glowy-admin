<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEvent extends Model
{
    protected $table = 'client_events';
    
    protected $fillable = [
        'description',
        'thumbnail',
        'original_image',
    ];
}
