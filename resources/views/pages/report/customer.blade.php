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
            <h6 class="text-uppercase text-center">Data Laporan Customer</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row mb-2 mt-1">
                <div class="col-md-2">
                    <select name="opsi" id="opsi" class="form-control form-control-sm">
                        <option value="">--Pilih Opsi--</option>
                        @foreach ($customers as $item)
                            <option value="{{ $item->id }}">{{ $item->customer_name }}</option>
                        @endforeach
                    </select>
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

        $('#opsi').select2();

        invoiceCustomerAll();
        function invoiceCustomerAll() {
            $('.card-body').empty();
            $.ajax({
                url: '{{ URL::route('report.customer_get_data') }}',
                type: 'GET',
                success: function(response) {
                    var invoice_val = "" +
                    "<table id=\"table_one\" class=\"table table-bordered\">" +
                        "<thead style=\"background-color: #32a893;\">" +
                            "<tr>" +
                                "<th class=\"text-white text-center fw-bold\">No</th>" +
                                "<th class=\"text-white text-center fw-bold\">Customer</th>" +
                                "<th class=\"text-white text-center fw-bold\">Jumlah Transaksi</th>" +
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
                                        "<td>";

                                        if (item.customer) {
                                            invoice_val += item.customer.customer_name;
                                        } else {
                                            invoice_val += "Customer Tidak Ada";
                                        }

                                    invoice_val += "</td>" +
                                        "<td class=\"text-center\">" + item.transactions + "</td>" +
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

        $('#opsi').on('change', function() {
            if ($(this).val() == "") {
                invoiceCustomerAll();
            }
            else {
                $('.card-body').empty();

                var id = $(this).val();
                var url = '{{ route("report.customer_detail", ":id") }}';
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
                                            invoice_val += item.customer.customer_name;
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
