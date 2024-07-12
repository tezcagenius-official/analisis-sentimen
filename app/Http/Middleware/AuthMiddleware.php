<?php

namespace App\Http\Middleware;

use App\Constant\Runtime;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user')) {
            return redirect()
                ->route('login')
                ->with(['password' => 'Kamu harus login untuk mengakses halaman admin']);
        }


        $user = $request->session()->get('user');

        if ($user->role_type == Runtime::ROLE_ADMIN) {
            $admin_record = DB::table('admin')
                ->where('idAdmin', $user->id);
            if (!$admin_record) {
                return redirect()
                    ->route('login')
                    ->with(['password' => 'Akun kamu tidak valid, silahkan login ulang']);
            }
        }

        if ($user->role_type == Runtime::ROLE_GURU) {
            $teacher_record = DB::table('guru')
                ->where('idGuru', $user->id);
            if (!$teacher_record) {
                return redirect()
                    ->route('login')
                    ->with(['password' => 'Akun kamu tidak valid, silahkan login ulang']);
            }
        }
        
        return $next($request);
    }
}
