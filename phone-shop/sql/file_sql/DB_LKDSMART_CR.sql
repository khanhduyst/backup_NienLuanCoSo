# CREATE DATABASE lkd_smart;

USE lkd_smart;

-- Cac bang thuoc tinh cua san pham 
CREATE TABLE brands (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE os (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE colors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  code VARCHAR(20) NOT NULL, 
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  size VARCHAR(50) NOT NULL,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    status TINYINT(1) DEFAULT 1,   
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    brand_id INT NOT NULL,
    CONSTRAINT fk_chip_brand FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE RESTRICT
);

ALTER TABLE products
ADD COLUMN chip_id INT,
ADD CONSTRAINT fk_chip FOREIGN KEY (chip_id) REFERENCES chips(id) ON DELETE RESTRICT;

ALTER TABLE brands 
ADD COLUMN type TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE products
ADD COLUMN screen_technology VARCHAR(100) AFTER name,
ADD COLUMN screen_size DECIMAL(3,1) AFTER screen_technology,
ADD COLUMN front_camera VARCHAR(100) AFTER screen_size,
ADD COLUMN rear_camera VARCHAR(100) AFTER front_camera,
ADD COLUMN battery_capacity INT AFTER rear_camera,
ADD COLUMN sim_card VARCHAR(50) AFTER battery_capacity;

ALTER TABLE products
ADD COLUMN categories VARCHAR(50) AFTER  battery_capacity;

ALTER TABLE products
ADD COLUMN img_main VARCHAR(255) AFTER  categories;

CREATE TABLE storages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  size VARCHAR(50) NOT NULL,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- bang san pham
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,        
  description TEXT,                   
  brand_id INT NOT NULL,               
  os_id INT NOT NULL,                  
  status TINYINT(1) DEFAULT 1,         
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (brand_id) REFERENCES brands(id),
  FOREIGN KEY (os_id) REFERENCES os(id)
);

-- cac bien the cua san pham
CREATE TABLE product_variants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,             
  ram_id INT NOT NULL,                  
  storage_id INT NOT NULL,              
  color_id INT NOT NULL,               
  price DECIMAL(12,2) NOT NULL,         
  quantity INT NOT NULL DEFAULT 0,     
  status TINYINT(1) DEFAULT 1,          
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (ram_id) REFERENCES rams(id),
  FOREIGN KEY (storage_id) REFERENCES storages(id),
  FOREIGN KEY (color_id) REFERENCES colors(id)
);

-- hinh san pham
CREATE TABLE product_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,             
  image_url VARCHAR(255) NOT NULL,     
  is_main TINYINT(1) DEFAULT 0,       
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id)
);
 
 -- bang tai khoan
 CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  phone VARCHAR(20) UNIQUE,
  password VARCHAR(255) NOT NULL,       
  role ENUM('admin','customer') DEFAULT 'customer',
  status TINYINT(1) DEFAULT 1,        
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- bang hoa don 
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,                  
  total DECIMAL(12,2) NOT NULL,         
  shipping_address VARCHAR(255) NOT NULL,
  shipping_city VARCHAR(100),
  shipping_district VARCHAR(100),
  shipping_province VARCHAR(100),
  status ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- bang hoa don chi tiet
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,                 
  variant_id INT NOT NULL,              
  quantity INT NOT NULL,
  price DECIMAL(12,2) NOT NULL,         
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (variant_id) REFERENCES product_variants(id)
);

-- bang kho 
CREATE TABLE stock (
  id INT AUTO_INCREMENT PRIMARY KEY,
  variant_id INT NOT NULL,             
  change_type ENUM('import','export') NOT NULL,
  quantity INT NOT NULL,
  note VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id)
);

 -- log
 CREATE TABLE activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,                          
  action VARCHAR(50) NOT NULL,           
  table_name VARCHAR(100) NOT NULL,      
  record_id INT,                         
  description TEXT,                    
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


-- them du lieu
INSERT INTO users (username, fullname, email, phone, password, role, status) 
VALUES (
    'admin',
    'Quản trị viên',
    'admin@example.com',
    '0123456789',
    '12345', 
    'admin',
    1
);

-- Customer
INSERT INTO users (username, fullname, email, phone, password, role, status)
VALUES ('duy123', 'Người dùng Duy', 'duy@example.com', '0987654321', '1234', 'customer', 1);


 
