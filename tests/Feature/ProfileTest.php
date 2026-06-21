<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** 1 */
    public function test_vente_page_displays_approved_properties(): void
    {
        $user = User::factory()->create();

        Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Villa for Sale',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->get('/vente');

        $response->assertStatus(200);
        $response->assertSee('Villa for Sale');
    }

    /** 2 */
    public function test_vente_page_empty_state(): void
    {
        $response = $this->get('/vente');

        $response->assertStatus(200);
        $response->assertSee('Aucun bien en vente pour le moment');
    }

    /** 3 */
    public function test_location_page_displays_approved_properties(): void
    {
        $user = User::factory()->create();

        Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'location',
            'category' => 'appartement',
            'title' => 'Apartment for Rent',
            'description' => 'Description.',
            'city' => 'Oran',
            'rooms' => 3,
            'area' => 100,
            'price' => 50000,
            'status' => 'approved',
        ]);

        $response = $this->get('/location');

        $response->assertStatus(200);
        $response->assertSee('Apartment for Rent');
    }

    /** 4 */
    public function test_location_page_empty_state(): void
    {
        $response = $this->get('/location');

        $response->assertStatus(200);
        $response->assertSee('Aucun bien en location pour le moment');
    }

    /** 5 */
    public function test_show_approved_property(): void
    {
        $user = User::factory()->create();

        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Approved Property',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'approved',
        ]);

        $response = $this->get('/properties/' . $property->id);

        $response->assertStatus(200);
        $response->assertSee('Approved Property');
    }

    /** 6 */
    public function test_show_pending_property_returns_404(): void
    {
        $user = User::factory()->create();

        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Pending Property',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
            'status' => 'pending',
        ]);

        $response = $this->get('/properties/' . $property->id);

        $response->assertStatus(404);
    }

    /** 7 */
    public function test_guest_cannot_access_create_page(): void
    {
        $response = $this->get('/properties/create');

        $response->assertRedirect('/login');
    }

    /** 8 */
    public function test_authenticated_user_can_access_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/properties/create');

        $response->assertStatus(200);
    }
}
