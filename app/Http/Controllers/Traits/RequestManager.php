<?php

namespace App\Http\Controllers\Traits;

use App\Libraries\ApiResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

trait RequestManager
{
    use react_crud\react_crud_apis;

    public function handleRequest(Request $request, $privilege)
    {
        $moduleType = $request->segment(1);
        $requestType = $request->segment(2);

        switch (true){
            /*react-crud project section starts*/
            case $moduleType == 'api' and $requestType == 'allEmployees':
                return $this->allEmployees($request);
                break;
            case $moduleType == 'api' and $requestType == 'add_employee':
                return $this->addEmployee($request);
                break;
            case $moduleType == 'api' and $requestType == 'update_employee':
                return $this->updateEmployee($request);
                break;
            case $moduleType == 'api' and $requestType == 'delete_employee':
                return $this->deleteEmployee($request);
                break;
            /*react-crud project section ends*/



            default:
                return ApiResponses::errorResponse('Sorry! Wrong Path', HTTPResponse::HTTP_NOT_FOUND);
                break;
        }
    }
}
