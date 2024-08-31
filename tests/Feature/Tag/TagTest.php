<?php

namespace Tests\Feature\Tag;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\FormData;
use App\Models\FormBuilder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that all tags can be returned 
     */
    public function test_that_all_tags_can_be_fetched()
    {
        // create a new form 
        Tag::factory(5)->create();
        $this->actingAsAuthenticatedTestUser();
        $response = $this->getJson('/api/tag');
        $response->assertStatus(200)->assertJsonStructure([
            "status",
            "data" => [
                "*" => [
                    "id",
                    "name",
                ]
            ]
        ]);
    }
}
