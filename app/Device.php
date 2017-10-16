<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Device extends Eloquent
{
  protected $hidden = [
      'secretKey', 'mutantKey'
  ];

  public function alerts()
  {
   return $this->embedsMany('App\Alert');
  }

  public function log()
  {
   return $this->embedsMany('App\Log');
  }

  public function place()
  {
    return $this->belongsTo('App\Place');
  }
}
