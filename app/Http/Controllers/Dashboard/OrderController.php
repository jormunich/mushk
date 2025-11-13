<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('items')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product');
        return view('dashboard.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        flash()->success(__('Order updated successfully'));

        return redirect()->route('dashboard.orders.show', $order);
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        flash()->success(__('Order deleted successfully'));

        return redirect()->route('dashboard.orders.index');
    }
}
