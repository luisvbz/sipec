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
use N2L;
use Permiso;
use Auth;
use Input;


class AdministracionController extends Controller
{

    public function index()
    {
        $secciones = Secciones::all();

        return var_dump($secciones);

        
    }

    public function programas(){

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


		return view('administracion.programas', compact('sedes', 'periodos', 'profesores'));    	
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

        $datosbasicos = Participante::where('numero_identificacion', Input::get('cedula'))->get();

        if(count($datosbasicos) == 0){

           // $datos = array('tipo' => 1,
             //             'mensaje' => 'EL participante no esta registrado, haga click aqui para registrarlo');

            return response()->json($datos);

        }else{

            $ubicacion = Ubicacionp::where('liga','ilike', '%'.$liga.'%')->get();

            if(count($ubicacion) == 0){

               // $datos = array('tipo' => 2,
                 //         'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos'].' '.'Esta regsitrada pero no tiene ubicación, debe registrar la ubicacion');

            return response()->json($datos);

            }else{


                $verficarListaNotas = Nota::where('id_seccion', Input::get('seccion'))->where('id_participante', $datosbasicos[0]['id'])->get();

                $verficarMateria =   \DB::select("SELECT * FROM (SELECT b.id_materia, a.ligaseccion FROM historico_secon.notas a 
                                                    INNER JOIN historico_secon.secciones b ON a.id_seccion = b.id
                                                    WHERE a.id_participante = ? 
                                                    and a.ligaseccion like  ?) as secciones
                                                    WHERE id_materia = ?", array($datosbasicos[0]['id'], $ligaseccion, Input::get('materia')));


                if(count($verficarListaNotas) == 0 OR count($verficarMateria) == 0){

                   // $datos = array('tipo' => 3,
                     //     'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']);

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

                   // $datos = array('tipo' => 4,
                     //     'mensaje' => $datosbasicos[0]['nombres'].' '.$datosbasicos[0]['apellidos']. ' ya esta registrado(a) en esta sección o en la misma materia');
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
                                ->where('id_seccion', Input::get('id_seccion'))
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();


        $arrayPar = array();


        $n= 1;

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

            $pdf = \PDF::loadView('administracion.reportes.notasDefinitivas', compact('arrayPar','encabezado'));

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
