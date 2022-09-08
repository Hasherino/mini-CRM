<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company_id'
    ];

    public static function createEmployee($request) {
        $data = $request->only('first_name', 'last_name', 'company_id');
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        Employee::create($request->all())->save();
    }

    public static function updateEmployee($request, $id) {
        $data = $request->only('first_name', 'last_name', 'company_id');
        $validator = Validator::make($data, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'company_id' => 'integer|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $employee = Employee::findOrFail($id);
        $employee->fill($request->all())->save();
    }

    public static function deleteEmployee($id) {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
