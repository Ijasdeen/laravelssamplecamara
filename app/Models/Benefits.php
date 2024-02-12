<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefits extends Model
{
    use HasFactory;

    protected $table = 'benefits';

    protected $fillable = [
        'cat_id',
        'title', 
        'description',
        'start_date',
        'end_date',
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
