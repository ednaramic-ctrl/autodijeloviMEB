CREATE DATABASE IF NOT EXISTS autodijelovi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE autodijelovi;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role VARCHAR(30) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB;
CREATE TABLE categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 description TEXT
) ENGINE=InnoDB;
CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 description TEXT,
 price DECIMAL(10,2) NOT NULL,
 stock INT NOT NULL DEFAULT 0,
 category_id INT NOT NULL,
 CONSTRAINT fk_products_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
 CONSTRAINT chk_products_price CHECK (price >= 0),
 CONSTRAINT chk_products_stock CHECK (stock >= 0)
) ENGINE=InnoDB;
CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 total DECIMAL(10,2) NOT NULL DEFAULT 0,
 CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
 CONSTRAINT chk_orders_total CHECK (total >= 0)
) ENGINE=InnoDB;
CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 product_id INT NOT NULL,
 quantity INT NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_order_items_orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
 CONSTRAINT fk_order_items_products FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
 CONSTRAINT chk_items_quantity CHECK (quantity > 0),
 CONSTRAINT chk_items_price CHECK (price >= 0)
) ENGINE=InnoDB;
CREATE TABLE vehicle_checks (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 brand VARCHAR(100) NOT NULL,
 model VARCHAR(100) NOT NULL,
 year INT NOT NULL,
 part VARCHAR(150) NOT NULL,
 CONSTRAINT fk_vehicle_checks_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Password values are demo-only placeholders, not usable login passwords.
INSERT INTO users (name,email,password,role) VALUES
 ('Demo Customer','demo@example.com','DEMO_ONLY_NOT_A_HASH','customer'),
 ('Demo Admin','admin@example.com','DEMO_ONLY_NOT_A_HASH','admin');
INSERT INTO categories (name,description) VALUES ('Brakes','Brake system parts'),('Filters','Air and oil filters'),('Engine','Engine components');
INSERT INTO products (name,description,price,stock,category_id) VALUES
 ('Brake Pads','Front brake pads',85.00,20,1),('Oil Filter','Standard oil filter',18.50,45,2),('Timing Belt','Replacement timing belt',110.00,12,3);
INSERT INTO orders (user_id,order_date,total) VALUES (1,'2026-10-20 12:00:00',103.50);
INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (1,1,1,85.00),(1,2,1,18.50);
INSERT INTO vehicle_checks (user_id,brand,model,year,part) VALUES (1,'Audi','A6',2006,'Oil Filter'),(1,'Skoda','Octavia',2012,'Brake Pads');
