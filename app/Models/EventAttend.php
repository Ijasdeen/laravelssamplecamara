<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttend extends Model
{
    use HasFactory;

    protected $table = 'event_attend';

    protected $fillable = [
        'event_id',
        'user_id', 
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
