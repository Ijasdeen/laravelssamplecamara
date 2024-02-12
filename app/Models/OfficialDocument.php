<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialDocument extends Model
{
    use HasFactory;

    protected $table = 'official_document';

    protected $fillable = [
        'title',
        'description', 
        'document' ,
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
