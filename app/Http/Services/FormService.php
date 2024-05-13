<?php

namespace App\Services;

use App\Models\FormBuilder;
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
            'access_control.*.user' => 'sometimes|string',
            'access_control.*.role' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return FormBuilder::create($data);
    }

    public function getForm(int $id): FormBuilder
    {
        return FormBuilder::find($id);
    }
}
