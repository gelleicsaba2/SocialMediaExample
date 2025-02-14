<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationView extends Model
{
    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'relations_view';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'user_name',
        'friend_id',
        'friend_name',
        'accepted'
    ];

    public $timestamps = false;
}