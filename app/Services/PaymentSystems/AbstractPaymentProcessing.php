<?php


namespace App\Services\PaymentSystems;

use Illuminate\Http\JsonResponse;

abstract class AbstractPaymentProcessing
{
    protected float $amount;
    protected string $currency;
    protected string $processStatus;
    protected string $orderId;

    abstract public function initPayment(PaymentDataDto $dto): void;

    abstract public function sendToPaymentSystemApi(): JsonResponse;

    public static function getPaymentProcessingByName(string $paymentSystemName): self
    {
        return new PaymentProcessingAwesomePay();
    }
}
