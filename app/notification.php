<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $table = 'notification';
    protected $fillable = [
        'sender_id',
        'content',
        'staus'
    ];
}
