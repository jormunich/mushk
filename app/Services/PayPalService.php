<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalService
{
    private $client;

    public function __construct()
    {
        $this->client = $this->getClient();
    }

    private function getClient()
    {
        $mode = config('services.paypal.mode');
        $clientId = config("services.paypal.{$mode}.client_id");
        $clientSecret = config("services.paypal.{$mode}.client_secret");

        if ($mode === 'live') {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        } else {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }

        return new PayPalHttpClient($environment);
    }

    public function createOrder($orderData)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $orderData['reference_id'],
                'amount' => [
                    'currency_code' => config('services.paypal.currency'),
                    'value' => $orderData['total'],
                    'breakdown' => [
                        'item_total' => [
                            'currency_code' => config('services.paypal.currency'),
                            'value' => $orderData['subtotal']
                        ],
                        'shipping' => [
                            'currency_code' => config('services.paypal.currency'),
                            'value' => $orderData['shipping']
                        ],
                        'tax_total' => [
                            'currency_code' => config('services.paypal.currency'),
                            'value' => $orderData['tax']
                        ]
                    ]
                ],
                'items' => $orderData['items']
            ]],
            'application_context' => [
                'cancel_url' => route('checkout.cancel'),
                'return_url' => route('checkout.success')
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}


