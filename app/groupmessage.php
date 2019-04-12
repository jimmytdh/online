<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groupmessage extends Model
{
    protected $table = 'groupmessage';
    protected $fillable = ['group_id','sender_id','message'];
}
