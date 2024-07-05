<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function lihatKelas(Request $request) {
        $data_kelas = DB::table('kelas')
            ->paginate(10);
        
        foreach ($data_kelas as $urutan => $kelas) {
            $data_siswa = DB::table('siswa')
                ->where('idKelas', $kelas->idKelas)
                ->get();
            $data_kelas[$urutan]->siswa = $data_siswa;
        }

        return view('kelas.index')
            ->with('user', Auth::user())
            ->with('data', $data_kelas);
    }

    public function formBuatKelas(Request $request) {
        return view('kelas.form')
            ->with('user', Auth::user());
    }

    public function buatKelas(Request $request) {
        $inputan_user = $request->only('namaKelas');
        $aturan_inputan_user = [
            'nameKelas'  => 'required',
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        Session::flash('success', 'Data kelas berhasil ditambahkan');
        DB::table('kelas')
            ->insertGetId($inputan_user);
    }

    public function formUbahKelas(Request $request, $idKelas) {
        $data_kelas = DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->first();
        
        if (!$data_kelas) {
            return back()
                ->with(['error' => 'Data kelas tidak ditemukan']);
        }

        return view('kelas.form')
            ->with('data', $data_kelas)
            ->with('user', Auth::user()); 
    }

    public function ubahKelas(Request $request) {
        $idKelas = $request->input('idKelas');
        $data_kelas = DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->first();
    
        if (!$data_kelas) {
            return back()
                ->with(['error' => 'Data kelas tidak ditemukan']);
        }
        
        $inputan_user = $request->only('namKelas');
        $aturan_inputan_user = [
            'nameKelas'  => 'required',
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        Session::flash('success', 'Data kelas berhasil dirubah');
        return redirect()
            ->route('kelas.index')
            ->with(['success' => 'Data kelas berhasil diubah']);
    }
}
