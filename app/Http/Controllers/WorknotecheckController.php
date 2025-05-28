<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorknotecheckController extends Controller
{
    //
    public function worknotecheckIndex(){

        return view('department_admin.check_work_notes');
    }
}
