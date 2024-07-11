@extends('layouts.main')

@section('main')
<div class="row mg-t-20 flex">
<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mx-auto">
        <form action="{{ route($target_route) }}" method="POST">
            @csrf
            <div class="form-example-wrap">
            <div class="cmp-tb-hd">
                <h2>{{ $page_title }}</h2>
            </div>
            <div class="form-example-int">
               
                
            </div>
            <div class="form-example-int">
                @if (!empty($data))
                    <input type="hidden" name="idSiswa" value="{{ $data->idSiswa }}">
                @endif
                <div class="form-group">
                    <label>Kelas</label>
                    <div class="nk-int-st">
                        <select name="idKelas" class="form-control input-sm">
                            @foreach ($data_kelas as $kelas)
                                <option 
                                    value="{{ $kelas->idKelas }}"
                                    @if (old('idKelas', empty($data) ? 0 : $data->idKelas) == $kelas->idKelas)
                                        selected
                                    @endif
                                >
                                    {{ $kelas->namaKelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('idKelas')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <div class="nk-int-st">
                        <div class="nk-int-st">
                            <input type="text" name="nama" class="form-control input-sm" placeholder="Masukan nama siswa" value="{{ old('nama', empty($data) ? '' : $data->nama) }}">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Masukan Usia</label>
                    <div class="nk-int-st">
                        <input type="text" name="usia" class="form-control input-sm" placeholder="Masukan usia" value="{{ old('usia', empty($data) ? '' : $data->usia) }}"> 
                        @error('usia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror 
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="nk-int-st">
                        <select name="jenisKelamin" class="form-control input-sm">
                            @foreach ($jenis_kelamin as $kelamin)
                                <option 
                                    value="{{ $kelamin }}"
                                    @if (old('jenisKelamin', empty($data) ? 0 : $data->jenisKelamin) == $kelamin)
                                        selected
                                    @endif
                                >
                                    {{ $kelamin }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenisKelamin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror 
                    </div>
                </div>
            </div>
            <div class="form-example-int mg-t-15">
            </div>
            <div class="form-example-int mg-t-15">
                <button  type="submit" class="btn btn-success notika-btn-success waves-effect">Simpan</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection