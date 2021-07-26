<?php


namespace App\Services;


use App\Services\PaymentProcessing\PaymentDecline;

class CallbackManager
{
    public static function resolve(array $data): array
    {
        if ($data['transaction']['status'] === null
            || $data['transaction']['id'] === null) {
            throw new \InvalidArgumentException();
        }

        if ($data['transaction']['status'] === StatusEnum::STATUS_FAIL) {
            $processing = new PaymentDecline();
        } else {
            //
        }

        return $processing->handle($data);
    }
}
