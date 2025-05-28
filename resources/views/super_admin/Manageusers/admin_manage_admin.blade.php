{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous">
    </script>

    <br>
    <br>

    <title>การจัดการแอดมิน</title>

    <div class="container">
        <h2 class="text-center">การจัดการแอดมิน</h2><br>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                ตารางการจัดการแอดมิน
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>หน่วยงาน</th>
                            <th>แผนก</th>
                            <th>Email</th>
                            <th>User Level</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if ($user->organization && $user->organization->organization_name)
                                        {{ $user->organization->organization_name }}
                                    @else
                                        <span class="text-center">ยังไม่ระบุหน่วยงาน</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->user_department === null)
                                        <span class="text-center">ยังไม่ระบุแผนก</span>
                                    @else
                                        {{ $user->user_department }}
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->user_level == 1)
                                        <span>ผู้ใช้งานทั่วไป</span>
                                    @elseif ($user->user_level == 2)
                                        <span>ผู้ดูแลระบบระดับมหาวิทยาลัย</span>
                                    @elseif ($user->user_level == 3)
                                        <span>ผู้ดูแลระบบระดับหน่วยงาน</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="{{ '#editModal_' . $user->id }}">แก้ไข</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="table-responsive">
            <table class="table table table-striped table-bordered mx-auto">
                <thead class="text-center">
                    <tr>
                        <th>ชื่อ</th>
                        <th>รหัสประจำตัว</th>
                        <th>Email</th>
                        <th>User Level</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->ldap_username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->user_level == 1)
                                    <span>ผู้ใช้งานทั่วไป</span>
                                @elseif ($user->user_level == 2)
                                    <span>ผู้ดูแลระบบระดับมหาวิทยาลัย</span>
                                @elseif ($user->user_level == 3)
                                    <span>ผู้ดูแลระบบระดับหน่วยงาน</span>
                                @elseif ($user->user_level == 4)
                                    <span>ผู้บริหาร</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="{{ '#editModal_' . $user->id }}">แก้ไข</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

        <!-- Modal Edit -->
        @foreach ($users as $user)
            <div class="modal fade" id="{{ 'editModal_' . $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ 'editModal_' . $user->id }}">แก้ไขระดับผู้ใช้
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('manageadminUpdate', $user->id) }}", method="post">
                                @csrf
                                @method('PUT')

                                @if ($message = Session::get('success'))
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: '{{ $message }}',
                                        })
                                    </script>
                                @endif

                                <div class="form-group">
                                    <label for="user_level" class="form-label">ระดับผู้ใช้ :</label>
                                    <select name="user_level" class="form-select">
                                        <option value="1" {{ $user->user_level == 1 ? 'selected' : '' }}>
                                            ผู้ใช้งานทั่วไป</option>
                                        <option value="2" {{ $user->user_level == 2 ? 'selected' : '' }}>
                                            ผู้ดูแลระบบระดับมหาวิทยาลัย</option>
                                        <option value="3" {{ $user->user_level == 3 ? 'selected' : '' }}>
                                            ผู้ดูแลระบบระดับหน่วยงาน</option>
                                        {{-- <option value="4" {{ $user->user_level == 4 ? 'selected' : '' }}>
                                            ผู้บริหาร</option> --}}
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- End Modal Edit -->

    </div>

    <script src="{{ asset('js/admin_manage_admin.js') }}"></script>
@endsection
