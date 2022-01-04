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
            <h6 class="text-uppercase text-center">Data Produk Toko</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif


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
                                <th class="text-white text-center fw-bold">Kode</th>
                                <th class="text-white text-center fw-bold">Nama</th>
                                <th class="text-white text-center fw-bold">Kategori</th>
                                <th class="text-white text-center fw-bold">Harga Jual</th>
                                <th class="text-white text-center fw-bold">Stok</th>
                                <th class="text-white text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_shops as $key => $item)
                                <tr
                                    @if ($key % 2 == 1)
                                        echo class="tabel_active";
                                    @endif
                                >
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        <span class="code_{{ $item->id }}">
                                            @if ($item->product)
                                                {{ $item->product->product_code }}
                                            @else
                                                Kode Produk Kosong
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="product_{{ $item->id }}">
                                            @if ($item->product)
                                                {{ $item->product->product_name }}
                                            @else
                                                Produk Kosong
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="category_{{ $item->id }}">
                                            @if ($item->product->category)
                                                {{ $item->product->category->category_name }}
                                            @else
                                                Kategori Kosong
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="price_selling_{{ $item->id }}">
                                            @if ($item->product)
                                                {{ rupiah($item->product->product_price_selling) }}
                                            @else
                                                Harga Jual Produk Kosong
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->stock == null)
                                            0
                                        @else
                                            {{ $item->stock }}
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
                                                        class="dropdown-item border-bottom py-1 btn-edit"
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
                    <h5 class="modal-title text-white">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_product_id" class="form-label">Nama Produk</label>
                        <select name="create_product_id" id="create_product_id" class="form-control form-control-sm select_product_create" required>

                        </select>
                        <div class="mt-2">
                            <span class="create_product_id_error text-danger"></span>
                        </div>
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
                <input type="hidden" id="edit_id" name="edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Produk Toko</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_product_id" class="form-label">Nama Produk</label>
                        <select name="edit_product_id" id="edit_product_id" class="form-control form-control-sm select_product_edit" required>

                        </select>
                        <div class="mt-2">
                            <span class="edit_product_id_error text-danger"></span>
                        </div>
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
            $('#create_product_id').empty();
            $('.create_product_id_error').empty();

            var formData = {
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_shop.create') }}',
                type: 'GET',
                data: formData,
                success: function(response) {

                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.product_name + "</option>";
                    });

                    $('#create_product_id').append(value);
                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_code').focus();

            $('.select_product_create').select2({
                dropdownParent: $('.modal-create')
            });
        });


        $('#form_create').submit(function(e) {
            e.preventDefault();
            $('.create_product_id_error').empty();

            var formData = {
                product_id: $('#create_product_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_shop.store') }} ',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "false") {
                        $('.create_product_id_error').append("Produk sudah tersedia");
                    } else {
                        $('.modal-create').modal('hide');
                        console.log('true');
                        $('.modal-proses').modal('show');
                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                }
            });
        });

        $('body').on('click', '.btn-edit', function(e) {
            e.preventDefault();
            $('#edit_product_id').empty();
            $('.edit_product_id_error').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_shop.edit", ":id") }}';
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

                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                        // sesuai produk yg terpilih
                        if (item.id == response.product_id) {
                            value += "selected";
                        }
                        value += ">" + item.product_name + "</option>";
                    });

                    $('#edit_product_id').append(value);
                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_code').focus();

            $('.select_product_edit').select2({
                dropdownParent: $('.modal-edit')
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();
            $('.edit_product_id_error').empty();

            var formData = {
                id: $('#edit_id').val(),
                product_id: $('#edit_product_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_shop.update') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "false") {
                        $('.edit_product_id_error').append("Produk sudah tersedia");
                    } else {
                        $('.modal-edit').modal('hide');
                        $('.code_' + $('#edit_id').val()).empty();
                        $('.product_' + $('#edit_id').val()).empty();
                        $('.category_' + $('#edit_id').val()).empty();
                        $('.price_' + $('#edit_id').val()).empty();
                        $('.price_selling_' + $('#edit_id').val()).empty();

                        $('.modal-proses').modal('show');

                        $('.code_' + response.id).append(response.code);
                        $('.product_' + response.id).append(response.product_name);
                        $('.category_' + response.id).append(response.category_name);
                        $('.price_' + response.id).append(format_rupiah(response.price));
                        $('.price_selling_' + response.id).append(format_rupiah(response.price_selling));

                        setTimeout(() => {
                            $('.modal-proses').modal('hide');
                        }, 1000);
                    }
                }
            });
        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();

            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_shop.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.product_name);
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
                url: '{{ URL::route('product_shop.delete') }}',
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
