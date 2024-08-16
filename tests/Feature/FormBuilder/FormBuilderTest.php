<?php

namespace Tests\Feature\FormBuilder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FormBuilder;

class FormBuilderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_that_all_forms_can_be_fetched(): void
    {
        FormBuilder::factory(3)->create();
        $this->actingAsAuthenticatedTestUser();
        $response = $this->getJson('/api/forms/');
        //dd($response);
        $this->assertEquals(3, count($response["data"]));
        $response->assertJsonStructure([
            "status",
            "data" => [
                "*" => [
                    "id",
                    "name",
                    "json_form",
                    "process_flow_id",
                ],
            ]
        ]);

        $response->assertStatus(200);
    }
}
