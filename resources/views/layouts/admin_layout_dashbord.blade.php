<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <title>Document</title> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="bi bi-list" style="font-size: 33px;"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="{{ route('adminIndex') }}">ระบบลงเวลาปฏิบัติงาน</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                @if (auth()->user()->user_level == 2)
                    <li class="sidebar-item">
                        <a class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#menu"
                            aria-expanded="false" aria-controls="menu">
                            <i class="bi bi-database-add"></i>
                            <span style="font-size: 13px;">ผู้ดูแลระบบระดับมหาวิทยาลัย</span>
                        </a>
                        <ul id="menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('worktimerecordingIndex') }}" class="sidebar-link"
                                    style="font-size: 12px"><i class="bi bi-dot"></i>ตรวจสอบการลงเวลา</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('reportIndex')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>รายงานการทำงาน</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('OrganizationIndex')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>จัดการหน่วยงาน</a>
                            </li>
                            {{-- <li class="sidebar-item">
                                <a href="{{ route('SubOrganizationIndex')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>จัดการหน่วยงานย่อย</a>
                            </li> --}}
                            <li class="sidebar-item">
                                <a href="{{route('manageuserIndex')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>จัดการข้อมูลบุคลากร</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('addholidayIndex') }}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>กำหนดปฏิทินวันหยุดประจำปี</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('managetimeIndex') }}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>กำหนดเวลาเข้า - ออกงาน</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('manageadminIndex') }}" class="sidebar-link"
                                    style="font-size: 12px"><i class="bi bi-dot"></i>การจัดการแอดมิน</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('work_leave_index')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>ตรวจสอบการลา</a>
                            </li>

                        </ul>
                    </li>
                @elseif(auth()->user()->user_level == 3)
                    <li class="sidebar-item">
                        <a class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#menu"
                            aria-expanded="false" aria-controls="menu">
                            <i class="bi bi-database-add"></i>
                            <span>ผู้ดูแลระบบระดับหน่วยงาน</span>
                        </a>
                        <ul id="menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('worktimerecordingIndex') }}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>ตรวจสอบการลงเวลา</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('Org_reportIndex')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>รายงานการทำงาน</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('work_leave_index')}}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>ตรวจสอบการลา</a>
                            </li>
                        </ul>
                    </li>
                @elseif(auth()->user()->user_level == 4)
                    <li class="sidebar-item">
                        <a class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#menu"
                            aria-expanded="false" aria-controls="menu">
                            <i class="bi bi-database-add"></i>
                            <span>สำหรับผู้บริหาร</span>
                        </a>
                        <ul id="menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('worktimerecordingIndex') }}" class="sidebar-link" style="font-size: 12px"><i
                                        class="bi bi-dot"></i>ตรวจสอบการลงเวลา</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- menu user --}}
                <li class="sidebar-item">
                    <a class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#menuUser"
                        aria-expanded="false" aria-controls="menuUser">
                        <i class="bi bi-clock"></i>
                        <span>สำหรับผู้ใช้ทั่วไป</span>
                    </a>
                    <ul id="menuUser" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        {{-- <li class="sidebar-item">
                            <a href="{{ route('userInformation') }}" class="sidebar-link" style="font-size: 12px">
                                <i class="bi bi-dot"></i>
                                <span>ข้อมูลผู้ใช้</span>
                            </a>
                        </li> --}}
                        <li class="sidebar-item">
                            <a href="{{ route('userTimestampIndex') }}" class="sidebar-link" style="font-size: 12px">
                                <i class="bi bi-dot"></i>
                                <span>ลงเวลาเข้า - ออกงาน</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('userWorkhistory') }}" class="sidebar-link" style="font-size: 12px">
                                <i class="bi bi-dot"></i>
                                <span>ประวัติการทำงาน</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('userHoliday') }}" class="sidebar-link" style="font-size: 12px">
                                <i class="bi bi-dot"></i>
                                <span>ปฏิทินวันหยุดราชการ</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a href="{{ route('work_leave_user_index') }}" class="sidebar-link" style="font-size: 12px">
                                <i class="bi bi-dot"></i>
                                <span>ยื่นเรื่องขอลางาน</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                {{-- end menu user --}}

            </ul>

            {{-- <div class="sidebar-footer">
                <a href="#" class="sidebar-link col-md-4" style="background: #0e2238">
                    <i class="bi bi-box-arrow-left"></i>
                </a>
            </div> --}}

        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-1">
                <form action="#" class="d-none d-sm-inline-block"></form>
                <div class="navbar-collapse collapse" style="height: 50px">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <p class="mt-3" style="color: #515356; font-size: 13px">
                                    {{ Auth::user()->name }} <i class="bi bi-caret-down-fill"></i>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded mt-1 py-1">
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">
                                    <i class='bx bx-log-out' id="log_out"></i>
                                    <span style="margin-right: 50px; font-size: 13px">Logout</span>
                                    <i class="bi bi-box-arrow-left" style="font-size: 16px"></i></a>
                                <form id="logout-form" action="{{ route('user.signoutCallback') }}" method="GET"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <!-- content -->
                        @yield('admin_dashbord')
                        <!-- end content -->
                    </div>
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    {{-- <div class="row text-body-secondary"> --}}
                        <p class="text-center mt-2 mb-2"> Footer </p>
                        {{-- <div class="col-6 text-start">
                            <a class="text-body-secondary">
                                <strong style="font-size: 13px" class="text-center">
                                    footer
                                </strong>
                            </a>
                        </div> --}}
                    {{-- </div> --}}
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/admin_dashboard.js') }}"></script>
</body>

</html>
