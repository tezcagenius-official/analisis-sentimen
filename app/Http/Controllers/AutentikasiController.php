<?php

namespace App\Http\Controllers;

use App\Constant\Runtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;

class AutentikasiController extends Controller
{
    const ROLE_ADMIN = 0;
    const ROLE_GURU = 0;
    public function login(Request $request) {
        $user_input = $request->only('username', 'password');
        $user_input_field_rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user_record = new stdClass();
        $admin_record = DB::table('admin')
            ->where('username', $user_input['username'])
            ->first();
       
        if ($admin_record) {
           $match = Hash::check($user_input['password'], $admin_record->password);
           if (!$match) {
                return back()
                    ->withErrors(['password' => 'Password tidak sesuai'])
                    ->withInput();
           }

           $user_record->id = $admin_record->idAdmin;
           $user_record->nama = $admin_record->username;
           $user_record->role_type = Runtime::ROLE_ADMIN;
           $user_record->nama_role = 'Admin';

           $request->session()->put('user', $user_record);
           return redirect()
                ->route('dashboard');
        }

        $teacher_record = DB::table('guru')
            ->where('username', $user_input['username'])
            ->first();
        
        if ($teacher_record) {
            $match = Hash::check($user_input['password'], $teacher_record->password);
            if (!$match) {
                    return back()
                        ->withErrors(['password' => 'Password tidak sesuai'])
                        ->withInput();
            }

            $data_kelas = DB::table('kelas')
                ->where('waliKelas', $teacher_record->idGuru)
                ->first();
            $user_record->id = $teacher_record->idGuru;
            $user_record->nama = $teacher_record->nama;
            $user_record->role_type = Runtime::ROLE_GURU;
            $user_record->nama_role = 'Guru';
            $user_record->kelas = $data_kelas;
            $request->session()->put('user', $user_record);
            return redirect()
                ->route('dashboard');
        }

        return back()
            ->withErrors(['password' => 'Username atau password tidak sesuai'])
            ->withInput();
    }

    public function keluar(Request $request) {
        $request->session()->forget('user'); 
        return redirect()
            ->route('login');
    }
}
