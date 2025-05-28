@extends('layouts.admin_layout_dashbord')

@section('admin_dashbord')
    <br>

    <title></title>

    <div class="container">
        <h2 class="text-center mt-3"> จัดการหน่วยงานย่อย </h2>

        <div class="form-group">
            <a href="{{ route('SubOrganizationIndex') }}" class="btn btn-primary"><i class="bi bi-arrow-left"> กลับ</i></a>
        </div> <br>

        <div class="flex-row-reverse">
            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal"
                data-bs-target="#CreateSubOrganization">
                เพิ่มหน่วยงานย่อย
            </button>
        </div>

        <div class="modal fade" id="CreateSubOrganization" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มหน่วยงานย่อย</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @if ($message = Session::get('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ $message }}',
                                })
                            </script>
                        @endif

                        @foreach ($organization as $data)
                            <form action="{{ route('CreateSelectSubOrganization') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="organization_parent_id">คณะ/สำนัก : </label>
                                    <input type='hidden' name ="organization_parent_id" value="{{ $data->id }}">
                                    <input type="text" name="organization_parent_name" value="{{ $data->name }}"
                                        class="form-control" required readonly></input>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="organization_name">แผนก/ตำแหน่ง :</label>
                                    <input type="text" name="organization_name" class="form-control" required><br>
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
        <h5 class="text-center"> {{ $data->name }}</h5><br>
        @endforeach

        <div class="table-responsive">
            <table id="data-table" class="table table table-striped table-bordered mx-auto">
                <thead class="text-center">
                    <tr class="table-secondary">
                        <th class="text-center">id</th>
                        <th class="text-center">หน่วยงานย่อย</th>
                        <th class="text-center">แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sub_organization as $row)
                        <tr>
                            <td class="text-center">{{ $row->id }}</td>
                            <td>{{ $row->organization_name }}</td>
                            <td class="text-center col-md-3">
                                <div class="d-inline-block">
                                    <a class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="{{ '#editModal_' . $row->id }}">แก้ไข</a>
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

        <!-- Modal Edit -->
        @foreach ($sub_organization as $row)
            <div class="modal fade" id="{{ 'editModal_' . $row->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ 'editModal_' . $row->id }}">แก้ไขรายชื่อผู้ใช้
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('EditSelectSubOrganization', $row->id) }}", method="post">
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
                                    <input type="hidden" name="id" value="{{ $row->id }}" class="form-control"
                                        required>
                                    <label for="organization_name">แผนก/ตำแหน่ง :</label>
                                    <input type="text" name="organization_name" value="{{ $row->organization_name }}"
                                        class="form-control" required>
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

    </div>
@endsection
