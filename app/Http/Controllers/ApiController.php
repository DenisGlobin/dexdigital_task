<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CallbackManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
//        $status = $request->input('transaction.status') ?? null;
//        $order_id = $request->input('transaction.id') ?? null;
//        $error = $request->input('error');
//
//        if ($status === null || $order_id === null) {
//            $data = [
//                'status' => 'fail',
//                'redirectUrl' => null
//            ];
//
//            return response()->json($data);
//        }
//
//        $id = explode('-', $order_id)[0];
//        $id = (int) $id;
//        Order::update($status, $id);
//
//        $data = [
//            'status' => $status,
//            'redirectUrl' => route('success')
//        ];
//
//        if ($status === 'fail') {
//            $data['redirectUrl'] = route('fail');
//            $data['error'] = $error;
//        }
        $paymentData = $request->input();
        $result = CallbackManager::resolve($paymentData);

        return response()->json($result);
    }
}
