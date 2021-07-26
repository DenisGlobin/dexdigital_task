<?php


namespace App\Services\PaymentStatus;


use App\Models\Order;
use App\Services\CallbackDataDto;
use App\Services\StatusEnum;

class PaymentStatusSuccess implements PaymentStatus
{
    private CallbackDataDto $data;

    /**
     * PaymentStatusSuccess constructor.
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

        $id = explode('-', $orderId)[0];
        $id = (int) $id;
        Order::update(StatusEnum::STATUS_SUCCESS, $id);

        $responseData = [
            'orderId' => $orderId,
            'status' => StatusEnum::STATUS_SUCCESS,
            'redirectUrl' => route('success'),
        ];

        return $responseData;
    }
}
