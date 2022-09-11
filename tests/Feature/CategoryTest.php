<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testEndpointReturnsSuccess()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
    }
}
