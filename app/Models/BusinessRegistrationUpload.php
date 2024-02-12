<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRegistrationUpload extends Model
{
    use HasFactory;

    protected $table = 'business_registration_upload';
   
    protected $fillable = [  
        'business_registration_id',
        'user_id',
        'document', 
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
