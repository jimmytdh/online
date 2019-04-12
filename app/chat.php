<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    protected $table = 'chat';
    protected $fillable = ['receiver_id','sender_id','convo','message'];
}
