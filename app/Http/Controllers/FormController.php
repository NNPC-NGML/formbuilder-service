<?php

namespace App\Http\Controllers;

use App\Jobs\FormBuilder\FormBuilderCreated;
use App\Services\FormService;
use Illuminate\Http\Request;

use App\Http\Resources\FormResource;

/**
 * @OA\Info(
 *     title="Formbuilder Service ",
 *     version="0.1"
 * )
 */
class FormController extends Controller
{

    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * @OA\Post(
     *     path="/forms",
     *     tags={"Forms"},
     *     summary="Create a new form",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "json_form"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Annual Survey"
     *             ),
     *             @OA\Property(
     *                 property="json_form",
     *                 type="string",
     *                 example="{'field1': 'value1', 'field2': 'value2'}"
     *             ),
     *             @OA\Property(
     *                 property="active",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="field_structure",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="fieldId",
     *                         type="string",
     *                         example="unique_field_id"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="username"
     *                     ),
     *                     @OA\Property(
     *                         property="label",
     *                         type="string",
     *                         example="Username"
     *                     ),
     *                     @OA\Property(
     *                         property="inputType",
     *                         type="string",
     *                         example="text"
     *                     ),
     *                     @OA\Property(
     *                         property="required",
     *                         type="boolean",
     *                         example=true
     *                     ),
     *                     @OA\Property(
     *                         property="placeholder",
     *                         type="string",
     *                         example="Enter your username"
     *                     ),
     *                     @OA\Property(
     *                         property="selectable",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(
     *                                 property="optionId",
     *                                 type="string",
     *                                 example="option1"
     *                             ),
     *                             @OA\Property(
     *                                 property="label",
     *                                 type="string",
     *                                 example="Option 1"
     *                             ),
     *                             @OA\Property(
     *                                 property="value",
     *                                 type="string",
     *                                 example="1"
     *                             ),
     *                             @OA\Property(
     *                                 property="selected",
     *                                 type="boolean",
     *                                 example=false
     *                             )
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="range",
     *                         type="object",
     *                         @OA\Property(
     *                             property="min",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="max",
     *                             type="integer",
     *                             example=10
     *                         ),
     *                         @OA\Property(
     *                             property="step",
     *                             type="integer",
     *                             example=1
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="A newly created form",
     *         @OA\JsonContent(ref="#/components/schemas/Form")
     *     )
     * )
     */

    public function create(Request $request)
    {
        $form = $this->formService->createForm($request->all());
        FormBuilderCreated::dispatch($form->toArray());
        return response()->json($form, 201);
    }


      /**
     * @OA\Get(
     *     path="/api/forms/{id}",
     *     tags={"Forms"},
     *     summary="Retrieve a form by ID",
     *     description="Returns a single form.",
     *     operationId="getForm",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the form to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Form")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Form not found"
     *     )
     * )
     */
     public function show($id)
    {
        $form = $this->formService->getForm($id);

        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        return new FormResource($form);
    }
}
