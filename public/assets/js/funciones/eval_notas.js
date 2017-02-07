var el_actual = 0;
this.valoractual = 0;
this.valornuevo = 0;

function AbrirNota (num_nota, es_directo) {
	$("#mgmensaje").empty();
	$("#mgmensaje").hide();
	if (es_directo) {
		if (el_actual == 0){
			el_actual = num_nota;
		}
		var label_nota = document.getElementById("l_nota_" + el_actual);
		var input_nota = document.getElementById("i_nota_" + el_actual);
		label_nota.style.display = "block";
		input_nota.style.display = "none";	
		el_actual = num_nota;
	}
	var label_nota = document.getElementById("l_nota_" + num_nota);
	var input_nota = document.getElementById("i_nota_" + num_nota);
	label_nota.style.display = "none";
	input_nota.style.display = "block";
	input_nota.value = label_nota.innerHTML;		
	input_nota.focus();
	input_nota.select();
	
	//obtener el valor actual de la nota para evaluar si hay algun cambio en ella
	this.valoractual = document.getElementById("i_nota_" + num_nota).value;
}

function ValidarNota(e, num_nota) {
	var key=e.keyCode || e.which;
	var num_filas = document.getElementById("tbparticipantes").rows.length;;
	var input_nota = document.getElementById("i_nota_" + num_nota);
  
  if (key==27){ // ESC
	  AceptarNota(false, num_nota);
	  return 0;
	  $("#mgmensaje").hide();
  } 

  if ((key==13) || (key==40)) { // ENTER OR KEYDOWN
	  if (!EsNotaValida(input_nota.value)){
		  return 0;
	  }
	  if (el_actual==0){
		  el_actual = num_nota;
	  }
	  el_actual = num_nota + 1;
	  if (el_actual > num_filas) {
		  el_actual = num_filas;
	  }
	  AceptarNota(true, num_nota);
  }
  if (key==38){ // KEYUP
	  if (!EsNotaValida(input_nota.value)){
		  return 0;
	  }
	  el_actual = num_nota - 1;
	  if (el_actual < 1 ) {
		  el_actual = 1;
	  }
	  AceptarNota(true, num_nota);
  }
  
}

function EsNotaValida(valor){
	if (!((valor >= 0 && valor <= 20) || (valor == "AP") || (valor == "RE") || (valor == "SI")) || (valor == "")) {
		$("#mgmensaje").show();
		$("#mgmensaje").html("<center><span style='color: #c0392b; font-size: 15px;'><i class='fa  fa-times-circle'></i>El valor '" + valor + "' no es una nota válida</span></center>");
		return 0;
	}
	return true;
}

function AceptarNota(es_aceptada, num_nota){
	var label_nota = document.getElementById("l_nota_" + num_nota);
	var input_nota = document.getElementById("i_nota_" + num_nota);
	var secc = document.getElementById("notaSeccion").value;
	var part = document.getElementById("notaParticipante_" + num_nota).value;
	var valor = document.getElementById("i_nota_" + num_nota).value;
	
	//obtener el nuevo valor y evaluar si hay algun cambio en ella
	this.valornuevo = document.getElementById("i_nota_" + num_nota).value;
	
	if (es_aceptada) {
		label_nota.innerHTML = input_nota.value;
		if(this.valornuevo!=this.valoractual){
		  // AQUI DEBES GRABAR SEGUN LA FILA (num_nota)
      $('#divu_svnotas').append(rsavenotas(secc, part, valor));
		}
		label_nota.style.display = "block";
		input_nota.style.display = "none";
		
		//reiniciar variables
    this.valoractual = 0;
    this.valornuevo = 0;
    //volver a comenzar
		AbrirNota(el_actual, false);
	} else {
		label_nota.style.display = "block";
		input_nota.style.display = "none";
	}
}

//Ruta guardar nota
function rsavenotas(idsec, idpart, valor){
  return $.ajax({
        data: { idsec: idsec, idpart: idpart, valor: valor },
        type: 'post',
        url: '/administracion/cargarnota',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          
        }, 
        success: function(data){
        	var cedula = data[0]['participante']['numero_identificacion'] 
        	var nombre = data[0]['participante']['apellidos']+' '+data[0]['participante']['nombres']; 

        	$("#mgmensaje").show();
        	$("#mgmensaje").html("<center><span style='color: #27ae60; font-size: 15px;'><i class='fa fa-check-circle'></i> Nota actualizada a: "+nombre+' - '+cedula+"</span></center>")
        }

    });

}
  
		  //alert("guardar-> idsec:"+secc+", idpart:"+part+", valor:"+valor);
  //alert("valor-> actual:"+this.valoractual+", nuevo:"+this.valornuevo);
