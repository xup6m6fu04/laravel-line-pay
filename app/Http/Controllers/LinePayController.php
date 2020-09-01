<?php

namespace App\Http\Controllers;

use App\Order;
use App\Services\LinePayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LinePayController extends Controller
{
    protected $linePayService;

    public function __construct(LinePayService $linePayService)
    {
        $this->linePayService = $linePayService;
    }

    public function form(Request $request)
    {
        $order_id = 'ORDER-' . $this->linePayService->randString(12, true);
        $product_id = 'PRODUCT-' . $this->linePayService->randString(12, true);
        $product_name = '測試商品' . $this->linePayService->randString(12, true);
        return view('form')->with([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'product_name' =>$product_name
        ]);
    }

    public function getPaymentInfo(Request $request)
    {
        try {
            $args = $request->all();
            $response = $this->linePayService->getPaymentResponse($args);
            Order::firstOrCreate(
                ['order_id' => $args['order_id']],
                [
                    'product_id' => $args['product_id'],
                    'quantity' => $args['quantity'],
                    'price' => $args['price'],
                    'transaction_id' => $response->toArray()['info']['transactionId']
                ]
            );
            Log::info(print_r($response->toArray(), true));
            return ['payment_url' => $response->getPaymentUrl()];
        } catch (Exception $e) {
            Log::error($e);
        }
    }
    // 使用者授權付款後，跳轉到該商家URL
    public function confirm(Request $request)
    {
        Log::info('Confirm Start');
        Log::info(print_r($request->all(), true));
        $order = Order::where('transaction_id', $request->input('transactionId'))->first();
        $this->linePayService->confirm([
            "transaction_id" => $request->input('transactionId'),
            "amount" => $order->price * $order->quantity,
            "currency" => 'TWD'
        ]);
        Log::info('Confirm End');
        return redirect()->route('form')->withErrors(['confirm' => $request->input('transactionId')]);
    }

    public function refund(Request $request)
    {
        Log::info('Refund Start ' . $request->input('transaction_id'));
        Log::info(print_r($request->all(), true));
        $response = $this->linePayService->refund([
            "transaction_id" => $request->input('transaction_id'),
            "refund_amount" => $request->input('refund_amount')
        ]);
        Log::info(print_r($response->toArray(), true));
        Log::info('Refund End');
        return ['message' => $response->toArray()['returnMessage']];
    }

    // 使用者通過LINE支付頁，取消支付後跳轉到該URL
    public function cancel(Request $request)
    {
        Log::info('Cancel Start');
        Log::info(print_r($request->all(), true));
        Log::info('Cancel End');
    }
}
