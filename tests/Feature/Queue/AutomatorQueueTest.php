<?php

namespace Tests\Unit\Queue;

use App\Jobs\Automator\AutomatorTaskBroadcasterJob;
use App\Services\AutomatorTaskService;
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

    public function test_it_handles_automator_creation_job_correctly(): void
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

        AutomatorTaskBroadcasterJob::dispatch($data);

        Queue::assertPushed(AutomatorTaskBroadcasterJob::class, function ($job) use ($data) {
            return $job->getData() == $data;
        });
    }
}
