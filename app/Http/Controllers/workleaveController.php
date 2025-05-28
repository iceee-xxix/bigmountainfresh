<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\work_leave;
use App\Models\Attemp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class workleaveController extends Controller
{
    public function work_leave_index()
    {

        $user = auth()->user();

        if ($user->user_level == 2) {
            $work_leave_history = Attemp::where('attemp_type','=',4)
            ->orderBy('created_at', 'desc')
            ->orderBy('attemp_date', 'desc')
            ->get();
            $user_selection = User::all();

        } elseif ($user->user_level == 3) {
            $work_leave_history = Attemp::where('attemp_type','=',4)
            ->whereHas('user', function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('attemp_date', 'desc')
            ->get();

            $user_selection = User::where('organization_id', $user->organization_id)->get();
        }


        return view('organization_admin.work_leave.work_leave', compact('work_leave_history', 'user_selection'));
    }

    public function work_leave_submit(Request $request)
    {
        $date_pick = $request->input('work_leave_dates', '');
        $work_leave_date = explode(', ', $date_pick);
        $userId = $request->input('work_leave_user');

        if (!empty($date_pick)) {
            foreach ($work_leave_date as $date) {
                $check = Attemp::where('users_id', $userId)
                    ->whereDate('attemp_date', $date)
                    ->where('attemp_type', 4)
                    ->first();

                if ($check) {
                    return redirect()->back()->with('error', 'คุณได้ทำการยื่นลาวันดังกล่าวแล้ว');
                }
            }

            foreach ($work_leave_date as $date) {
                Attemp::create([
                    'attemp_date' => $date,
                    'users_id' => $userId,
                    'attemp_in_out' => 0,
                    'attemp_type' => 4,
                    'attemp_describe' => $request->input('work_leave_describe'),
                ]);
            }
            return redirect()->back()->with('success', 'บันทึกเรียบร้อย');
        } else {
            return redirect()->back()->with('error', 'กรุณาเลือกวัน');
        }
    }


    public function work_leave_delete(Request $request ,$id){
        $work_delete = Attemp::find($id);
        if (!empty($work_delete)) {
                $work_delete->delete();
                return redirect()->back()->with('success','บันทึกเรียบร้อยแล้ว');
            }
        }
    }


