<?php

namespace App\Jobs\FormBuilder;

use App\Services\FormService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FormDataCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the unit.
     *
     * @var array
     */
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param FormService $service
     * @return void
     */
    public function handle(): void
    {
         
         $service = new FormService();
         $service->createFormData($this->data);

    }

     public function getData(): array
    {
        return $this->data;
    }
}
