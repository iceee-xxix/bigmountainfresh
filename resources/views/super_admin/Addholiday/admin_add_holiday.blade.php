{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br><br>

    <title>กำหนดปฏิทินการปฏิบัติงานประจำปี</title>


    <div class="container">
        <h2 class="text-center">กำหนดปฏิทินวันหยุดประจำปี {{ date('Y') + 543 }}</h2><br><br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('api_holiday_update') }}" class="btn btn-secondary btn-sm">อัพเดทวันหยุดราชการ</a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            เพิ่มวันหยุด
                        </button>
                    </div>
                </div>

                <br>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        ตารางปฏิทินวันหยุดประจำปี {{ date('Y') + 543 }}<span class="float-end">จำนวนวันหยุดทั้งหมด : {{ $totalHolidays }}
                            วัน</span>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>วันหยุด</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($holidays as $holiday)
                                    <tr>
                                        <td class="date-cell"> {{ $holiday->holiday_date }} </td>
                                        <td> {{ $holiday->holiday_name }} </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="d-inline-block">
                                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="{{ '#editModal_' . $holiday->id }}"><i
                                                            class="bi bi-pencil-square"></i></a>
                                                </div>
                                                <div class="d-inline-block">
                                                    <form action="{{ route('deleteHoliday', $holiday->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <table class="table table table-striped table-bordered mx-auto">
                    <thead class="text-center">
                        <tr>
                            <th>วันที่</th>
                            <th>วันหยุด</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($holidays as $holiday)
                            <tr>
                                <td class="date-cell"> {{ $holiday->holiday_date }} </td>
                                <td> {{ $holiday->holiday_name }} </td>
                                <td class="text-center">
                                    <div class="d-inline-block">
                                        <a class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="{{ '#editModal_' . $holiday->id }}"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                    <div class="d-inline-block">
                                        <form action="{{ route('deleteHoliday', $holiday->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </div>

            <!-- Modal Create-->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">กำหนดวันหยุด</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('holidayCreate') }}" method="post">
                                @csrf

                                @if ($message = Session::get('success'))
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: '{{ $message }}',
                                        })
                                    </script>
                                @endif

                                <div class="form-group">
                                    <label for="holiday_date">วัน/เดือน/ปี :</label>
                                    <input type="date" name="holiday_date" class="form-control" required>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="holiday_name">วันหยุด :</label>
                                    <input type="text" name="holiday_name" class="form-control"
                                        placeholder="กรุณาระบุวันหยุด" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Create -->

            <!-- Modal Edit -->
            @foreach ($holidays as $holiday)
                <div class="modal fade" id="{{ 'editModal_' . $holiday->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{ 'editModal_' . $holiday->id }}">แก้ไขวันหยุดการปฏิบัติงาน
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('holidayUpdate', $holiday->id) }}", method="post">
                                    @csrf
                                    @method('PUT')

                                    @if ($message = Session::get('success'))
                                        <script>
                                            Swal.fire({
                                                icon: 'success',
                                                title: '{{ $message }}',
                                            })
                                        </script>
                                    @endif

                                    <div class="form-group col-md-6">
                                        <label for="holiday_date">วัน/เดือน/ปี :</label>
                                        <input type="date" name="holiday_date" class="form-control"
                                            value="{{ $holiday->holiday_date }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="holiday_name">หมายเหตุ :</label>
                                        <input type="text" name="holiday_name" class="form-control"
                                            value="{{ $holiday->holiday_name }}" placeholder="กรุณาระบุหมายเหตุ" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- End Modal Edit -->

        </div>
    </div>

    {{-- <script src="{{ asset('js/user_holiday.js') }}"></script> --}}
    <script src="{{ asset('js/admin_add_holiday.js') }}"></script>
@endsection
{{-- <style>
    .add-button {
        text-decoration: none;
        display: inline-block;
        padding: 5px 10px;
        background-color: blue;
        color: white;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .add-button:hover {
        background-color: rgb(0, 0, 139);
        color:white;
    }
</style> --}}
