@extends('layouts.base')

@section('titulo')
    Sipec - Usuarios
@stop

@section('modulo')
    Usuarios<br>/
    <small>Editar Ususario</small>
@stop

@section('contenido')
			{!! Form::open(array('route' => 'modificar.usuario','method' => 'post','class' => 'form-inline'))!!}
<div class="row">
	<div class="col-lg-12">
    @if(Session::has('mensaje'))
  <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <strong>Well done!</strong> {!! Session::get('mensaje') !!}.
  </div>
  @endif
		<div class="panel panel-info">
			<div class="panel-heading">
				Datos basicos del usuario
			</div>
			<div class="panel-body">
				<div class="form-group">
					{!! Form::text('user', $user->user, array('class' => 'form-control','placeholder' => 'Cedula' ,'id' => 'cedula')) !!}
					<input type="hidden" name="id" value="{{ $user->id }}">
					@if($errors->has('user'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('user') }}</span>
                         @endif
				</div>
				<div class="form-group">
					{!! Form::text('apellidos', $user->apellidos, array('class' => 'form-control', 'placeholder' => 'Apellidos','id' => 'apellidos')) !!}
					@if($errors->has('apellidos'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('apellidos') }}</span>
                         @endif
				</div>
				<div class="form-group">
					{!! Form::text('nombre', $user->nombre, array('class' => 'form-control', 'placeholder' => 'Nombres','id' => 'nombres')) !!}
					@if($errors->has('nombre'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('nombre') }}</span>
                         @endif
				</div>
				<div class="form-group">
					{!! Form::text('telefono', $user->telefono, array('class' => 'form-control', 'placeholder' => 'telf: Ej: 0424-1234567','id' => 'telefono')) !!}
					@if($errors->has('telefono'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('telefono') }}</span>
                         @endif
				</div>
				<div class="form-group">
					<select class="form-control" name="rol">
						@foreach($user->rol as $rol)
						<option value="{{ $rol->id }}">{!! $rol->display_name !!}</option>
						@endforeach
						@foreach($roles as $rol)
						<option value="{{ $rol->id }}">{!! $rol->display_name !!}</option>
						@endforeach
					</select>
					@if($errors->has('rol'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('rol') }}</span>
                         @endif
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					{!! Form::text('email', $user->email, array('class' => 'form-control','placeholder' => 'Correo electronico' ,'id' => 'email')) !!}
					@if($errors->has('email'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('email') }}</span>
                         @endif
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" id="pass1" placeholder="Contraseña"> 
					@if($errors->has('password'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('password') }}</span>
                         @endif
				</div>
				<div class="form-group">
					<input type="password" name="pass2" class="form-control" id="pass2" placeholder="Contraseña"> 
					@if($errors->has('pass2'))
                             <span style="color: #b94a48;" class="help-block error">{{ $errors->first('pass2') }}</span>
                         @endif
				</div>
			<div class="form-group">
				<label>Activar</label>
					{!! Form::checkbox('activar', null, array('class' => 'form-control', 'id' => 'activo')) !!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
<div class="col-lg-4">
  <div class="panel panel-warning">
        <div class="panel-heading">
          Asignar sedes
        </div>
        <div class="panel-body">
        <div class="form-group">
            <select class="form-control" id="ssede">
              <option value="0">Seleccione</option>
              @foreach($sedes as $sede)
                <option value="{{ $sede->id }}">{!! $sede->denominacion !!}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <a id="add-sede" class="add-sede btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
          </div>
        </div>
        <table class="table table-stripped" id="tbsede">
          @foreach($user->sedes as $sede)
            <tr>
              <td style="width: 90%;"><input id="sede_{{ $sede->id }}" type="hidden" name="sede[]" value="{{ $sede->id }}">{!! $sede->denominacion !!}</td>
              <td style="width: 10%;"><a class="delete-sede btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>
          @endforeach
        </table>
  </div>
</div>
<div class="col-lg-4">
  <div class="panel panel-warning">
        <div class="panel-heading">
          Asignar programas
        </div>
        <div class="panel-body">
        <div class="form-group">
            <select class="form-control"  id="sprograma" style="width: 200px;">
              <option value="0">Seleccione</option>
              @foreach($proyectos as $p)
                <option value="{{ $p->id }}">{!! $p->denominacion !!}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <a  id="add-programa" class="add-programa btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
          </div>
        </div>
        <table class="table table-stripped" id="tbprogramas">
            @foreach($user->proyectos as $p)
            <tr>
              <td style="width: 90%;"><input id="programa_{{ $p->id }}" type="hidden" name="programa[]" value="{{ $p->id }}">{!! $p->denominacion !!}</td>
              <td style="width: 10%;"><a class="delete-programas btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>
          @endforeach
        </table>
  </div>
</div>
<div class="col-lg-4">
  <div class="panel panel-warning">
        <div class="panel-heading">
          Asignar periodos
        </div>
        <div class="panel-body">
          <div class="form-group">
            <select class="form-control"  id="speriodo">
              <option value="0">Seleccione</option>
              @foreach($periodos as $p)
                <option value="{{ $p->id }}">{!! $p->nom_periodo !!}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <a  id="add-periodos" class="add-periodos btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
          </div>
        </div>
        <table class="table table-stripped" id="tbperiodo">
           @foreach($user->periodos as $p)
            <tr>
              <td style="width: 90%;"><input id="periodo_{{ $p->id }}" type="hidden" name="periodos[]" value="{{ $p->id }}">{!! $p->nom_periodo !!}</td>
              <td style="width: 10%;"><a class="delete-periodos btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td></tr>
          @endforeach
        </table>
  </div>
</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Asiganción de Modulos y Permisos
			</div>
			<div class="panel-body">
				<table id="tb_modulosypermisos" style="font-size: 12px;" class="table  table-striped">
            <thead style="text-align: center;" class="">
                <tr>
                    <th style="width: 10px">#</th>
                      <th>Modulo</th>
                      <th style="text-align: center;">Pantalla</th>
                      <th style="text-align: center;">Buscar</th>
                      <th style="text-align: center;">Incluir</th>
                      <th style="text-align: center;">Modificar</th>
                      <th style="text-align: center;">Eliminar</th>
                      <th style="text-align: center;">Procesar</th>
                      <th style="text-align: center;">Imprimir</th>
                      <th style="text-align: center;">Anular</th>
                </tr>
            </thead>
            <tbody>
            <?php $n = 1?> 
            @foreach($modulos as $m)
            	<tr>
            		@if($m->activo == 't')
            		<td><input type="checkbox" name="modulos[]" value="{{ $m->id }}" checked></td>
            		@else
            		<td><input type="checkbox" name="modulos[]" value="{{ $m->id }}"></td>
            		@endif
            		@if($m->id_arbol == '0')
            			<td>{!! $m->nombre !!}</td>
            		@else
            			<td> -- {!! $m->nombre !!}</td>
            		@endif
            		@if($m->pantalla == TRUE)
            			<td><center><input type="checkbox" name="pantalla_{{ $m->id }}" checked></center></td>
            		@else
            			<td><center><input type="checkbox" name="pantalla_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->buscar == TRUE)
            			<td><center><input type="checkbox" name="buscar_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="buscar_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->incluir == TRUE)
            			<td><center><input type="checkbox" name="incluir_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="incluir_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->modificar == TRUE)
            			<td><center><input type="checkbox" name="modificar_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="modificar_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->eliminar == TRUE)
            			<td><center><input type="checkbox" name="eliminar_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="eliminar_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->procesar == TRUE)
            			<td><center><input type="checkbox" name="procesar_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="procesar_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->imprimir == TRUE)
            			<td><center><input type="checkbox" name="imprimir_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="imprimir_{{ $m->id }}"></center></td>
            		@endif
            		@if($m->anular == TRUE)
            			<td><center><input type="checkbox" name="anular_{{ $m->id }}" checked></center></td>
            		@else
            		<td><center><input type="checkbox" name="anular_{{ $m->id }}"></center></td>
            		@endif
            	</tr>
            @endforeach
            </tbody>
            <table>
			</div>
			<div class="panel-footer">
        <a href="{{ route('seguridad') }}" class="btn btn-sm btn-danger pull-left">Volver</a>
				<input type="submit" class="btn btn-sm btn-success pull-right" value="Actualizar usuario">	
			</div>
		</div>
	</div>

</div>
{!! Form::close() !!}
@endsection
@section('scripts')
  {!! HTML::script('assets/js/funciones/spp.js')!!}
@endsection