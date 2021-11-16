<?php

namespace App\Domains\Channel\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Channel extends Model
{
    use HasFactory;
    use Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'channel_member', 'channel_id', 'member_id');
    }
    public function member()
    {
        return $this->hasMany(User::class, 'channel_id', 'id');
    }
}
