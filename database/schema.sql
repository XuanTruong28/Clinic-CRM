CREATE DATABASE IF NOT EXISTS clinic_crm
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE clinic_crm;

-- Bảng lưu trữ tài khoản Admin/Staff
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng lưu trữ thông tin Bệnh nhân (Tương đương module Lead)
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(20) NOT NULL,
    status ENUM('new', 'consulting', 'treated', 'cancelled') NOT NULL DEFAULT 'new',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL, -- CỘT ĐƯỢC THÊM VÀO ĐỂ CHẠY SOFT DELETE
    UNIQUE KEY unique_patient_phone (phone),
    UNIQUE KEY unique_patient_email (email),
    INDEX idx_patients_created_at (created_at),
    INDEX idx_patients_status_created_at (status, created_at)
);

-- Bảng lưu trữ Lịch hẹn khám (Tương đương module Order)
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_code VARCHAR(50) NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    patient_email VARCHAR(150),
    appointment_date DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_appointment_code (appointment_code),
    INDEX idx_appointments_created_at (created_at),
    INDEX idx_appointments_status_created_at (status, created_at),
    INDEX idx_appointments_date (appointment_date)
);