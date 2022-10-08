<?php

namespace App\Http\Controllers\Traits\react_crud;

use App\Libraries\ApiResponses;
use App\Models\react_crud\Employees;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

trait react_crud_apis
{
    public function allEmployees($request)
    {
        $allEmployeeData = Employees::where('status', 1)->get()->toArray();
        return ApiResponses::successResponse('Data found!', HTTPResponse::HTTP_OK, $allEmployeeData);
    }

    public function addEmployee($request)
    {
        if (empty($request->name)) {
            return ApiResponses::errorResponse('Employee name cannot be empty!');
        }
        if (empty($request->age)) {
            return ApiResponses::errorResponse('Employee age cannot be empty!');
        }

        try {
            Employees::create([
                'name' => $request->name,
                'age' => $request->age
            ]);
            return ApiResponses::successResponse('Employee stored successfully!');
        } catch (\Exception $e) {
            #dd($e->getMessage(),$e->getFile(), $e->getLine());
            return ApiResponses::errorResponse('Employee cannot be stored!', HTTPResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateEmployee($request)
    {
        if (empty($request->id)) {
            return ApiResponses::errorResponse('Employee id cannot be empty!');
        }
        if (empty($request->name)) {
            return ApiResponses::errorResponse('Employee name cannot be empty!');
        }
        if (empty($request->age)) {
            return ApiResponses::errorResponse('Employee age cannot be empty!');
        }

        try {
            $employeeData = Employees::find($request->id);
            if (empty($employeeData)) {
                return ApiResponses::errorResponse('Invalid employee!');
            }
            $employeeData->update([
                'name' => $request->name,
                'age' => $request->age
            ]);
            return ApiResponses::successResponse('Employee updated successfully!');
        } catch (\Exception $e) {
            #dd($e->getMessage(),$e->getFile(), $e->getLine());
            return ApiResponses::errorResponse('Employee cannot be updated!', HTTPResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteEmployee($request)
    {
        if (empty($request->id)) {
            return ApiResponses::errorResponse('Employee id cannot be empty!');
        }

        try {
            $employeeData = Employees::find($request->id);
            if (empty($employeeData)) {
                return ApiResponses::errorResponse('Invalid employee!');
            }
            // set employee status -1 as Deleted employee
            $employeeData->update([
                'status' => -1,
            ]);
            return ApiResponses::successResponse('Employee deleted successfully!');
        } catch (\Exception $e) {
            #dd($e->getMessage(),$e->getFile(), $e->getLine());
            return ApiResponses::errorResponse('Employee cannot be deleted!', HTTPResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
