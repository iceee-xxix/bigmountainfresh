{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <br>

    @if ($message = Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ $message }}',
            })
        </script>
    @endif

    <title>ปฏิทินวันหยุดราชการ</title>

    <div class="container mt-3">
        <h2 class="text-center">ปฏิทินวันหยุดประจำปี</h1><br>

            <div class="card mb-4 col-md-10 mx-auto">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    ตารางปฏิทินวันหยุดประจำปี
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>วันหยุด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $holiday)
                            <style>
                                .left {
                                    text-align: left;
                                }
                            </style>
                            <tr>
                                <td class="date-cell left"> {{ $holiday->holiday_date }} </td>
                                <td class="left"> {{ $holiday->holiday_name }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- <div class="row justify-content-center">
                <div class="col-md-7">
                    <table class="table table-dark table-bordered mx-auto">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>วันหยุด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $holiday)
                                <style>
                                    .left {
                                        text-align: left;
                                    }
                                </style>
                                <tr>
                                    <td class="date-cell left"> {{ $holiday->holiday_date }} </td>
                                    <td class="left"> {{ $holiday->holiday_name }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table><br>
                </div>
            </div> --}}
    </div>

    <script src="{{ asset('js/user_holiday.js') }}"></script>
@endsection
