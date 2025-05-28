<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;


class HolidayController extends Controller
{
    //
    public function userHoliday(){
        $currentYear = Carbon::now()->year;

        $holidays = Holiday::whereYear('holiday_date', $currentYear)
        ->orderBy('holiday_date','asc')
        ->get();

        return view('users.Holiday.user_holiday',compact('holidays'));
    }
}
