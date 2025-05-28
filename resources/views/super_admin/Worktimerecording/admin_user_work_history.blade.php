{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br>

    <title>ประวัติการลงเวลาปฏิบัติงาน</title>
    <div class="container">
        <a href="{{ URL::previous() }}" class="btn btn-info">&laquo; กลับ</a>

        <h2 class="text-center">ประวัติการลงเวลาปฏิบัติงาน</h2><br>
        <p> ชื่อ : {{ $users->name }} </p>
        <p>หน่วยงาน : {{ $users->organization->organization_name }}</p>
        <p>แผนก : {{ $users->user_department }}</p>
        <p> รหัสประจำตัว : {{ $users->ldap_username }}</p>

        <br>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                ประวัติการลงเวลาปฏิบัติงาน
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>เวลา</th>
                            <th>เข้า-ออกงาน</th>
                            <th>ประเภท</th>
                            <th>สาย</th>
                            <th>พิกัด</th>
                            <th>หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_works as $row)
                            <tr>
                                <td class="date-cell"> {{ $row->attemp_date }} </td>
                                <td> {{ $row->attemp_time }} </td>
                                <td> {!! $row->InOutStatus !!} </td>
                                <th> {!! $row->AttempTypeName !!}</th>
                                <th>
                                    @if (isset($row->attemp_late_time))
                                        {{ $row->attemp_late_time }} นาที
                                    @endif
                                </th>
                                <td>
                                    {{-- <div class="text-center">
                                        <a class ="btn btn-secondary btn btn-sm"
                                            href = "https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}"
                                            target="_blank"><i class="bi bi-map"></i></a>
                                    </div> --}}
                                    <div class ="text-center">
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
                                        data-bs-target="{{ '#editModal_' . $row->id }}"><i class="bi bi-journal"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        {{-- <div class="table-responsive">
            <table id="data-table" class="table table-dark table-bordered mx-auto">
                <thead>
                    <tr class = "text-center">
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>เข้า-ออกงาน</th>
                        <th>ประเภท</th>
                        <th>สาย</th>
                        <th>พิกัด</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($user_works as $row)
                        <tr>
                            <td class="date-cell"> {{ $row->attemp_date }} </td>
                            <td> {{ $row->attemp_time }} </td>
                            <td> {!! $row->InOutStatus !!} </td>
                            <th> {!! $row->AttempTypeName !!}</th>
                            <th>
                                @if (isset($row->attemp_late_time))
                                    {{ $row->attemp_late_time }} นาที
                                @endif
                            </th>
                            <td class = "text-center"><a class ="btn btn-secondary btn btn-sm"
                                    href = "https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}"
                                    target="_blank"><i class="bi bi-map"></i></a>
                            </td>
                            <td class = "text-center">
                                <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="{{ '#editModal_' . $row->id }}"><i
                                    class="bi bi-journal"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>

    @foreach ($user_works as $row)
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
                            <p>ประเภท :
                                @if ($row->attemp_type == 2)
                                    นอกหน่วยงาน
                                @elseif($row->attemp_type == 3)
                                    ราชการ
                                @endif
                            </p>
                            <p>หมายเหตุ : {{ $row->attemp_describe }}</p>
                            <p>ภาพประกอบ :</p>
                            <img src="{{ Storage::url('image/' . $row->attemp_image) }}" class="img-fluid rounded-start"
                                alt="">
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

    <script src="{{ asset('js/admin_work_time_recording.js') }}"></script>
@endsection

{{-- <style>
    a {
        text-decoration: none;
        display: inline-block;
        padding: 8px 16px;
    }

    a:hover {
        background-color: black;
        color: white;
    }

    .previous {
        background-color: #f1f1f1;
        color: black;
    }

    .next {
        background-color: #04AA6D;
        color: white;
    }

    .round {
        border-radius: 50%;
    }
</style> --}}
