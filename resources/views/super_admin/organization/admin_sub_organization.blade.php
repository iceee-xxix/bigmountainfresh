@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>

    <div class="container">
        <h2 class="text-center">จัดการหน่วยงานย่อย</h2><br>

        <div class="form-group col-md-6">
            <label for="option_id">เลือกตามหน่วยงาน :</label>
            <form id="myForm" action="{{ route('SubOrganization_Select') }}" method="get">
                <div class="input-group">
                    <select id="id" name="id" class="form-select" onchange="checkSelection()">
                        <option value="none" selected>เลือกหน่วยงาน</option>
                        @foreach ($option as $item)
                            <option value="{{ $item->id }}">{{ $item->organization_name }}</option>
                        @endforeach
                    </select>
                    <button id="submit_btn" type="submit" class="btn btn-primary" disabled>เลือก</button>
                </div>
            </form>
        </div>


        <div class="flex-row-reverse">
            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="bi bi-plus-circle"></i> เพิ่ม
            </button>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table table table-striped table-bordered mx-auto">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>หน่วยงานหลัก</th>
                        <th>หน่วยงานย่อย</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sub_organization as $organization)
                        <tr>
                            <td class="text-center">{{ $organization->id }}</td>
                            <td>{{ $organization->parent->organization_name }}</td>
                            <td>{{ $organization->organization_name }}</td>
                            <td class="text-center ">
                                <div class="d-inline-block">
                                    <a class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="{{ '#editModal_' . $organization->id }}">แก้ไข</a>
                                </div>
                                <div class="d-inline-block">
                                    {{-- <form action="{{ route('', $organization->id) }}" method="post"> --}}
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
        </div>

        <!-- Modal Create-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มหน่วยงาน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('CreateSubOrganization') }}" method="post">
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
                                <label for="organization_parent_id">คณะ/หน่วยงาน :</label>
                                <select name="organization_parent_id" class="form-select">
                                    @foreach ($option as $item)
                                        <option value="{{ $item->id }}">{{ $item->organization_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="organization_name">แผนก/ตำแหน่ง :</label>
                                <input type="text" name="organization_name" class="form-control" required>
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
        @foreach ($sub_organization as $organization)
            <div class="modal fade" id="{{ 'editModal_' . $organization->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ 'editModal_' . $organization->id }}">แก้ไขหน่วยงานย่อย
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('EditOrganization', $organization->id) }}", method="post">
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
                                    <label for="organization_name">หน่วยงานย่อย :</label>
                                    <input type="text" name="organization_name"
                                        value="{{ $organization->organization_name }}" class="form-control" required>
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

    </div>

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
