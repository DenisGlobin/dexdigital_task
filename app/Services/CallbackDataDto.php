<?php


namespace App\Services;


use Illuminate\Http\Request;
use stdClass;

class CallbackDataDto
{
    public stdClass $transaction;
    public stdClass $order;
    public stdClass $error;

    /**
     * @param Request $request
     * @return static
     */
    public static function createFromRequest(Request $request): self
    {
        $callbackData = new self();

        $transaction = new \stdClass();
        $transaction->id = $request->input('transaction.id') ?? null;
        $transaction->operation = $request->input('transaction.operation') ?? '';
        $transaction->status = $request->input('transaction.status') === StatusEnum::STATUS_SUCCESS
            ? StatusEnum::STATUS_SUCCESS
            : StatusEnum::STATUS_FAIL;

        $callbackData->transaction = $transaction;

        $order = new \stdClass();
        $order->order_id = $request->input('order.order_id') ?? null;
        $order->status = $request->input('order.status') ?? null;
        $order->amount = $request->input('order.amount') ?? 0;
        $order->currency = $request->input('order.currency') ?? 'USD';
        $order->refunded_amount = $request->input('order.refunded_amount') ?? 0;
        $order->marketing_amount = $request->input('order.marketing_amount') ?? 0;
        $order->marketing_currency = $request->input('order.marketing_currency') ?? 'USD';
        $order->processing_amount = $request->input('order.processing_amount') ?? 0;
        $order->processing_currency = $request->input('order.processing_currency') ?? 'USD';
        $order->descriptor = $request->input('order.descriptor') ?? 'FAKE_PSP';
        $order->fraudulent = $request->input('order.fraudulent') ?? false;
        $order->total_fee_amount = $request->input('order.total_fee_amount') ?? 0;
        $order->fee_currency = $request->input('order.fee_currency') ?? 'USD';

        $callbackData->order = $order;

        if ($request->input('transaction.status') === StatusEnum::STATUS_FAIL) {
            $error = new \stdClass();
            $error->code = $request->input('error.code') ?? null;
            $error->messages = $request->input('error.messages') ?? '';
            $error->recommended_message_for_user = $request->input('error.recommended_message_for_user') ?? '';

            $callbackData->error = $error;
        }

        return $callbackData;
    }
}
