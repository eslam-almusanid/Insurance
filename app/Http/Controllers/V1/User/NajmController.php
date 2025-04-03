<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Interfaces\NajmServiceInterface;
use Illuminate\Http\Request;
use App\Interfaces\YakeenServiceInterface;
use App\Rules\SaudiIDRule;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class NajmController extends Controller
{
    protected $najmService;
    protected $yakeenService;

    public function __construct(NajmServiceInterface $najmService, YakeenServiceInterface $yakeenService)
    {
        $this->najmService = $najmService;
        $this->yakeenService = $yakeenService;
    }

    public function getVehicleInfo(Request $request)
    {
        try {
            $request->validate([
                'national_id' => ['required','string',new SaudiIDRule],
                'vehicle_sequence_number' => 'required|string|size:12',
            ]);
    
            $identity = $this->verifyIdentity($request);
    
            $result = $this->najmService->getVehicleInfo(
                $identity['data']['national_id'],
                $request->vehicle_sequence_number
            );
    
            return response()->json($result);
        } catch (BadRequestException $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    protected function verifyIdentity(Request $request)
    {
        $identity = $this->yakeenService->verifyIdentity($request->national_id);

        if ($identity['status'] === 'error') {
            throw new BadRequestException($identity['message']);
        }

        return $identity;
    }

    public function checkPolicyStatus(Request $request)
    {
        $request->validate([
            'national_id' => ['required','string',new SaudiIDRule],
            'vehicle_sequence_number' => 'required|string|size:12',
            'policy_number' => 'required|string',
        ]);

        $identity = $this->verifyIdentity($request);

        $result = $this->najmService->checkPolicyStatus(
            $identity['data']['national_id'],
            $request->vehicle_sequence_number,
            $request->policy_number
        );

        return response()->json($result);
    }

    public function submitClaim(Request $request)
    {
        $request->validate([
            'national_id' => ['required','string',new SaudiIDRule],
            'vehicle_sequence_number' => 'required|string|size:12',
            'accident_date' => 'required|date',
            'location' => 'required|string',
            'description' => 'required|string',
        ]);
        
        $this->verifyIdentity($request);

        $result = $this->najmService->submitClaim($request->all());

        return response()->json($result, 201);
    }

    public function getInsuranceOffers(Request $request)
    {
        $request->validate([
            'national_id' => ['required','string',new SaudiIDRule],
            'vehicle_sequence_number' => 'required|string|size:12',
            'is_custom_car' => 'boolean',
        ]);

        $identity = $this->verifyIdentity($request);

        $result = $this->najmService->getInsuranceOffers(
            $identity['data']['national_id'],
            $request->vehicle_sequence_number,
            $request->boolean('is_custom_car', false)
        );

        return response()->json($result);
    }
}
