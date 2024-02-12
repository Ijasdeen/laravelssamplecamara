<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_address';

    protected $fillable = [
        'user_id',
        'address_type',
        'address',
        'additional_details',
        'latitude',
        'longitude',
        'created_at',
       ];
}
