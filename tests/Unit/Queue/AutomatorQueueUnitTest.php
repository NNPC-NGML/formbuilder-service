<?php

namespace Tests\Unit\Queue;

use Tests\TestCase;
use App\Models\FormData;
use App\Models\FormBuilder;
use App\Services\FormService;
use App\Jobs\AutomatorTask\AutomatorTaskCreated;
use App\Jobs\AutomatorTask\AutomatorTaskUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutomatorQueueUnitTest extends TestCase
{
    use RefreshDatabase;
    public function test_automator_service_can_create_form_data()
    {

        FormBuilder::factory()->create(["process_flow_step_id" => 1]);
        $this->assertDatabaseCount("form_data", 0);
        $data = [
            "id" => 1,
            "title" => "abc",
            "route" => "abc.com",
            "processflow_history_id" => 1,
            "formbuilder_data_id" => null,
            "entity" => "customer",
            "entity_id" => 1,
            "entity_site_id" => 1,
            "user_id" => 1,
            "processflow_id" => 1,
            "processflow_step_id" => 1,
            "task_status" => 0,
        ];
        $job = new AutomatorTaskCreated($data);
        $job->handle();
        $this->assertDatabaseCount("form_data", 1);
    }
    public function test_automator_service_can_update_form_data()
    {

        $form = FormBuilder::factory()->create(["process_flow_step_id" => 1]);
        // create a new form data 
        $formDataData = [
            'form_builder_id' => $form->id,
            'form_field_answers' => json_encode([
                ['fieldId' => '1', 'fieldKey' => 'text', 'question' => 'What is your location?', 'response' => 'India'],
                ['fieldId' => '2', 'fieldKey' => 'text', 'question' => 'What is your age?', 'response' => '30']
            ]),
            'automator_task_id' => 1,
            'process_flow_history_id' => 1,
            'entity' => "user",
            'entity_id' => 1,
            'entity_site_id' => 1,
            'user_id' => 1,
            'status' => 1,
        ];
        $formData = FormData::factory()->create($formDataData);
        $this->assertDatabaseCount("form_data", 1);
        $data = [
            "id" => 1,
            "title" => "abc",
            "route" => "abc.com",
            "processflow_history_id" => 1,
            "formbuilder_data_id" => $formData->id,
            "entity" => "customer",
            "entity_id" => 1,
            "entity_site_id" => 1,
            "user_id" => 1,
            "processflow_id" => 1,
            "processflow_step_id" => 1,
            "task_status" => 0,
        ];
        $job = new AutomatorTaskCreated($data);
        $job->handle();
        $this->assertDatabaseCount("form_data", 1);
    }
    public function test_automator_service_can_create_form_data_from_update_job()
    {

        FormBuilder::factory()->create(["process_flow_step_id" => 1]);
        $this->assertDatabaseCount("form_data", 0);
        $data = [
            "id" => 1,
            "title" => "abc",
            "route" => "abc.com",
            "processflow_history_id" => 1,
            "formbuilder_data_id" => null,
            "entity" => "customer",
            "entity_id" => 1,
            "entity_site_id" => 1,
            "user_id" => 1,
            "processflow_id" => 1,
            "processflow_step_id" => 1,
            "task_status" => 0,
        ];
        $job = new AutomatorTaskUpdated($data);
        $job->handle();
        $this->assertDatabaseCount("form_data", 1);
    }
    public function test_automator_service_can_update_form_datafrom_update_job()
    {

        $form = FormBuilder::factory()->create(["process_flow_step_id" => 1]);
        // create a new form data 
        $formDataData = [
            'form_builder_id' => $form->id,
            'form_field_answers' => json_encode([
                ['fieldId' => '1', 'fieldKey' => 'text', 'question' => 'What is your location?', 'response' => 'India'],
                ['fieldId' => '2', 'fieldKey' => 'text', 'question' => 'What is your age?', 'response' => '30']
            ]),
            'automator_task_id' => 1,
            'process_flow_history_id' => 1,
            'entity' => "user",
            'entity_id' => 1,
            'entity_site_id' => 1,
            'user_id' => 1,
            'status' => 1,
        ];
        $formData = FormData::factory()->create($formDataData);
        $this->assertDatabaseCount("form_data", 1);
        $data = [
            "id" => 1,
            "title" => "abc",
            "route" => "abc.com",
            "processflow_history_id" => 1,
            "formbuilder_data_id" => $formData->id,
            "entity" => "customer",
            "entity_id" => 1,
            "entity_site_id" => 1,
            "user_id" => 1,
            "processflow_id" => 1,
            "processflow_step_id" => 1,
            "task_status" => 0,
        ];
        $job = new AutomatorTaskUpdated($data);
        $job->handle();
        $this->assertDatabaseCount("form_data", 1);
    }
}
