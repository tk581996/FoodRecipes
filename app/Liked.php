<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liked extends Model
{
    protected $table = "liked";
    protected $primaryKey = "liked_id";
    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
