<?php
/**
 * Created by PhpStorm.
 * User: marcela
 * Date: 14/04/18
 * Time: 10:02
 */

namespace CodeFlix\Auth;


use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class JWTProvider extends Authorization
{

    private $jwt;
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        //tipo do token
       return 'bearer';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        //retorna se o usuário está autenticado ou não
        try {
            return \Auth::guard('api')->authenticate();
        }catch(AuthenticationException $exception){
            //refresh token automatico
            $this->refreshToken();
            return \Auth::guard('api')->user();
        }

    }
    protected function refreshToken(){
        $token = $this->jwt->parseToken()->refresh();
        $this->jwt->setToken($token);
    }

}