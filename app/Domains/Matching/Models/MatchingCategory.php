<?php

namespace App\Domains\Matching\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchingCategory extends Model
{
    use HasFactory;

    protected $table = 'matching_category';

    public function matching()
    {
        return $this->hasMany(Matching::class);
    }
}
