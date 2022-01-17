<?php

namespace App\Http\Middleware;

use Closure;

class WebsiteCheckAuth
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
        if (is_null($request->user()))
        {
            return response()->redirectToRoute('website/home')->with('login', true);
        }
        return $next($request);
    }
}
