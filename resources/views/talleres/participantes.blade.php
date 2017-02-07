<div  class="modal fade" id="modalParticipantes" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Participantes registrados</h4>
        <h4 class="modal-title">@{{ tallerSel.codigo }} - @{{ tallerSel.unidad_curricular }} (@{{ tallerSel.seccion }})</h4>
      </div>
      <div class="modal-body" style="max-height: calc(95vh - 200px);
    overflow-y: auto;"> 
    <form class="form form-inline">
        <div class="form-group">
            <input type="text" name="filtro" 
                    v-bind:disabled="filtro.tipo == 0" 
                    v-on:keydown.esc="filtro.queryPart = ''"
                    class="form-control col-sm-4" 
                    placeholder="Buscar" 
                    v-model="filtro.queryPart">
        </div>
        <div class="form-group">
              <label>Cedula</label>
            <input type="radio" value="1" v-model="filtro.tipo">
        </div>
        <div class="form-group">
              <label>Apellidos</label>
            <input type="radio" value="2" v-model="filtro.tipo">
        </div>
        <div class="form-group">
              <label>Nombres</label>
            <input type="radio" value="3" v-model="filtro.tipo">
        </div>
    </form>
        
            <table class="table table-striped">
              <thead>
                  <tr>
                    <th style="text-align: center;">Nro.</th>
                    <th>Cedula</th>
                    <th>Nombres</th>
                    <th>Inscrito?</th>
                    @if(Permiso::Modificar('curtall'))
                    <th>Asistio?</th>
                    <th>Aprobo?</th>
                    <th>Solvente?</th>
                    @endif
                  </tr>
              </thead>
              <tbody>
                <template v-if="participantes.participantes.length == 0">
                  <tr>
                       <td colspan="7" style="text-align: center; font-size: 15px;">No se han registrado participantes en este taller o curso!</td>
                  </tr>
                </template>
                <template v-else>
                  <tr v-for="(part, index) in participantesFiltrados">
                        <td style="text-align: center;">@{{ index + 1 }}</td>
                        <td>@{{ part.numero_identificacion }}</td>
                        <td>@{{ part.apellidos.toUpperCase() }}, @{{ part.nombres.toUpperCase() }}</td>
                        <td><input type="checkbox" class="form-control" 
                                    v-bind:checked="part.inscrito" 
                                    v-bind:disabled="part.inscrito">
                        </td>
                        @if(Permiso::Modificar('curtall'))
                        <td><input type="checkbox" class="form-control" 
                                    v-bind:disabled="part.aprobado"
                                    v-model="part.asistencia" 
                                    v-on:change="marcarAsistencia(part.id, part.asistencia, index)" 
                                    v-bind:checked="part.asistencia">
                        </td>
                        <td><input type="checkbox" class="form-control" 
                                    v-model="part.aprobado" 
                                    v-on:change="marcarAprobado(part.id, part.aprobado, index)" 
                                    v-bind:checked="part.aprobado" 
                                    v-bind:disabled="!part.asistencia">
                        </td>
                        <td><input type="checkbox" class="form-control" 
                                    v-model="part.solvente"
                                    v-bind:checked="part.solvente"
                                    v-on:change="marcarSolvente(part.id, part.solvente, index)" >
                        </td>
                        @endif
                        @if(Permiso::Imprimir('curtall'))
                        <td v-if="part.inscrito && part.asistencia && part.aprobado && part.solvente">
                          <button 
                            v-on:click="imprimirCertificado(part)"
                            class="btn btn-xs btn-success" 
                            rel="tooltip" 
                            title="Imprimir certificado"><i class="fa fa-print"></i></button>
                        </td>
                        @endif
                  </tr>
                </template>
              </tbody>
            </table>
      </div>
      <div class="modal-footer">
        @if(Permiso::Incluir('curtall'))
      <button id="btnFormAdd" v-on:click="participantes.agregar = true" class="btn btn-xs btn-primary pull-left">Agregar Participante <i class="fa fa-plus"></i></button><div v-if="participantes.agregar" class="form-inline pull-left" id="divpart" style="margin-left:0px;"><input v-model="buscarPart" name="cedula" class="form-control" placeholder="Cedula de Identidad" style="width:200px; margin-left:50px;" type="text"><label style="width: 400px; margin-left:10px; text-align:left;"><span v-if="participantes.participante.existe">@{{ participantes.participante.apellidos }}, @{{ participantes.participante.nombres }}</span></label><button id="btnadd" v-if="participantes.participante.existe || participantes.participante.inscrito" v-on:click="registrarParticipante" v-bind:disabled="!participantes.participante.existe || participantes.participante.inscrito" rel="tooltip" title="Agregar" class="btn btn-xs btn-success"><i class="fa fa-save"></i></button><button v-on:click="participantes.agregar = false" rel="tooltip" title="Cancelar" onclick="CancelarAddPart()" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></button>@endif</div></div>
    </div>
  </div>
</div>