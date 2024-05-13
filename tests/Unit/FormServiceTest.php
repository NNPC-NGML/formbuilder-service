<?php

namespace Tests\Unit;

use App\Models\FormBuilder;
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
            ],
            'access_control' => [
                ['user' => 'user1', 'role' => 'editor'],
                ['user' => 'user2', 'role' => 'viewer']
            ]
        ];

        $form = $this->formService->createForm($formData);

        $this->assertDatabaseHas('forms', [
            'name' => 'Test Form'
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

        $this->assertInstanceOf(FormBuilder::class, $form);


        $this->assertDatabaseHas('forms', [
            'name' => $formData['name']
        ]);

        $this->assertDatabaseMissing('forms', [
            'extra_field' => 'Unexpected Data'
        ]);
    }
    public function testGetFormReturnsFormWhenExists()
    {
        $formBuilder = FormBuilder::create([
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
                ['user' => 'user1', 'role' => 'editor'],
                ['user' => 'user2', 'role' => 'viewer']
            ]
        ]);

        $result = $this->formService->getForm($formBuilder->id);

        $this->assertNotNull($result);
        $this->assertInstanceOf(FormBuilder::class, $result);
        $this->assertEquals($formBuilder->id, $result->id);
    }

    public function testGetFormReturnsNullWhenNoFormExists()
    {
        $nonExistentForId = mt_rand(1000000000, 9999999999);

        $result = $this->formService->getForm($nonExistentForId);

        $this->assertNull($result);
    }
}
