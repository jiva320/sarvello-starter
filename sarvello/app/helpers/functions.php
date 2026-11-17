<?php
/*
 * File:    functions.php
 * Module:  Shared
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Small helpers used on every page.
 */

// Print user data safely (stops script injection). Use it for every value you echo.
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Build a link to a page, e.g. url('products') -> /sarvello/public/?page=products
function url(string $page, array $params = []): string
{
    $params = array_merge(['page' => $page], $params);
    return config('base_url') . '/?' . http_build_query($params);
}

function redirect(string $page, array $params = []): void
{
    header('Location: ' . url($page, $params));
    exit;
}

// Show a page from app/views, passing variables to it.
function view(string $name, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../views/partials/header.php';
    require __DIR__ . '/../views/' . $name . '.php';
    require __DIR__ . '/../views/partials/footer.php';
}

// One-time message shown at the top of the next page ("Product saved").
function flash(?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'] = $message;
        return null;
    }
    $msg = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $msg;
}

// Write an entry to the audit log (who changed what).
function audit(string $action, string $details = ''): void
{
    $stmt = db()->prepare('INSERT INTO audit_log (user_id, action, details) VALUES (?, ?, ?)');
    $stmt->execute([current_user()['user_id'] ?? null, $action, $details]);
}
