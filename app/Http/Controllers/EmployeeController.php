<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    function __construct()
    {
        JWTAuth::parseToken()->authenticate();
    }
    
    public function index()
    {
        return response(Employee::paginate(10), 200);
    }

    public function show($id)
    {
        return response(Employee::findOrFail($id), 200);
    }

    public function create(Request $request)
    {
        if (($error = Employee::createEmployee($request)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Employee added successfully'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (($error = Employee::updateEmployee($request, $id)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        if (($error = Employee::deleteEmployee($id)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}
