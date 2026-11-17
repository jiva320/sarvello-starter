<?php
/*
 * File:    Category.php
 * Module:  M2 Product and category management
 * Author:  Fatima
 * Date:    2026-11-17
 * Purpose: Example model. Copy this pattern for your own tables:
 *          every query uses prepare() + execute() with ? placeholders.
 */

function category_all(): array
{
    return db()->query('SELECT category_id, name FROM categories ORDER BY name')->fetchAll();
}

function category_find(int $categoryId): ?array
{
    $stmt = db()->prepare('SELECT category_id, name FROM categories WHERE category_id = ?');
    $stmt->execute([$categoryId]);
    return $stmt->fetch() ?: null;
}

function category_create(string $name): int
{
    $stmt = db()->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);
    return (int) db()->lastInsertId();
}
