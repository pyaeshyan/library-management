<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\FrontendUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class BookControllerRTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_book_list()
    {

        $user = FrontendUser::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('12345678'),
            'phone' => '12345677',
            'address' => 'Address'
        ]);


        Sanctum::actingAs($user);

        $response = $this->getJson('/api/book-list');

        $response->assertStatus(200);
    }

    public function test_issue_book_list()
    {
        $user = FrontendUser::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('12345678'),
            'phone' => '12345677',
            'address' => 'Address'
        ]);


        Sanctum::actingAs($user);

        $response = $this->getJson('/api/issue-list');

        $response->assertStatus(200);
    }
}
