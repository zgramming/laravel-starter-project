<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function index()
    {
        $keys = [];
        return view('modules.user.grids.user_grid', $keys);
    }
}
