<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'valores.programas_proyectos1';
}
