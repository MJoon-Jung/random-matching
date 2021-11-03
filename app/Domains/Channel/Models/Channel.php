<?php

namespace App\Domains\Channel\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
//    public function members()
//    {
//        return $this->hasMany(Member::class);
//    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'channel_member', 'channel_id', 'member_id');
    }
}