<?php

namespace App\Domains\User\Models;

use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Chat;
use App\Domains\Channel\Models\Member;
use App\Domains\Matching\Models\Matching;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


//    protected $with = ['getFriendsAttribute'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = ['name', 'email', 'password', 'gender'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    protected $appends = ['profile_photo_url'];

    public function isMan()
    {
//       man = true , woman = false
        return $this?->gender;
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channel_member', 'member_id', 'channel_id');
    }

//    public function members()
//    {
//        return $this->hasMany(Member::class);
//    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    //남자 검색
    public function matchingMen()
    {
        return $this->hasMany(Matching::class, 'man_id', 'id');
    }
    //여자 검색
    public function matchingWomen()
    {
        return $this->hasMany(Matching::class, 'woman_id', 'id');
    }

    // Get list of who sent me a friend request
    public function myFriends()
    {
        return $this->belongsToMany(
            self::class,
            'friends',
            'user_id',
            'friend_id'
        )->withTimestamps();
    }

    public function friendsOf()
    {
        return $this->belongsToMany(
            self::class,
            'friends',
            'friend_id',
            'user_id'
        )->withTimestamps();
    }

    // Merge
    public function getFriendsAttribute()
    {
        return $this->myFriends->merge($this->friendsOf);
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }
}
