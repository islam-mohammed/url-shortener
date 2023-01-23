<?php

namespace Tests\Feature;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShortLinkTest extends TestCase
{
     public function test_short_link_accessor_is_valid() {

        $user = User::factory()->create();
        $url= ShortLink::factory()->state([
            'user_id' => $user->getKey(),
        ])->create();

        $slug = $url->slug;
        $this->assertNotNull($slug);

        $expectedUrl = url('') . '/' . $slug;

        $this->assertSame($expectedUrl, $url->shortLink);
    }

    public function test_short_links_page_is_displayed() {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user);
        $response = $this->get('/short');
        $response->assertStatus(200);
    }


    public function test_require_a_destination(): void {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('/short', [
            "destination" => "",
            "user_id" => $user->getKey()
        ]);
        $response->assertSessionHasErrors('destination');
    }

    public function test_require_a_valid_destination(): void {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('/short', [
            "destination" => "AAAA",
            "user_id" => $user->getKey()
        ]);
        $response->assertSessionHasErrors('destination');
    }
    public function test_require_a_user(): void {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('/short', [
            "destination" => "http://example.com",
            "user_id" => ''
        ]);
        $response->assertSessionHasErrors('user_id');
    }

    public function test_slug_is_generated_on_creating_a_new_short_link(): void {
        $user = User::factory()->create();
        $shortLink = ShortLink::factory()->state([
            "user_id" => $user->getKey()
        ])->create();

        $this->assertNotNull($shortLink->slug);
    }

    public function test_views_should_increment_by_one_when_the_short_link_is_visited(): void {
        // create new user
        $user = User::factory()->create();

        // create short link for the user
        $shortLink = ShortLink::factory()->state([
            "user_id" => $user->getKey()
        ])->create();

        // simulate visiting the short link
        $this->get($shortLink->shortLink);

        // pull the latest short link data from the database
        $shortLink->refresh();

        // assert that the number of views has been increased by 1
        $this->assertEquals($shortLink->views, 1);

    }
}
