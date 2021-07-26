<?php


namespace App\Services\PaymentProcessing;


use App\Services\CallbackDataDto;
use App\Services\PaymentStatus\PaymentStatus;
use App\Services\PaymentStatus\PaymentStatusSuccess;

final class PaymentAccept extends PaymentProcessing
{
    /**
     * @param CallbackDataDto $dto
     * @return PaymentStatus
     */
    protected function initNewStatus(CallbackDataDto $dto): PaymentStatus
    {
        return new PaymentStatusSuccess($dto);
    }
}
