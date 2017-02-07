<div  class="modal fade" id="modalRecord" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="mgtitleNotas"><center>Record academico</center></h4>
      </div>
      <div class="modal-body" id="mgbodyNotas">
<img src="{{ asset('assets/images/logo_unermb_planilla.png') }}">

<img style="margin-left: 420px;" src="{{ asset('assets/images/logo_educacion.png') }}">
      <table class="tg" id="planillaPart">
    <table class="tg">
  <tr>
    <td class="tg-8ua6" colspan="7">RECORD ACADEMICO</td>
  </tr>
  <tr>
    <td class="tg-uqo3" colspan="7">UNIDAD DE EDUCACIÓN CONTINUA</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CEDULA</td>
    <td class="tg-yw4l" colspan="5">@{{ participante.cedula }}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">PARTICIPANTE</td>
    <td class="tg-yw4l" colspan="5">@{{ participante.nombre  }}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CURSO</td>
    <td class="tg-yw4l" colspan="5">@{{ participante.programa  }}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">SEDE</td>
    <td class="tg-yw4l" colspan="">@{{ participante.sede }}</td>
    <td class="tg-7qzr">COHORTE</td>
    <td class="tg-yw4l" style="text-align: center;">@{{ participante.periodo }}</td>
    <td class="tg-7qzr">PENSUM</td>
    <td class="tg-yw4l" style="text-align: center;">@{{ participante.pensum }}</td>
  </tr>
  <tr>
    <td class="tg-8ua6">SEM.</td>
    <td class="tg-8ua6">COD</td>
    <td class="tg-8ua6" colspan="2">ASIGNATURA</td>
    <td class="tg-8ua6">SECCIÓN</td>
    <td class="tg-8ua6">UC</td>
    <td class="tg-8ua6">NOTA</td>
  </tr>
  <tbody>
      <tr v-for="seccion in secciones">
        <td class="tg-s6z3" style="text-align: center;">@{{ seccion.sem }}</td>
        <td class="tg-s6z3" style="text-align: center;">@{{ seccion.codigo }}</td>
        <td class="tg-s6z3" colspan="2">@{{ seccion.asig }}</td>
        <td class="tg-s6z3" style="text-align: center;">@{{ seccion.seccion }} - (@{{ seccion.sede }})</td>
        <td class="tg-s6z3" style="text-align: center;">@{{ seccion.uc }}</td>
        <td class="tg-s6z3" style="text-align: center;">@{{ seccion.def }}</td>
      </tr>
  </tbody> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Unidades de credito</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.uca }}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Inidices académicos</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.ia }}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Promedios Aritméticos</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.paa }}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Unidades de creditos cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.ucc }}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Indices Académicos Cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.iaa }}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Promedios Aritméticos Cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">@{{ infodef.pac }}</td>
      </tr> 
</table>



      </div>
      <div class="modal-footer" id="mgmensajeNotas" style="display:none;">
      </div>
      <div class="modal-footer" id="mgtoolsNotas">
      <input type="hidden" name="id_seccion" id="id_seccion_notas">
      <form method="post" action="/participante/printRecord">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" >
      <input type="hidden" name="abrev" v-bind:value="abrev">
      <button class="btn btn-success" type="submit" target="_blank">Imprimir <i class="fa fa-print" target="_blank"></i></button>
      </form>
      </div>
    </div>

  </div>
</div>