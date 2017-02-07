<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'valores.entorno1';

	public function sede(){

		return $this->hasOne('sipec\Sede', 'id', 'id_sede');
	}

	public function proyecto(){

		return $this->hasOne('sipec\Proyecto', 'id', 'id_proy');
	}
}
