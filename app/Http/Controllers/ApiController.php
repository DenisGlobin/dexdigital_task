<?php

namespace App\Http\Controllers;

use App\Services\CallbackDataDto;
use App\Services\CallbackManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
        $paymentData = CallbackDataDto::createFromRequest($request);
        try {
            $result = CallbackManager::resolve($paymentData);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => 'Internal error']);
        }

        return response()->json($result);
    }
}
