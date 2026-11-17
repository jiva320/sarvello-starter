<?php
/*
 * File:    OrderController.php
 * Module:  M6 Online shopping and order management
 * Author:  Tommaso
 * Date:    2026-11-17
 * Purpose: Cart, checkout, order history and tracking.
 *
 * To build:
 *  - Add to cart, change quantity, remove item (cart_items table).
 *  - Total = items (with discounts) + delivery charge.
 *  - Secure checkout (logged-in customer, CSRF token, one database transaction).
 *  - On order: reduce batch stock earliest expiry first (calls M3 code).
 *  - Order history and status tracking (placed, packed, out for delivery, delivered).
 */

function order_cart(): void
{
    view('placeholder', ['title' => 'Your cart', 'module' => 'M6 Shopping and orders', 'owner' => 'Tommaso']);
}
