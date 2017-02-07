<div  class="modal fade" id="modalGrupos" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Agregar nuevo grupo</center></h4>
      </div>
      <div class="modal-body"> 
          <div class="form-group">
            <label>Pensum</label>
            <select class="form-control" name="pensum">
              <option>Seleccione</option>
              <option value="1">1</option>
            </select>
          </div>
          <div class="form-group" id="modulos" style="display: none;">
          <label>Modulo/Materia</label>
              <select name="modulos" class="form-control" id="selectModulos">

              </select>
          </div>
          <div class="form-group">
            <label>Grupo</label>
            <input type="text" name="grupo" class="form-control">
          </div>
          <div class="form-group">
            <label>Facilitador</label>
            <select name="facilitador" style="width: 100%; height: 10px; font-size: 10px;">
              <option>Seleccione</option>
              @foreach($profesores as $p)
                <option value="{{ $p->id }}">{{ strtoupper($p->apellidos) }}, {{ strtoupper($p->nombres) }} - ({{ number_format($p->numero_identificacion, 0, ",",".") }})</option>
              @endforeach
            </select>
          </div>
          <br>
          <div class="form-group">
              <label>Cantidad cupo maximo</label>
            <input type="number" name="cant" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-xs btn-success" onclick="guardarGrupo();">Agregar <i class="fa fa-plus"></i></button>  
      </div>
    </div>

  </div>
</div>