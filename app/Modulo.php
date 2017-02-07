<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    function users()
    {
        return $this->belongsToMany('sipec\User', 'modulo_user', 'modulo_id', 'user_id');
    }
}
