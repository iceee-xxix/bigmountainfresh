<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attemp;
use App\Models\User;
use App\Models\Organizations;
use App\Models\Holiday;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

class TestController extends Controller
{
    public function test_report(Request $request)
    {
        $organizations = Organizations::all();

        $months = [
            'January' => 'มกราคม',
            'February' => 'กุมภาพันธ์',
            'March' => 'มีนาคม',
            'April' => 'เมษายน',
            'May' => 'พฤษภาคม',
            'June' => 'มิถุนายน',
            'July' => 'กรกฎาคม',
            'August' => 'สิงหาคม',
            'September' => 'กันยายน',
            'October' => 'ตุลาคม',
            'November' => 'พฤศจิกายน',
            'December' => 'ธันวาคม',
        ];

        $selectedMonth = $request->input('selectedMonth');
        $selectedYear = $request->input('selectedYear', Carbon::now()->year);

        $currentMonth = Carbon::now()->startOfMonth();

        if ($selectedMonth && array_key_exists($selectedMonth, $months)) {
            $currentMonth = Carbon::parse(array_search($selectedMonth, $months))->startOfMonth();
        }

        $daysInMonth = $currentMonth->daysInMonth;
        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dates[] = $i;
        }

        // เริ่มโค้ดใหม่ที่นี่
        $holidays = Holiday::whereYear('holiday_date', $currentMonth->year)
            ->whereMonth('holiday_date', $currentMonth->month)
            ->pluck('holiday_date')
            ->toArray();

        $workDays = 0;
        for ($day = $currentMonth->copy(); $day->lte(Carbon::now()); $day->addDay()) {
            if (!$day->isWeekend() && !in_array($day->format('Y-m-d'), $holidays)) {
                $workDays++;
            }
        }

        $userReports = [];
        $attempts = Attemp::whereYear('attemp_date', $currentMonth->year)
            ->whereMonth('attemp_date', $currentMonth->month)
            ->get();

        foreach ($attempts as $attempt) {
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
                    'total_late_time' => 0,
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
                $userReports[$user->id]['total_late_time'] += $attempt->attemp_late_time;
            }
        }

        foreach ($userReports as &$userReport) {
            $userReport['absent_count'] = $workDays - $userReport['work_count'];
            if ($userReport['leave_count'] > 0) {
                $userReport['absent_count'] -= $userReport['leave_count'];
            }
        }

        usort($userReports, function ($a, $b) {
            return $b['work_count'] <=> $a['work_count'];
        });

        return view('test.test_report', compact('userReports', 'selectedMonth', 'selectedYear', 'months', 'organizations', 'dates', 'attempts'));
    }



    // public function generatePDF(Request $request)
    // {
    //     $selectedMonth = $request->input('selectedMonth');
    //     $selectedOrganizationId = $request->input('organization_id');

    //     if ($selectedMonth) {
    //         $selectedDate = Carbon::parse($selectedMonth)->startOfMonth();
    //     } else {
    //         $selectedDate = Carbon::now()->startOfMonth();
    //     }


    //     $daysInMonth = $selectedDate->daysInMonth;

    //     $dates = [];
    //     for ($i = 1; $i <= $daysInMonth; $i++) {
    //         $dates[] = $i;
    //     }

    //     // กำหนดชื่อเดือนภาษาอังกฤษและภาษาไทย
    //     $englishMonths = [
    //         'January', 'February', 'March', 'April', 'May', 'June',
    //         'July', 'August', 'September', 'October', 'November', 'December'
    //     ];

    //     $thaiMonths = [
    //         'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
    //         'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    //     ];

    //     // หาดัชนีของเดือนในอาร์เรย์ $englishMonths
    //     $index = array_search($selectedDate->englishMonth, $englishMonths);

    //     // นำดัชนีไปใช้เพื่อเข้าถึงชื่อเดือนภาษาไทย
    //     $index = $selectedDate->format('n') - 1;
    //     $selectedMonthThai = $thaiMonths[$index];

    //     $attempts = Attemp::whereYear('attemp_date', $selectedDate->year)
    //             ->whereMonth('attemp_date', $selectedDate->month)
    //             ->whereHas('user', function ($query) use ($selectedOrganizationId) {
    //                 $query->where('organization_id', $selectedOrganizationId);
    //             })->get();


    //     $groupedAttempts = $attempts->groupBy('users_id');
    //     $organization = Organizations::find($selectedOrganizationId);

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

    //     // $attemp_history = Attemp::whereMonth('attemp_date', now()->month)->get();

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


    //     // Create PDF instance with options
    //     $options = new Options();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $options->set('isRemoteEnabled', true);

    //     $dompdf = new Dompdf($options);

    //     // Render Blade view to HTML
    //     $html = view('test.test_report_pdf', [
    //         'organization' => $organization,
    //         'dates' => $dates,
    //         'groupedAttempts' => $groupedAttempts,
    //         'selectedMonth' => $selectedMonthThai,
    //         'userReports' => $userReports, // เพิ่มข้อมูลรายงานที่คุณสร้างใหม่นี้ไปยัง PDF
    //     ])->render();


    //     // Load HTML into Dompdf
    //     $dompdf->loadHtml($html);

    //     // Render PDF
    //     $dompdf->render();

    //     // Output PDF
    //     return $dompdf->stream();
    // }

    public function generatePDF(Request $request)
    {
        $selectedMonth = $request->input('selectedMonth');
        $selectedYear = $request->input('selectedYear');
        $selectedOrganizationId = $request->input('organization_id');

        if ($selectedMonth && $selectedYear) {
            $selectedDate = Carbon::createFromFormat('F Y', "{$selectedMonth} {$selectedYear}")->startOfMonth();
        } else {
            $selectedDate = Carbon::now()->startOfMonth();
        }


        $daysInMonth = $selectedDate->daysInMonth;

        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dates[] = $i;
        }

        $thaiMonths = [
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        ];
        $selectedMonthThai = $thaiMonths[$selectedDate->month - 1];

        $attempts = Attemp::whereYear('attemp_date', $selectedDate->year)
            ->whereMonth('attemp_date', $selectedDate->month)
            ->whereHas('user', function ($query) use ($selectedOrganizationId) {
                $query->where('organization_id', $selectedOrganizationId);
            })->get();

        $groupedAttempts = $attempts->groupBy('users_id');
        $organization = Organizations::find($selectedOrganizationId);

        $userReports = [];
        $monthStart = $selectedDate->startOfMonth();
        $today = now();

        $holidays = Holiday::whereYear('holiday_date', $today->year)
            ->whereMonth('holiday_date', $today->month)
            ->pluck('holiday_date')
            ->toArray();
            // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            
        if ($selectedDate->isCurrentMonth()) {
            $endDate = Carbon::now();
        } else {
            $endDate = Carbon::createFromFormat('F Y', "{$selectedMonth} {$selectedYear}")->endOfMonth();
        }
        $workDays = 0;
        $day = $selectedDate->copy();
        while ($day->lte($endDate)) {
            $workDays++;
            if ($day->isWeekend() || in_array($day->format('Y-m-d'), $holidays)) {
                $workDays--;
            }
            $day->addDay(); // เพิ่มวันที่ไปเรื่อยๆ
        }
        // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // $attemp_history = Attemp::whereMonth('attemp_date', now()->month)->get();

        foreach ($attempts as $attempt) {
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
                    'total_late_time' => 0,
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
                $userReports[$user->id]['total_late_time'] += $attempt->attemp_late_time;
            }
        }

        foreach ($userReports as &$userReport) {
            $userReport['absent_count'] = $workDays - $userReport['work_count'];
            if ($userReport['leave_count'] > 0) {
                $userReport['absent_count'] -= $userReport['leave_count'];
            }
        }

        usort($userReports, function ($a, $b) {
            return $b['work_count'] <=> $a['work_count'];
        });


        // Create PDF instance with options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Render Blade view to HTML
        $html = view('test.test_report_pdf', [
            'organization' => $organization,
            'dates' => $dates,
            'groupedAttempts' => $groupedAttempts,
            'selectedMonth' => $selectedMonthThai,
            'userReports' => $userReports, // เพิ่มข้อมูลรายงานที่คุณสร้างใหม่นี้ไปยัง PDF
        ])->render();


        // Load HTML into Dompdf
        $dompdf->loadHtml($html);

        // Render PDF
        $dompdf->render();

        // Output PDF
        return $dompdf->stream();
    }



}
