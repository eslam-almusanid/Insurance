<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Interfaces\YakeenServiceInterface;
use Illuminate\Http\Request;
use App\Rules\SaudiIDRule;
class YakeenController extends Controller
{
    protected $yakeenService;

    public function __construct(YakeenServiceInterface $yakeenService)
    {
        $this->yakeenService = $yakeenService;
    }

    public function verifyIdentity(Request $request)
    {
        $request->validate([
            'national_id' => ['required','string',new SaudiIDRule],
        ]);

        $result = $this->yakeenService->verifyIdentity($request->national_id);

        return response()->json($result,$result['status'] == 'success' ? 200 : 400);
    }
}