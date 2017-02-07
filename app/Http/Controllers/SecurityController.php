<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;

class SecurityController extends Controller
{
   
    public function mtto()
    {
        return view('seguridad.mtto');
    }

}
