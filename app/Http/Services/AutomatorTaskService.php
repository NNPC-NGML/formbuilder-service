<?php
namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutomatorTaskService
{

    /**
     * Create a new process flow.
     *
     * @param  Request  $request
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
        //Save Task
        return (object)array(); //Temp. returning empty Obj
    }
}
