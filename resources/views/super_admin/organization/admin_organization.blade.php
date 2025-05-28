{{-- @extends('layouts.admin_layout_dashbord')
@section('admin_dashbord') --}}
@extends('layouts.layout')
@section('dashbord_layout')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <br>
    <br>
    <title>จัดการหน่วยงานหลัก</title>
    <div class="container col-md-6">
        <h2 class="text-center">จัดการหน่วยงานหลัก</h2><br>

        <div class="flex-row-reverse">
            <button type="button" class="btn btn-primary btn-sm mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-plus-circle"></i> เพิ่ม
            </button>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>หน่วยงาน</th>
                            <th>แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organization_show as $Organization)
                            <tr>
                                <td class="text-center">{{ $Organization->id }}</td>
                                <td>{{ $Organization->organization_name }}</td>
                                <td class="col-md-3">
                                    <div class="text-center">
                                        <div class="d-inline-block">
                                            <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="{{ '#editModal_' . $Organization->id }}">แก้ไข</a>
                                        </div>
                                        <div class="d-inline-block">
                                            <form action="{{ route('DeleteOrganization', $Organization->id) }}" method="post">
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

        {{-- <table class="table table table-striped table-bordered mx-auto">
            <thead>
                <tr>
                    <th class="text-center">id</th>
                    <th class="text-center">หน่วยงาน</th>
                    <th class="text-center">แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($organization_show as $Organization)
                    <tr>
                        <td class="text-center">{{ $Organization->id }}</td>
                        <td>{{ $Organization->organization_name }}</td>
                        <td class="text-center col-md-3">
                            <div class="d-inline-block">
                                <a class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="{{ '#editModal_' . $Organization->id }}">แก้ไข</a>
                            </div>
                            <div class="d-inline-block">
                                <form action="{{ route('DeleteOrganization', $Organization->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">ลบ</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>

        <!-- Modal Create-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มหน่วยงานหลัก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('CreateOrganization') }}" method="post">
                            @csrf

                            @if ($message = Session::get('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ $message }}',
                                    })
                                </script>
                            @endif

                            @if ($message = Session::get('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ $message }}',
                                    })
                                </script>
                            @endif

                            <div class="form-group">
                                <label for="organization_name">ชื่อหน่วยงานหลัก :</label>
                                <input id="organization_name" type="text" name="organization_name" class="form-control"
                                    required>
                                <br>
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
        <!-- End Modal Create-->

        <!-- Modal Edit -->
        @foreach ($organization_show as $Organization)
            <div class="modal fade" id="{{ 'editModal_' . $Organization->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ 'editModal_' . $Organization->id }}">แก้ไขชื่อหน่วยงานหลัก
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('EditOrganization', $Organization->id) }}", method="post">
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
                                    <label for="organization_name">ชื่อหน่วยงานหลัก :</label>
                                    <input id="organization_name" type="text" name="organization_name"
                                        class="form-control" value="{{ $Organization->organization_name }}" required>
                                    <br>
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
        <!--end  Modal Edit -->


    <script src="{{ asset('js/admin_organization.js') }}"></script>
@endsection
