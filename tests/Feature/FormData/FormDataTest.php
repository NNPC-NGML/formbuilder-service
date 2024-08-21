<?php

namespace Tests\Feature\FormBuilder;

use Tests\TestCase;
use App\Models\FormData;
use App\Models\FormBuilder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormDataTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_that_all_forms_can_be_fetched(): void
    // {
    //     FormBuilder::factory(3)->create();
    //     $this->actingAsAuthenticatedTestUser();
    //     $response = $this->getJson('/api/forms/');
    //     $this->assertEquals(3, count($response["data"]));
    //     $response->assertJsonStructure([
    //         "status",
    //         "data" => [
    //             "*" => [
    //                 "id",
    //                 "name",
    //                 "json_form",
    //                 "process_flow_id",
    //             ],
    //         ]
    //     ]);

    //     $response->assertStatus(200);
    // }

    // public function test_that_a_particular_forms_can_be_updated(): void
    // {
    //     $form = FormBuilder::factory()->create();
    //     $this->actingAsAuthenticatedTestUser();
    //     $data = ["name" => "new updated name"];
    //     $response = $this->putJson('/api/forms/update/' . $form->id, $data);
    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas("form_builders", $data);
    //     $response->assertJsonStructure([
    //         "status",
    //         "message"
    //     ]);
    // }

    // public function test_that_a_particular_forms_can_be_viewed(): void
    // {
    //     $form = FormBuilder::factory()->create();
    //     FormData::factory()->create(["form_builder_id" => $form->id]);
    //     $this->actingAsAuthenticatedTestUser();
    //     $response = $this->getJson('/api/forms/view/' . $form->id . "/user/1");
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         "status",
    //         "data" => [
    //             "id",
    //             "name",
    //             "json_form",
    //             "process_flow_id",
    //             "form_data"
    //         ]
    //     ]);
    // }

    // public function test_that_form_data_can_be_submitted_by_a_user_when_form_has_process_flow_id()
    // {
    //     // create a new form 
    //     $form = FormBuilder::factory()->create();
    //     $formDataData = [
    //         "form_id" => $form->id,
    //         "data" => json_encode(["value" => "test"]),
    //     ];
    //     $this->actingAsAuthenticatedTestUser();
    //     $response = $this->postJson('/api/form-data/create', $formDataData);
    //     $response->assertStatus(200);
    //     // assert thatthe record was stored as a new data without any form of entity relationship
    // }
}
