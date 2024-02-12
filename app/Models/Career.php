<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'career';
   
    protected $fillable = [
        'cat_id',
        'title',
        'description',
        'career_date',
        'company_name',
        'pay_scale',
        'email' ,
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
