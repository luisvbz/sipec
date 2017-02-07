<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
   protected $connection = 'bdunermb';

	protected $table = 'historico_secon.secciones';

	public $timestamps = FALSE;

	public function profesor(){

		return $this->hasOne('sipec\Participante', 'id', 'id_profesor');
	}

	public function periodo(){

		return $this->hasOne('sipec\Periodo', 'id', 'id_periodo');
	}

	public function materia(){

		return $this->hasOne('sipec\Curriculo', 'id', 'id_materia');
	}

	public function sede(){

		return $this->hasOne('sipec\Sede', 'abrev', 'abrev_sede');
	}

	public function proyecto(){

		return $this->hasOne('sipec\Proyecto', 'abrev', 'abrev_proy');
	}
}
