<?php

namespace App\Http\Controllers;

use Skillz\UserService;
use Illuminate\Http\Request;
use App\Services\FormService;
use App\Http\Resources\FormDataResource;
use Illuminate\Support\Facades\Auth;

class FormDataController extends Controller
{

    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }
}
