<?php

namespace Tests\Unit;

use App\Models\Form;
use App\Services\FormService;
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
            ]
        ];

        $form = $this->formService->createForm($formData);

        $this->assertDatabaseHas('forms', [
            'name' => 'Test Form'
        ]);

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('Test Form', $form->name);
    }

    public function testCreateFormValidationFailure()
    {
        $formData = [
            // 'name' is required but missing
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
        $form = Form::create([
            'name' => 'Test Form',
            'json_form' => '{"field": "value"}',
            'field_structure' => json_encode(['field1' => 'value1']),
            'access_control' => [
                ['user' => 'user1', 'role' => 'editor'],
                ['user' => 'user2', 'role' => 'viewer']
            ]
        ]);

        $response = $this->get(route('forms.show', ['id' => $form->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $form->id,
            'name' => 'Test Form'
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
