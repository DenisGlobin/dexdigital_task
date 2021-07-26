<?php


namespace App\Services\PaymentStatus;


interface PaymentStatus
{
    public function finishPayment(): array;
}
