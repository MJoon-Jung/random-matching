<?php

namespace App\Domains\Matching\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'man_id',
        'woman_id'
    ];

    protected $table = 'matchings';

    public function man()
    {
        return $this->belongsTo(User::class, 'man_id');
    }
    public function woman()
    {
        return $this->belongsTo(User::class, 'woman_id');
    }
}
