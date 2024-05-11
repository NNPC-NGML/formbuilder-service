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
            'active' => true,
            'fields' => [
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
}
