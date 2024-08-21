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
            'tag_id' => 'required|integer',
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

    public function getFormWithRelationships(int $formId): FormBuilder
    {
        $form = FormBuilder::where(["id" => $formId])->with(["activeFormdata"])->first();

        if (!$form) {
            throw new ModelNotFoundException("FormBuilder with id $formId not found.");
        }

        return $form;
    }

    /**
     * Create form data.
     * 
     * @param array $data form data you want to update
     *
     * @return App\Models\FormData an instance of the created form data.
     */
    public function createFormData(array $data): FormData
    {

        $validator = Validator::make($data, [
            'form_builder_id' => 'required|exists:form_builders,id',
            'form_field_answers' => 'required',
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

    /**
     * Get all forms.
     *
     *
     * @return \Illuminate\Database\Eloquent\Collection|array A collection of all form objects.
     */
    public function getAllForms()
    {
        return  FormBuilder::all();
    }

    /**
     * Update a  form details.
     * 
     * @param integer $id form id
     * @param array $data form data you want to update
     *
     * @return boolean indicating update was a success.
     */
    public function updateForm(int $id, array $data)
    {
        try {
            $form = $this->getForm($id);
            if ($form) {
                return  $form->update($data);
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update Form Data.
     * 
     * @param integer $id the form data id to be updated
     * @param array $data the the new data to use to update the form data
     *
     * @return boolean indicating update was a success.
     */
    public function updateFormData(int $id, array $data)
    {
        try {
            $formData = $this->getFormData($id);
            if ($formData) {
                return  $formData->update($data);
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
