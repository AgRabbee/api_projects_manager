<?php

namespace App\Services;

use \Firebase\JWT\JWT;

class TokenService
{
    private $user;
    private $pass;
    private $key;
    private $privilege;

    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->key = config('clients.key');
    }

    private function setAccess($client)
    {
        $clientListArr = config('clients.clientList');
        if (isset($clientListArr[$client])) {
            $this->user = $clientListArr[$client]['username'];
            $this->pass = $clientListArr[$client]['password'];
            $this->privilege = $clientListArr[$client]['privilege'];
        }
    }

    public function generateToken($username, $password, $client)
    {
        try {
            $this->setAccess($client);
            if ($this->user != $username || $this->pass != $password) {
                return null;
            }
            $token = [
                'username' => $username,
                'password' => $password,
                'clientid' => $client,
                'privilege' => $this->privilege,
                "exp" => time() + 60 * 60
            ];
            $jwt = JWT::encode($token, $this->key);

            $jwt_token['status'] = '200';
            $jwt_token['token_type'] = 'bearer';
            $jwt_token['expire_on'] = date("Y-m-d H:i:s", strtotime("+1 hour"));
            $jwt_token['token'] = $jwt;
            $jwt_token['msg'] = 'Successfully generated token';
            return $jwt_token;
        } catch (\Exception $e) {
            #dd($e->getMessage(),$e->getFile(), $e->getLine());
            return null;
        }
    }


    public static function checkTokenValidity($bearerToken)
    {
        try {
            if (!isset($bearerToken) || empty($bearerToken)) return false;
            if (strpos($bearerToken, 'bearer ') != 0) return false;
            $token = str_replace("bearer ", "", $bearerToken);
            $self = (new self);
            if (isset($token) && !empty($token)) {
                $user = JWT::decode($token, $self->key, ['HS256']);
                $self->setAccess($user->clientid);
                return ['status' => (($user->username == $self->user) && ($user->password == $self->pass)), 'privilege' => $user->privilege];
            }
            return ['status' => false, 'msg' => 'Invalid Token'];
        } catch (\Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

}
