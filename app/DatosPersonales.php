<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class DatosPersonales extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'principal.datos_personales';
}
