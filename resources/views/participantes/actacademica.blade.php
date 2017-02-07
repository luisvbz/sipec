@extends('layouts.base')

@section("meta")
<meta id="token" name="token" value="{{ csrf_token() }}">
@endsection

@section('titulo')
    Sipec - Programas
@stop

@section('modulo')
    Mis proyectos<br>/
    <small>Lista de Programas</small>
@stop


@section('contenido')
<div id="app">
<div class="row">
  <div class="col-md-3" v-for="programa in programas">
      <div class="pr-wrap">
        <table class="pr">
          <tr>
            <th class="pr-g9dd" colspan="5">@{{ programa.abrev_proyec}}</th>
          </tr>
          <tr>
            <td class="pr-baqh" colspan="5">@{{ programa.proy }}<br></td>
          </tr>
          <tr>
            <td class="pr-pi53" colspan="5">SEDE</td>
          </tr>
          <tr>
            <td class="pr-f7xw" colspan="5">@{{ programa.sede }}</td>
          </tr>
          <tr>
            <td class="pr-ir4y" colspan="5">PERIODO<br></td>
          </tr>
          <tr>
            <td class="pr-f7xw" colspan="5">@{{ programa.periodo }}</td>
          </tr>
          <tr>
            <td class="pr-ir4y" colspan="5">
              <button v-on:click="verRecord(programa.abrev_proyec)" class="btn btn-success">VER RECORD ACADÉMICO <i class="fa fa-search"></i></button>
            </td>
          </tr>
        </table>
      </div>
  </div>
</div>
@include('participantes.modalrecord')
</div>


@endsection

@section('scripts')
{!! HTML::script('assets/js/vue.js')!!}
{!! HTML::script('assets/js/vue-resource.min.js')!!}

<script type="text/javascript">

Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

	new Vue({
		el: "#app",
		data:{ 
			programas: [],
			secciones: [],
			participante: {cedula: '', nombre: '', programa: '', pensum: '', sede: '', periodo: ''},
      infodef: {uca: 0, ucc: 0, pac: 0, paa: 0, ia: 0, iaa: 0},
			abrev: ""
		},
		mounted : function(){
				this.getRecord();
		},
		methods : {
			getRecord:function(){

				this.$http.post('/participante/cargarProgramas').then(function(response){
				for (var i = 0; i < response.data.length; i++) {
					var data = response.data[i];
					this.programas.push({'abrev_proyec': data.abrev_proyec, 
										'proy': data.proy , 'sede': data.sede, 
										'periodo': data.periodo});
					};
				});

			},

			verRecord: function(abrev){
			/*	if(this.abrev == ""){
						jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar una programa',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

				}else{ */
          console.log(abrev);
					var input = abrev;
          this.abrev = abrev;
					this.$http.post('/participante/cargarRecord', {abrev: input}).then(function(response){
						this.secciones = [];
            this.infodef =  {uca: 0, ucc: 0, pac: 0, paa: 0, ia: 0, iaa: 0};
						for (var i = 0; i < response.data[0].length; i++) {
							var data = response.data[0][i];

              //Llenando el array de las secciones
							this.secciones.push(data);
						}
            //Llenando la informacion definitiva
              this.infodef.uca = response.data[2].uca;
              this.infodef.ucc = response.data[2].ucc;
              this.infodef.pac = response.data[2].pac;
              this.infodef.paa = response.data[2].paa;
              this.infodef.ia = response.data[2].ia;
              this.infodef.iaa = response.data[2].iaa;


							//Asignando los valores al participante
							this.participante.cedula = response.data[1].cedula;
							this.participante.nombre = response.data[1].participante;
							this.participante.programa = response.data[1].programa;
              this.participante.sede = response.data[0][0].sede;
              this.participante.pensum = response.data[0][0].pensum;
              this.participante.periodo = response.data[0][0].periodo;


						$("#modalRecord").modal("show");
					});
			//	}
				
			}
		}

		})
</script>

@endsection