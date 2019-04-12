<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groupmember extends Model
{
    protected $table = 'groupmember';
    protected $fillable = ['group_id','user_id'];
}
