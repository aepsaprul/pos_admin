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
            <h6 class="text-uppercase text-center">Data Laporan Laba Rugi</h6>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row mb-2 mt-1">
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
                    <table id="table_one" class="table table-bordered">
                        <thead style="background-color: #32a893;">
                            <tr>
                                <th class="text-white text-center fw-bold">Tanggal</th>
                                <th class="text-white text-center fw-bold">Omset</th>
                                <th class="text-white text-center fw-bold">Total HPP</th>
                                <th class="text-white text-center fw-bold">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="raw_date" class="text-center"></td>
                                <td id="raw_revenue" class="text-end"></td>
                                <td id="raw_total_price" class="text-end"></td>
                                <td id="raw_profit" class="text-end"></td>
                            </tr>
                        </tbody>
                    </table>
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

        $('#table_one').DataTable({
                        'ordering': false
                    });

        salesAll();
        function salesAll() {
            $('.table_data').empty();
            $.ajax({
                url: '{{ URL::route('report.income_get_data') }}',
                type: 'GET',
                success: function(response) {
                    var sum_product_price = 0;
                    var sum_sub_total = 0;

                    $.each(response.sales, function(index, item) {
                        sum_product_price += parseFloat(item.quantity * item.product.product_price);
                        sum_sub_total += parseFloat(item.sub_total);
                        var total_profit =  sum_sub_total - sum_product_price;

                        $('#raw_date').html(tanggal(item.invoice.date_recorded));
                        $('#raw_revenue').html(format_rupiah(sum_product_price));
                        $('#raw_total_price').html(format_rupiah(sum_sub_total));
                        $('#raw_profit').html(format_rupiah(total_profit));
                    });
                }
            });
        }

        $('.btn-search').on('click', function(e) {
            e.preventDefault();
            $('.table_data').empty();

            if ($('#start_date').val() == "" || $('#end_date').val() == "") {
                alert('Tanggal harus diisi');
            } else {
                var formData = {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: CSRF_TOKEN
                }

                $.ajax({
                    url: '{{ URL::route('report.income_filter') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                    var sum_product_price = 0;
                    var sum_sub_total = 0;

                    $.each(response.sales, function(index, item) {
                        sum_product_price += parseFloat(item.quantity * item.product.product_price);
                        sum_sub_total += parseFloat(item.sub_total);
                        var total_profit =  sum_sub_total - sum_product_price;

                        var start_date = tanggal(response.start_date);
                        var end_date = tanggal(response.end_date);

                        $('#raw_date').html(start_date + " s/d " + end_date);
                        $('#raw_revenue').html(format_rupiah(sum_product_price));
                        $('#raw_total_price').html(format_rupiah(sum_sub_total));
                        $('#raw_profit').html(format_rupiah(total_profit));
                    });
                    }
                });
            }
        });
    } );
</script>
@endsection
