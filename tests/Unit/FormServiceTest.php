<?php

namespace Tests\Unit;

use App\Models\FormBuilder;
use App\Models\FormData;
use App\Services\FormService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;


class FormServiceTest extends TestCase
{
    use RefreshDatabase;


    protected $formService;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->formService = new FormService();
    // }



    // public function testCreateFormSuccess()
    // {

    //     $formData = [
    //         'name' => 'Test Form',
    //         'json_form' => '{"field1": "value1"}',
    //         'field_structure' => [
    //             [
    //                 'fieldId' => 'field1',
    //                 'name' => 'Field 1',
    //                 'label' => 'Field One',
    //                 'inputType' => 'text',
    //                 'required' => true,
    //                 'placeholder' => 'Enter Field 1'
    //             ]
    //         ],
    //         'access_control' => [
    //             ['user' => 1, 'role' => 'editor'],
    //             ['user' => 2, 'role' => 'viewer']
    //         ]
    //     ];

    //     $form = $this->formService->createForm($formData);

    //     $this->assertDatabaseHas('form_builders', [
    //         'name' => $form->name
    //     ]);

    //     $this->assertInstanceOf(FormBuilder::class, $form);
    //     $this->assertEquals('Test Form', $form->name);
    // }

    // public function testCreateFormValidationFailure()
    // {
    //     $formData = [
    //         'json_form' => '{"field1": "value1"}'
    //     ];

    //     $this->expectException(\Exception::class);

    //     $this->formService->createForm($formData);
    // }

    // public function testCreateFormWithUnexpectedData()
    // {
    //     $formData = [
    //         'name' => 'Test Form',
    //         'json_form' => '{"field1": "value1"}',
    //         'extra_field' => 'Unexpected Data'
    //     ];

    //     $this->expectException(\Exception::class);
    //     $form = $this->formService->createForm($formData);

    //     $this->assertDatabaseMissing('form_builders', [
    //         'name' => $form->name
    //     ]);

    //     $this->assertDatabaseMissing('form_builders', [
    //         'extra_field' => 'Unexpected Data'
    //     ]);
    // }
    // //      Start of uncommented section
    // //public function testGetFormById()
    // //{

    // // $form_builder = FormBuilder::factory()->create();


    // //    $response = $this->get(route('forms.show', ['id' => $form_builder->id]));

    // //     $response = $this->getJson('/api/forms/' . $form_builder->id);

    // //     $response->assertStatus(200);
    // //     $response->assertJson([
    // //         'id' => $form_builder->id,
    // //         'name' => $form_builder->name
    // //     ]);
    // // }

    // // public function testFormNotFound()
    // // {
    // //     $nonExistentForId = mt_rand(1000000000, 9999999999);

    // //     $response = $this->get(route('forms.show', ['id' => $nonExistentForId]));

    // //     $response->assertStatus(404);
    // //     $response->assertJson(['message' => 'Form not found']);
    // // }

    // public function testGetFormReturnsForm()
    // {
    //     // Arrange
    //     $form = FormBuilder::factory()->create([
    //         'name' => 'Test Form',
    //         'json_form' => '{"field1": "value1"}',
    //         'field_structure' => [
    //             [
    //                 'fieldId' => 'field1',
    //                 'name' => 'Field 1',
    //                 'label' => 'Field One',
    //                 'inputType' => 'text',
    //                 'required' => true,
    //                 'placeholder' => 'Enter Field 1'
    //             ]
    //         ],
    //         'access_control' => [
    //             ['user' => 1, 'role' => 'editor'],
    //             ['user' => 2, 'role' => 'viewer']
    //         ]
    //     ]);


    //     // Act
    //     $result = $this->formService->getForm($form->id);

    //     // Assert
    //     $this->assertInstanceOf(FormBuilder::class, $result);
    //     $this->assertEquals($form->id, $result->id);
    //     $this->assertEquals('Test Form', $result->name);
    //     $this->assertEquals('{"field1": "value1"}', $result->json_form);
    //     $this->assertEquals($form->field_structure, $result->field_structure);
    //     $this->assertEquals($form->access_control, $result->access_control);
    // }


    // public function testGetFormNotFound()
    // {
    //     $nonExistentId = 999;


    //     $this->expectException(ModelNotFoundException::class);
    //     $this->expectExceptionMessage("FormBuilder with id $nonExistentId not found.");

    //     $this->formService->getForm($nonExistentId);
    // }

    // public function testCreateFormDataValidation()
    // {
    //     $formService = new FormService();

    //     $form = FormBuilder::factory()->create([
    //         'name' => 'Test Form Data',
    //         'json_form' => '{"field1": "value1"}',
    //         'field_structure' => [
    //             [
    //                 'fieldId' => 'field1',
    //                 'name' => 'Field 1',
    //                 'label' => 'Field One',
    //                 'inputType' => 'text',
    //                 'required' => true,
    //                 'placeholder' => 'Enter Field 1'
    //             ]
    //         ],
    //         'access_control' => [
    //             ['user' => 1, 'role' => 'editor'],
    //             ['user' => 2, 'role' => 'viewer']
    //         ]
    //     ]);

    //     $validData = [
    //         'form_builder_id' => $form->id,
    //         'form_field_answers' => [
    //             ['fieldId' => '1', 'fieldKey' => 'text', 'question' => 'What is your location?', 'response' => 'India'],
    //             ['fieldId' => '2', 'fieldKey' => 'text', 'question' => 'What is your age?', 'response' => '30']
    //         ],
    //         'submitted' => true,
    //         'automator_task_id' => 1
    //     ];

    //     $formData = $formService->createFormData($validData);
    //     $this->assertInstanceOf(FormData::class, $formData);
    // }

    // public function testCreateFormDataValidationFailure()
    // {
    //     $formService = new FormService();

    //     $form = FormBuilder::create([
    //         'name' => 'Test Form Data',
    //         'json_form' => '{"field1": "value1"}',
    //         'field_structure' => [
    //             [
    //                 'fieldId' => 'field1',
    //                 'name' => 'Field 1',
    //                 'label' => 'Field One',
    //                 'inputType' => 'text',
    //                 'required' => true,
    //                 'placeholder' => 'Enter Field 1'
    //             ]
    //         ],
    //         'access_control' => [
    //             ['user' => 1, 'role' => 'editor'],
    //             ['user' => 2, 'role' => 'viewer']
    //         ]
    //     ]);

    //     $invalidData = [
    //         'form_builder_id' => $form->id,
    //         'form_field_answers' => [
    //             ['fieldId' => '1', 'fieldKey' => 'text', 'question' => 'What is your location?', 'response' => 'India'],
    //             ['fieldId' => '2', 'fieldKey' => 'text', 'question' => 'What is your age?', 'response' => null] // Invalid response
    //         ],
    //         'submitted' => true
    //     ];

    //     $this->expectException(ValidationException::class);
    //     $formService->createFormData($invalidData);
    // }

    // public function testGetFormDataReturnsFormData()
    // {
    //     $form = FormBuilder::create([
    //         'name' => 'Test Form Data',
    //         'json_form' => '{"field1": "value1"}',
    //         'field_structure' => [
    //             [
    //                 'fieldId' => 'field1',
    //                 'name' => 'Field 1',
    //                 'label' => 'Field One',
    //                 'inputType' => 'text',
    //                 'required' => true,
    //                 'placeholder' => 'Enter Field 1'
    //             ]
    //         ],
    //         'access_control' => [
    //             ['user' => 1, 'role' => 'editor'],
    //             ['user' => 2, 'role' => 'viewer']
    //         ]
    //     ]);

    //     $fieldAnswers = [
    //         ['fieldId' => '1', 'fieldKey' => 'text', 'question' => 'What is your location?', 'response' => 'India'],
    //         ['fieldId' => '2', 'fieldKey' => 'text', 'question' => 'What is your age?', 'response' => '30']
    //     ];

    //     $formDataData = [
    //         'form_builder_id' => $form->id,
    //         'form_field_answers' => $fieldAnswers
    //     ];

    //     $formDataCreated = FormData::create($formDataData);

    //     $storedFormData = FormData::find($formDataCreated->id);
    //     $storedJson = $storedFormData->form_field_answers;

    //     $this->assertEquals(
    //         $fieldAnswers,
    //         $storedJson,
    //         'The JSON stored in the database does not match the expected value.'
    //     );

    //     $this->assertEquals(
    //         'What is your location?',
    //         $storedJson[0]['question'],
    //         'The question stored in the database does not match the expected value.'
    //     );

    //     $this->assertInstanceOf(FormData::class, $formDataCreated);
    //     $this->assertEquals($form->id, $formDataCreated->form_builder_id);

    //     $result = $this->formService->getFormData($formDataCreated->id);

    //     $this->assertInstanceOf(FormData::class, $result);
    //     $this->assertEquals($formDataCreated->id, $result->id);
    //     $this->assertEquals($form->id, $result->form_builder_id);
    // }

    // public function testGetFormDataNotFound()
    // {
    //     $nonExistentId = 999;

    //     $this->expectException(ModelNotFoundException::class);
    //     $this->expectExceptionMessage("FormData with id $nonExistentId not found.");

    //     $this->formService->getFormData($nonExistentId);
    // }

    public function test_a_user_can_fetch_all_forms()
    {
        $service = $this->formService();
        // create about 3 forms 
        FormBuilder::factory(3)->create();
        $allForms = $service->getAllForms();
        $this->assertEquals(3, $allForms->count());
        $this->assertInstanceOf(FormBuilder::class, $allForms[0]);
        $this->assertDatabaseCount("form_builders", $allForms->count());
    }

    public function test_that_a_particular_form_can_be_updated()
    {
        $service = $this->formService();

        $form = FormBuilder::factory()->create();
        $data = ["name" => "updated Name"];
        $updatedForm = $service->updateForm($form->id, $data);
        $this->assertTrue($updatedForm);
        $this->assertDatabaseHas("form_builders", $data);
    }

    public function test_that_wrong_id_is_provided_to_update_form()
    {
        $service = $this->formService();
        $data = ["name" => "updated Name"];
        $updatedForm = $service->updateForm(0, $data);
        $this->assertTrue(!$updatedForm);
        $this->assertDatabaseMissing("form_builders", $data);
    }

    private function formService()
    {
        return new FormService();
    }
}
