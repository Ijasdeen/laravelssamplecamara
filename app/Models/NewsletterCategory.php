<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterCategory extends Model
{
    use HasFactory;

    protected $table = 'newsletter_category';

    protected $fillable = [
        'name', 
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
