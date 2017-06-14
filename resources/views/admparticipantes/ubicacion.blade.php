<div  class="modal fade" id="editarDatosUbicacion" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <form class="form-horizontal form-bordered" style="padding: 10px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar ubicacion del participante</h4>
      </div>
      <div class="modal-body" >
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-2" style="text-align: right;">Programa</label>
                        <div class="col-lg-10">
                          <select class="form-control" v-model="nuevaUbicacion.programa">
                              <option disabled>Seleccion el programa  a editar</option>
                              <option v-for="u in ubicaciones">@{{ u.proy }} - @{{ u.sede }} (@{{ u.periodo}})</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-2" style="text-align: right;">Pensum</label>
                        <div class="col-lg-10">
                          <select class="form-control" v-model="nuevaUbicacion.pensum">
                              <option disabled>Seleccion el pensum</option>
                              <option value="1">1</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-2" style="text-align: right;">Periodo</label>
                        <div class="col-lg-10">
                          <select class="form-control" v-model="nuevaUbicacion.sede">
                            <option disabled>Seleccion la sede</option>
                            @foreach(Auth::user()->sedes as $sede)
                            <option value="{{ $sede->id }}">{!! $sede->denominacion !!}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="form-group" style="padding:5px;">
                    <label class="col-lg-2" style="text-align: right;">Periodo</label>
                        <div class="col-lg-10">
                           <select class="form-control" v-model="nuevaUbicacion.periodo">
                           <option disabled>Seleccion el periodo</option>
                            @foreach(Auth::user()->periodos as $p)
                            <option value="{{ $p->id }}">{!! $p->nom_periodo !!}</option>
                            @endforeach
                          </select>
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