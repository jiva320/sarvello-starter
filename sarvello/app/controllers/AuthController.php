<?php
/*
 * File:    AuthController.php
 * Module:  M1 User registration and authentication
 * Author:  Jiva
 * Date:    2026-11-17
 * Purpose: Register, log in, log out, password reset, profile, role-based access.
 *
 * To build:
 *  - Register with name, email, phone, password (hash with password_hash()).
 *  - Log in with password_verify(); store user_id, full_name and role in $_SESSION['user'].
 *  - Secure log out (session_destroy()).
 *  - Password recovery by email link (password_resets table, token expires).
 *  - View and update profile.
 *  - Roles: admin, staff, customer (use require_role() from app/helpers/auth.php).
 */

function auth_login(): void
{
    view('placeholder', ['title' => 'Log in', 'module' => 'M1 Registration and authentication', 'owner' => 'Jiva']);
}

function auth_register(): void
{
    view('placeholder', ['title' => 'Register', 'module' => 'M1 Registration and authentication', 'owner' => 'Jiva']);
}

function auth_logout(): void
{
    $_SESSION = [];
    session_destroy();
    session_start();
    flash('You have been logged out.');
    redirect('home');
}
