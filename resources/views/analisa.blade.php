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
 
    <div>
        <div class="container" style="padding-top: 20px;">
            <div class="row mg-t-20 flex" style="flex-direction: column;">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mx-auto">
                        @include('alert')
                        @if(!empty($hasil_analisa))
                            <div class="alert alert-success">
                                Hasil analisa untuk siswa dengan nama <b>{{ $data_siswa->nama }}</b>
                            </div>
                        @endif
                        <form action="{{ route('lihat.analisa.kesimpulan') }}" method="POST">
                            @csrf
                            <div class="form-example-wrap">
                            <div class="cmp-tb-hd">
                                <h2>Masukan Kode Siswa</h2>
                            </div>
                            <div class="form-example-int">
                                <div class="form-group">
                                <label>Kode Siswa</label>
                                <div class="nk-int-st">
                                    <input type="text" name="kodeSiswa" class="form-control input-sm" placeholder="Masukan nama kelas" value="{{ old('kodeSiswa', empty($data_siswa) ? '' : $data_siswa->kodeSiswa )}}">
                                </div>
                                @error('kodeSiswa')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>
                            <div class="form-example-int mg-t-15">
                                <button  type="submit" class="btn btn-success notika-btn-success waves-effect">Submit</button>
                            </div>
                            </div>
                        </form>
                </div>
                @if (!empty($hasil_analisa))
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mx-auto" style="margin-top: 40px;">
                    <div class="normal-table-list" style="margin-bottom: 40px">
                        <div class="basic-tb-hd">
                            <h2>Rangkuman Data Uji</h2>
                        </div>
                        <div class="bsc-tbl-st">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Jumlah Yakin</th>
                                        <th>Jumlah Tidak Yakin</th>
                                        <th>Jumlah Total Data Uji</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $hasil_analisa->total_ya }}
                                        </td>
                                        <td>
                                            {{ $hasil_analisa->total_tidak }}
                                        </td>
                                        <td>
                                            {{ $hasil_analisa->total_kesuluruhan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="normal-table-list">
                        <div class="basic-tb-hd">
                            <h2>Jawaban Kuisioner</h2>
                        </div>
                        <div class="bsc-tbl-st">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil_analisa->kuisioner as $kuisioner)
                                        <tr>
                                            <td>{{ $kuisioner->question }}</td>
                                            <td><b>{{ $kuisioner->value }}</b></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="normal-table-list" style="margin-top: 40px;">
                        <div class="basic-tb-hd">
                            <h2>Hasil Perhitungan</h2>
                        </div>
                        <div class="bsc-tbl-st">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Yakin</th>
                                        <th>Tidak Yakin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>Rangkuman Keseluruhan</b></td>
                                        <td>{{ $hasil_analisa->total_ya }} / {{ $hasil_analisa->total_kesuluruhan }}</td>
                                        <td>{{ $hasil_analisa->total_tidak }} / {{ $hasil_analisa->total_kesuluruhan }}</td>
                                    </tr>
                                    @foreach ($hasil_analisa->kuisioner as $kuisioner)
                                        @if ($kuisioner->id != 24)
                                            <tr>
                                                <td style="width: 70%">
                                                    {{ $kuisioner->question }}
                                                    <br>
                                                    <b>{{ $kuisioner->value }}</b>
                                                </td>
                                                <td>
                                                    @if(property_exists($kuisioner, 'laplasian_ya'))
                                                        {{ $kuisioner->laplasian_ya }}
                                                    @else
                                                        {{ $kuisioner->ya }}
                                                    @endif
                                                    /
                                                    {{ $hasil_analisa->total_ya }}
                                                    @if(property_exists($kuisioner, 'laplasian_ya'))
                                                        -
                                                        <b>
                                                            {{ $kuisioner->ya }}/{{ $hasil_analisa->total_ya + count($hasil_analisa->kuisioner) }}
                                                        </b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(property_exists($kuisioner, 'laplasian_tidak'))
                                                        {{ $kuisioner->laplasian_tidak }}
                                                    @else
                                                        {{ $kuisioner->tidak }}
                                                    @endif    
                                                    /{{ $hasil_analisa->total_tidak }}
                                                    @if(property_exists($kuisioner, 'laplasian_tidak'))
                                                        -
                                                        <b>
                                                            {{ $kuisioner->tidak }}/{{ $hasil_analisa->total_tidak + count($hasil_analisa->kuisioner) }}
                                                        </b>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                    @endforeach
                                    <tr>
                                        <td><b>Persentase</b></td>
                                        <td>
                                            {{ $hasil_analisa->probabilitas_ya }}
                                        </td>
                                        <td>
                                            {{ $hasil_analisa->probabilitas_tidak }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Hasil Klasifikasi</b></td>
                                        <td colspan="2">
                                            {{ $hasil_analisa->klasifikasi }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Nilai Asli</b></td>
                                        <td colspan="2">
                                            {{ $hasil_analisa->nilai_asli }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Kategori</b></td>
                                        <td colspan="2">
                                            {{ $hasil_analisa->kategori }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
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