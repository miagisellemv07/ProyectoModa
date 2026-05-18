<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Controllers\Controller;
class PayPallController extends Controller
{ 
    public function index($amount)
    {
        $mode = config('paypal.mode');
        $client_id = config("paypal.{$mode}.client_id");
        $currency = config('paypal.currency', 'MXN');
        return response()->json([
            'client_id' => $client_id,
            'amount' => $amount,
            'currency' => $currency
        ]);
    }



    public function createOrder(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        if (isset($token['error']) || !isset($token['access_token'])) {
            return response()->json($token, 500);
        }
        $provider->setAccessToken($token);

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('paypal.currency', 'MXN'),
                        "value" => $request->amount
                    ]
                ]
            ]
        ]);

        return response()->json($order);
    }

    public function captureOrder(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        if (isset($token['error']) || !isset($token['access_token'])) {
            return response()->json($token, 500);
        }
        $provider->setAccessToken($token);

        $result = $provider->capturePaymentOrder($request->orderID);

        return response()->json($result);
    }
}