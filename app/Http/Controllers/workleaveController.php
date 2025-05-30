<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\work_leave;
use App\Models\Attemp;
use App\Models\GroupAttemp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class workleaveController extends Controller
{
    public function work_leave_index()
    {

        $user = auth()->user();

        if ($user->user_level == 1) {
            $work_leave_history = Attemp::where('attemp_type', '=', 4)
                ->orderBy('created_at', 'desc')
                ->orderBy('attemp_date', 'desc')
                ->get();
            $user_selection = User::where('id', $user->id)->get();
            return view('organization_admin.work_leave.user_work_leave', compact('work_leave_history', 'user_selection'));
        }
        if ($user->user_level == 2) {
            $work_leave_history = Attemp::where('attemp_type', '=', 4)
                ->orderBy('created_at', 'desc')
                ->orderBy('attemp_date', 'desc')
                ->get();
            $user_selection = User::all();
        } elseif ($user->user_level == 3) {
            $work_leave_history = Attemp::where('attemp_type', '=', 4)
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

            $attemp_id = [];
            foreach ($work_leave_date as $date) {
                $attemp = Attemp::create([
                    'attemp_date' => $date,
                    'users_id' => $userId,
                    'attemp_in_out' => 0,
                    'attemp_type' => 4,
                    'attemp_describe' => $request->input('work_leave_describe'),
                ]);
                $attemp_id[] = $attemp->id;
            }
            $group_attemp = new GroupAttemp();
            $group_attemp->attemp_id = implode(',', $attemp_id);
            $group_attemp->save();

            return redirect()->back()->with('success', 'บันทึกเรียบร้อย');
        } else {
            return redirect()->back()->with('error', 'กรุณาเลือกวัน');
        }
    }


    public function work_leave_delete(Request $request, $id)
    {
        $work_delete = Attemp::find($id);
        if (!empty($work_delete)) {
            if ($work_delete->delete()) {
                $group_attemp = GroupAttemp::whereRaw("FIND_IN_SET(?, attemp_id)", [$work_delete->id])->first();
                $group_attemp_id = explode(',', $group_attemp->attemp_id);
                $array = array_filter($group_attemp_id, fn($v) => $v != $work_delete->id);
                $array = array_values($array);
                if (count($group_attemp_id) > 1) {
                    $group_attemp->attemp_id = implode(',', $array);
                    $group_attemp->save();
                } else {
                    $group_attemp->delete();
                }
            };
            return redirect()->back()->with('success', 'บันทึกเรียบร้อยแล้ว');
        }
    }

    public function work_leave_cancel(Request $request)
    {
        $data = [
            'status' => false,
            'message' => 'ยกเลิกไม่สำเร็จ',
        ];
        $input = $request->post();
        $work_delete = Attemp::find($input['id']);
        if (!empty($work_delete)) {
            $work_delete->status = 3;
            $work_delete->cancel_absent = $input['value'];
            $work_delete->deleted_at = date('Y-m-d H:i:s');
            if ($work_delete->save()) {
                $group_attemp = GroupAttemp::whereRaw("FIND_IN_SET(?, attemp_id)", [$work_delete->id])->first();
                $group_attemp_id = explode(',', $group_attemp->attemp_id);
                $array = array_filter($group_attemp_id, fn($v) => $v != $work_delete->id);
                $array = array_values($array);
                if (count($group_attemp_id) > 1) {
                    $group_attemp->attemp_id = implode(',', $array);
                    $group_attemp->save();
                } else {
                    $group_attemp->delete();
                }
                $data = [
                    'status' => true,
                    'message' => 'ยกเลิกเรียบร้อยแล้ว',
                ];
            };
        }
        return response()->json($data);
    }

    public function work_leave_approve(Request $request)
    {
        $data = [
            'status' => false,
            'message' => 'อนุมัติไม่สำเร็จ',
        ];
        $input = $request->post();
        $work_delete = Attemp::find($input['id']);
        if (!empty($work_delete)) {
            $work_delete->status = 2;
            $work_delete->updated_at = date('Y-m-d H:i:s');
            if ($work_delete->save()) {
                $data = [
                    'status' => true,
                    'message' => 'อนุมัติเรียบร้อยแล้ว',
                ];
            };
        }
        return response()->json($data);
    }
}
