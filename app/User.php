<?php

namespace sipec;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Auth;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword,  Authorizable, EntrustUserTrait {
        EntrustUserTrait::can as may;
        Authorizable::can insteadof EntrustUserTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function rol()
    {
        return $this->belongsToMany('sipec\Role','role_user');
    }

    function modulos()
    {
        return $this->belongsToMany('sipec\Modulo', 'modulo_user', 'user_id', 'modulo_id')
        ->withPivot('pantalla', 'buscar', 'incluir', 'modificar', 'eliminar', 'procesar', 'imprimir', 'anular')
        ->orderBy('sistema_id', 'ASC')
        ->orderBy('id_padre', 'ASC')
        ->orderBy('id_arbol', 'ASC');
    }

    function sedes()
    {
        return $this->belongsToMany('sipec\Sede', 'sede_user', 'user_id', 'sede_id');
    }

    function proyectos()
    {
        return $this->belongsToMany('sipec\Proyecto', 'sipec_user.proyecto_user', 'user_id', 'proyecto_id');
    }

    function periodos()
    {
        return $this->belongsToMany('sipec\Periodo', 'sipec_user.periodo_user', 'user_id', 'periodo_id');
    }


    public function scopeCedula($query, $cedula){
        if (isset($cedula))
         {
            if (trim($cedula) != "")
              $query->where('user', $cedula);
        
        }
    }

    public function scopeApellidos($query, $apellidos){
        if (isset($apellidos))
         {
            if (trim($apellidos) != "")
              $query->where('apellidos','ilike', "%".$apellidos."%");
        
        }
    }

     public function scopeNombres($query, $nombres){
        if (isset($nombres))
         {
            if (trim($nombres) != "")
              $query->where('nombre','ilike', "%".$nombres."%");
        
        }
    }

    public function canBuscar($m){

            foreach (Auth::user()->modulos as $modulo) {
            
            if($modulo->abrev == $m AND $modulo->pivot->buscar == TRUE){

                return TRUE;

            }else{

                return FALSE;

            }
                  
        }
    }

    public function canEliminar($m){

           // $modulo = \DB::select('sipec_user.modulos');
            foreach (Auth::user()->modulos as $modulo) {
            
            if($modulo->abrev == $m AND $modulo->pivot->eliminar == TRUE){

                return TRUE;

            }else{

                return FALSE;

            }
                  
        }
    }

    public function canImprimir($m){

            foreach (Auth::user()->modulos as $modulo) {
            
            if($modulo->abrev == $m AND $modulo->pivot->imprimir == TRUE){

                return TRUE;

            }else{

                return FALSE;

            }
                  
        }
    }

    public function canIncluir($m){

            foreach (Auth::user()->modulos as $modulo) {
            
            if($modulo->abrev == $m AND $modulo->pivot->incluir == TRUE){

                return TRUE;

            }else{

                return FALSE;

            }
                  
        }
    }
}
