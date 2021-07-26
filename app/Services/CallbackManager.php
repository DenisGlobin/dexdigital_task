<?php


namespace App\Services;


use App\Services\PaymentProcessing\PaymentAccept;
use App\Services\PaymentProcessing\PaymentDecline;

class CallbackManager
{
    /**
     * @param CallbackDataDto $dto
     * @return array
     */
    public static function resolve(CallbackDataDto $dto): array
    {
        if (empty($dto->transaction->status) || empty($dto->transaction->id)) {
            throw new \InvalidArgumentException();
        }

        if ($dto->transaction->status === StatusEnum::STATUS_FAIL) {
            $processing = new PaymentDecline();
        } else {
            $processing = new PaymentAccept();
        }

        return $processing->handle($dto);
    }
}
