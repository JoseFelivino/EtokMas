<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles = null )
    {
        $rolesInArray = explode('|', $roles);
        if (Auth::user() == null) return redirect()->back()->with('errorMessage', 'You are not authorized to access this path');
        if ( in_array(Auth::user()->role->name, $rolesInArray ))  return $next($request);
            //TODO: suruh brenli buat page yg isinya message
        return redirect()->back()->with('errorMessage', 'You are not authorized to access this path');
    }
}
