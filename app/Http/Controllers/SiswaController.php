<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function lihatSiswa(Request $request) {
        $data_siswa = DB::table('siswa')
            ->addSelect('nama', 'usia', 'jenisKelamin')
            ->addSelect(DB::raw('kelas.nama AS namaKelas'))
            ->join('kelas', 'kelas.idKelas', '=', 'siswa.idKelas')
            ->paginate(10);
        
        return view('siswa.index')
            ->with('data', $data_siswa)
            ->with('user', Auth::user());
    }

    public function formBuatSiswa(Request $request) {
        $data_kelas = DB::table('kelas')
            ->get();
        
        return view('siswa.form')
            ->with('data_kelas', $data_kelas)
            ->with('user', Auth::user());
    }

    public function buatSiswa(Request $request) {
        $inputan_user = $request->only('nama', 'usia', 'jenisKelamin', 'idKelas');
        $aturan_inputan_user = [
            'nama'  => 'required',
            'usia'  => 'required',  
            'jenisKelamin'  => 'required',
            'idKelas' => 'required|exists:kelas,idKelas'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        Session::flash('success', 'Data siswa berhasil ditambahkan');
        
        return redirect()
            ->route('siswa.index')
            ->with(['success' => 'Data siswa berhasil ditambahkan']);
    }

    public function formUbahSiswa(Request $request, $idSiswa) {
        $data_siswa = DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->first();
        
        if (!$data_siswa) {
            return back()
                ->with(['error' => 'Data siswa tidak ditemukan']);
        }


        $data_kelas = DB::table('kelas')
            ->get();
        
        return view('siswa.form')
            ->with('data_kelas', $data_kelas)
            ->with('data', $data_siswa)
            ->with('user', Auth::user());
    }

    public function ubahSiswa(Request $request) {
        $idSiswa = $request->input('idSiswa');
        $data_siswa = DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->first();
    
        if (!$data_siswa) {
            return back()
                ->with(['error' => 'Data siswa tidak ditemukan']);
        }


        $inputan_user = $request->only('nama', 'usia', 'jenisKelamin', 'idkelas');
        $aturan_inputan_user = [
            'nama'  => 'required',
            'usia'  => 'required',  
            'jenisKelamin'  => 'required',
            'idKelas' => 'required|exists:kelas,idKelas'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        Session::flash('success', 'Data siswa berhasil diubah');
        DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->update($inputan_user);

        return redirect()
            ->route('siswa.index')
            ->with(['success' => 'Data siswa berhasil rubah']);
    }
}
