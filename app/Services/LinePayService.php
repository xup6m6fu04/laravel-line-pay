<?php
namespace App\Services;

use App\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use yidas\linePay\Client;

class LinePayService
{
    protected $linePay;

    public function __construct()
    {
        try {
            $this->linePay = new Client([
                'channelId' => config('line.channel_id'),
                'channelSecret' => config('line.channel_secret_key'),
                'isSandbox' => true,
            ]);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function getPaymentResponse(Array $args)
    {
        // Online Request API
        // https://pay.line.me/tw/developers/apis/onlineApis?locale=zh_TW
        $response = $this->linePay->request([
            'amount' => $args['quantity'] * $args['price'],
            'currency' => $args['currency'],
            'orderId' => $args['order_id'],
            'packages' => [
                [
                    'id' => $args['package_id'],
                    'amount' => $args['quantity'] * $args['price'],
                    'name' => $args['package_name'],
                    'products' => [
                        [
                            'name' => $args['product_name'],
                            'quantity' => $args['quantity'],
                            'price' => $args['price'],
                            'imageUrl' => config("app.url") . '/order.png',
                        ],
                    ],
                ],
            ],
            'options' => [
                'payment' => [
                    'capture' => true // 自動請款
                ]
            ],
            'redirectUrls' => [
                'confirmUrl' => config("app.url") . '/line-pay/confirm',
                'cancelUrl' => config("app.url") . '/line-pay/cancel',
            ],
        ]);
        // Check Request API result (returnCode "0000" check method)
        if (!$response->isSuccessful()) {
            throw new Exception("ErrorCode {$response['returnCode']}: {$response['returnMessage']}");
        }

        return $response;
    }

    public function confirm(Array $args)
    {
        return $this->linePay->confirm($args['transaction_id'], [
            "amount" => $args['amount'],
            "currency" => $args['currency'],
        ]);
    }

    public function refund($args)
    {
        return isset($args['refund_amount']) && $args['refund_amount'] == 0
            ? $this->linePay->refund($args['transaction_id'])
            : $this->linePay->refund($args['transaction_id'], [
                'refundAmount' => $args['refund_amount'],
            ]);
    }

    function randString($length = 10, $only_number = false)
    {
        $pattern = ($only_number) ? '0123456789' : '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        while (strlen($string) < $length) {
            $string .= substr($pattern, rand(0, strlen($pattern) - 1), 1);
        }

        return $string;
    }
}
