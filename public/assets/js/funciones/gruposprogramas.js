function nuevoGrupo(){

		var sede = $("#sede").val();
		var programa = $("#sprograma").val();
		var periodo = $("#periodo").val();

		if(sede == null || programa == null || periodo == null)	{

				jAlert("Debes elegrir la Sede, el Programa y el Proyecto para poder crear un nuevo grupo o seccion!");
		}else{

			$("#modalGrupos").modal();		
		}

		
	
}

 $('select[name="facilitador"]').select2({
        placeholder: "Seleccione",
        allowClear: true
});

 $('select[name="pensum"]').change(function(){

 	var pensum = $(this).val();
 	var programa = $("#sprograma").val();
 	var smodulos = $("#selectModulos");
 	var modulos = $("#modulos");
 	
 	$.ajax({
        data: { pensum: pensum, programa: programa},
        type: 'post',
        url: '/administracion/cargarmodulos',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
         // $("#modulos").html('<img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){

        	 for (var i = 0; i < data.length; i++) {

        		var posicion = data[i][2];
        		var n = parseInt([i])+1;

        		//console.log("#m"+n+' '+"<optgroup label='Modulo "+n+"' id='m"+n+"'></optgroup>");
        		switch(posicion) {
				    case n:
				        smodulos.append("<optgroup label='Modulo "+n+"' id='m"+n+"'></optgroup>");
				        $("#m"+n).append("<option value='"+data[i][5]+"/"+data[i][0]+"'>"+data[i][5]+' - '+data[i][4]+"</option>")
				        break;
				    default:
				        break;
				}

        	}

        	modulos.show();
        }

      });


 });

function guardarGrupo(){

	var sede = $("#sede").val();
	var programa = $("#sprograma").val();
	var periodo = $("#periodo").val();
	var periodo_text = $("#periodo :selected").text();
	var pensum = $('select[name="pensum"]').val();
	var modulo = $('select[name="modulos"]').val();
	var facilitador = $('select[name="facilitador"]').val();
	var grupo = $('input[name="grupo"]').val();
	var cantidad = $('input[name="cant"]').val();

	$.ajax({
        data: { sede: sede, programa: programa, periodo:periodo, periodo_text: periodo_text,  pensum: pensum, modulo: modulo, facilitador:facilitador, grupo: grupo, cantidad: cantidad},
        type: 'post',
        url: '/administracion/guardarGrupo',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
         // $("#modulos").html('<img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){

        	if(data[0]['tipo'] == 0){

        	}else{

        		$("#tb_programas tbody").append('<tr>'+
                '<td><input type="radio" value="'+data[1][7]+'" name="rdseccion"></td>'+
                '<td style="text-align: center" id="pensum_'+data[1][7]+'">'+data[1][0]+'</td>'+
                '<td>'+data[1][1]+'</td>'+
                '<td id="cod_'+data[1][7]+'">'+data[1][2]+'</td>'+
                '<td>'+data[1][3]+'</td>'+
                '<td id="mod_'+data[1][7]+'">'+data[1][4]+'</td>'+
                '<td id="grupo_'+data[1][7]+'"style="text-alig:center;">'+data[1][5]+'</td>'+
                '<td>'+data[1][6]+'</td>'+
                '<td>0/<span id="cant_'+data[1][7]+'">0</span><input type="hidden" value="'+data[1][8]+'" id="materia_'+data[1][7]+'"></td>'+
                '<td><a style="color:#c0392b; text-decoration:none; font-size: 18px;" href="javascript:;" onclick="eliminarSeccion('+data[1][7]+');"><i class="fa fa-trash-o"></i></a></td>'+	
                '</tr>');
        	}

        	$("#modalGrupos").modal("hide");


        	$("#mensajeJS").html('<div class="alert alert-success">'+
								      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
								      '<strong>La sección se ha creado con exito </strong>'+
								  '</div>');

        	
        }



});
}

function eliminarSeccion(id_seccion){

	 var fila = $("#grupo_"+id_seccion).parent();

	swal({title: "Estas seguro(a)?",
		text: "Deseas eliminar esta seccion?",   
		type: "warning",   showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Sí, Borrar!",   
		cancelButtonText: "No, Cancelar!",   
		closeOnConfirm: false,   closeOnCancel: false }, 
		function(isConfirm){   
		if (isConfirm) {  

		   $.ajax({
        data: { id_seccion: id_seccion},
        type: 'post',
        url: '/administracion/eliminarGrupo',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
         // $("#modulos").html('<img id="loader" alt="" src="/assets/images/loaders/loader1.gif>');
        }, 
        success: function(data){

        	fila.fadeOut();

			swal("Borrado!", "La seccion de borrado exitosamente!", "success");

			console.log(data);

		}

		});

		} else {     
		swal("Cancelado","No se ha borrado la sección", "error");   
	} 
});
}