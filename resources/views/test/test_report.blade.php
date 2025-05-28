@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>

    <h2>รายงานการทำงาน</h2>
    <br>

    <div class="form-group">
        <label for="organization_id">รายงานการทำงานย้อนหลัง :</label>

        <form action="{{ route('generatePDF') }}" method="post">
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
                <div class="col-md-2">
                    <select name="selectedYear" id="selectedYear" class="form-select" onchange="checkSelection()">
                        <option value="none">เลือกปี</option>
                        @for ($year = now()->year; $year >= now()->year - 4; $year--)
                            <option value="{{ $year }}" {{ old('selectedYear', now()->year) == $year ? 'selected' : '' }}>
                                ปี {{ $year + 543 }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="submit_btn" disabled><i
                            class="bi bi-filetype-pdf"></i></button>
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

    <div class="table-responsive col-md-8">
        <table class="table table-striped table-bordered">
            <thead class="text-center">
                <th>ชื่อ</th>
                <th>หน่วยงาน</th>
                <th>แผนก</th>
                <th>มาทำงาน</th>
                <th>ขาดงาน</th>
                <th>ลางาน</th>
                <th>มาสาย</th>
                <th>สาย(นาที)</th>
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
                        <td>{{ $userReport['total_late_time'] }} นาที</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="form-group col-md-3">
            <label for="selectedMonth">แสดงผลตามเดือน :</label>
            <form action="{{ route('report_select_month')}}" method="get">
                <div class="input-group">
                    <select name="selectedMonth" id="selected" class="form-select" onchange="checkSelectionMonth()">
                        <option value="none">เดือนปัจจุบัน</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                {{ $month }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary" id="submit_btn_selected" disabled>เลือก</button>
                </div>
            </form>

            <script>
                function checkSelectionMonth() {
                    var selectedMonth = document.getElementById("selected").value;
                    var submitButton_Month = document.getElementById("submit_btn_selected");

                    if (selectedMonth === "none") {
                        submitButton_Month.disabled = true;
                    } else {
                        submitButton_Month.disabled = false;
                    }
                }
            </script>
        </div> --}}


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
    </div> --}}
@endsection
