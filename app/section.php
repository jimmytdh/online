<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $table = 'section';
    protected $fillable = ['div_id','section'];
}
