<?php

namespace App\Http\Controllers;

use Skillz\UserService;
use Illuminate\Http\Request;
use App\Services\FormService;

use App\Http\Resources\FormResource;
use App\Jobs\FormBuilder\FormBuilderCreated;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{

    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }


    /**
     * @OA\Get(
     *     path="/api/forms",
     *     summary="Get all forms",
     *     description="Retrieves a list of all available forms",
     *     tags={"Forms"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/FormResource")   

     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             )
     *         )
     *     )
     * )
     */

    public function index()
    {
        $allForms = $this->formService->getAllForms();
        return FormResource::collection($allForms)->additional([
            'status' => 'success' // or any other status you want to append
        ]);
    }

    /**
     * @OA\Post(
     *     path="/forms/create",
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
     *         
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
     *         @OA\JsonContent(ref="#/components/schemas/FormResource")
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


    /**
     * @OA\Post(
     *     path="/forms/{id}/data",
     *     tags={"Form Data"},
     *     summary="Store form data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the form to store data for",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"form_field_answers"},
     *             @OA\Property(
     *                 property="form_field_answers",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="fieldId",
     *                         type="string",
     *                         example="unique_field_id"
     *                     ),
     *                     @OA\Property(
     *                         property="fieldKey",
     *                         type="string",
     *                         example="key1"
     *                     ),
     *                     @OA\Property(
     *                         property="response",
     *                         type="string",
     *                         example="answer1"
     *                     ),
     *                     @OA\Property(
     *                         property="question",
     *                         type="string",
     *                         example="What is your username?"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Form data stored successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FormResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function storeData(Request $request, $id)
    {
        $data = $request->all();
        $data['form_builder_id'] = $id;
        $formData = $this->formService->createFormData($data);
        FormDataCreated::dispatch($formData->toArray());
        return response()->json($formData, 201);
    }

    /**
     * @OA\Put(
     *     path="/forms/update/{id}",
     *     tags={"Forms"},
     *     summary="Update a form",
     *     description="Updates the form with the specified ID.",
     *     operationId="updateForm",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the form to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="value1"
     *             ),
     *             @OA\Property(
     *                 property="tag_id",
     *                 type="string",
     *                 example="value1"
     *             ),
     *             @OA\Property(
     *                 property="json_form",
     *                 type="object",
     *                 example={"name": "value"}
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="process_flow_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="process_flow_step_id",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Form updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Form updated successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid ID"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Form not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Form not found"
     *             )
     *         )
     *     )
     * )
     */

    public function update(int $id, Request $request)
    {
        if (empty($id) || $id < 1) {
            return false;
        }
        $update = $this->formService->updateForm($id, $request->all());
        if ($update) {
            return response()->json([
                "status" => "success",
                "message" => "form updated successfully"
            ], 200);
        }

        return response()->json([
            "status" => "error",
            "message" => "Invalid ID"
        ], 400);
    }


    /**
     * @OA\Get(
     *     path="/form/view/{id}/{entity}/{entity_id}",
     *     summary="View a specific form with relationships",
     *     description="This endpoint allows a user to view a specific form with its relationships. 
     *                  It checks the access permissions based on the entity and entity_id parameters.",
     *     operationId="viewForm",
     *     tags={"Forms"},
     *     
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the form to view",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="entity",
     *         in="path",
     *         description="Entity type associated with the form",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="entity_id",
     *         in="path",
     *         description="Entity ID associated with the form",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Form retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/FormResource")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Form retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="task", type="object", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/FormResource")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=400,
     *         description="Access denied to this form",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="you do not have access to this form")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Entity ID mismatch with active user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="The entity id does not match with the active user")
     *         )
     *     ),
     *     
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function view(int $id, string $entity, int $entity_id)
    {

        $user = auth()->id();
        // if ($entity_id > 0 && $entity_id !== $user) {
        //     return response()->json([
        //         "status" => "error",
        //         "message" => "The entity id does not match with the active  user",
        //     ], 500);
        // }
        $getForm = $this->formService->getFormWithRelationships($id);
        $response = (new FormResource($getForm));

        if ($getForm) {

            // check if the form has a process_flow_id

            if ($getForm->process_flow_id < 1) {
                // check that there is an active form data 
                if ($getForm->activeFormdata->count() > 0) {
                    // check if data relationship entity and entity id exist in data before granting user access to form
                    //use array filter to do the check
                    $checkAccess = array_filter($getForm->activeFormdata->toArray(), function ($formData) use ($entity, $entity_id, $user) {
                        return isset($formData['entity'])
                            && isset($formData['entity_id'])
                            && $formData['entity'] === $entity
                            && $formData['entity_id'] == $entity_id
                            && $formData['user_id'] == $user;
                    });
                    if (!empty($checkAccess)) {
                        return $response->additional([
                            'status' => 'success', // or any other status you want to append
                            'task' => $checkAccess[0] // return the specific task
                        ]);
                    }
                    return response()->json([
                        "status" => "error",
                        "message" => "you do not have access to this form",
                    ], 400);
                } else {
                    return response()->json([
                        "status" => "error",
                        "message" => "you do not have access to this form",
                    ], 400);
                }
            }

            return $response->additional([
                'status' => 'success' // or any other status you want to append
            ]);
        }
    }
}
