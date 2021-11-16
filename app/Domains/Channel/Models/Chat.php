<?php

namespace App\Domains\Channel\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Chat extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'content',
        'member_id',
        'channel_id',
    ];

    protected $table = 'channel_chat';

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
