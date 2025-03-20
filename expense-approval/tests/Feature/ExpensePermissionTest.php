<?php

namespace Tests\Feature;

use App\Enum\PlatformPermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Platform;
use App\Models\User;
use App\Models\Permission;

class ExpensePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Seed the permissions and users
        $this->seed(\Database\Seeders\ExpensePermissionSeeder::class);

    }

    /** @test */
    public function a_user_with_submit_permission_can_submit_expenses()
    {
        $submitter = User::where('name', 'Login')->first();
        $submitPermission = Permission::where('name', 'submit_expense')->first();
        $hasPermission = $submitter->platformPermissions->first();

        $this->assertEquals($submitPermission->name, $hasPermission->name);
        $this->assertTrue($submitter->hasGrantedGotPermission(Platform::class, PlatformPermissions::SUBMIT_EXPENSES->value), 'Login should have submit expense permission');
    }

    /** @test */
    public function a_user_without_submit_permission_cannot_submit_expenses()
    {
        $randomUser = User::factory()->create();

        $this->assertFalse($randomUser->hasGrantedGotPermission(Platform::class, PlatformPermissions::SUBMIT_EXPENSES->value), 'Login should not have submit expense permission');
    }

    /** @test */
    public function a_user_with_approve_permission_can_approve_expenses()
    {
        $approver = User::where('name', 'Admin Login')->first();

        $this->assertTrue($approver->hasGrantedGotPermission(Platform::class, PlatformPermissions::APPROVE_EXPENSES->value), 'Login should have approve expense permission');
    }

    /** @test */
    public function a_user_without_approve_permission_cannot_approve_expenses()
    {
        $randomUser = User::factory()->create();
        $approvePermission = Permission::where('name', 'approve_expense')->first();

        $this->assertFalse($randomUser->hasGrantedGotPermission(Platform::class, PlatformPermissions::APPROVE_EXPENSES->value), 'Login should not have approve expense permission');
    }

}
