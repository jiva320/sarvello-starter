-- File:    seed.sql
-- Module:  Shared sample data (owner: Tommaso)
-- Date:    2026-11-17
-- Purpose: Sample data so every module has something to work with. Import after schema.sql.
--          Test logins are added later by the M1 owner through the Register page.

USE sarvello;

INSERT INTO categories (name) VALUES ('Dairy'), ('Meat'), ('Vegetables'), ('Fruits'), ('Bakery');

INSERT INTO settings (setting_key, setting_value) VALUES
    ('near_expiry_days', '5'),
    ('delivery_charge', '7.50');

INSERT INTO products (category_id, name, description, price, cost_price, date_type, low_stock_threshold) VALUES
    (1, 'Full-cream milk 2L', 'Fresh Australian full-cream milk', 3.80, 2.40, 'use_by', 20),
    (1, 'Greek yoghurt 1kg', 'Natural Greek-style yoghurt', 6.50, 4.10, 'use_by', 10),
    (2, 'Chicken breast 500g', 'Free-range chicken breast fillets', 9.00, 6.20, 'use_by', 10),
    (3, 'Baby spinach 120g', 'Washed baby spinach leaves', 3.50, 1.90, 'best_before', 15),
    (4, 'Bananas 1kg', 'Cavendish bananas', 3.90, 2.00, 'best_before', 15),
    (5, 'Sourdough loaf', 'Baked fresh daily', 6.00, 2.80, 'best_before', 8);

-- Batches relative to today, so the expiry statuses always make sense when testing.
INSERT INTO product_batches (product_id, batch_code, quantity, manufacture_date, expiry_date, status) VALUES
    (1, 'MLK-A', 30, CURDATE() - INTERVAL 3 DAY, CURDATE() + INTERVAL 7 DAY, 'fresh'),
    (1, 'MLK-B', 12, CURDATE() - INTERVAL 8 DAY, CURDATE() + INTERVAL 2 DAY, 'near_expiry'),
    (2, 'YOG-A', 15, CURDATE() - INTERVAL 10 DAY, CURDATE() + INTERVAL 4 DAY, 'near_expiry'),
    (3, 'CHK-A', 20, CURDATE() - INTERVAL 1 DAY, CURDATE() + INTERVAL 5 DAY, 'near_expiry'),
    (4, 'SPN-A', 25, CURDATE() - INTERVAL 2 DAY, CURDATE() + INTERVAL 6 DAY, 'fresh'),
    (5, 'BAN-A', 40, CURDATE() - INTERVAL 4 DAY, CURDATE() + INTERVAL 3 DAY, 'near_expiry'),
    (6, 'SDG-A', 10, CURDATE() - INTERVAL 2 DAY, CURDATE() - INTERVAL 1 DAY, 'expired');

INSERT INTO suppliers (name, contact_name, email, phone) VALUES
    ('Green Valley Dairy', 'Sam Lee', 'orders@greenvalley.test', '02 9000 1111'),
    ('Harbour Bakery Co', 'Mia Chen', 'sales@harbourbakery.test', '02 9000 2222');

INSERT INTO product_suppliers (product_id, supplier_id) VALUES (1, 1), (2, 1), (6, 2);
