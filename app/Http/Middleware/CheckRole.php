<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user()->type != $role){
            return redirect('/admin')->with('flash_message_error','You are not Allowed!');
        }
        return $next($request);
    }
}
