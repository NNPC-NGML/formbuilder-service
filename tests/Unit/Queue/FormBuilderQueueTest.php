<?php

namespace Tests\Unit\Queue;

use App\Jobs\Formbuilder\FormDataCreated;
use App\Services\FormService;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormBuilderQueueTest extends TestCase
{
    use RefreshDatabase;

    private FormService $service;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->service = $this->app->make(FormService::class);
    // }

    // public function test_it_handles_form_data_creation_job_correctly(): void
    // {
    //     Queue::fake();

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
    //             ['user' => 1, 'role' => 'viewer']
    //         ]
    //     ];
    //     // $job = new FormDataCreated($formData);
    //     // $job->handle($this->service);

    //     // $this->assertDatabaseCount('form_builders', 1);
    //     // $this->assertDatabaseHas('form_builders', [
    //     //     'name' => $formData['name'],
    //     // ]);
    // }
}
