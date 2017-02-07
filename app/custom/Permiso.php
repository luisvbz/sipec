<?php

namespace sipec\custom;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use Auth;
use Input;

class Permiso {

	public function eliminar($id_usuario, $id_modulo){


		$p = \DB::select("SELECT eliminar FROM sipec_user.modulo_user WHERE user_id = ? AND modulo_id = ?", array($id_usuario, $id_modulo));

		if($p->eliminar == true){

			return true;

		}else{

			return false;
		}

	}

} 