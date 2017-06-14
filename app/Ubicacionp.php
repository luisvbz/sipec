<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Ubicacionp extends Model
{
     protected $connection = 'bdunermb';

	protected $table = 'principal.participantes_ubicacion';

	public $timestamps = FALSE;

	public function entorno(){

		return $this->hasOne('sipec\Ubicacion', 'id', 'id_ubicacion');

	}

	public function participante(){

		return $this->hasOne('sipec\Participante', 'id', 'id_participante');

	}

}
