<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $fillable = [
        'fname',
        'lname',
        'position',
        'contact',
        'email',
        'sex',
        'dob',
        'section',
        'address',
        'username',
        'password',
        'level',
        'status',
        'picture'
    ];
}
