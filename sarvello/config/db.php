<?php
/*
 * File:    db.php
 * Module:  Shared
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: One shared database connection (PDO) for the whole system.
 */

function config(string $key)
{
    static $settings = null;
    if ($settings === null) {
        $file = __DIR__ . '/config.php';
        if (!file_exists($file)) {
            die('Missing config/config.php. Copy config.sample.php to config.php first.');
        }
        $settings = require $file;
    }
    return $settings[$key] ?? null;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . config('db_host') . ';dbname=' . config('db_name') . ';charset=utf8mb4';
        $pdo = new PDO($dsn, config('db_user'), config('db_pass'), [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
