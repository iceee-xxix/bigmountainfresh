<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Attemp;
use Carbon\Carbon;
use Auth;

class WorktimerecordingController extends Controller
{
    //
    public function worktimerecordingIndex(){
        if(Auth()->user()->user_level == 2){
            $current_date = Carbon::today()->toDateString(); //วันที่ปัจจุบัน
            $worktimes = Attemp::orderBy('attemp_date','desc')
            ->orderBy('attemp_time','desc')
            ->get();
        }
        elseif(Auth()->user()->user_level == 3){
            $user = auth()->user();
            $worktimes = Attemp::whereHas('user', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            })
            ->orderBy('attemp_date','desc')
            ->orderBy('attemp_time','desc')
            ->get();
        }

        return view('super_admin.Worktimerecording.admin_work_time_recording',compact('worktimes'));
    }
}
