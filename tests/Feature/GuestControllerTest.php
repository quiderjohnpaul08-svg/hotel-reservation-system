<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_payload_creates_guest_with_phone(): void
    {
        $response = $this->post(route('guests.store'), [
            'first_name' => 'Ritchie',
            'last_name' => 'Coscos',
            'email' => 'ritchie@example.com',
            'phone' => '09123456789',
            'address' => 'Tubigon',
        ]);

        $response
            ->assertRedirect(route('guests.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('guests', [
            'first_name' => 'Ritchie',
            'last_name' => 'Coscos',
            'email' => 'ritchie@example.com',
            'phone' => '09123456789',
            'address' => 'Tubigon',
        ]);
    }
}
