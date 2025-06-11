<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Attemp;
use App\Models\Holiday;
use App\Models\WorkSchedule;
use Carbon\Carbon;

class TimestampController extends Controller
{
    //
    public function userTimestampIndex()
    {
        $current_date = Carbon::today()->toDateString();
        $user_id = auth()->user()->id;
        $current_time = Carbon::now()->toTimeString();

        $holiday = Holiday::whereDate('holiday_date', $current_date)->get();
        if ($holiday !== null && !$holiday->isEmpty()) {
            foreach ($holiday as $h) {
                if ($h->holiday_date == $current_date) {
                    return view('users.Timestamp.user_day_off')->with('holiday_name', $h->holiday_name)->with('holiday_date', $h->holiday_date);
                }
            }
        }
        $attemp_leave = Attemp::where('users_id', '=', $user_id)
            ->where('attemp_in_out', '=', 0)
            ->whereDate('attemp_date', $current_date)->first();

        $attemp_in = Attemp::where('users_id', '=', $user_id)
            ->where('attemp_in_out', '=', 1)
            ->whereDate('attemp_date', $current_date)->first();

        $attemp_out = Attemp::where('users_id', '=', $user_id)
            ->where('attemp_in_out', '=', 2)
            ->whereDate('attemp_date', $current_date)->first();

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $attemp_history = Attemp::where('users_id', '=', $user_id)
            ->whereBetween('attemp_date', [$startOfWeek, $endOfWeek])
            ->get();

        $schedule_in = WorkSchedule::select('work_schedule_timein')->first();
        $schedule_out = WorkSchedule::select('work_schedule_timeout')->first();

        return view('users.Timestamp.user_timestamp', compact('attemp_history', 'current_time', 'current_date', 'attemp_in', 'attemp_out', 'attemp_leave', 'schedule_in', 'schedule_out'));
    }

    public function insert(Request $request)
    {

        $user_id = auth()->user()->id;
        $current_date = Carbon::today()->toDateString();
        $current_time = Carbon::now()->toTimeString();

        $work_schedule = WorkSchedule::first();

        $current_latitude = $request->input('lat');
        $current_longitude = $request->input('lng');

        if ($request->hasFile('attemp_image')) {
            $image = $request->file('attemp_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/image/'), $imageName);
            if ($request->workin == null && $request->workout == null) {
                if ($current_time >= $work_schedule->work_schedule_timein) {
                    $currentTime = Carbon::now();
                    $targetTime = Carbon::parse($work_schedule->work_schedule_timein);
                    $timeDifference = $currentTime->diff($targetTime);
                    $hours = $timeDifference->h;
                    $minutes = $timeDifference->i;
                    if ($hours > 0) {
                        $minutes += $hours * 60;
                    }
                    $insert = Attemp::create([
                        "attemp_in_out" => 1,
                        "attemp_date" => $current_date,
                        "attemp_time" => $current_time,
                        "users_id" => $user_id,
                        "attemp_late_time" => $minutes,
                        "attemp_type" => 1,
                        "latitude" => $current_latitude,
                        "longitude" => $current_longitude,
                        "attemp_image" => $imageName,
                    ]);
                } else {
                    $insert = Attemp::create([
                        "attemp_date" => $current_date,
                        "attemp_time" => $current_time,
                        "users_id" => $user_id,
                        "attemp_type" => 1,
                        "attemp_in_out" => 1,
                        "latitude" => $current_latitude,
                        "longitude" => $current_longitude,
                        "attemp_image" => $imageName,
                    ]);
                }
            } elseif ($request->workin !== null && $request->workout == null && $current_time >= $work_schedule->work_schedule_timeout) {
                $insert = Attemp::create([
                    "attemp_date" => $current_date,
                    "attemp_time" => $current_time,
                    "users_id" => $user_id,
                    "attemp_type" => 1,
                    "attemp_in_out" => 2,
                    "latitude" => $current_latitude,
                    "longitude" => $current_longitude,
                    "attemp_image" => $imageName,
                ]);
            }
            return redirect()->back()->with('success', 'บันทึกเวลาสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'ไม่อยู่ในพื้นที่หน่วยงาน');
        }
    }
}
