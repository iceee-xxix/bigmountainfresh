<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkSchedule;

class ManagetimeworkController extends Controller
{
    //
    public function managetimeIndex()
    {
        $workschedules = WorkSchedule::all();
        return view('super_admin.Manage_time_work.admin_manage_time_work', compact('workschedules'));
    }

    public function managetimeCreate(Request $request)
    {
        $request->validate([
            'work_schedule_timein' => 'required',
            'work_schedule_timeout' => 'required',
        ]);

        // ตรวจสอบว่ามีข้อมูลการตั้งเวลางานอยู่แล้วหรือไม่
        $existingSchedule = WorkSchedule::first();
        if ($existingSchedule) {
            return redirect()->back()->with('error', 'มีข้อมูลการตั้งเวลางานอยู่แล้ว');
        }

        $workschedule = new WorkSchedule();
        $workschedule->work_schedule_timein = $request->work_schedule_timein;
        $workschedule->work_schedule_timeout = $request->work_schedule_timeout;
        $workschedule->save();

        return redirect()->back()->with('success', 'ตั้งเวลางานเรียบร้อยแล้ว');
    }

    public function managetimeUpdate(Request $request, $id)
    {
        $request->validate([
            'work_schedule_timein' => 'required',
            'work_schedule_timeout' => 'required',
        ]);

        $workschedule_update = WorkSchedule::find($id);
        $workschedule_update->work_schedule_timein = $request->work_schedule_timein;
        $workschedule_update->work_schedule_timeout = $request->work_schedule_timeout;
        $workschedule_update->save();

        return redirect()->back()->with('success','แก้ไขเวลางานเรียบร้อยแล้ว');
    }

    public function managetimeDelete($id)
    {
        $workschedule_delete = WorkSchedule::find($id);
        $workschedule_delete->delete();

        return redirect()->back()->with('success','ลบเวลางานเรียบร้อยแล้ว');
    }
}
