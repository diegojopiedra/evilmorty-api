<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Eloquent {
    protected $hidden = [
        'password', 'remember_token',
    ];
}
