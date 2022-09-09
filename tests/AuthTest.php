<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class AuthTest extends TestCase
{
    public function testLogin()
    {
        $baseUrl = Config::get('app.url') . '/api/auth/login';
        $email = Config::get('api.apiEmail');
        $password = Config::get('api.apiPassword');

        $response = $this->json('POST', $baseUrl . '/', [
            'email' => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
