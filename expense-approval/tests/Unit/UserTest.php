<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase; // Ensures fresh database state for each test

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_creation()
    {
    // Arrange: Create a user
     User::factory()->create([
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    ]);

    // Act: Fetch user from database
    $fetchedUser = User::where('email', 'johndoe@example.com')->first();

    // Assert: Check user data
    $this->assertNotNull($fetchedUser);
    $this->assertEquals('John Doe', $fetchedUser->name);
    $this->assertEquals('johndoe@example.com', $fetchedUser->email);
    }
}
