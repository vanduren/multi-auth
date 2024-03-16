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
    public function handle(Request $request, Closure $next, string $expectedRole): Response
    {
        if (!$request->user()){
            return redirect()->route('login');
        }
        switch ($expectedRole){
            case '1':
                $expectedUri = '/superadmin';
                break;
            case '2':
                $expectedUri = '/admin';
                break;
            case '3':
                $expectedUri = '/dashboard';
                break;
            default:
                $expectedUri = '/';
        }
        switch ($request->user()->role){
            case '1':
                $allowedUri = '/superadmin';
                break;
            case '2':
                $allowedUri = '/admin';
                break;
            case '3':
                $allowedUri = '/dashboard';
                break;
            default:
                $allowedUri = '/';
        }
        $requestedUri = $request->getRequestUri();
        $role = $request->user()->role;

        // dd($requestedUri, $expectedUri, $role, $expectedRole, $allowedUri);
        if (!($role == $expectedRole && $requestedUri == $expectedUri)){
            return redirect($allowedUri);
        }
        return $next($request);
    }
}
