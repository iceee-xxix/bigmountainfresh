{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br>
    <br>

    <title>สรุปรายงานการทำงาน</title>

    <div class="text-center">
        <h2>สรุปรายงานการทำงาน</h2>
        {{-- <h4>เดือน : <span id="thaiMonth"></span></h4> --}}
        <h4>เดือน : <span id="thaiMonth"></span> ปี <span id="thaiYear"></span></h4>
    </div>
    <br>

    {{-- <div class="form-group">
        <label for="organization_id">รายงานการทำงานย้อนหลัง :</label>
        <form action="{{ route('reportSelectPDF') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select" id="selected_organization_id" name="organization_id"
                        onchange="checkSelection()">
                        <option value="none">เลือกหน่วยงาน</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->organization_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="selectedMonth" id="selectedMonth" class="form-select" onchange="checkSelection()">
                        <option value="none">เลือกเดือน</option>
                        @foreach ($months as $englishMonth => $thaiMonth)
                            <option value="{{ $englishMonth }}" {{ $selectedMonth == $englishMonth ? 'selected' : '' }}>
                                {{ $thaiMonth }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="submit_btn" disabled><i class="bi bi-printer"></i> พิมพ์</button>
                </div>
            </div>
        </form>
    </div> --}}

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- <div class="form-group">
                    <label for="organization_id">รายงานการทำงานย้อนหลัง :</label>
                    <form action="{{ route('reportSelectPDF') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" aria-label="Small select example" id="selected_organization_id" name="organization_id"
                                    onchange="checkSelection()">
                                    <option value="none">เลือกหน่วยงาน</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->organization_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="selectedMonth" id="selectedMonth" class="form-select form-select-sm" aria-label="Small select example"
                                    onchange="checkSelection()">
                                    <option value="none">เลือกเดือน</option>
                                    @foreach ($months as $englishMonth => $thaiMonth)
                                        <option value="{{ $englishMonth }}"
                                            {{ $selectedMonth == $englishMonth ? 'selected' : '' }}>
                                            {{ $thaiMonth }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm" id="submit_btn" disabled><i
                                        class="bi bi-printer"></i> พิมพ์</button>
                            </div>
                        </div>
                    </form>
                </div> --}}

                <div class="form-group">
                    <label for="organization_id" style="font-size: 15px;">พิมพ์สรุปรายงานการทำงาน :</label>
                    <form action="{{ route('reportSelectPDF') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" aria-label="Small select example" id="selected_organization_id" name="organization_id"
                                    onchange="checkSelection()">
                                    <option value="none">เลือกหน่วยงาน</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->organization_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="selectedMonth" id="selectedMonth" class="form-select form-select-sm" aria-label="Small select example"
                                    onchange="checkSelection()">
                                    <option value="none">เลือกเดือน</option>
                                    @foreach ($months as $englishMonth => $thaiMonth)
                                        <option value="{{ $englishMonth }}"
                                            {{ $selectedMonth == $englishMonth ? 'selected' : '' }}>
                                            {{ $thaiMonth }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="selectedYear" id="selectedYear" class="form-select form-select-sm" aria-label="Small select example"
                                    onchange="checkSelection()">
                                    <option value="none">เลือกปี</option>
                                    @for ($year = now()->year; $year >= now()->year - 4; $year--)
                                        <option value="{{ $year }}"
                                            {{ old('selectedYear', now()->year) == $year ? 'selected' : '' }}>
                                            ปี {{ $year + 543 }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm" id="submit_btn" disabled><i
                                        class="bi bi-filetype-pdf"></i> พิมพ์</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        function checkSelection() {
                            var organizationSelect = document.getElementById("selected_organization_id").value;
                            var monthSelect = document.getElementById("selectedMonth").value;
                            var yearSelect = document.getElementById("selectedYear").value;
                            var submitButton = document.getElementById("submit_btn");

                            if (organizationSelect !== "none" && monthSelect !== "none" && yearSelect !== "none") {
                                submitButton.disabled = false;
                            } else {
                                submitButton.disabled = true;
                            }
                        }
                    </script>
                </div>

                <br>

                <div class="card mb-4 mx-auto ">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        ตารางสรุปการทำงาน
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>หน่วยงาน</th>
                                    <th>แผนก</th>
                                    <th>มาทำงาน</th>
                                    <th>ขาดงาน</th>
                                    <th>ลางาน</th>
                                    <th>มาสาย</th>
                                    <th>สาย(นาที)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userReports as $userReport)
                                    <tr>
                                        <td>{{ $userReport['name'] }}</td>
                                        <td>{{ $userReport['organization_name'] }}</td>
                                        <td>{{ $userReport['user_department'] }}</td>
                                        <td>{{ $userReport['work_count'] }} วัน</td>
                                        <td>{{ $userReport['absent_count'] }} วัน</td>
                                        <td>{{ $userReport['leave_count'] }} วัน</td>
                                        <td>{{ $userReport['late_count'] }} วัน</td>
                                        <td>{{ $userReport['total_late_time'] }} นาที</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- <div class="table-responsive">
        <table class="table table table-striped table-bordered mx-auto">
            <thead>
                <th class="text-center">ชื่อ/วันที่</th>
                <th class="text-center">หน่วยงาน</th>
                <th class="text-center">แผนก</th>
                @foreach ($dates as $date)
                    <th class="text-center">{{ $date }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($attempts->groupBy('users_id') as $userId => $userAttempts)
                    <tr>
                        <td>{{ $userAttempts->first()->user->name }}</td>
                        <td style="font-size: 13px;">
                            @if (isset($userAttempts->first()->user->organization->organization_name) && !is_null($userAttempts->first()->user->organization->organization_name))
                                {{ $userAttempts->first()->user->organization->organization_name }}
                            @else
                                ยังไม่ระบุหน่วยงาน
                            @endif
                        </td>

                        <td>{{ $userAttempts->first()->user->user_department }}</td>
                        @foreach ($dates as $date)
                            <td class="text-center" style="font-size: 13px;">
                                @foreach ($userAttempts as $attempt)
                                    @if (Carbon\Carbon::parse($attempt->attemp_date)->format('d') == $date)
                                            @if ($attempt->attemp_type == 1 || $attempt->attemp_type == 2 || $attempt->attemp_type == 3)
                                                /
                                            @elseif ( $attempt->attemp_type == 4 )
                                                ล
                                            @endif
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    {{-- <div class="table-responsive col-md-8">
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
    </div> --}}

    <script src="{{ asset('js/admin_report.js') }}"></script>

    {{-- <script>
        function checkSelection() {
            var organizationSelect = document.getElementById("selected_organization_id").value;
            var monthSelect = document.getElementById("selectedMonth").value;
            var submitButton = document.getElementById("submit_btn");

            if (organizationSelect !== "none" && monthSelect !== "none") {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    </script> --}}

    <script>
        // ตัวแปรเดือนภาษาอังกฤษ
        var englishMonth = "{{ $show_current_month }}";

        // Object ที่เก็บชื่อเดือนภาษาอังกฤษและเดือนภาษาไทย
        var months = {
            'January': 'มกราคม',
            'February': 'กุมภาพันธ์',
            'March': 'มีนาคม',
            'April': 'เมษายน',
            'May': 'พฤษภาคม',
            'June': 'มิถุนายน',
            'July': 'กรกฎาคม',
            'August': 'สิงหาคม',
            'September': 'กันยายน',
            'October': 'ตุลาคม',
            'November': 'พฤศจิกายน',
            'December': 'ธันวาคม'
        };

        // แปลงเดือนภาษาอังกฤษเป็นเดือนภาษาไทย
        var thaiMonth = months[englishMonth];

        // รับปีปัจจุบันจากระบบของผู้ใช้และแปลงเป็นปีไทย
        var currentYear = new Date().getFullYear();
        var thaiYear = currentYear + 543;

        // แสดงเดือนภาษาไทยและปีไทยใน element ที่มี id="thaiMonth" และ id="thaiYear"
        document.getElementById("thaiMonth").innerHTML = thaiMonth;
        document.getElementById("thaiYear").innerHTML = thaiYear;
    </script>
@endsection
