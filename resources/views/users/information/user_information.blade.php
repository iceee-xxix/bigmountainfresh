@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>

    <title>ข้อมูลผู้ใช้งาน</title>

    <div class="container mt-2">
        <h2 class="text-center">ข้อมูลผู้ใช้งาน</h2><br><br>
        <div class="row mx-auto">
            <div class="col-md-3">
                <div class="profile text-center"><img src="{{ asset('img/account_icon.png') }}"></div><br>
            </div>
            <div class="col-md-5 mt-4 user_info">
                <div class="name mb-2">ชื่อ : {{ Auth::user()->name }}</div>
                <div class="ldap mb-2">รหัส : {{ Auth::user()->ldap_username }}</div>
                <div class="email mb-2">อีเมล : {{ Auth::user()->email }}</div>
                <div class="level mb-2"> ระดับผู้ใช้งาน :
                    @if (Auth::user()->user_level == 1)
                        <span>ผู้ใช้งานทั่วไป</span>
                    @elseif(Auth::user()->user_level == 2)
                        <span>ผู้ดูแลระบบระดับมหาวิทยาลัย</span>
                    @elseif(Auth::user()->user_level == 3)
                        <span>ผู้ดูแลระบบระดับหน่วยงาน</span>
                    @elseif(Auth::user()->user_level == 4)
                        <span>ผู้บริหาร</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <style>
        .profile img {
            width: 150px;
            height: auto;
        }
    </style>

    <script src="{{ asset('js/user_information.js') }}"></script>
@endsection
