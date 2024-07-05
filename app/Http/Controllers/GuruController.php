<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function formBuatGuru(Request $request) {
        return view('guru.form')
            ->with('user', Auth::user());
    }

    public function buatGuru(Request $request) {
        $inputan_user = $request->only('username', 'password');
        $aturan_inputan_user = [
            'username'  => 'required|unique:guru',
            'password'  => 'required'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        DB::table('guru')
            ->insertGetId($inputan_user);
        return redirect()
            ->route('guru.index')
            ->with(['success' => 'Data guru berhasil ditambahkan']);
    }

    public function formUbahGuru(Request $request, $idGuru) {
        $data_guru = DB::table('guru')
            ->where('idGuru', $idGuru)
            ->first();
        
        if (!$data_guru) {
            return back()
                ->with(['error' => 'Data guru tidak ditemukan']);
        }

        return view('guru.form')
            ->with('data', $data_guru)
            ->with('user', Auth::user()); 
    }

    public function ubahGuru(Request $request) {
        $idGuru = $request->input('idGuru');
        $data_guru = DB::table('guru')
            ->where('idGuru', $idGuru)
            ->first();
    
        if (!$data_guru) {
            return back()
                ->with(['error' => 'Data guru tidak ditemukan']);
        }
        
        $inputan_user = $request->only('username', 'password');
        $aturan_inputan_user = [
            'username'  => 'required|unique:guru',
            'password'  => 'required'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        DB::table('guru')
            ->where('idGuru', $idGuru)
            ->update($inputan_user);
        
        return redirect()
            ->route('guru.index')
            ->with(['success' => 'Data guru berhasil diubah']);
    }

    public function lihatGuru(Request $request) {
        $data_guru = DB::table('guru')
            ->paginate(10);
        return view('guru.index')
            ->with('data', $data_guru);
    }
}
