@extends('dashboard.layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">{{ __('Order Details') }}</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard.index') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ $order->order_number }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">{{ __('Order') }} #{{ $order->order_number }}</h4>
                        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Customer Information -->
                    <h5 class="mb-3">{{ __('Customer Information') }}</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>{{ __('Name') }}:</strong> {{ $order->customer_name }}</p>
                            <p><strong>{{ __('Email') }}:</strong> {{ $order->customer_email }}</p>
                            @if($order->customer_phone)
                                <p><strong>{{ __('Phone') }}:</strong> {{ $order->customer_phone }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('Shipping Address') }}:</strong></p>
                            <p class="mb-0">{{ $order->address }}</p>
                            <p class="mb-0">{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                            <p>{{ $order->country }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items -->
                    <h5 class="mb-3">{{ __('Order Items') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                                         class="me-2">
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
                                    <td colspan="3" class="text-end"><strong>{{ __('Subtotal') }}:</strong></td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Shipping') }}:</strong></td>
                                    <td class="text-end">
                                        @if($order->shipping == 0)
                                            {{ __('Free') }}
                                        @else
                                            ${{ number_format($order->shipping, 2) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Tax') }}:</strong></td>
                                    <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="3" class="text-end"><strong>{{ __('Total') }}:</strong></td>
                                    <td class="text-end"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <hr>
                        <h5 class="mb-3">{{ __('Order Notes') }}</h5>
                        <p>{{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Update Order Status -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Order Status') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">{{ __('Order Status') }}</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Status') }}</label>
                            <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-save"></i> {{ __('Update Order') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Payment Information') }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Method') }}:</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>{{ __('Status') }}:</strong> {!! $order->payment_status_badge !!}</p>
                    @if($order->paypal_order_id)
                        <p><strong>{{ __('PayPal Order ID') }}:</strong><br>
                        <small class="text-muted">{{ $order->paypal_order_id }}</small></p>
                    @endif
                    @if($order->paypal_payer_id)
                        <p><strong>{{ __('PayPal Payer ID') }}:</strong><br>
                        <small class="text-muted">{{ $order->paypal_payer_id }}</small></p>
                    @endif
                    <p><strong>{{ __('Order Date') }}:</strong><br>{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


