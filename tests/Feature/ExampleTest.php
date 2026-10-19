<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): void
    {
        $this->actingAs(User::create([
            'username' => 'admin',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make('password123'),
            'tipe_akun' => 'guru',
            'dibuat_pada' => now(),
        ]));
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->actingAsAdmin();
        $response = $this->get('/admin/industri');

        $response->assertStatus(200);
    }

    public function test_mapping_pembimbing_page_returns_successful_response(): void
    {
        $this->actingAsAdmin();
        $response = $this->get('/admin/mapping-pembimbing');

        $response->assertStatus(200);
    }
}
