@extends('layouts.main')

@section('main')
<div class="notika-status-area mg-t-10">
    @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ count($data_guru) }}</span></h2>
                    <p>Total Guru</p>
                </div>
                <div class="sparkline-bar-stats1"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ count($data_kelas) }}</span></h2>
                    <p>Total Kelas</p>
                </div>
                <div class="sparkline-bar-stats2"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ count($data_kuisioner)  }}</span></h2>
                    <p>Total Kuisioner</p>
                </div>
                <div class="sparkline-bar-stats3"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">{{ count($data_siswa) }}</span></h2>
                    <p>Total Siswa</p>
                </div>
                <div class="sparkline-bar-stats4"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
    </div>
    @endif
    @php
        if(count($data_kuisioner) > 0) {
            $presisi = $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fp) * 100; 
            $recall = $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fn) * 100;
        }
    @endphp
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="notika-email-post-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="email-statis-inner notika-shadow" style="margin-left: -15px">
                                <div class="email-ctn-round">
                                    <div class="email-rdn-hd">
                                        <h2>Rangkuman Analisis</h2>
                                    </div>
                                    <div class="email-statis-wrap">
                                        <div class="email-round-nock">
                                            <input type="text" class="knob" value="0" data-rel="{{ count($data_kuisioner) <= 0 ? 0 : (2 * $presisi * $recall) / ($presisi + $recall) }}" data-linecap="round" data-width="130" data-bgcolor="#E4E4E4" data-fgcolor="#00c292" data-thickness=".10" data-readonly="true">
                                        </div>
                                        <div class="email-ctn-nock">
                                            <p>F1 Score</p>
                                        </div>
                                    </div>
                                    <div class="email-round-gp">
                                        <div class="email-round-pro">
                                            <div class="email-signle-gp">
                                                <input type="text" class="knob" value="0" data-rel="{{ count($data_kuisioner) <= 0 ? 0 : ($kesimpulan->total_tp + $kesimpulan->total_tn ) / ($kesimpulan->total_tp + $kesimpulan->total_fn + $kesimpulan->total_tn + $kesimpulan->total_fp) * 100 }}" data-linecap="round" data-width="90" data-bgcolor="#E4E4E4" data-fgcolor="#00c292" data-thickness=".10" data-readonly="true" disabled>
                                            </div>
                                            <div class="email-ctn-nock">
                                                <p>Akurasi</p>
                                            </div>
                                        </div>
                                        <div class="email-round-pro">
                                            <div class="email-signle-gp">
                                                <input type="text" class="knob" value="0" data-rel="{{ count($data_kuisioner) <= 0 ? 0 : $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fp) * 100; }}" data-linecap="round" data-width="90" data-bgcolor="#E4E4E4" data-fgcolor="#00c292" data-thickness=".10" data-readonly="true" disabled>
                                            </div>
                                            <div class="email-ctn-nock">
                                                <p>Presisi</p>
                                            </div>
                                        </div>
                                        <div class="email-round-pro sm-res-ds-n lg-res-mg-bl">
                                            <div class="email-signle-gp">
                                                <input type="text" class="knob" value="0" data-rel="{{ count($data_kuisioner) <= 0 ? 0 : $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fn) * 100; }}" data-linecap="round" data-width="90" data-bgcolor="#E4E4E4" data-fgcolor="#00c292" data-thickness=".10" data-readonly="true" disabled>
                                            </div>
                                            <div class="email-ctn-nock">
                                                <p>Recall</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <div class="normal-table-list" style="margin-bottom: 40px">
                <div class="basic-tb-hd">
                    <h2>Data Kuisioner</h2>
                </div>
                <div class="bsc-tbl-st">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_kuisioner as $index => $kuisioner)
                                <tr>
                                    <td>{{ $index + 1; }}</td>
                                    <td>{{ $kuisioner->namaSiswa}}</td>
                                    <td>{{ $kuisioner->namaKelas}}</td>
                                    <td>
                                        <a href="{{ route('lihat.analisa.kuisioner', ['idKuisioner' => $kuisioner->idKuisioner]) }}">Lihat Hasil</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data_kuisioner) <= 0)
                                <tr>
                                    <td colspan="4">Tidak ada data kuisioner</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection