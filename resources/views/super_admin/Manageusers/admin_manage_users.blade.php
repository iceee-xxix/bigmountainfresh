{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <title>การจัดการข้อมูลบุคลากร</title>

    <br>

    <div class="container">
        <h2 class="text-center mt-3">การจัดการข้อมูลบุคลากร</h2><br>

        <br>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                ตารางการจัดการข้อมูลบุคลากร
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>รหัสประจำตัว</th>
                            <th>หน่วยงาน</th>
                            <th>แผนก</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->ldap_username }}</td>
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
                                <td>
                                    <div class="text-center">
                                        <div class="d-inline-block">
                                            <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="{{ '#editModal_' . $user->id }}">แก้ไข</a>
                                        </div>
                                        <div class="d-inline-block">
                                            <form action="{{ route('manageuserDelete', $user->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                            </form>
                                        </div>
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
                        <th>หน่วยงาน</th>
                        <th>แผนก</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->ldap_username }}</td>
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
                            <td class="text-center">
                                <div class="d-inline-block">
                                    <a class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="{{ '#editModal_' . $user->id }}">แก้ไข</a>
                                </div>
                                <div class="d-inline-block">
                                    <form action="{{ route('manageuserDelete', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">ลบ</button>
                                    </form>
                                </div>
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
                            <h5 class="modal-title" id="{{ 'editModal_' . $user->id }}">แก้ไขรายชื่อผู้ใช้
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('manageuserEdit', $user->id) }}", method="post">
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

                                <div class="form-group col-md-10 mx-auto">
                                    <label for="edit_name">ชื่อ :</label>
                                    <input type="text" name="edit_name" class="form-control"
                                        value="{{ $user->name }}">
                                </div>
                                <br>
                                <div class="form-group col-md-10 mx-auto">
                                    <label for="edit_ldap_username">รหัสประจำตัว :</label>
                                    <input type="text" name="edit_ldap_username" class="form-control"
                                        value="{{ $user->ldap_username }}">
                                </div>
                                <br>
                                <div class="form-group col-md-10 mx-auto">
                                    <label for="organization_id">เลือกหน่วยงาน:</label>
                                    <select class="form-select" name="organization_id" id="organization_id">
                                        <option selected disabled class="text-center">--- เลือก ---</option>
                                        @foreach ($organizations as $organization)
                                            <option value="{{ $organization->id }}">{{ $organization->organization_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="form-group col-md-10 mx-auto">
                                    <label for="edit_user_department">แผนก :</label>
                                    <input type="text" name="edit_user_department" class="form-control"
                                        value="{{ $user->user_department }}">
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

    <script src="{{ asset('js/admin_manage_users.js') }}"></script>

    <script>
        function checkSelection() {
            var optionSelect = document.getElementById("id").value;
            var submitButton = document.getElementById("submit_btn");

            if (optionSelect === "none") {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }
    </script>
@endsection
