<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'cat_id',
        'title',
        'description',
        'address',
        'longitude',
        'latitude',
        'start_datetime',
        'end_datetime',
        'image', 
        'event_share',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'status'
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
