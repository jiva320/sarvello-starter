# Sarvello Fine Foods – Online Food Expiry and Waste Reduction System

CPRO306 Capstone Project, Project 16. A 3-tier PHP and MySQL web application that runs on XAMPP.

## Run it on your laptop

1. Install XAMPP and start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Clone this repo into `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac), so you have `htdocs/sarvello`.
3. Open phpMyAdmin (http://localhost/phpmyadmin), click **Import**, and import `database/schema.sql`, then `database/seed.sql`.
4. Copy `config/config.sample.php` to `config/config.php`. Leave the database settings as they are unless your MySQL has a password.
5. Open http://localhost/sarvello/public/ in your browser.

`config/config.php` is in `.gitignore` because it will hold the OpenAI key. **Never commit it.**

## Folder layout

```
config/            database connection and settings (config.php is never committed)
public/            the only folder the browser opens: index.php and assets (css, js, img)
app/controllers/   one file per module: the logic for each page
app/models/        code that reads and writes database tables
app/views/         the HTML pages: customer/, staff/, admin/, partials/ (header, footer)
app/helpers/       shared code: login sessions, roles, security, small functions
database/          schema.sql (tables), seed.sql (sample data), changes/ (schema changes)
docs/              logbook, contribution tracker, diagrams, assessment drafts
tests/             test cases and result screenshots, one folder per module
```

## Who owns what

| Module | Files | Owner |
| --- | --- | --- |
| M1 Registration, login, roles | `AuthController.php`, `views/*/auth*` | Jiva |
| M2 Products and categories | `ProductController.php` | Fatima |
| M3 Inventory and batches | `BatchController.php` | Tommaso |
| M4 Expiry monitoring and alerts | `ExpiryController.php` | Beatriz |
| M5 Discounts and promotions | `PromotionController.php` | Beatriz |
| M6 Shopping cart and orders | `OrderController.php` | Tommaso |
| M7 Waste and disposal | `WasteController.php` | Member 5 |
| M8 Suppliers and restocking | `SupplierController.php` | Fatima |
| M9 Reports and dashboard | `ReportController.php` | Member 5 |
| AI feature (OpenAI) | `AiController.php` | Beatriz |
| Database schema | `database/schema.sql` | Tommaso (only he edits it) |

Shared files (`config/`, `app/helpers/`, `app/views/partials/`, `public/index.php`): ask in the group chat before changing.

## How we use Git

1. Pull before you start: `git pull origin main`
2. Work on your own branch, named after your module: `git checkout -b m4-expiry`
3. Commit at least twice a week with a clear message: `M4: add days-to-expiry calculation`
4. Push your branch and open a pull request. Another member reviews it before it is merged into `main`.
5. Commit whatever you have at the end of every iteration, finished or not. Commits are how individual work is marked.
6. Need a database change? Write it as a new file in `database/changes/` and tell Tommaso.

## Coding standards (marked in A6)

Every PHP file starts with this header:

```php
/*
 * File:    BatchController.php
 * Module:  M3 Inventory and batch management
 * Author:  Tommaso
 * Date:    2026-11-24
 * Purpose: Record incoming stock batches and update quantities.
 */
```

- Indent with 4 spaces; leave a blank line between functions.
- Clear names: `$expiryDate`, not `$d`. No global variables.
- Always use prepared statements (see `app/models/`), never put user input straight into SQL.
- Always print user data with `e()` to stop script injection.
- Comment anything that is not obvious.
