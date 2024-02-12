<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'image',
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
