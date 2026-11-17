<?php
/*
 * File:    AiController.php
 * Module:  AI feature (OpenAI API), required for Assessment 5
 * Author:  Beatriz
 * Date:    2026-11-17
 * Purpose: Recipe suggestions built from near-expiry products.
 *
 * To build:
 *  - Get product names in the Save Food section (product names only, no customer data).
 *  - Send them to the OpenAI API with cURL, using config('openai_key').
 *  - Show the suggestions, labelled as AI-generated.
 *  - If the API fails or the key is empty, show a friendly message; the shop keeps working.
 */

function ai_recipes(): void
{
    view('placeholder', ['title' => 'Recipe ideas', 'module' => 'AI feature', 'owner' => 'Beatriz']);
}
