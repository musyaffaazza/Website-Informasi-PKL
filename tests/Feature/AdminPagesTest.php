<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_admin_pages_render_successfully(): void
    {
        $routes = [
            '/',
            '/admin',
            '/admin/jurusan',
            '/admin/rombel',
            '/admin/siswa',
            '/admin/guru',
            '/admin/industri',
            '/admin/mapping-pembimbing',
            '/admin/log-aktivitas',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(in_array($route, ['/', '/admin']) ? 302 : 200);
        }
    }
}