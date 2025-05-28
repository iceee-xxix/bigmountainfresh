<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class AddholidayController extends Controller
{
    //
    public function addholidayIndex()
    {
        $currentYear = Carbon::now()->year;

        $holidays = Holiday::whereYear('holiday_date', $currentYear)
                   ->orderBy('holiday_date')
                   ->get();

        $totalHolidays = Holiday::whereYear('holiday_date', $currentYear)->count();

        return view('super_admin.Addholiday.admin_add_holiday',compact('holidays','totalHolidays'));
    }

    public function holidayCreate(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'holiday_name' => 'required',
        ]);

        $holiday = new Holiday();
        $holiday->holiday_date = $request->holiday_date;
        $holiday->holiday_name = $request->holiday_name;
        $holiday->save();

        return redirect()->back()->with('success','บันทึกข้อมูลวันหยุดเรียบร้อยแล้ว');
    }

    public function holidayUpdate(Request $request, $id)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'holiday_name' => 'required',
        ]);

        $holiday = Holiday::find($id);

        $holiday->holiday_date = $request->holiday_date;
        $holiday->holiday_name = $request->holiday_name;
        $holiday->save();

        return redirect()->back()->with('success','แก้ไขวันหยุดสำเร็จแล้ว');
    }

    public function deleteHoliday($id)
    {
        $holiday = Holiday::find($id);
        $holiday->delete();

        return redirect()->back()->with('success','ลบวันหยุดสำเร็จแล้ว');
    }

    public function api_holiday_update(){
    $currentYear = Carbon::now()->year;
    $loop = [
        $currentYear-1,
        $currentYear,
        $currentYear+1
    ];
    foreach ($loop as $loop_year) {
            $clientId = 'a376b25e-d6d5-40fc-b4e1-576e70364886';
            $apiUrl = "https://apigw1.bot.or.th/bot/public/financial-institutions-holidays/?year={$loop_year}";

            $response = Http::withHeaders([
                'X-IBM-Client-Id' => $clientId,
            ])->get($apiUrl);

            $data = $response->json();

            if (isset($data['result']['data'])) {
                foreach ($data['result']['data'] as $holidayData) {
                    $date = $holidayData['Date'];
                    $name = $holidayData['HolidayDescriptionThai'];

                    $existingHoliday = Holiday::where('holiday_date', $date)->first();

                    if (!$existingHoliday) {
                        Holiday::create([
                            'holiday_date' => $date,
                            'holiday_name' => $name,
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('success','อัพเดทวันหยุดเรียบร้อยแล้ว');
    }
}
