<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppIntroduction extends Model
{
    use HasFactory;

    protected $table = 'app_introduction';

    protected $fillable = [
        'title',
        'description' 
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
