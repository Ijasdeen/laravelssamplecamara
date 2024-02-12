<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletter';

    protected $fillable = [
        'cat_id',
        'title',
        'description',
        'image',
        'n_file',
        'created_at',
        'status'
    ];

    protected $hidden = [ 
        'updated_at',
        'status'
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
