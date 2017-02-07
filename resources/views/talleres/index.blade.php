@extends('layouts.base')

@section("meta")
<meta id="token" name="token" value="{{ csrf_token() }}">
@endsection


@section('titulo')
    Sipec - Cursos y Talleres
@stop

@section('modulo')
    Cursos y Talleres<br>/
    <small>Lista de Cursos y talleres</small>
@stop


@section('contenido')
<div id="app">
  <div class="row">
    <div class="col-md-9">
    <div class="alert alert-success" v-if="hasMensaje">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" v-on:click="hasMensaje = false">×</button>
        <strong>@{{ mensaje }}</strong>
    </div>

      <div disabled class="panel panel-default ">
      <div class="panel-heading">
        Cursos y talleres:  <span>@{{ talleres.length }}</span>
        <span class="pull-right" id="encabezadoBusqueda"></span>
      </div>
      <div class="panel-heading" style="padding: 2px;">
      	<center>
        @if(Permiso::Buscar('curtall'))
      	<a rel="tooltip" title="Historico de notas" v-on:click="verParticipantes(id_seccion)" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></a>
        @endif
        @if(Permiso::Imprimir('curtall'))
      	<a  data-toggle="tipoImpresion"  href="javascript:;" rel="tooltip"  class="btn btn-xs btn-success"><i class="fa fa-print"></i></a>
        @endif
        @if(Permiso::Incluir('curtall'))
      	<a  class="btn btn-xs btn-success" rel="tooltip" v-on:click="aperturarCurtall" title="Aperturar curso o taller"><i class="fa fa-plus"></i></a>
        @endif
      	</center>
      </div>
      <div class="panel-body">
          <table id="tb_programas" style="font-size: 11px;" class="table table-striped">
              <thead style="text-align: center;" class="">
                  <tr>
                       <th>-</th>
                       <th>Pesum</th>
                        <th>Mod</th>
                        <th>Codigo</th>
                        <th>Sede</th>
                        <th>Modulo</th>
                        <th>Grupos</th>
                        <th>Profesor</th>
                        <th>Cant.</th>
                         @if(Permiso::Eliminar('curtall'))
                        <th></th>
                        @endif
                        @if(Permiso::Modificar('curtall'))
                        <th></th>
                        @endif
                  </tr>
              </thead>
              <tbody>
                <tr v-if="loader" v-for="(taller, index) in talleres">
                    <td><input type="radio" 
                    v-on:click="tallerSel = {codigo: taller.materia.codigo, unidad_curricular: taller.materia.unidad_curricular, seccion: taller.seccion}" 
                    v-bind:value="taller.id"
                    v-model="id_seccion"></td>
                    <td>@{{ taller.materia.pensum }}</td>
                    <td>@{{ taller.materia.sem }}</td>
                    <td>@{{ taller.materia.codigo }}</td>
                    <td>@{{ taller.abrev_sede }}</td>
                    <td>@{{ taller.materia.unidad_curricular }}</td>
                    <td>@{{ taller.seccion }}</td>
                    <td>@{{ taller.profesor.nombres }} @{{ taller.profesor.apellidos }}</td>
                    <td>0</td>
                    @if(Permiso::Modificar('curtall'))
                      <template v-if="taller.status == 1">
                        <td><a style="color:#2980b9; text-decoration:none; font-size: 18px;cursor: pointer;" v-on:click="cerrarCursoTaller(taller.id, index)"><i class="fa fa-unlock"></i></a></td>
                      </template>
                      <template v-else>
                        <td><a style="color:#2980b9; text-decoration:none; font-size: 18px;cursor: pointer;" v-on:click="reabrirCursoTaller(taller.id, index)"><i class="fa fa-lock"></i></a></td>
                      </template>
                    @endif
                    @if(Permiso::Eliminar('curtall'))
                        <td><a style="color:#c0392b; text-decoration:none; font-size: 18px;cursor: pointer;" v-on:click="eliminarCursoTaller(taller.id)"><i class="fa fa-trash-o"></i></a></td>
                    @endif
                </tr>
              </tbody>
              </table>
              </div>
           </div>
         </div>
  	<div class="col-md-3">
    <div class="panel panel-default ">
      <div class="panel-heading">
        Barra de herramientas
      </div>
      <div class="panel-body">
      	<div class="form-group">
      	<label>Sede:</label>
      		<select  class="form-control" v-model="abrev_sede">
      			<option value="0">Seleccione la sede</option>
            @foreach($sedes as $sede)
              <option value="{{ $sede->abrev }}">{!! $sede->denominacion !!}</option>
            @endforeach
      		</select>
      	</div>
      	<div class="form-group pill-right">
      		<label>Año:</label>
      		<select  name="periodo" class="form-control" v-model="anio">
      				<option value="2016">2016</option>
      		</select>
      	</div>
      	<div class="form-group">
      		<a class="btn btn-xs btn-success" v-on:click="getTalleres(abrev_sede, anio)">Consultar <i class="fa fa-search"></i></a>
      		<a class="btn btn-xs btn-danger" v-on:click="clean">Limpiar <i class="fa fa-eraser"></i></a>
      	</div>
      {!! Form::close()!!}
  	</div>

  	</div>
    @if(Permiso::Incluir('curtall'))
    <div class="panel panel-default ">
      <div class="panel-heading">
        Nuevo curso o taller
      </div>
        <div class="panel-body"> 
          <div class="form-group">
              <center><button rel="tooltip" title="Agregar cursos o talleres" v-on:click="nuevoCurtall" class="btn btn-xs btn-primary">Agregar nuevo <i class="fa fa-plus"></i></button></center>
          </div>
        </div>
      </div>
      @endif
  </div>
  </div>
  @include('talleres.nuevo')
  @include('talleres.aperturar')
  @include('talleres.participantes')

   @if(Permiso::Imprimir('curtall'))
    @include('talleres.certificado')
   @endif
</div>

@endsection

@section('scripts')
{!! HTML::script('assets/js/vue.js')!!}
{!! HTML::script('assets/js/vue-resource.min.js')!!}

<script type="text/javascript">

Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

  new Vue({
    el: '#app',
    data: {
      abrev_sede: '0',
      anio: '2016',
      talleres : [],
      loader: false,
      id_seccion: 0, //Id de la seccion
      tallerSel: {codigo: '', unidad_curricular: '', seccion: ''}, //Taller selccionado
      curtall: [],
      tipo: '',// escoger si e curso o taller
      nuevocurtall: {tipo: '', titulo: '', uc: 0, hs: 0},
      participantes: {agregar: false, participantes: [], participante: {idpart: 0, apellidos: '', nombres: '', existe: false, inscrito: false}},
      nuevosModulos: [],
      agregar: false,
      hasMensaje: false,
      mensaje: '',
      buscarPart: '', //Data para buscar participante y agregarlos a los cursos y talleres
      nuevaApertura: {
          talleres: [],
          profesor: 0,
          curtall: 0,
          cantidad: 0,
          sede: '',
          codigo: ''
        },
      filtro: {queryPart: '', tipo: 0} //filtrar los participantes por cedula
    },
    mounted: function(){
     this.loader = true;
    },
    computed: {
        participantesFiltrados: function(){

          var arrayParticipantes = this.participantes.participantes;

          var tipo = this.filtro.tipo;

          var query = this.filtro.queryPart;

          if(!query){
            return arrayParticipantes;

          }

          query = query.trim().toLowerCase();

          if(tipo == 1){

            arrayParticipantes = arrayParticipantes.filter(function(item){

            if(item.numero_identificacion.toLowerCase().indexOf(query) !== -1){

              return item;

            }

          });

          }else if(tipo == 2){

            arrayParticipantes = arrayParticipantes.filter(function(item){

            if(item.apellidos.toLowerCase().indexOf(query) !== -1){

              return item;

            }

          });

          }else{

            arrayParticipantes = arrayParticipantes.filter(function(item){

            if(item.nombres.toLowerCase().indexOf(query) !== -1){

              return item;

            }

          });

          }

          return arrayParticipantes;
        }
    },
    watch:{
        tipo: function(){

          var tipo = this.tipo;
          this.nuevaApertura.talleres = [];
          this.$http.post('/administracion/cargarCurtall', {tipo: tipo}).then(function(response){
                this.nuevaApertura.curtall = [];

                for (var i = 0; i < response.body.length; i++) {

                   this.nuevaApertura.talleres.push(response.body[i]);
                };
          });

        },
        buscarPart: function(){
          this.participantes.participante.existe = false;
          this.participantes.participante.idpart = 0;
          this.participantes.participante.apellidos = '';
          this.participantes.participante.nombres = '';

              if(this.buscarPart.length <= 6){

              }else{
                this.$http.post('/administracion/buscarParticipante', {cedula: this.buscarPart, id_seccion: this.id_seccion }).then(function(response){
                      data = response.body[0][0];
                      inscrito = response.body[1].inscrito;
                     if(data.length == 0){

                      }else{
                        if(inscrito == 0){
                            this.participantes.participante.inscrito = false;
                            this.participantes.participante.existe = true;
                            this.participantes.participante.idpart = data.id;
                            this.participantes.participante.apellidos = data.apellidos;
                            this.participantes.participante.nombres = data.nombres;  
                        }else{
                           this.participantes.participante.inscrito = true;
                           this.participantes.participante.existe = true;
                           this.participantes.participante.idpart = data.id;
                           this.participantes.participante.apellidos = data.apellidos;
                           this.participantes.participante.nombres = data.nombres; 

                            jQuery.gritter.add({
                            title: 'Error!',
                            text: this.participantes.participante.nombres+' '+this.participantes.participante.apellidos+' ya esta inscrito en este curso o taller!',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

                        }
                        
                      }
                      
                });
              }
        }
    },
    methods: {
      getTalleres: function(abrev, anio){

        if(this.abrev_sede == "0" || this.abrev_sede == "" || this.anio == ""){

            jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar la sede y el año a consultar',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

        }else{ 
          
          this.$http.post('/administracion/cargarTallares', {abrev: abrev, anio: anio}).then(function(response){
              this.talleres = [];
              if(response.body.length == 0){
                  jAlert('No se encontro información disponible con esta busqueda!', 'Advertencia');
              }else{
                  for (var i = 0; i < response.body.length ;  i++) {
                  this.talleres.push(response.body[i]);
                  };  
              }

          });
        }
      },
      nuevoCurtall: function(){ //funcion para crear un nuevo curso o taller
        if(this.abrev_sede == "0" || this.abrev_sede == "" || this.anio == ""){

            jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar la sede para poder crear un nuevo curso o taller',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

        }else{ 

        this.$http.post('/administracion/cargarSelectCurtall',  {abrev: this.abrev_sede}).then(function(response){
          this.curtall = [];
          for (var i = 0; i < response.body.length; i++) {

           this.curtall.push(response.body[i])

          }

          $("#modalCurtall").modal('show');

        });
      }

      },
      agregarModulo: function(){ //Funcion para agrager modulo en el formulario

          this.agregar = true;

          this.nuevosModulos.push({titulo: '', uc: 0, hs: 0});
      },

      quitarModulo: function(){ //Remueve modulos del formulario
          
          this.nuevosModulos.splice(0,1);

          if(this.nuevosModulos.length == 0){
              
              this.agregar = false;            
          }
      },
      aperturarCurtall: function(){//funcion para aperturar talleres creados anteriormente

        if(this.abrev_sede == "0" || this.abrev_sede == "" || this.anio == ""){

            jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar para aperturar un curso o taller',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

        }else{ 

            $("#aperturarCurtall").modal("show");

        }

      },
      guardarApertura: function(){

          var profesor = this.nuevaApertura.profesor;
          var cantidad = this.nuevaApertura.cantidad;
          var curtall = this.nuevaApertura.curtall;
          var sede = this.abrev_sede;
          var codigo = this.nuevaApertura.codigo;

          if(this.nuevaApertura.profesor == 0){
              
              jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar un facilitador',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else if(this.nuevaApertura.curtall == 0){

              jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes elegir un curso o taller',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else if(this.nuevaApertura.cantidad == 0){

                jQuery.gritter.add({
                            title: 'Error!',
                            text: 'La cantidad maxima no puede ser igual a 0',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else if(this.nuevaApertura.codigo == ''){

                 jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes escribir el codigo',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else{
              this.hasMensaje = false;
              this.$http.post('/administracion/aperturarCurtall', { profesor: profesor, cantidad: cantidad,curtall: curtall, sede: sede, codigo: codigo}).then(function(response){

              console.log(response.body);

                this.talleres.push(response.body[0]);

                $("#aperturarCurtall").modal("hide");
                this.nuevaApertura.profesor = 0;
                this.nuevaApertura.cantidad = 0;
                this.nuevaApertura.curtall = 0;
                his.nuevaApertura.codigo = '';
                this.hasMensaje = true;
                this.mensaje = "El taller se ha aperturado exitosamente!";

              });

          }
      },
      eliminarCursoTaller: function(id, index){
        alert(id);
      },
      cerrarCursoTaller: function(id, index){

        var r = confirm('Deseas cerrar este curso o taller?');

        if(r){

            this.talleres[index].status = 0;
        }
       

      },
      reabrirCursoTaller: function(id, index){
        this.talleres[index].status = 1;
      },
      guardarCurtall: function(){

          if(this.nuevocurtall.tipo == ''){

            jQuery.gritter.add({
                            title: 'Error!',
                            text: 'Debes seleccionar lo que deseas crear, Curo o Talle',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else if(this.nuevocurtall.titulo == ''){
            jQuery.gritter.add({
                            title: 'Error!',
                            text: 'El curso o taller deben tener un nombre o titulo',
                            sticky: false,
                            time: '',
                            class_name: 'growl-danger',

                     });

          }else{
            this.$http.post('/administracion/guardarCurtall', {padre: this.nuevocurtall, hijos: this.nuevosModulos}).then(function(response){

              $("#modalCurtall").modal('hide');
              this.nuevocurtall = {tipo: '', titulo: '', uc: 0, hs: 0};
              this.nuevosModulos = [];
              this.agregar = false;  
              this.mensaje = "El taller o curso se ha registrado exitosamente!";
              this.hasMensaje = true;
          });  
          }
          
          
      },
      //Functiones de los participantes
      verParticipantes: function(id_seccion){

        this.participantes.participantes = [];
        this.$http.post('/administracion/cargarParticipantes', {id_seccion: id_seccion}).then(function(response){
            
            for (var i = 0; i < response.body.length; i++) {
                  this.participantes.participantes.push(response.body[i]);
            };
              $("#modalParticipantes").modal("show");
        });
          
      },
      registrarParticipante: function(){

          this.$http.post('/administracion/registrarParticipante', {id_seccion: this.id_seccion, id_part: this.participantes.participante.idpart}).then(function(response){

              this.buscarPart = '';
              this.participantes.participantes.push(response.body[0]);
          });
      },
      imprimirCertificado: function(){
        //  $("#modalParticipantes").modal("hide");
          $("#modalCertificaco").modal("show");
      },
      /** Funciones para marcar los checkboxes**/
      marcarAsistencia: function(id, asistencia, index){

           this.$http.post('/administracion/marcarAsistencia', {id_seccion: this.id_seccion, id_part: id, asistencia: asistencia}).then(function(response){
          });

      },
       marcarAprobado: function(id, aprobado, index){

           this.$http.post('/administracion/marcarAprobado', {id_seccion: this.id_seccion, id_part: id, aprobado: aprobado}).then(function(response){
          });

      },
      marcarSolvente: function(id, solvente, index){
          this.$http.post('/administracion/marcarSolvente', {id_seccion: this.id_seccion, id_part: id, solvente: solvente}).then(function(response){
          });
      },
      /** Fin funciones para marcar los checkbox**/
      clean: function(){
            this.abrev_sede = '0';
            this.anio = '2016';
            this.talleres = [];
      }
    }
  });

</script>

@endsection