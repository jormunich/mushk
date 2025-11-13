@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="text-center mb-5">
            <div class="mb-3">
                <svg width="80" height="80" fill="currentColor" class="text-success">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
            </div>
            <h1 class="mb-3">{{ __('Thank You for Your Order!') }}</h1>
            <p class="lead">{{ __('Your order has been successfully placed.') }}</p>
            <p class="text-muted">{{ __('Order Number') }}: <strong>{{ $order->order_number }}</strong></p>
            <p class="text-muted">{{ __('Confirmation email has been sent to') }} <strong>{{ $order->customer_email }}</strong></p>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('Order Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">{{ __('Shipping Information') }}</h6>
                                <p class="mb-1">{{ $order->customer_name }}</p>
                                <p class="mb-1">{{ $order->address }}</p>
                                <p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                                <p class="mb-1">{{ $order->country }}</p>
                                @if($order->customer_phone)
                                    <p class="mb-1">{{ __('Phone') }}: {{ $order->customer_phone }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">{{ __('Payment Information') }}</h6>
                                <p class="mb-1">{{ __('Payment Method') }}: {{ ucfirst($order->payment_method) }}</p>
                                <p class="mb-1">{{ __('Payment Status') }}: {!! $order->payment_status_badge !!}</p>
                                <p class="mb-1">{{ __('Order Status') }}: {!! $order->status_badge !!}</p>
                                <p class="mb-1">{{ __('Order Date') }}: {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">{{ __('Order Items') }}</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th class="text-center">{{ __('Quantity') }}</th>
                                        <th class="text-end">{{ __('Price') }}</th>
                                        <th class="text-end">{{ __('Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product)
                                                        <img src="{{ $item->product->getFilePath() }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="me-2" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <span>{{ $item->product_name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->product_price, 2) }}</td>
                                            <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">{{ __('Subtotal') }}:</td>
                                        <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">{{ __('Shipping') }}:</td>
                                        <td class="text-end">
                                            @if($order->shipping == 0)
                                                {{ __('Free') }}
                                            @else
                                                ${{ number_format($order->shipping, 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">{{ __('Tax') }}:</td>
                                        <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td colspan="3" class="text-end fw-bold fs-5">{{ __('Total') }}:</td>
                                        <td class="text-end fw-bold fs-5">${{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        {{ __('Continue Shopping') }}
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                        {{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
</svg>

<script>
// Clear cart after successful order
localStorage.removeItem('cart');
if (typeof updateCartCount === 'function') {
    updateCartCount();
}
</script>
@endsection


