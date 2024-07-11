<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AutentikasiController extends Controller
{
    const ROLE_ADMIN = 0;
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
           $request->session()->put('role', self::ROLE_ADMIN);
           $request->session()->put('user', $admin_record);
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
        }

    }
}
