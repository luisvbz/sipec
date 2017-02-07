<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'historico_secon.periodos';
}
