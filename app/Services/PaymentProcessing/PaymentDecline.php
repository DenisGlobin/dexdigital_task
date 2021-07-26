<?php


namespace App\Services\PaymentProcessing;


use App\Services\PaymentStatus\PaymentStatus;
use App\Services\PaymentStatus\PaymentStatusFail;

final class PaymentDecline extends PaymentProcessing
{

    public function initNewStatus($data): PaymentStatus
    {
        //setCallbackData
        return new PaymentStatusFail($data);
    }
}
