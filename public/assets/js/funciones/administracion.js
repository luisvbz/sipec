var seccion = $("input[name='rdseccion']:checked").val();
var periodo = $("#periodo :selected").text();

	$("#sede").change(function(){
		var id_sede = $(this).val();

		$("#sprograma").empty();
		if(id_sede == 0){

        	}else{
		$.ajax({
        data: { id_sede: id_sede},
        type: 'post',
        url: '/administracion/cargar/proyectos',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          $("#loader").show();
        }, 
        success: function(data){
        	
          for (var i = 0; i < data.length; i++) {
          	$("#loader").hide();
          	$("#programa").show();
          	$("#sprograma").append('<option value="'+data[i][0]+'">'+data[i][1]+'</option>');
          }
        }

      });
	}
	});

	$("#buscarSecciones").click(function(){
    var seccion = $("input[name='rdseccion']:checked").val();
		var sede = $("#sede").val();
		var sede_text = $("#sede :selected").text();
		var programa = $("#sprograma").val();
		var programa_text = $("#sprograma :selected").text();
		var periodo = $("#periodo").val();
		var periodo_text = $("#periodo :selected").text();
		var tbprogramas = $("#tb_programas tbody");

		tbprogramas.empty();
		$("#encabezadoBusqueda").empty();

		$.ajax({
        data: { sede: sede, programa: programa, periodo:periodo},
        type: 'post',
        url: '/administracion/cargar/secciones',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){

        }, 
        success: function(data){
        
         if(data.length == 0){
          	jAlert('No se encontro información disponible con esta busqueda!', 'Advertencia');
	      	}else{
	      		$("#encabezadoBusqueda").append('<b>'+programa_text+' - '+sede_text+' - '+periodo_text+'</b>');
	      		$("#cuantas").html('<b>'+data.length+'</b>');
	      		for (var i = 0; i < data.length; i++) {

              if(canEliminar == ""){
                      tbprogramas.append('<tr>'+
                      '<td><input type="radio" value="'+data[i][7]+'" name="rdseccion"></td>'+
                      '<td style="text-align: center" id="pensum_'+data[i][7]+'">'+data[i][0]+'</td>'+
                      '<td>'+data[i][1]+'</td>'+
                      '<td id="cod_'+data[i][7]+'">'+data[i][2]+'</td>'+
                      '<td>'+data[i][3]+'</td>'+
                      '<td id="mod_'+data[i][7]+'">'+data[i][4]+'</td>'+
                      '<td id="grupo_'+data[i][7]+'"style="text-alig:center;">'+data[i][5]+'</td>'+
                      '<td>'+data[i][6]+'</td>'+
                      '<td>'+data[i][8]['cant']+'/<span id="cant_'+data[i][7]+'">'+data[i][9]['contar_cupo']+'</span><input type="hidden" value="'+data[i][10]+'" id="materia_'+data[i][7]+'"></td>'+
                      '</tr>');

              }else{
                      tbprogramas.append('<tr>'+
                      '<td><input type="radio" value="'+data[i][7]+'" name="rdseccion"></td>'+
                      '<td style="text-align: center" id="pensum_'+data[i][7]+'">'+data[i][0]+'</td>'+
                      '<td>'+data[i][1]+'</td>'+
                      '<td id="cod_'+data[i][7]+'">'+data[i][2]+'</td>'+
                      '<td>'+data[i][3]+'</td>'+
                      '<td id="mod_'+data[i][7]+'">'+data[i][4]+'</td>'+
                      '<td id="grupo_'+data[i][7]+'"style="text-alig:center;">'+data[i][5]+'</td>'+
                      '<td>'+data[i][6]+'</td>'+
                      '<td>'+data[i][8]['cant']+'/<span id="cant_'+data[i][7]+'">'+data[i][9]['contar_cupo']+'</span><input type="hidden" value="'+data[i][10]+'" id="materia_'+data[i][7]+'"></td>'+
                      '<td><a style="color:#c0392b; text-decoration:none; font-size: 18px;" href="javascript:;" onclick="eliminarSeccion('+data[i][7]+');"><i class="fa fa-trash-o"></i></a></td>'+
                      '</tr>');
                }     
              }
          		
	      	}
        }

      });
	});

	//Consultar los participantes en este grupo o seccion

	$("#buscarParticipantes").click(function(){
		var id_seccion = $("input[name='rdseccion']:checked").val();
		var cod = $("#cod_"+id_seccion).text();
		var modulo = $("#mod_"+id_seccion).text();
		var grupo = $("#grupo_"+id_seccion).text();

		if(id_seccion == null){
        jAlert("Debes elegrir la seccion para poder ver el listado de los participantes!");
		}else{

		$.ajax({
        data: { id_seccion: id_seccion},
        type: 'post',
        url: '/administracion/cargar/participantes',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          
        }, 
        success: function(data){

          var p = data[0];
          var s = data[1];


        	$('#mgtitle').html('Particpantes registrados<br>'+cod+' - '+modulo+' '+'('+grupo+')');
        	$('#mgbody').append(
            '<table id="tbparticipantes" class="table table-striped">'+
            '<thead>'+
              '<th style="text-align: center;">Nro.</th>'+
             '<th>Cedula</th>'+
              '<th>Nombres</th>'+
             '<th>Cohorte</th>'+
             '<th>Notas</th>'+
             '<th></th>'+
             '<th><input type="checkbox" onClick="marcarDesmarcar(this)" id="marcarTodos"></th>'+
             '</thead>'+
             '<tbody>'+
             '</tbody>'+
             '<tfoot></tfoot>'+
             '</table>');
          for (var i = 0; i < p.length; i++) {
          	 var nota = p[i][4];
          	 if(nota == null){
          	 	nota = '-';
          	 }

             if(nota == 0){
              nota = '-';
             }

             if(nota == '-0'){
              nota = '-';
             }

          		$("#tbparticipantes tbody").append('<tr>'+
          			'<td style="text-align: center;"><input id="notaParticipante_'+p[i][0]+'" type="hidden" value="'+p[i][5]+'"><input id="notaSeccion" type="hidden" value="'+p[i][6]+'">'+p[i][0]+'</td>'+
          			'<td>'+p[i][1]+'</td>'+
          			'<td id="nomPart_'+p[i][7]+'">'+p[i][2]+'</td>'+
          			'<td>'+p[i][3]+'</td>'+
          			'<td><label id="l_nota_'+p[i][0]+'" onClick="AbrirNota('+p[i][0]+', true)" value="'+nota+'">'+nota+'</label>'+
                '<input id="i_nota_'+p[i][0]+'" style="width: 50px; display: none;" value="'+nota+'" maxlength="2" onkeydown="ValidarNota(event,'+p[i][0]+')"> '+
                '<td style="color: #c0392b; font-size: 20px;"><a style="color:#c0392b; text-decoration:none;" href="javascript:;" onClick="quitarParticipante('+p[i][7]+');"><i class="fa fa-trash-o"></i></a></td>'+
                '<td><input name="chkpart[]" type="checkbox" value="'+p[i][5]+'"></td>'+
                '</td>'+
          			'</tr>');
          }

          //Mostrando la cantidad de participantes registrados
          $("#tbparticipantes tfoot").append(
            '<tr>'+
            '<td colspan="7"><span id="cantPart"><b>'+p.length+'</b></span> Participantes regitrados en esta seccion</td>'+
            '<tr>'
            );

          //agregando boton de añadir participante

          $("#mgtools").append('<button id="btnFormAdd" class="btn btn-xs btn-primary pull-left" onClick="agregarPart()">Agregar Participante <i class="fa fa-plus"></i></button>');

          //Copiar listado de partcipoantes a otra seccion


          $("#tbparticipantes tfoot").append('<tr>'+
            '<td colspan="2" style="text-align: right;"><label>Copiar listado a:</label></td>'+
            '<td colspan="3">'+
              '<select name="copyTo" id="copyTo" class="form-control">'+
                '<option value="0">Seccion...</option>'+
              '</select>'+
            '</td>'+
            '<td colspan="2">'+
              '<button type="button" onclick="copiarParticpantes()" class="btn btn-xs btn-success">Copiar <i class="fa fa-copy"></i></button>'+
            '</td>'+
            '</tr>');

          //Llenar select de copiar a otra seccion

           for (var j = 0; j < s.length; j++) {
            
            var posicion = s[j][1];
            var n = parseInt([j])+1;

                /*switch(posicion) {
                case n:
                    $("#copyTo").append("<optgroup label='Modulo "+n+"' id='s"+n+"'></optgroup>");
                    $("#s"+n).append("<option value='"+s[j][0]+"'>"+s[j][2]+" - "+s[j][3]+" ("+s[j][4]+")</option>")
                    break;
                default:
                    break;
                }*/
                $("#copyTo").append("<option value='"+s[j][0]+"'>"+s[j][2]+" - "+s[j][3]+" ("+s[j][4]+")</option>")

          }


          if(canEliminar == ""){
              $(".fa-trash-o").remove();
          }

          if(canIncluir== ""){
              $("input[type='checkbox']").parent().remove();
              $("#copyTo").parent().parent().remove();
              $("#btnFormAdd").remove();
          }

          

          $("#modalGrande").modal();
        }

      });

		$(".close").click(function(){
			$("#mgbody").empty();
      $("#mgmensaje").empty();
      $("#mgtools").empty();
      $("#mgmensaje").hide();
		});

		$("#CerrarModal").click(function(){
			$("#mgbody").empty();
      $("#mgtools").empty();
       $("#mgmensaje").empty();
       $("#mgmensaje").hide();
		});

    //Marcar todos los participante

		}

	});

//Marcar todos lo ckechboxes

function marcarDesmarcar(source){
   checkboxes = $("#tbparticipantes input[type=checkbox]");

  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
  
//Copiar todos loa participantes a otra sección
function copiarParticpantes(){

   var participantes = $("input[name='chkpart[]']:checked").serializeArray();

   var id_seccion = $("#copyTo").val();

   var sede = $("#sede").val();

   var programa = $("#sprograma").val();

   var periodo = $("#periodo :selected").text();

   var codigo = $("#cod_"+id_seccion).text();

   var pensum = $("#pensum_"+id_seccion).text();

   var liga = periodo+'/'+programa+'-'+sede+'/'+pensum+'/'+codigo;

    if(id_seccion == 0){
      
      jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar una sección',
                            sticky: false,
                            time: '',
                            class_name: 'growl-warning',

                     });

    }else{

    $.ajax({
        data: {chkpart: participantes, id_seccion: id_seccion, liga: liga},
        type: 'post',
        url: '/administracion/copiar/participantes',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
            $("#mgmensaje").show();
            $("#mgmensaje").html('Copiando participantes, Por favor espere .... <img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){

          $("#mgmensaje").hide();
          jQuery.gritter.add({
                            title: 'Copiado exitoso!',
                            text: 'Los participantes se han copiado exitoamnete',
                  class_name: 'growl-success',
                 // image: 'images/screen.png',
                            sticky: false,
                            time: ''
                     });
          //console.log("#cant_"+id_seccion);
            $("#cant_"+id_seccion).html(data);

        }

      });  
    }
    

}
//

//Mostrar formulario para añadir un participante en la seccion
function agregarPart(){

    
    $("#mgtools").append('<div class="form-inline pull-left" id="divpart" style="margin-left:0px;">'+
      '<input type="text" id="addparseccion" onblur ="buscarPart()" name="addparseccion" class="form-control"  placeholder="Cedula de Identidad" style="width:200px; margin-left:50px;">'+
      '<label id="nombrePart" style="width: 400px; margin-left:10px; text-align:left;"></label>'+
      '<button id="btnadd" disabled rel="tooltip" title="Agregar"  class="btn btn-xs btn-success"><i class="fa fa-save"></i></button>'+
      '<button rel="tooltip" title="Cancelar" onclick="CancelarAddPart()" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></button>'+
      '</div>');

}

//funcion para verificar el nombre de participante
function buscarPart(){
  var cedula = $("#addparseccion").val();
  var nombre = $("#nombrePart");
  var seccion = $("input[name='rdseccion']:checked").val();
  var materia = $("#materia_"+seccion).val();
  var programa = $("#sprograma").val();

  $.ajax({
        data: { cedula: cedula, seccion: seccion, programa: programa, materia: materia, periodo: periodo},
        type: 'post',
        url: '/administracion/participanteAjax',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          $("#nombrePart").html('<img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){
          var tipo = data['tipo'];
          var boton = $("#btnadd");


          if(tipo == 1){
           
             $("#nombrePart").html('<span style="color: #c0392b">'+data['mensaje']+'</span>');

          }else if(tipo == 2){

            $("#nombrePart").html('<span style="color: #c0392b">'+data['mensaje']+'</span>');

          }else if(tipo == 3){

            $("#nombrePart").html('<span style="color: #27ae60">'+data['mensaje']+'</span>');
            boton.removeAttr("disabled");
            boton.attr('onClick','agPartSeccion()');

          }else if(tipo == 4){

            $("#nombrePart").html('<span style="color: #c0392b">'+data['mensaje']+'</span>');
          } 
        }
      });

}

function CancelarAddPart(){



    $("#divpart").remove();
    $("#btnFormAdd").removeAttr("disabled");
}

function agPartSeccion(){

  var cedula = $("#addparseccion").val();
  var nombre = $("#nombrePart");
  var seccion = $("input[name='rdseccion']:checked").val();
  var programa = $("#sprograma").val();
  var sede = $("#sede").val();
  var programa = $("#sprograma").val();
  var periodo_text = $("#periodo :selected").text();
  var pensum = $("#pensum_"+seccion).text();
  var codigo = $("#cod_"+seccion).text();
  var grupo = $("#grupo_"+seccion).text();
  var materia = $("#materia_"+seccion).val();
  var count = $("#tbparticipantes tbody tr:last").find("td").eq(0).text();

  var ligaseccion = periodo_text+'/'+programa+'-'+sede+'/'+pensum+'/'+codigo+'/'+grupo+'/'+cedula;

  $.ajax({
        data: { cedula: cedula, seccion: seccion, programa: programa, periodo: periodo, materia: materia, ligaseccion: ligaseccion},
        type: 'post',
        url: '/administracion/addParticipanteAjax',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          $("#nombrePart").html('<img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){

          var tipo = data['tipo'];
          var boton = $("#btnadd");
          var numero = parseInt(count) + 1;

          boton.attr("disabled");

          $("#divpart").remove();

          var nota = data[0][4];
             if(nota == null){
              nota = '-';
             }

             if(nota == 0){
              nota = '-';
             }

             if(nota == '-0'){
              nota = '-';
             }



          $("#tbparticipantes tbody").append('<tr>'+
                '<td style="text-align: center;"><input id="notaParticipante_'+numero+'" type="hidden" value="'+numero+'"><input id="notaSeccion" type="hidden" value="'+data[0][6]+'">'+numero+'</td>'+
                '<td>'+data[0][1]+'</td>'+
                '<td id="nomPart_'+data[0][7]+'">'+data[0][2]+'</td>'+
                '<td>'+data[0][3]+'</td>'+
                '<td><label id="l_nota_'+numero+'" onClick="AbrirNota('+numero+', true)" value="'+nota+'">'+nota+'</label>'+
                '<input id="i_nota_'+data[0][0]+'" style="width: 50px; display: none;" value="'+nota+'" maxlength="2" onkeydown="ValidarNota(event,'+data[0][0]+')"> '+
                '<td style="color: #c0392b; font-size: 20px;"><a style="color:#c0392b; text-decoration:none;" href="javascript:;"onClick=quitarParticipante('+data[0][7]+')><i class="fa fa-trash-o"></i></a></td>'+
                '<td><input name="chkpart[]" type="checkbox" value="'+data[0][5]+'"></td>'+
                '</td>'+
                '</tr>');

          $("#cantPart").html('<b>'+numero+'</b>');

           $("#cant_"+seccion).html(numero);

           $("#mgmensaje").show();

           $("#mgmensaje").html("<center><span style='color: #27ae60; font-size: 15px;'><i class='fa fa-check-circle'></i> Participante agregado exitosamente: "+data[0][2]+"</span></center>")


        }
      });
}

//Funcion para quitar participante de una seccion 

function quitarParticipante(id_part){

  var nombre = $("#nomPart_"+id_part).text();

         $("#mgbody").animate({ opacity: 0.3});

         $("#mgmensaje").show();

         $("#mgmensaje").html('<center>'+
                '<span class="alert alert-danger" id="confirmDel"><b>Deseas eliminar a: '+nombre+' de esta seccion y modulo? </b>'+
                '<button onClick="confQuitarPart(1, '+id_part+')" class="btn btn-xs btn-success">Aceptar <i class="fa fa-check-circle"></i></button>'+
                '<button onClick="confQuitarPart(0, '+id_part+')" class="btn btn-xs btn-danger">Cancelar <i class="fa fa-times"></i></button>'+
                '</span>'+
                '</center>').focus(); 

}

function confQuitarPart(bool,id_part){

    var nombre = $("#nomPart_"+id_part).text();   
    var fila = $("#nomPart_"+id_part).parent();
    var count = $("#tbparticipantes tbody tr:last").find("td").eq(0).text();
    var seccion = $("input[name='rdseccion']:checked").val();

          if(bool === 1){

               $.ajax({
                    data: { id_part: id_part , seccion: seccion},
                    type: 'post',
                    url: '/administracion/quitarParticipante',
                    headers:
                    {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                    },beforeSend: function(){
                  $("#mgmensaje").show();
                  $("#mgmensaje").html('Eliminando <img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
                   },success: function(data){

                      var numero = parseInt(count) - 1;

                      $("#mgbody").animate({ opacity: 1});

                      $("#confirmDel").remove();

                      fila.fadeOut().remove();

                      $("#mgmensaje").show();

                       $("#mgmensaje").html('<center>'+
                        '<span style="color: #27ae60; font-size: 15px;"><b>'+nombre+' ha sido eliminado correctamente <i class="fa fa-check-circle"></i></b></span>'+
                        '</center>').focus();

                       $("#cantPart").html('<b>'+numero+'</b>');

                        $("#cant_"+seccion).html(numero);
                    }

                  });

          }else{
                  $("#mgbody").animate({ opacity: 1});
                  $("#mgmensaje").hide();
                  $("#confirmDel").fadeOut().remove();
          }

         }