<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/admin/industri');

        $response->assertStatus(200);
    }

    public function test_mapping_pembimbing_page_returns_successful_response(): void
    {
        $response = $this->get('/admin/mapping-pembimbing');

        $response->assertStatus(200);
    }
}
