<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attemp;
use App\Models\User;
use App\Models\Holiday;

class Test2Controller extends Controller
{
    //
    public function test()
    {
        return view('test.test');
    }

    public function location_test(Request $request){

        // //ที่อยู่จริง
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

        // //location เครื่อง
        // $min_latitude = 15.851173662653748;
        // $min_longitude =       100.9731262922287;
        // $max_latitude =  15.892287799786175;
        // $max_longitude =   101.00007712841034;

        if ($current_latitude >= $min_latitude && $current_latitude <= $max_latitude &&
        $current_longitude >= $min_longitude && $current_longitude <= $max_longitude) {


        }
        else {
            return redirect()->back()->with('error','ไม่อยู่ในพื้นที่');
        }
    }

    // public function test_report_history()
    // {
    //     $userReports = [];
    //     $monthStart = now()->startOfMonth();
    //     $today = now();

    //     $workDays = 0;
    //     for ($day = $monthStart; $day->lte($today); $day->addDay()) {
    //         if (!$day->isWeekend()) {
    //             $workDays++;
    //         }
    //     }

    //     แสดงทุกหน่วยงาน
    //     $attemps = Attemp::whereMonth('attemp_date', now()->month)->get();

    //     แสดงตามหน่วยงาน
    //     $attemps = Attemp::whereMonth('attemp_date', now()->month)
    //               ->whereHas('user', function($query) {
    //                     $query->where('organization_id', Auth()->user()->organization_id);
    //               })->get();

    //     foreach ($attemps as $attemp) {
    //         $user = $attemp->user;
    //         $organization = $user->organization;
    //         if (!isset($userReports[$user->id])) {
    //             $userReports[$user->id] = [
    //                 'name' => $user->name,
    //                 'organization_name' => $organization->organization_name,
    //                 'user_department' => $user->user_department,
    //                 'late_count' => 0,
    //                 'work_count' => 0,
    //                 'leave_count' => 0,
    //                 'absent_count' => 0,
    //             ];

    //         }
    //         if ($attemp->attemp_in_out == 1) {
    //             $userReports[$user->id]['work_count']++;
    //         }
    //         if ($attemp->attemp_type == 4) {
    //             $userReports[$user->id]['leave_count']++;
    //         }
    //         if ($attemp->attemp_late_time !== null && $attemp->attemp_late_time > 0) {
    //             $userReports[$user->id]['late_count']++;
    //         }
    //     }

    //     foreach ($userReports as &$userReport) {
    //         $userReport['absent_count'] = $workDays - $userReport['work_count'];
    //         if ($userReport['leave_count'] > 0) {
    //             $userReport['absent_count'] -= $userReport['leave_count'];
    //         }
    //     }

    //     usort($userReports, function($a, $b) {
    //         return $b['work_count'] <=> $a['work_count'];
    //     });

    //     return view('test2.test_report_history', compact('userReports'));
    // }

    // public function test_report_history()
    // {
    //     $userReports = [];
    //     $monthStart = now()->startOfMonth();
    //     $today = now();

    //     $holidays = Holiday::whereYear('holiday_date', $today->year)
    //                     ->whereMonth('holiday_date', $today->month)
    //                     ->pluck('holiday_date')
    //                     ->toArray();

    //     $workDays = 0;
    //     for ($day = $monthStart; $day->lte($today); $day->addDay()) {
    //         if (!$day->isWeekend() && !in_array($day->format('Y-m-d'), $holidays)) {
    //             $workDays++;
    //         }
    //     }

    //     // แสดงทุกหน่วยงาน
    //     $attempts = Attemp::whereMonth('attemp_date', now()->month)->get();

    //     foreach ($attempts as $attempt) {
    //         $user = $attempt->user;
    //         $organization = $user->organization;
    //         if (!isset($userReports[$user->id])) {
    //             $userReports[$user->id] = [
    //                 'name' => $user->name,
    //                 'organization_name' => $organization->organization_name,
    //                 'user_department' => $user->user_department,
    //                 'late_count' => 0,
    //                 'work_count' => 0,
    //                 'leave_count' => 0,
    //                 'absent_count' => 0,
    //             ];
    //         }
    //         if ($attempt->attemp_in_out == 1) {
    //             $userReports[$user->id]['work_count']++;
    //         }
    //         if ($attempt->attemp_type == 4) {
    //             $userReports[$user->id]['leave_count']++;
    //         }
    //         if ($attempt->attemp_late_time !== null && $attempt->attemp_late_time > 0) {
    //             $userReports[$user->id]['late_count']++;
    //         }
    //     }

    //     foreach ($userReports as &$userReport) {
    //         $userReport['absent_count'] = $workDays - $userReport['work_count'];
    //         if ($userReport['leave_count'] > 0) {
    //             $userReport['absent_count'] -= $userReport['leave_count'];
    //         }
    //     }

    //     usort($userReports, function($a, $b) {
    //         return $b['work_count'] <=> $a['work_count'];
    //     });

    //     return view('test2.test_report_history', compact('userReports'));
    // }

    public function test_report_history()
    {
        $userReports = [];
        $monthStart = now()->startOfMonth();
        $today = now();

        $holidays = Holiday::whereYear('holiday_date', $today->year)
                        ->whereMonth('holiday_date', $today->month)
                        ->pluck('holiday_date')
                        ->toArray();

        $workDays = 0;
        for ($day = $monthStart; $day->lte($today); $day->addDay()) {
            if (!$day->isWeekend() && !in_array($day->format('Y-m-d'), $holidays)) {
                $workDays++;
            }
        }

        // แสดงทุกหน่วยงาน
        $attemp_history = Attemp::whereMonth('attemp_date', now()->month)->get();

        foreach ($attemp_history as $attempt) {
            $user = $attempt->user;
            $organization = $user->organization;
            if (!isset($userReports[$user->id])) {
                $userReports[$user->id] = [
                    'name' => $user->name,
                    'organization_name' => $organization->organization_name,
                    'user_department' => $user->user_department,
                    'late_count' => 0,
                    'work_count' => 0,
                    'leave_count' => 0,
                    'absent_count' => 0,
                ];
            }
            if ($attempt->attemp_in_out == 1) {
                $userReports[$user->id]['work_count']++;
            }
            if ($attempt->attemp_type == 4) {
                $userReports[$user->id]['leave_count']++;
            }
            if ($attempt->attemp_late_time !== null && $attempt->attemp_late_time > 0) {
                $userReports[$user->id]['late_count']++;
            }
        }

        // foreach ($userReports as &$userReport) {
        //     $userReport['absent_count'] = $workDays - $userReport['work_count'];
        //     if ($userReport['leave_count'] > 0) {
        //         $userReport['absent_count'] -= $userReport['leave_count'];
        //     }
        // }
        foreach ($userReports as &$userReport) {
            $userReport['absent_count'] = $workDays - $userReport['work_count'];
            if ($userReport['leave_count'] > 0) {
                $userReport['absent_count'] -= $userReport['leave_count'];
            }
            // เพิ่มเงื่อนไขนี้เพื่อให้ 'absent_count' ไม่น้อยกว่า 0
            $userReport['absent_count'] = max(0, $userReport['absent_count']);
        }


        usort($userReports, function($a, $b) {
            return $b['work_count'] <=> $a['work_count'];
        });

        return view('test2.test_report_history', compact('userReports'));
    }


}
