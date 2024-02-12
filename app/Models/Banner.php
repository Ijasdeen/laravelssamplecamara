<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banner';

    protected $fillable = [
        'banner_image' ,
        'banner_type' ,
        'redirection' 
    ]; 
    
    protected $hidden = [
        'created_at',
        'updated_at',
     ];

    protected $casts = [
        'id' => 'integer'
    ];
}
