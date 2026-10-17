CREATE DATABASE IF NOT EXISTS campuslost CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE campuslost;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  category VARCHAR(50) NOT NULL DEFAULT 'Other',
  description TEXT,
  location VARCHAR(150) NOT NULL,
  item_date DATE NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  status ENUM('lost','found','returned') NOT NULL DEFAULT 'lost',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_item_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE claims (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  item_id INT UNSIGNED NOT NULL,
  claimant_id INT UNSIGNED NOT NULL,
  message TEXT NOT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_claim_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
  CONSTRAINT fk_claim_user FOREIGN KEY (claimant_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY one_claim_per_user (item_id, claimant_id)
);

-- After registering your own account, promote it with:
-- UPDATE users SET role = 'admin' WHERE email = 'your-email@college.edu';
