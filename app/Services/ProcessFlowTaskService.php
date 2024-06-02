<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ProcessFlowTaskService
{

    /**
     * Create a new process flow.
     *
     * @param  array  $data
     * @return object
     */
    public function createProcessFlow(array $data): object
    {
        $validator = Validator::make($data, [
            "name" => "required|string|max:255",
            "start_step_id" => "nullable|integer",
            "frequency" => "required|in:daily,weekly,hourly,monthly,yearly,none",
            "frequency_for" => "required|in:users,customers,suppliers,contractors,none",
            "week" => "nullable|string",
            "day" => "nullable|string",
            "status" => "sometimes|boolean",
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        //TODO:: KEEP RECORD OF PROCESS
        return (object)array($data);
    }
}
