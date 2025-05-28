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

        $current_date = Carbon::today()->toDateString(); //วันที่ปัจจุบัน
        $user_id = auth()->user()->id; //user_id ที่ login อยู่
        $current_time = Carbon::now()->toTimeString(); //เวลาปัจจุบัน

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

        $startOfWeek = now()->startOfWeek(); // วันเริ่มต้นของสัปดาห์นี้
        $endOfWeek = now()->endOfWeek(); // วันสิ้นสุดของสัปดาห์นี้

        $attemp_history = Attemp::where('users_id', '=', $user_id)
            ->whereBetween('attemp_date', [$startOfWeek, $endOfWeek])
            ->get();

        $schedule_in = WorkSchedule::select('work_schedule_timein')->first();
        $schedule_out = WorkSchedule::select('work_schedule_timeout')->first();

        return view('users.Timestamp.user_timestamp', compact('attemp_history', 'current_time', 'current_date', 'attemp_in', 'attemp_out', 'attemp_leave','schedule_in','schedule_out'));
    }
    public function insert(Request $request)
    {

        $user_id = auth()->user()->id; //user_id ที่ login อยู่
        $current_date = Carbon::today()->toDateString(); //วันที่ปัจจุบัน
        $current_time = Carbon::now()->toTimeString(); //เวลาปัจจุบัน

        $work_schedule = WorkSchedule::first();//ดึงเวลาเข้างาน

        //ที่อยู่จริง
        // $current_latitude = $request->latitude;
        // $current_longitude = $request->longitude;

        //ที่อยู่ตาม ม.
        $current_latitude = 15.688550428666275;
        $current_longitude = 100.10709374758582;

        //location ม.
        $min_latitude = 15.683941447799139;
        $min_longitude = 100.09829699993134;
        $max_latitude = 15.694229246114995;
        $max_longitude = 100.11404693126678;

        if ($request->attemp_type == 2 || $request->attemp_type == 3) {
            $request->validate([
                'attemp_image' => 'image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($request->hasFile('attemp_image')) {
                $image = $request->file('attemp_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/image/'), $imageName);

                if ($request->workin == null && $request->workout == null) {
                    if ($current_time >= $work_schedule->work_schedule_timein) { ##เข้าสาย
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
                            "attemp_type" => $request->attemp_type,
                            "latitude" => $request->latitude,
                            "longitude" => $request->longitude,
                            "attemp_image" => $imageName,
                            "attemp_describe" => $request->attemp_describe,
                        ]);
                        return redirect()->back()->with('success', 'บันทึกเวลาสำเร็จ');
                    } else {
                        $insert = Attemp::create([
                            "attemp_in_out" => 1,
                            "attemp_date" => $current_date,
                            "attemp_time" => $current_time,
                            "users_id" => $user_id,
                            "attemp_type" => $request->attemp_type,
                            "latitude" => $request->latitude,
                            "longitude" => $request->longitude,
                            "attemp_image" => $imageName,
                            "attemp_describe" => $request->attemp_describe,
                        ]);

                        return redirect()->back()->with('success', 'บันทึกเวลาสำเร็จ');
                    }
                } elseif ($request->workin !== null && $request->workout == null && $current_time >= $work_schedule->work_schedule_timeout) {
                    $insert = Attemp::create([
                        "attemp_in_out" => 2,
                        "attemp_date" => $current_date,
                        "attemp_time" => $current_time,
                        "users_id" => $user_id,
                        "attemp_type" => $request->attemp_type,
                        "latitude" => $request->latitude,
                        "longitude" => $request->longitude,
                        "attemp_image" => $imageName,
                        "attemp_describe" => $request->attemp_describe,
                    ]);
                    return redirect()->back()->with('success', 'บันทึกเวลาสำเร็จ');
                }
            } else {
                return redirect()->back()->with('error', 'โปรดแนบรูปภาพ');
            }

        } elseif ($request->attemp_type == 1) {
            if (
                $current_latitude >= $min_latitude && $current_latitude <= $max_latitude &&
                $current_longitude >= $min_longitude && $current_longitude <= $max_longitude
            ) {
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
                            "latitude" => $current_latitude, // เปลี่ยนจาก $request->latitude
                            "longitude" => $current_longitude, // เปลี่ยนจาก $request->longitude
                        ]);
                    } else {
                        $insert = Attemp::create([
                            "attemp_date" => $current_date,
                            "attemp_time" => $current_time,
                            "users_id" => $user_id,
                            "attemp_type" => 1,
                            "attemp_in_out" => 1,
                            "latitude" => $current_latitude, // เปลี่ยนจาก $request->latitude
                            "longitude" => $current_longitude, // เปลี่ยนจาก $request->longitude
                        ]);
                    }
                } elseif ($request->workin !== null && $request->workout == null && $current_time >= $work_schedule->work_schedule_timeout) {
                    $insert = Attemp::create([
                        "attemp_date" => $current_date,
                        "attemp_time" => $current_time,
                        "users_id" => $user_id,
                        "attemp_type" => 1,
                        "attemp_in_out" => 2,
                        "latitude" => $current_latitude, // เปลี่ยนจาก $request->latitude
                        "longitude" => $current_longitude, // เปลี่ยนจาก $request->longitude
                    ]);
                }
                return redirect()->back()->with('success', 'บันทึกเวลาสำเร็จ');
            } else {
                return redirect()->back()->with('error', 'ไม่อยู่ในพื้นที่หน่วยงาน');
            }
        }
    }
}
