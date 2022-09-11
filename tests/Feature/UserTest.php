<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $postData = $this->getPostData();
        $response = $this->getResponse();
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

    public function testShow()
    {
        $response = $this->getResponse();
        $responseContent = json_decode($response->getContent(), true);
        $userId = $responseContent['data']['id'];
        $response = $this->get("/api/user/$userId");

        $response->assertStatus(200);
    }

    private function getResponse(): TestResponse
    {
        $postData = $this->getPostData();
        return $this->post('/api/user', $postData);
    }

    #[ArrayShape([
        "name" => "string",
        "email" => "string",
        "password" => "string",
        "password_confirmation" => "string",
        "verified" => "string",
        "admin" => "string"
    ])]
    private function getPostData(): array
    {
        return [
            "name" => ucwords("tewqwqwq"),
            "email" => "hia@hi.nl",
            "password" => "password",
            "password_confirmation" => "password",
            "verified" => "0",
            "admin" => "0"
        ];
    }
}
