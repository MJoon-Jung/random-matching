<?php

namespace App\Domains\Channel\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'channel_id',
    ];

    protected $table = 'channel_member';

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
