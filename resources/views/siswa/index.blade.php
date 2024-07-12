@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="normal-table-list">
                <div class="basic-tb-hd">
                    <h2>Data Siswa</h2>
                    <div class="flex justify-between">
                        <a href="{{ route('form.tambah.siswa') }}" class="btn btn-success notika-btn-success waves-effect">Tambah Siswa</a>
                        <div class="nk-int-st" style="width: 40%">
                            <form action="{{ route('daftar.siswa') }}" method="GET">
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
                                <th>Kelas</th>
                                <th>Usia</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_siswa as $index => $siswa)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->namaKelas }}</td>
                                    <td>{{ $siswa->usia }}</td>
                                    <td>{{ $siswa->jenisKelamin }}</td>
                                    <td>
                                        <a href="{{ route('form.ubah.siswa', ['idSiswa' => $siswa->idSiswa]) }}">Ubah</a>
                                        <a href="{{ route('hapus.siswa', ['idSiswa' => $siswa->idSiswa]) }}">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data_siswa) <= 0)
                                <tr>
                                    <td colspan="5">Data siswa tidak ada</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection