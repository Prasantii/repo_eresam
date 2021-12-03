<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PnsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->session()->get('is_pns_front')){
            
                return $next($request);
            
        }else{
            return redirect('/login');
        }
        
    }
}
