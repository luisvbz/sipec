<!DOCTYPE html>
<html>
<head>
	<title>Notas</title>
	<style type="text/css">
.page-break {
   page-break-after:always; 
}

.tg  {border-collapse:collapse;border-spacing:0px; width:14cm; }
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:1px;border-style:solid;border-width:0.5px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:1px;border-style:solid;border-width:0.5px;overflow:hidden;word-break:normal;}
.tg .tg-8ua6{font-weight:bold;background-color:#343434;color:#ffffff;text-align:center;vertical-align:top; border-style:solid;border-width:0.5px; border-color: #000;}
.tg .tg-uqo3{background-color:#efefef;text-align:center;vertical-align:top; color: #000;}
.tg .tg-s6z2{text-align:center; color: #000;}
.tg .tg-s6z3{text-align:left; color: #000; text-transform: uppercase;  }
.tg .tg-7qzr{font-weight:bold;background-color:#c0c0c0;text-align:right;vertical-align:top; color: #000;}
.tg .tg-yw4l{vertical-align:top; color: #000;}
.tg .tg-u1yq{font-weight:bold;background-color:#c0c0c0;text-align:center;vertical-align:top; color: #000;}
.tg .tg-u1yqq{font-weight:bold;background-color:#c0c0c0;text-align:left;vertical-align:top; color: #000; }
#footer {
        position: fixed;
        left: 0;
        right: 0;
        color: #aaa;
        font-size: 0.9em;
      }
#footer {
        bottom: 0;
        border-top: 0.1pt solid #aaa;
      }
#footer table {
        width: 100%;
        border-collapse: collapse;
        border: none;
      }

#footer td {
        padding: 0;
        width: 50%;
      }

#header {
        position: fixed;
        top: 0;
        height: 5cm;
      }
#content {
        position: relative;
        top: 1;
        margin-top: -20px;
      }


      .page-number {
        text-align: center;
      }

      .page-number:before {
        content: "Pagina " counter(page);
      }

#facilitador{
    position: fixed;
    top: 0cm;
    left: 14.5cm;
}

</style>
</head>
<div id="footer">
      <div class="page-number"></div>
</div>
<div id="header">
<!--<img src="{{ asset('assets/images/logo_unermb_planilla.png') }}">

<img style="margin-left: 300px;" src="{{ asset('assets/images/logo_educacion.png') }}">-->

<div id="facilitador">
<table class="tg" id="tbfacilitador" style="width:5cm;">
    <tr>
      <td style="border:none;" colspan="2"><img src="{{ asset('assets/images/logo_unermb_planilla.png') }}"></td>
    </tr>
    <tr>
      <td style="border:none;" colspan="2" style="height: 20px;">
      </td>
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
        {!! $encabezado[0][6]!!}
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
        C.I.: {!! $encabezado[0][11]!!}
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
      <td style="border:none;" colspan="2" style="height: 20px;">
      </td>
    </tr>
    <tr>
      <td style="border:none;" colspan="2"><img src="{{ asset('assets/images/logo_educacion.png') }}"></td>
    </tr>
</table>
</div>
</div>
<br>
<body>
<div id="content">
    <table class="tg" id="notasPart" style="width:14cm;">
    <thead>
  <tr>
    <td class="tg-8ua6" colspan="7">PLANILLA DE CALIFICACIÓN DEFINITIVA</td>
  </tr>
  <tr>
    <td class="tg-uqo3" colspan="7">UNIDAD DE EDUCACIÓN CONTINUA</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CURSO</td>
    <td class="tg-yw4l">{!! $encabezado[0][7]!!}</td>
    <td class="tg-7qzr">GRUPO</td>
    <td class="tg-yw4l">{!! $encabezado[0][5]!!}</td>
    <td class="tg-7qzr">CODIGO</td>
    <td class="tg-yw4l">{!! $encabezado[0][2]!!}</td>
  </tr>
   <tr>
    <td class="tg-7qzr" colspan="2">SEDE</td>
    <td class="tg-yw4l">{!! $encabezado[0][3]!!}</td>
    <td class="tg-7qzr">PENSUM</td>
    <td class="tg-yw4l">{!! $encabezado[0][0]!!}</td>
    <td class="tg-7qzr">UC</td>
    <td class="tg-yw4l">{!! $encabezado[0][9]!!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">PERIODO</td>
    <td class="tg-yw4l">{!! $encabezado[0][8]!!}</td>
    <td class="tg-7qzr">SEM</td>
    <td class="tg-yw4l">{!! $encabezado[0][1]!!}</td>
    <td class="tg-7qzr">HS</td>
    <td class="tg-yw4l">{!! $encabezado[0][10]!!}</td>
  </tr>
   <tr>
    <td class="tg-7qzr" colspan="2">MODULO</td>
    <td class="tg-yw4l" colspan="5">{!! $encabezado[0][4]!!}</td>
  </tr>
  <tr>
    <td class="tg-8ua6" colspan="5">PARTICIPANTE</td>
    <td class="tg-8ua6" colspan="2">NOTA DEFINITIVA</td>
  </tr>
  <tr>
    <td class="tg-u1yq">Nro.</td>
    <td class="tg-u1yq">Cedula</td>
    <td class="tg-u1yq" colspan="3">APELLIDOS Y NOMBRES</td>
    <td class="tg-u1yq">NÚMERO</td>
    <td class="tg-u1yq">LETRAS</td>
  </tr>
  </thead>
  <tbody id="bodyPartNotas">
      @foreach($arrayPar as $p)
        <tr>
            <td class="tg-s6z2">{!! $p[0] !!}</td>
            <td class="tg-s6z2">{!! $p[1] !!}</td>
            <td class="tg-s6z3" colspan="3">{!! $p[2] !!}</td>
            <td class="tg-s6z2">{!! $p[8] !!}</td>
            <td class="tg-s6z2">{!! $p[9] !!}</td>
        </tr>
      @endforeach
  </tbody>
</table>
</div>

</body>
</html>