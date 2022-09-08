<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
    ];

    public static function createCompany($request) {
        $data = $request->only('name', 'email', 'logo', 'website');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|unique:companies|max:255',
            'logo' => 'string|max:255',
            'website' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        Company::create($request->all())->save();
    }

    public static function updateCompany($request, $id) {
        $data = $request->only('name', 'email', 'logo', 'website');
        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'email' => 'string|email|unique:companies|max:255',
            'logo' => 'string|max:255',
            'website' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $company = Company::findOrFail($id);
        $company->fill($request->all())->save();
    }

    public static function deleteCompany($id) {
        $company = Company::findOrFail($id);

        if(!$company->employees()->get()->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Company still has employees.'
            ], 400);
        }

        $company->delete();
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
