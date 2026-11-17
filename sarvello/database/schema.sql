-- File:    schema.sql
-- Module:  Shared database (owner: Tommaso)
-- Date:    2026-11-17
-- Purpose: Starter tables for all modules. Tommaso finalises this from the ERD.
--          Import in phpMyAdmin, then import seed.sql.

DROP DATABASE IF EXISTS sarvello;
CREATE DATABASE sarvello CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sarvello;

-- ===== M1 Users and roles (Jiva) =====
CREATE TABLE users (
    user_id        INT AUTO_INCREMENT PRIMARY KEY,
    full_name      VARCHAR(100) NOT NULL,
    email          VARCHAR(150) NOT NULL UNIQUE,
    phone          VARCHAR(20),
    password_hash  VARCHAR(255) NOT NULL,                 -- password_hash(), never plain text
    role           ENUM('customer','staff','admin') NOT NULL DEFAULT 'customer',
    is_active      TINYINT(1) NOT NULL DEFAULT 1,
    failed_logins  INT NOT NULL DEFAULT 0,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE password_resets (
    reset_id    INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    token_hash  VARCHAR(255) NOT NULL,
    expires_at  DATETIME NOT NULL,
    used        TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE addresses (
    address_id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    street      VARCHAR(150) NOT NULL,
    suburb      VARCHAR(80) NOT NULL,
    state       VARCHAR(10) NOT NULL,
    postcode    VARCHAR(10) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- ===== M2 Products and categories (Fatima) =====
CREATE TABLE categories (
    category_id  INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(60) NOT NULL UNIQUE
);

CREATE TABLE products (
    product_id           INT AUTO_INCREMENT PRIMARY KEY,
    category_id          INT NOT NULL,
    name                 VARCHAR(120) NOT NULL,
    description          TEXT,
    price                DECIMAL(10,2) NOT NULL,
    cost_price           DECIMAL(10,2) NOT NULL DEFAULT 0,   -- used for waste loss (M7)
    image_path           VARCHAR(255),
    date_type            ENUM('use_by','best_before') NOT NULL DEFAULT 'best_before',
    low_stock_threshold  INT NOT NULL DEFAULT 10,
    is_active            TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    INDEX idx_product_name (name)
);

-- ===== M3 Inventory and batches (Tommaso) =====
CREATE TABLE product_batches (
    batch_id           INT AUTO_INCREMENT PRIMARY KEY,
    product_id         INT NOT NULL,
    batch_code         VARCHAR(50),
    quantity           INT NOT NULL,
    manufacture_date   DATE,
    expiry_date        DATE NOT NULL,
    status             ENUM('fresh','near_expiry','expired','disposed') NOT NULL DEFAULT 'fresh',
    received_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    purchase_order_id  INT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    INDEX idx_batch_expiry (expiry_date, status)
);

CREATE TABLE inventory_adjustments (
    adjustment_id    INT AUTO_INCREMENT PRIMARY KEY,
    batch_id         INT NOT NULL,
    quantity_change  INT NOT NULL,
    reason           VARCHAR(200) NOT NULL,
    staff_id         INT NOT NULL,
    adjusted_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES product_batches(batch_id),
    FOREIGN KEY (staff_id) REFERENCES users(user_id)
);

-- ===== M4 Expiry settings and alerts (Beatriz) =====
CREATE TABLE settings (
    setting_key    VARCHAR(50) PRIMARY KEY,
    setting_value  VARCHAR(255) NOT NULL
);

CREATE TABLE alerts (
    alert_id    INT AUTO_INCREMENT PRIMARY KEY,
    type        ENUM('near_expiry','expired','low_stock','system_error') NOT NULL,
    batch_id    INT NULL,
    product_id  INT NULL,
    message     VARCHAR(255) NOT NULL,
    is_read     TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ===== M5 Promotions (Beatriz) =====
CREATE TABLE promotions (
    promotion_id      INT AUTO_INCREMENT PRIMARY KEY,
    batch_id          INT NOT NULL,
    discount_percent  DECIMAL(5,2) NOT NULL,
    start_date        DATE NOT NULL,
    end_date          DATE NOT NULL,
    approved_by       INT NOT NULL,
    status            ENUM('active','ended','cancelled') NOT NULL DEFAULT 'active',
    FOREIGN KEY (batch_id) REFERENCES product_batches(batch_id),
    FOREIGN KEY (approved_by) REFERENCES users(user_id)
);

-- ===== M6 Cart and orders (Tommaso) =====
CREATE TABLE cart_items (
    cart_item_id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT NOT NULL,
    product_id    INT NOT NULL,
    quantity      INT NOT NULL,
    added_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE orders (
    order_id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT NOT NULL,
    address_id       INT NULL,
    subtotal         DECIMAL(10,2) NOT NULL,
    discount_total   DECIMAL(10,2) NOT NULL DEFAULT 0,
    delivery_charge  DECIMAL(10,2) NOT NULL DEFAULT 0,
    total            DECIMAL(10,2) NOT NULL,
    status           ENUM('placed','packed','out_for_delivery','delivered','cancelled') NOT NULL DEFAULT 'placed',
    placed_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (address_id) REFERENCES addresses(address_id)
);

CREATE TABLE order_items (
    order_item_id  INT AUTO_INCREMENT PRIMARY KEY,
    order_id       INT NOT NULL,
    batch_id       INT NOT NULL,
    quantity       INT NOT NULL,
    unit_price     DECIMAL(10,2) NOT NULL,      -- price actually charged (after discount)
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (batch_id) REFERENCES product_batches(batch_id)
);

-- ===== M7 Waste (Member 5) =====
CREATE TABLE waste_records (
    waste_id         INT AUTO_INCREMENT PRIMARY KEY,
    batch_id         INT NOT NULL,
    quantity         INT NOT NULL,
    reason           ENUM('expired','damaged','unsellable','other') NOT NULL,
    disposal_method  ENUM('landfill','compost','donation','return_to_supplier','other') NOT NULL,
    loss_value       DECIMAL(10,2) NOT NULL,     -- quantity x cost_price
    disposed_on      DATE NOT NULL,
    staff_id         INT NOT NULL,
    notes            VARCHAR(255),
    FOREIGN KEY (batch_id) REFERENCES product_batches(batch_id),
    FOREIGN KEY (staff_id) REFERENCES users(user_id)
);

-- ===== M8 Suppliers and purchase orders (Fatima) =====
CREATE TABLE suppliers (
    supplier_id   INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(120) NOT NULL,
    contact_name  VARCHAR(100),
    email         VARCHAR(150),
    phone         VARCHAR(20),
    is_active     TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE product_suppliers (
    product_id   INT NOT NULL,
    supplier_id  INT NOT NULL,
    PRIMARY KEY (product_id, supplier_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
);

CREATE TABLE purchase_orders (
    purchase_order_id  INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id        INT NOT NULL,
    status             ENUM('draft','sent','received','completed','cancelled') NOT NULL DEFAULT 'draft',
    created_by         INT NOT NULL,
    created_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

CREATE TABLE purchase_order_items (
    po_item_id         INT AUTO_INCREMENT PRIMARY KEY,
    purchase_order_id  INT NOT NULL,
    product_id         INT NOT NULL,
    quantity_ordered   INT NOT NULL,
    quantity_received  INT NOT NULL DEFAULT 0,
    FOREIGN KEY (purchase_order_id) REFERENCES purchase_orders(purchase_order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

ALTER TABLE product_batches
    ADD FOREIGN KEY (purchase_order_id) REFERENCES purchase_orders(purchase_order_id);

-- ===== Shared: audit log (who changed what) =====
CREATE TABLE audit_log (
    log_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NULL,
    action     VARCHAR(100) NOT NULL,
    details    VARCHAR(255),
    logged_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
