<?php

namespace sipec;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
    protected $connection = 'bdunermb';

	protected $table = 'historico_secon.curriculo';

	public $timestamps = false;
}
