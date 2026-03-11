<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_login()
    {
        // Preparacion
        $user = User::factory()->create([
            'password' => bcrypt('test123'),
        ]);

        // Ejecucion
        $response = $this->post('/api/v1/login', [
            'email' => $user->email,
            'password' => 'test123',
        ]);

        // Verificacion
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'user',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_it_cannot_login_with_invalid_credentials()
    {
        // Preparacion
        $user = User::factory()->create([
            'password' => bcrypt('test123'),
        ]);

        // Ejecucion
        $response = $this->post('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Verificacion
        $response->assertStatus(422);
        $this->assertGuest();
    }

    // public function test_it_can_logout()
    // {
    //     // Preparacion
    //     $user = User::factory()->create();

    //     // Ejecucion
    //     $response = $this->actingAs($user)->post('/api/v1/logout');

    //     // Verificacion
    //     $response->assertStatus(200);
    //     $this->assertGuest();
    // }

    // public function test_it_can_get_profile()
    // {
    //     // Preparacion
    //     $user = User::factory()->create();

    //     // Ejecucion
    //     $response = $this->actingAs($user)->get('/api/v1/profile');

    //     // Verificacion
    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'id' => $user->id,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //     ]);
    // }
}
