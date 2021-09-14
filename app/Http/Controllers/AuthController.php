<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class AuthController extends Controller
{
    public function getLogout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }
}
