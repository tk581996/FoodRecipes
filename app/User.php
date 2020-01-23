<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "user";
    protected $primaryKey = "user_id";
    
    /* @var array
    protected $fillable = [
        'name', 'email', 'password',
    ];

    var array

    protected $hidden = [
        'password', 'remember_token',
    ];

    @var array
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */
}
