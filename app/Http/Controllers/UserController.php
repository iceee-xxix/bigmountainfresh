<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function userIndex(){
        return view('users.user_index');
    }
}
