<?php

namespace Tests\Feature;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_post_valid_destination_retuns_success()
    {
        // Create new user
        $user = User::factory()->create();

        // Create new short link for this user
        $shortLink = ShortLink::factory()->state([
            "user_id" => $user->getKey()
        ])->create();

        // Get the destination
        $destination = $shortLink->destination;

        // send post request to the /api endpoing
        $response = $this->withHeaders([
            'Contnent-Type' => 'application/json',
        ])->post('/api', [
            "destination" => $destination
        ]);

        // it should asset status of 200
        $response->assertStatus(200);
    }

    public function test_post_with_null_destination_retuns_bad_request_status_code()
    {
        // send post request with empty destination to the /api endpoing
        $response = $this->withHeaders([
            'Contnent-Type' => 'application/json',
        ])->post('/api', [
            "destination" => ''
        ]);

        // it should asset status of 400
        $response->assertStatus(400);
    }

     public function test_post_with_invalid_or_non_exist_destination_retuns_not_found_status_code()
    {
        // send post request with invalid destination to the /api
        $response = $this->withHeaders([
            'Contnent-Type' => 'application/json',
        ])->post('/api', [
            "destination" => 'AAA'
        ]);

        // it should asset status of 404
        $response->assertStatus(404);
    }

     public function test_post_with_destination_retuns_the_correct_response_data() {

         // Create new user
        $user = User::factory()->create();

        // Create new short link for this user
        $shortLink = ShortLink::factory()->state([
            "user_id" => $user->getKey()
        ])->create();

        // Get the destination
        $destination = $shortLink->destination;

        // send post request to the /api endpoing
        $response = $this->withHeaders([
            'Contnent-Type' => 'application/json',
        ])->post('/api', [
            "destination" => $destination
        ]);

        // it should asset  that all the required props are returned from the call
        $response->assertStatus(200)->assertJson([
            "destination" => true,
            "slug" => true,
            "shortened_url" => true,
            "updated_at" => true,
            "created_at" => true
        ]);
    }
}
