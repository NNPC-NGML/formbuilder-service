<?php

namespace App\Services;

use App\Models\FormBuilder;
use App\Models\FormData;
class FormService
{
    public function createForm($data): FormBuilder
    {
        return FormBuilder::create($data);
    }

    public function getForm(int $formId): FormBuilder
    {
        return FormBuilder::find($formId);
    }

    public function createFormData(array $data): FormData
    {
        return FormData::create($data);
    }
}
