@extends('layouts.layout')
@section('dashbord_layout')

<br>

<title>วันหยุด</title>

    <div class="container mt-5">
        <h1 class="text-center" id="thaiDate"></h1>
        <h2 class="text-center">ระบบลงเวลาปิด เนื่องจากเป็นวันหยุด <span class="text-danger">{{ $holiday_name }}</span></h2>
    </div>

    <script>
        // ฟังก์ชันสำหรับแปลงวันที่เป็นรูปแบบวันที่ไทย
        function thaiDate(dateString) {
            // สร้างวัตถุ Date จากวันที่ในรูปแบบ ISO
            var date = new Date(dateString);

            // รายการของเดือนภาษาไทย
            var thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

            // ดึงวันที่, เดือน, และปี
            var day = date.getDate();
            var month = date.getMonth();
            var year = date.getFullYear() + 543; // เพิ่ม 543 เพื่อแปลงปีเป็นปีไทย

            // สร้างข้อความในรูปแบบวันที่ไทย
            var thaiDateStr = day + " " + thaiMonths[month] + " " + year;

            return thaiDateStr;
        }

        // เมื่อเอกสารโหลดเสร็จสมบูรณ์
        document.addEventListener("DOMContentLoaded", function() {
            // ดึงวันที่จากค่าที่ส่งมาจาก Controller
            var holidayDate = "{{ $holiday_date }}";

            // เรียกใช้งานฟังก์ชันแปลงวันที่ไทยและแสดงผลใน element ที่มี id="thaiDate"
            document.getElementById("thaiDate").innerText = "วันที่ " + thaiDate(holidayDate);
        });
    </script>


@endsection
