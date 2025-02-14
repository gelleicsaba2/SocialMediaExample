<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Notification extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'friend_id',
        'message',
        'readen'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class);
    }
}