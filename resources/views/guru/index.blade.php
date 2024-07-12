@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="normal-table-list">
                <div class="basic-tb-hd">
                    <h2>Data Guru</h2>
                    <div class="flex justify-between">
                        <a href="{{ route('form.tambah.guru') }}" class="btn btn-success notika-btn-success waves-effect">Tambah Guru</a>
                        <div class="nk-int-st" style="width: 40%">
                            <form action="{{ route('daftar.guru') }}" method="GET">
                                <input type="text" name="query" class="form-control input-md" placeholder="Cari berdasarkan Nama atau NIP" value="{{ Request::get('query') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bsc-tbl-st">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_guru as $index => $guru)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $guru->nip }}</td>
                                    <td>{{ $guru->nama }}</td>
                                    <td>
                                        <a href="{{ route('form.ubah.guru', ['idGuru' => $guru->idGuru]) }}">Ubah</a>
                                        <a href="{{ route('hapus.guru', ['idGuru' => $guru->idGuru]) }}">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data_guru) <= 0)
                                <tr>
                                    <td colspan="5">Data guru tidak ada</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection