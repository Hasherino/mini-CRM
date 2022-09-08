<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    function __construct()
    {
        JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return response(Company::paginate(10), 200);
    }

    public function show($id)
    {
        return response(Company::findOrFail($id), 200);
    }

    public function create(Request $request)
    {
        if (($error = Company::createCompany($request)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Company added successfully'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if (($error = Company::updateCompany($request, $id)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        if (($error = Company::deleteCompany($id)) instanceof Response) {
            return $error;
        }

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully'
        ], 200);
    }
}
