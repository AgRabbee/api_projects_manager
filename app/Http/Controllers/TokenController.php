<?php

namespace App\Http\Controllers;

use App\Libraries\ApiResponses;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class TokenController extends Controller
{
    public $token;
    public function __construct(TokenService $token)
    {
        $this->token = $token;
    }

    public function getToken(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $client = $request->client;

        try {
            if(empty($username) || empty($password) || empty($client) ){
                return ApiResponses::errorResponse('Credentials should be provided!',HTTPResponse::HTTP_UNAUTHORIZED);
            }
            $jwt_token = $this->token->generateToken($username, $password, $client);
            if(!$jwt_token){
                return ApiResponses::errorResponse('Invalid username or password!',HTTPResponse::HTTP_UNAUTHORIZED);
            }
            return response()->json($jwt_token);
        }
        catch (\Exception $e){
            return ApiResponses::errorResponse('Something went wrong!',HTTPResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
