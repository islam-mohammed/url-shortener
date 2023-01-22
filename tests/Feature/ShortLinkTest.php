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
        $slug = Str::random(5);
        $user = User::factory()->create();
        $url= ShortLink::factory()->state([
            'slug' => $slug,
            'user_id' => $user->getKey(),
        ])->create();

        $expectedUrl = url('') . '/' . $slug;

        $this->assertSame($expectedUrl, $url->shortLink);
    }
}
