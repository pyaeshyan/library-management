<?php

namespace Tests\Feature;

use App\Models\FrontendUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_create_user_andlogin()
    {
        $user = FrontendUser::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('12345678'),
            'phone' => '12345677',
            'address' => 'Address'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => '12345678',
        ]);
        
        $response->assertStatus(200)
                    ->assertJsonStructure(['token']);
    }
}
