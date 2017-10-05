<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent {
    protected $hidden = [
        'password', 'remember_token',
    ];
}
