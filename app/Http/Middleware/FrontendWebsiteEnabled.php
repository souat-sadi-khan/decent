<?php

namespace App\Http\Middleware;

use Closure;

class FrontendWebsiteEnabled
{
    /**
     * Used to check a feature is available or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  feature  type="string"  required="true"
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! get_option('enable_frontend_website')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
