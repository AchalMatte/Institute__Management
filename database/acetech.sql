-- Acetech Institute Management Database

CREATE DATABASE IF NOT EXISTS acetech_db;
USE acetech_db;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(20) NOT NULL UNIQUE,
    description TEXT,
    duration VARCHAR(50),
    fee DECIMAL(10,2),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS batches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_name VARCHAR(100) NOT NULL,
    course_id INT,
    start_date DATE,
    end_date DATE,
    timing VARCHAR(50),
    capacity INT DEFAULT 30,
    status ENUM('upcoming','ongoing','completed') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    address TEXT,
    batch_id INT,
    enrollment_date DATE,
    photo VARCHAR(255) DEFAULT 'default.png',
    status ENUM('active','inactive','completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(200),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin (password: admin123)
-- Run this in PHP to get hash: password_hash('admin123', PASSWORD_DEFAULT)
-- Temporary plain password stored, will be hashed on first login via setup.php
INSERT INTO admin_users (username, password, email) VALUES 
('admin', 'admin123', 'admin@acetech.com');

-- Sample Courses
INSERT INTO courses (course_name, course_code, description, duration, fee) VALUES
('Python Programming', 'PY101', 'Learn Python from basics to advanced including Django framework.', '3 Months', 8000.00),
('Web Development', 'WD201', 'Full stack web development with HTML, CSS, JS, PHP and MySQL.', '6 Months', 15000.00),
('Java Programming', 'JV301', 'Core Java, OOP concepts, JDBC and Spring Boot basics.', '4 Months', 10000.00),
('C/C++ Programming', 'CC401', 'Fundamentals of C and C++ with data structures.', '3 Months', 7000.00),
('JavaScript & React', 'JS501', 'Modern JavaScript ES6+, React.js and Node.js basics.', '4 Months', 12000.00),
('Database Management', 'DB601', 'SQL, MySQL, database design and administration.', '2 Months', 5000.00);
