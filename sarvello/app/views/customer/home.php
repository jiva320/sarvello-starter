<?php
/*
 * File:    home.php
 * Module:  Shared (UI lead: Fatima)
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Customer home page.
 */
?>
<div class="p-5 mb-4 bg-light rounded-3">
    <h1 class="display-6">Fresh groceries, delivered</h1>
    <p class="lead">Shop online, and save money on food that is close to its best-before date.</p>
    <a class="btn btn-success" href="<?= e(url('products')) ?>">Start shopping</a>
    <a class="btn btn-outline-success" href="<?= e(url('save-food')) ?>">Save Food, Save Money</a>
</div>
