@extends('layouts.base')

@section('modulo')
    Usuarios<br>/
    <small>Roles y Permisos</small>
@stop

@section('contenido')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
    <div class="panel panel-default ">
              <div class="panel panel-heading">
              <h4 class="panel-title">Lista de Roles</h4>
              </div>
              <div class="panel panel-body" style="padding: 0px;">
              <table class="table table-striped" id="tb_usuarios">
                <thead>
                <th style="width: 10px">#</th>
                  <th>Nombre</th>
                  <th>Nombre en Pantalla</th>
                  <th>Descripcion</th>
                  <th>Acciones</th>
              </thead>
                <tbody>
                <?php $n = 1;?>
                @foreach($roles as $rol)
                  <tr id="rol_{{ $rol->id}}">
                    <td>{!! $n++ !!}</td>  
                    <td>{!! $rol->name !!}</td>  
                    <td id="rname_{{ $rol->id}}">{!! $rol->display_name !!}</td>  
                    <td>{!! $rol->description !!}</td>
                    <th><a onClick="ver_permisos({{$rol->id}});" class="btn btn-primary btn-xs">Ver permisos</a>
                    <a onClick="cargar_permisos({{$rol->id}});" class="btn btn-danger btn-xs">Asignar permisos</a></th> 
                  </tr>
                @endforeach
                
              </tbody></table>
            </div>
            <!-- /.box-header -->
            <div class="panel-footer">
              {!! $roles->render() !!}
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
<div class="modal fade" id="modalPermisos">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="tpermiso"></span></h4>
      </div>
      <div class="modal-body" id="bodypermisos">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cerrar_modal" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{!! csrf_field() !!} 
@endsection

@section('scripts')
<script type="text/javascript">

  function ver_permisos(id_rol) {
    var tb_user = $("#tb_usuarios");
    var rol_name = $("#rname_"+id_rol).text();
    $.ajax({
        data: {id_rol: id_rol},
        url: '/usuarios/listapermisos',
        type: 'post',
        dataTye: 'JSON',
         headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        success: function(data){

          if(data.length == 0){
            $('#tpermiso').html(rol_name);
            $('#bodypermisos').html('<li>Este rol no tienes permisos asignados</li>')
            $('#modalPermisos').modal('show');
          }else{

            $('#tpermiso').html(rol_name);
            $('#bodypermisos').html('<table id="tb_permisos" class="table table-striped"></table>');
            for (var i = 0; i < data.length; i++) {
              $('#tb_permisos').append('<tr><td>'+data[i][1]+'</td><td><button class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></td></tr>')
            };
           
            $('#modalPermisos').modal('show');
          }
        }

    }); 

      }


  function cargar_permisos(id_rol){
    var tb_user = $("#tb_usuarios");
    var rol_name = $("#rname_"+id_rol).text();

    $.ajax({
        data: {id_rol: id_rol},
        url: '/usuarios/cargarpermisos',
        type: 'post',
        dataTye: 'JSON',
         headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        success: function(data){
            $('#tpermiso').html(rol_name);
            $('#bodypermisos').html('<table id="tb_permisos" class="table table-striped"></table>');

            if(data.length == 0){
            $('#tpermiso').html(rol_name);
            $('#bodypermisos').html('<tr><td>No hay mas permisos que agregar a este rol</td></tr>')
            $('#modalPermisos').modal('show');
          }else{

            for (var i = 0; i < data.length; i++) {

              $('#tb_permisos').append('<tr><td>'+data[i][1]+'</td><td><button onClick="agregar_permiso('+id_rol+','+data[i][0]+')" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></td></tr>')
            }
          }

            $('#modalPermisos').modal('show');
          }
        });

    }

    function agregar_permiso(id_rol, id_permiso){
      var tb_user = $("#tb_usuarios");
      var rol_name = $("#rname_"+id_rol).text();

      $.ajax({
        data: {id_rol: id_rol, id_permiso: id_permiso },
        type: 'post',
        url: '/usuarios/agregarpermiso',
        headers:
        {
        'X-CSRF-Token': $('input[name="_token"]').val()
        },
        beforeSend: function(){
          console.log('1');
        }, 
        success: function(data){
          console.log(data);
        }

      });
    }

 $('#cerrar_modal').click(function(e){
       $('#tpermiso').html("");
      $('#bodypermisos').html("");

    });

</script>
@endsection