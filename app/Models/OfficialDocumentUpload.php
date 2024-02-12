<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialDocumentUpload extends Model
{
    use HasFactory;

    protected $table = 'official_document_upload';
   
    protected $fillable = [
        'official_document_id',
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
