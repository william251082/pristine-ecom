<?php

namespace Tests\Feature;

use Tests\TestCase;

class BuyerTest extends TestCase
{
    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/buyer');

        $response->assertStatus(200);
    }
}
