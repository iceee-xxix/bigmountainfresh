<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 12px;
            text-align: center;
        }
    </style>

    <title>PDF Report</title>
</head>
<body>
    <style>
        @page {
            size: A4 landscape;
        }

        table {
            border-collapse: collapse;
            margin: auto;
        }

        td,
        th {
            border: 1px solid;
            width: 20px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    <h2>สรุปรายงานการทำงาน</h2>
    <h4>รายงานประจำเดือน : {{ $selectedMonthThai }} ปี {{ $selectedYearThai }}</h4>
    <h4>หน่วยงาน : {{ $organization->organization_name }}</h4><br>
    <table>
        <table>
            <thead>
                <tr>
                    <th class="text-center">ชื่อ/วันที่</th>
                    <th class="text-center">แผนก</th>
                    @foreach ($dates as $date)
                        <th class="text-center">{{ $date }}</th>
                    @endforeach
                    <th class="text-center">เซ็นชื่อ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedAttempts as $userId => $userAttempts)
                    <tr>
                        <td style="font-size: 10px; width: 100px; text-align: left;">{{ $userAttempts[0]->user->name }}</td>
                        <td style="font-size: 10px; width: 100px; text-align: left;">{{ $userAttempts[0]->user->user_department }}</td>

                        @foreach ($dates as $date)
                            <td class="text-center" style="font-size: 13px;">
                                @foreach ($userAttempts as $attempt)
                                    @if (Carbon\Carbon::parse($attempt->attemp_date)->format('d') == $date)
                                        @if ($attempt->attemp_type == 1 || $attempt->attemp_type == 2 || $attempt->attemp_type == 3)
                                            /
                                        @elseif ($attempt->attemp_type == 4)
                                            ล
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                        <td style="width: 100px"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </table>

    <div class="page-break"></div>

    <h2>สรุปรายงานการทำงาน</h2>
    <h4>รายงานประจำเดือน : {{ $selectedMonthThai }} ปี {{ $selectedYearThai }}</h4>
    <h4>หน่วยงาน : {{ $organization->organization_name }}</h4><br>

    <table>
        <table>
            <thead>
                <th>ชื่อ</th>
                <th>แผนก</th>
                <th>มาทำงาน</th>
                <th>ขาดงาน</th>
                <th>ลางาน</th>
                <th>มาสาย</th>
                <th>สาย(นาที)</th>
                <th>เซ็นชื่อ</th>
            </thead>
            <tbody>
                @foreach ($userReports as $userReport)
                    <tr>
                        <td style="width: 150px; text-align: left;">{{ $userReport['name'] }}</td>
                        <td style="width: 150px; text-align: left;">{{ $userReport['user_department'] }}</td>
                        <td style="width: 80px;">{{ $userReport['work_count'] }} วัน</td>
                        <td style="width: 80px;">{{ $userReport['absent_count'] }} วัน</td>
                        <td style="width: 80px;">{{ $userReport['leave_count'] }} วัน</td>
                        <td style="width: 80px;">{{ $userReport['late_count'] }} วัน</td>
                        <td style="width: 95px;">{{ $userReport['total_late_time'] }} นาที</td>
                        <td style="width: 100px;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </table>
</body>


</html>
