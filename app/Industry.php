<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;

    // public function job_post() 
    // {
    //     return $this->belongsTo('App\JobPost');
    // }
}
