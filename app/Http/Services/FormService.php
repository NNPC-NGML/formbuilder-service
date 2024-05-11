<?php

namespace App\Services;

use App\Models\FormBuilder;
class FormService
{
    public function createForm($data): FormBuilder
    {
        return FormBuilder::create($data);
    }

    public function getForm(int $formId): Form
    {
        return Form::find($formId);
    }
}
