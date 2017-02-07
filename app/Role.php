<?php namespace sipec;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	public function permisos()
    {
        return $this->belongsToMany('sipec\Permission','permission_role');
    }
}