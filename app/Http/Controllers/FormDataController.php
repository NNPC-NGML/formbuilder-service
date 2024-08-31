<?php

namespace App\Http\Controllers;

use App\Models\FormData;
use Illuminate\Http\Request;
use App\Services\FormService;
use App\Jobs\FormData\FormDataCreated;
use App\Jobs\FormData\FormDataUpdated;


class FormDataController extends Controller
{

    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * @OA\Post(
     *     path="api/form-data/create",
     *     summary="Create or update form data",
     *     description="This endpoint is used to create new form data or update existing data based on the presence of a process flow ID in the form. If the form does not have a process flow ID, the data will be treated as an update, and a data_id is required.",
     *     operationId="storeFormData",
     *     tags={"Form Data"},
     *     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"form_builder_id", "form_field_answers"},
     *             @OA\Property(
     *                 property="form_builder_id",
     *                 type="integer",
     *                 description="ID of the form builder",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="form_field_answers",
     *                 type="array",
     *                 description="Array of form field answers",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="field_id", type="integer", example=1),
     *                     @OA\Property(property="answer", type="string", example="Sample answer")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="data_id",
     *                 type="integer",
     *                 description="ID of the data to update (required if the form does not have a process flow ID)",
     *                 example=1
     *             )
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Data has been saved and dispatched to the proper channel.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data has been saved and dispatched to the proper channel.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request or validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="data_id is required for this form to be sent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Something went wrong",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="something went wrong, please try again")
     *         )
     *     ),
     *     
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */

    public function store(Request $request)
    {
        // authenticated user
        $user = auth()->id();
        // if the form has a process flow id 
        $formId = $request->form_builder_id;
        $getForm = $this->formService->getForm($formId);
        //if the form does not have  a process_flow_id, then treat the data as a update 
        if ($getForm->process_flow_id < 1) {
            // check for the data id to be update, if the value does not exist 
            if (!isset($request->data_id) && $request->data_id < 1) {
                return response()->json([
                    "status" => "error",
                    "message" => "data_id is required for this form to be sent ",
                ], 400);
            }
            // update data with service updateFormData
            $updateForm = $this->formService->updateFormData($request->data_id, $request->all());
            if (!$updateForm) {
                return response()->json([
                    "status" => "error",
                    "message" => "something went wrong, please try again",
                ], 400);
            }
            $this->formService->dispatchFormData("update", $request->data_id);

            return response()->json([
                "status" => "success",
                "message" => "Data has being saved and dispatched to the proper channel.",
            ], 200);
        }
        // create a new form data since the form has a process_flow_id
        $request = $request->all();
        $request["user_id"] = $user;
        // create new data with service createFormData method
        $createFormData = $this->formService->createFormData($request);
        if ($createFormData) {
            $this->formService->dispatchFormData("create", $createFormData->id);
            return response()->json([
                "status" => "success",
                "message" => "Data has being saved and dispatched to the proper channel.",
            ], 200);
        }
        return response()->json([
            "status" => "error",
            "message" => "something went wrong, please try again",
        ], 400);
    }
}
