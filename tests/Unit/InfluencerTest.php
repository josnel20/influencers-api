<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Influencer;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InfluencerTest extends TestCase
{
    use RefreshDatabase;

    // Teste de cadastro do usuário
    public function testUserRegistration()
    {
        $response = $this->postJson('/api/v1/cadastrar', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'senha@123',
            'password_confirmation' => 'senha@123',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }
}
