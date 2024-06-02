<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CustomerService
{

    /**
     * Create a new process flow.
     *
     * @param  array  $data
     * @return object
     */
    public function createCustomerJob(array $data): object
    {
        $validator = Validator::make($data, [
            "name" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        //TODO:: KEEP RECORD OF PROCESS
        return (object)array($data);
    }
}
