<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use sipec\Participante;
use sipec\Secciones;
use sipec\Entorno;
use sipec\Sede;
use sipec\Periodo;
use sipec\Nota;
use sipec\Ubicacionp;
use sipec\Curriculo;
use sipec\Constancia;
use sipec\Proyecto;
use sipec\Cne;
use sipec\Cne2;
use N2L;
use Permiso;
use Auth;
use Input;


class AdministracionController extends Controller
{

    public function getAllParticipantes(Request $request)
    {
        $participantes = Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.apellidos',  'p.numero_identificacion', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.nacionalidad', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->orderBy('p.apellidos')
                        ->paginate(10);
        $sedes = array();
        foreach (Auth::user()->sedes as $s) {
            array_push($sedes, $s->id);
        }

        $sedes = Sede::whereIn('id', $sedes)->get();

        if($request->ajax()){

            return response()->json($participantes);
        }
        return view('admparticipantes.index', compact('sedes'));        
    }

    public function buscarParticipante(Request $request){

        $cedula = $request->input('cedula');
        $apellidos = $request->input('apellidos');
        $nombres = $request->input('nombres');

        if($cedula == ""):
            $cedula = null;
        endif;

        if($apellidos == ""):
            $apellidos = null;
        endif;

        if($nombres == ""):
            $nombres = null;
        endif;

        if($cedula == null && $apellidos == null && $nombres == null){

            $participantes =  Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->orderBy('p.apellidos')
                        ->paginate(10);
                       // return $cedula;
        }else if($cedula =! null && $apellidos == null && $nombres == null){

            $participantes =  Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono','p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->where('p.numero_identificacion', $request->input('cedula'))
                        ->orderBy('p.apellidos')
                        ->paginate(10);

        }else if($cedula == null && $apellidos =! null && $nombres == null){
            //return '%'.$request->input('apellidos').'%';
            $participantes =  Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->where('p.apellidos', 'ilike','%'.$request->input('apellidos').'%')
                        ->orderBy('p.apellidos')
                        ->paginate(10);

        }else if($cedula == null && $apellidos == null && $nombres =! null){
            //return '%'.$request->input('apellidos').'%';
            $participantes =  Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->where('p.nombres', 'ilike','%'.$request->input('nombres').'%')
                        ->orderBy('p.apellidos')
                        ->paginate(10);
        }else if($cedula == null && $apellidos =! null && $nombres =! null){
            //return '%'.$request->input('apellidos').'%';
            $participantes =  Ubicacionp::select('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->join('principal.datos_basicos as p', 'p.id', '=', 'principal.participantes_ubicacion.id_participante')
                        ->groupBy('id_participante', 'p.numero_identificacion','p.nacionalidad', 'p.apellidos', 'p.nombres', 'p.edo_civil', 'p.sexo', 'p.correo', 'p.telefono', 'p.fecha_nacimiento')
                        ->where('id_ubicacion','>',200)
                        ->where('p.nombres', 'ilike','%'.$request->input('nombres').'%')
                        ->where('p.apellidos', 'ilike','%'.$request->input('apellidos').'%')
                        ->orderBy('p.apellidos')
                        ->paginate(10);
        }


        return response()->json($participantes);
    }

    public function buscarCne(Request $request){

        $datos = Cne2::buscar('V', $request->input('cedula'));

        return response()->json($datos);
    }

    public function updateDatosBasicos(Request $request){//Actualizar los datos basicos de participantes

            $data = $request->input('data');

            $part = Participante::find($data['id']);
            $part->nacionalidad = $data['nac'];
            $part->apellidos = $data['apellidos'];
            $part->nombres = $data['nombres'];
            $part->sexo = $data['sexo'];
            $part->fecha_nacimiento = $data['fecnac'];
            $part->correo = $data['correo'];
            $part->telefono = $data['cod'].'-'.$data['tlf'];
            $part->edo_civil = $data['edo_civil'];
            $psave = $part->save();

            if($psave){
                return response()->json(array('save' => true, 'part' => $part, 'index' => $data['index']));
            }else{
                return abort(500);
            }
            
    }

    public function guardarParticipante(Request $request){//Guardar un nuevo participante

        $data = $request->input('data');
        $datosBasicos = $data['datos_personales'];
        $datos_ubicacion = $data['datos_ubicacion'];

        //Guardando datos del participante

        $participante = new Participante;
        $participante->tipo_identificacion = 'C';
        $participante->nacionalidad = $datosBasicos['nac'];
        $participante->numero_identificacion = $datosBasicos['cedula'];
        $participante->apellidos = $datosBasicos['apellidos'];
        $participante->nombres = $datosBasicos['nombres'];
        $participante->sexo = $datosBasicos['sexo'];
        if($datosBasicos['fecnac'] != 0){
             $participante->fecha_nacimiento = $datosBasicos['fecnac'];
        }
        $participante->correo = $datosBasicos['correo'];
        $participante->edo_civil = $datosBasicos['edo_civil'];
        $participante->telefono = $datosBasicos['tlf'];
        $p = $participante->save();

        //Guardando la ubicacion del participante

        $id_ubicacion = Entorno::where('liga_proyectosede', $datos_ubicacion['programa'].'-'.$datos_ubicacion['sede'])->get();

        $ubicacion = new Ubicacionp;
        $ubicacion->id_participante = $participante->id;
        $ubicacion->id_ubicacion = $id_ubicacion[0]->id;
        $ubicacion->pensum = $datos_ubicacion['pensum'];
        $ubicacion->per_ing = $datos_ubicacion['periodo'];
        $ubicacion->liga = $participante->numero_identificacion.'/'.$id_ubicacion[0]->liga_proyectosede.'/'.$datos_ubicacion['pensum'];
        $u = $ubicacion->save();

        if($p == true && $u == true){

            return response()->json(array('save' => true, 'participante' => $participante));
        }else{

            return abort(500);
        }

    }

    public function guardarParticipanteUbicacion(Request $request){

        $data = $request->input('data');
         $datosBasicos = $data['datos_personales'];
        $datos_ubicacion = $data['datos_ubicacion'];

        $participante = Participante::where('numero_identificacion', $datosBasicos['cedula'])->get();

        $id_ubicacion = Entorno::where('liga_proyectosede', $datos_ubicacion['programa'].'-'.$datos_ubicacion['sede'])->get();

        $ubicacion = new Ubicacionp;
        $ubicacion->id_participante = $participante[0]->id;
        $ubicacion->id_ubicacion = $id_ubicacion[0]->id;
        $ubicacion->pensum = $datos_ubicacion['pensum'];
        $ubicacion->per_ing = $datos_ubicacion['periodo'];
        $ubicacion->liga = $participante[0]->numero_identificacion.'/'.$id_ubicacion[0]->liga_proyectosede.'/'.$datos_ubicacion['pensum'];
        $u = $ubicacion->save();

         if($u == true){

            return response()->json(array('save' => true, 'participante' => $participante[0]));
        }else{

            return abort(500);
        }

    }

    public function cargarUbiPart(Request $request){

            $cedula = $request->input('cedula');
            $participante = Participante::with('ubicacion')->where('numero_identificacion', $cedula)->get();
            $programas = array();

           foreach ($participante[0]->ubicaciones as $u) {
                 array_push($programas, array('abrev_proyec' => $u->proyecto->abrev,
                                              'proy' => $u->proyecto->denominacion,
                                              'sede' => $u->sede->denominacion,
                                              'periodo' => $u->pivot->per_ing));
           }

           return response()->json($programas);
    }

    public function programas($abrev_proyec, $abrev_sede){

		$total = Secciones::where('anulado', FALSE)->count();

		$sedes = Auth::user()->sedes;

        $profesores = \DB::Select("SELECT a.id, a.numero_identificacion, a.apellidos, a.nombres
                                      FROM principal.datos_basicos a
                                    INNER JOIN principal.facilitadores_ubicacion b ON a.id = b.id_facilitador
                                    ORDER BY a.apellidos");

		if(Auth::user()->hasRole('SA') OR Auth::user()->hasRole('Admin')){

			$periodos = Periodo::orderBy('nom_periodo', 'DESC')->get();

		}else{

			$periodos = Auth::user()->periodos;
		}

        $sede = Sede::where('abrev', $abrev_sede)->get();
        $proy = Proyecto::where('abrev', $abrev_proyec)->get();


		return view('administracion.programas', compact('sedes', 'periodos', 'profesores', 'proy', 'sede'));    	
    }

    //carga los proyectos en el select del menu programas

    public function cargarProyectos(){

    	$proyectos = Auth::user()->proyectos;

    	$sede = Sede::where('abrev',  Input::get('id_sede'))->get();

    	$arraySede = array();

    	foreach ($sede as $s) {
    		array_push($arraySede, $s->id);
    	}

    	$parray = array();

    	foreach ($proyectos as $p) {
    		
    		$programas = Entorno::where('id_sede', $arraySede[0])->where('id_proy', $p->id)->get();

    		foreach ($programas as $p) {
    			array_push($parray, array($p->proyecto->abrev, $p->proyecto->denominacion));
    		}
			
    	}

    	return response()->json($parray);
    }

    public function cargarSecciones(){

        	$secciones = Secciones::with('materia')->where('abrev_sede', Input::get('sede'))
        							->where('abrev_proy', Input::get('programa'))
        							->where('id_periodo', Input::get('periodo'))
                                    ->where('anulado', FALSE)
                                    ->orderBy('id', 'DESC')->get();

    	$arraySecciones = array();

    	$cantidades = array();

    	foreach ($secciones as $s) {



    		$cantidaP = \DB::select(\DB::raw('SELECT historico_secon.contar_cupo(?)'), array($s->id));
    		$cantidaPNotas = \DB::select(\DB::raw('SELECT historico_secon.contar_cupo_condef(?) as cant'), array($s->id));
    		
    		array_push($arraySecciones, array( 
    									$s->materia->pensum,
    									$s->materia->sem,
    									$s->materia->codigo,
										$s->abrev_sede,
										$s->materia->unidad_curricular,
										$s->seccion,
										$s->profesor->nombres.' '.$s->profesor->apellidos,
										$s->id,
										$cantidaPNotas[0],
										$cantidaP[0],
                                        $s->materia->id));
    	}

    	return response()->json($arraySecciones);
    }

    //Funcion que carga los participantes de un grupo especifico

    public function cargarParticipantes(){

    	//$participantes = Nota::with('participante')->where('id_seccion', Input::get('id_seccion'))->get();

        $participantes = Nota::join('principal.datos_basicos as p', 'p.id', '=', 'historico_secon.notas.id_participante')
                                ->where('id_seccion', Input::get('id_seccion'))
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();

    	$arrayPar = array();

    	$n= 1;

        $seccion = Secciones::find(Input::get('id_seccion'));

    	foreach ($participantes as $p) {
    		
    		array_push($arrayPar, array($n++,
                                        number_format($p->participante->numero_identificacion, 0,",", "."), 
                                        $p->participante->apellidos.' '.$p->participante->nombres, 
                                        $p->participante->ubicacion->per_ing,
                                        $p->def,
                                        $p->id_participante,
                                        $p->id_seccion,
                                        $p->id));

    	}

        $secciones = Secciones::select('historico_secon.secciones.id','c.posicion','c.codigo', 'c.unidad_curricular', 'historico_secon.secciones.seccion')
                                ->join('historico_secon.curriculo as c', 'c.id','=', 'historico_secon.secciones.id_materia' )
                                ->where('historico_secon.secciones.abrev_proy', $seccion['abrev_proy'])
                                ->where('historico_secon.secciones.abrev_sede', $seccion['abrev_sede'])
                                ->where('historico_secon.secciones.id_periodo', $seccion['id_periodo'])
                                ->where('historico_secon.secciones.id', '<>', Input::get('id_seccion'))
                                ->where('historico_secon.secciones.anulado', FALSE)
                                ->orderBy('c.posicion', 'ASC')
                                ->get();
                                
        $arraySecciones = array();

        foreach ($secciones as $s) {
                array_push($arraySecciones, array($s->id,
                                                  $s->posicion,
                                                  $s->codigo,
                                                  $s->unidad_curricular,
                                                  $s->seccion));
        }
        

    	return response()->json(array($arrayPar, $arraySecciones));
    }

    public function copiarParticipantes(){
            
        $part = Input::get('chkpart');

        $seccion = Secciones::find(Input::get('id_seccion'));



       for ($i=0; $i < count($part) ; $i++) { 
            
            $d = Participante::find($part[$i]['value']);
            $ligaseccion = Input::get('liga').'/'.$seccion['seccion'].'/'.$d['numero_identificacion'];

            //verificar si el participante esta registado en la misma seccion

            $verificar = Nota::where('ligaseccion', $ligaseccion)->get();

            if(count($verificar) > 0){
                //No regitrarlo
            }else{

                $newPartNotas = new Nota;
                $newPartNotas->id_participante = $part[$i]['value'];
                $newPartNotas->id_seccion = Input::get('id_seccion');
                $newPartNotas->ligaseccion = $ligaseccion;
                $newPartNotas->save();

            }

            //return response()->json($seccion);

       }

       $cantidad = Nota::where('id_seccion', Input::get('id_seccion'))->count();

        return response()->json($cantidad);

      
        
    }

    public function cargarNota(){

        $nota = Nota::with('participante')->where('id_participante', Input::get('idpart'))->where('id_seccion', Input::get('idsec'))->get();

      \DB::table('historico_secon.notas')->where('id_participante', Input::get('idpart'))
                                        ->where('id_seccion', Input::get('idsec'))
                                        ->update(array('def' => Input::get('valor')));

        return $nota;
    }

    //Carga de ajax para mostrar el nombre del participante

    public function ajaxParticipante(){

        $liga = Input::get('cedula').'%'.Input::get('programa');

        $ligaseccion = Input::get('periodo').'%'.Input::get('cedula');

        $datosbasicos = Participante::where('numero_identificacion', Input::get('cedula'))->get();

       // return $liga;

        if(count($datosbasicos) == 0){

            //$cne = Cne::where('cedula', Input::get('cedula'))->get();

            $cne = Cne2::buscar('V',  Input::get('cedula'));

           // return $cne;

            $datos = array('tipo' => 1,
                           'mensaje' => 'EL participante no esta registrado!',
                           'datos' => $cne);

            return response()->json($datos);

        }else{

            $ubicacion = Ubicacionp::where('liga','ilike', '%'.$liga.'%')->get();

            if(count($ubicacion) == 0){

                $datos = array('tipo' => 2,
                               'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos'].' '.'Esta regsitrado(a) pero no tiene ubicación, debe registrar la ubicacion');

            return response()->json($datos);

            }else{

                $materia = Input::get('materia');
                $id = $datosbasicos[0]['id'];
                $verficarListaNotas = Nota::where('id_seccion', Input::get('seccion'))->where('id_participante', $datosbasicos[0]['id'])->get();

                $verficarMateria =   \DB::select("SELECT * FROM (SELECT b.id_materia, a.ligaseccion FROM historico_secon.notas a 
                                                    INNER JOIN historico_secon.secciones b ON a.id_seccion = b.id
                                                    WHERE a.id_participante = ? 
                                                    and a.ligaseccion like  ?) as secciones
                                                    WHERE id_materia = ?", array($datosbasicos[0]['id'], $ligaseccion, Input::get('materia')));
                $sql = "SELECT * FROM (SELECT b.id_materia, a.ligaseccion FROM historico_secon.notas a 
                                                    INNER JOIN historico_secon.secciones b ON a.id_seccion = b.id
                                                    WHERE a.id_participante = $id 
                                                    and a.ligaseccion like   $ligaseccion) as secciones
                                                    WHERE id_materia = $materia";
                //return $sql;

                if(count($verficarListaNotas) == 0 OR count($verficarMateria) == 0){
                    $datos = array('tipo' => 3,
                          'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']);
                }else {
                    $datos = array('tipo' => 4,
                          'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']. ' ya esta registrado(a) en esta sección o en la misma materia');
                }
                

                return response()->json($datos);
            }
        }
    }

//Funcion para agregar un nuevo particiapnte en la seccion seleccionada

     public function GuardarParticipanteSeccion(){


        $liga = Input::get('cedula').'%'.Input::get('programa');

         $ligaseccion = Input::get('periodo').'%'.Input::get('cedula');

         //return $ligaseccion;

        $datosbasicos = Participante::where('numero_identificacion', Input::get('cedula'))->get();

        if(count($datosbasicos) == 0){

            $datos = array('tipo' => 1,
                          'mensaje' => 'EL participante no esta registrado, haga click aqui para registrarlo');

            return response()->json($datos);

        }else{

            $ubicacion = Ubicacionp::where('liga','ilike', '%'.$liga.'%')->get();

            if(count($ubicacion) == 0){

               $datos = array('tipo' => 2,
                         'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos'].' '.'Esta regsitrada pero no tiene ubicación, debe registrar la ubicacion');

            return response()->json($datos);

            }else{


                $verficarListaNotas = Nota::where('id_seccion', Input::get('seccion'))->where('id_participante', $datosbasicos[0]['id'])->get();

                $verficarMateria =   \DB::select("SELECT * FROM (SELECT b.id_materia, a.ligaseccion FROM historico_secon.notas a 
                                                    INNER JOIN historico_secon.secciones b ON a.id_seccion = b.id
                                                    WHERE a.id_participante = ? 
                                                    and a.ligaseccion like  ?) as secciones
                                                    WHERE id_materia = ?", array($datosbasicos[0]['id'], $ligaseccion, Input::get('materia')));


                if(count($verficarListaNotas) == 0 OR count($verficarMateria) == 0){

                   $datos = array('tipo' => 3,
                          'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']);

                    $aggPart = new Nota;
                    $aggPart->id_participante = $datosbasicos[0]['id'];
                    $aggPart->id_seccion = Input::get('seccion');
                    $aggPart->ligaseccion = Input::get('ligaseccion');
                    $aggPart->usr_creador = Auth::user()->user;
                    $aggPart->feccre = date('Y-m-d h:m:s');
                    $aggPart->save();

                    $participantes = Nota::with('participante')->where('id', $aggPart->id)->get();

                 $arrayPar = array();

                     $n= 1;

                foreach ($participantes as $p) {
            
                     array_push($arrayPar, array($n++,
                                        $p->participante->numero_identificacion, 
                                        $p->participante->apellidos.' '.$p->participante->nombres, 
                                        $p->participante->ubicacion->per_ing,
                                        $p->def,
                                        $p->id_participante,
                                        $p->id_seccion,
                                        $p->id));

        }

                    $datos = array('part' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']);


                }else {

                    $datos = array('tipo' => 4,
                          'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']. ' ya esta registrado(a) en esta sección o en la misma materia');
                }
                

                return response()->json($arrayPar);
            }
        }


}

    public  function quitarParticipante(){

    $eliminar = \DB::delete("DELETE FROM historico_secon.notas WHERE id_participante = ? AND id_seccion = ?", array(Input::get("id_part"),Input::get("seccion")));

     //$part = Nota::find(Input::get("id_part"));
       // $part->delete();
    }


    /** Reportes del modulo de administracion **/

    public function listadoParticipantes(Request $request){

        //$participantes = Nota::with('participante')->where('id_seccion', Input::get('id_seccion'))->get();

        $participantes = Nota::join('principal.datos_basicos as p', 'p.id', '=', 'historico_secon.notas.id_participante')
                                //->leftjoin('principal.datos_personales as d', 'd.id_persona', '=', 'historico_secon.notas.id_participante')
                                ->where('id_seccion', Input::get('id_seccion'))
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();
        //return $participantes;


        $arrayPar = array();


        $n= 1;

        foreach ($participantes as $p) {
            
            array_push($arrayPar, array($n++,
                                        number_format($p->participante->numero_identificacion, 0,",", "."), 
                                        $p->participante->apellidos.' '.$p->participante->nombres, 
                                        $p->participante->correo,
                                        'N/T',
                                        $p->participante->ubicacion->per_ing,
                                        $p->def,
                                        $p->id_participante,
                                        $p->id_seccion,
                                        $p->id));

        }

      $secciones = Secciones::with('profesor', 'materia', 'sede', 'proyecto', 'periodo')
                        ->where('id', Input::get('id_seccion'))
                        ->where('anulado', FALSE)
                        ->get();

                 $arraySecciones = array();
                foreach ($secciones as $s) {
                array_push($arraySecciones, array( 
                                        $s->materia->pensum,
                                        $s->materia->sem,
                                        $s->materia->codigo,
                                        $s->sede->denominacion,
                                        $s->materia->unidad_curricular,
                                        $s->seccion,
                                        $s->profesor->nombres.' '.$s->profesor->apellidos,
                                        $s->proyecto->denominacion,
                                        $s->periodo->nom_periodo,
                                        $s->materia->uc,
                                        $s->materia->hs
                                        ));
            }

        if ($request->ajax()) {
            return response()->json(array($arrayPar, $arraySecciones));
        }else{

            $pdf = \PDF::loadView('administracion.reportes.listadoParticipantes', compact('arrayPar','arraySecciones'));
            return $pdf->stream();
        }
        

        
    }

    public function notasDefParticipantes(Request $request){

        $participantes = Nota::join('principal.datos_basicos as p', 'p.id', '=', 'historico_secon.notas.id_participante')
                                ->where('id_seccion', Input::get('id_seccion'))
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();


        $arrayPar = array();


        $n= 1;

        foreach ($participantes as $p) {
            
            $apellido = explode(" ", $p->participante->apellidos);

            $nombre = explode(" ", $p->participante->nombres);

            $nota = $p->def;

            

            if($nota == NULL OR $nota == 0){

                $nota = "S/I";

                $letras = "SIN INFORMACIÓN";

            }else{

                $letras = N2L::num2letras($p->def);
            }

            array_push($arrayPar, array($n++,
                                        number_format($p->participante->numero_identificacion, 0,",", "."), 
                                        $apellido[0].', '.$nombre[0], 
                                        $p->participante->ubicacion->per_ing,
                                        $p->def,
                                        $p->id_participante,
                                        $p->id_seccion,
                                        $p->id, 
                                        $nota, strtoupper($letras)));

        }

      $secciones = Secciones::with('profesor', 'materia', 'sede', 'proyecto', 'periodo')
                                ->where('anulado', FALSE)
                                ->where('id', Input::get('id_seccion'))->get();

                 $encabezado = array();
                foreach ($secciones as $s) {
                    $nombreP = explode(" ",  $s->profesor->nombres);
                    $apellidoP = explode(" ",  $s->profesor->apellidos);
                array_push($encabezado, array( 
                                        $s->materia->pensum,
                                        $s->materia->sem,
                                        $s->materia->codigo,
                                        $s->sede->denominacion,
                                        $s->materia->unidad_curricular,
                                        $s->seccion,
                                        strtoupper($apellidoP[0]).', '.strtoupper($nombreP[0]),
                                        $s->proyecto->denominacion,
                                        $s->periodo->nom_periodo,
                                        $s->materia->uc,
                                        $s->materia->hs,
                                        number_format($s->profesor->numero_identificacion, 0,",", "."),
                                        $s->ligaseccion,
                                        $s->id_periodo,
                                        $s->id_materia,
                                        $s->id));
            }

        if ($request->ajax()) {

            return response()->json(array($arrayPar, $encabezado));

          }else{

            $constancia = New Constancia;
            $constancia->id_participante = 0;
            $constancia->id_periodo = $encabezado[0][13];
            $constancia->feccre = date("Y-m-d H:m:s");
            $constancia->impreso = FALSE;
            $constancia->anio = date("Y");
            $constancia->usr_creador = Auth::user()->user;
            $constancia->liga = $encabezado[0][12];
            $constancia->tipo = "PCD";
            $constancia->tipo = "PCD";
            $constancia->entregado = FALSE;
            $constancia->id_seccion = $encabezado[0][15];
            $constancia->save();

            $id_constancia = $constancia->id;

            $pdf = \PDF::loadView('administracion.reportes.notasDefinitivas', compact('arrayPar','encabezado', 'id_constancia'));

            //return view('administracion.reportes.notasDefinitivas', compact('arrayPar','encabezado'));

            return $pdf->stream();

            }

    }

    /** Funciones para agregar grupos **/

    public function cargarModulos(){

        $modulos = Curriculo::where('pensum', Input::get('pensum'))
                            ->where('abrev_proy', Input::get('programa'))
                            ->orderBy('sem', 'ASC')
                            ->orderBy('posicion', 'ASC')->get();

        $arrayModulos = array();

        foreach ($modulos as $m) {
            
            array_push($arrayModulos, array($m->id, $m->sem, $m->posicion, $m->abrev_proy, $m->unidad_curricular, $m->codigo));
        }
        return response()->json($arrayModulos);


    }

    public function guardarGrupo(Request $request){

        $modulos = explode("/", Input::get('modulo'));

        $codigo = $modulos[0];

        $modulo = $modulos[1];

        if ($request->ajax()) {

            $verificar = Secciones::where('abrev_proy', Input::get('programa'))
                                  ->where('abrev_sede', Input::get('sede'))
                                  ->where('id_materia', $modulo)
                                  ->where('seccion', Input::get('grupo'))
                                  ->where('anulado', FALSE)
                                  ->get();

            if(count($verificar) > 0){

                $datos = array('tipo' => 0);
                $seccion = array();

                return response()->json(array($datos, $seccion));

            }else{

                $grupo = new Secciones;
                $grupo->id_periodo =  Input::get('periodo');
                $grupo->ligaseccion =  Input::get('periodo_text').'/'.Input::get('programa').'-'.Input::get('sede').'/'.Input::get('pensum').'/'.$codigo.'/'.Input::get('grupo');
                $grupo->abrev_proy =  Input::get('programa');
                $grupo->abrev_sede =  Input::get('sede');
                $grupo->id_materia =  $modulo;
                $grupo->seccion = Input::get('grupo');
                $grupo->id_profesor = Input::get('facilitador');
                $grupo->max_cupo = Input::get('cantidad');
                $grupo->usr_creador = Auth::user()->user;
                $grupo->feccre = date('Y-m-d H:m:s');
                $grupo->verificada = FALSE;
                $grupo->save();

                $seccion = array($grupo->materia->pensum,
                                        $grupo->materia->sem,
                                        $grupo->materia->codigo,
                                        $grupo->abrev_sede,
                                        $grupo->materia->unidad_curricular,
                                        $grupo->seccion,
                                        $grupo->profesor->nombres.' '.$grupo->profesor->apellidos,
                                        $grupo->id,
                                        $grupo->materia->id);

                $datos = array('tipo' => 1);

                return response()->json(array($datos, $seccion));

            }
            

        }else{

            return abort(403);
        }
    }

    public function eliminarGrupo(){

        $seccion = \DB::update("UPDATE historico_secon.secciones SET anulado = TRUE where id = ?", array(Input::get('id_seccion')));

    }

}
