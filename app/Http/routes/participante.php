<?php //Rutas para el modulo de administracion

Route::group(['prefix' => 'participante'], function () {

	Route::get('/', array('as' => 'verificar', 'uses' => 'ParticipantesController@verificar'));

	Route::post('/', array('as' => 'verificar.participante', 'uses' => 'ParticipantesController@verificarParticipante'));

	Route::get('/actacademica', array('as' => 'actacademica', 'uses' => 'ParticipantesController@actuacionAcademica'));

	Route::post('/cargarProgramas', array('as' => 'cargar.actuacion', 'uses' => 'ParticipantesController@cargarProgramas'));

	Route::post('/cargarRecord', array('as' => 'cargar.record', 'uses' => 'ParticipantesController@cargarRecord'));

	Route::post('/printRecord', array('as' => 'print.record', 'uses' => 'ParticipantesController@PrintRecord'));

	Route::get('salir', array('as' => 'logout.part', 'uses' => 'ParticipantesController@salir'));


});