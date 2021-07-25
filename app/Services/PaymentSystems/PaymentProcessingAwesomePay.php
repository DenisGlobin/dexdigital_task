<?php


namespace App\Services\PaymentSystems;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

final class PaymentProcessingAwesomePay extends AbstractPaymentProcessing
{
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';

    private string $token;

    public function initPayment(PaymentDataDto $dto): void
    {
        $order = new Order();
        $order->status = self::STATUS_PENDING;

        if ($order->save()) {
            throw new \Exception('Can\'t create new Order');
        }

        $this->amount = $dto->amount;
        $this->currency = $dto->currency;
        $this->processStatus = $dto->processStatus;
        $this->orderId = $order->getId() . '-' . microtime();
//        $this->orderId = '11111-' . microtime();
        $this->token = bin2hex(openssl_random_pseudo_bytes(16));

        //$response = $this->sendToPaymentSystemApi();
    }

    public function sendToPaymentSystemApi(): JsonResponse
    {
        return $this->processPayment();
    }

    private function processPayment(): JsonResponse
    {
        $payload = new \stdClass();

        $payForm = new \stdClass();
        $payForm->token = $this->token;
        $payForm->design_name = 'des1';

        $payload->pay_form = $payForm;

        $transactionData = new \stdClass();
        $transactionData->id = $this->orderId;
        $transactionData->operation = 'pay';
        $transactionData->status = $this->processStatus === self::STATUS_SUCCESS ? self::STATUS_SUCCESS : self::STATUS_FAIL;
        $transactionData->descriptor = 'FAKE_PSP';
        $transactionData->amount = $this->amount;
        $transactionData->currency = $this->currency;
        $transactionData->fee = [
            'amount' => 0,
            'currency' => 'USD'
        ];
        $transactionData->card = [
            'bank' => 'CITIZENS STATE BANK'
        ];

        if ($transactionData->status === self::STATUS_FAIL) {
            $error = new \stdClass();
            $error->code = '6.01';
            $error->messages = 'Unknown decline code';
            $error->recommended_message_for_user = 'Unknown decline code';

            $transactionData->error = $error;
        }

        $transactions = new \stdClass();
        $transactions->{$this->orderId} = $transactionData;
        $payload->transactions = $transactions;

        $order = new \stdClass();
        $order->order_id = $this->orderId;
        $order->status = $this->processStatus === self::STATUS_SUCCESS ? self::STATUS_ACCEPTED : self::STATUS_DECLINED;
        $order->amount = $this->amount;
        $order->currency = $this->currency;
        $order->refunded_amount =  $this->processStatus === self::STATUS_SUCCESS ? $this->amount : 0;
        $order->marketing_amount = $this->currency;
        $order->marketing_currency = $this->currency;
        $order->processing_amount = $this->currency;
        $order->processing_currency = $this->currency;
        $order->descriptor = 'FAKE_PSP';
        $order->fraudulent = false;
        $order->total_fee_amount = 0;
        $order->fee_currency = 'USD';

        $payload->order = $order;

        $transaction = new \stdClass();
        $transaction->id = $this->orderId;
        $transaction->operation = 'pay';
        $transaction->status = $this->processStatus === self::STATUS_SUCCESS ? self::STATUS_SUCCESS : self::STATUS_FAIL;

        $payload->transaction = $transaction;

//        $payload = json_encode($payload);
//        $url = route('api.callback');
////        $response = redirect()->route('api.callback')->withInput(['payload' => $payload]);
//        $client = new Client();
//        $response = $client->patch($url, ['payload' => $payload])->getBody()->getContents();
//        $data = json_decode($response, true);

        return response()->json($payload);
    }

}
