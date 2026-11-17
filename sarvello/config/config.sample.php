<?php
/*
 * File:    config.sample.php
 * Module:  Shared
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Settings template. Copy to config.php (which is never committed) and fill in.
 */

return [
    // XAMPP defaults: user "root", no password.
    'db_host' => 'localhost',
    'db_name' => 'sarvello',
    'db_user' => 'root',
    'db_pass' => '',

    // Base URL of the public folder, used for links.
    'base_url' => '/sarvello/public',

    // OpenAI key for the AI feature. Keep it here only, never in code or Git.
    'openai_key'   => '',
    'openai_model' => 'gpt-4o-mini',

    // Default number of days before expiry that counts as "near-expiry" (M4).
    'near_expiry_days' => 5,

    // Email settings for alerts and password reset (PHPMailer, M1 and M4).
    'mail_from' => 'no-reply@sarvello.test',
];
