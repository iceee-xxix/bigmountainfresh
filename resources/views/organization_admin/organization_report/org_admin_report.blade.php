{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <br>

    <title>สรุปรายงานการทำงาน</title>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <div class="text-center mt-3">
        <h2>สรุปรายงานการทำงาน</h2>
        {{-- <h4>เดือน : <span id="currentMonth">{{ $show_current_month }}</span></h4> --}}
        <h4>เดือน : <span id="currentMonth">{{ $show_current_month }}</span> ปี <span id="currentYear"></span></h4>
        <h4>หน่วยงาน : {{ Auth()->user()->organization->organization_name }}</h4>
    </div>

    <br>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="organization_id" style="font-size: 15px;">พิมพ์สรุปรายงานการทำงาน :</label>
                    {{-- <form action="{{ route('Org_reportSelectPDF') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <!-- เลือกเดือนเท่านั้น -->
                                <select name="selectedMonth" id="selectedMonth" class="form-select form-select-sm" aria-label="Small select example" onchange="checkSelection()">
                                    <option value="none">เลือกเดือน</option>
                                    @foreach ($months as $englishMonth => $thaiMonth)
                                        <option value="{{ $englishMonth }}" {{ $selectedMonth == $englishMonth ? 'selected' : '' }}>
                                            {{ $thaiMonth }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm" id="submit_btn" disabled><i class="bi bi-printer"></i>
                                    พิมพ์</button>
                            </div>
                        </div>
                    </form> --}}
                    <form action="{{ route('Org_reportSelectPDF') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <select name="selectedMonth" id="selectedMonth" class="form-select form-select-sm"
                                    aria-label="Small select example" onchange="checkSelection()">
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
                                <select name="selectedYear" id="selectedYear" class="form-select form-select-sm"
                                    aria-label="Small select example" onchange="checkSelection()">
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
                                        class="bi bi-printer"></i> พิมพ์</button>
                            </div>
                        </div>
                    </form>
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
                </div>

            </div>
        </div>
    </div>

    <script>
        function checkSelection() {
            var monthSelect = document.getElementById("selectedMonth").value;
            var submitButton = document.getElementById("submit_btn");

            // เช็คการเลือกเดือนเท่านั้น
            if (monthSelect !== "none") {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    </script>

    <br>

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

    <script src="{{ asset('js/org_admin_report.js') }}"></script>
@endsection
