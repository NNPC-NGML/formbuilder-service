<?php

namespace App\Jobs\AutomatorTask;

// use App\Models\Designation;
use App\Models\FormBuilder;
use App\Services\FormService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Skillz\Nnpcreusable\Service\AutomatorTaskService;

class AutomatorTaskCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The data for creating the designation.
     *
     * @var array
     */
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
     *
     * @return void
     */
    public function handle(): void
    {
        // if "formbuilder_data_id" == null create a new form data and dispatch formdata created 
        $this->data["process_flow_step_id"] = $this->data["processflow_step_id"];
        $this->data["process_flow_history_id"] = $this->data["processflow_history_id"];
        $this->data["automator_task_id"] = $this->data["id"];

        unset($this->data["processflow_step_id"]);
        unset($this->data["id"]);

        if ($this->data["formbuilder_data_id"] == null) {
            $formBuilderId = FormBuilder::where(["process_flow_step_id" => $this->data["process_flow_step_id"]])->first();
            if ($formBuilderId) {
                $this->data["form_builder_id"] = $formBuilderId->id;
                $this->data["status"] = 0;
                $createFormData = $this->formService()->createFormData($this->data);
                if ($createFormData) {
                    $this->formService()->dispatchFormData("create", $createFormData->id);
                }
            }
        } else {
            $this->data["id"] = $this->data["formbuilder_data_id"];
            //get form data and update 
            $this->data["status"] = 1;
            $updateFormData = $this->formService()->updateFormData($this->data["id"], $this->data);
            if ($updateFormData) {
                $this->formService()->dispatchFormData("update", $this->data["id"]);
            }
        }

        //update if data_id already exists
        //automator task created
        // $service = new AutomatorTaskService();
        // $data = $this->data;
        // $service->create($data);
    }

    private function formService()
    {
        return new FormService();
    }
}
