<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use Input;
use sipec\Participante;
use sipec\Secciones;
use sipec\Nota;
use sipec\NotaTalleres;
use sipec\Proyecto;
use Session;

class ParticipantesController extends Controller
{


     public function index()
    {
        return view('participantes.index');
    }

    public function verificar()
    {
        return view('participantes.verificar');
    }

    public function verificarParticipante(){

            $participante = Participante::with('ubicaciones')->where('numero_identificacion', Input::get("cedula"))->get();

            if(count($participante) == 0){

                Session::flash('message', 'No estas registrado como participante');

                return redirect('/participante');

            }else{

                foreach ($participante as $p) {

                
                $id_part = "";

                Session::put('id_part', $p->id);

                $cedula = "";

                Session::put('cedula', $p->numero_identificacion);

                $apellidos = "";

                Session::put('apellidos', $p->apellidos);

                $nombres = "";

                Session::put('nombres', $p->nombres);  

                return view('participantes.index', compact('participante'));  
            }

            


            }

    }

    public function ActuacionAcademica(){

        if(Session::has('nombres')){

            return view('participantes.actacademica', compact('participante'));

        }else{

            Session::flash('message', 'Debes verificarte antes');

           return redirect('/participante');

        }
        
    }

    public function cargarProgramas(){

        $participante = Participante::with('ubicaciones','talleres')->find(Session::get('id_part'));

        $programas = array();
        $talleres = array();
           foreach ($participante->ubicaciones as $u) {
                 array_push($programas, array('abrev_proyec' => $u->proyecto->abrev,
                                              'proy' => $u->proyecto->denominacion,
                                              'sede' => $u->sede->abrev,
                                              'periodo' => $u->pivot->per_ing));
           }

           foreach ($participante->talleres as $taller) {
                  array_push($talleres, array('abrev_proyec' => $taller->seccion->materia->unidad_curricular,
                                               'sede' => $taller->seccion->sede->abrev,
                                               'periodo' => $taller->seccion->periodo->nom_periodo,
                                               'inscrito' => $taller->inscrito,
                                               'asistencia' => $taller->asistencia,
                                               'aprobado' => $taller->aprobado,
                                               'solvente' => $taller->solvente,
                                               'tipo' => $taller->seccion->abrev_proy));
           }


        return response()->json(array($programas, $talleres));

    }

     public function cargarRecord(Request $request){

        $record = Nota::with('participante', 'seccion')
                  ->where('id_participante', Session::get('id_part'))
                  ->where('ligaseccion', 'like', '%'.Input::get('abrev').'%')
                  ->get();

        /* $secciones = Secciones::with('materia')->where('abrev_sede', Input::get('sede'))
                                    ->where('abrev_proy', Input::get('programa'))
                                    ->where('id_periodo', Input::get('periodo'))
                                    ->where('anulado', FALSE)
                                    ->orderBy('id', 'DESC')->get();*/
        $head = array();
        $body = array();

        foreach ($record as $r) {

            if($r->def == NULL){

                $nota = 0;
            }else{
                $nota = $r->def;
            }
            
            array_push($body, array('sem' => $r->seccion->materia->sem,
                                    'abrev_sede' => $r->seccion->abrev_sede,
                                    'codigo' => $r->seccion->materia->codigo,
                                    'asig' => $r->seccion->materia->unidad_curricular,
                                    'uc' => $r->seccion->materia->uc,
                                    'seccion' =>$r->seccion->seccion,
                                    'def' => $nota,
                                    'sede' => strtoupper($r->seccion->sede->denominacion),
                                    'periodo' => $r->seccion->periodo->nom_periodo,
                                    'pensum' => $r->seccion->materia->pensum));
        }

        $programa_sede = Proyecto::where('abrev', Input::get('abrev'))->get();
        $participante = array('cedula' => number_format(Session::get('cedula'), 0,"", "."), 
                            'participante' => strtoupper(Session::get('apellidos')).', '.strtoupper(Session::get('nombres')),
                             'programa' => strtoupper($programa_sede[0]->denominacion));

        $uca = 0;
        $ucc = 0;
        $pac = 0; 
        $paa = 0;
        $ia =  0; 
        $iaa= 0;

        foreach ($body as $b) {
            
              //Sacando las unidades de credito aprobadas
              if($b['def'] == 0){
                  //no sumar las unidades de credito si la notas es 0 o nula
              }else{

                $uca = $b['uc'] +  $uca;
              }

              //Sumando la unidades de credito cursadas
              $ucc = $b['uc'] + $ucc;

              //Calculadno el promedio aritmetico cursado
              $pac = $b['def'] + $pac;

               //Calculadno el indice academico aritmetico cursado
              $iaa = $b['def'] + $iaa;


              //haciendo el calculo del indice

              $ia2 = $b['uc'] * $b['def'];

              //echo $ia2.'<br>';

              $ia =  $ia + $ia2;

              //haciendo el calculo del promedio aritmetico

              $paa_2 = $b['uc'] * $b['def'];

              $paa = $paa + $paa_2;

        }

                       //Calculando el promedio aritmetico cursado
              $pac = $pac / count($body); 

              //Calculando el promedio aritmetico aprobado
           
                $paa = $paa / $uca;     
        

              //Finalizando el calculo del indice academico aprobado

              $ia = $ia / $uca;

              //Finalizando el calculo del indice academico cursados

              $iaa = $iaa / count($body);
             
            $indices = array('uca' => $uca,
                             'ucc' => $ucc,
                             'pac' => number_format($pac, 2, ".",","),
                             'paa' => number_format($paa, 2, ".",","),
                             'ia' => number_format($ia, 2, ".",","),
                             'iaa' => number_format($iaa, 2, ".", ","));


       

        return response()->json(array($body, $participante, $indices));

    }

    public function PrintRecord(){

         $record = Nota::with('participante', 'seccion')->where('id_participante', Session::get('id_part'))->where('ligaseccion', 'like', '%'.Input::get('abrev').'%')->get();

        /* $secciones = Secciones::with('materia')->where('abrev_sede', Input::get('sede'))
                                    ->where('abrev_proy', Input::get('programa'))
                                    ->where('id_periodo', Input::get('periodo'))
                                    ->where('anulado', FALSE)
                                    ->orderBy('id', 'DESC')->get();*/
        $head = array();
        $body = array();

        foreach ($record as $r) {

            if($r->def == NULL){

                $nota = 0;
            }else{
                $nota = $r->def;
            }
            
            array_push($body, array('sem' => $r->seccion->materia->sem,
                                    'abrev_sede' => $r->seccion->abrev_sede,
                                    'codigo' => $r->seccion->materia->codigo,
                                    'asig' => $r->seccion->materia->unidad_curricular,
                                    'uc' => $r->seccion->materia->uc,
                                    'seccion' =>$r->seccion->seccion,
                                    'def' => $nota,
                                    'sede' => strtoupper($r->seccion->sede->denominacion),
                                    'periodo' => $r->seccion->periodo->nom_periodo,
                                    'pensum' => $r->seccion->materia->pensum,
                                    'programa' => strtoupper($r->seccion->proyecto->denominacion)));
        }

        $programa_sede = Proyecto::where('abrev', Input::get('abrev'))->get();
        $participante = array('cedula' => number_format(Session::get('cedula'), 0,"", "."), 
                            'participante' => strtoupper(Session::get('apellidos')).', '.strtoupper(Session::get('nombres')),
                             'programa' => strtoupper($programa_sede[0]->denominacion));

        $uca = 0;
        $ucc = 0;
        $pac = 0; 
        $paa = 0;
        $ia =  0; 
        $iaa= 0;

        foreach ($body as $b) {
            
              //Sacando las unidades de credito aprobadas
              if($b['def'] == 0){
                  //no sumar las unidades de credito si la notas es 0 o nula
              }else{

                $uca = $b['uc'] +  $uca;
              }

              //Sumando la unidades de credito cursadas
              $ucc = $b['uc'] + $ucc;

              //Calculadno el promedio aritmetico cursado
              $pac = $b['def'] + $pac;

               //Calculadno el indice academico aritmetico cursado
              $iaa = $b['def'] + $iaa;


              //haciendo el calculo del indice

              $ia2 = $b['uc'] * $b['def'];

              //echo $ia2.'<br>';

              $ia =  $ia + $ia2;

              //haciendo el calculo del promedio aritmetico

              $paa_2 = $b['uc'] * $b['def'];

              $paa = $paa + $paa_2;

        }

                       //Calculando el promedio aritmetico cursado
              $pac = $pac / count($body); 

              //Calculando el promedio aritmetico aprobado
              $paa = $paa / $uca; 

              //Finalizando el calculo del indice academico aprobado

              $ia = $ia / $uca;

              //Finalizando el calculo del indice academico cursados

              $iaa = $iaa / count($body);
             
            $indices = array('uca' => $uca,
                             'ucc' => $ucc,
                             'pac' => number_format($pac, 2, ".",","),
                             'paa' => number_format($paa, 2, ".",","),
                             'ia' => number_format($ia, 2, ".",","),
                             'iaa' => number_format($iaa, 2, ".", ","));


            $pdf = \PDF::loadview('participantes.pdfrecordacad', compact('body', 'participante', 'indices'));
            return $pdf->stream();
    }

    public function salir(){

            Session::flush();

            return redirect('/participante');

    }
}