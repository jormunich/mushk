<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PayPalService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function index(): View
    {
        return view('pages.checkout');
    }

    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'cart' => 'required|json',
        ]);

        try {
            $cart = json_decode($validated['cart'], true);
            
            if (empty($cart)) {
                return redirect()->route('pages.cart')
                    ->with('error', __('Your cart is empty'));
            }

            // Calculate totals
            $subtotal = 0;
            $items = [];
            
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    continue;
                }
                
                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'name' => $product->name,
                    'unit_amount' => [
                        'currency_code' => config('services.paypal.currency'),
                        'value' => number_format($product->price, 2, '.', '')
                    ],
                    'quantity' => (string)$item['quantity']
                ];
            }

            $shipping = $subtotal >= 50 ? 0 : 5.00;
            $tax = $subtotal * 0.08; // 8% tax
            $total = $subtotal + $shipping + $tax;

            // Create order in database first
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip'],
                'country' => $validated['country'],
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => 'paypal',
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'quantity' => $item['quantity'],
                        'subtotal' => $product->price * $item['quantity'],
                    ]);
                }
            }

            // Create PayPal order
            $paypalOrder = $this->paypalService->createOrder([
                'reference_id' => $order->order_number,
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'shipping' => number_format($shipping, 2, '.', ''),
                'tax' => number_format($tax, 2, '.', ''),
                'total' => number_format($total, 2, '.', ''),
                'items' => $items
            ]);

            // Save PayPal order ID
            $order->update([
                'paypal_order_id' => $paypalOrder->result->id
            ]);

            // Get approval URL
            foreach ($paypalOrder->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect()->away($link->href);
                }
            }

            throw new \Exception('PayPal approval URL not found');

        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', __('Payment processing failed. Please try again.'));
        }
    }

    public function success(Request $request): RedirectResponse
    {
        $token = $request->query('token');
        
        if (!$token) {
            return redirect()->route('pages.cart')
                ->with('error', __('Invalid payment token'));
        }

        try {
            // Find order by PayPal order ID
            $order = Order::where('paypal_order_id', $token)->first();
            
            if (!$order) {
                return redirect()->route('pages.cart')
                    ->with('error', __('Order not found'));
            }

            // Capture payment
            $capture = $this->paypalService->captureOrder($token);
            
            if ($capture->result->status === 'COMPLETED') {
                $order->update([
                    'payment_status' => 'completed',
                    'status' => 'processing',
                    'paypal_payer_id' => $capture->result->payer->payer_id ?? null
                ]);

                return redirect()->route('checkout.confirmation', $order->order_number)
                    ->with('success', __('Payment successful! Your order has been placed.'));
            }

            throw new \Exception('Payment not completed');

        } catch (\Exception $e) {
            Log::error('Payment capture error: ' . $e->getMessage());
            return redirect()->route('pages.cart')
                ->with('error', __('Payment verification failed. Please contact support.'));
        }
    }

    public function cancel(): RedirectResponse
    {
        return redirect()->route('pages.cart')
            ->with('info', __('Payment was cancelled. Your cart is still available.'));
    }

    public function confirmation($orderNumber): View
    {
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('pages.order-confirmation', compact('order'));
    }
}
