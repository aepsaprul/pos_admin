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
            <h6 class="text-uppercase text-center">Data Produk Keluar Gudang</h6>
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
                                <th class="text-white text-center fw-bold">Pengguna</th>
                                <th class="text-white text-center fw-bold">Nama Product</th>
                                <th class="text-white text-center fw-bold">Toko</th>
                                <th class="text-white text-center fw-bold">Harga</th>
                                <th class="text-white text-center fw-bold">Qty</th>
                                <th class="text-white text-center fw-bold">Sub Total</th>
                                <th class="text-white text-center fw-bold">Tanggal</th>
                                <th class="text-white text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_outs as $key => $item)
                                <tr
                                    @if ($key % 2 == 1)
                                        echo class="tabel_active";
                                    @endif
                                >
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @if ($item->product == null)
                                            <span class="text-danger">Product Tidak Ada</span>
                                        @else
                                            {{ $item->product->product_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->shop == null)
                                            <span class="text-danger">Toko Tidak Ada</span>
                                        @else
                                            {{ $item->shop->name }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ rupiah($item->price) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ rupiah($item->sub_total) }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>
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
                                                        class="dropdown-item py-1 btn-edit"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-pencil-alt border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Ubah
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
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
                    <h5 class="modal-title text-white">Tambah Produk Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_product_id" class="form-label">Nama Produk</label>
                        <select name="create_product_id" id="create_product_id" class="form-control" name="create_product_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_shop_id" class="form-label">Toko</label>
                        <select name="create_shop_id" id="create_shop_id" class="form-control" name="create_shop_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_quantity" class="form-label">Quantity</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="create_quantity"
                            name="create_quantity"
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

{{-- modal edit  --}}
<div class="modal fade modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_edit">

                {{-- id  --}}
                <input type="hidden" id="edit_id" name="edit_id">

                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Ubah Produk Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_product_id" class="form-label">Nama Produk</label>
                        <select name="edit_product_id" id="edit_product_id" class="form-control" name="edit_product_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_shop_id" class="form-label">Toko</label>
                        <select name="edit_shop_id" id="edit_shop_id" class="form-control" name="edit_shop_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_quantity" class="form-label">Quantity</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="edit_quantity"
                            name="edit_quantity"
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
            $('#create_shop_id').empty();

            var formData = {
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_out.create') }}',
                type: 'GET',
                data: formData,
                success: function(response) {
                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.product_name + "</option>";
                    });
                    $('#create_product_id').append(value);

                    // shop query
                    var value = "<option value=\"\">--Pilih Toko--</option>";
                    $.each(response.shops, function(index, item) {
                        value += "<option value=\"" + item.id + "\">" + item.name + "</option>";
                    });
                    $('#create_shop_id').append(value);

                    $('.modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_product_id').focus();

            $('#create_product_id').select2({
                dropdownParent: $('.modal-create')
            });

            $('#create_shop_id').select2({
                dropdownParent: $('.modal-create')
            });
        });


        $('#form_create').submit(function(e) {
            e.preventDefault();
            $('.modal-create').modal('hide');

            var formData = {
                product_id: $('#create_product_id').val(),
                shop_id: $('#create_shop_id').val(),
                quantity: $('#create_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_out.store') }} ',
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

            $('#edit_product_id').empty();
            $('#edit_shop_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_out.edit", ":id") }}';
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
                    $('#edit_quantity').val(response.quantity);

                    // product query
                    var value = "<option value=\"\">--Pilih Produk--</option>";
                    $.each(response.products, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                            if (item.id == response.product_id) {
                                value += "selected";
                            }
                        value += ">" + item.product_name + "</option>";
                    });
                    $('#edit_product_id').append(value);

                    // shop query
                    var value = "<option value=\"\">--Pilih Toko--</option>";
                    $.each(response.shops, function(index, item) {
                        value += "<option value=\"" + item.id + "\"";
                            if (item.id == response.shop_id) {
                                value += "selected";
                            }
                        value += ">" + item.name + "</option>";
                    });
                    $('#edit_shop_id').append(value);

                    $('.modal-edit').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-edit', function() {
            $('#edit_product_name').focus();

            $('#edit_product_id').select2({
                dropdownParent: $('.modal-edit')
            });

            $('#edit_supplier_id').select2({
                dropdownParent: $('.modal-edit')
            });
        });

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            $('.modal-edit').modal('hide');

            var formData = {
                id: $('#edit_id').val(),
                product_id: $('#edit_product_id').val(),
                shop_id: $('#edit_shop_id').val(),
                quantity: $('#edit_quantity').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('product_out.update') }}',
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
            $('.delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("product_out.delete_btn", ":id") }}';
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
                url: '{{ URL::route('product_out.delete') }}',
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
