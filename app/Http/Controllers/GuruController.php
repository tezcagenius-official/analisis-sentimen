<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function formTambahGuru(Request $request) {
        return view('guru.form')
            ->with('target_route', 'tambah.guru')
            ->with('page_title', 'Tambah Guru')
            ->with('user', $request->session()->get('user'));
    }

    public function tambahGuru(Request $request) {
        $inputan_user = $request->only('nip', 'nama', 'username', 'password');
        $aturan_inputan_user = [
            'username'  => 'required|unique:guru,username',
            'nip'  => 'required|unique:guru,nip',
            'nama'  => 'required',  
            'password'  => 'required'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        $inputan_user['password'] = Hash::make($inputan_user['password']);

        DB::table('guru')
            ->insertGetId($inputan_user);
        return redirect()
            ->route('daftar.guru')
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
            ->with('target_route', 'ubah.guru')
            ->with('page_title', 'Ubah data guru')
            ->with('user', $request->session()->get('user'));
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
        
        $inputan_user = $request->only('nip', 'nama', 'username');
        $aturan_inputan_user = [
            'username'  => 'required|unique:guru,username,'.$data_guru->idGuru.',idGuru',
            'nip'  => 'required|unique:guru,nip,'.$data_guru->idGuru.',idGuru',
            'nama'  => 'required'
        ];

        if (!empty($request->input('password'))) {
            $aturan_inputan_user['password_lama'] = ['required', function ($attribute, $value, $fail) use ($data_guru) {
                if (!Hash::check($value, $data_guru->password)) {
                    return $fail(_('Konfirmasi password lama tidak sesuai'));
                }
            }];
            $inputan_user['password_lama'] = $request->input('password_lama');
        }
        
        $validasi = Validator::make($inputan_user, $aturan_inputan_user);

        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        if (!empty($request->input('password'))) {
			unset($inputan_user['password_lama']);
			$inputan_user['password'] = Hash::make($request->input('password'));
		}

        DB::table('guru')
            ->where('idGuru', $data_guru->idGuru)
            ->update($inputan_user);

        return redirect()
            ->route('daftar.guru')
            ->with(['success' => 'Data guru berhasil diubah']);
    }

    public function lihatGuru(Request $request) {
        $query = DB::table('guru');
        if ($request->has('query')) {
            $query->where('guru.nama', 'LIKE', '%'. $request->get('query') . '%')
                ->orWhere('guru.nip', 'LIKE', '%' . $request->query('query') . '%');
        }
        $data_guru = $query->get();
        return view('guru.index')
            ->with('user', $request->session()->get('user'))
            ->with('data_guru', $data_guru);
    }

    public function hapusGuru(Request $request, $idGuru) {
        $guru = DB::table('guru')
            ->where('idGuru', $idGuru)
            ->first();
    
        if (!$guru) {
            return back()
                ->with(['error' => 'Data guru tidak ditemukan']);
        }

        DB::table('kelas')
            ->where('waliKelas', $idGuru)
            ->update(['waliKelas' => 0]);

        Session::flash('success', 'Data guru berhasil dihapus');
        DB::table('guru')
            ->where('idGuru', $idGuru)
            ->delete();
        return redirect()
            ->route('daftar.guru')
            ->with(['success' => 'Data guru berhasil hapus']); 
    }
}
