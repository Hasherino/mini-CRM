<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployeeControllerTest extends TestCase
{
    private function getToken() {
        $user = User::where('email', Config::get('api.apiEmail'))->first();
        return JWTAuth::fromUser($user);
    }

    public function testIndexReturnsDataInValidFormat() {
        $baseUrl = Config::get('app.url').'/api/employees?token='.$this->getToken();
        
        $this->json('get', $baseUrl)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'first_name',
                            'last_name',
                            'company_id',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            );
    }

    public function testShowReturnsDataInValidFormat() {
        
        $baseUrl = Config::get('app.url').'/api/employees/1?token='.$this->getToken();
        
        $this->json('get', $baseUrl)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'id',
                    'first_name',
                    'last_name',
                    'company_id',
                    'created_at',
                    'updated_at'
                ]
            );
    }

    public function testCreateReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/employees?first_name=John&last_name=Doe&company_id=1&token='.$this->getToken();
        
        $this->json('post', $baseUrl)
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Employee added successfully'
            ], 201);
    }

    public function testUpdateReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/employees/1?first_name=John&last_name=Doe&company_id=1&token='.$this->getToken();
        
        $this->json('put', $baseUrl)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Employee updated successfully'
            ], 200);
    }

    public function testDeleteReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/employees/1?token='.$this->getToken();
        
        $this->json('delete', $baseUrl)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Employee deleted successfully'
            ], 200);
    }
}
