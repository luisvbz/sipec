<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use sipec\Sede;
use sipec\SeccionesTalleres;
use sipec\Entorno;
use sipec\Curriculo;
use sipec\Periodo;
use sipec\Participante;
use sipec\NotaTalleres;
use Input;

class CursosyTalleresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($abrev_sede)
    {
        $sede = Sede::where('abrev', $abrev_sede)->get();

        $profesores = \DB::Select("SELECT a.id, a.numero_identificacion, a.apellidos, a.nombres
                                      FROM principal.datos_basicos a
                                    INNER JOIN principal.facilitadores_ubicacion b ON a.id = b.id_facilitador
                                    ORDER BY a.apellidos");

        return view('talleres.index', compact('sede', 'profesores'));
    }

    public function cargaTalleres(Request $request){

        if ($request->ajax()) {
                
                $secciones = SeccionesTalleres::with('materia', 'profesor')
                                    ->where('abrev_sede', Input::get('abrev'))
                                    ->where('id_periodo', Input::get('anio'))
                                    ->where('anulado', FALSE)
                                    ->orderBy('id', 'DESC')->get();

                return response()->json($secciones);

        }else{

            return abort(403);
        }
    }

    public function cargarCurtall(Request $request){

         if ($request->ajax()) {
                
                 $modulos = Curriculo::where('posicion', 1)
                            ->where('abrev_proy', Input::get('tipo'))
                            ->orderBy('sem', 'ASC')->get();

                return response()->json($modulos);

        }else{

            return abort(403);
        }

    }

    public function guardarSeccion(Request $request){

         if ($request->ajax()) {
                
                $anio = $request->input('anio');
               //return $anio;

                $periodo = Periodo::where('id',$anio)->get(array('id', 'nom_periodo'));

                $curso = Curriculo::find(Input::get('curtall'));

                $seccion = new SeccionesTalleres;
                $seccion->id_periodo =  $periodo[0]->id;
                $seccion->ligaseccion =  $periodo[0]->nom_periodo.'/'.$curso->abrev_proy.'-'.Input::get('sede').'/'.$curso->pensum.'/'.$curso->codigo.'/'.Input::get('codigo');
                $seccion->abrev_proy =  $curso->abrev_proy;
                $seccion->abrev_sede =  Input::get('sede');
                $seccion->id_materia =  $curso->id;
                $seccion->seccion = Input::get('codigo');
                $seccion->id_profesor = Input::get('profesor');
                $seccion->max_cupo = Input::get('cantidad');
                $seccion->usr_creador = \Auth::user()->user;
                $seccion->feccre = date('Y-m-d H:m:s');
                $seccion->verificada = FALSE;
                $seccion->status = 1;
                $seccion->save(); 

                $s = SeccionesTalleres::with('materia', 'profesor')->where('id', $seccion->id)->get();

                return response()->json($s);

        }else{

            return abort(403);
        }

    }

    public function guardarCurtall(Request $request){

        if ($request->ajax()) {

                $padre = Input::get('padre');

                $hijos = Input::get('hijos');

                $getCodigo = Curriculo::where('abrev_proy', $padre['tipo'])->orderBy('codigo', 'DESC')->first();

                if(count($getCodigo) == 0){
                        
                    $codigo = $padre['tipo'].'00100';

                    $sem = 1;


                }else{
                    $abrev = substr($getCodigo->codigo, 0,1);
                    $cod = substr($getCodigo->codigo, 1,3);
                    $cod = $cod + 1;
                    $sem = $getCodigo->sem +1;

                    if(strlen($cod) == 1){

                        $cod = '00'.$cod.'00';

                    }elseif(strlen($cod) == 2){
                        
                        $cod = '0'.$cod.'00';

                    }
                        $codigo = $abrev.$cod;
                }

                //Inserta el Taller padre 

                $cur = new Curriculo;
                $cur->abrev_proy = $padre['tipo'];
                $cur->pensum = 1;
                $cur->sem = $sem;
                $cur->posicion = 1;
                $cur->codigo = $codigo;
                $cur->unidad_curricular = $padre['titulo'];
                $cur->uc = $padre['uc'];
                $cur->hs = $padre['hs'];
                $cur->ht = 0;
                $cur->hp = 0;
                $cur->save();

                //Comenzar a guardar los hijos del taller o curso padre como modulos

                 for ($i=0; $i < count($hijos); $i++) { 

                  $sum = $i + 1;

                  $getCodigo = Curriculo::where('abrev_proy', $padre['tipo'])->orderBy('codigo', 'DESC')->first();
                  $getPosicion = Curriculo::find($cur->id);

                if(count($getCodigo) == 0){
                        
                    $codigo = $padre['tipo'].'000';


                }else{
                    $abrev = substr($getCodigo->codigo, 0,4);
                    $cod = substr($getCodigo->codigo, 5,6);
                    $cod = $cod + 1;

                    if(strlen($cod) == 1){

                        $codigo = $abrev.'0'.$cod;

                    }elseif(strlen($cod) == 2){
                        
                        $codigo = $abrev.$cod;

                    }
                }
                    
                   $pos = 2;

                    $curhijos = new Curriculo;
                    $curhijos->abrev_proy = $padre['tipo'];
                    $curhijos->pensum = 1;
                    $curhijos->sem = $sem;
                    $curhijos->posicion = ($sum+1);
                    $curhijos->codigo = $codigo;
                    $curhijos->unidad_curricular = $hijos[$i]['titulo'];
                    $curhijos->uc = $hijos[$i]['uc'];
                    $curhijos->hs = $hijos[$i]['hs'];
                    $curhijos->ht = 0;
                    $curhijos->hp = 0;
                    $curhijos->save();
                }

                return "Ok";




        }else{

            return abort(403);
        }
    }

    public function cargarSelectCurtall(Request $request){

        if ($request->ajax()) {

            $sede = Sede::where('abrev', Input::get('abrev'))->get();

            $curtall = Entorno::with('proyecto')->where('id_proy', 29)->orWhere('id_proy', 30)->where('id_sede', $sede[0]->id)->get();

                return response()->json($curtall);

        }else{

            return abort(403);
        }
    }


    // Funciones para los participantes

    public function cargarParticipantes(Request $request){

        if ($request->ajax()) {

           $participantes = NotaTalleres::join('principal.datos_basicos as p', 'p.id', '=', 'historico_secon.notas_talleres.id_participante')
                                ->where('id_seccion', Input::get('id_seccion'))
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();

            return response()->json($participantes);

        }else{

            return abort(403);
        }

    }

    public function buscarParticipante(Request $request){

        if($request->ajax()){

            $participante = Participante::where('numero_identificacion', Input::get("cedula"))->get();

            $verificarInscrito = NotaTalleres::where('id_participante', $participante[0]->id)->where('id_seccion', Input::get("id_seccion"))->get();

            if(count($verificarInscrito) == 0){

             return response()->json(array($participante, array('inscrito' => 0)));

          }else{

              return response()->json(array($participante, array('inscrito' => 1)));
          }

        }else{


        }        

    }

    public function registrarParticipante(Request $request){

            if ($request->ajax()) {

                $seccion = SeccionesTalleres::find(Input::get('id_seccion'));
                $participante = Participante::find(Input::get('id_part'));

                $newNota = new NotaTalleres;
                $newNota->id_participante = $participante->id;
                $newNota->id_seccion = $seccion->id;
                $newNota->ligaseccion = $seccion->ligaseccion.'/'.$participante->numero_identificacion;
                $newNota->inscrito = TRUE;
                $newNota->usr_creador = \Auth::user()->cedula;
                $newNota->save();

                $nuevoRegistrado = NotaTalleres::join('principal.datos_basicos as p', 'p.id', '=', 'historico_secon.notas_talleres.id_participante')
                                ->where('ligaseccion', $newNota->ligaseccion)
                                ->orderBy('p.apellidos', 'ASC')
                                ->get();

                return response()->json($nuevoRegistrado);

            }
    }

    public function marcarAsistencia(Request $request){

        if($request->ajax()){

                    $asistencia = \DB::update("UPDATE historico_secon.notas_talleres 
                                     SET asistencia = ? where id_seccion = ? 
                                     AND id_participante = ?", array(Input::get('asistencia'),Input::get('id_seccion'), Input::get('id_part')));

            return 'ok';
        }
    }

    public function marcarAprobado(Request $request){

        if($request->ajax()){

                    $aprobado = \DB::update("UPDATE historico_secon.notas_talleres 
                                     SET aprobado = ? where id_seccion = ? 
                                     AND id_participante = ?", array(Input::get('aprobado'),Input::get('id_seccion'), Input::get('id_part')));

            return 'ok';
        }
    }

    public function marcarSolvente(Request $request){

        if($request->ajax()){

                    $solvencia = \DB::update("UPDATE historico_secon.notas_talleres 
                                     SET solvente = ? where id_seccion = ? 
                                     AND id_participante = ?", array(Input::get('solvente'),Input::get('id_seccion'), Input::get('id_part')));

            return 'ok';
        }
    }

   
}
