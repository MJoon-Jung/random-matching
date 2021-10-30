<?php

namespace App\Domains\Friend\Models;

use Database\Factories\FriendFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    protected static function newFactory()
    {
        return new FriendFactory();
    }

}
