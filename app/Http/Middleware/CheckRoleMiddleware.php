<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()){
            return redirect()->route('login');
        }
        $uriOrigin = $request->getRequestUri();
        $role = $request->user()->role;
        if ($role == '3' && $uriOrigin == '/dashboard'){
            return $next($request);
        }elseif ($role == '3' && $uriOrigin != '/dashboard'){
                return redirect()->route('dashboard');
        }
        if ($role == '1' && $uriOrigin == '/superadmin'){
            return $next($request);
        }elseif ($role == '1' && $uriOrigin != '/superadmin'){
            return redirect()->route('superadmin');
        }
        if ($role == '2' && $uriOrigin == '/admin'){
            return $next($request);
        }elseif ($role == '2' && $uriOrigin != '/admin'){
            return redirect()->route('admin');
        }
        return $next($request);
    }
}
