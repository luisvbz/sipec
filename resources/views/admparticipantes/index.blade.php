@extends('layouts.base')

@section("meta")
<meta id="token" name="token" value="{{ csrf_token() }}">
@endsection

@section('titulo')
    Sipec - Participantes
@stop

@section('modulo')
    Participantes /<br>
    <small style="font-size: 17px">Listado</small>
@stop

@section('contenido')
<div id="app">
<div class="row" v-cloak>
  <div class="col-md-9">
    <div id="panelSecciones" disabled class="panel panel-default ">
    <div class="panel-heading">
      Lista de particpantes: @{{ paginator.total }}
      <div class="pull-right">
          Pagina: <b>@{{ paginator.current }}</b> de <b>@{{ paginator.last_page }}</b> / Mostrando <b>@{{ paginator.per_page }}</b> de <b>@{{ paginator.total }}</b> registros.
      </div>
    </div>
    <div class="panel-body" >
    <table class="table table-striped">
    	<thead>
    		<tr>
                <th>#</th>
    			<th>Cedula</th>
    			<th>Apellidos</th>
    			<th>Nombres</th>
                <th>Acciones</th>
    		</tr>
    	</thead>
    	<tbody>
            <tr v-if="loading">
                <td colspan="5">
                    <center>
                        <i class="fa fa-circle-o-notch fa-spin spinner"></i> 
                        <h4>Cargando....</h4>
                    </center>
                </td>
            </tr>
    		<tr v-for="(p, index) in participantes">
                <td>@{{ index + 1 }}</td>
    			<td>@{{ p.numero_identificacion }}</td>
    			<td>@{{ p.apellidos }}</td>
    			<td>@{{ p.nombres }}</td>
                <td><button class="btn btn-success btn-xs" @click="editarD(p, index)" rel="tooltip" title="Editar datos basicos"><i class="fa fa-edit"></i></button>
                <button class="btn btn-primary btn-xs" @click="editarU(p.numero_identificacion)"><i class="fa fa-map-marker"></i></button>
    		</tr>
    	</tbody>
    </table>
    </div>
    <div class="panel-footer">
    	<button class="btn btn-xs btn-primary" :disabled="paginator.current == 1" @click="getParticipantes(paginator.current - 1)"><i class="fa fa-arrow-left"></i> Anterior</button>
        <button class="btn btn-xs btn-primary pull-right" :disabled="paginator.current == paginator.last_page" @click="getParticipantes(paginator.current + 1)">Siguiente <i class="fa fa-arrow-right"></i></button>
    </div>
	</div>
       </div>
	<div class="col-md-3">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Busqueda
    </div>
    <div class="panel-body">
        <form v-on:submit.prevent="buscarParticipante">
            <div class="form-group">
                <label>Cedula</label>
                <input type="text" v-model="cedula" class="form-control" placeholder="Ej. 1234567">
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" v-model="apellidos" class="form-control" placeholder="Apellido">
            </div>
            <div class="form-group">
            <label>Nombres</label>
                <input type="text" v-model="nombres" class="form-control" placeholder="Nombres">
            </div>
        	<div class="form-group">
        		<button type="submit" class="btn btn-xs btn-success">Buscar participante <i class="fa fa-search"></i></button>
        	</div>
        </form>
	</div>
	</div>
    @if(Permiso::Incluir('admparticipantes'))
      <div class="panel panel-info">
    <div class="panel-heading">
      Nuevo particpante
    </div>
    <div class="panel-body">
    <center><button class="btn btn-xs btn-success" @click="nuevo">Nuevo usuario <i class="fa fa-plus"></i></button></center>
    </div>
    </div>
    @endif
</div>
</div>
@include("admparticipantes.nuevo")
@include("admparticipantes.datosbasicos")
@include("admparticipantes.ubicacion")
</div>

@endsection


@section('scripts')
{!! HTML::script('assets/js/vue.js')!!}
{!! HTML::script('assets/js/vue-resource.min.js')!!}
<script type="text/javascript">
   $(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    //$('#fecnac').datepicker();
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
</script>

<script type="text/javascript">

Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

  new Vue({
    el: '#app',
    name: 'particpantes',
    data: {
      participantes: [],
      paginator: {current: 1, total: 0, per_page: 10, last_page: 0},
      post: {
            datos_personales: {
                    nac: '',
                    cedula: '',
                    sexo: 'M',
                    edo_civil: 1,
                    apellidos: '',
                    nombres: '',
                    fecnac: '',
                    correo: '',
                    tlf: ''
                },
            datos_ubicacion: {
                sede: '',
                programa: '',
                pensum: 1,
                periodo: '',
                }
            },
      participante: {id: null, nac: null, cedula: null, apellidos: null, nombres: null, edo_civil: null, correo: null, cod: null, tlf: null, fecnac: null, sexo: ''},
      loading: false,
      cedula: null,
      apellidos: null,
      nombres: null,
      sede: '',
      programa: '',
      programas: [],
      loadCne: false,
      saving: false,
      ubicaciones: [],
      nuevaUbicacion: {programa: null, pensum: null, periodo: null, sede: null}
    },
    mounted: function(){
        this.getParticipantes(1);
    },
    computed: {

        verificarDatos: function(){
            datos = this.post.datos_personales;

            if(datos.cedula == '' || datos.apellidos == '' || datos.nombres == '' || datos.fecnac == '' || datos.correo == '' || datos.tlf == ''){

                return false;

            }else{

                return true;
            }
        },

        verificarUbicacion: function(){

            datos = this.post.datos_ubicacion;

            datos.sede = this.sede;
            datos.programa = this.programa;

            if(datos.sede == '' || datos.programa == '' || datos.pensum == '' || datos.periodo == ''){

                return false;

            }else{
                return true;

            }
        }
    },
    watch: {
        sede: function(){
            this.programas = [];
            this.$http.post('/administracion/cargar/proyectos', {id_sede: this.sede}).then(function(response){
                
                for (var i = 0; i < response.body.length; i++) {
                    this.programas.push(response.body[i]);
                };
            }, function(response){

            })
        }
    },
    methods: {
        getParticipantes: function(current){
            this.participantes = [];
            this.loading = true;
            this.$http.get('/administracion/participantes?page='+current).then(function(response){

                this.paginator.current = response.body.current_page;
                this.paginator.total = response.body.total;
                this.paginator.per_page = response.body.per_page;
                this.paginator.last_page = response.body.last_page;
                
                for (var i = 0; i < response.body.data.length; i++) {
                    this.participantes.push(response.body.data[i]);
                }
                this.loading = false;

            }, function(response){
                console.log('error');
            });
        },
        buscarParticipante: function(){
             this.participantes = [];
            this.loading = true;
            this.$http.post('/administracion/participantes', {cedula: this.cedula, apellidos: this.apellidos, nombres: this.nombres }).then(function(response){
                 this.paginator.current = response.body.current_page;
                this.paginator.total = response.body.total;
                this.paginator.per_page = response.body.per_page;
                this.paginator.last_page = response.body.last_page;
                
                for (var i = 0; i < response.body.data.length; i++) {
                    this.participantes.push(response.body.data[i]);
                }
                this.loading = false;   
            }, function(response){

            });
        },
        buscarCne: function(){

        this.loadCne = true;
        this.$http.post('/administracion/buscarCne', {cedula: this.post.datos_personales.cedula}).then(function( response){

            var data = response.body;


            this.post.datos_personales.apellidos = data.apellidos;

            this.post.datos_personales.nombres = data.nombres;

            this.post.datos_personales.nac = data.nacionalidad;
            this.post.datos_personales.fecnac = "";
            this.post.datos_personales.correo = "";
            this.post.datos_personales.tlf = "";

            this.loadCne = false;

        }, function(response){

                jAlert("No hay datos para esta cedula, debe ingresar los datos completois", 'Advertencia');
                this.post.datos_personales.apellidos = "";
                this.post.datos_personales.nommbres = "";
                this.loadCne = false;
            });
        },
        nuevo: function(){

            $("#nuevoParticipante").modal("show");
        },
        editarD: function(participante, index){

            this.participante.index = index;
            this.participante.id = participante.id_participante;
            this.participante.nac = participante.nacionalidad;
            this.participante.cedula = participante.numero_identificacion;
            this.participante.apellidos = participante.apellidos;
            this.participante.nombres = participante.nombres;
            this.participante.fecnac = participante.fecha_nacimiento;
            this.participante.edo_civil = participante.edo_civil;
            this.participante.sexo = participante.sexo;
            this.participante.correo = participante.correo;
            this.participante.tlf = participante.telefono;

            $("#editarDatosBasicos").modal("show");
        },
        editarU: function(cedula){
            this.ubicaciones = [];
            this.$http.post('/administracion/participantes/cargarUbiPart', {cedula: cedula}).then(function(response){

                for (var i = 0; i < response.body.length; i++) {
                    this.ubicaciones.push(response.body[i]);
                }
            }, function(response){

            });

            $("#editarDatosUbicacion").modal("show");  
        },
        guardarDatosBasicos: function(){

            this.$http.post('/administracion/participantes/actdatosbasicos', { data: this.participante })
                        .then(function(response){

                            if(response.body.save = true){
                                var index = response.body.index;
                                var data = response.body.part;

                                this.participantes[index].nacionalidad = data.nacionalidad;
                                this.participantes[index].numero_identificacion = data.numero_identificacion;
                                this.participantes[index].apellidos = data.apellidos;
                                this.participantes[index].nombres =  data.nombres;
                                this.participantes[index].fecha_nacimiento = data.fecha_nacimiento;
                                this.participantes[index].edo_civil = data.edo_civil;
                                this.participantes[index].sexo = data.sexo;
                                this.participantes[index].correo = data.correo;
                                this.participantes[index].telefono = data.telefono;

                                jAlert("El participante <b>" + this.participantes[index].nombres +", " +this.participantes[index].apellidos + " </b>fue modificado exitosamente", 'Mensaje');

                                $("#editarDatosBasicos").modal("hide");
                            }

                        }, function(response){


                        })
        },
        guardar: function(){
            datos.sede = this.sede;
            datos.programa = this.programa;

            this.saving = true;
            this.$http.post('/administracion/participantes/guardar', {data: this.post}).then(function(response){
                
                if(response.body.save){
                    jAlert("El particpante ha sido registrado con exito", "Mensaje");
                    this.saving = false;
                    $("#nuevoParticipante").modal("hide");
                }

            }, function(response){

                jAlert("Ocurrio un error al registrar el participante, error "+ response.status);
                this.saving = false;

            })
        }
    }
  });

</script>

@endsection