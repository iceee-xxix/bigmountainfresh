{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>

<title>ลงเวลาเข้า - ออกงานประจำวัน</title>

<br>

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

<!-- Modal 2: ลงเวลานอกสถานที่ -->
<div class="modal fade" id="outsideModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="outsideModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outsideModalLabel">บันทึกเวลากรณีออกนอกหน่วยงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- เนื้อหาของ Modal 2 -->
                <form action='{{ route('insert') }}' method="POST" style="margin-top: 50px;"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control " name="user_id" value="{{ Auth()->user()->id }}"
                            hidden>
                        @if (isset($attemp_in->attemp_time))
                        <input type="text" class="form-control" name="workin"
                            value="{{ $attemp_in->attemp_time }}" hidden>
                        @else
                        <input type="text" class="form-control" name="workin" hidden>
                        @endif

                        @if (isset($attemp_out->attemp_time))
                        <input type="text" class="form-control" name="workout"
                            value="{{ $attemp_out->attemp_time }}" hidden>
                        @else
                        <input type="text" class="form-control" name="workout" hidden>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="attemp_type">เลือกประเถท :</label>
                        <select name="attemp_type" class="form-select" aria-label="Default select example" required>
                            <option disabled selected hidden>กรุณาเลือกประเภท</option>
                            <option value="2">นอกหน่วยงาน</option>
                            <option value="3">ราชการ</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="attemp_image" class="form-label">แนบรูปภาพประกอบ :</label>
                        <input class="form-control" type="file" id="formFile" name="attemp_image">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="attemp_describe">หมายเหตุ :</label>
                        <input type="text" name="attemp_describe" class="form-control"
                            placeholder="กรุณาระบุหมายเหตุ" required>

                        <input type="text" id="latitude" name="latitude" hidden>
                        <input type="text" id="longitude" name="longitude" hidden>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="container">

    <style>
        #map {
            height: 200px;
            width: 100%;
        }
    </style>
    <h2 class="date-cell text-center" style="font-size: 30px">{{ $current_date }}</h2>

    <h2 class=" text-center" id="epic" style="font-size: 25px"></h2>

    <div class="text-center" id="currentDateTime" style="margin-top: 20px; font-size: 25px;"></div>

    <form action='{{ route('insert') }}' method="post" style="margin-top: 20px;" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div id="map"></div>
                <script>
                    let map;

                    function initMap() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                (position) => {
                                    const userPos = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude,
                                    };
                                    $('#lat').val(userPos.lat);
                                    $('#lng').val(userPos.lng);

                                    map = new google.maps.Map(document.getElementById("map"), {
                                        center: userPos,
                                        zoom: 16,
                                        disableDefaultUI: false, // เปิด UI ปกติ
                                        clickableIcons: false, // ปิดคลิกไอคอน POI ต่าง ๆ
                                    });

                                    new google.maps.Marker({
                                        position: userPos,
                                        map: map,
                                        title: "คุณอยู่ที่นี่",
                                        draggable: false, // ไม่ให้ลาก marker ได้
                                    });

                                    map.addListener("click", function(e) {
                                        e.stop(); // ป้องกัน event คลิก
                                    });
                                },
                                () => {
                                    alert("ไม่สามารถระบุตำแหน่งได้");
                                }
                            );
                        } else {
                            alert("เบราว์เซอร์ไม่รองรับ Geolocation");
                        }
                    }
                </script>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB525cpMEpjYlG8HiWgBqPCbaZU6HHxprY&callback=initMap"></script>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="user_id">ชื่อพนักงาน</label>
                    <input type="text" class="form-control " name="user_id" value="{{ Auth::user()->name }}" readonly>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="workin">เวลาเข้างาน</label>
                    @if (isset($attemp_in->attemp_time))
                    <input type="text" class="form-control" name="workin" id="workin"
                        value="{{ $attemp_in->attemp_time }}" readonly>
                    @else
                    <input type="text" class="form-control" name="workin" id="workin" readonly>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="workout">เวลาออกงาน</label>
                    @if (isset($attemp_in->attemp_time))
                    @if (isset($attemp_out->attemp_time))
                    <input type="text" class="form-control" name="workout"
                        id="workout" value="{{ $attemp_out->attemp_time }}" readonly>
                    @else
                    {{-- @if ($current_time > '16:30:00')
                                    <input type="text" class="form-control" name="workout" readonly>
                                @else
                                    @php
                                        list($HH, $mm, $ii) = explode(':', $schedule_out->work_schedule_timeout); // แยกเวลาออกเป็นส่วนๆ
                                        $schedule_out_format = $HH . ':' . $mm; // รวมชั่วโมงและนาทีใหม่
                                    @endphp
                                    <br><span style="color: red; font-size: 17px; ">{{ $schedule_out_format }}น. ลงเวลาได้อีกครั้ง</span>
                    @endif --}}
                    @php
                    [$HH, $mm, $ii] = explode(':', $schedule_out->work_schedule_timeout); // แยกเวลาออกเป็นส่วนๆ
                    $schedule_out_format = $HH . ':' . $mm;
                    @endphp

                    @if ($current_time > $schedule_out_format)
                    <input type="text" class="form-control" name="workout" readonly>
                    @else
                    <br><span style="color: red; font-size: 17px;">{{ $schedule_out_format }}น.
                        ลงเวลาได้อีกครั้ง</span>
                    @endif
                    @endif
                    @else
                    <input type="text" class="form-control" name="workout" readonly>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="attemp_image">ถ่ายรูปสำหรับลงเวลา</label>
                    <input class="form-control" type="file" id="cameraInput" name="attemp_image" accept="image/*" capture="environment" required>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="save-working">ลงเวลา</label>
                    {{-- @dd($attemp_leave) --}}
                    @if (isset($attemp_leave))
                    <button type="submit" class="form-control btn btn-success" id="save-working"
                        disabled>ลาเรียบร้อยแล้ว</button>
                    @else
                    @if (isset($attemp_in->attemp_time) && isset($attemp_out->attemp_time))
                    <button type="submit" class="form-control btn btn-success" id="save-working"
                        disabled>ลงเวลาเรียบร้อยแล้ว</button>
                    @elseif (isset($attemp_in->attemp_time) &&
                    empty($attemp_out->attemp_time) &&
                    $current_time < $schedule_out->work_schedule_timeout)
                        <button type="submit" class="form-control btn btn-secondary" id="save-working"
                            disabled>บันทึกเวลา</button>
                        {{-- @elseif (empty($attemp_in->attemp_time) && empty($attemp_out->attemp_time) && $current_time < '00:00:00')
                                <button type="submit" class="form-control btn btn-primary" id="save-working"
                                    disabled>บันทึกเวลา</button> --}}
                        @else
                        <button type="submit" class="form-control btn btn-primary"
                            id="save-working">บันทึกเวลา</button>
                        @endif
                        @endif
                        <input type="text" id="latitude" name="latitude" hidden>
                        <input type="text" id="longitude" name="longitude" hidden>
                        <input type="text" name="attemp_type" value="1" hidden>
                </div>
            </div>
        </div>
    </form>

    <br>

    <div class="card mb-4 mt-4 col-md-12 mx-auto">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            การลงเวลาประจำวัน
            <!-- <div class="float-end">
                @if (isset($attemp_in->attemp_time) && isset($attemp_out->attemp_time))
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                    data-bs-target="#outsideModal" disabled>
                    ลงเวลานอกหน่วยงาน <i class="bi bi-geo-alt"></i>
                </button>
                @elseif (isset($attemp_in->attemp_time) &&
                empty($attemp_out->attemp_time) &&
                $current_time < $schedule_out->work_schedule_timeout)
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#outsideModal" disabled>
                        ลงเวลานอกหน่วยงาน <i class="bi bi-geo-alt"></i>
                    </button>
                    {{-- @elseif (empty($attemp_in->attemp_time) && empty($attemp_out->attemp_time) && $current_time < '07:30:00')
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#outsideModal" disabled>
                            ลงเวลานอกหน่วยงาน <i class="bi bi-geo-alt"></i>
                        </button> --}}
                    @else
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#outsideModal">
                        ลงเวลานอกหน่วยงาน <i class="bi bi-geo-alt"></i>
                    </button>
                    @endif
            </div> -->
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>ประเภท</th>
                        <th>ตำแหน่ง</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attemp_history as $attemp_histories)
                    @if ($attemp_histories->attemp_date === now()->format('Y-m-d'))
                    <tr>
                        <td> {{ $attemp_histories->attemp_date }} </td>
                        <td> {{ $attemp_histories->attemp_time }} </td>
                        <td class="text-center">
                            <?php if ($attemp_histories->attemp_late_time) {
                                echo 'มาสาย ' . $attemp_histories->attemp_late_time . ' นาที';
                            } else {
                                echo $attemp_histories->InOutStatus;
                            } ?>
                        </td>
                        <td style="font-size: 15px">
                            <div class="text-center">
                                @if ($attemp_histories->latitude && $attemp_histories->longitude)
                                <a class="btn btn-secondary btn btn-sm"
                                    href="https://www.google.com/maps?q={{ $attemp_histories->latitude }},{{ $attemp_histories->longitude }}"
                                    target="_blank"><i class="bi bi-map"></i></a>
                                @else
                                <span><i class="bi bi-map"></i></span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="{{ '#editModal_' . $attemp_histories->id }}"><i
                                        class="bi bi-journal"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endif
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

    {{-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <br>
                    <h4 style="margin-top: 50px; text-align: center;">การลงเวลาประจำวัน</h4><br>

                    <div class="table-responsive">
                        <table class="table table-dark table-bordered mx-auto">
                            <thead>
                                <tr>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">เวลา</th>
                                    <th class="text-center">เข้า-ออก</th>
                                    <th class="text-center">ตำแหน่ง</th>
                                    <th class="text-center">หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attemp_history as $attemp_histories)
                                    @if ($attemp_histories->attemp_date === now()->format('Y-m-d'))
                                        <tr>
                                            <td> {{ $attemp_histories->attemp_date }} </td>
    <td> {{ $attemp_histories->attemp_time }} </td>
    <td class="text-center"> {!! $attemp_histories->InOutStatus !!} </td>
    <td style="font-size: 15px" class="text-center">
        @if ($attemp_histories->latitude && $attemp_histories->longitude)
        <a class="btn btn-secondary btn btn-sm"
            href="https://www.google.com/maps?q={{ $attemp_histories->latitude }},{{ $attemp_histories->longitude }}"
            target="_blank"><i class="bi bi-map"></i></a>
        @else
        <span><i class="bi bi-map"></i></span>
        @endif
    </td>
    <td>
        <div class="text-center">
            <a class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                data-bs-target="{{ '#editModal_' . $attemp_histories->id }}"><i
                    class="bi bi-journal"></i></a>
        </div>
    </td>
    </tr>
    @endif
    @endforeach
    </tbody>
    </table>
    <br>
</div>
</div>
</div>
</div> --}}
</div>

@foreach ($attemp_history as $attemp_histories)
<div class="modal fade" id="{{ 'editModal_' . $attemp_histories->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ 'editModal_' . $attemp_histories->id }}">หมายเหตุการทำงาน
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>ประเภท : <?php if ($attemp_histories->attemp_late_time) {
                                    echo 'มาสาย ' . $attemp_histories->attemp_late_time . ' นาที';
                                } else {
                                    echo $attemp_histories->InOutStatus;
                                } ?>
                    </p>
                    <p>ถ่ายรูปสำหรับลงเวลา :</p>
                    <img src="{{ Storage::url('image/' . $attemp_histories->attemp_image) }}"
                        class="img-fluid rounded-start" alt="">
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

<script src="{{ asset('js/user_timestamp.js') }}"></script>

{{-- <select name="attemp_type" class="form-select">
        <option value="2">
            นอก</option>
        <option value="3">
            ราชการ
        </option>
    </select> --}}

@endsection