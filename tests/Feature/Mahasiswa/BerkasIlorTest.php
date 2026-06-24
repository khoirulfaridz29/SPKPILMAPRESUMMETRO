<?php

namespace Tests\Feature\Mahasiswa;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerkasIlorTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_berkas(): void
    {
        $this->get('/mahasiswa/berkas')->assertRedirect('/login');
    }

    public function test_non_mahasiswa_cannot_access_berkas(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/mahasiswa/berkas')
            ->assertForbidden();
    }

    public function test_mahasiswa_upload_rejects_invalid_berkas_name(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $this->actingAs($user)->post('/mahasiswa/berkas', [
            'nama_berkas' => '../../../etc/passwd',
        ])->assertSessionHasErrors('nama_berkas');
    }

    public function test_berkas_lihat_requires_authentication(): void
    {
        $this->get('/mahasiswa/berkas/1/lihat')->assertRedirect('/login');
    }
}
