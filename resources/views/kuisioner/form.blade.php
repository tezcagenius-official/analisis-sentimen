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
                    <input type="hidden" name="idKuisioner" value="{{ $data->idKuisioner }}">
                @endif
                <div class="form-group">
                    <label>Pilih Siswa</label>
                    <div class="nk-int-st">
                        <select name="idSiswa" class="form-control input-sm">
                            @foreach ($data_siswa as $siswa)
                                <option 
                                    value="{{ $siswa->idSiswa }}"
                                    @if (old('idSiswa', empty($data) ? 0 : $data->idSiswa) == $siswa->idSiswa)
                                        selected
                                    @endif
                                >
                                    {{ $siswa->namaKelas }} - {{ $siswa->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('idSiswa')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror 
                    </div> 
                </div>

                @foreach($data_pertanyaan as $index => $pertanyaan)
                    <div class="form-group">
                        <label>{{ $pertanyaan->question }}</label>
                        <div class="nk-int-st">
                            @if ($pertanyaan->type == 'select')
                                <select name="pertanyaan[{{ $pertanyaan->id }}]" class="form-control input-sm">
                                    @foreach ($pertanyaan->option as $pilihan)
                                        <option 
                                            value="{{ $pilihan }}"
                                            @if (old('pertanyaan['.$pertanyaan->id.']', empty($pertanyaan->value) ? '' : $pertanyaan->value) == $pilihan)
                                                selected
                                            @endif
                                        >
                                            {{ $pilihan }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @if ($pertanyaan->type == 'radio')
                                <div class="flex" style="gap: 20px; align-items: center;">
                                    @foreach ($pertanyaan->option as $idx => $pilihan)
                                        <div>
                                            <input 
                                                type="radio" name="pertanyaan[{{ $pertanyaan->id }}]" id="radio[{{$pertanyaan->id}}][{{ $idx }}]" 
                                                value="{{ $pilihan }}" 
                                                @if (old('pertanyaan['.$pertanyaan->id.']', empty($pertanyaan->value) ? '' : $pertanyaan->value) == $pilihan)
                                                    checked
                                                @endif
                                            />
                                            <label for="radio[{{$pertanyaan->id}}][{{ $idx }}]">{{ $pilihan }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @php
                                $error_key = 'pertanyaan.' . $pertanyaan->id;
                            @endphp
                           
                        </div>  
                        @error($error_key)
                            <small class="text-danger">{{ $message }}</small>
                        @enderror 
                    </div>
                @endforeach
            </div>
            <div class="form-example-int mg-t-15">
                <button  type="submit" class="btn btn-success notika-btn-success waves-effect">Simpan</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection