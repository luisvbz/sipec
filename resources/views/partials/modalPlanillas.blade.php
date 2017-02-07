<div  class="modal fade" id="modalPlanillas" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="mgtitlePlanillas"><center>Imprimir planilla de listado de participantes</center></h4>
      </div>
      <div class="modal-body" id="mgbodyPlanillas">

<img src="{{ asset('assets/images/logo_unermb_planilla.png') }}">

<img style="margin-left: 420px;" src="{{ asset('assets/images/logo_educacion.png') }}">
      <table class="tg" id="planillaPart">
  <tr>
    <th class="tg-uqo3" colspan="7">UNIDAD DE EDUCACIÓN CONTINUA</th>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CURSO</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">GRUPO</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">CODIGO</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">SEDE</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">PENSUM</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">UC</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">PERIODO</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">SEM</td>
    <td class="tg-yw4l"></td>
    <td class="tg-7qzr">HS</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">FACILITADOR</td>
    <td class="tg-yw4l" colspan="5"></td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">MODULO</td>
    <td class="tg-yw4l" colspan="5"></td>
  </tr>
  <tr>
    <td class="tg-8ua6" colspan="7">LISTADO DE PARTICIPANTES</td>
  </tr>
  <tr>
    <td class="tg-u1yq">Nro.</td>
    <td class="tg-u1yq">Cedula</td>
    <td class="tg-u1yq" colspan="5">APELLIDOS Y NOMBRES</td>
  </tr>
  <tbody id="bodyPartPlanilla">
  
  </tbody>
</table>

      </div>
      <div class="modal-footer" id="mgmensajePlanillas" style="display:none;">
      </div>
      <div class="modal-footer" id="mgtoolsPlanillas">
      {!! Form::open(array('method' => 'POST', 'route' => 'lista.pdf', 'target' => '_blank'))!!}
      <input type="hidden" name="id_seccion">
      <button class="btn btn-success">Imprimir <i class="fa fa-print" target="_blank"></i></button>
      {!! Form::close() !!}
         
      </div>
    </div>

  </div>
</div>