<?php

namespace App\Laravel\Middlewares\Api;

use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as Jwt;

class JWTAuth extends BaseMiddleware{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, \Closure $next, $guard = "api"){
        try{
            if (!$token = $request->bearerToken()) {
                return $this->respond('jwt.absent', 'token_not_provided', 400);
            }

            $user = auth($guard)->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        } catch (TokenBlacklistedException $e) {
            return $this->respond('jwt.expired', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (!$user) {
            return $this->respond('jwt.user_not_found', 'user_not_found', 404);
        }

        return $next($request);
    }

 /**
     * Fire event and return the response.
     *
     * @param  string   $event
     * @param  string   $error
     * @param  int  $status
     * @param  array    $payload
     * @return mixed
     */
    protected function respond($event, $error, $status, $payload = []){
        $response = [];
        $response_code = 401;

        switch($error) {
            case 'token_not_provided':
                $response = [
                    'msg' => "Token not provided",
                    'status' => false,
                    'status_code' => "TOKEN_NOT_PROVIDED",
                    'hint' => "You can obtain a token in a successful login/register request.",
                ];
                break;
            case 'token_expired':
                $response = [
                    'msg' => "Your session has expired.",
                    'status' => false,
                    'status_code' => "TOKEN_EXPIRED",
                    'hint' => "You must try refreshing your token. If this error still occurs, you must re-login.",
                ];
                break;
            case 'token_invalid':
                $response = [
                    'msg' => "Invalid token",
                    'status' => false,
                    'status_code' => "TOKEN_INVALID",
                    'hint' => "You can obtain a token in a successful login/register request.",
                ];
                break;
            case 'user_not_found':
                $response = [
                    'msg' => "Invalid acccount access.",
                    'status' => false,
                    'status_code' => "INVALID_AUTH_USER",
                ];
                break;
        }

        return response()->json($response, $response_code);
    }
}