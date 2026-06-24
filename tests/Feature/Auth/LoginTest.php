<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('Password1!'),
        ]);

        $this->post('/login', [
            'username' => 'testuser',
            'password' => 'Password1!',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create(['username' => 'testuser']);

        $this->post('/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_login_fails_with_nonexistent_user(): void
    {
        $this->post('/login', [
            'username' => 'ghost',
            'password' => 'Password1!',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_forgot_password_returns_generic_message(): void
    {
        $response = $this->post('/forgot-password', ['username' => 'nonexistent']);

        $response->assertSessionHas('success');
        $this->assertStringContainsString('Jika username terdaftar', session('success'));
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect();

        $this->assertGuest();
    }
}
