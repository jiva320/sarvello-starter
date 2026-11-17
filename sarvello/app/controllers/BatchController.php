<?php
/*
 * File:    BatchController.php
 * Module:  M3 Inventory and batch management
 * Author:  Tommaso
 * Date:    2026-11-17
 * Purpose: Stock in batches, quantities, low-stock alerts and adjustments.
 *
 * To build:
 *  - Record incoming stock as a batch (product, quantity, manufacture date, expiry date).
 *  - Track available quantity per product (sum of its batches).
 *  - Several batches per product, each with its own expiry date.
 *  - Reduce batch quantities automatically when an order is fulfilled (earliest expiry first).
 *  - Low-stock notification when quantity falls below products.low_stock_threshold.
 *  - Adjust quantities with a reason and the staff member (inventory_adjustments table).
 */

function batch_list(): void
{
    require_role(['staff', 'admin']);
    view('placeholder', ['title' => 'Stock batches', 'module' => 'M3 Inventory and batches', 'owner' => 'Tommaso']);
}
