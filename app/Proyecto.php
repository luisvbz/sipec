<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'valores.programas_proyectos1';

	function entorno()
    {
        return $this->hasOne('sipec\Entorno', 'id_sede', 'id');
    }

}
