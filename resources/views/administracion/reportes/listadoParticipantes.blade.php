<!DOCTYPE html>
<html>
<head>
	<title>Listado de participantes</title>
	<style type="text/css">
.page-break {
    page-break-after: always;
}
.tg  {border-collapse:collapse;border-spacing:0; width:100%;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:1px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:1px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-8ua6{font-weight:bold;background-color:#343434;color:#ffffff;text-align:center;vertical-align:top; border-style:solid;border-width:1px; border-color: #000;}
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

      .page-number {
        text-align: center;
      }

      .page-number:before {
        content: "Pagina " counter(page);
      }

</style>
</head>
<body>
<div id="footer">
      <div class="page-number"></div>
</div>

<img src="{{ asset('assets/images/logo_unermb_planilla.png') }}">

<img style="margin-left: 300px;" src="{{ asset('assets/images/logo_educacion.png') }}">
<br>
<table class="tg" id="planillaPart">
  <tr>
    <th class="tg-uqo3" colspan="7">UNIDAD DE EDUCACIÓN CONTINUA</th>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CURSO</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][7]!!}</td>
    <td class="tg-7qzr">GRUPO</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][5]!!}</td>
    <td class="tg-7qzr">CODIGO</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][2]!!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">SEDE</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][3]!!}</td>
    <td class="tg-7qzr">PENSUM</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][0]!!}</td>
    <td class="tg-7qzr">UC</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][9]!!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">PERIODO</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][8]!!}</td>
    <td class="tg-7qzr">SEM</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][1]!!}</td>
    <td class="tg-7qzr">HS</td>
    <td class="tg-yw4l">{!! $arraySecciones[0][10]!!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">FACILITADOR</td>
    <td class="tg-yw4l" colspan="5">{!! $arraySecciones[0][6]!!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">MODULO</td>
    <td class="tg-yw4l" colspan="5">{!! $arraySecciones[0][4]!!}</td>
  </tr>
  <tr>
    <td class="tg-8ua6" colspan="7">LISTADO DE PARTICIPANTES</td>
  </tr>
  <thead>
  <tr>
    <th class="tg-u1yq">Nro.</th>
    <th class="tg-u1yq">Cedula</th>
    <th class="tg-u1yq" colspan="5">APELLIDOS Y NOMBRES</th>
  </tr>
  </thead>
  <tbody>
  @foreach($arrayPar as $p)
    <tr>
    <td class="tg-s6z2">{!! $p[0]!!}</td>
    <td class="tg-s6z2">{!! $p[1] !!}</td>
    <td class="tg-s6z3" colspan="5">{!! $p[2]!!}</td>
  </tr>
  @endforeach
  </tbody>
  
</table>
</body>
</html>