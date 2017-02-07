$("#add-sede").click(function(){
		var tbsede = $("#tbsede");
		var sede_val =  $("#ssede  option:selected").val();
		var sede = $("#ssede  option:selected").text();

		if(sede_val == 0){

		}else{
			if(sede_val == $("#sede_"+sede_val).val()){
				jAlert('Esta sede ya ha sido seleccionada', 'Advertencia');
			}else{
				tbsede.append('<tr><td style="width: 90%;"><input id="sede_'+sede_val+'" type="hidden" name="sede[]" value="'+sede_val+'">'+sede+'</td><td style="width: 10%;"><a class="delete-sede btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>');	
			}
			
		}

			$(".delete-sede").click(function(){
			$(this).parent().parent().remove();
		});

	});

			$(".delete-sede").click(function(){
			$(this).parent().parent().remove();
		});



	$("#add-programa").click(function(){
		var tbprogramas = $("#tbprogramas");
		var p_val =  $("#sprograma  option:selected").val();
		var p = $("#sprograma  option:selected").text();

		if(p_val == 0){

		}else{
			if(p_val == $("#programa_"+p_val).val()){
				jAlert('Este programa ha sido seleccionado', 'Advertencia');
			}else{
			tbprogramas.append('<tr><td style="width: 90%;"><input id="programa_'+p_val+'" type="hidden" name="programa[]" value="'+p_val+'">'+p+'</td><td style="width: 10%;"><a class="delete-programas btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>');
			}
		}

		$(".delete-programas").click(function(){
			$(this).parent().parent().remove();
		});

	});

	$(".delete-programas").click(function(){
			$(this).parent().parent().remove();
		});




	$("#add-periodos").click(function(){
		var tbperiodo = $("#tbperiodo");
		var per_val =  $("#speriodo  option:selected").val();
		var per = $("#speriodo  option:selected").text();

		if(per_val == 0){

		}else{
			if(per_val == $("#periodo_"+per_val).val()){
				jAlert('Este periodo ya ha sido seleccionado', 'Advertencia');
			}else{
			tbperiodo.append('<tr><td style="width: 90%;"><input id="periodo_'+per_val+'" type="hidden" name="periodos[]" value="'+per_val+'">'+per+'</td><td style="width: 10%;"><a class="delete-periodos btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>');	
			}
		}

		$(".delete-periodos").click(function(){
			$(this).parent().parent().remove();
		});
		

	});

	$(".delete-periodos").click(function(){
			$(this).parent().parent().remove();
		});
