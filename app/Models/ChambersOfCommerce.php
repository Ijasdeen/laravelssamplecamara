<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChambersOfCommerce extends Model
{
    use HasFactory;

    protected $table = 'chambers_of_commerce';

    protected $fillable = [
        'title',
        'description' ,
        'image'
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
