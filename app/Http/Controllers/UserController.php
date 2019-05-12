<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getLoginForm(){
        return view('loginForm');
    }

    public function login(Request $req){
        $login = $req->login;
        $password = $req->password;

        $token = User::login($login, $password);

        return response($token);
    }
}
