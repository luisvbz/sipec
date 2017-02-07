<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use sipec\User;
use sipec\Sede;

class BaseController extends Controller
{

    public function index()
    {

        return view('index');
    }

   
}
