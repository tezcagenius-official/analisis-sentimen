@extends('layouts.main')

@section('main')
<div class="row mg-t-20 flex">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
        <form action="{{ route($target_route) }}" method="POST">
            @csrf
            <div class="form-example-wrap">
            <div class="cmp-tb-hd">
                <h2>{{ $page_title }}</h2>
            </div>
            <div class="form-example-int">
                @if (!empty($data))
                    <input type="hidden" name="idKelas" value="{{ $data->idKelas }}">
                @endif
                <div class="form-group">
                <label>Nama Kelas</label>
                <div class="nk-int-st">
                    <input type="text" name="namaKelas" class="form-control input-sm" placeholder="Masukan nama kelas" value="{{ old('namaKelas', empty($data) ? '' : $data->namaKelas) }}">
                    @error('namaKelas')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                </div>
            </div>
            <div class="form-example-int mg-t-15">
                <div class="form-group">
                <label>Masukan Wali Kelas</label>
                <div class="nk-int-st">
                    <select name="waliKelas" class="form-control input-sm">
                        @foreach ($data_guru as $guru)
                            <option 
                                value="{{ $guru->idGuru }}"
                                @if (old('waliKelas', empty($data) ? 0 : $data->waliKelas) == $guru->idGuru)
                                    selected
                                @endif
                            >
                                {{ $guru->nip }} - {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('waliKelas')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror 
                </div>
                </div>
            </div>
            <div class="form-example-int mg-t-15">
            </div>
            <div class="form-example-int mg-t-15">
                <button  type="submit" class="btn btn-success notika-btn-success waves-effect">Submit</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection