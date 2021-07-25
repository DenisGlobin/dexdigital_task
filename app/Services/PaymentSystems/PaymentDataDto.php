<?php


namespace App\Services\PaymentSystems;


use Illuminate\Http\Request;

class PaymentDataDto
{
    public float $amount;
    public string $currency;
    public string $processStatus;

    public static function createFromRequest(Request $request): self
    {
        $paymentData = new self();
        $paymentData->amount = (float) $request->input('amount');
        $paymentData->currency = (string) $request->input('currency');
        $paymentData->currency = strtoupper($paymentData->currency);
        $paymentData->processStatus = (string) $request->input('processStatus');
        $paymentData->processStatus = strtolower($paymentData->processStatus);

        return $paymentData;
    }
}
