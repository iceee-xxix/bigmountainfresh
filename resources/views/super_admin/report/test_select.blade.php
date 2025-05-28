@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')

<br>

<title>หน้าหลัก</title>

<div class="container">
    <h1 class="text-center">Report</h1><br>

    <a href="{{route('test_report')}}" class="btn btn-primary"><- กลับ</a>

<br>
<h3 id="selectedMonthDisplay" class="text-center"></h3><br>

    <table class="table table table-striped table-bordered mx-auto">
        <thead>
            <th scope="col">ชื่อ/วันที่</th>
            @foreach ($dates as $date)
                <th scope="col">{{ $date }}</th>
            @endforeach
        </thead>
        <tbody>

        </tbody>
      </table>
</div>

<script>
    var englishMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var selectedMonth = '{{ $selectedMonth }}';
    var index = englishMonths.indexOf(selectedMonth);

    document.getElementById('selectedMonthDisplay').innerText = thaiMonths[index];
</script>

@endsection
