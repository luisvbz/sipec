<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use sipec\User;
use sipec\Role;
use sipec\Permission;
use Input;
use sipec\Cne;
use sipec\Cne2;
use sipec\Modulo;
use sipec\UserModulos;
use sipec\Sede;
use sipec\Proyecto;
use sipec\Periodo;

class UsuariosController extends Controller
{
   
   public function __construct(){

    $this->middleware('role:SA|Admin');
   }
    public function index()
    {    

           $users = User::orderBy('user', 'ASC')->paginate(7);

        $roles = Role::all();
        
        return view('usuarios.lista', compact('users', 'roles'));
    }

    public function nuevo(){

      $modulos = Modulo::orderBy('sistema_id', 'ASC')
                        ->orderBy('id_padre', 'ASC')
                        ->orderBy('id_arbol', 'ASC')->get();
      $roles = Role::all();

      $sedes = Sede::orderBy('denominacion', 'ASC')->get();

      $proyectos = Proyecto::orderBy('denominacion', 'ASC')->get();

      $periodos = Periodo::orderBy('nom_periodo', 'DESC')->get();

      return view('usuarios.nuevo', compact('modulos', 'roles', 'sedes', 'proyectos', 'periodos'));

    }

    public function guardar(Request $request){

      $validator = \Validator::make($request->all(), [
            'user' => 'required|unique:users',
            'apellidos' => 'required',
            'nombre'  => 'required',
            'email' => 'required|unique:users',
            'telefono' => 'required|unique:users|numeric|min:11',
            'rol' => 'required',
            'password' => 'required|min:8',
            'pass2' => 'required|min:8|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('/seguridad/usuarios/nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }

      //Guardando el Usuario
      $user = new User;
      $user->user = Input::get('user');
      $user->apellidos = Input::get('apellidos');
      $user->nombre = Input::get('nombre');
      $user->email = Input::get('email');
      $user->telefono = Input::get('telefono');
      $user->usr_creador = \Auth::user()->id;
      $user->password = \Hash::make(Input::get('password'));
      $user->is_active = Input::get('activar');
      $user->save();

      //Asignandole el rol
      $user->roles()->attach(Input::get('rol'));

      //Asigancion de sedes

      if(Input::get('sede') != 0){
        $user->sedes()->sync(Input::get('sede'));
      }

      //Asigancion de pryectos

      if(Input::get('programa') != 0){
        $user->proyectos()->sync(Input::get('programa'));
      }

      //Asigancion de periodos

      if(Input::get('periodos') != 0){
        $user->periodos()->sync(Input::get('periodos'));
      }

      //Asigando permisos
      $modulos = count(Input::get('modulos'));
      $mod = Input::get('modulos');

      $data_sync = array();

      for ($i=0; $i < $modulos ; $i++) { 
            echo $i;
        $p = 'pantalla_'.$mod[$i];
        $b = 'buscar_'.$mod[$i];
        $in = 'incluir_'.$mod[$i];
        $modif = 'modificar_'.$mod[$i];
        $del = 'eliminar_'.$mod[$i];
        $pro = 'procesar_'.$mod[$i];
        $imp = 'imprimir_'.$mod[$i];
        $anu = 'anular_'.$mod[$i];

        $pantalla = Input::get($p);
        $buscar = Input::get($b);
        $incluir = Input::get($in);
        $modificar = Input::get($modif);
        $eliminar = Input::get($del);
        $procesar = Input::get($pro);
        $imprimir = Input::get($imp);
        $anular = Input::get($anu);

        if($pantalla == NULL){ $pantalla = FALSE; }
        if($incluir == NULL){ $incluir = FALSE; }
        if($modificar == NULL){ $modificar = FALSE; }
        if($eliminar == NULL){ $eliminar = FALSE; }
        if($procesar == NULL){ $procesar = FALSE; }
        if($imprimir == NULL){ $imprimir = FALSE; }
        if($anular == NULL){ $anular = FALSE; }

        $data_sync[$mod[$i]] = ['pantalla' => $pantalla, 
                                  'buscar' => $buscar, 
                                 'incluir' => $incluir, 
                               'modificar' => $modificar, 
                                'eliminar' => $eliminar,
                                'procesar' => $procesar,
                                'imprimir' => $imprimir,
                                  'anular' => $anular];

      }

    
      $user->modulos()->sync($data_sync);

      \Session::flash('mensaje', 'Usuarios registrado exitosamente!');

      return redirect()->route('seguridad');



    }

    public function editar($id){

      $user = User::find($id);

      /*$modulos = Modulo::orderBy('sistema_id', 'ASC')
                        ->orderBy('id_padre', 'ASC')
                        ->orderBy('id_arbol', 'ASC')->get();*/

      $modulos = \DB::select("SELECT * FROM ((SELECT a.id, a.nombre, b.pantalla, b.buscar, b.incluir, b.modificar, b.eliminar, 
                                                   b.procesar, b.imprimir, b.anular, a.id_arbol, a.id_padre, a.sistema_id, 't' as activo
                                             FROM sipec_user.modulos a
                                            left JOIN sipec_user.modulo_user b ON a.id = b.modulo_id
                                            WHERE b.user_id = ?
                                            ORDER BY a.sistema_id ASC, a.id_padre ASC, a.id_arbol ASC)
                                            UNION all
                                            (SELECT a.id, a.nombre, 'f' as pantalla, 'f' as buscar, 'f' as incluir, 'f' as modificar, 'f' as eliminar, 
                                                   'f' as procesar, 'f' as imprimir, 'f' as anular, a.id_arbol, a.id_padre, a.sistema_id, 'f' as activo
                                             FROM sipec_user.modulos a
                                            WHERE  a.id not in (select c.modulo_id from sipec_user.modulo_user c where  c.user_id = ?)
                                            ORDER BY a.sistema_id ASC, a.id_padre ASC, a.id_arbol ASC)) AS modulos
                                            ORDER BY sistema_id ASC, id_padre ASC, id_arbol ASC", array($id, $id));

      foreach ($user->rol as $rol) {
        $roles = Role::where('id', '<>', $rol->id)->get();
      }
      
       $sedes = Sede::orderBy('denominacion', 'ASC')->get();

      $proyectos = Proyecto::orderBy('denominacion', 'ASC')->get();

      $periodos = Periodo::orderBy('nom_periodo', 'DESC')->get();

      return view('usuarios.editar', compact('modulos', 'roles', 'user', 'sedes', 'proyectos', 'periodos'));

    }
    /* Guargar las modificaciones de los usuasios*/
    public function modificar(Request $request){


      $validator = \Validator::make($request->all(), [
            'user' => 'required',
            'apellidos' => 'required',
            'nombre'  => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'rol' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/seguridad/usuarios/nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }

      //Guardando el Usuario
      $user = User::find(Input::get('id'));
      $user->user = Input::get('user');
      $user->apellidos = Input::get('apellidos');
      $user->nombre = Input::get('nombre');
      $user->email = Input::get('email');
      $user->telefono = Input::get('telefono');
      $user->usr_creador = \Auth::user()->id;
      if(Input::get('password') == NULL){

      }else{
        $user->password = \Hash::make(Input::get('password'));
      }
      $user->is_active = Input::get('activar');
      $user->save();

      foreach ($user->rol as $rol) {
        $user->roles()->detach($rol->id);  
      }

      
      $user->roles()->attach(Input::get('rol'));

      //Asigancion de sedes

      if(Input::get('sede') != 0){
        $user->sedes()->sync(Input::get('sede'));
      }else{
        \DB::select('DELETE FROM sipec_user.sede_user WHERE user_id = ?', array($user->id));
      }

      //Asigancion de pryectos

      if(Input::get('programa') != 0){
        $user->proyectos()->sync(Input::get('programa'));
      }else{
        \DB::select('DELETE FROM sipec_user.proyecto_user WHERE user_id = ?', array($user->id));
      }

      //Asigancion de periodos

      if(Input::get('periodos') != 0){
        $user->periodos()->sync(Input::get('periodos'));
      }else{
        \DB::select('DELETE FROM sipec_user.periodo_user WHERE user_id = ?', array($user->id));
      }

      

      //Asigando permisos
      $modulos = count(Input::get('modulos'));
      $mod = Input::get('modulos');

      $data_sync = array();

      for ($i=0; $i < $modulos ; $i++) { 
        $p = 'pantalla_'.$mod[$i];
        $b = 'buscar_'.$mod[$i];
        $in = 'incluir_'.$mod[$i];
        $modif = 'modificar_'.$mod[$i];
        $del = 'eliminar_'.$mod[$i];
        $pro = 'procesar_'.$mod[$i];
        $imp = 'imprimir_'.$mod[$i];
        $anu = 'anular_'.$mod[$i];

        $pantalla = Input::get($p);
        $buscar = Input::get($b);
        $incluir = Input::get($in);
        $modificar = Input::get($modif);
        $eliminar = Input::get($del);
        $procesar = Input::get($pro);
        $imprimir = Input::get($imp);
        $anular = Input::get($anu);

        if($pantalla == NULL){ $pantalla = FALSE; }
        if($incluir == NULL){ $incluir = FALSE; }
        if($modificar == NULL){ $modificar = FALSE; }
        if($eliminar == NULL){ $eliminar = FALSE; }
        if($procesar == NULL){ $procesar = FALSE; }
        if($imprimir == NULL){ $imprimir = FALSE; }
        if($anular == NULL){ $anular = FALSE; }

        $data_sync[$mod[$i]] = ['pantalla' => $pantalla, 
                                  'buscar' => $buscar, 
                                 'incluir' => $incluir, 
                               'modificar' => $modificar, 
                                'eliminar' => $eliminar,
                                'procesar' => $procesar,
                                'imprimir' => $imprimir,
                                  'anular' => $anular];

      }

    
      $user->modulos()->sync($data_sync);

      \Session::flash('mensaje', 'Usuario modificado exitosamente!');

      return redirect()->back();



    }

    public function buscar(){

      $users = User::cedula(Input::get('cedula'))->apellidos(Input::get('apellidos'))->nombres(Input::get('nombres'))->get();

       $roles = Role::all();
        
      return view('usuarios.lista', compact('users', 'roles'));

    }


    public function rolesypermisos(){

        $permisos = Permission::paginate(7);
        $roles = Role::paginate(7);

        return view('usuarios.rolesypermisos', compact('roles', 'permisos'));
    }

    public function permisosAjax(Request $request) {

        #$permisos = Role::where('id', Input::get('id_rol'))->get();

        $rol = Role::findOrFail(Input::get('id_rol'));

        $permisos = $rol->perms()->get();

        $permisosArray = array();
        foreach ($permisos as $p) {

                array_push($permisosArray, array($p->id, $p->display_name));
            
        }
        
        return response()->json($permisosArray);
    }

    public function CargarPersonaAjax(Request $request) {

       // $persona = Cne::where('cedula', Input::get('cedula'))->get();
        $cedula = Input::get('cedula');
        $persona = Cne2::buscar('V', $cedula);

        $arraypersona = array($persona['apellidos'], $persona['nombres']);
        
        return response()->json($arraypersona);
    }

    public function cargarPermisosAjax(){

        $permisos = \DB::select("SELECT 
                                  permissions.id, 
                                  permissions.display_name
                                FROM 
                                  sipec_user.permission_role, 
                                  sipec_user.permissions, 
                                  sipec_user.roles
                                WHERE 
                                  permissions.id = permission_role.permission_id AND
                                  permission_role.role_id = ?
                                 GROUP BY permissions.id, 
                                  permissions.display_name
                                 ORDER BY permissions.display_name", array(Input::get('id_rol')));




        $permisosArray = array();

        foreach ($permisos as $p) {
            $perm = Permission::where('id', '<>', $p->id )->get();
            foreach ($perm as $p) {
            array_push($permisosArray, array($p->id, $p->display_name));
            }
                
        }

        

        return response()->json($permisosArray);
    }

    public function agregarPermisosAjax(){
        
        $id_rol = Input::get('id_rol');
        $id_permiso = Input::get('id_permiso');

        $rol = Role::find($id_rol);

        $attachP = $rol->attachPermission($id_permiso);

    }
   
}
