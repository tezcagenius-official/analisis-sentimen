@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="normal-table-list">
                <div class="basic-tb-hd">
                    <h2>Data Kuisioner</h2>
                    <div class="flex justify-between">
                        <a href="{{ route('form.tambah.kuisioner') }}" class="btn btn-success notika-btn-success waves-effect">Tambah Data Kuisioner</a>
                        <div class="nk-int-st" style="width: 40%">
                            <form action="{{ route('daftar.kuisioner') }}" method="GET">
                                <input type="text" name="query" class="form-control input-md" placeholder="Cari berdasarkan nama siswa" value="{{ Request::get('query') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bsc-tbl-st">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_kuisioner as $index => $kuisioner)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $kuisioner->namaSiswa }}</td>
                                    <td>
                                        <a href="{{ route('form.ubah.kuisioner', ['idKuisioner' => $kuisioner->idKuisioner]) }}">Ubah</a>
                                        <a href="{{ route('lihat.analisa.kuisioner', ['idKuisioner' => $kuisioner->idKuisioner]) }}">Lihat Perhitungan Analisa</a>
                                        <a href="{{ route('hapus.kuisioner', ['idKuisioner' => $kuisioner->idKuisioner]) }}">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data_kuisioner) <= 0)
                                <tr>
                                    <td colspan="5">Data kuisioner tidak ada</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection