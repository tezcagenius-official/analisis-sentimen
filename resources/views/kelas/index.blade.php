@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="normal-table-list">
                <div class="basic-tb-hd">
                    <h2>Data Kelas</h2>
                    <a href="{{ route('form.tambah.kelas') }}" class="btn btn-success notika-btn-success waves-effect">Tambah Data Kelas</a>
                </div>
                <div class="bsc-tbl-st">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kelas</th>
                                <th>Jumlah Siswa</th>
                                <th>Wali Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_kelas as $index => $kelas)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $kelas->namaKelas }}</td>
                                    <td>{{ count($kelas->siswa) }}</td>
                                    <td>{{ empty($kelas->waliKelas) ? 'Tidak ada wali kelas' : $kelas->waliKelas }}</td>
                                    <td>
                                        <a href="{{ route('form.ubah.kelas', ['idKelas' => $kelas->idKelas]) }}">Ubah</a>
                                        <a href="{{ route('hapus.kelas', ['idKelas' => $kelas->idKelas]) }}">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data_kelas) <= 0)
                                <tr>
                                    <td colspan="5">Data kelas tidak ada</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection