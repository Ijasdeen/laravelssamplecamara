<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactEmail extends Model
{
    use HasFactory;

    protected $table = 'contact_email';

    protected $fillable = [
        'email' 
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
       
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
