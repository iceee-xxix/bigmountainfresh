<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
{
    //
    public function userInformation(){
        return view('users.Information.user_information');
    }
}
