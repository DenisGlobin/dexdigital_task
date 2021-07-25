<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Models\Order;
use App\Services\PaymentSystems\AbstractPaymentProcessing;
use App\Services\PaymentSystems\PaymentDataDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function createPayment(Request $request): JsonResponse
    {
        $paymentData = PaymentDataDto::createFromRequest($request);
        try {
            $paymentSystem = AbstractPaymentProcessing::getPaymentProcessingByName($request->paymentSystem);
            $paymentSystem->initPayment($paymentData);
            $response = $paymentSystem->sendToPaymentSystemApi();
        } catch (\Exception $e) {
            return \response()->setStatusCode(500)->json();
        }

        return $response;
    }

    public function callback(Request $request): JsonResponse
    {
        $status = $request->input('transaction.status') ?? null;
        $order_id = $request->input('transaction.id') ?? null;
        $error = $request->input('error');

        if ($status === null || $order_id === null) {
            $data = [
                'status' => 'fail',
                'redirectUrl' => null
            ];

            return response()->json($data);
        }

        $id = explode('-', $order_id);
        $id = (int) $id;
        $order = Order::findOrFail($id);

        $data = [
            'status' => $status,
            'redirectUrl' => route('success')
        ];

        if ($status === 'fail') {
            $data['redirectUrl'] = route('fail');
            $data['error'] = $error;

            $order->updateStatus('fail');
        }

        if ($status === 'success') {
            $order->updateStatus('success');
        }

        return response()->json($data);
    }
}
