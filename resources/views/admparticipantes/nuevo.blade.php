<div  class="modal fade" id="nuevoParticipante" role="dialog" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="padding: 0px;">
    <!-- Modal content-->
    <div class="modal-content">
    <section>
        <div v-if="loadCne" style="position: absolute; top: 200px; left: 400px;">
          <i class="fa fa-circle-o-notch fa-spin spinner"></i>
          <center><h5>Buscandos datos ...</h5></center>
        </div>
        <div v-if="saving" style="position: absolute; top: 200px; left: 400px;">
          <i class="fa fa-circle-o-notch fa-spin spinner"></i>
          <center><h5>Registrando participante ...</h5></center>
        </div>
        <div class="wizard" :style="loadCne || saving ? 'opacity: 0.2': ''">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#paso1" data-toggle="tab" aria-controls="paso1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="fa fa-graduation-cap"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="paso1">
                    <h4>Paso 1</h4>
                        <p>Datos básicos</p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="from-group">
                            <label>Cedula</label>
                            <input type="text" class="form-control" v-model="post.datos_personales.cedula" v-on:keydown.enter="buscarCne">
                          </div>
                          <div class="from-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" v-model="post.datos_personales.apellidos">
                          </div>
                          <div class="from-group">
                            <label>Fecha de nacimineto</label>
                            <input type="text" class="form-control hasDatepicker" id="fecnac"  v-model="post.datos_personales.fecnac">
                          </div>
                          <div class="from-group">
                            <label>Estado civil</label>
                            <select class="form-control" v-model="post.datos_personales.edo_civil">
                              <option value="1">Soltero(a)</option>
                              <option value="2">Casado(a)</option>
                              <option value="3">Viudo(a)</option>
                              <option value="4">Divorciado(a)</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="from-group">
                            <label>Sexo</label>
                            <select class="form-control" style="width:30%;" v-model="post.datos_personales.sexo">
                              <option value="M">Masculino</option>
                              <option value="F">Femenino</option>
                            </select>
                          </div>
                          <div class="from-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" v-model="post.datos_personales.nombres">
                          </div>
                          <div class="from-group">
                            <label>Correo electronico</label>
                            <input type="email" class="form-control"  v-model="post.datos_personales.correo">
                          </div>
                          <div class="from-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control"  v-model="post.datos_personales.tlf">
                          </div>
                        </div>
                      </div>
                      <hr>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step" :disabled="!verificarDatos">Continuar</button></li>
                          
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h4>Paso 2</h4>
                        <p>Ubicar al participante</p>
                         <div class="row">
                        <div class="col-md-6">
                          <div class="from-group">
                            <label>Sede</label>
                            <select class="form-control" v-model="sede">
                            <option disabled value="">Seleccione la sede ....</option>
                            @foreach($sedes as $s)
                              <option value="{{ $s->abrev }}">{!! $s->denominacion !!}</option>
                            @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Pensum</label>
                            <select class="form-control">
                              <option value="1">1</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="from-group">
                            <label>Proyecto</label>
                            <select class="form-control" v-model="programa">
                            <option disabled value="">Seleccione el programa ....</option>
                              <option v-for="p in programas" :value="p[0]">@{{ p[1] }}</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Periodo de ingreso</label>
                            <select class="form-control" v-model="post.datos_ubicacion.periodo">
                            <option disabled value="">Seleccione el periodo</option>
                              <option value="{{ Auth::user()->periodos[0]->nom_periodo }}">{!! Auth::user()->periodos[0]->nom_periodo !!}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                        <hr>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Atras</button></li>
                            <li><button type="button" class="btn btn-primary next-step" :disabled="!verificarUbicacion">Continuar</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h4>Paso 3</h4>
                        <p>Verifica los datos del participante antes de guardarlos</p>
                        <hr>
                        <div class="row">
                          <div class="col-lg-8 col-lg-offset-2">
                            <table class="table table-striped">
                              <tr>
                                <td colspan="2" style="text-align: center;"><b>Datos básicos</b></td>
                                <td colspan="2" style="text-align: center;"><b>Datos de ubicación</b></td>
                              </tr>
                              <tr>
                                <td style="text-align: right"><b>Cedula:</b></td>
                                <td>@{{ post.datos_personales.cedula }}</td>
                                <td style="text-align: right"><b>Sede:</b></td>
                                <td>@{{ sede }}</td>
                              </tr>
                              <tr>
                                <td style="text-align: right"><b>Apellidos:</b></td>
                                <td>@{{ post.datos_personales.apellidos }}</td>
                                <td style="text-align: right"><b>Programa:</b></td>
                                <td>@{{ programa }}</td>
                              </tr>
                              <tr>
                                <td style="text-align: right"><b>Nombres:</b></td>
                                <td>@{{ post.datos_personales.nombres }}</td>
                                <td style="text-align: right"><b>Periodo:</b></td>
                                <td>@{{ post.datos_ubicacion.periodo  }}</td>
                              </tr>
                              <tr>
                                <td style="text-align: right"><b>Sexo:</b></td>
                                <td>@{{ post.datos_personales.sexo }}</td>
                                <td style="text-align: right"><b>Pensum:</b></td>
                                <td>@{{ post.datos_ubicacion.pensum }}</td>
                              </tr>
                               <tr>
                                <td style="text-align: right"><b>Correo:</b></td>
                                <td>@{{ post.datos_personales.correo }}</td>
                                <td></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td style="text-align: right"><b>Telefono:</b></td>
                                <td>@{{ post.datos_personales.tlf }}</td>
                                <td></td>
                                <td></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <hr>
                        <ul class="list-inline pull-right">
                          <li><button type="button" @click="guardar" :disabled="!verificarDatos || !verificarUbicacion" class="btn btn-primary next-step">Finalizar <i class="fa fa-save"></i></button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
    </div>

  </div>
</div>