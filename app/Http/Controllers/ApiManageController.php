<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RequestManager;
use App\Libraries\ApiResponses;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ApiManageController extends Controller
{
    use RequestManager;

    public function apiRequest(Request $request)
    {
        try {
            $tokenAccess = TokenService::checkTokenValidity($request->header('ApiAuthorization'));
            if (!$tokenAccess['status']) {
                return ApiResponses::errorResponse($tokenAccess['msg'], HTTPResponse::HTTP_UNAUTHORIZED);
            }
            $response = $this->handleRequest($request, $tokenAccess['privilege']);
            return response()->json($response);
        } catch (\Exception $e) {
            #dd($e->getMessage(),$e->getFile(), $e->getLine());
            return ApiResponses::errorResponse('Something went wrong!' . $e->getMessage(), $e->getFile(), $e->getLine(), HTTPResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
