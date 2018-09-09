<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\v1\TokenController;
use App\Helper\Response;
class TokenValidation
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
        if ($request->header('Authorization')) {
            $token = TokenController::checkToken($request->header('Authorization'));
            if ($token['response'] == 'success') {
                return $next($request);
            } else {
                return response(Response::json('', 'Unauthorized', 'failed', 401));
            }
            return $next($request);                
        } else {
            return response(Response::json('', 'Unauthorized', 'failed', 401));
        }
    }
}
