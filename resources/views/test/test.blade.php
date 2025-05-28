@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')

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

<h1> location test </h1>

    <div class="container">
        <h2>เลือกตำแหน่งที่ต้องการ</h2>
        <form id="locationForm" action="{{ route('location_test') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="latitude">ละติจูด (Latitude)</label>
                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
            </div>
            <div class="form-group">
                <label for="longitude">ลองจิจูด (Longitude)</label>
                <input type="text" class="form-control" id="longitude" name="longitude" readonly>
            </div>
            <button type="submit" class="btn btn-primary">บันทึกตำแหน่งปัจจุบัน</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                }, (error) => {
                    console.error('เกิดข้อผิดพลาดในการเข้าถึงตำแหน่ง: ' + error.message);
                });
            } else {
                console.error('เบราว์เซอร์ไม่รองรับการเข้าถึงตำแหน่งปัจจุบัน');
            }
        });
    </script>

@endsection
