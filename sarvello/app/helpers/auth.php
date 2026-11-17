<?php
/*
 * File:    auth.php
 * Module:  M1 Registration, authentication and roles (shared helpers)
 * Author:  Jiva
 * Date:    2026-11-17
 * Purpose: Login sessions, role checks and CSRF protection used by every module.
 */

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

// Put at the top of any page that needs a login, e.g. require_role(['admin', 'staff']);
function require_role(array $roles): void
{
    $user = current_user();
    if ($user === null) {
        flash('Please log in first.');
        redirect('login');
    }
    if (!in_array($user['role'], $roles, true)) {
        http_response_code(403);
        die('You do not have access to this page.');
    }
}

// CSRF token: put csrf_field() inside every <form method="post">, and call check_csrf() when handling it.
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function check_csrf(): void
{
    if (!hash_equals(csrf_token(), $_POST['csrf'] ?? '')) {
        http_response_code(400);
        die('Invalid form submission. Please go back and try again.');
    }
}
