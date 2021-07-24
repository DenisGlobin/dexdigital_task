<?php


namespace App\Services\PaymentSystems;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractPaymentProcessing
{
    abstract public function initPayment(PaymentDataDto $dto): JsonResource;

    abstract public function processPayment(): RedirectResponse;

    public static function getInstance(string $paymentSystemName): self
    {
        return new PaymentProcessingAwesomePay();
    }
}
