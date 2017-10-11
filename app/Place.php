<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Place extends Eloquent
{
  public function devices()
  {
   return $this->embedsMany('App\Device');
  }
}
