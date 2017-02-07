<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class UserModulo extends Model
{

    protected $table = 'modulo_user';

    protected $primaryKey = false;

    public $timestamps = false;
}
