<?php

namespace Tests\Unit\Queue;

use App\Jobs\CustomerTaskBroadcasterJob;
use App\Service\CustomerService;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerQueueTest extends TestCase
{
   use RefreshDatabase;

    private CustomerService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(CustomerService::class);
    }

    public function test_it_handles_custome_job_correctly(): void
    {
        Queue::fake();

        $data = [
            "name" => "Berry Alem",
            //TODO:: Update other relevant fields when customer flow is fully figured
        ];

        CustomerTaskBroadcasterJob::dispatch($data);

        Queue::assertPushed(CustomerTaskBroadcasterJob::class, function ($job) use ($data) {
            return $job->getData() == $data;
        });
    }
}
