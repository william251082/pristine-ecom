<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerTest extends TestCase
{
    public function testUserEndpointReturnsSuccess()
    {
        $response = $this->get('/api/seller');

        $response->assertStatus(200);
    }
}
