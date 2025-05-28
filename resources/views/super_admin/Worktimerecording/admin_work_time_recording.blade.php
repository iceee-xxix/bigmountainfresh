{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br>
    <title>ตรวจสอบประวัติการลงเวลาปฏิบัติงาน</title>
    <br>

    <h2 class="text-center">ตรวจสอบประวัติการลงเวลาปฏิบัติงาน</h2><br>
    @if ( auth()->user()->user_level == 3 )
        <h4 class="text-center"> หน่วยงาน : {{ auth()->user()->organization->organization_name }} </h4><br>
    @endif

    {{-- <div class="flex-row-reverse">
            <a href="{{route('workReport')}}" class="btn btn-primary">Report</a>
        </div>
        <br> --}}

    <div class="card mb-4 col-md-11 mx-auto">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            ตารางข้อมูลการลงเวลาปฏิบัติงานของบุคลากร
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>หน่วยงาน</th>
                        <th>แผนก</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>ประเภท</th>
                        <th>นาทีที่สาย</th>
                        <th>พิกัด</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($worktimes as $worktime)
                        <tr>
                            <td><a href="{{ route('admin_user_work_history', ['id' => $worktime->users_id]) }}">
                                    {{ $worktime->User->name }} </a></td>
                            <td> {{ $worktime->User->organization->organization_name }} </td>
                            <td> {{ $worktime->User->user_department }} </td>
                            <td class="date-cell"> {{ $worktime->attemp_date }} </td>
                            <td> {{ $worktime->attemp_time }} </td>
                            <td class ="text-center"> {!! $worktime->InOutStatus !!} </td>
                            <th>
                                @if (isset($worktime->attemp_late_time))
                                    {{ $worktime->attemp_late_time }} นาที
                                @endif
                            </th>
                            <td>
                                <div class ="text-center">
                                    @if ($worktime->latitude && $worktime->longitude)
                                        <a class ="btn btn-secondary btn btn-sm"
                                            href="https://www.google.com/maps?q={{ $worktime->latitude }},{{ $worktime->longitude }}"
                                            target="_blank"><i class="bi bi-map"></i></a>
                                    @else
                                        <span> </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class ="text-center">
                                    <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="{{ '#editModal_' . $worktime->id }}"><i class="bi bi-journal"></i></a>
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
                    <tr class ="text-center">
                        <th>ชื่อพนักงาน</th>
                        <th>หน่วยงาน</th>
                        <th>แผนก</th>
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
                    @foreach ($worktimes as $worktime)
                        <tr>
                            <td><a href="{{ route('admin_user_work_history', ['id' => $worktime->users_id]) }}">
                                    {{ $worktime->User->name }} </a></td>
                            <td> {{ $worktime->User->organization->organization_name }} </td>
                            <td> {{ $worktime->User->user_department }} </td>
                            <td class="date-cell"> {{ $worktime->attemp_date }} </td>
                            <td> {{ $worktime->attemp_time }} </td>
                            <td class ="text-center"> {!! $worktime->InOutStatus !!} </td>
                            <th class ="text-center"> {!! $worktime->AttempTypeName !!}</th>
                            <th>
                                @if (isset($worktime->attemp_late_time))
                                    {{ $worktime->attemp_late_time }} นาที
                                @endif
                            </th>
                            <td class ="text-center"><a class ="btn btn-secondary btn btn-sm"
                                    href = "https://www.google.com/maps?q={{ $worktime->latitude }},{{ $worktime->longitude }}"
                                    target="_blank"><i class="bi bi-map"></i></a></td>
                            <td class ="text-center">
                                <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="{{ '#editModal_' . $worktime->id }}"><i class="bi bi-journal"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

    @foreach ($worktimes as $worktime)
        <div class="modal fade" id="{{ 'editModal_' . $worktime->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ 'editModal_' . $worktime->id }}">หมายเหตุการทำงาน
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="form-group">
                            <p>ประเภท :
                                {!! $worktime->AttempTypeName !!}
                            </p>
                            <p>หมายเหตุ : {{ $worktime->attemp_describe }}</p>
                            <p>ภาพประกอบ :</p>
                            <img src="{{ Storage::url('image/' . $worktime->attemp_image) }}"
                                class="img-fluid rounded-start" alt="">
                        </div> --}}
                        <div class="form-group">
                            <p>ประเภทการลงเวลา :
                                {!! $worktime->AttempTypeName !!}
                            </p>
                            <p>หมายเหตุ : {{ $worktime->attemp_describe }}</p>
                            @if ( isset($worktime->attemp_image) )
                            <p>รูปภาพอ้างอิง :</p>
                                <img src="{{ Storage::url('image/' . $worktime->attemp_image) }}" class="img-fluid rounded-start"
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

    <script src="{{ asset('js/admin_work_time_recording.js') }}"></script>
@endsection
