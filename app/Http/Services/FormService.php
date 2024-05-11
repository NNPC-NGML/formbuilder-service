<?php

namespace App\Services;

use App\Models\Form;
use App\Models\FormData;
class FormService
{
    public function createForm($data): Form
    {
        //dispatch actions
        return Form::create($data);
    }

    public function getForm(int $formId): Form
    {
        return Form::find($formId);
    }

    public function createFormData(array $data): FormData
    {
        return FormData::create($data);
    }
}
