<html>
<head>
  <title>_Mi record academico</title>
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
.nota { position: fixed;  top: 690;}
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
    <td class="tg-yw4l" colspan="5">{!! $participante['cedula'] !!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">PARTICIPANTE</td>
    <td class="tg-yw4l" colspan="5">{!! $participante['participante'] !!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">CURSO</td>
    <td class="tg-yw4l" colspan="5">{!! $body[0]['programa'] !!}</td>
  </tr>
  <tr>
    <td class="tg-7qzr" colspan="2">SEDE</td>
    <td class="tg-yw4l" colspan="">{!! $body[0]['sede'] !!}</td>
    <td class="tg-7qzr">COHORTE</td>
    <td class="tg-yw4l" style="text-align: center;">{!! $body[0]['periodo'] !!}</td>
    <td class="tg-7qzr">PENSUM</td>
    <td class="tg-yw4l" style="text-align: center;">{!! $body[0]['pensum'] !!}</td>
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
    @foreach($body as $m)
      <tr>
        <td class="tg-s6z3" style="text-align: center;">{!! $m['sem'] !!}</td>
        <td class="tg-s6z3" style="text-align: center;">{!! $m['codigo'] !!}</td>
        <td class="tg-s6z3" colspan="2">{!! $m['asig'] !!}</td>
        <td class="tg-s6z3" style="text-align: center;">{!! $m['seccion'] !!} - ({!! $m['abrev_sede'] !!})</td>
        <td class="tg-s6z3" style="text-align: center;">{!! $m['uc'] !!}</td>
        <td class="tg-s6z3" style="text-align: center;">{!! $m['def'] !!}</td>
      </tr>
    @endforeach
  </tbody> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Unidades de credito</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['uca'] !!}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Inidices académicos</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['ia'] !!}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Promedios Aritméticos</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['paa'] !!}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Unidades de creditos cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['ucc'] !!}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Indices Académicos Cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['iaa'] !!}</td>
      </tr> 
      <tr>
        <td class="tg-s6z3" style="text-align: right;" colspan="6"><strong>Promedios Aritméticos Cursadas</strong></td>
        <td class="tg-s6z3" style="text-align: center;">{!! $indices['pac'] !!}</td>
      </tr> 
</table>
<br>
<br>
<p class="nota"><strong>***Nota***:</strong>Esta planilla de notas no es valida sin sello humedo</p>
</body>
</html>