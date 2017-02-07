<?php //Rutas para el modulo de seguridad

Route::group(['prefix' => 'seguridad','middleware' => array('auth', 'role:SA|Admin')], function () {
    
    Route::get('/usuarios', array('as' => 'seguridad', 
    							'middleware' => array('modulo:secusrs', 'ver:secusrs'),'uses' => 'UsuariosController@index'));

    Route::get('/usuarios/nuevo', array('as' => 'crear.usuario', 
    							'middleware' => array('modulo:secusrs', 'ver:secusrs', 'incluir:secusrs'),'uses' => 'UsuariosController@nuevo'));

    Route::post('/usuarios/nuevo', array('as' => 'guardar.usuario', 
                                'middleware' => array('modulo:secusrs', 'incluir:secusrs'),'uses' => 'UsuariosController@guardar'));

    Route::get('/usuarios/{id}', array('as' => 'editar.usuario', 
                                'middleware' => array('modulo:secusrs', 'modificar:secusrs'),'uses' => 'UsuariosController@editar'));

    Route::post('/usuarios/modificar', array('as' => 'modificar.usuario', 
                                'middleware' => array('modulo:secusrs', 'incluir:secusrs'),'uses' => 'UsuariosController@modificar'));

    Route::post('/usuarios/busqueda', array('as' => 'buscar.usuario', 
                                'middleware' => array('modulo:secusrs', 'buscar:secusrs'),'uses' => 'UsuariosController@buscar'));

    Route::get('/rolesypermisos', array('as' => 'roles.permisos', 
    							'middleware' => array('modulo:secrols', 'ver:secrols'),'uses' => 'UsuariosController@rolesypermisos'));

    Route::post('/', array('as' => 'user.save', 'uses' => 'UsuariosController@saveUser'));

    Route::post('/listapermisos', 'UsuariosController@permisosAjax');

    Route::post('/cargarpermisos', 'UsuariosController@cargarPermisosAjax');

    Route::post('/agregarpermiso', 'UsuariosController@agregarPermisosAjax');

    Route::post('/cargarPersona', 'UsuariosController@CargarPersonaAjax');



    Route::get('/mantenimiento', array('as' => 'mtto', 'uses' => 'SecurityController@mtto'));
});