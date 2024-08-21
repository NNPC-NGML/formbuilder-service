<?php

namespace Tests\Feature\FormBuilder;

use Tests\TestCase;
use App\Models\FormData;
use App\Models\FormBuilder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function test_that_a_particular_forms_can_be_updated(): void
    {
        $form = FormBuilder::factory()->create();
        $this->actingAsAuthenticatedTestUser();
        $data = ["name" => "new updated name"];
        $response = $this->putJson('/api/forms/update/' . $form->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas("form_builders", $data);
        $response->assertJsonStructure([
            "status",
            "message"
        ]);
    }

    public function test_that_a_particular_forms_with_process_flow_id_can_be_viewed(): void
    {
        $form = FormBuilder::factory()->create();
        FormData::factory()->create(["form_builder_id" => $form->id]);
        $this->actingAsAuthenticatedTestUser();
        $response = $this->getJson('/api/forms/view/' . $form->id . "/customer/1");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status",
            "data" => [
                "id",
                "name",
                "json_form",
                "process_flow_id",
                "form_data",

            ]
        ]);
    }

    public function test_that_a_particular_forms_without_process_flow_id_can_be_viewed(): void
    {
        $form = FormBuilder::factory()->create(["process_flow_id" => 0]);
        FormData::factory()->create(["form_builder_id" => $form->id, "entity" => "customer", "entity_id" => 1, "user_id" => 1]);
        $this->actingAsAuthenticatedTestUser();
        $response = $this->getJson('/api/forms/view/' . $form->id . "/customer/1");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status",
            "data" => [
                "id",
                "name",
                "json_form",
                "process_flow_id",
                "form_data",
            ]
        ]);
    }
}
