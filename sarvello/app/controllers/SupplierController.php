<?php
/*
 * File:    SupplierController.php
 * Module:  M8 Supplier and restocking management
 * Author:  Fatima
 * Date:    2026-11-17
 * Purpose: Suppliers, product links and purchase orders.
 *
 * To build:
 *  - Register and update suppliers (contact details).
 *  - Link products to suppliers (product_suppliers table).
 *  - Create purchase orders for restocking.
 *  - Receive stock against a purchase order: creates batches with expiry dates (M3).
 *  - Track purchase order status: draft, sent, received, completed.
 */

function supplier_list(): void
{
    require_role(['admin']);
    view('placeholder', ['title' => 'Suppliers', 'module' => 'M8 Suppliers and restocking', 'owner' => 'Fatima']);
}
