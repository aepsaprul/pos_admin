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
            <h6 class="text-uppercase text-center">Data Penjualan</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row mb-2 mt-1">
                <div class="col-md-4">

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="table_one" class="table table-bordered">
                        <thead style="background-color: #32a893;">
                            <tr>
                                <th class="text-white text-center fw-bold">No</th>
                                <th class="text-white text-center fw-bold">Tanggal</th>
                                <th class="text-white text-center fw-bold">Nama Kasir</th>
                                <th class="text-white text-center fw-bold">Kode Nota</th>
                                <th class="text-white text-center fw-bold">Total</th>
                                <th class="text-white text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $item)
                                <tr
                                    @if ($key % 2 == 1)
                                        echo class="tabel_active";
                                    @endif
                                >
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->date_recorded)) }}</td>
                                    <td>
                                        @if ($item->user)
                                            {{ $item->user->name }}
                                        @else
                                            User Tidak Ada
                                        @endif
                                    </td>
                                    <td>{{ $item->code }}</td>
                                    <td class="text-end">{{ rupiah($item->total_amount) }}</td>
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
                                                        class="dropdown-item border-bottom py-1 btn-detail"
                                                        data-id="{{ $item->id }}"
                                                        type="button">
                                                            <i
                                                                class="fas fa-eye border border-1 px-2 py-2 me-2 text-white"
                                                                style="background-color: #32a893;">
                                                            </i> Detail
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

{{-- modal detail  --}}
<div class="modal fade modal-detail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_detail">
                <div class="modal-header" style="background-color: #32a893;">
                    <h5 class="modal-title text-white">Detail Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1 row">
                        <label for="detail_code" class="col-sm-4 col-form-label"><strong>Kode Produk</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_code" name="detail_code" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="detail_date" class="col-sm-4 col-form-label"><strong>Tanggal</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_date" name="detail_date" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="detail_total_amount" class="col-sm-4 col-form-label"><strong>Total</strong></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="detail_total_amount" name="detail_total_amount" readonly>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <div class="col-md-12">
                            <table id="table_two" class="table table-bordered">
                                <thead style="background-color: #32a893;">
                                    <tr>
                                        <th class="text-white text-center fw-bold">No</th>
                                        <th class="text-white text-center fw-bold">Nama Produk</th>
                                        <th class="text-white text-center fw-bold">Quantity</th>
                                        <th class="text-white text-center fw-bold">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

        $('body').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            $('#table_two tbody').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("invoice.show", ":id") }}';
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
                    $('#detail_code').val(response.code);
                    $('#detail_date').val(response.date);
                    $('#detail_total_amount').val(format_rupiah(response.total_amount));

                    $.each(response.sales, function(index, item) {
                        var sales_val = "" +
                            "<tr>" +
                                "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                "<td>" + item.product.product_name + "</td>" +
                                "<td class=\"text-center\">" + item.quantity + "</td>" +
                                "<td class=\"text-end\">" + format_rupiah(item.sub_total) + "</td>" +
                            "</tr>";
                        $('#table_two tbody').append(sales_val);
                    });

                    $('.modal-detail').modal('show');
                }
            });

        });

        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault()

            var id = $(this).attr('data-id');
            var url = '{{ route("sales.delete_btn", ":id") }}';
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
                    $('.delete_title').append(response.code);
                    $('#delete_invoice_id').val(response.id);
                    $('.modal-delete').modal('show');
                }
            });
        });

        $('#form_delete').submit(function(e) {
            e.preventDefault();

            $('.modal-delete').modal('hide');

            var formData = {
                id: $('#delete_invoice_id').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('sales.delete') }}',
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
