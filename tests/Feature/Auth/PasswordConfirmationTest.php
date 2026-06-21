<?php

namespace Tests\Feature\Auth;

use App\Models\Property;
use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /** 1 */
    public function test_guest_cannot_submit_inquiry(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->post('/properties/' . $property->id . '/inquiries', [
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);

        $response->assertRedirect('/login');
    }

    /** 2 */
    public function test_user_can_submit_inquiry_for_approved_property(): void
    {
        $owner = User::factory()->create();
        $inquirer = User::factory()->create();

        $property = Property::create([
            'user_id' => $owner->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($inquirer)->post('/properties/' . $property->id . '/inquiries', [
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('inquiries', [
            'property_id' => $property->id,
            'user_id' => $inquirer->id,
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);
    }

    /** 3 */
    public function test_inquiry_for_pending_property_returns_404(): void
    {
        $owner = User::factory()->create();
        $inquirer = User::factory()->create();

        $property = Property::create([
            'user_id' => $owner->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Pending Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($inquirer)->post('/properties/' . $property->id . '/inquiries', [
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);

        $response->assertStatus(404);
    }

    /** 4 */
    public function test_inquiry_validation_errors(): void
    {
        $owner = User::factory()->create();
        $inquirer = User::factory()->create();

        $property = Property::create([
            'user_id' => $owner->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($inquirer)->post('/properties/' . $property->id . '/inquiries', []);

        $response->assertSessionHasErrors(['type', 'name', 'email']);
    }

    /** 5 */
    public function test_inquiry_type_validation(): void
    {
        $owner = User::factory()->create();
        $inquirer = User::factory()->create();

        $property = Property::create([
            'user_id' => $owner->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($inquirer)->post('/properties/' . $property->id . '/inquiries', [
            'type' => 'invalid_type',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);

        $response->assertSessionHasErrors(['type']);
    }

    /** 6 */
    public function test_inquiry_requires_email(): void
    {
        $owner = User::factory()->create();
        $inquirer = User::factory()->create();

        $property = Property::create([
            'user_id' => $owner->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Villa',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($inquirer)->post('/properties/' . $property->id . '/inquiries', [
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
