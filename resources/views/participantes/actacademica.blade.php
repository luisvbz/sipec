@extends('layouts.base')

@section("meta")
<meta id="token" name="token" value="{{ csrf_token() }}">
@endsection

@section('titulo')
    Sipec - Programas
@stop

@section('modulo')
    Mis proyectos y Cursos/Talleres<br>/
    <small>Lista de Programas</small>
@stop


@section('contenido')
<div id="app">
<div class="row">
  <div class="col-lg-6"  v-cloak v-if="programas.length > 0">
    <div class="panel panel-success">
      <div class="panel-heading">
        Mis programas
      </div>
      <div class="panel-body">
        <form v-on:submit.prevent="verRecord(programa_selected)" >
          <div class="form-group">
          <label>Seleccione el Programa</label>
          <select class="form-control" v-model="programa_selected">
         <option disabled value="">Seleccione ...</option>
            <option v-for="programa in programas"  :value="programa.abrev_proyec">
              @{{ programa.abrev_proyec}} - @{{ programa.proy }} - (@{{ programa.sede }}) - @{{ programa.periodo }}
            </option>
          </select>
          </div>
          <div class="form-group">
            <center><button type="submit"
                class="btn btn-xs btn-success">VER RECORD ACADÉMICO 
                <i class="fa fa-search"></i>
           </button></center>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6"  v-cloak v-if="talleres.length > 0">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Mis cursos y talleres
      </div>
      <div class="panel-body">
         <div class="form-group">
          <form >
          <label>Seleccione el curso o taller:</label>
          <select class="form-control" v-model="curtall_selected">
             <option disabled value="">Seleccione ...</option>
            <option v-for="taller in talleres" :value="taller">
             <template v-if="taller.tipo == 'C'">
              Curso: @{{ taller.abrev_proyec}}  - (@{{ taller.sede }}) - @{{ taller.periodo }}
             </template>
             <template v-else>
              Taller: @{{ taller.abrev_proyec}}  - (@{{ taller.sede }}) - @{{ taller.periodo }}
             </template>
            </option>
          </select>
         </div>
         <div class="form-group">
           <center>
               <button v-if="canPrint" type="submit" @click="imprimirCert(curtall_selected)"
                    class="btn btn-xs btn-success">IMPRIMIR CERTIFICADO 
                    <i class="fa fa-print"></i> 
               </button>
               <button v-else disabled
                    class="btn btn-xs btn-success">IMPRIMIR CERTIFICADO 
                    <i class="fa fa-print"></i> 
               </button>

           </center>
         </div>
         </form> 
      </div>
    </div>
  </div>
    <div class="row" v-if="loadRecord" v-cloak >
      <center>
        <i class="fa fa-refresh fa-spin spinner"></i><br> 
        <h4>Cargando record académico ...</h4>
      </center>
    </div>
    <div class="row" v-if="verNotas" v-cloak >
      @include('participantes.record')
    </div>
    <div class="row" v-if="verInfoTaller" v-cloak >
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            Información actual del curso
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Curso o Taller</th>
                    <th style="text-align:center;">Inscrito</th>
                    <th style="text-align:center;">Asistente</th>
                    <th style="text-align:center;">Aprobado</th>
                    <th style="text-align:center;">Solvente</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>@{{ curtall_selected.abrev_proyec }}</td>
                     <td class="check_text"  v-if="curtall_selected.inscrito"><span><i class="fa fa-check"></i></span></td>
                     <td v-else></td>
                     <td class="check_text"  v-if="curtall_selected.asistencia"><span><i class="fa fa-check"></i></span></td>
                     <td v-else></td>
                     <td class="check_text"  v-if="curtall_selected.aprobado"><span><i class="fa fa-check"></i></span></td>
                     <td v-else></td>
                     <td class="check_text"  v-if="curtall_selected.solvente"><span><i class="fa fa-check"></i></span></td>
                     <td v-else></td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
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
      talleres: [],
			secciones: [],
			participante: {cedula: '', nombre: '', programa: '', pensum: '', sede: '', periodo: ''},
      infodef: {uca: 0, ucc: 0, pac: 0, paa: 0, ia: 0, iaa: 0},
			abrev: "",
      programa_selected: '',
      curtall_selected: '',
      canPrint: false,
      verNotas: false,
      loadRecord: false,
      verInfoTaller: false
		},
		mounted : function(){
				this.getRecord();
		},
    computed: {
      checkPrint: function(taller){

          if(taller.inscrito && taller.asistencia && taller.aprobado && taller.solvente){
            return true;
          }
      }
    },
    watch: {

      curtall_selected: function(){
        var taller = this.curtall_selected;
        if(taller.inscrito && taller.asistencia && taller.aprobado && taller.solvente){
           this.canPrint = true;
          }
        this.verNotas = false;
        this.verInfoTaller = true;  
      }

    },
		methods : {
      imprimirCert: function(taller){
        alert("a");
        console.log(taller);
      },
			getRecord:function(){

				this.$http.post('/participante/cargarProgramas').then(function(response){
				
        if(response.data[0].length == 0){
          
        }else{
            for (var i = 0; i < response.data[0].length; i++) {
                  var data = response.data[0][i];
                  this.programas.push(data);
          }
        }

        if(response.body[1].length == 0){

        }else{
            for (var i = 0; i < response.data[1].length; i++) {
            var data = response.data[1][i];
            this.talleres.push(data);
          }
        }

          
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
					var input = abrev;
          this.abrev = abrev;
          this.verNotas = false;
          this.verInfoTaller = false;
          this.loadRecord = true;
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

              this.loadRecord = false;
						  this.verNotas = true;
					});
			//	}
				
			}
		}

		})
</script>

@endsection