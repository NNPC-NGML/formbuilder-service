<?php

namespace Tests\Unit;

use App\Models\FormData;
use App\Models\Form;
use App\Services\FormService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormDataServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $formService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formService = new FormService();
    }

    public function testCreateFormData()
    {

        $form = Form::create([
            'name' => 'Sample Form',
            'json_form' => '{}',
            'active' => true
        ]);

        $formData = [
            'form_builder_id' => $form->id,
            'form_field_answers' => json_encode([
                ['fieldId' => '1', 'fieldKey' => 'age', 'response' => '30', 'question' => 'Your Age?']
            ])
        ];

        $createdFormData = $this->formService->createFormData($formData);

        $this->assertInstanceOf(FormData::class, $createdFormData);
        $this->assertEquals($form->id, $createdFormData->form_builder_id);
        $this->assertDatabaseHas('form_data', [
            'id' => $createdFormData->id,
        ]);
    }
}
