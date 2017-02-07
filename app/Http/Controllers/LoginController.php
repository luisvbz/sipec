<?php

namespace sipec\Http\Controllers;

use Illuminate\Http\Request;

use sipec\Http\Requests;
use sipec\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        #return dd(\Input::get('user'));

        if (Auth::attempt(['user' => \Input::get('user'), 'password' => \Input::get('password'), 'is_active' => TRUE])) {

            return redirect()->intended('/');

        }else{

            \Session::flash('message', "Error a iniciar sesion");

            return redirect('login'); 
        }
    }
}
