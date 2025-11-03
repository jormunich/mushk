// Favorites/Wishlist Management with localStorage
const Favorites = {
    // Get favorites from localStorage
    getFavorites: function() {
        const favorites = localStorage.getItem('wishlist');
        return favorites ? JSON.parse(favorites) : [];
    },

    // Save favorites to localStorage
    saveFavorites: function(favorites) {
        localStorage.setItem('wishlist', JSON.stringify(favorites));
        this.updateFavoritesUI();
    },

    // Check if product is in favorites
    isFavorite: function(productId) {
        const favorites = this.getFavorites();
        return favorites.some(item => item.id === productId);
    },

    // Toggle favorite (add or remove)
    toggleFavorite: function(product) {
        let favorites = this.getFavorites();
        const existingIndex = favorites.findIndex(item => item.id === product.id);

        if (existingIndex > -1) {
            // Remove from favorites
            favorites.splice(existingIndex, 1);
            this.saveFavorites(favorites);
            this.showNotification('Removed from favorites', 'info');
            return false;
        } else {
            // Add to favorites
            favorites.push(product);
            this.saveFavorites(favorites);
            this.showNotification('Added to favorites!', 'success');
            return true;
        }
    },

    // Remove item from favorites
    removeItem: function(productId) {
        let favorites = this.getFavorites();
        favorites = favorites.filter(item => item.id !== productId);
        this.saveFavorites(favorites);
        this.showNotification('Removed from favorites', 'info');
    },

    // Get favorites count
    getCount: function() {
        return this.getFavorites().length;
    },

    // Clear all favorites
    clearFavorites: function() {
        localStorage.removeItem('wishlist');
        this.updateFavoritesUI();
        this.showNotification('All favorites cleared', 'info');
    },

    // Update favorites UI
    updateFavoritesUI: function() {
        const favorites = this.getFavorites();
        const count = this.getCount();

        // Update favorites count badge
        const favoritesBadge = document.getElementById('favorites-count');
        if (favoritesBadge) {
            favoritesBadge.textContent = count;
            favoritesBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }

        // Update all favorite buttons
        document.querySelectorAll('[data-favorite-id]').forEach(button => {
            const productId = parseInt(button.getAttribute('data-favorite-id'));
            const isFav = this.isFavorite(productId);
            
            if (isFav) {
                button.classList.add('active', 'text-danger');
                button.classList.remove('btn-outline-dark');
                const svg = button.querySelector('svg');
                if (svg) {
                    svg.innerHTML = '<use xlink:href="#heart-filled"></use>';
                }
            } else {
                button.classList.remove('active', 'text-danger');
                button.classList.add('btn-outline-dark');
                const svg = button.querySelector('svg');
                if (svg) {
                    svg.innerHTML = '<use xlink:href="#heart"></use>';
                }
            }
        });

        // Update offcanvas favorites if open
        const favoritesOffcanvasBody = document.querySelector('#offcanvasFavorites .offcanvas-body');
        if (favoritesOffcanvasBody) {
            this.renderFavorites(favoritesOffcanvasBody, favorites);
        }
    },

    // Render favorites items
    renderFavorites: function(container, favorites) {
        if (favorites.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <svg width="64" height="64" class="text-muted mb-3"><use xlink:href="#heart"></use></svg>
                    <h5 class="text-muted">Your favorites is empty</h5>
                    <p class="text-muted">Add products you love to keep track of them!</p>
                    <a href="${window.location.origin}/products" class="btn btn-primary">Browse Products</a>
                </div>
            `;
            return;
        }

        let favoritesHTML = `
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-danger">Your Favorites</span>
                    <span class="badge bg-danger rounded-pill">${this.getCount()}</span>
                </h4>
                <ul class="list-group mb-3" id="favorites-items">
        `;

        favorites.forEach(item => {
            favoritesHTML += `
                <li class="list-group-item" data-product-id="${item.id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="/products/${item.id}" class="text-decoration-none text-dark">${item.name}</a>
                                </h6>
                                <div class="fw-bold text-primary">$${item.price.toFixed(2)}</div>
                            </div>
                        </div>
                        <div class="text-end d-flex gap-2">
                            <button class="btn btn-sm btn-primary" onclick="addToCartFromFavorites(${item.id})" title="Add to Cart">
                                <svg width="16" height="16"><use xlink:href="#cart"></use></svg>
                            </button>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="Favorites.removeItem(${item.id}); Favorites.renderFavoritesPage();" title="Remove">
                                <svg width="16" height="16"><use xlink:href="#trash"></use></svg>
                            </button>
                        </div>
                    </div>
                </li>
            `;
        });

        favoritesHTML += `
                </ul>
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-outline-danger btn-sm" onclick="Favorites.clearFavorites()">Clear All</button>
                </div>
            </div>
        `;

        container.innerHTML = favoritesHTML;
    },

    // Show notification
    showNotification: function(message, type = 'success') {
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
    }
};

// Toggle favorite from any button
function toggleFavorite(event, productId) {
    event.preventDefault();
    event.stopPropagation();

    const button = event.currentTarget;
    const productElement = button.closest('[data-product-id]');
    
    if (!productElement) {
        console.error('Product element not found');
        return;
    }

    const product = {
        id: parseInt(productElement.getAttribute('data-product-id')),
        name: productElement.getAttribute('data-product-name'),
        price: parseFloat(productElement.getAttribute('data-product-price')),
        image: productElement.getAttribute('data-product-image')
    };

    Favorites.toggleFavorite(product);
}

// Add to cart from favorites
function addToCartFromFavorites(productId) {
    const favorites = Favorites.getFavorites();
    const item = favorites.find(f => f.id === productId);
    
    if (item && typeof Cart !== 'undefined') {
        Cart.addItem({
            ...item,
            quantity: 1
        });
    }
}

// Initialize favorites on page load
document.addEventListener('DOMContentLoaded', function() {
    Favorites.updateFavoritesUI();

    // Add event listeners to favorite buttons
    document.querySelectorAll('[data-favorite-id]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = parseInt(this.getAttribute('data-favorite-id'));
            const productElement = this.closest('[data-product-id]');
            
            if (!productElement) return;

            const product = {
                id: productId,
                name: productElement.getAttribute('data-product-name'),
                price: parseFloat(productElement.getAttribute('data-product-price')),
                image: productElement.getAttribute('data-product-image')
            };

            Favorites.toggleFavorite(product);
        });
    });
});

