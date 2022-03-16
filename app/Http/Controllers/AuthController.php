<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        $keys = [];
        return view("modules.login",$keys);
    }

    public function login(){

    }

    public function logout(){

    }
}
