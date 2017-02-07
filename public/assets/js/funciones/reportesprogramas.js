
function imprimirPlanilla(tipo){

    $('[data-toggle="tipoImpresion"]').popover("hide");

    var id_seccion = $("input[name='rdseccion']:checked").val();
     if(tipo === 1){
      var tabla = $("#planillaPart");
       var curso = tabla.find("tr").eq(1).find("td").eq(1);
        var sede = tabla.find("tr").eq(2).find("td").eq(1);
        var periodo = tabla.find("tr").eq(3).find("td").eq(1);
        var grupo = tabla.find("tr").eq(1).find("td").eq(3);
        var pensum = tabla.find("tr").eq(2).find("td").eq(3);
        var sem = tabla.find("tr").eq(3).find("td").eq(3);
        var cod = tabla.find("tr").eq(1).find("td").eq(5);
        var uc = tabla.find("tr").eq(2).find("td").eq(5);
        var hs = tabla.find("tr").eq(3).find("td").eq(5);
        var facilitador = tabla.find("tr").eq(4).find("td").eq(1);
        var modulo = tabla.find("tr").eq(5).find("td").eq(1);
    }else{
      var tabla = $("#notasPart");
        var curso = tabla.find("tr").eq(2).find("td").eq(1);
        var sede = tabla.find("tr").eq(3).find("td").eq(1);
        var periodo = tabla.find("tr").eq(4).find("td").eq(1);
        var grupo = tabla.find("tr").eq(2).find("td").eq(3);
        var pensum = tabla.find("tr").eq(3).find("td").eq(3);
        var sem = tabla.find("tr").eq(4).find("td").eq(3);
        var cod = tabla.find("tr").eq(2).find("td").eq(5);
        var uc = tabla.find("tr").eq(3).find("td").eq(5);
        var hs = tabla.find("tr").eq(4).find("td").eq(5);
        var modulo = tabla.find("tr").eq(5).find("td").eq(1);
    }
   

    //Tipo 1; listado de participantes - Tipo 2; Planillas de notas definitivas
    if(tipo === 1){

       var url = '/administracion/reportes/listadopart';

       $.ajax({
                    data: { id_seccion: id_seccion },
                    type: 'post',
                    url: url,
                    headers:
                    {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                    },beforeSend: function(){
                  
                   },success: function(data){
                      var p = data[0];
                      var s = data[1];

                      //agregando el encabezado en el reporte del modal

                      pensum.html(s[0][0]);
                      sem.html(s[0][1]);
                      cod.html(s[0][2]);
                      sede.html(s[0][3]);
                      grupo.html(s[0][5]);
                      modulo.html(s[0][4]);
                      facilitador.html(s[0][6]);
                      curso.html(s[0][7]);
                      periodo.html(s[0][8]);
                      uc.html(s[0][9]);
                      hs.html(s[0][10]);
                      

                      for (var i = 0; i < p.length; i++) {
                       
                        $("#bodyPartPlanilla").append('<tr>'+
                                    '<td class="tg-s6z2">'+p[i][0]+'</td>'+
                                    '<td class="tg-s6z2">'+p[i][1]+'</td>'+
                                    '<td class="tg-s6z3" colspan="5">'+p[i][2]+'</td>'+
                                  '</tr>');
                      };
                      //  $("#mgtoolsPlanillas").html('<button class="btn btn-success" onClick="imprimirListado(1,'+id_seccion+');">Imprimir <i class="fa fa-print"></i></button>');
                        $("input[name='id_seccion']").val(id_seccion);

                       $("#modalPlanillas").modal();
                   }

                   

                  });

     
    }else{
      var url = '/administracion/reportes/notasdef';
      $("#id_seccion_notas").val($("input[name='rdseccion']:checked").val());
      $.ajax({
                    data: { id_seccion: id_seccion },
                    type: 'post',
                    url: url,
                    headers:
                    {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                    },beforeSend: function(){
                  
                   },success: function(data){

                       var p = data[0];
                       var s = data[1];

                      pensum.html(s[0][0]);
                      sem.html(s[0][1]);
                      cod.html(s[0][2]);
                      sede.html(s[0][3]);
                      grupo.html(s[0][5]);
                      modulo.html(s[0][4]);
                      curso.html(s[0][7]);
                      periodo.html(s[0][8]);
                      uc.html(s[0][9]);
                      hs.html(s[0][10]);
                      $('#nprof').html(s[0][6]);
                      $('#cedprof').html('C.I.: '+s[0][11]);

                      console.log('a'+s[0][8]);

                      for (var i = 0; i <=  p.length; i++) {
                        $("#bodyPartNotas").append('<tr>'+
                              '<td class="tg-s6z2">'+p[i][0]+'</td>'+
                              '<td class="tg-s6z2">'+p[i][1]+'</td>'+
                              '<td class="tg-s6z3" colspan="3">'+p[i][2]+'</td>'+
                              '<td class="tg-s6z2">'+p[i][8]+'</td>'+
                              '<td class="tg-s6z2">'+p[i][9]+'</td>'+
                          '</tr>');
                      }

                   }


                  });
        $("#modalNotas").modal();


    }

              $(".close").click(function(){
                      $("#bodyPartPlanilla").empty();
                    });

}

$(document).ready(function(){
    $('[data-toggle="tipoImpresion"]').popover({
      title: "Seleccione el documento", 
      html: true,
      content: '<button style="width:100%" onClick = "imprimirPlanilla(1);" class="btn btn-xs btn-success">Listado de participantes <i class="fa fa-print"></i></button>'+
                '<br><br><button style="width:100%" onClick = "imprimirPlanilla(2); "class="btn btn-xs btn-default">Planilla definitiva <i class="fa fa-print"></i></button>',});
});

function imprimirPCD(tipo, id_seccion){

  console.log(tipo, id_seccion);
}