<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\RegistrationRequest;
use App\Services\V1\RegistrationService;

class RegistrationController extends Controller
{
    protected $registrationService;

    public function __construct(
        RegistrationService $registrationService
    ) {
        $this->registrationService = $registrationService;
    }

    public function __invoke(RegistrationRequest $request)
    {
        $registration = $this->registrationService->create($request->validated());

        return response()->json([
            'message' => 'Registration successful',
            'data' => $registration
        ]);
    }
}
