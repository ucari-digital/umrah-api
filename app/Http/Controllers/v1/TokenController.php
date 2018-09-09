<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\peserta;

// 3Rd, Helper
use \Firebase\JWT\JWT;
use App\Helper\Response;
class TokenController extends Controller
{
    public function getToken(Request $request)
    {
        if ($request->header('x-api-key') == env('TOKEN_WEB_KEY', null)) {
            $key = "DN4_UhAj";
            $token = array(
                "iss" => env('TOKEN_ISS', ''),
                "aud" => env('TOKEN_AUD', ''),
                "nbf" => strtotime('now'),
                "exp" => strtotime("+5 hours")
                // "exp" => strtotime("+1 minutes")
            );

            $jwt = JWT::encode($token, $key);
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            $arr_token = [
                'token' => $jwt,
                'generate'=> $decoded->nbf,
                'expired' => $decoded->exp
            ];

            return Response::json($arr_token, 'Generated Token', 'success', 200);
        } else {
            return Response::json(null, 'Unauthorized', 'failed', 401);
        }
    }

    public static function checkToken($res_token)
    {
        try{
            $key = "DN4_UhAj";
            $jwt = JWT::encode($res_token, $key);
            $decoded = JWT::decode($res_token, $key, array('HS256'));

            $arr_token = [
                'token' => $jwt,
                'generate'=> $decoded->nbf,
                'expired' => $decoded->exp
            ];

            return Response::json($arr_token, 'Active Token', 'success', 200);
        } catch(\Exception $e) {
            return Response::json($e->getMessage(), 'Expired Token', 'failed', 419);
        }
        
    }
    
    public static function tokenValidator(Request $request)
    {
        try{
            $validation_db_token = peserta::where('token', $request->header('Authorization'))->first();
            if ($validation_db_token) {
                $token = TokenController::checkToken($validation_db_token->token);
                if ($token['response'] == 'success') {
                    return Response::json($validation_db_token, 'Active Token', 'success', 200);
                } else {
                    return response(Response::json('', 'Unauthorized', 'failed', 401));
                }
            } else {
                return response(Response::json('', 'Unauthorized', 'failed', 401));
            }

        } catch(\Exception $e) {
            return Response::json($e->getMessage(), 'Expired Token', 'failed', 419);
        }
        
    }
}
