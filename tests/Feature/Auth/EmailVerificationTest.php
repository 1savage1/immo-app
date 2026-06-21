<?php

namespace Tests\Feature\Auth;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** 1 */
    public function test_guest_cannot_access_admin_pending(): void
    {
        $response = $this->get('/admin/properties/pending');

        $response->assertRedirect('/login');
    }

    /** 2 */
    public function test_non_admin_cannot_access_admin_pending(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/properties/pending');

        $response->assertStatus(403);
    }

    /** 3 */
    public function test_admin_can_access_admin_pending(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->is_admin = true;
        $admin->save();

        $response = $this->actingAs($admin)->get('/admin/properties/pending');

        $response->assertStatus(200);
    }

    /** 4 */
    public function test_admin_can_approve_property(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->is_admin = true;
        $admin->save();

        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Pending Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post('/admin/properties/' . $property->id . '/approve');

        $response->assertStatus(302);
        $this->assertEquals('approved', $property->fresh()->status);
    }

    /** 5 */
    public function test_admin_can_reject_property(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->is_admin = true;
        $admin->save();

        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Pending Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post('/admin/properties/' . $property->id . '/reject');

        $response->assertStatus(302);
        $this->assertEquals('rejected', $property->fresh()->status);
    }

    /** 6 */
    public function test_guest_cannot_approve_property(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Pending Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'pending',
        ]);

        $response = $this->post('/admin/properties/' . $property->id . '/approve');

        $response->assertRedirect('/login');
    }
}
