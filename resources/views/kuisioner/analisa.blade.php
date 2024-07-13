@extends('layouts.main')

@section('main')
<div class="row mg-t-20 flex">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
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
@endsection