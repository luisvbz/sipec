<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'historico_secon.constancias';

	public $timestamps = false;
}
