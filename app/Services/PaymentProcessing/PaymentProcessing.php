<?php


namespace App\Services\PaymentProcessing;


use App\Services\PaymentStatus\PaymentStatus;

abstract class PaymentProcessing
{
    abstract protected function initNewStatus($data): PaymentStatus;

    public function handle(array $data): array
    {
        $status = $this->initNewStatus($data);

        return $status->finishPayment();
    }
}
