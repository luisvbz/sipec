<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Entorno extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'valores.entorno1';


	public function sede(){

		return $this->hasOne('sipec\Sede', 'id_sede', 'id');
	}

	public function proyecto(){

		return $this->hasOne('sipec\Proyecto', 'id', 'id_proy');
	}
}
