<?php

namespace App\Services;

use App\Models\Form;
class FormService
{
    public function createForm($data): Form
    {
        return Form::create($data);
    }

    public function getForm(int $formId): Form
    {
        return Form::find($formId);
    }
}
