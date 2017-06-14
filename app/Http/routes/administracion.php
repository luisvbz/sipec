<?php //Rutas para el modulo de administracion

Route::group(['prefix' => 'administracion','middleware' => array('auth', 'role:SA|Admin|Asistente')], function () {

    Route::get('/participantes', array('as' => 'adm.participantes', 
                                'middleware' => array('modulo:admparticipantes', 'ver:admparticipantes'),'uses' => 'AdministracionController@getAllParticipantes'));

    Route::post('/participantes', array('as' => 'filtrar.participantes', 
                                'middleware' => array('modulo:admparticipantes', 'buscar:admparticipantes'),'uses' => 'AdministracionController@buscarParticipante'));

    Route::post('/participantes/guardar', array('as' => 'guardar.participantes', 
                                'middleware' => array('modulo:admparticipantes', 'incluir:admparticipantes'),'uses' => 'AdministracionController@guardarParticipante'));

    Route::post('/participantes/guardarubicacion', array('as' => 'guardar.participantesubicacion', 
                                'middleware' => array('modulo:adm', 'incluir:admparticipantes'),'uses' => 'AdministracionController@guardarParticipanteUbicacion'));

    Route::post('/participantes/actdatosbasicos', array('as' => 'act.datosBasicos', 
                                'middleware' => array('modulo:admparticipantes', 'modificar:admparticipantes'),'uses' => 'AdministracionController@updateDatosBasicos'));

     Route::post('/participantes/cargarUbiPart', array('as' => 'cargar.ubiPart', 
                                'middleware' => array('modulo:admparticipantes', 'ver:admparticipantes'),'uses' => 'AdministracionController@cargarUbiPart'));

    Route::post('/buscarCne', array('as' => 'buscar.cne', 
                                'middleware' => array('modulo:adm', 'buscar:admparticipantes'),'uses' => 'AdministracionController@buscarCne'));

    /// Programas

     Route::get('/programas/{abrev_proy}/{abrev_sede}', array('as' => 'adm.programas', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'buscar:admprogramas'),'uses' => 'AdministracionController@programas'));

     Route::post('/cargar/proyectos', array('as' => 'adm.proyectos', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas'),'uses' => 'AdministracionController@cargarProyectos'));

    Route::post('/cargar/secciones', array('as' => 'adm.secciones', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas'),'uses' => 'AdministracionController@cargarSecciones'));

  	 Route::post('/cargar/participantes', array('as' => 'buscar.participantes', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'buscar:admprogramas'),'uses' => 'AdministracionController@cargarParticipantes'));

     Route::post('/copiar/participantes', array('as' => 'copiar.participantes', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'incluir:admprogramas'),'uses' => 'AdministracionController@copiarParticipantes'));

    Route::post('/cargarnota', array('as' => 'cargar.notas', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'incluir:admprogramas'),'uses' => 'AdministracionController@cargarNota'));

    Route::post('/participanteAjax', array('as' => 'ajax.part', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'buscar:admprogramas'),'uses' => 'AdministracionController@ajaxParticipante'));

    Route::post('/addParticipanteAjax', array('as' => 'ajax.part', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'incluir:admprogramas'),'uses' => 'AdministracionController@GuardarParticipanteSeccion'));

    Route::post('/quitarParticipante', array('as' => 'quitar.part',
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'eliminar:admprogramas'), 'uses' => 'AdministracionController@quitarParticipante'));

    Route::post('/reportes/listadopart', array('as' => 'lista.part',
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'imprimir:admprogramas'), 'uses' => 'AdministracionController@listadoParticipantes'));

    Route::post('/reportes/notasdef', array('as' => 'notas.part',
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'imprimir:admprogramas'), 'uses' => 'AdministracionController@notasDefParticipantes'));

    Route::post('/reportes/pdf', array('as' => 'lista.pdf',
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'imprimir:admprogramas'), 'uses' => 'AdministracionController@listadoParticipantes'));

    Route::post('/cargarmodulos', array('as' => 'cargar.modulos', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'incluir:admprogramas'),'uses' => 'AdministracionController@cargarModulos'));

    Route::post('/guardarGrupo', array('as' => 'guardar.grupo', 
                                'middleware' => array('modulo:adm', 'ver:admprogramas', 'incluir:admprogramas'),'uses' => 'AdministracionController@guardarGrupo'));

    Route::post('/eliminarGrupo', array('as' => 'eliminar.grupo', 
                                'middleware' => array('role:SA|Admin','modulo:adm', 'ver:admprogramas', 'eliminar:admprogramas'),'uses' => 'AdministracionController@eliminarGrupo'));

    /// Cursos y talleres

    Route::get('/curtall/{abrev_sede}', array('as' => 'cursos.talleres', 
                                'middleware' => array('modulo:adm', 'ver:curtall'),'uses' => 'CursosyTalleresController@index'));

    Route::post('/cargarTallares', array('as' => 'cargar.talleres', 
                                'middleware' => array('modulo:adm', 'ver:curtall'),'uses' => 'CursosyTalleresController@cargaTalleres'));

    Route::post('/cargarSelectCurtall', array('as' => 'cargar.select', 
                                'middleware' => array('modulo:adm', 'ver:curtall'),'uses' => 'CursosyTalleresController@cargarSelectCurTall'));

    Route::post('/cargarCurtall', array('as' => 'cargar.curtall', 
                                'middleware' => array('modulo:adm', 'ver:curtall'),'uses' => 'CursosyTalleresController@cargarCurtall'));

    Route::post('/guardarCurtall', array('as' => 'guardar.curtall', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'incluir:curtall'),'uses' => 'CursosyTalleresController@guardarCurtall'));

    Route::post('/aperturarCurtall', array('as' => 'aperturar.curtall', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'incluir:curtall'),'uses' => 'CursosyTalleresController@guardarSeccion'));

     Route::post('/cargarParticipantes', array('as' => 'cargar.part', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'buscar:curtall'),'uses' => 'CursosyTalleresController@cargarParticipantes'));

     Route::post('/buscarParticipante', array('as' => 'buscar.part', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'buscar:curtall'),'uses' => 'CursosyTalleresController@buscarParticipante'));

     Route::post('/registrarParticipante', array('as' => 'registar.part', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'incluir:curtall'),'uses' => 'CursosyTalleresController@registrarParticipante'));

     Route::post('/marcarAsistencia', array('as' => 'marcar.asistencia', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'modificar:curtall'),'uses' => 'CursosyTalleresController@marcarAsistencia'));

     Route::post('/marcarAprobado', array('as' => 'marcar.aprobado', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'modificar:curtall'),'uses' => 'CursosyTalleresController@marcarAprobado'));

     Route::post('/marcarSolvente', array('as' => 'marcar.solvente', 
                                'middleware' => array('modulo:adm', 'ver:curtall', 'modificar:curtall'),'uses' => 'CursosyTalleresController@marcarSolvente'));


    });