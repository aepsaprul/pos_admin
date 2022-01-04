@extends('layouts.app')

@section('style')
<link href="{{ asset('lib/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

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
            <h6 class="text-uppercase text-center">Data Roles</h6>

            <div class="row mb-2 mt-1">
                <div class="col-md-4">
                    @if (Auth::user()->roles_id == 0)
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
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="table_one" class="table table-bordered">
                        <thead style="background-color: #32a893;">
                            <tr>
                                <th class="text-white text-center fw-bold">No</th>
                                <th class="text-white text-center fw-bold">Nama Roles</th>
                                <th class="text-white text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $item)
                                <tr
                                    @if ($key % 2 == 1)
                                        echo class="tabel_active";
                                    @endif
                                >
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
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
                                                        class="dropdown-item py-1 border-bottom btn-edit"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-pencil-alt border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Ubah
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        class="dropdown-item py-1 border-bottom btn-delete"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-trash-alt border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Hapus
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        class="dropdown-item py-1 btn-access"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-lock border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Akses
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
                    <h5 class="modal-title text-white">Tambah Roles</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_name" class="form-label">Nama</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_name"
                            name="create_name">
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
                    <h5 class="modal-title text-white">Ubah Roles</h5>
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
                            name="edit_name">
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

{{-- modal access  --}}
<div class="modal fade modal-access" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_access">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="access_id"
                    name="access_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Hak Akses Roles</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div id="navigation"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
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

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#table_one').DataTable({
            'ordering': false
        });

        $('#button-create').on('click', function() {
            $('.modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_name').focus();

        });

        $('#form_create').submit(function(e) {
            e.preventDefault();

            $('.modal-create').modal('hide');

            var formData = {
                name: $('#create_name').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.store') }} ',
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

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("roles.edit", ":id") }}';
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
                    $('#edit_id').val(response.id);
                    $('#edit_name').val(response.name);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.modal-edit').modal('hide');

            var formData = {
                id: $('#edit_id').val(),
                name: $('#edit_name').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.update') }}',
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
            var url = '{{ route("roles.delete_btn", ":id") }}';
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
                url: '{{ URL::route('roles.delete') }}',
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

        $('body').on('click', '.btn-access', function(e) {
            e.preventDefault();
            $('#navigation').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("roles.access", ":id") }}';
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
                    $('#access_id').val(response.id);

                    $.each(response.nav_mains, function(index, value) {
                        if (value.nav_sub.length == 0) {
                            var nav_main_value = "" +
                                "<div class=\"form-check\">" +
                                    "<input class=\"form-check-input check_nav_main\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_main[]\" id=\"check_nav_main_" + value.id + "\" data-id=\"" + value.id + "\"";

                                    $.each(response.roles_nav_mains, function(index, val) {
                                        if (val.nav_main_id == value.id) {
                                            nav_main_value += " checked";
                                        }
                                    });

                                    nav_main_value += ">" +
                                    "<label class=\"form-check-label\" for=\"check_nav_main_" + value.id + "\">" +
                                        value.title
                                    "</label>" +
                                "</div>";
                            $('#navigation').append(nav_main_value);
                        } else {
                            var nav_main_value = "" +
                                "<div class=\"form-check\">" +
                                    "<input class=\"form-check-input check_nav_main\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_main[]\" id=\"check_nav_main_" + value.id + "\" data-id=\"" + value.id + "\"";

                                    $.each(response.roles_nav_mains, function(index, val) {
                                        if (val.nav_main_id == value.id) {
                                            nav_main_value += " checked";
                                        }
                                    });

                                    nav_main_value += ">" +
                                    "<label class=\"form-check-label\" for=\"check_nav_main_" + value.id + "\">" +
                                        value.title
                                    "</label>" +
                                "</div>" +
                                "<ul class=\"list-group\">";
                                $.each(value.nav_sub, function(index, value) {
                                    nav_main_value += "" +
                                        "<li class=\"list-group-item p-0 border-0\">" +
                                            "<div class=\"form-check\">" +
                                                "<input class=\"form-check-input check_nav_sub\" type=\"checkbox\" value=\"" + value.id + "\" name=\"check_nav_sub[]\" id=\"check_nav_sub_" + value.id + "\" data-main=\"" + value.nav_main_id + "\"";

                                                $.each(response.roles_nav_subs, function(index, val) {
                                                    if (val.nav_sub_id == value.id) {
                                                        nav_main_value += " checked";
                                                    }
                                                });

                                                nav_main_value += ">" +
                                                "<label class=\"form-check-label\" for=\"check_nav_sub_" + value.id + "\">" +
                                                    value.title
                                                "</label>" +
                                            "</div>" +
                                        "</li>";
                                });
                                nav_main_value += "</ul>";
                            $('#navigation').append(nav_main_value);
                        }
                    });

                    $('.modal-access').modal('show');
                }
            });
        });

        $('#form_access').submit(function(e) {
            e.preventDefault();

            $('.modal-access').modal('hide');

            const check_nav_main = [];
            const check_nav_sub = [];

            $('.check_nav_main').each(function() {
                if ($(this).is(":checked")) {
                    check_nav_main.push($(this).val());
                }
            });

            $('.check_nav_sub').each(function() {
                if ($(this).is(":checked")) {
                    check_nav_sub.push($(this).val());
                }
            });

            var formData = {
                id: $('#access_id').val(),
                nav_main: check_nav_main,
                nav_sub: check_nav_sub,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('roles.access_save') }}',
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
