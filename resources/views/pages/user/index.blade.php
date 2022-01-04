@extends('layouts.app')

@section('style')
<link href="{{ asset('lib/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('lib/select2/css/select2.min.css') }}">

<style>
    .col-md-12,
    .col-md-12 button,
    .col-md-12 a {
        font-size: 12px;
    }
    .fas {
        font-size: 14px;
    }
    .btn {
        padding: .2rem .6rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h6 class="text-uppercase text-center">Data User</h6>

            <div class="row mb-2 mt-1">
                <div class="col-md-4">
                    <button
                        id="button-create"
                        type="button"
                        class="btn"
                        title="Tambah">
                            <i
                                class="fas fa-plus border border-0 py-2 me-2 text-white"
                                style="background-color: #32a893; margin-left: -10px; padding-right: 10px; padding-left: 10px;">
                            </i> Tambah
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="table_one" class="table table-bordered">
                        <thead style="background-color: #32a893;">
                            <tr>
                                <th class="text-white text-center fw-bold">No</th>
                                <th class="text-white text-center fw-bold">Nama</th>
                                <th class="text-white text-center fw-bold">Email</th>
                                <th class="text-white text-center fw-bold">Roles</th>
                                <th class="text-white text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                                <tr
                                    @if ($key % 2 == 1)
                                        echo class="tabel_active";
                                    @endif
                                >
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->employee)
                                            {{ $item->employee->email }}
                                        @else
                                            Email tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->roles)
                                            {{ $item->roles->name }}
                                        @else
                                            Roles tidak ada
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button
                                                type="button"
                                                class="dropdown-toggle text-white border border-0 py-1"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                                style="background-color: #32a893;">
                                                    <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button
                                                        class="dropdown-item py-1 btn-delete"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-trash-alt border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mb-5"></div>
    </div>
</div>

{{-- modal create  --}}
<div class="modal fade modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah User</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_employee_id" class="form-label">Nama Karyawan</label>
                        <select name="create_employee_id" id="create_employee_id" class="form-control form-control-sm select2_employee">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control form-control-sm"
                            id="create_password"
                            name="create_password"
                            maxlength="100"
                            required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="" id="view_password">
                            <label class="form-check-label" for="view_password" style="font-size: 12px;">
                                Lihat Password
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="create_roles" class="form-label">Roles</label>
                        <select id="create_roles" name="create_roles" class="form-control form-control-sm" required>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal edit  --}}
<div class="modal fade modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="edit_id"
                    name="edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah User</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_name"
                            name="edit_name"
                            maxlength="50"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_roles" class="form-label">Roles</label>
                        <select id="edit_roles" name="edit_roles" class="form-control form-control-sm" required>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal delete  --}}
<div class="modal fade modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_delete">

                {{-- id  --}}
                <input type="hidden" id="delete_id" name="delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary text-center" data-bs-dismiss="modal" style="width: 100px;">Tidak</button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal proses berhasil  --}}
<div class="modal fade modal-proses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Proses sukses.... <i class="fas fa-check" style="color: #32a893;"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('lib/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('lib/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#table_one').DataTable({
            'ordering': false
        });

        $('#button-create').on('click', function() {
            $('#create_roles').empty();
            $('#create_employee_id').empty();

            $.ajax({
                url: '{{ URL::route('user.create') }}',
                type: 'GET',
                success: function(response) {
                    var employee_val = "<option value=\"\">--Pilih Karyawan--</option>";

                    $.each(response.employees, function(index, value) {
                        employee_val += "<option value=\"" + value.id + "\">" + value.full_name + "</option>";
                    });

                    var roles_val = "<option value=\"\">--Pilih Roles--</option>";

                    $.each(response.roles, function(index, value) {
                        roles_val += "<option value=\"" + value.id + "\">" + value.name + "</option>";
                    });

                    $('#create_employee_id').append(employee_val);
                    $('#create_roles').append(roles_val);
                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_employee_id').focus();

            $('.select2_employee').select2({
                dropdownParent: $('.modal-create')
            });
        });

        $('#view_password').on('change', function() {
            if ($('#view_password').is(":checked")) {
                $('#create_password').attr('type', 'text');
            } else {
                $('#create_password').attr('type', 'password');
            }
        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            $('.modal-create').modal('hide');

            var formData = {
                employee_id: $('#create_employee_id').val(),
                email: $('#create_email').val(),
                password: $('#create_password').val(),
                roles: $('#create_roles').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('user.store') }} ',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var id = $(this).attr('data-id');
            var url = '{{ route("user.delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.delete_title').append(response.name);
                    $('#delete_id').val(response.id);
                    $('.modal-delete').modal('show');
                }
            });
        });

        $('#form_delete').submit(function(e) {
            e.preventDefault();

            $('.modal-delete').modal('hide');

            var formData = {
                id: $('#delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('user.delete') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');
                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                }
            });
        });
    } );
</script>
@endsection
