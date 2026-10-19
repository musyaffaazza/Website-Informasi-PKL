<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::create([
            'username' => 'admin',
            'email' => 'admin@example.test',
            'password_hash' => Hash::make('password123'),
            'tipe_akun' => 'guru',
            'dibuat_pada' => now(),
        ]);
    }

    public function test_guests_are_redirected_from_admin_and_wali_kelas_pages(): void
    {
        $this->get('/admin/jurusan')->assertRedirect(route('login'));
        $this->get('/admin/profile')->assertRedirect(route('login'));
        $this->get('/wali-kelas/daftar-murid')->assertRedirect(route('login'));
    }

    public function test_all_admin_pages_render_successfully(): void
    {
        $this->actingAs($this->createAdmin());

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
