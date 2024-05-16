<?php
namespace App\Service;

use Illuminate\Support\Facades\Validator;

class AutomatorTaskService
{

    /**
     * Create a new automator flow.
     *
     * @param  array  $data
     * @return object
     */
    public function createAutomatorFlow(array $data): object
    {
        // Validate the request data
        $validator = Validator::make($data, [
            "processflow_history_id" => "sometimes|nullable|integer",
            "formbuilder_data_id" => "sometimes|nullable|integer",
            "user_id" => "sometimes|nullable|integer",
            "processflow_id" => "sometimes|nullable|integer",
            "processflow_step_id" => "sometimes|nullable|integer",
            "task_status" => "sometimes|nullable|integer",
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        //TODO:: KEEP RECORD OF Task
        return (object)array($data);
    }
}
