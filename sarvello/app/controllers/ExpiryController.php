<?php
/*
 * File:    ExpiryController.php
 * Module:  M4 Food expiry monitoring and alerts
 * Author:  Beatriz
 * Date:    2026-11-17
 * Purpose: Days to expiry, batch status, alerts and blocking expired stock.
 *
 * To build:
 *  - Days remaining = DATEDIFF(expiry_date, CURDATE()).
 *  - Status: fresh / near_expiry / expired / disposed (product_batches.status).
 *  - Alerts for batches inside the threshold (3, 5 or 7 days, settings table).
 *  - Let admin change the threshold.
 *  - Block expired batches from sale (status = 'expired' is never sold).
 *  - Daily check: a script run by Windows Task Scheduler or cron (expiry_check()).
 */

function expiry_dashboard(): void
{
    require_role(['staff', 'admin']);
    view('placeholder', ['title' => 'Expiry monitoring', 'module' => 'M4 Expiry monitoring', 'owner' => 'Beatriz']);
}
