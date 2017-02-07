<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class NotaTalleres extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'historico_secon.notas_talleres';

	public $timestamps = FALSE;

	public function participante(){

		return $this->hasOne('sipec\Participante','id','id_participante')->orderBy('apellidos', 'ASC');
	}

	public function seccion(){

		return $this->hasOne('sipec\SeccionesTalleres','id','id_seccion');
	}
}
