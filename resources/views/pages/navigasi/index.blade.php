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
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h6 class="text-uppercase text-center">Data Navigasi</h6>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-2 mt-1">
                        <div class="col-md-4">
                            <button
                                id="main-button-create"
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
                                        <th class="text-white text-center fw-bold">Title</th>
                                        <th class="text-white text-center fw-bold">Link</th>
                                        <th class="text-white text-center fw-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nav_mains as $key => $item)
                                        <tr
                                            @if ($key % 2 == 1)
                                                echo class="tabel_active";
                                            @endif
                                        >
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td><span class="main_title_{{ $item->id }}">{{ $item->title }}</span></td>
                                            <td><span class="main_link_{{ $item->id }}">{{ $item->link }}</span></td>
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
                                                                class="dropdown-item main-btn-edit border-bottom"
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
                                                                class="dropdown-item main-btn-delete"
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
                <div class="col-md-6">
                    <div class="row mb-2 mt-1">
                        <div class="col-md-4">
                            <button
                                id="sub-button-create"
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
                            <table id="table_two" class="table table-bordered">
                                <thead style="background-color: #32a893;">
                                    <tr>
                                        <th class="text-white text-center fw-bold">No</th>
                                        <th class="text-white text-center fw-bold">Title</th>
                                        <th class="text-white text-center fw-bold">Link</th>
                                        <th class="text-white text-center fw-bold">Nav Main</th>
                                        <th class="text-white text-center fw-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nav_subs as $key => $item)
                                        <tr
                                            @if ($key % 2 == 1)
                                                echo class="tabel_active";
                                            @endif
                                        >
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td><span class="sub_title_{{ $item->id }}">{{ $item->title }}</span></td>
                                            <td><span class="sub_link_{{ $item->id }}">{{ $item->link }}</span></td>
                                            <td>
                                                <span class="sub_nav_main_{{ $item->id }}">
                                                    @if ($item->navMain)
                                                        {{ $item->navMain->title }}
                                                    @else
                                                        Data tidak ada
                                                    @endif
                                                </span>
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
                                                                class="dropdown-item sub-btn-edit border-bottom"
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
                                                                class="dropdown-item sub-btn-delete"
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
            </div>

        </div>
        <div class="mb-5"></div>
    </div>
</div>

{{-- main modal create  --}}
<div class="modal fade main-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_create">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah Menu Utama</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_title"
                            name="main_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="main_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_link"
                            name="main_create_link"
                            maxlength="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal create  --}}
<div class="modal fade sub-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_create">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Tambah Menu Sub</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_title"
                            name="sub_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_link"
                            name="sub_create_link"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_link" class="form-label">Menu Utama</label>
                        <select name="sub_create_nav_main" id="sub_create_nav_main" class="form-control form-control-sm" required>

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

{{-- main modal edit  --}}
<div class="modal fade main-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="main_edit_id"
                    name="main_edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Menu Utama</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_title"
                            name="main_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="main_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_link"
                            name="main_edit_link"
                            maxlength="100"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="border-0 text-white" style="background-color: #32a893; padding: 5px 10px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal edit  --}}
<div class="modal fade sub-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="sub_edit_id"
                    name="sub_edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Menu Sub</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_title"
                            name="sub_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_link"
                            name="sub_edit_link"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_nav_main" class="form-label">Menu Utama</label>
                        <select class="form-control form-control-sm" name="sub_edit_nav_main" id="sub_edit_nav_main">

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

{{-- main modal delete  --}}
<div class="modal fade main-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_delete">

                {{-- id  --}}
                <input type="hidden" id="main_delete_id" name="main_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="main_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary text-center" data-bs-dismiss="modal" style="width: 100px;">Tidak</button>
                    <button type="submit" class="btn btn-primary text-center" style="width: 100px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal delete  --}}
<div class="modal fade sub-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_delete">

                {{-- id  --}}
                <input type="hidden" id="sub_delete_id" name="sub_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="sub_delete_title text-decoration-underline"></span> ?</h5>
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

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#table_one').DataTable({
            'ordering': false
        });

        $('#table_two').DataTable({
            'ordering': false
        });

        // main create

        $('#main-button-create').on('click', function() {
            $('.main-modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.main-modal-create', function() {
            $('#main_create_title').focus();
        });

        $('#main_form_create').submit(function(e) {
            e.preventDefault();

            $('.main-modal-create').modal('hide');

            var formData = {
                title: $('#main_create_title').val(),
                link: $('#main_create_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_store') }} ',
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

        // sub create

        $('#sub-button-create').on('click', function() {
            $('#sub_create_nav_main').empty();

            $.ajax({
                url: '{{ URL::route('nav.sub_create') }}',
                type: 'GET',
                success: function(response) {
                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\">" + value.title + "</option>";
                    });

                    $('#sub_create_nav_main').append(nav_main_value);
                    $('.sub-modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.sub-modal-create', function() {
            $('#sub_create_title').focus();
        });

        $('#sub_form_create').submit(function(e) {
            e.preventDefault();

            $('.sub-modal-create').modal('hide');

            var formData = {
                title: $('#sub_create_title').val(),
                link: $('#sub_create_link').val(),
                nav_main_id: $('#sub_create_nav_main').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.sub_store') }} ',
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

        // main edit

        $('body').on('click', '.main-btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.main_edit", ":id") }}';
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
                    $('#main_edit_id').val(response.id);
                    $('#main_edit_title').val(response.title);
                    $('#main_edit_link').val(response.link);

                    $('.main-modal-edit').modal('show');
                }
            })
        });

        $('#main_form_edit').submit(function(e) {
            e.preventDefault();

            $('.main-modal-edit').modal('hide');
            $('.main_title_' + $('#main_edit_id').val()).empty();
            $('.main_link_' + $('#main_edit_id').val()).empty();

            var formData = {
                id: $('#main_edit_id').val(),
                title: $('#main_edit_title').val(),
                link: $('#main_edit_link').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');

                    $('.main_title_' + response.id).append(response.title);
                    $('.main_link_' + response.id).append(response.link);

                    setTimeout(() => {
                        $('.modal-proses').modal('hide');
                    }, 1000);
                }
            });
        });

        // sub edit

        $('body').on('click', '.sub-btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.sub_edit", ":id") }}';
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
                    $('#sub_edit_id').val(response.id);
                    $('#sub_edit_title').val(response.title);
                    $('#sub_edit_link').val(response.link);

                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\"";

                        if (value.id == response.nav_main_id) {
                            nav_main_value += "selected";
                        }

                        nav_main_value += ">" + value.title + "</option>";
                    });

                    $('#sub_edit_nav_main').append(nav_main_value);
                    $('.sub-modal-edit').modal('show');
                }
            })
        });

        $('#sub_form_edit').submit(function(e) {
            e.preventDefault();

            $('.sub-modal-edit').modal('hide');
            $('.sub_title_' + $('#sub_edit_id').val()).empty();
            $('.sub_link_' + $('#sub_edit_id').val()).empty();
            $('.sub_nav_main_' + $('#sub_edit_id').val()).empty();

            var formData = {
                id: $('#sub_edit_id').val(),
                title: $('#sub_edit_title').val(),
                link: $('#sub_edit_link').val(),
                nav_main_id: $('#sub_edit_nav_main').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.sub_update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.modal-proses').modal('show');

                    $('.sub_title_' + response.id).append(response.title);
                    $('.sub_link_' + response.id).append(response.link);
                    $('.sub_nav_main_' + response.id).append(response.nav_main_title);

                    setTimeout(() => {
                        $('.modal-proses').modal('hide');
                    }, 1000);
                }
            });
        });

        // main delete

        $('body').on('click', '.main-btn-delete', function(e) {
            e.preventDefault();
            $('.main_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.main_delete_btn", ":id") }}';
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
                    $('.main_delete_title').append(response.title);
                    $('#main_delete_id').val(response.id);
                    $('.main-modal-delete').modal('show');
                }
            });
        });

        $('#main_form_delete').submit(function(e) {
            e.preventDefault();

            $('.main-modal-delete').modal('hide');

            var formData = {
                id: $('#main_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.main_delete') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "false") {
                        alert('Menu utama \"' + response.title + '\" terdapat di menu sub, hapus menu sub yg terdapat menu utama \"' + response.title + '\" terlebih dahulu ');
                    } else {
                        $('.modal-proses').modal('show');
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                }
            });
        });

        // sub delete

        $('body').on('click', '.sub-btn-delete', function(e) {
            e.preventDefault();
            $('.sub_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("nav.sub_delete_btn", ":id") }}';
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
                    $('.sub_delete_title').append(response.title);
                    $('#sub_delete_id').val(response.id);
                    $('.sub-modal-delete').modal('show');
                }
            });
        });

        $('#sub_form_delete').submit(function(e) {
            e.preventDefault();

            $('.sub-modal-delete').modal('hide');

            var formData = {
                id: $('#sub_delete_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('nav.sub_delete') }}',
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
