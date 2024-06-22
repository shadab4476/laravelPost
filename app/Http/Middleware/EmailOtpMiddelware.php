<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailOtpMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!session()->has('verified_mobile_otp')) {
            if (auth()->check()) {
                return redirect()->route('getverify.otp')->with(["status" => "otp sent."]);
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}
