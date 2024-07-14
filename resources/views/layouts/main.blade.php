<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard One | Notika - Notika Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/owl.transitions.css') }}">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/meanmenu/meanmenu.min.css') }}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/wave/waves.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/wave/button.css') }}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ URL::asset('css/responsive.css') }}">
    <!-- modernizr JS
		============================================ -->
    <script src="{{ URL::asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="#" class="logo">Analisis Sentimen</a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->
    <!-- Main Menu area start-->
    <div class="main-menu-area" style="background-color: white;">
        <div class="container">
            <div class="row">
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li>
                            <a class="{{ route_name() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="notika-icon notika-house"></i> Beranda</a>
                        </li>
                        @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                            <li><a class="{{ in_array(route_name(), ['daftar.kelas', 'form.tambah.kelas', 'form.ubah.kelas']) ? 'active' : '' }}" href="{{ route('daftar.kelas') }}"><i class="notika-icon notika-mail"></i> Data Kelas</a>
                            </li>
                        @endif
                        <li><a href="{{ route('daftar.siswa') }}" class="{{ in_array(route_name(), ['daftar.siswa', 'form.tambah.siswa', 'form.ubah.siswa']) ? 'active' : '' }}"><i class="notika-icon notika-edit"></i> Data Siswa</a>
                        </li>
                        @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                        <li><a href="{{ route('daftar.guru') }}" class="{{ in_array(route_name(), ['daftar.guru', 'form.tambah.guru', 'form.ubah.guru']) ? 'active' : '' }}"><i class="notika-icon notika-bar-chart"></i> Data Guru</a>
                        </li>
                        @endif
                        <li><a href="{{ route('daftar.kuisioner') }}" class="{{ in_array(route_name(), ['daftar.kuisioner', 'form.tambah.kuisioner', 'form.ubah.kuisioner', 'lihat.analisa.kuisioner']) ? 'active' : '' }}"></i>Data Kuisioner</a>
                        </li>
                        @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                        <li><a href="{{ route('analisa.kesimpulan') }}" class="{{ in_array(route_name(), ['analisa.kesimpulan']) ? 'active' : '' }}"><i class="notika-icon notika-form"></i>Hasil Analisa</a>
                        </li>
                        @endif
                    </ul>
            </div>
        </div>
    </div>
    <div>
        <div class="container" style="padding-top: 20px;">
            <div class="row" style="margin-bottom: 15px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="notika-icon notika-form"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                <h2>Selamat Datang {{ $user->nama }}</h2>
                                    <p>Anda login sebagai 
                                        <b>{{ $user->nama_role }}</b>
                                        @if ($user->role_type == \App\Constant\Runtime::ROLE_GURU)
                                            dan walikelas <b>{{ $user->kelas->namaKelas }}</b>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                            <div class="breadcomb-report">
                                <a href="{{ route('keluar') }}" data-toggle="tooltip" data-placement="left" title="" class="btn waves-effect"><i class="notika-icon notika-logout"></i> Keluar</a>
                            </div>
						</div>
                    </div>
                    </div>
                </div>
            </div>
            @include('alert')
            @yield('main')
        </div>
    </div>
    <!-- jquery
		============================================ -->
    <script src="{{ URL::asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <!-- wow JS
		============================================ -->
    <script src="{{ URL::asset('js/main.js') }}"></script>
    <script src="{{ URL::asset('js/knob/jquery.knob.js') }}"></script>
    <script src="{{ URL::asset('js/knob/jquery.appear.js') }}"></script>
    <script src="{{ URL::asset('js/knob/knob-active.js') }}"></script>
    <script type="text/javascript">
      window.addEventListener('DOMContentLoaded', function () {
        const copyBtn = document.querySelectorAll('#copy')
        copyBtn.forEach((item) => {
          $(item).tooltip({
            trigger: 'click',
            placement: 'top'
          });
          item.addEventListener('click', function (e) {
            const kode = item.getAttribute('data-kode');
            navigator.clipboard.writeText(kode);
            $(item).tooltip('hide')
              .attr('data-original-title', 'Berhasil disalin')
              .tooltip('show');
            setTimeout(function() {
              $(item).tooltip('hide');
            }, 1000);
          })
        })
      })
    </script>
</body>

</html>