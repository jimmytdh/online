<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $table = 'post';
    protected $fillable = ['user_id','photo','content'];
}
