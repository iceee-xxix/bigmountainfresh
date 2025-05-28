@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />


    <br>
    <br>
    {{-- Alert --}}
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ $message }}',
            })
        </script>
    @elseif ($message = Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ $message }}',
            })
        </script>
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>หน้าหลัก</title>
    <div class="container mt-2">
        <h2 class="text-center">กำหนดวันลาบุคลากร</h2><br>
        @if (auth()->user()->user_level == 3)
            <h5 class="text-center">หน่วยงาน : {{ auth()->user()->organization->organization_name }} </h5>
        @endif
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="flex-row-reverse mt-4">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#resignationModal">
                            เพิ่มการลาของบุคลากร
                        </button>
                    </div>

                    <div class="card mb-4 mt-3">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            ตารางประวัติการกำหนดวันลา
                            {{-- <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                            data-bs-target="#resignationModal">
                            เพิ่มการลาของบุคลากร
                        </button> --}}
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ชื่อ</th>
                                        <th>หน่วยงาน</th>
                                        <th>ตำแหน่ง</th>
                                        <th>วันที่ลา</th>
                                        <th>เหตุผลการลา</th>
                                        <th>แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($work_leave_history as $row_history)
                                        <tr>
                                            <td> {{ $row_history->user->name }} </td>
                                            <td> {{ $row_history->user->organization->organization_name }} </td>
                                            <td> {{ $row_history->user->user_department }} </td>
                                            <td class="date-cell"> {{ $row_history->attemp_date }} </td>
                                            <td> {{ $row_history->attemp_describe }} </td>
                                            <td>
                                                <div class="text-center">
                                                    <form method="POST"
                                                        action="{{ route('work_leave_delete', ['id' => $row_history->id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="work_leave_date"
                                                            value="{{ $row_history->work_leave_date }}">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('คุณต้องการลบการลาในวันที่ {{ $row_history->work_leave_date }} ใช่หรือไม่?')"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal: ยื่นลางาน -->
                    <div class="modal fade" id="resignationModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="resignationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resignationModalLabel">กำหนดวันลาพนักงาน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- เนื้อหาของ Modal: ยื่นลางาน -->
                                    <form method="POST" action="{{ route('work_leave_submit') }}">
                                        @csrf
                                        <div class="form-group col-md-10 mx-auto">
                                            <label for="work_leave_describe">เลือกพนักงาน:</label>
                                            {{-- <select class="form-select" aria-label="Default select example"
                                                name="work_leave_user">
                                                @foreach ($user_selection as $user_select)
                                                    <option value="{{ $user_select->id }}">
                                                        {{ $user_select->name }} :
                                                        {{ $user_select->organization->organization_name }} :
                                                        {{ $user_select->user_department }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                            <select class="form-control select2" style="width: 100%; " aria-label="Default select example" name="work_leave_user" id="work_leave_user">
                                                <option value="none" selected disabled hidden>เลือกพนักงาน</option>
                                                @foreach ($user_selection as $user_select)
                                                    <option value="{{ $user_select->id }}">
                                                        {{ $user_select->name }} :
                                                        {{ $user_select->organization->organization_name }} :
                                                        {{ $user_select->user_department }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <script>
                                                $('.select2').select2({
                                                    dropdownParent: $('#resignationModal')
                                                });
                                            </script>
                                        </div><br>
                                        <div class="form-group col-md-10 mx-auto">
                                            <div class="form-group">
                                                <label for="dates">เลือกวันที่:</label>
                                                <input type="text" id="dates" name="work_leave_dates"
                                                    placeholder="เลือกวันที่" class="form-control">
                                            </div>
                                        </div><br>
                                        <div class="form-group col-md-10 mx-auto">
                                            <label for="work_leave_describe">เหตุผลในการลา:</label>
                                            <style>
                                                .select-custom{
                                                    width: 100%;
                                                    height: 35px;
                                                    border-radius: 7px;
                                                    border-color: rgba(128, 128, 128, 0.5);
                                                    color: rgb(61, 61, 61);
                                                    padding: 0px 5px 0px 5px;
                                                }
                                            </style>
                                            <select class="select-custom" aria-label="Default select example"
                                                id="work_leave_describe" name="work_leave_describe"
                                                onchange="showHideInput()">
                                                <option disabled selected hidden>กรุณาเลือกประเภท</option>
                                                <option value="ลาป่วย">ลาป่วย</option>
                                                <option value="ลากิจส่วนตัว">ลากิจส่วนตัว</option>
                                                <option value="ลาพักผ่อน">ลาพักผ่อน</option>
                                                <option value="ลาคลอดบุตร">ลาคลอดบุตร</option>
                                                <option value="none">อื่นๆ</option>
                                            </select>
                                        </div><br>
                                        <div class="form-group col-md-10 mx-auto" id="other_leave" style="display: none;">
                                            <label for="other_leave_description">ระบุเหตุผลในการลา:</label>
                                            <textarea class="form-control" id="other_leave_description" name="other_leave_description"></textarea>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <input type="text" class="form-control " name="user_id"
                                                value="{{ Auth()->user()->id }}" hidden>

                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div><br>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <br><br>

    <script src="{{ asset('js/admin_work_leave.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // เรียกใช้งาน Route สำหรับดึงข้อมูลวันหยุด
            fetch("{{ route('holiday_fetch') }}")
                .then(response => response.json())
                .then(data => {
                    // จัดเก็บข้อมูลวันหยุดไว้ในตัวแปร holidays
                    const holidays = data;

                    // เรียกใช้ flatpickr โดยใช้ข้อมูลวันหยุดเพื่อ disable วันที่
                    flatpickr('#dates', {
                        mode: 'multiple',
                        dateFormat: 'Y-m-d',
                        disable: holidays
                    });
                });
        });
    </script>
    <script type="text/javascript">
        function showHideInput() {
            var selectBox = document.getElementById("work_leave_describe");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var textareaDiv = document.getElementById("other_leave");
            if (selectedValue == "none") {
                textareaDiv.style.display = "block";
                // ไม่ส่งข้อมูลจาก dropdown และซ่อนช่อง input
                selectBox.removeAttribute('name');
                document.getElementById("other_leave_description").setAttribute('name', 'work_leave_describe');
            } else {
                textareaDiv.style.display = "none";
                // ส่งข้อมูลจาก dropdown และซ่อนช่อง input
                selectBox.setAttribute('name', 'work_leave_describe');
                document.getElementById("other_leave_description").removeAttribute('name');
            }
        }
    </script>
@endsection
