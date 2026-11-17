<?php
/*
 * File:    WasteController.php
 * Module:  M7 Food waste and disposal management
 * Author:  Member 5
 * Date:    2026-11-17
 * Purpose: Record disposed food, reasons, losses and wastage summaries.
 *
 * To build:
 *  - Record expired, damaged and unsellable items against their batch.
 *  - Category of waste and disposal reason.
 *  - Quantity and estimated loss (quantity x cost price).
 *  - Disposal date, method and responsible staff.
 *  - Summaries by category and period; history to spot recurring waste.
 *  - Records can be corrected with a reason, never deleted.
 */

function waste_list(): void
{
    require_role(['staff', 'admin']);
    view('placeholder', ['title' => 'Food waste', 'module' => 'M7 Waste and disposal', 'owner' => 'Member 5']);
}
