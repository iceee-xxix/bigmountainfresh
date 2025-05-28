<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class holidays_2024_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holidays = [
            [
                'holiday_date' => '2024-01-01',
                'holiday_name' => 'วันขึ้นปีใหม่',
            ],
            [
                'holiday_date' => '2024-02-26',
                'holiday_name' => 'วันหยุดชดเชยวันมาฆบูชา',
            ],
            [
                'holiday_date' => '2024-04-08 ',
                'holiday_name' => '	วันหยุดชดเชยวันจักรี',
            ],
            [
                'holiday_date' => '2024-04-012',
                'holiday_name' => 'วันหยุดพิเศษ (วันหยุดราชการ)',
            ],
            [
                'holiday_date' => '2024-04-15',
                'holiday_name' => '	วันสงกรานต์',
            ],
            [
                'holiday_date' => '2024-04-16',
                'holiday_name' => 'วันหยุดชดเชยวันสงกรานต์',
            ],
            [
                'holiday_date' => '2024-05-01',
                'holiday_name' => 'วันแรงงานแห่งชาติ',
            ],
            [
                'holiday_date' => '2024-05-06',
                'holiday_name' => 'วันหยุดชดเชยวันฉัตรมงคล',
            ],
            [
                'holiday_date' => '2024-05-06',
                'holiday_name' => 'วันหยุดชดเชยวันฉัตรมงคล',
            ],
            [
                'holiday_date' => '2024-05-22',
                'holiday_name' => 'วันวิสาขบูชา ',
            ],
            [
                'holiday_date' => '2024-06-03',
                'holiday_name' => 'วันเฉลิมพระชนมพรรษาสมเด็จพระนางเจ้าสุทิดา',
            ],
            [
                'holiday_date' => '2024-07-22',
                'holiday_name' => 'วันหยุดชดเชยวันอาสาฬหบูชา',
            ],
            [
                'holiday_date' => '2024-07-29',
                'holiday_name' => 'วันหยุดชดเชยวันเฉลิมพระชนมพรรษาพระบาทสมเด็จพระเจ้าอยู่หัว',
            ],
            [
                'holiday_date' => '2024-08-12',
                'holiday_name' => 'วันแม่แห่งชาติ',
            ],
            [
                'holiday_date' => '2024-10-14',
                'holiday_name' => 'วันหยุดชดเชยวันคล้ายวันสวรรคตรัชกาลที่ 9',
            ],
            [
                'holiday_date' => '2024-10-23',
                'holiday_name' => 'วันปิยมหาราช',
            ],
            [
                'holiday_date' => '2024-12-5',
                'holiday_name' => '	วันคล้ายวันพระราชสมภพรัชกาลที่ 9 วันชาติ และ วันพ่อแห่งชาติ',
            ],
            [
                'holiday_date' => '2024-12-10',
                'holiday_name' => 'วันรัฐธรรมนูญ',
            ],
            [
                'holiday_date' => '2024-12-30',
                'holiday_name' => 'วันหยุดพิเศษ (วันหยุดราชการ)',
            ],
            [
                'holiday_date' => '2024-12-31',
                'holiday_name' => 'วันสิ้นปี',
            ],
        ];

        DB::table('holidays')->insert($holidays);
    }
}
