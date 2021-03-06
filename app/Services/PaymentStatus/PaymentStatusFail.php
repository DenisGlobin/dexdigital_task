<?php


namespace App\Services\PaymentStatus;


use App\Models\Order;
use App\Services\CallbackDataDto;
use App\Services\StatusEnum;

class PaymentStatusFail implements PaymentStatus
{
    private CallbackDataDto $data;

    /**
     * PaymentStatusFail constructor.
     * @param CallbackDataDto $data
     */
    public function __construct(CallbackDataDto $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function finishPayment(): array
    {
        $orderId = $this->data->transaction->id;
        $errorCode = $this->data->error->code;
        $errorMessage = $this->data->error->recommended_message_for_user;

        $id = explode('-', $orderId)[0];
        $id = (int) $id;
        Order::update(StatusEnum::STATUS_FAIL, $id);

        $error = [
            'code' => $errorCode,
            'message' => $errorMessage
        ];

        $responseData = [
            'orderId' => $orderId,
            'status' => StatusEnum::STATUS_FAIL,
            'redirectUrl' => route('fail'),
            'error' => $error
        ];

        return $responseData;
    }
}
