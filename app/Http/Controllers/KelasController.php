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
            ->addSelect('kelas.idKelas')
            ->addSelect('kelas.namaKelas')
            ->addSelect(DB::raw('guru.nama AS waliKelas'))
            ->leftJoin('guru', 'guru.idGuru', '=', 'kelas.waliKelas')
            ->paginate(10);
        
        foreach ($data_kelas as $urutan => $kelas) {
            $data_siswa = DB::table('siswa')
                ->where('idKelas', $kelas->idKelas)
                ->get();
            $data_kelas[$urutan]->siswa = $data_siswa;
        }

        return view('kelas.index')
            ->with('user', Auth::user())
            ->with('data_kelas', $data_kelas);
    }

    public function formTambahKelas(Request $request) {
        $data_guru = DB::table('guru')->get();
        return view('kelas.form')
            ->with('data_guru', $data_guru)
            ->with('page_title', 'Menambahkan data kelas')
            ->with('target_route', 'tambah.kelas')
            ->with('data', NULL)
            ->with('user', Auth::user());
    }

    public function tambahKelas(Request $request) {
        $inputan_user = $request->only('namaKelas', 'waliKelas');
        $aturan_inputan_user = [
            'namaKelas'  => 'required',
            'waliKelas' => 'required|exists:guru,idGuru'
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        // validasi guru telah mewakili kelas
        $data_kelas = DB::table('kelas')
            ->where('waliKelas', $inputan_user['waliKelas'])
            ->first();

        if ($data_kelas) {
            return redirect()
                ->back()
                ->withErrors(['waliKelas' => 'Wali kelas yang dipilih telah menjadi wali kelas untuk kelas ' . $data_kelas->namaKelas])
                ->withInput();
        }

        Session::flash('success', 'Data kelas berhasil ditambahkan');
        DB::table('kelas')
            ->insertGetId($inputan_user);

        return redirect()
            ->route('daftar.kelas')
            ->with(['success' => 'Data kelas berhasil ditambahkan']);
    }

    public function formUbahKelas(Request $request, $idKelas) {
        $data_kelas = DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->first();
        
        $data_guru = DB::table('guru')->get();
        if (!$data_kelas) {
            return back()
                ->with(['error' => 'Data kelas tidak ditemukan']);
        }

        return view('kelas.form')
            ->with('data', $data_kelas)
            ->with('page_title', 'Mengubah data kelas')
            ->with('target_route', 'ubah.kelas')
            ->with('data_guru', $data_guru)
            ->with('user', Auth::user()); 
    }

    public function ubahKelas(Request $request) {
        $idKelas = $request->input('idKelas');
        $kelas = DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->first();
    
        if (!$kelas) {
            return back()
                ->with(['error' => 'Data kelas tidak ditemukan']);
        }
        
        $inputan_user = $request->only('namaKelas', 'waliKelas');
        $aturan_inputan_user = [
            'namaKelas'  => 'required',
            'waliKelas' => 'required|exists:guru,idGuru'
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

         // validasi guru telah mewakili kelas
         $data_kelas = DB::table('kelas')
            ->where('waliKelas', $inputan_user['waliKelas'])
            ->first();

        if ($data_kelas && $inputan_user['waliKelas'] != $kelas->waliKelas) {
            return redirect()
                ->back()
                ->withErrors(['waliKelas' => 'Wali kelas yang dipilih telah menjadi wali kelas untuk kelas ' . $data_kelas->namaKelas])
                ->withInput();
        }

        Session::flash('success', 'Data kelas berhasil dirubah');
        DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->update($inputan_user);
        return redirect()
            ->route('daftar.kelas')
            ->with(['success' => 'Data kelas berhasil diubah']);
    }

    public function hapusKelas(Request $request, $idKelas)
    {
        $kelas = DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->first();
    
        if (!$kelas) {
            return back()
                ->with(['error' => 'Data kelas tidak ditemukan']);
        }

        Session::flash('success', 'Data kelas berhasil dihapus');
        DB::table('kelas')
            ->where('idKelas', $idKelas)
            ->delete();
        return redirect()
            ->route('daftar.kelas')
            ->with(['success' => 'Data kelas berhasil hapus']); 
    }
}
