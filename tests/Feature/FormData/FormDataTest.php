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

    public function test_that_form_data_can_be_submitted_by_a_user_when_form_has_process_flow_id()
    {
        // create a new form 
        $form = FormBuilder::factory()->create();
        $formDataData = [
            "form_id" => $form->id,

            //"data" => json_encode(["value" => "test"]),
        ];


        $jsonData = [
            [
                "id" => 1,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
            [
                "id" => 2,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
            [
                "id" => 3,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
        ];
        $data = [
            'form_builder_id' => $form->id,
            'form_field_answers' => json_encode($jsonData),
        ];
        $this->assertDatabaseCount("form_data", 0);
        $this->actingAsAuthenticatedTestUser();
        $response = $this->postJson('/api/form-data/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseCount("form_data", 1);
        $this->assertDatabaseHas("form_data", $data);

        // assert that the record was stored as a new data without any form of entity relationship
    }
    public function test_that_form_data_can_be_submitted_by_a_user_when_form_does_not_have_process_flow_id()
    {
        // create a new form 
        $form = FormBuilder::factory()->create(["process_flow_id" => 0]);
        $formDataData = [
            "form_builder_id" => $form->id,
        ];
        $formData = FormData::factory()->create($formDataData);

        $jsonData = [
            [
                "id" => 1,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
            [
                "id" => 2,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
            [
                "id" => 3,
                "text" => "name",
                "placeholder" => "enter name here",
                "key" => "customer_name_id", // what ever your db column name is for name 
                "value" => "emeka and suns", // the value you need to save in the db
                "type" => "text",
            ],
        ];
        $data = [
            'form_builder_id' => $form->id,
            'form_field_answers' => json_encode($jsonData),
            'data_id' => $formData->id,
        ];
        $this->actingAsAuthenticatedTestUser();
        $response = $this->postJson('/api/form-data/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseCount("form_data", 1);
        unset($data["data_id"]);
        $this->assertDatabaseHas("form_data", $data);

        // assert that the record was stored as a new data without any form of entity relationship
    }
}
