<div  class="modal fade" id="editarDatosBasicos" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <form class="form-horizontal form-bordered" style="padding: 10px;" v-on:submit.prevent="guardarDatosBasicos()">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar datos basicos</h4>
      </div>
      <div class="modal-body" >
                    <div class="form-group" style="padding:5px; background-color: #ddd">
                      <label class="col-lg-4">Cedula</label>
                        <div class="col-lg-8">
                          <select class="form-control" name="nac" style="width:40px; position:absolute;" v-model="participante.nac">
                                <option value="V">V</option>
                                <option value="E">E</option>
                          </select>
                        <label style="width:85%;margin-left:50px;">@{{ participante.cedula }}</label>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-4">Apellidos</label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" v-model="participante.apellidos">
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px; background-color: #ddd;">
                    <label class="col-lg-4">Nombres</label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" v-model="participante.nombres">
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-4">Fecha de nacimiento</label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" v-model="participante.fecnac">
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px; background-color: #ddd;">
                    <label class="col-lg-4">Sexo</label>
                        <div class="col-lg-8">
                          <select class="form-control" v-model="participante.sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-4">Estado civil</label>
                        <div class="col-lg-8">
                        <select class="form-control" v-model="participante.edo_civil">
                          <option disabled>Seleccione ...</option>
                          <option value="1">Soltero(a)</option>
                              <option value="2">Casado(a)</option>
                              <option value="3">Viudo(a)</option>
                              <option value="4">Divorciado(a)</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px; background-color: #ddd;">
                    <label class="col-lg-4">Correo electronico</label>
                        <div class="col-lg-8">
                          <input type="email" class="form-control" v-model="participante.correo">
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-4">Teléfono</label>
                        <div class="col-lg-8">
                        <input class="form-control" maxlength="4" style="width:40px; position:absolute;" type="text" v-model="participante.cod">
                        <input style="width:80%;margin-left:50px;"maxlength="7" type="text"  class="form-control" v-model="participante.tlf">
                        </div>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
            <button class="btn btn-xs btn-success" type="submit">Listo <i class="fa fa-save"></i></button>
      </div>
    </div>
    </form>
  </div>
</div>