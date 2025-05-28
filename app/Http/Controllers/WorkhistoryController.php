<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Attemp;
use Carbon\Carbon;

class WorkhistoryController extends Controller
{
    //
    public function userWorkhistory(){

        $user_id = Auth()->user()->id;
        $work_history = Attemp::where('users_id' , '=' , $user_id)
        ->orderBy('attemp_date','desc')
        ->orderBy('attemp_time','desc')
        ->get();

        return view('users.WorkHistory.user_work_history',compact('work_history',));
    }
}
