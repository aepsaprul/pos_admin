@guest

@yield('content')

@else

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/maskot.png') }}">

    <title>{{ config('app.name', 'POS') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('theme/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('theme/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{ asset('theme/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet"/>

    <!-- PNotify -->
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('theme/build/css/custom.min.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body class="nav-md footer_fixed">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><img src="{{ asset('assets/store.png') }}" alt="" style="max-width: 30px;"> <span>Aplikasi POS</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('assets/user.png') }}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                @if (Auth::user()->employee_id == null)
                                    <li>
                                        <a href="{{ url('home') }}"><i class="fa fa-home"></i> Dashboard</a>
                                    </li>
                                    <li>
                                        <a><i class="fa fa-database"></i> Master <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('employee.index') }}">Karyawan</a></li>
                                            <li><a href="{{ route('position.index') }}">Jabatan</a></li>
                                            <li><a href="{{ route('nav.index') }}">Navigasi</a></li>
                                            <li><a href="{{ route('user.index') }}">User</a></li>
                                            <li><a href="{{ route('product_category.index') }}">Kategori Produk</a></li>
                                            <li><a href="{{ route('product.index') }}">Produk</a></li>
                                            <li><a href="{{ route('shop.index') }}">Toko</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a><i class="fa fa-exchange"></i> Transaksi Gudang <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('product_in.index') }}">Produk Masuk</a></li>
                                            <li><a href="{{ route('inventory_invoice.index') }}">Produk Keluar</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> Supplier</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('supplier.index') }}"><i class="fa fa-gift"></i> Promo</a>
                                    </li>
                                    <li>
                                        <a><i class="fa fa-copy"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('report.index') }}">Penjualan</a></li>
                                            <li><a href="{{ route('report.customer_index') }}">Customer</a></li>
                                            <li><a href="{{ route('report.product_index') }}">Produk</a></li>
                                            <li><a href="{{ route('report.income_index') }}">Laba Rugi</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('product_shop.index') }}"><i class="fa fa-archive"></i> Produk</a>
                                    </li>
                                    <li>
                                        <a><i class="fa fa-exchange"></i> Transaksi Toko <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('received_product.index') }}">Produk Masuk</a></li>
                                            <li><a href="{{ route('invoice.index') }}">Penjualan</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('customer.index') }}"><i class="fa fa-users"></i> Customer</a>
                                    </li>
                                    <li>
                                        <a><i class="fa fa-inbox"></i> Kasir <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('cashier.index') }}">Cash</a></li>
                                            <li><a href="{{ route('cashier.credit') }}">Tempo</a></li>
                                        </ul>
                                    </li>
                                @else
                                    @foreach ($current_nav_mains as $item)
                                    <li>
                                        @if ($item->link != '#')
                                            <a href="{{ url($item->link) }}"><i class="{{ $item->icon }}"></i> {{ $item->title }}</a>
                                        @else
                                            <a href="#"><i class="{{ $item->icon }}"></i> {{ $item->title }}<span class="fa fa-chevron-down"></span></a>
                                        @endif
                                        <ul class="nav child_menu">
                                            @foreach ($current_menus as $item_menu)
                                                @if ($item_menu->main_id == $item->id)
                                                    <li><a href="{{ url($item_menu->navSub->link) }}">{{ $item_menu->navSub->title }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a
                                    href="javascript:;"
                                    class="user-profile dropdown-toggle"
                                    aria-haspopup="true"
                                    id="navbarDropdown"
                                    data-toggle="dropdown"
                                    aria-expanded="false">
                                        <img
                                            src="{{ asset('assets/user.png') }}"
                                            alt="">
                                                {{ Auth::user()->name }}
                                </a>
                                <div
                                    class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="#">
                                            <i class="fa fa-user pull-right"></i>
                                                Profile
                                    </a>
                                    <a
                                        class="dropdown-item"
                                        href="#">
                                            <i class="fa fa-unlock pull-right"></i>
                                                Ubah Password
                                    </a>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out pull-right"></i>
                                                Log Out
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            @yield('content')

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('theme/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('theme/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{ asset('theme/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>

    <!-- PNotify -->
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('theme/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('theme/build/js/custom.min.js') }}"></script>

    @yield('script')

    <script>
        function format_rupiah(bilangan) {
            var	number_string = bilangan.toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            return rupiah;
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
        }

        function tanggal(date) {
            var date = new Date(date);
            var tahun = date.getFullYear();
            var nomorbulan = date.getMonth() + 1;
            var bulan = date.getMonth();
            var tanggal = date.getDate();
            var hari = date.getDay();
            var jam = date.getHours();
            var menit = date.getMinutes();
            var detik = date.getSeconds();
            switch(hari) {
            case 0: hari = "Minggu"; break;
            case 1: hari = "Senin"; break;
            case 2: hari = "Selasa"; break;
            case 3: hari = "Rabu"; break;
            case 4: hari = "Kamis"; break;
            case 5: hari = "Jum'at"; break;
            case 6: hari = "Sabtu"; break;
            }
            switch(bulan) {
            case 0: bulan = "Januari"; break;
            case 1: bulan = "Februari"; break;
            case 2: bulan = "Maret"; break;
            case 3: bulan = "April"; break;
            case 4: bulan = "Mei"; break;
            case 5: bulan = "Juni"; break;
            case 6: bulan = "Juli"; break;
            case 7: bulan = "Agustus"; break;
            case 8: bulan = "September"; break;
            case 9: bulan = "Oktober"; break;
            case 10: bulan = "November"; break;
            case 11: bulan = "Desember"; break;
            }

            return tampilTanggal = tanggal + "-" + nomorbulan + "-" + tahun;
            // var tampilWaktu = "Jam: " + jam + ":" + menit + ":" + detik;
            // console.log(tampilTanggal);
            // console.log(tampilWaktu);
        }
    </script>
</body>
</html>
@endguest
