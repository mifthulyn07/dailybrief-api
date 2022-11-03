<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role1=null, $role2=null)
    {
        if ($request->user()->role == $role1 || $request->user()->role == $role2) {
            return $next($request);
        }
        return response()->json([
            'status' => false,
            'errors' => 'Anda tidak memiliki hak mengakses laman tersebut!',
        ], 403);
    }

}
