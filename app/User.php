<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent {
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function places()
   {
     return $this->embedsMany('App\Place');
   }
}
