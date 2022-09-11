<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/transaction');

        $response->assertStatus(200);
    }
}
