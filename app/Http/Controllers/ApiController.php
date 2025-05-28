<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Holiday;

class ApiController extends Controller
{
    public function fetchData()
    {

        $current_year = Carbon::now()->year;
        $clientId = 'a376b25e-d6d5-40fc-b4e1-576e70364886';
        $apiUrl = 'https://apigw1.bot.or.th/bot/public/financial-institutions-holidays/?year=2024';

        $response = Http::withHeaders([
            'X-IBM-Client-Id' => $clientId,
        ])->get($apiUrl);

        // ตรวจสอบสถานะของ response
        if ($response->successful()) {
            $data = $response->json(); // ดึงข้อมูล JSON จาก response
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }

    public function holiday_fetch()
    {
        // ดึงข้อมูลวันหยุดทั้งหมดจากฐานข้อมูล
        $holidays = Holiday::pluck('holiday_date')->toArray();
        // ส่งข้อมูลวันหยุดกลับเป็น JSON ในรูปแบบของ Array
        return response()->json($holidays);
    }

}