CREATE DATABASE IF NOT EXISTS socialteam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE socialteam;

CREATE TABLE settings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  app_name VARCHAR(100) NOT NULL DEFAULT 'socialTeam',
  theme VARCHAR(30) NOT NULL DEFAULT 'sunset',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO settings (id, app_name, theme) VALUES (1, 'socialTeam', 'sunset')
  ON DUPLICATE KEY UPDATE app_name=VALUES(app_name);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  avatar VARCHAR(255) NULL,
  role ENUM('admin','moderator','user') NOT NULL DEFAULT 'user',
  status ENUM('active','suspended') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  body TEXT NOT NULL,
  seen TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_chat(sender_id, receiver_id, created_at)
);
