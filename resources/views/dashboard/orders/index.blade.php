@extends('dashboard.layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">{{ __('Orders') }}</h3>
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
                <a href="#">{{ __('Orders') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">{{ __('Order List') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('dashboard.orders.index') }}" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="payment_status" class="form-control">
                                    <option value="">{{ __('All Payment Statuses') }}</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                                <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Order #') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Items') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Payment') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>
                                            <div>{{ $order->customer_name }}</div>
                                            <small class="text-muted">{{ $order->customer_email }}</small>
                                        </td>
                                        <td>{{ $order->items->count() }} {{ __('items') }}</td>
                                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                        <td>{!! $order->status_badge !!}</td>
                                        <td>{!! $order->payment_status_badge !!}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-sm btn-info" title="{{ __('View') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ __('Delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ __('No orders found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


