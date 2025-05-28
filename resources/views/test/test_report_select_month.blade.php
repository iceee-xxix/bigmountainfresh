@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>
    <a href="{{ route('test_report')}}" class=" btn btn-primary">กลับ</a><br><br>

    <h2>รายงานการทำงาน</h2>
    <h3>รายงานประจำเดือน : <span id="selectedMonthDisplay"></span></h3><br>

    <div class="table-responsive">
        <table class="table table table-striped table-bordered mx-auto">
            <thead>
                <th class="text-center">ชื่อ/วันที่</th>
                @foreach ($dates as $date)
                    <th class="text-center">{{ $date }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($attempts->groupBy('users_id') as $userId => $userAttempts)
                    <tr>
                        <td>{{ $userAttempts->first()->user->name }}</td>
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
