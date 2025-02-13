<?php

namespace App\Jobs\FormData;

use App\Models\FormData;
use App\Services\FormService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FormBuilderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The data for creating the designation
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $formDataValue = [
            'entity' => $this->data["entity"],
            'entity_id' => $this->data["entity_id"],
        ];
        if (isset($this->data["entity_site_id"])) {
            $formDataValue["entity_site_id"] = $this->data["entity_site_id"];
        }
        $updateFormData = $this->formService()->updateFormData($this->data["task_id"], $formDataValue);
        if ($updateFormData) {
            $model = FormData::where(["id" => $this->data["task_id"]])->with(["formBuilder.tag"])->first();
            $response = $model->toArray();
            FormDataCreated::dispatch($response)->onQueue("processflow_queue");
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function formService()
    {
        return new FormService();
    }
}
