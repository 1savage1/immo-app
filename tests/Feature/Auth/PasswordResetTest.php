<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Booking;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** 1 */
    public function test_user_creation(): void
    {
        $user = User::factory()->create(['name' => 'User Created']);

        $this->assertDatabaseHas('users', ['name' => 'User Created']);
    }

    /** 2 */
    public function test_property_creation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $this->assertDatabaseHas('properties', ['title' => 'Property Title']);
    }

    /** 3 */
    public function test_property_image_creation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $image = new PropertyImage();
        $image->property_id = $property->id;
        $image->path = 'properties/test.png';
        $image->position = 1;
        $image->save();

        $this->assertDatabaseHas('property_images', ['path' => 'properties/test.png']);
    }

    /** 4 */
    public function test_booking_creation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $booking = new Booking();
        $booking->property_id = $property->id;
        $booking->user_id = $user->id;
        $booking->days = 7;
        $booking->start_date = '2026-06-01';
        $booking->end_date = '2026-06-08';
        $booking->save();

        $this->assertDatabaseHas('bookings', ['days' => 7]);
    }

    /** 5 */
    public function test_inquiry_creation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $inquiry = Inquiry::create([
            'property_id' => $property->id,
            'user_id' => $user->id,
            'type' => 'achat',
            'name' => 'Inquirer',
            'email' => 'inq@example.com',
        ]);

        $this->assertDatabaseHas('inquiries', ['name' => 'Inquirer']);
    }

    /** 6 */
    public function test_property_belongs_to_user_relation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $this->assertEquals($user->id, $property->user->id);
    }

    /** 7 */
    public function test_property_has_many_images_relation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $image = new PropertyImage();
        $image->property_id = $property->id;
        $image->path = 'properties/test.png';
        $image->position = 1;
        $image->save();

        $this->assertCount(1, $property->images);
    }

    /** 8 */
    public function test_property_has_many_bookings_relation(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner@example.com',
            'operation' => 'vente',
            'category' => 'villa',
            'title' => 'Property Title',
            'description' => 'Description.',
            'city' => 'Algiers',
            'rooms' => 5,
            'area' => 200,
            'price' => 20000000,
        ]);

        $booking = new Booking();
        $booking->property_id = $property->id;
        $booking->user_id = $user->id;
        $booking->days = 7;
        $booking->start_date = '2026-06-01';
        $booking->end_date = '2026-06-08';
        $booking->save();

        $this->assertCount(1, $property->bookings);
    }
}
