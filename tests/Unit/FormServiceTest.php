<?php

namespace Tests\Unit;

use App\Models\FormBuilder;
use App\Services\FormService;
use Database\Factories\FormBuilderFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $formService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formService = new FormService();
    }

    public function testCreateFormSuccess()
    {

        $formData = [
            'name' => 'Test Form',
            'json_form' => '{"field1": "value1"}',
            'field_structure' => [
                [
                    'fieldId' => 'field1',
                    'name' => 'Field 1',
                    'label' => 'Field One',
                    'inputType' => 'text',
                    'required' => true,
                    'placeholder' => 'Enter Field 1'
                ]
            ],
            'access_control' => [
                ['user' => 1, 'role' => 'editor'],
                ['user' => 2, 'role' => 'viewer']
            ]
        ];

        $form = $this->formService->createForm($formData);

        $this->assertDatabaseHas('forms', [
            'name' => $form->name
        ]);

        $this->assertInstanceOf(FormBuilder::class, $form);
        $this->assertEquals('Test Form', $form->name);
    }

    public function testCreateFormValidationFailure()
    {
        $formData = [
            'json_form' => '{"field1": "value1"}'
        ];

        $this->expectException(\Exception::class);

        $this->formService->createForm($formData);
    }

    public function testCreateFormWithUnexpectedData()
    {
        $formData = [
            'name' => 'Test Form',
            'json_form' => '{"field1": "value1"}',
            'extra_field' => 'Unexpected Data'
        ];

        $form = $this->formService->createForm($formData);

        $this->assertDatabaseHas('forms', [
            'name' => 'Test Form'
        ]);

        $this->assertDatabaseMissing('forms', [
            'extra_field' => 'Unexpected Data'
        ]);
    }

    public function testGetFormById()
    {
        $form_builder = FormBuilderFactory::factory()->create();


        $response = $this->get(route('forms.show', ['id' => $form_builder->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $form_builder->id,
            'name' => $form_builder->name
        ]);
    }

    public function testFormNotFound()
    {
        $nonExistentForId = mt_rand(1000000000, 9999999999);

        $response = $this->get(route('forms.show', ['id' => $nonExistentForId]));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Form not found']);
    }
}
