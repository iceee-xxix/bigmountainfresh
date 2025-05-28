{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br><br>

    <title>กำหนดเวลาเข้า/ออกงาน</title>

    <div class="container">
        <h2 class="text-center">กำหนดเวลาเข้า - ออกงาน</h2><br>
        <div class="row justify-content-center">

            <div class="col-md-9">
                {{-- <div class="row">
                    <div class="col">
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                กำหนดเวลางาน
                            </button>
                    </div>
                </div> --}}

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        ตารางกำหนด เวลาเข้า - ออกงาน
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>เวลาเข้างาน</th>
                                    <th>เวลาออกงาน</th>
                                    <th>วันที่กำหนดล่าสุด</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workschedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->work_schedule_timein }}</td>
                                        <td>{{ $schedule->work_schedule_timeout }}</td>
                                        <td>{{ $schedule->updated_at }}</td>
                                        <td class="col-md-2">
                                            <div class="text-center">
                                                <div class="d-inline-block">
                                                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="{{ '#editModal_' . $schedule->id }}">แก้ไข</a>
                                                </div>
                                                <div class="d-inline-block">
                                                    <form action="{{ route('managetimeDelete', $schedule->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
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

                <style>
                    .datatable-top>div:first-child {
                        display: none;
                    }

                    .datatable-top>div:last-child {
                        display: none;
                    }

                    .datatable-bottom {
                        display: none;
                    }
                </style>

                {{-- <table class="table table table-striped table-bordered mx-auto">
                    <thead>
                        <tr>
                            <th>เวลาเข้างาน</th>
                            <th>เวลาออกงาน</th>
                            <th>วันที่กำหนดล่าสุด</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workschedules as $schedule)
                            <tr>
                                <td>{{ $schedule->work_schedule_timein }}</td>
                                <td>{{ $schedule->work_schedule_timeout }}</td>
                                <td>{{ $schedule->updated_at }}</td>
                                <td class="text-center col-md-2">
                                    <div class="d-inline-block">
                                        <a class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="{{ '#editModal_' . $schedule->id }}">แก้ไข</a>
                                    </div>
                                    <div class="d-inline-block">
                                        <form action="{{ route('managetimeDelete', $schedule->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">ลบ</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">กำหนดเวลางาน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('managetimeCreate') }}" method="post">
                                @csrf

                                @if ($message = Session::get('success'))
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: '{{ $message }}',
                                        })
                                    </script>
                                @endif

                                @if ($message = Session::get('error'))
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: '{{ $message }}',
                                        })
                                    </script>
                                @endif

                                <div class="form-group col-md-6 mx-auto">
                                    <label for="holiday_date">กำหนดเวลาเข้างาน :</label>
                                    <input type="time" name="work_schedule_timein" class="form-control" required>
                                </div>
                                <br>
                                <div class="form-group col-md-6 mx-auto">
                                    <label for="holiday_date">กำหนดเวลาออกงาน :</label>
                                    <input type="time" name="work_schedule_timeout" class="form-control" required>
                                </div>
                                <br>
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
            @foreach ($workschedules as $schedule)
                <div class="modal fade" id="{{ 'editModal_' . $schedule->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{ 'editModal_' . $schedule->id }}">แก้ไขกำหนดเวลางาน
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('managetimeUpdate', $schedule->id) }}", method="post">
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

                                    <div class="form-group col-md-6 mx-auto">
                                        <label for="holiday_date">กำหนดเวลาเข้างาน :</label>
                                        <input type="time" name="work_schedule_timein" class="form-control"
                                            value="{{ $schedule->work_schedule_timein }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group col-md-6 mx-auto">
                                        <label for="holiday_date">กำหนดเวลาออกงาน :</label>
                                        <input type="time" name="work_schedule_timeout" class="form-control"
                                            value="{{ $schedule->work_schedule_timeout }}" required>
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

    <script src="{{ asset('js/admin_manage_time_work.js') }}"></script>
@endsection
