<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'user_notification_setting';

    protected $fillable = [
        'user_id',
        'event',
        'calendar_event',
        'news_letter',
        'created_at',
       ];
}
