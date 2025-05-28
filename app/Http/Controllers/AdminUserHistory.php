<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attemp;
use App\Models\User;
use Carbon\Carbon;
class AdminUserHistory extends Controller
{
    public function admin_user_work_history($id){

        $user_works = Attemp::where('users_id' , '=' , $id)
        ->orderBy('attemp_date','desc')
        ->orderBy('attemp_time','desc')
        ->get();

        $users = User::find($id);

        return view('super_admin.Worktimerecording.admin_user_work_history',compact('user_works','users'));
    }
}
