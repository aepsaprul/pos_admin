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
            <h6 class="text-uppercase text-center">Data Laporan Penjualan</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row mb-2 mt-1">
                <div class="col-md-2">
                    <label for="select_shop">Pilih Toko</label>
                    <select name="select_shop" id="select_shop" class="form-control form-control-sm select_shop">
                        <option value="0">--Pilih Toko--</option>
                        @foreach ($shops as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="select_cashier">Pilih Kasir</label>
                    <select name="select_cashier" id="select_cashier" class="form-control form-control-sm select_cashier">

                    </select>
                </div>
                <div class="col-md-2">
                    <label for="opsi">Pilih Opsi</label>
                    <select name="opsi" id="opsi" class="form-control form-control-sm">
                        <option value="0">--Pilih Opsi--</option>
                        <option value="1">Data Keseluruhan</option>
                        <option value="2">Data Bukan Customer</option>
                        <option value="3">Data Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="start_date">Tanggal Awal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm">
                </div>
                <div class="col-md-1">
                    <label for="start_date"></label>
                    <button class="btn btn-primary form-control btn-search"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="mb-5"></div>
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

        invoiceSalesCurrent();
        function invoiceSalesCurrent() {
            $('.card-body').empty();
            $.ajax({
                url: '{{ URL::route('report.sales_get_data_current') }}',
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Tanggal</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Kasir</th>" +
                                "<th class=\"text-white text-center fw-bold\">Customer</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nego</th>" +
                                "<th class=\"text-white text-center fw-bold\">Kode Nota</th>" +
                                "<th class=\"text-white text-center fw-bold\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       invoice_val += " class=\"tabel_active\"";
                                    }
                                    invoice_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td class=\"text-center\">";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(invoice_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        function invoiceSalesAll() {
            $('.card-body').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('report.sales_get_data') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response.invoices);
                    var invoice_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Tanggal</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Kasir</th>" +
                                "<th class=\"text-white text-center fw-bold\">Customer</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nego</th>" +
                                "<th class=\"text-white text-center fw-bold\">Kode Nota</th>" +
                                "<th class=\"text-white text-center fw-bold\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       invoice_val += " class=\"tabel_active\"";
                                    }
                                    invoice_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td class=\"text-center\">";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(invoice_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        function invoiceSalesNotCustomer() {
            $('.card-body').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('report.sales_not_customer') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Tanggal</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Kasir</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nego</th>" +
                                "<th class=\"text-white text-center fw-bold\">Kode Nota</th>" +
                                "<th class=\"text-white text-center fw-bold\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       invoice_val += " class=\"tabel_active\"";
                                    }
                                    invoice_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td class=\"text-center\">";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(invoice_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        function invoiceSalesCustomer() {
            $('.card-body').empty();

            var formData = {
                opsi: $('#opsi').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: '{{ URL::route('report.sales_customer') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Tanggal</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nama Kasir</th>" +
                                "<th class=\"text-white text-center fw-bold\">Customer</th>" +
                                "<th class=\"text-white text-center fw-bold\">Diskon</th>" +
                                "<th class=\"text-white text-center fw-bold\">Nego</th>" +
                                "<th class=\"text-white text-center fw-bold\">Kode Nota</th>" +
                                "<th class=\"text-white text-center fw-bold\">Total</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>";
                            $.each(response.invoices, function(index, item) {
                                invoice_val += "" +
                                    "<tr";
                                    if (index % 2 == 1) {
                                       invoice_val += " class=\"tabel_active\"";
                                    }
                                    invoice_val += ">" +
                                        "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                        "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                        "<td class=\"text-center\">";

                                        if (item.user) {
                                            invoice_val += item.user.name;
                                        } else {
                                            invoice_val += "User Tidak Ada";
                                        }

                                        invoice_val += "</td><td>";

                                        if (item.customer) {
                                            invoice_val += item.customer.customer_name;
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.discount + "</td>" +
                                        "<td class=\"text-center\">" + item.bid + "</td>" +
                                        "<td class=\"text-center\">" + item.code + "</td>" +
                                        "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                    "</tr>";
                            });
                        invoice_val += "</tbody>" +
                    "</table>";

                    $('.card-body').append(invoice_val);

                    $('#table_one').DataTable({
                        'ordering': false
                    });
                }
            });
        }

        $('#select_shop').on('change', function() {

            $('#select_cashier').empty();

            var id = $(this).val();
            var url = '{{ route("report.sales_shop", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id,
                _token: CSRF_TOKEN
            }

            $.ajax({
                url: url,
                data: formData,
                type: 'GET',
                success: function(response) {
                    var value_employee = "<option value=\"0\">--Pilih Kasir--</option>"
                    $.each(response.cashiers, function(index, item) {
                        value_employee += "<option value=\"" + item.id + "\">" + item.full_name + "</option>";
                    });
                    $('#select_cashier').append(value_employee);
                }
            });
        });

        $('.btn-search').on('click', function() {
            if ($('#start_date').val() == "" || $('#end_date').val() == "") {
                alert('Tanggal harus diisi!');
            } else {
                var shop_id = $('#select_shop').val();
                var cashier_id = $('#select_cashier').val();
                var opsi = $('#opsi').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                var formData = {
                    shop_id: shop_id,
                    cashier_id: cashier_id,
                    opsi: opsi,
                    start_date: start_date,
                    end_date: end_date,
                    _token: CSRF_TOKEN
                }

                $('.card-body').empty();

                $.ajax({
                    url: '{{ URL::route('report.sales_search') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var invoice_val = "" +
                        "<table id=\"table_one\" class=\"table table-bordered\">" +
                            "<thead style=\"background-color: #32a893;\">" +
                                "<tr>" +
                                    "<th class=\"text-white text-center fw-bold\">No</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Tanggal</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Nama Kasir</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Customer</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Nego</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Kode Nota</th>" +
                                    "<th class=\"text-white text-center fw-bold\">Total</th>" +
                                "</tr>" +
                            "</thead>" +
                            "<tbody>";
                                $.each(response.invoices, function(index, item) {
                                    invoice_val += "" +
                                        "<tr";
                                        if (index % 2 == 1) {
                                        invoice_val += " class=\"tabel_active\"";
                                        }
                                        invoice_val += ">" +
                                            "<td class=\"text-center\">" + (index + 1) + "</td>" +
                                            "<td class=\"text-center\">" + tanggal(item.date_recorded) + "</td>" +
                                            "<td class=\"text-center\">";

                                            if (item.user) {
                                                invoice_val += item.user.name;
                                            } else {
                                                invoice_val += "User Tidak Ada";
                                            }

                                            invoice_val += "</td><td>";

                                            if (item.customer) {
                                                invoice_val += "<span class=\"text-primary\">" + item.customer.customer_name + "</span>";
                                            } else {
                                                invoice_val += "Customer Tidak Ada";
                                            }

                                        invoice_val += "</td>" +
                                            "<td class=\"text-center\">" + item.bid + "</td>" +
                                            "<td class=\"text-center\">" + item.code + "</td>" +
                                            "<td class=\"text-center\">" + format_rupiah(item.total_amount) + "</td>" +
                                        "</tr>";
                                });
                            invoice_val += "</tbody>" +
                        "</table>";

                        $('.card-body').append(invoice_val);

                        $('#table_one').DataTable({
                            'ordering': false
                        });
                    }
                });
            }
        });
    } );
</script>
@endsection
