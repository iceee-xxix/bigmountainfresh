<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/layout_styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">

    <style>
        .nav-right {
            margin-left: auto;
            margin-right: 10px;
        }

        body {
            font-family: "Kanit", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>

    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #191970;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('adminIndex') }}" style="font-size: 18px;"><i
                class="bi bi-calendar-check"></i>&nbsp;ระบบลงเวลาปฏิบัติงาน</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars" style="font-size: 20px; color: rgba(255, 255, 255, 0.5);"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="font-size: 14px;">{{ Auth::user()->name }}&nbsp;</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item pb-2 text-center" href="#!" style="font-size: 15px;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            ออกจากระบบ
                        </a>
                        <form id="logout-form" action="{{ route('user.signoutCallback') }}" method="GET"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        @if (auth()->user()->user_level == 2)
                        <div class="sb-sidenav-menu-heading">ผู้ดูแลระบบระดับมหาลัย</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="bi bi-pencil-square"></i></div>
                            การจัดการข้อมูล
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="{{ route('addholidayIndex') }}">กำหนดปฏิทินวันหยุดประจำปี</a>
                                <a class="nav-link" href="{{ route('managetimeIndex') }}">กำหนดเวลาเข้า - ออกงาน</a>
                                <a class="nav-link" href="{{ route('manageuserIndex') }}">จัดการข้อมูลบุคลากร</a>
                                <a class="nav-link" href="{{ route('OrganizationIndex') }}">จัดการหน่วยงาน</a>
                                <a class="nav-link" href="{{ route('manageadminIndex') }}">การจัดการแอดมิน</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="{{ route('reportIndex') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-calendar-week"></i></div>
                            สรุปรายงานการทำงาน
                        </a>
                        <a class="nav-link" href="{{ route('worktimerecordingIndex') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-clock-history"></i></div>
                            ตรวจสอบการลงเวลา
                        </a>
                        <a class="nav-link" href="{{ route('work_leave_index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-calendar-minus"></i></div>
                            กำหนดวันลาบุคลากร
                        </a>
                        @elseif(auth()->user()->user_level == 3)
                        <div class="sb-sidenav-menu-heading">ผู้ดูแลระบบระดับหน่วยงาน</div>
                        <a class="nav-link" href="{{ route('Org_reportIndex') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-calendar-week"></i></div>
                            สรุปรายงานการทำงาน
                        </a>
                        <a class="nav-link" href="{{ route('worktimerecordingIndex') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-clock-history"></i></div>
                            ตรวจสอบการลงเวลา
                        </a>
                        <a class="nav-link" href="{{ route('work_leave_index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-calendar-minus"></i></div>
                            กำหนดวันลาบุคลากร
                        </a>
                        @endif

                        <div class="sb-sidenav-menu-heading">สำหรับผู้ใช้ทั่วไป</div>
                        <a class="nav-link" href="{{ route('userTimestampIndex') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-clock"></i></div>
                            ลงเวลาเข้าและออกงาน
                        </a>
                        <a class="nav-link" href="{{ route('userWorkhistory') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-clock-history"></i></div>
                            ประวัติการทำงาน
                        </a>
                        <a class="nav-link" href="{{ route('work_leave_index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-journal-text"></i></div>
                            คำขอลา
                        </a>
                        <a class="nav-link" href="{{ route('userHoliday') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-calendar2-week"></i></div>
                            ปฏิทินวันหยุดราชการ
                        </a>
                    </div>
                </div>
                {{-- <div class="sb-sidenav-footer">
                    <div class="small">ชื่อ :</div>
                    แผนก :
                </div> --}}
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- content -->
                    @yield('dashbord_layout')
                    <!-- end content -->
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted mx-auto">© 2025 , So Smart Solution</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/layout_scripts.js') }}"></script>
</body>

</html>