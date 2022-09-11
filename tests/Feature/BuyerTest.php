<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyerTest extends TestCase
{
    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/buyer');

        $response->assertStatus(200);
    }
}
