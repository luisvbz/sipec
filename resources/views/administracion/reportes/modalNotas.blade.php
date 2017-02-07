<div  class="modal fade" id="modalNotas" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="mgtitleNotas"><center>Imprimir planillas de notas definitivas</center></h4>
      </div>
      <div class="modal-body" id="mgbodyNotas">

<table style="width:100%;">
  <tr>
    <td style="vertical-align:top;">
    <table class="tg" id="notasPart" style="width:580px;">
  <tr>
    <td class="tg-8ua6" colspan="7">PLANILLA DE CALIFICACIÓN DEFINITIVA</td>
  </tr>
  <tr>
    <td class="tg-uqo3" colspan="7">UNIDAD DE EDUCACIÓN CONTINUA</td>
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
    <td class="tg-7qzr" colspan="2">MODULO</td>
    <td class="tg-yw4l" colspan="5"></td>
  </tr>
  <tr>
    <td class="tg-8ua6" colspan="5">PARTICIPANTE</td>
    <td class="tg-8ua6" colspan="5">NOTA DEFINITIVA</td>
  </tr>
  <tr>
    <td class="tg-u1yq">Nro.</td>
    <td class="tg-u1yq">Cedula</td>
    <td class="tg-u1yq" colspan="3">APELLIDOS Y NOMBRES</td>
    <td class="tg-u1yq">NÚMERO</td>
    <td class="tg-u1yq">LETRAS</td>
  </tr>
  <tbody id="bodyPartNotas">

  </tbody>
</table>
    </td>
    <td style="vertical-align:top;">
    <table class="tg" id="tbfacilitador" style="width:280px;">
    <tr>
      <td><img src="{{ asset('assets/images/logo_unermb_planilla.png') }}"></td>
    </tr>
    <tr>
      <td class="tg-8ua6" colspan="2">
        OBSERVACIONES
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td  colspan="2" style="height: 20px; border: none;">
      </td>
    </tr>
    <tr>
      <td class="tg-8ua6" colspan="2">
        FACILITADOR
      </td>
    </tr>
     <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px; border-bottom: none;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px; border-top: none;">
      </td>
    </tr>
     <tr>
      <td  class="tg-s6z2" colspan="2" style="font-size: 10px;">
       <B>FIRMA</B>
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 10px; border-bottom: none;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px; border-top: none;">
        <span id="nprof"></span>
      </td>
    </tr>
     <tr>
      <td  class="tg-s6z2" colspan="2" style="font-size: 10px;">
       <B>APELLIDO Y NOMBRE</B>
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 10px; border-bottom: none;">
      </td>
    </tr>
    <tr>
      <td class="tg-s6z2" colspan="2" style="height: 20px; border-top: none;">
        <span id="cedprof"></span>
      </td>
    </tr>
     <tr>
      <td  class="tg-s6z2" colspan="2" style="font-size: 10px;">
       <B>CEDULA</B>
      </td>
    </tr>
    <tr>
      <td  class="tg-s6z3" colspan="2" style="font-size: 11px;">
       <B>CORREO:</B>
      </td>
    </tr>
    <tr>
      <td  class="tg-s6z3" colspan="2" style="font-size: 11px;">
       <B>TELÉFONO:</B>
      </td>
    </tr>
    <tr>
      <td  class="tg-s6z3" colspan="2" style="font-size: 11px;">
       <B>FECHA:</B>
      </td>
    </tr>
    <tr>
      <td><img src="{{ asset('assets/images/logo_educacion.png') }}"></td>
    </tr>
</table>
    </td>
  </tr>
</table>


      </div>
      <div class="modal-footer" id="mgmensajeNotas" style="display:none;">
      </div>
      <div class="modal-footer" id="mgtoolsNotas">
      {!! Form::open(array('method' => 'POST', 'route' => 'notas.part', 'target' => '_blank'))!!}
      <input type="hidden" name="id_seccion" id="id_seccion_notas">
      <button class="btn btn-success">Imprimir <i class="fa fa-print" target="_blank"></i></button>
      {!! Form::close() !!}
         
      </div>
    </div>

  </div>
</div>