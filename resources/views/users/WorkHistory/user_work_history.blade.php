{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br>

    <title>ประวัติการทำงาน</title>

    <div class="container mt-3">
        <h2 class="text-center">ประวัติการทำงาน</h2>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    {{-- <div class="dayinmonth" style="margin-top: 40px;"></div> --}}
                    <br>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            ตารางแสดงประวัติการทำงาน
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th>ประเภท</th>
                                        <th>เวลาที่สาย</th>
                                        <th>พิกัด</th>
                                        <th>หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($work_history as $row)
                                        <tr>
                                            <td class="date-cell">{{ $row->attemp_date }}</td>
                                            <td>{{ $row->attemp_time }}</td>
                                            <td>{!! $row->InOutStatus !!}</td>
                                            <td>
                                                @if ($row->attemp_late_time)
                                                    {{ $row->attemp_late_time }} นาที
                                                @else
                                                    0 นาที
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($row->latitude && $row->longitude)
                                                        <a class ="btn btn-secondary btn btn-sm"
                                                            href="https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}"
                                                            target="_blank"><i class="bi bi-map"></i></a>
                                                    @else
                                                        <span> </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="{{ '#editModal_' . $row->id }}"><i
                                                            class="bi bi-journal"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @foreach ($work_history as $row)
                    <div class="modal fade" id="{{ 'editModal_' . $row->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'editModal_' . $row->id }}">หมายเหตุการทำงาน
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <p>ประเภทการลงเวลา :
                                            {!! $row->AttempTypeName !!}
                                        </p>
                                        <p>หมายเหตุ : {{ $row->attemp_describe }}</p>
                                        @if ( isset($row->attemp_image) )
                                        <p>รูปภาพอ้างอิง :</p>
                                            <img src="{{ Storage::url('image/' . $row->attemp_image) }}" class="img-fluid rounded-start"
                                            alt="">
                                        @endif
                                    </div>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                    {{-- <div class="table-responsive">
                        <table id="data-table" class="table table-dark table-bordered mx-auto">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>เวลา</th>
                                    <th>เข้า-ออกงาน</th>
                                    <th>เวลาที่สาย</th>
                                    <th>พิกัด</th>
                                    <td style="display:none;">
                                    <td style="display:none;">
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($work_history as $row)
                                    <tr>
                                        <td class="date-cell"> {{ $row->attemp_date }} </td>
                                        <td> {{ $row->attemp_time }} </td>
                                        <td> {!! $row->InOutStatus !!} </td>
                                        <td>
                                            @if ($row->attemp_late_time)
                                                {{ $row->attemp_late_time }} นาที
                                            @endif
                                        </td>
                                        <td class = "text-center">
                                            @if ($row->latitude && $row->longitude)
                                                <a class ="btn btn-secondary btn btn-sm"
                                                    href="https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}"
                                                    target="_blank"><i class="bi bi-map"></i></a>
                                            @else
                                                <span><i class="bi bi-map"></i></span>
                                            @endif
                                        <td style="display:none;">
                                            @php
                                                $month = date('m', strtotime($row->attemp_date));
                                            @endphp
                                            {{ $month }}
                                        </td>
                                        <td style="display:none;"> {{ $row->attemp_status }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/user_history.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateCells = document.querySelectorAll('.date-cell');
            dateCells.forEach(function(cell) {
                var dateString = cell.textContent.trim();
                var thaiDate = convertToThaiDate(dateString);
                cell.textContent = thaiDate;
            });
        });

        function convertToThaiDate(dateString) {
            var parts = dateString.split('-');
            var year = parts[0];
            var month = parseInt(parts[1]);
            var day = parts[2];

            var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
                'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];
            var thaiMonth = thaiMonths[month - 1];

            var thaiYear = parseInt(year) + 543;
            var thaiDay = parseInt(day);
            return thaiDay + ' ' + thaiMonth + ' ' + thaiYear;
        }
    </script>
@endsection
