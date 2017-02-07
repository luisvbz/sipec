<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Ubicacionp extends Model
{
     protected $connection = 'bdunermb';

	protected $table = 'principal.participantes_ubicacion';

	public function entorno(){

		return $this->hasOne('sipec\Ubicacion', 'id', 'id_ubicacion');

	}
}
