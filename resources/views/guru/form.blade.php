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
                    <input type="hidden" name="idGuru" value="{{ $data->idGuru }}">
                @endif
                <div class="form-group">
                    <label>Nomor Induk Pegawai (NIP)</label>
                    <div class="nk-int-st">
                        <div class="nk-int-st">
                            <input type="text" name="nip" class="form-control input-sm" placeholder="Masukan nomor induk pegawai" value="{{ old('nip', empty($data) ? '' : $data->nip) }}">
                        </div>
                        @error('nip')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <div class="nk-int-st">
                        <input type="text" name="nama" class="form-control input-sm" placeholder="Masukan nama guru" value="{{ old('nama', empty($data) ? '' : $data->nama) }}"> 
                    </div>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror 
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <div class="nk-int-st">
                        <input type="text" name="username" class="form-control input-sm" placeholder="Masukan username" value="{{ old('username', empty($data) ? '' : $data->username) }}"> 
                    </div>
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror 
                </div>
                @if (!empty($data))
                    <div class="form-group">
                        <label>Password Lama</label>
                        <div class="nk-int-st">
                            <input type="password" name="password_lama" class="form-control input-sm" placeholder="Masukan password baru" value=""> 
                        </div>
                        @error('password_lama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror 
                    </div> 
                @endif
                <div class="form-group">
                    <label>Password {{ empty($data) ? ''  : 'Baru'}}</label>
                    <div class="nk-int-st">
                        <input type="password" name="password" class="form-control input-sm" placeholder="Masukan password {{ empty($data) ? ''  : 'baru'}}" value=""> 
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror 
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