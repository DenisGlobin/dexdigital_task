<?php


namespace App\Services\PaymentProcessing;


use App\Services\CallbackDataDto;
use App\Services\PaymentStatus\PaymentStatus;

abstract class PaymentProcessing
{
    abstract protected function initNewStatus(CallbackDataDto $dto): PaymentStatus;

    public function handle(CallbackDataDto $dto): array
    {
        $status = $this->initNewStatus($dto);

        return $status->finishPayment();
    }
}
