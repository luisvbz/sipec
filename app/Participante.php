<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'principal.datos_basicos';

	function datospersonales(){

		return $this->hasOne('sipec\DatosPersonales', 'id_persona', 'id');
	}

	function ubicaciones(){

		return $this->belongsToMany('sipec\Ubicacion', 'principal.participantes_ubicacion', 'id_participante', 'id_ubicacion')
									->withPivot('pensum', 'per_ing', 'estado', 'liga', 'id', 'id_periodo')->where('valores.entorno1.id', '>=', 200);
	}

	function ubicacion(){

		return $this->hasOne('sipec\Ubicacionp', 'id_participante','id' )->where('id_ubicacion', '>=', 200);
	}
}
