<?php

namespace Tests\Unit\Queue;

use App\Jobs\ProcessFlowTaskBroadcasterJob;
use App\Service\ProcessFlowTaskService;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessFlowQueueTest extends TestCase
{
   use RefreshDatabase;

    private ProcessFlowTaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ProcessFlowTaskService::class);
    }

    public function test_it_handles_process_flow_creation_job_correctly(): void
    {
        Queue::fake();

        $data = [
            "name" => "Process Flow 1",
            "start_step_id" => 1,
            "frequency" => "daily",
            "frequency_for" => "users",
            "week" => "weekly",
            "day" => "thursday",
            "status" => true,
        ];

        ProcessFlowTaskBroadcasterJob::dispatch($data);

        Queue::assertPushed(ProcessFlowTaskBroadcasterJob::class, function ($job) use ($data) {
            return $job->getData() == $data;
        });
    }
}
