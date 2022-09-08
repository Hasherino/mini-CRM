<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
            'logo' => 'mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=100',
            'website' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        if (!!$request->logo) {
            $image_path = $request->file('logo')->store('.', 'public');
            $request = new Request($request->all());
            $request->merge(['logo' => public_path().'\\storage\\'.ltrim($image_path, './')]);
        }

        $company = Company::create($request->all());
        $company->save();

        return $company;
    }

    public static function updateCompany($request, $id) {
        $data = $request->only('name', 'email', 'logo', 'website');
        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'email' => 'string|email|unique:companies|max:255',
            'logo' => 'mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=100',
            'website' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $company = Company::findOrFail($id);

        if (!!$request->logo) {
            if(file_exists($company->logo)) {
                unlink($company->logo);
            }

            $image_path = $request->file('logo')->store('.', 'public');
            $request = new Request($request->all());
            $request->merge(['logo' => public_path().'\\storage\\'.ltrim($image_path, './')]);
        }

        

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
