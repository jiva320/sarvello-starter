<?php
/*
 * File:    index.php
 * Module:  Shared (front controller)
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Every page goes through here: index.php?page=products runs the products page.
 *          To add a page, add one line to $routes and write the function in your controller.
 */

session_start();

require __DIR__ . '/../config/db.php';
require __DIR__ . '/../app/helpers/functions.php';
require __DIR__ . '/../app/helpers/auth.php';

foreach (glob(__DIR__ . '/../app/models/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/../app/controllers/*.php') as $file) {
    require_once $file;
}

// page name => function that handles it
$routes = [
    'home'        => 'home_page',            // shared
    // M1 Jiva
    'login'       => 'auth_login',
    'register'    => 'auth_register',
    'logout'      => 'auth_logout',
    // M2 Fatima
    'products'    => 'product_list',
    // M3 Tommaso
    'batches'     => 'batch_list',
    // M4 Beatriz
    'expiry'      => 'expiry_dashboard',
    // M5 Beatriz
    'save-food'   => 'promotion_save_food',
    // M6 Tommaso
    'cart'        => 'order_cart',
    // M7 Member 5
    'waste'       => 'waste_list',
    // M8 Fatima
    'suppliers'   => 'supplier_list',
    // M9 Member 5
    'dashboard'   => 'report_dashboard',
    // AI Beatriz
    'recipes'     => 'ai_recipes',
];

$page = $_GET['page'] ?? 'home';
$handler = $routes[$page] ?? null;

if ($handler === null || !function_exists($handler)) {
    http_response_code(404);
    view('placeholder', ['title' => 'Page not found', 'owner' => '', 'module' => '']);
    exit;
}

$handler();

function home_page(): void
{
    view('customer/home', ['title' => 'Sarvello Fine Foods']);
}
