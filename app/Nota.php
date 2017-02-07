<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'historico_secon.notas';

	public $timestamps = FALSE;

	public function participante(){

		return $this->hasOne('sipec\Participante','id','id_participante')->orderBy('apellidos', 'ASC');
	}

	public function seccion(){

		return $this->hasOne('sipec\Secciones','id','id_seccion');
	}
}
