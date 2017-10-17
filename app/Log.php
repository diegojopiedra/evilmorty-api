<?php

namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Log extends Eloquent
{
    public function device()
    {
     return $this->belongsTo('App\Device');
    }
}
