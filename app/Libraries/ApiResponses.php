<?php

namespace App\Libraries;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApiResponses
{
    public static function successResponse($message, $statusCode = HttpResponse::HTTP_OK, $data = [], $errorCode = '', $responseType = '')
    {
        return [
            'responseTime' => Carbon::now()->timestamp,
            'responseType' => $responseType,
            'status' => $statusCode,
            'errorCode' => $errorCode,
            'response' => 'error',
            'msg' => $message,
            'data' => $data,
        ];
    }

    public static function errorResponse($message, $statusCode = HttpResponse::HTTP_BAD_REQUEST, $data = [], $errorCode = '', $responseType = '')
    {
        return [
            'responseTime' => Carbon::now()->timestamp,
            'responseType' => $responseType,
            'status' => $statusCode,
            'errorCode' => $errorCode,
            'response' => 'error',
            'msg' => $message,
            'data' => $data,
        ];
    }
}
