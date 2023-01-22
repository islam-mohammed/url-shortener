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
}
