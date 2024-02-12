<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDirectory extends Model
{
    use HasFactory;

    protected $table = 'member_directory';
   
    protected $fillable = [
        'company_name',
        'website',
        'image',
        'email',
        'contact_no',
        'poc_name',
        'sector',
        'description' 
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 
    ];

    protected $casts = [
        'id' => 'integer'
    ];
}
