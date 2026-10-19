<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_access_kaprog_panel(): void
    {
        $this->actingAs($this->createUser('admin'));

        $this->get('/kaprog')->assertForbidden();
    }

    public function test_wali_kelas_cannot_access_kaprog_panel(): void
    {
        $this->actingAs($this->createGuruUser('wali-kelas', ['Wali Kelas']));

        $this->get('/kaprog')->assertForbidden();
    }

    public function test_kaprog_can_access_kaprog_panel(): void
    {
        $this->actingAs($this->createGuruUser('kaprog', ['Kaprog']));

        $this->get('/kaprog')->assertRedirect(route('kaprog.murid-pkl.index'));
    }

    public function test_admin_cannot_access_wali_kelas_panel(): void
    {
        $this->actingAs($this->createUser('admin'));

        $this->get('/wali-kelas')->assertForbidden();
    }

    public function test_kaprog_cannot_access_wali_kelas_panel(): void
    {
        $this->actingAs($this->createGuruUser('kaprog', ['Kaprog']));

        $this->get('/wali-kelas')->assertForbidden();
    }

    public function test_wali_kelas_can_access_wali_kelas_panel(): void
    {
        $this->actingAs($this->createGuruUser('wali-kelas', ['Wali Kelas']));

        $this->get('/wali-kelas')->assertRedirect(route('wali-kelas.murid.index'));
    }

    private function createUser(string $username): User
    {
        return User::create([
            'username' => $username,
            'email' => $username . '@example.test',
            'password_hash' => Hash::make('password123'),
            'tipe_akun' => 'guru',
            'dibuat_pada' => now(),
        ]);
    }

    private function createGuruUser(string $username, array $roles): User
    {
        $user = $this->createUser($username);

        Guru::create([
            'user_id' => $user->id,
            'nip' => 'NIP-' . $username,
            'nama' => ucwords(str_replace('-', ' ', $username)),
            'roles_list' => $roles,
        ]);

        return $user->fresh();
    }
}
