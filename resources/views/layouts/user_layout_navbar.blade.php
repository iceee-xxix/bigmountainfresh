<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>ระบบลงเวลาปฏิบัติงาน</title>
    <link rel="stylesheet" href="{{ asset('css/user_layout.css') }}" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name"><a href="{{route('userIndex')}}" style="color: white;">ระบบลงเวลาปฏิบัติงาน</a></div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <ul class="nav-list">
            <li>
                <a href="{{ route('userInformation') }}">
                    <i class="bx bx-user"></i>
                    <span class="links_name">ข้อมูลผู้ใช้</span>
                </a>
                <span class="tooltip">ข้อมูลผู้ใช้</span>
            </li>
            <li>
                <a href="{{ route('userTimestampIndex') }}">
                    <i class='bx bx-time'></i>
                    <span class="links_name">ลงเวลาเข้า - ออกงาน</span>
                </a>
                <span class="tooltip">ลงเวลาเข้า - ออกงาน</span>
            </li>
            <li>
                <a href="{{ route('userWorkhistory')}}">
                    <i class='bx bx-history'></i>
                    <span class="links_name">ประวัติการทำงาน</span>
                </a>
                <span class="tooltip">ประวัติการทำงาน</span>
            </li>
            <li>
                <a href="{{ route('userHoliday')}}">
                    <i class='bx bx-calendar'></i>
                    <span class="links_name">ปฏิทินวันหยุด</span>
                </a>
                <span class="tooltip">ปฏิทินวันหยุด</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="{{ asset('img/account_icon.png') }}" alt="profileImg" />
                    <div class="name_job">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="job">รหัส : {{ Auth::user()->ldap_username }}</div>
                    </div>
                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out' id="log_out"></i></a>
                    <form id="logout-form" action="{{ route('user.signoutCallback') }}" method="GET"
                        style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="container">
            @yield('user_navbar')
        </div>
    </section>

    <style>
        ol,
        ul {
            padding-left: initial;
        }

        a {
            text-decoration: none;
        }

        #log_out:hover {
            color: red;
        }
    </style>

    <script src="{{ asset('js/user_layout.js') }}"></script>
</body>

</html>
