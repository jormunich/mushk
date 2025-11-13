// Cart Management with localStorage
const Cart = {
    // Get cart items from localStorage
    getCart: function() {
        const cart = localStorage.getItem('shopping_cart');
        return cart ? JSON.parse(cart) : [];
    },

    // Save cart to localStorage
    saveCart: function(cart) {
        localStorage.setItem('shopping_cart', JSON.stringify(cart));
        this.updateCartUI();
    },

    // Add item to cart
    addItem: function(product) {
        let cart = this.getCart();
        const existingItemIndex = cart.findIndex(item => item.id === product.id);

        if (existingItemIndex > -1) {
            // Item exists, update quantity
            cart[existingItemIndex].quantity += product.quantity;
        } else {
            // New item
            cart.push(product);
        }

        this.saveCart(cart);
        this.showNotification('Product added to cart!', 'success');
    },

    // Remove item from cart
    removeItem: function(productId) {
        let cart = this.getCart();
        cart = cart.filter(item => item.id !== productId);
        this.saveCart(cart);
        this.showNotification('Product removed from cart', 'info');
    },

    // Update item quantity
    updateQuantity: function(productId, quantity) {
        let cart = this.getCart();
        const itemIndex = cart.findIndex(item => item.id === productId);

        if (itemIndex > -1) {
            if (quantity <= 0) {
                this.removeItem(productId);
            } else {
                cart[itemIndex].quantity = quantity;
                this.saveCart(cart);
            }
        }
    },

    // Get cart total
    getTotal: function() {
        const cart = this.getCart();
        return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    },

    // Get cart count
    getCount: function() {
        const cart = this.getCart();
        return cart.reduce((count, item) => count + item.quantity, 0);
    },

    // Clear cart
    clearCart: function() {
        localStorage.removeItem('shopping_cart');
        this.updateCartUI();
        this.showNotification('Cart cleared', 'info');
    },

    // Update cart UI
    updateCartUI: function() {
        const cart = this.getCart();
        const count = this.getCount();
        const total = this.getTotal();

        // Update cart count badge
        const cartBadge = document.getElementById('cart-count');
        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }

        // Update offcanvas cart
        const cartOffcanvasBody = document.querySelector('#offcanvasCart .offcanvas-body');
        if (cartOffcanvasBody) {
            this.renderCart(cartOffcanvasBody, cart, total);
        }
    },

    // Render cart items
    renderCart: function(container, cart, total) {
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <svg width="64" height="64" class="text-muted mb-3"><use xlink:href="#shopping-bag"></use></svg>
                    <h5 class="text-muted">Your cart is empty</h5>
                    <p class="text-muted">Add some products to get started!</p>
                    <a href="${window.location.origin}/products" class="btn btn-primary">Browse Products</a>
                </div>
            `;
            return;
        }

        let cartHTML = `
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill">${this.getCount()}</span>
                </h4>
                <ul class="list-group mb-3" id="cart-items">
        `;

        cart.forEach(item => {
            cartHTML += `
                <li class="list-group-item" data-product-id="${item.id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.name}</h6>
                                <small class="text-muted">$${item.price.toFixed(2)} each</small>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="Cart.updateQuantity(${item.id}, ${item.quantity - 1})">
                                        <svg width="12" height="12"><use xlink:href="#minus"></use></svg>
                                    </button>
                                    <span class="fw-bold">${item.quantity}</span>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="Cart.updateQuantity(${item.id}, ${item.quantity + 1})">
                                        <svg width="12" height="12"><use xlink:href="#plus"></use></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold mb-2">$${(item.price * item.quantity).toFixed(2)}</div>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Cart.removeItem(${item.id})" title="Remove">
                                <svg width="16" height="16"><use xlink:href="#trash"></use></svg>
                            </button>
                        </div>
                    </div>
                </li>
            `;
        });

        cartHTML += `
                </ul>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Total (USD)</span>
                    <strong>$${total.toFixed(2)}</strong>
                </li>
                <div class="d-grid gap-2 mt-3">
                    <a href="/pages/cart" class="btn btn-outline-primary">View Full Cart</a>
                    <button class="btn btn-primary btn-lg" onclick="Cart.checkout()">Continue to checkout</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="Cart.clearCart()">Clear Cart</button>
                </div>
            </div>
        `;

        container.innerHTML = cartHTML;
    },

    // Show notification
    showNotification: function(message, type = 'success') {
        // Create toast notification
        const toastHTML = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        const toastContainer = document.createElement('div');
        toastContainer.innerHTML = toastHTML;
        document.body.appendChild(toastContainer);

        const toastElement = toastContainer.querySelector('.toast');
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();

        toastElement.addEventListener('hidden.bs.toast', function () {
            toastContainer.remove();
        });
    },

    // Checkout function
    checkout: function() {
        const cart = this.getCart();
        if (cart.length === 0) {
            this.showNotification('Your cart is empty!', 'error');
            return;
        }

        // Redirect to checkout page
        window.location.href = '/checkout';
    }
};

// Add to cart from product page
function addToCart(event) {
    event.preventDefault();

    const productElement = event.target.closest('[data-product-id]') || document.querySelector('[data-product-id]');
    
    if (!productElement) {
        console.error('Product element not found');
        return;
    }

    const quantityInput = document.getElementById('quantity') || document.querySelector('input[name="quantity"]');
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

    const product = {
        id: parseInt(productElement.getAttribute('data-product-id')),
        name: productElement.getAttribute('data-product-name'),
        price: parseFloat(productElement.getAttribute('data-product-price')),
        image: productElement.getAttribute('data-product-image'),
        quantity: quantity
    };

    Cart.addItem(product);
}

// Quantity controls for product page
function increaseQuantity() {
    const input = document.getElementById('quantity');
    if (input) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    if (input && parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    Cart.updateCartUI();

    // Add event listeners to all add to cart buttons on product listing pages
    document.querySelectorAll('.btn-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productItem = this.closest('.product-item');
            if (!productItem) return;

            const quantityInput = productItem.querySelector('input[name="quantity"]');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            // Get product data from data attributes
            const product = {
                id: parseInt(productItem.getAttribute('data-product-id')),
                name: productItem.getAttribute('data-product-name'),
                price: parseFloat(productItem.getAttribute('data-product-price')),
                image: productItem.getAttribute('data-product-image'),
                quantity: quantity
            };

            Cart.addItem(product);
        });
    });
});

