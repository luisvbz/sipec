<div  class="modal fade" id="aperturarCurtall" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Aperturar curso o taller</center></h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Curso:</label>
              <input type="radio" value="C" v-model="tipo">
              <label>Taller:</label>
              <input type="radio" value="T" v-model="tipo">
          </div>
          <div class="form-group">
            <label>Facilitador:</label>
              <select class="form-control" v-model="nuevaApertura.profesor">
                  <option value="">Seleccione</option>
                  @foreach($profesores as $p)
                    <option value="{{ $p->id}}">{!! strtoupper($p->apellidos) !!}, {!! strtoupper($p->nombres) !!} ({!! $p->numero_identificacion !!})</option>
                  @endforeach
              </select>
          </div>

          <div class="form-group">
            <label>Curso o taller:</label>
              <select class="form-control" v-model="nuevaApertura.curtall">
                  <option value="">Seleccione</option>
                    <option v-for="talleres in nuevaApertura.talleres" v-bind:value="talleres.id">@{{ talleres.codigo }} - @{{ talleres.unidad_curricular }}</option>

              </select>
          </div>
           <div class="form-group">
            <label>Codigo del taller o curso: <i>Ej: ABC...</i></label>
                <input type="text" class="form-control" placeholder="A, B, C ...." maxlength="1" v-model="nuevaApertura.codigo">
          </div>
          <div class="form-group">
              <table class="table" style="width: 100%;">
                   <tr>
                     <td style="font-size: 12px;">Cantida Maxima: <b>@{{ nuevaApertura.cantidad }}</b></td>
                     <td><button class="btn btn-xxs btn-primary" @click.prevent="nuevaApertura.cantidad++"><i class="fa fa-plus"></i></button></td>
                     <td><button class="btn btn-xxs btn-danger" @click.prevent="nuevaApertura.cantidad--" v-bind:disabled="nuevaApertura.cantidad == 0"><i class="fa fa-minus"></i></button></td>
                </tr>
              </table>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-xs btn-success" v-on:click="guardarApertura">Aperturar <i class="fa fa-plus"></i></button>  
      </div>
    </div>
  </div>
</div>