<?php
/*
 * File:    ProductController.php
 * Module:  M2 Product and category management
 * Author:  Fatima
 * Date:    2026-11-17
 * Purpose: Product catalogue, categories, search and filters.
 *
 * To build:
 *  - Add products (name, description, price, image) - admin only.
 *  - Edit products; deactivate or remove from the catalogue.
 *  - Categories: dairy, meat, vegetables, fruits, bakery (see seed.sql).
 *  - Search by name or keyword.
 *  - Filter by category, price range and availability.
 *  Follow Reading 2 (search) and Reading 3 (CRUD) from the student resources.
 */

function product_list(): void
{
    // Example of reading from the database through a model:
    $categories = category_all();
    view('placeholder', ['title' => 'Shop (' . count($categories) . ' categories loaded)', 'module' => 'M2 Products and categories', 'owner' => 'Fatima']);
}
