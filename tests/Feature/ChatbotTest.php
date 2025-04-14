<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Chatbot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_their_chatbots()
    {
        $user = User::factory()->create();
        $chatbot = Chatbot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/chatbots');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'status', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_user_can_create_chatbot()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/chatbots', [
                'name' => 'Test Chatbot'
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'status', 'created_at', 'updated_at']
            ]);

        $this->assertDatabaseHas('chatbots', [
            'name' => 'Test Chatbot',
            'user_id' => $user->id,
            'status' => 'inactive'
        ]);
    }

    public function test_user_cannot_access_other_users_chatbot_status()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $chatbot = Chatbot::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->getJson("/api/chatbots/{$chatbot->id}/status");

        $response->assertForbidden();
    }
} 