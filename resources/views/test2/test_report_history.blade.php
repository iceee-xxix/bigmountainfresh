@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>

    <h2 class="text-center">สรุปการลงเวลา</h2><br>

    <div class="table-responsive col-md-8 mx-auto">
        <table class="table table-striped table-bordered">
            <thead class="text-center">
                <th>ชื่อ</th>
                <th>หน่วยงาน</th>
                <th>แผนก</th>
                <th>มาทำงาน</th>
                <th>ขาดงาน</th>
                <th>ลางาน</th>
                <th>มาสาย</th>
            </thead>
            <tbody>
                @foreach ($userReports as $userReport)
                    <tr>
                        <td>{{ $userReport['name'] }}</td>
                        <td>{{ $userReport['organization_name'] }}</td>
                        <td>{{ $userReport['user_department'] }}</td>
                        <td class="text-center">{{ $userReport['work_count'] }} วัน</td>
                        <td class="text-center">{{ $userReport['absent_count'] }} วัน</td>
                        <td class="text-center">{{ $userReport['leave_count'] }} วัน</td>
                        <td class="text-center">{{ $userReport['late_count'] }} วัน</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
