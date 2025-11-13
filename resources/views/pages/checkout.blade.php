@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-4">{{ __('Checkout') }}</h1>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Shipping Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                            @csrf
                            <input type="hidden" name="cart" id="cart-data">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="customer_name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                           id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                           id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">{{ __('Phone') }}</label>
                                    <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                           id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ __('City') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="state" class="form-label">{{ __('State') }}</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="zip" class="form-label">{{ __('ZIP Code') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                           id="zip" name="zip" value="{{ old('zip') }}" required>
                                    @error('zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">{{ __('Country') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', 'USA') }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                {{ __('Proceed to PayPal') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                    </div>
                    <div class="card-body" id="order-summary">
                        <p class="text-muted">{{ __('Loading...') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    if (cart.length === 0) {
        window.location.href = '{{ route("pages.cart") }}';
        return;
    }

    // Set cart data in hidden field
    document.getElementById('cart-data').value = JSON.stringify(cart);

    // Calculate totals
    let subtotal = 0;
    let summaryHTML = '<div class="mb-3">';
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        summaryHTML += `
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <div class="fw-bold">${item.name}</div>
                    <small class="text-muted">Qty: ${item.quantity} × $${item.price.toFixed(2)}</small>
                </div>
                <div>$${itemTotal.toFixed(2)}</div>
            </div>
        `;
    });
    
    summaryHTML += '</div><hr>';
    
    const shipping = subtotal >= 50 ? 0 : 5.00;
    const tax = subtotal * 0.08;
    const total = subtotal + shipping + tax;
    
    summaryHTML += `
        <div class="d-flex justify-content-between mb-2">
            <div>{{ __('Subtotal') }}:</div>
            <div>$${subtotal.toFixed(2)}</div>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <div>{{ __('Shipping') }}:</div>
            <div>${shipping === 0 ? '{{ __("Free") }}' : '$' + shipping.toFixed(2)}</div>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <div>{{ __('Tax (8%)') }}:</div>
            <div>$${tax.toFixed(2)}</div>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-0">
            <div class="fw-bold fs-5">{{ __('Total') }}:</div>
            <div class="fw-bold fs-5">$${total.toFixed(2)}</div>
        </div>
    `;
    
    if (subtotal < 50) {
        summaryHTML += '<div class="alert alert-info mt-3 mb-0"><small>{{ __("Add") }} $' + (50 - subtotal).toFixed(2) + ' {{ __("more for free shipping!") }}</small></div>';
    }
    
    document.getElementById('order-summary').innerHTML = summaryHTML;
});
</script>
@endsection


