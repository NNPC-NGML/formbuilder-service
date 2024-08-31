<?php

namespace App\Http\Controllers;

use App\Services\TagService;



class FormDataController extends Controller
{

    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
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

    public function index()
    {
    }
}
