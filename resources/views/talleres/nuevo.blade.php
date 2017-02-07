<div  class="modal fade" id="modalCurtall" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center>Agregar nuevo curso o taller</center></h4>
      </div>
      <div class="modal-body" style="max-height: calc(95vh - 200px);
    overflow-y: auto;"> 
              <div class="form-group">
                  <label>Seleccione que desea crear</label>
                  <select class="form-control" v-model="nuevocurtall.tipo">
                      <option v-for="c in curtall" v-bind:value="c.proyecto.abrev">@{{ c.proyecto.denominacion }}</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Nombre del curso o taller</label>
                  <table>
                    <tr>
                      <td style="width: 85%"><input  type="text" v-model="nuevocurtall.titulo" class="form-control" placeholder="Ingrese el nombre del curso o taller"></td>
                      <td style="width: 5%;"><button class="btn btn-xs btn-success" rel="tooltip" v-on:click.prevent="agregarModulo" title="Agregar modulos a este taller"  v-bind:disabled="nuevosModulos.length == 10"><i class="fa fa-plus"></i></button></td>
                      <td style="width: 5%;"><button class="btn btn-xs btn-danger" rel="tooltip" v-on:click.prevent="quitarModulo" title="Agregar modulos a este taller"><i class="fa fa-minus"></i></button></td>
                    </tr>
                  </table>
              </div>
              <div class="form-group" v-if="!agregar">
                <center> <table class="table" style="width: 60%;">
                   <tr>
                     <td style="font-size: 14px;"><strong>UC:</strong> @{{ nuevocurtall.uc }}</td>
                     <td><button class="btn btn-xs btn-primary" @click.prevent="nuevocurtall.uc++"><i class="fa fa-plus"></i></button></td>
                     <td><button class="btn btn-xs btn-danger" @click.prevent="nuevocurtall.uc--" v-bind:disabled="nuevocurtall.uc == 0"><i class="fa fa-minus"></i></button></td>
                     <td style="font-size: 14px;"><strong>HS:</strong> @{{ nuevocurtall.hs }}</td>
                     <td><button class="btn btn-xs btn-primary" @click.prevent="nuevocurtall.hs++" ><i class="fa fa-plus"></i></button></td>
                     <td><button class="btn btn-xs btn-danger" @click.prevent="nuevocurtall.hs--" v-bind:disabled="nuevocurtall.hs == 0"><i class="fa fa-minus"></i></button></td>
                   </tr>
                 </table></center>
              </div>
              <template v-if="agregar">
                    <table class="table table-striped" v-for="(modulo, index) in nuevosModulos" style="margin-bottom: 5px;">
                      <thead>
                        <tr>
                            <th style="width: 90%; padding: 0px;">Modulo @{{ index + 1 }}</th>
                            <th colspan="3" style="width: 5%; text-align: center; padding: 0px;">UC</th>
                            <th colspan="3" style="width: 5%; text-align: center; padding: 0px;">HS</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td><input type="text" v-model="modulo.titulo" class="form-control" placeholder="Ingrese el nombre del curso o taller"></td>                        
                            <td>
                            <strong>@{{ modulo.uc }}</strong>
                            </td>
                            <td style="width: 10px;"><button class="btn btn-xxs btn-primary" @click.prevent="modulo.uc++"><i class="fa fa-plus"></i></button></td>
                            <td style="width: 10px;"><button class="btn btn-xxs btn-danger" @click.prevent="modulo.uc--" v-bind:disabled="modulo.uc == 0"><i class="fa fa-minus"></i></button></td>                     
                            <td>
                            <strong>@{{ modulo.hs }}</strong>
                            </td>
                            <td style="width: 10px;"><button class="btn btn-xxs btn-primary" @click.prevent="modulo.hs++" ><i class="fa fa-plus"></i></button></td>
                            <td style="width: 10px;"><button class="btn btn-xxs btn-danger" @click.prevent="modulo.hs--" v-bind:disabled="modulo.hs == 0"><i class="fa fa-minus"></i></button></td>
                          </tr>                        
                      </tbody>
                    </table>
              </template>
          
      </div>
      <div class="modal-footer">
        <button class="btn btn-xs btn-success" v-on:click="guardarCurtall">Agregar <i class="fa fa-plus"></i></button>  
      </div>
    </div>
  </div>
</div>