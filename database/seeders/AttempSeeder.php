<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // วันที่เริ่มต้นและสิ้นสุด
        $startDate = Carbon::create(2024, 5, 2);
        $endDate = Carbon::create(2024, 5, 28);

        // วนลูปทุกวันในเดือนพฤษภาคม 2024
        while ($startDate->lte($endDate)) {
            // ข้ามวันเสาร์และอาทิตย์
            if (!$startDate->isWeekend()) {
                // เพิ่มเวลา 08:30:00 น.
                DB::table('attemp')->insert([
                    'attemp_date' => $startDate->toDateString(),
                    'users_id' => 2,
                    'attemp_in_out' => 1,
                    'attemp_type' => 1,
                    'attemp_time' => '08:30:00',
                    'attemp_late_time' => null,
                    'latitude' => '15.688550428666275',
                    'longitude' => '100.10709374758582',
                    'attemp_describe' => null,
                    'attemp_image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // เพิ่มเวลา 16:30:00 น.
                DB::table('attemp')->insert([
                    'attemp_date' => $startDate->toDateString(),
                    'users_id' => 2,
                    'attemp_in_out' => 2,
                    'attemp_type' => 1,
                    'attemp_time' => '16:30:00',
                    'attemp_late_time' => null,
                    'latitude' => '15.688550428666275',
                    'longitude' => '100.10709374758582',
                    'attemp_describe' => null,
                    'attemp_image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // เพิ่มวันถัดไป
            $startDate->addDay();
        }
    }
}
