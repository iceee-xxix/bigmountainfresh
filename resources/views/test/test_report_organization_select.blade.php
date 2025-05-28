@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')

<br>

<a href="{{ route('test_report')}}" class=" btn btn-primary">กลับ</a><br><br>

<h2>รายงานการทำงาน</h2><br>
<h4>รายงานประจำเดือน : <span id="selectedMonthDisplay"></span></h4>
<h5>หน่วยงาน : {{ $organization->organization_name }}</h5><br>

<div class="table-responsive">
    <table class="table table-striped table-bordered mx-auto">
        <thead>
            <tr>
                <th class="text-center">ชื่อ/วันที่</th>
                <th class="text-center">แผนก</th>
                @foreach ($dates as $date)
                    <th class="text-center">{{ $date }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedAttempts as $userId => $userAttempts)
                <tr>
                    <td>{{ $userAttempts->first()->user->name }}</td>
                    <td>{{ $userAttempts->first()->user->user_department }}</td>
                    @foreach ($dates as $date)
                        <td class="text-center" style="font-size: 13px;">
                            @foreach ($userAttempts as $attempt)
                                @if (Carbon\Carbon::parse($attempt->attemp_date)->format('d') == $date)
                                    @if (isset($attempt->attemp_in))
                                        /
                                    @endif
                                    @if (isset($attempt->attemp_out))
                                        /
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function checkSelectionMonth() {
        var selectedMonth = document.getElementById("selectedMonth").value;
        var submitButton_Month = document.getElementById("submit_btn_month");

        if (selectedMonth === "none") {
            submitButton_Month.disabled = true;
        } else {
            submitButton_Month.disabled = false;
        }
    }

    var englishMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ];
        var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
            'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        var selectedMonth = '{{ $selectedMonth }}';
        var index = englishMonths.indexOf(selectedMonth);

        document.getElementById('selectedMonthDisplay').innerText = thaiMonths[index];
</script>

@endsection
