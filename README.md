php -S localhost:8000 -t public
# Secure Clinic CRM - Hệ thống Quản lý Bệnh nhân và Lịch hẹn

Dự án Mini CRM được xây dựng bằng kiến trúc PHP MVC thuần, tập trung vào bảo mật dữ liệu và chuẩn hóa quy trình CRUD. Hệ thống được thiết kế riêng cho việc quản lý phòng khám, bao gồm tiếp nhận đặt lịch công khai, quản lý hồ sơ Bệnh nhân (Patients) và theo dõi Lịch hẹn khám (Appointments).

## 1. Cấu trúc thư mục dự án (MVC Architecture)

Toàn bộ logic nghiệp vụ, giao diện và truy xuất cơ sở dữ liệu đã được phân tách rõ ràng theo chuẩn:

```text
clinic-crm/
├── public/
│   └── index.php
├── config/
│   ├── app.php
│   └── database.php
├── app/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── helpers.php
│   │   └── Exception.php
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── PublicBookingController.php
│   │   ├── PatientController.php
│   │   └── AppointmentController.php
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── PatientService.php
│   │   └── AppointmentService.php
│   ├── Repositories/
│   │   ├── UserRepository.php
│   │   ├── PatientRepository.php
│   │   └── AppointmentRepository.php
│   └── Views/
│       ├── layouts/main.php
│       ├── partials/nav.php, flash.php
│       ├── errors/ 404.php, 405.php, 500.php
│       ├── auth/login.php
│       ├── dashboard/index.php
│       ├── patients/index.php, create.php, edit.php
│       └── appointments/index.php, create.php, edit.php
├── database/
│   ├── schema.sql
│   └── seed_data.php
├── storage/logs/
│   └── app.log
└── README.md

#2. Hướng dẫn cài đặt và chạy ứng dụng
1. Cấu hình Cơ sở dữ liệu:

Truy cập phpMyAdmin, tạo database tên là clinic_crm (Charset: utf8mb4_unicode_ci).

Import file database/schema.sql để tạo cấu trúc các bảng (users, patients, appointments).

Chạy các câu lệnh trong file database/seed_data.php (hoặc seed.sql) để tạo tài khoản Admin và dữ liệu mẫu.

2. Cấu hình kết nối (Config):

Mở file config/database.php và đảm bảo thông tin kết nối chính xác (dbname: clinic_crm).

Hãy chắc chắn extension pdo_mysql đã được bật trong php.ini.

3. Khởi động Server:

Mở Terminal/Command Prompt tại thư mục gốc của project.

Chạy lệnh sau để khởi động PHP Built-in Server:

Bash
php -S localhost:8000 -t public
4. Đăng nhập hệ thống:

Truy cập URL: http://localhost:8000/login

Tài khoản demo: admin@example.com

Mật khẩu: 123456