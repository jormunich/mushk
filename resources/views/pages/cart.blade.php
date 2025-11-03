@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container-lg">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Shopping Cart') }}</li>
            </ol>
        </nav>

        <h1 class="h2 mb-4">{{ __('Shopping Cart') }}</h1>

        <div id="cart-page-content">
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    renderCartPage();
});

function renderCartPage() {
    const cart = Cart.getCart();
    const total = Cart.getTotal();
    const container = document.getElementById('cart-page-content');

    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <svg width="120" height="120" class="text-muted mb-4"><use xlink:href="#shopping-bag"></use></svg>
                <h3 class="text-muted mb-3">{{ __('Your cart is empty') }}</h3>
                <p class="text-muted mb-4">{{ __('Add some products to get started!') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">{{ __('Browse Products') }}</a>
            </div>
        `;
        return;
    }

    let cartHTML = `
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{ __('Cart Items') }}</h5>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
    `;

    cart.forEach(item => {
        cartHTML += `
            <tr data-product-id="${item.id}">
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <img src="${item.image}" alt="${item.name}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        <div>
                            <h6 class="mb-0">${item.name}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <strong>$${item.price.toFixed(2)}</strong>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="Cart.updateQuantity(${item.id}, ${item.quantity - 1}); renderCartPage();">
                            <svg width="12" height="12"><use xlink:href="#minus"></use></svg>
                        </button>
                        <span class="fw-bold px-3">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="Cart.updateQuantity(${item.id}, ${item.quantity + 1}); renderCartPage();">
                            <svg width="12" height="12"><use xlink:href="#plus"></use></svg>
                        </button>
                    </div>
                </td>
                <td>
                    <strong class="text-primary">$${(item.price * item.quantity).toFixed(2)}</strong>
                </td>
                <td>
                    <button class="btn btn-sm btn-link text-danger" onclick="Cart.removeItem(${item.id}); renderCartPage();" title="{{ __('Remove') }}">
                        <svg width="20" height="20"><use xlink:href="#trash"></use></svg>
                    </button>
                </td>
            </tr>
        `;
    });

    cartHTML += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <svg width="16" height="16" class="me-2"><use xlink:href="#arrow-left"></use></svg>
                        {{ __('Continue Shopping') }}
                    </a>
                    <button class="btn btn-outline-danger ms-2" onclick="if(confirm('{{ __('Are you sure you want to clear your cart?') }}')) { Cart.clearCart(); renderCartPage(); }">
                        {{ __('Clear Cart') }}
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{ __('Order Summary') }}</h5>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('Subtotal') }}</span>
                                <strong>$${total.toFixed(2)}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('Shipping') }}</span>
                                <strong>{{ __('Calculated at checkout') }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>{{ __('Total') }}</strong>
                                <strong class="text-primary h5 mb-0">$${total.toFixed(2)}</strong>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" onclick="Cart.checkout()">
                                {{ __('Proceed to Checkout') }}
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">{{ __('Secure checkout') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.innerHTML = cartHTML;
}
</script>

@endsection

