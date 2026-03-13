<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'title',
        'poster_path',
        'vote_average',
        'release_year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
