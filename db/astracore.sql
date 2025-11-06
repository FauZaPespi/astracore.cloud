DROP DATABASE IF EXISTS Astracore;

CREATE DATABASE Astracore;

USE Astracore;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(45) NOT NULL UNIQUE,
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE devices(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ip VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE modules(
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    command VARCHAR(255) NOT NULL,
    last_executed DATETIME,
    status VARCHAR(50) NOT NULL,
    console_output VARCHAR(255),
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE
);