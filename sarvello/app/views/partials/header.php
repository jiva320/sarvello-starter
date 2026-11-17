<?php
/*
 * File:    header.php
 * Module:  Shared (UI lead: Fatima)
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Top of every page: Bootstrap, site style and the navigation bar.
 */
$user = current_user();
$role = $user['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Sarvello Fine Foods') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= e(config('base_url')) ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="<?= e(url('home')) ?>">Sarvello Fine Foods</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= e(url('products')) ?>">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('save-food')) ?>">Save Food, Save Money</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('cart')) ?>">Cart</a></li>
                <?php if (in_array($role, ['staff', 'admin'], true)): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('batches')) ?>">Stock</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('expiry')) ?>">Expiry</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('waste')) ?>">Waste</a></li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('suppliers')) ?>">Suppliers</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('dashboard')) ?>">Dashboard</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($user): ?>
                    <li class="nav-item"><span class="navbar-text me-3"><?= e($user['full_name']) ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('logout')) ?>">Log out</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('login')) ?>">Log in</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= e(url('register')) ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if ($msg = flash()): ?>
    <div class="alert alert-info"><?= e($msg) ?></div>
<?php endif; ?>
