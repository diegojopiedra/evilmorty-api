<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Alert extends Eloquent
{
  public function device()
  {
   return $this->belongsTo('App\Device');
  }
}
