<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\DB;

class Managetime_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        WorkSchedule::create([
            'work_schedule_timein' => '08:30:00', // กำหนดเวลาเข้างาน
            'work_schedule_timeout' => '16:30:00', // กำหนดเวลาออกงาน
        ]);
    }
}
