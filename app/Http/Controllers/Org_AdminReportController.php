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

class Org_AdminReportController extends Controller
{
    //
    public function Org_reportIndex(Request $request)
    {
        $show_current_month = Carbon::now()->format('F');
        $selectedYear = $request->input('selectedYear', Carbon::now()->year);

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
        $currentMonth = Carbon::now()->startOfMonth();

        if ($selectedMonth && array_key_exists($selectedMonth, $months)) {
            $currentMonth = Carbon::parse(array_search($selectedMonth, $months))->startOfMonth();
        }

        $organizations = Organizations::all();
        $users = User::all();

        $daysInMonth = $currentMonth->daysInMonth;
        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dates[] = $i;
        }

        $attempts = Attemp::whereMonth('attemp_date', $currentMonth->month)
            ->whereYear('attemp_date', $currentMonth->year)
            ->whereMonth('attemp_date', $currentMonth->month)
            ->whereHas('user', function ($query) {
                $query->where('organization_id', Auth()->user()->organization_id);
            })
            ->get();

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
            // เพิ่มเงื่อนไขนี้เพื่อให้ 'absent_count' ไม่น้อยกว่า 0
            $userReport['absent_count'] = max(0, $userReport['absent_count']);
        }

        usort($userReports, function ($a, $b) {
            return $b['work_count'] <=> $a['work_count'];
        });

        return view('organization_admin.organization_report.org_admin_report', compact('organizations', 'users', 'dates', 'selectedMonth', 'months', 'attempts', 'show_current_month', 'userReports'));
    }

    public function Org_reportSelectPDF(Request $request)
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
        $selectedYearThai = $selectedYear + 543;

        $selectedOrganizationId = Auth()->user()->organization_id;

        $attempts = Attemp::whereYear('attemp_date', $selectedDate->year)
            ->whereMonth('attemp_date', $selectedDate->month)
            ->whereHas('user', function ($query) {
                $query->where('organization_id', Auth()->user()->organization_id);
            })->get();

        $groupedAttempts = $attempts->groupBy('users_id');
        $organization = Organizations::find($selectedOrganizationId);

        $currentMonth = $selectedDate->copy();

        $holidays = Holiday::whereYear('holiday_date', $currentMonth->year)
            ->whereMonth('holiday_date', $currentMonth->month)
            ->pluck('holiday_date')
            ->toArray();

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

        $userReports = [];
        $attempts_history = Attemp::whereYear('attemp_date', $currentMonth->year)
            ->whereMonth('attemp_date', $currentMonth->month)
            ->whereHas('user', function ($query) {
                $query->where('organization_id', Auth()->user()->organization_id);
            })->get();

        foreach ($attempts_history as $attempt) {
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
            // เพิ่มเงื่อนไขนี้เพื่อให้ 'absent_count' ไม่น้อยกว่า 0
            $userReport['absent_count'] = max(0, $userReport['absent_count']);
        }

        usort($userReports, function ($a, $b) {
            return $b['work_count'] <=> $a['work_count'];
        });

        // สร้างอินสแตนซ์ PDF พร้อมตัวเลือก
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // เรนเดอร์มุมมองเบลดเป็น HTML
        $html = view('organization_admin.organization_report.org_admin_report_select_pdf', [
            'organization' => $organization,
            'dates' => $dates,
            'groupedAttempts' => $groupedAttempts,
            'selectedMonth' => $selectedMonthThai,
            'userReports' => $userReports,
            'selectedMonthThai' => $selectedMonthThai,
            'selectedYearThai' => $selectedYearThai,
        ])->render();

        // โหลด HTML ลงใน Dompdf
        $dompdf->loadHtml($html);

        // เรนเดอร์ PDF
        $dompdf->render();

        // เอาท์พุต PDF
        return $dompdf->stream("รายงานการทำงานหน่วยงานย่อย");
    }

}
