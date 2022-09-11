<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $postData = [
            "name" => ucwords("tewqwqwq"),
            "email" => "hia@hi.nl",
            "password" => "password",
            "password_confirmation" => "password",
            "verified" => "0",
            "admin" => "0"
        ];
        $response = $this->post('/api/user', $postData);
        unset($postData['password']);
        unset($postData['password_confirmation']);
        $expectedResponse = json_encode(["data" => $postData]);
        $responseContent = json_decode($response->getContent(), true);
        unset($responseContent['data']['id']);
        unset($responseContent['data']['updated_at']);
        unset($responseContent['data']['created_at']);

        self::assertEquals($expectedResponse, json_encode($responseContent));
        $response->assertStatus(201);
    }
}
