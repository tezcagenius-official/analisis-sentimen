<?php

namespace App\Http\Controllers;

use App\Constant\Runtime;
use App\Helper\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function lihatSiswa(Request $request) {
        $query = DB::table('siswa')
            ->addSelect('siswa.idSiswa', 'siswa.nama', 'siswa.usia', 'siswa.jenisKelamin', 'siswa.kodeSiswa')
            ->addSelect('kelas.namaKelas')
            ->join('kelas', 'kelas.idKelas', '=', 'siswa.idKelas');
        
        if ($request->has('query')) {
            $query->where('siswa.nama', 'LIKE', '%'. $request->get('query') . '%');
        }

        $user = $request->session()->get('user');

        if ($user->role_type == Runtime::ROLE_GURU) {
            $query->where('kelas.waliKelas', '=', $user->id);
        }
        $data_siswa = $query->get();
        return view('siswa.index')
            ->with('data_siswa', $data_siswa)
            ->with('user', $request->session()->get('user'));
    }

    public function formTambahSiswa(Request $request) {
        $data_kelas = DB::table('kelas')
            ->get();
        $jenis_kelamin = ['Pria', 'Wanita']; 
        return view('siswa.form')
            ->with('data_kelas', $data_kelas)
            ->with('target_route', 'tambah.siswa')
            ->with('page_title', 'Tambah Siswa')
            ->with('jenis_kelamin', $jenis_kelamin)
            ->with('user', $request->session()->get('user'));
    }

    public function tambahSiswa(Request $request) {
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

        $inputan_user['kodeSiswa'] = strtoupper(Common::generateRandomCode());
        DB::table('siswa')
            ->insert($inputan_user);
        return redirect()
            ->route('daftar.siswa')
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

        $jenis_kelamin = ['Pria', 'Wanita']; 
        $data_kelas = DB::table('kelas')
            ->get();
        
        return view('siswa.form')
            ->with('data_kelas', $data_kelas)
            ->with('data', $data_siswa)
            ->with('user', $request->session()->get('user'))
            ->with('jenis_kelamin', $jenis_kelamin)
            ->with('target_route', 'ubah.siswa')
            ->with('page_title', 'Mengubah Siswa');
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

        DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->update($inputan_user);

        return redirect()
            ->route('daftar.siswa')
            ->with(['success' => 'Data siswa berhasil rubah']);
    }

    public function hapusSiswa(Request $request, $idSiswa) {
        $data_siswa = DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->first();
    
        if (!$data_siswa) {
            return back()
                ->with(['error' => 'Data siswa tidak ditemukan']);
        } 

        DB::table('siswa')
            ->where('idSiswa', $idSiswa)
            ->delete();
        
        return redirect()
            ->route('daftar.siswa')
            ->with(['success' => 'Data siswa berhasil dihapus']);
    }
}
