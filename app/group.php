<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    protected $table = 'group';
    protected $fillable = ['name'];
}
