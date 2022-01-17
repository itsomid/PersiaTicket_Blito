<?php

namespace App\Http\Middleware;

use Closure;

class CheckPanelAccess
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
        $user = $request->user();
        if ($user->access_level < 5 || $user->status != "enabled") {
            \Auth::logout();
            return redirect('panel');
        }
        return $next($request);
    }
}
