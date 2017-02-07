<?php

namespace sipec\Helpers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use Auth;
use Input;
use sipec\Modulo;
use sipec\UserModulo;

class Permiso {

	public static function Imprimir($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['imprimir'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Buscar($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['buscar'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Incluir($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['incluir'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Eliminar($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['eliminar'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Modificar($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['modificar'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Anular($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['anular'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

    public static function Procesar($m){

			$modulo = Modulo::where('abrev', $m)->get();

			foreach ($modulo as $modulo) {

			$modulo_user = UserModulo::where('user_id', Auth::user()->id)->where('modulo_id', $modulo->id)->get();

            	
	            if($modulo->abrev == $m AND $modulo_user[0]['procesar'] == TRUE){

	                return TRUE;

	            }else{

	                return FALSE;

	            }
			}

			
    }

} 