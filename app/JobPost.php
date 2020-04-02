<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use SoftDeletes;

    // public function industry() 
    // {
    //     return $this->hasOne('App\Industry');
    // }
}

