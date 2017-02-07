@extends('layouts.base')

@section('titulo')
    Sipec - Programas
@stop

@section('modulo')
    Programas<br>/
    <small>Lista de Programas</small>
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
  <div id="mensajeJS">
    
  </div>
    <div id="panelSecciones" disabled class="panel panel-default ">
    <div class="panel-heading">
      Secciones:  <span id="cuantas"></span>
      <span class="pull-right" id="encabezadoBusqueda"></span>
    </div>
    <div class="panel-heading" style="padding: 2px;">
    	<center>
      @if(Permiso::Buscar('admprogramas'))
    	<a id="buscarParticipantes" rel="tooltip" title="Historico de notas" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></a>
      @endif
      @if(Permiso::Imprimir('admprogramas'))
    	<a id="imprimir" data-toggle="tipoImpresion"  href="javascript:;" rel="tooltip"  class="btn btn-xs btn-success"><i class="fa fa-print"></i></a>
      @endif
      @if(Permiso::Incluir('admprogramas'))
    	<a id="add" onclick="nuevoGrupo()" rel="tooltip" title="Agregar grupos" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
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
                       @if(Permiso::Eliminar('admprogramas'))
                      <th></th>
                      @endif
                </tr>
            </thead>
            <tbody>
            
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
    {!! Form::open(array()) !!}
    	<div class="form-group">
    	<label>Sede:</label>
    		<select id="sede" name="sede" class="form-control">
    			<option value="0">Seleccione la sede</option>
    			@foreach($sedes as $s)
    				<option value="{{ $s->abrev }}">{!! $s->denominacion !!}</option>
    			@endforeach
    		</select>
    	</div>
    	<div class="form-group">
    		<img id="loader" style="display:none;" alt="" src="{{ asset('assets/images/loaders/loader1.gif') }}">
    		<div id="programa" style="display:none">
    			<label>Proyecto:</label>
    			<select name="programa" id="sprograma" class="form-control"></select>
    		</div>
    	</div>
    	<div class="form-group pill-right">
    		<label>Periodo:</label>
    		<select id="periodo" name="periodo" class="form-control">
    				@foreach($periodos as $p)
    				<option value="{{ $p->id }}">{!! $p->nom_periodo !!}</option>
    				@endforeach
    		</select>
    	</div>
    	<div class="form-group">
    		<a id="buscarSecciones" class="btn btn-xs btn-success">Consultar <i class="fa fa-search"></i></a>
    		<a href="javascript:location.reload()" class="btn btn-xs btn-danger">Limpiar <i class="fa fa-eraser"></i></a>
    	</div>
    {!! Form::close()!!}
	</div>
	</div>
</div>
</div>
@include('partials.modalLarge')

@include('administracion.reportes.modalListado')

@include('administracion.reportes.modalNotas')

@include('administracion.nuevogrupo')

@endsection

@section('scripts')

<script type="text/javascript">
    var canEliminar = "{{ Permiso::Eliminar('admprogramas') }}";
    var canIncluir = "{{ Permiso::Incluir('admprogramas') }}";
</script>
 {!! HTML::script('assets/js/funciones/administracion.js')!!}
@if(Permiso::Imprimir('admprogramas'))  
 {!! HTML::script('assets/js/funciones/reportesprogramas.js')!!} 
@endif
 {!! HTML::script('assets/js/funciones/gruposprogramas.js')!!}
@if(Permiso::Incluir('admprogramas')) 
 {!! HTML::script('assets/js/funciones/eval_notas.js')!!}
 @endif
@endsection