<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';
    protected $hidden = [
        'updated_at', 'created_at',
    ];
}
