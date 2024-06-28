<?php

namespace App\Services;

use App\Models\FormBuilder;
use App\Models\FormData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FormService
{
    public function createForm($data): FormBuilder
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'json_form' => 'required|json',
            'field_structure' => 'required|array',
            'field_structure.*.fieldId' => 'required|string',
            'field_structure.*.name' => 'required|string',
            'field_structure.*.label' => 'required|string',
            'field_structure.*.inputType' => 'required|string',
            'field_structure.*.required' => 'required|boolean',
            'field_structure.*.placeholder' => 'nullable|string',
            'access_control' => 'sometimes|array',
            'access_control.*.user' => 'sometimes|integer',
            'access_control.*.role' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return FormBuilder::create($data);
    }

    public function getForm(int $formId): FormBuilder
    {
        $form = FormBuilder::find($formId);

        if (!$form) {
            throw new ModelNotFoundException("FormBuilder with id $formId not found.");
        }

        return $form;
    }

    public function createFormData(array $data): FormData
    {

        $validator = Validator::make($data, [
            'form_builder_id' => 'required|exists:form_builders,id',
            'form_field_answers' => 'required|array',
            'form_field_answers.*.fieldId' => 'required|string',
            'form_field_answers.*.fieldKey' => 'required|string',
            'form_field_answers.*.response' => 'required|string',
            'form_field_answers.*.question' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return FormData::create($data);
    }

    public function getFormData(int $id): FormData
    {
        $formData = FormData::find($id);

        if (!$formData) {
            throw new ModelNotFoundException("FormData with id $id not found.");
        }

        return $formData;
    }
}
