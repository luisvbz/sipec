@extends('layouts.base')

@section('titulo')
    Usuarios
@stop

@section('modulo')
    Usuarios<br>/
    <small>Lista de Usuarios</small>
@stop

@section('contenido')
<div class="row">
  <div class="col-md-9">
  @if(Session::has('mensaje'))
  <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <strong>Well done!</strong> {!! Session::get('mensaje') !!}.
  </div>
  @endif
    <div class="panel panel-default ">
    <div class="panel-heading">
      Usuarios
    </div>
        <table id="tb_usuarios" style="font-size: 11px;" class="table table-bordered">
            <thead style="text-align: center;" class="">
                <tr>
                    <th style="width: 10px">#</th>
                      <th>Cedula</th>
                      <th>Apellidos</th>
                      <th>Nombres</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>Rol de Usuario</th>
                      <th>Activo</th>
                      <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                    @if(Request::is('seguridad/usuarios/busqueda') AND count($users) == 0)
                      <tr><td colspan="9">
                      <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                               <h5>No se encotraron resultados para la busqueda</h5>
                      </div></td></tr>
                    @else
                    <?php $n = 1;?>
                    @foreach($users as $user)
                      <tr>
                        <td>{!! $n++ !!}</td>  
                        <td>{!! $user->user !!}</td>  
                        <td>{!! $user->apellidos !!}</td>  
                        <td>{!! $user->nombre !!}</td>  
                        <td>{!! $user->email !!}</td>
                        <td>{!! $user->telefono !!}</td>  
                        <td>
                        @foreach($user->rol as $rol)
                          {!! $rol->display_name !!}
                        @endforeach
                        </td>
                        @if($user->is_active == TRUE)
                          <td style="color: #27ae60; font-size:18px; text-align:center;"><i class="fa fa-check-circle"></i></td>  
                        @else
                          <td style="color: #c0392b; font-size:18px; text-align:center;"><i class="fa fa-close"></i></td>  
                        @endif
                        <td style="font-size:18px; text-align:center;">
                        <a href="#"><i class = "fa fa-eye"></i></a> 
                        <a href="{{ route('editar.usuario', $user->id) }}"><i class = "fa fa-edit"></i></a> 
                        <i class = "fa fa-trash-o"></i></td>
                        
                      </tr>
                    @endforeach
                    @endif
                  </tbody>
       </table>
      </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Busqueda <i class="fa fa-tools"></i>
          </div>
          <div class="panel-body">
           {!! Form::open(array('route' => 'buscar.usuario', 'method' => 'POST')) !!}   
            <div class="form-group">
                <label>Cedula</label>
                {!! Form::text('cedula', Input::old('cedula'), array('class' => 'form-control', 'placeholder' => 'Ej. 1234567')) !!}
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                {!! Form::text('apellidos', null, array('class' => 'form-control', 'placeholder' => 'Ingrese uno o ambos apellidos')) !!}
            </div>
            <div class="form-group">
                <label>Nombres</label>
                {!! Form::text('nombres', null, array('class' => 'form-control', 'placeholder' => 'Ingrese uno o ambos nombres')) !!}
            </div>
            <div class="form-group">
                <center><input type="submit" class="btn btn-xs btn-success" value="BUSCAR"></center>
            </div>
           {!! Form::close() !!}
          </div>
        </div>
        @role('SA')
        <div class="panel panel-info">
          <div class="panel-heading">
            Crear nuevo usuario <i class="fa fa-tools"></i>
          </div>
          <div class="panel-body">
            <center><a href="{{ route('crear.usuario')}}" class="btn btn-xs btn-primary">NUEVO USUARIO <i class="fa fa-plus"></i></a></center>
          </div>
        </div>
        @endrole
    </div>
  </div>
@endsection


