<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->session()->has('user')) {
            return redirect()
                ->route('login')
                ->with(['password' => 'Kamu harus login untuk mengakses halaman admin']);
        }


        $user = $request->session()->get('user');
        if (!in_array($user->role_type, $roles)) {
            $request->session()->forget('user');
            return redirect()
                ->route('login')
                ->with(['password' => 'Anda tidak mempunya akses untuk melihat halaman tersebut']);
        }
        
        return $next($request);
    }
}
