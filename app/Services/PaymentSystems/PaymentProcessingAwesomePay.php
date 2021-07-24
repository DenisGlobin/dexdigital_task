<?php


namespace App\Services\PaymentSystems;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class PaymentProcessingAwesomePay extends AbstractPaymentProcessing
{

    public function initPayment(PaymentDataDto $dto): JsonResource
    {
        // TODO: Implement createPayment() method.
    }

    public function processPayment(): RedirectResponse
    {
        // TODO: Implement createPayment() method.
    }

    private function processSuccess(): Response
    {
        //
    }

    private function processFail(): Response
    {
        //
    }
}
