<?php

namespace Tests\Unit\Queue;

use App\Jobs\AutomatorTaskBroadcasterJob;
use App\Service\AutomatorTaskService;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutomatorQueueTest extends TestCase
{
   use RefreshDatabase;

    private AutomatorTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(AutomatorTaskService::class);
    }

    public function test_it_handles_department_creation_job_correctly(): void
    {
        Queue::fake();

        $data = [
            "processflow_history_id" => 7,
            "formbuilder_data_id" => 1,
            "user_id" => 2,
            "processflow_id" => 4,
            "processflow_step_id" => 3,
            "task_status" => 1,
        ];

        $job = new AutomatorTaskBroadcasterJob($data);
        $job->handle();

        $this->assertDatabaseCount('automator_tasks', 1);
        $this->assertDatabaseHas('automator_tasks', [
            'processflow_history_id' => $data['processflow_history_id'],
        ]);
    }
}
