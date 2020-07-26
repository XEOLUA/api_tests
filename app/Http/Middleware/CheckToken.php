<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\VarDumper\VarDumper;

class CheckToken
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

        $token_env = env('TOKEN','');

        $token_header = $request->header('token');

        if ($token_env != $token_header)
        {
//        dd(1);
            return redirect('error');
        }
//        dd(2);
        return $next($request);
    }
}
