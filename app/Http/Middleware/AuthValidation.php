<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\peserta;
use App\Http\Controllers\v1\TokenController;
use App\Helper\Response;
class AuthValidation
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
        $validation_db_token = peserta::where('token', $request->header('Authorization'))->first();
        if ($validation_db_token) {
            $token = TokenController::checkToken($validation_db_token->token);
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
