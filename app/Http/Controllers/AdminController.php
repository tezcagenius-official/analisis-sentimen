<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function formBuatAdmin(Request $request) {
        return view('Admin.form')
            ->with('user', Auth::user());
    }

    public function buatAdmin(Request $request) {
        $inputan_user = $request->only('username', 'password');
        $aturan_inputan_user = [
            'username'  => 'required|unique:Admin',
            'password'  => 'required'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        Session::flash('success', 'Data admin berhasil ditambahkan');
        DB::table('admin')
            ->insertGetId($inputan_user);
    }

    public function formUbahAdmin(Request $request, $idAdmin) {
        $data_Admin = DB::table('admin')
            ->where('idAdmin', $idAdmin)
            ->first();
        
        if (!$data_Admin) {
            return back()
                ->with(['error' => 'Data Admin tidak ditemukan']);
        }

        return view('admin.form')
            ->with('data', $data_Admin)
            ->with('user', Auth::user()); 
    }

    public function ubahAdmin(Request $request) {
        $idAdmin = $request->input('idAdmin');
        $data_Admin = DB::table('admin')
            ->where('idAdmin', $idAdmin)
            ->first();
    
        if (!$data_Admin) {
            return back()
                ->with(['error' => 'Data admin tidak ditemukan']);
        }
        
        $inputan_user = $request->only('username', 'password');
        $aturan_inputan_user = [
            'username'  => 'required|unique:Admin',
            'password'  => 'required'  
        ];

        $validasi = Validator::make($inputan_user, $aturan_inputan_user);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withErrors($validasi)
                ->withInput();
        }

        DB::table('admin')
            ->where('idAdmin', $idAdmin)
            ->update($inputan_user);
        
        return redirect()
            ->route('admin.index')
            ->with(['success' => 'Data admin berhasil diubah']);
    }

    public function lihatAdmin(Request $request) {
        $data_Admin = DB::table('admin')
            ->paginate(10);
        return view('admin.index')
            ->with('data', $data_Admin);
    }
}
