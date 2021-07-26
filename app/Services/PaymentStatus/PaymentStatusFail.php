<?php


namespace App\Services\PaymentStatus;


use App\Models\Order;
use App\Services\StatusEnum;

class PaymentStatusFail implements PaymentStatus
{
    private array $data;

    /**
     * PaymentStatusFail constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function finishPayment(): array
    {
        $orderId = $this->data['transaction']['id'] ?? null;
        $errorCode = $this->data['error']['code'] ?? null;
        $errorMessage = $this->data['error']['recommended_message_for_user'] ?? null;

//        $id = explode('-', $orderId)[0];
//        $id = (int) $id;
//        Order::update(StatusEnum::STATUS_FAIL, $id);

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
