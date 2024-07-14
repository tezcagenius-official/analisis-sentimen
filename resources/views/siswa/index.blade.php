@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="normal-table-list">
                <div class="basic-tb-hd">
                    <h2>Data Siswa</h2>
                    <div class="flex justify-between">
                        @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                            <a href="{{ route('form.tambah.siswa') }}" class="btn btn-success notika-btn-success waves-effect" >Tambah Siswa</a>
                        @else 
                            <div></div>
                        @endif
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
                                <th>Kode Siswa</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Usia</th>
                                <th>Jenis Kelamin</th>
                                @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_siswa as $index => $siswa)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>
                                        <div style="display: flex; justify-content: conter; align-items: center; gap: 10px;">
                                            <span style="cursor: pointer" data-kode="{{ $siswa->kodeSiswa }}" id="copy">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                            </span>
                                            <span class="text-success" data-toggle="tooltip" data-placement="right" title="Kode aplikasi digunakan untuk orang tua melihat hasil analisa">
                                                {{ $siswa->kodeSiswa }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->namaKelas }}</td>
                                    <td>{{ $siswa->usia }}</td>
                                    <td>{{ $siswa->jenisKelamin }}</td>
                                    @if ($user->role_type == \App\Constant\Runtime::ROLE_ADMIN)
                                        <td>
                                            <a href="{{ route('form.ubah.siswa', ['idSiswa' => $siswa->idSiswa]) }}">Ubah</a>
                                            <a href="{{ route('hapus.siswa', ['idSiswa' => $siswa->idSiswa]) }}">Hapus</a>
                                        </td>
                                    @endif
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