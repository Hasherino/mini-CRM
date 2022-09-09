<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyControllerTest extends TestCase
{
    private function getToken() {
        $user = User::where('email', Config::get('api.apiEmail'))->first();
        return JWTAuth::fromUser($user);
    }

    public function testIndexReturnsDataInValidFormat() {
        $baseUrl = Config::get('app.url').'/api/companies?token='.$this->getToken();
        
        $this->json('get', $baseUrl)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'logo',
                            'website',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            );
    }

    public function testShowReturnsDataInValidFormat() {
        
        $baseUrl = Config::get('app.url').'/api/companies/1?token='.$this->getToken();
        
        $this->json('get', $baseUrl)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'email',
                    'logo',
                    'website',
                    'created_at',
                    'updated_at'
                ]
            );
    }

    public function testCreateReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/companies?name=Foo&email=foo@bar.com&website=web.com&token='.$this->getToken();
        
        $this->json('post', $baseUrl)
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Company added successfully'
            ], 201);
    }

    public function testUpdateReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/companies/1?name=Foo&email=foo@bar.com&website=web.com&token='.$this->getToken();
        
        $this->json('put', $baseUrl)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Company updated successfully'
            ], 200);
    }

    public function testDeleteReturnsValidResponse() {
        $baseUrl = Config::get('app.url').'/api/companies/1?token='.$this->getToken();
        
        $this->json('delete', $baseUrl)
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Company still has employees.'
            ], 400);
    }
}
