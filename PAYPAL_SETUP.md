# PayPal Payment Integration Setup

## Overview
This application now includes PayPal payment integration for processing orders. Customers can checkout using PayPal, and orders are stored in the database for management in the dashboard.

## Features Implemented

### 1. Order Management System
- **Order Model**: Stores complete order information including customer details, shipping address, payment info, and order status
- **OrderItem Model**: Stores individual product items within each order
- **Soft Deletes**: Orders can be soft-deleted for record keeping

### 2. PayPal Integration
- **PayPal Checkout SDK**: Integrated for secure payment processing
- **Sandbox & Live Mode**: Supports both testing (sandbox) and production (live) environments
- **Order Tracking**: PayPal transaction IDs are stored with each order

### 3. Customer Checkout Flow
- **Cart Page** (`/pages/cart`): View cart items with quantity controls
- **Checkout Page** (`/checkout`): Enter shipping information and billing details
- **PayPal Payment**: Redirects to PayPal for secure payment
- **Order Confirmation**: Success page with order details after payment

### 4. Dashboard Order Management
- **Orders List** (`/dashboard/orders`): View all orders with filters
  - Filter by order status
  - Filter by payment status
  - Search by order number or customer
- **Order Details** (`/dashboard/orders/{id}`): 
  - View complete order information
  - Update order status
  - Update payment status
  - Add order notes
  - View PayPal transaction details

## Setup Instructions

### 1. Environment Variables

Add the following to your `.env` file:

```env
# PayPal Configuration
PAYPAL_MODE=sandbox  # Use 'sandbox' for testing, 'live' for production

# PayPal Sandbox Credentials (for testing)
PAYPAL_SANDBOX_CLIENT_ID=your_sandbox_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_sandbox_client_secret

# PayPal Live Credentials (for production)
PAYPAL_LIVE_CLIENT_ID=your_live_client_id
PAYPAL_LIVE_CLIENT_SECRET=your_live_client_secret

# Payment Currency
PAYPAL_CURRENCY=USD
```

### 2. Get PayPal API Credentials

#### For Testing (Sandbox):
1. Go to [PayPal Developer Dashboard](https://developer.paypal.com/dashboard/)
2. Log in with your PayPal account
3. Navigate to "Apps & Credentials"
4. Under "Sandbox", create a new app or use an existing one
5. Copy the **Client ID** and **Secret** 
6. Add them to your `.env` file as `PAYPAL_SANDBOX_CLIENT_ID` and `PAYPAL_SANDBOX_CLIENT_SECRET`

#### For Production (Live):
1. In the same dashboard, switch to "Live" mode
2. Create a new app for production
3. Copy the **Client ID** and **Secret**
4. Add them to your `.env` file as `PAYPAL_LIVE_CLIENT_ID` and `PAYPAL_LIVE_CLIENT_SECRET`
5. Change `PAYPAL_MODE=live` in your `.env` file

### 3. Testing with Sandbox

PayPal provides test accounts for sandbox testing:

1. Go to [Sandbox Accounts](https://developer.paypal.com/dashboard/accounts)
2. You'll see Personal (buyer) and Business (seller) test accounts
3. Use the Personal account credentials to test payments
4. Default password is usually `111111` or shown in the account details

**Test Credit Cards** (in Sandbox):
- Visa: 4032035519885281
- Mastercard: 5277696619303682
- Amex: 374244780313485

### 4. Database Setup

The migrations have already been run. The following tables were created:
- `orders`: Main orders table
- `order_items`: Order line items table

## Order Statuses

### Order Status
- **Pending**: Order placed, awaiting processing
- **Processing**: Order is being prepared
- **Shipped**: Order has been shipped
- **Delivered**: Order delivered to customer
- **Cancelled**: Order was cancelled

### Payment Status
- **Pending**: Payment not yet completed
- **Completed**: Payment successfully processed
- **Failed**: Payment failed
- **Refunded**: Payment was refunded

## Order Flow

1. Customer adds products to cart (stored in localStorage)
2. Customer clicks "Proceed to Checkout"
3. Customer fills out shipping information
4. Customer clicks "Proceed to PayPal"
5. System creates order in database with "pending" status
6. Customer is redirected to PayPal
7. Customer completes payment on PayPal
8. PayPal redirects back to success URL
9. System captures payment and updates order status to "completed"
10. Customer sees order confirmation page
11. Cart is cleared from localStorage

## Routes

### Frontend Routes
- `GET /checkout` - Checkout page
- `POST /checkout/process` - Process checkout and create PayPal order
- `GET /checkout/success` - PayPal return URL after successful payment
- `GET /checkout/cancel` - PayPal cancel URL
- `GET /checkout/confirmation/{orderNumber}` - Order confirmation page

### Dashboard Routes
- `GET /dashboard/orders` - List all orders
- `GET /dashboard/orders/{id}` - View order details
- `PUT /dashboard/orders/{id}` - Update order status
- `DELETE /dashboard/orders/{id}` - Delete order

## Important Notes

1. **Sandbox vs Live**: Always test thoroughly in sandbox mode before switching to live mode
2. **Webhooks**: For production, consider setting up PayPal webhooks for better payment tracking
3. **Security**: Never commit your `.env` file or expose API credentials
4. **Currency**: The system currently uses USD, update `PAYPAL_CURRENCY` if needed
5. **Shipping**: Free shipping is applied for orders over $50, otherwise $5 shipping fee
6. **Tax**: 8% tax is automatically calculated (can be adjusted in CheckoutController)

## Troubleshooting

### Common Issues:

1. **"No PayPal credentials found"**
   - Ensure environment variables are set correctly
   - Run `php artisan config:clear` to clear config cache

2. **Payment fails in testing**
   - Verify you're using sandbox test accounts
   - Check if `PAYPAL_MODE=sandbox` is set
   - Ensure sandbox credentials are correct

3. **Order not updating after payment**
   - Check Laravel logs in `storage/logs/laravel.log`
   - Verify PayPal return URLs are accessible
   - Ensure database connection is working

## Support

For PayPal integration issues, refer to:
- [PayPal Developer Documentation](https://developer.paypal.com/docs/)
- [PayPal Checkout SDK PHP](https://github.com/paypal/Checkout-PHP-SDK)

## Future Enhancements

Consider adding:
- Email notifications for order status changes
- Invoice generation
- Order tracking numbers
- Refund processing through dashboard
- Multiple payment methods (Stripe, etc.)
- Guest checkout optimization
- Order history for registered users


