<?php

namespace App\Services;

use App\Models\FormBuilder;
class FormService
{
    public function createForm($data): FormBuilder
    {
        return FormBuilder::create($data);
    }
}
