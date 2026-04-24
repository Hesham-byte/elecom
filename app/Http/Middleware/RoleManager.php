<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\String\s;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $authUserRole = Auth::user()->role;

        switch ($role) {
            case 'admin':
                if ($authUserRole == 0) {
                    return $next($request);
                }
                break;
            case 'vendor':
                if ($authUserRole == 1) {
                    return $next($request);
                }
                break;
            case 'customer':
                if ($authUserRole == 2) {
                    return $next($request);
                }
                break;
            default:
                return redirect('/unauthorized');
        }

        switch ($authUserRole) {
            case 0:
                return redirect('/admin/dashboard');
            case 1:
                return redirect('/vendor/dashboard');
            case 2:
                return redirect('/dashboard');
            default:
                return redirect('/unauthorized');
        }

        return redirect('/unauthorized');

    }
}
