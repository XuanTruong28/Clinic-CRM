# 🏥 Secure Clinic CRM - Hệ thống Quản lý Bệnh nhân và Lịch hẹn

**Secure Clinic CRM** là hệ thống quản trị quy trình khám chữa bệnh tại phòng khám tư nhân, được xây dựng dựa trên kiến trúc MVC (Model-View-Controller) với mục tiêu tối ưu hóa nghiệp vụ, đảm bảo tính bảo mật và hiệu năng cao.

---

# 🚀 Công nghệ sử dụng

- **PHP (Native - Không sử dụng Framework)**
- **MySQL**
- **Bootstrap 5**
- **Git**

---

# ✨ Các Module Chính

### 🔐 Quản trị người dùng (Auth)

- Đăng nhập
- Phân quyền **Admin / Staff**
- Bảo mật Session

---

### 👨‍⚕️ Quản lý Bệnh nhân (Patients)

- CRUD bệnh nhân
- Tìm kiếm thông minh
- Sắp xếp danh sách
- Phân trang
- Xử lý dữ liệu trùng lặp (**Unique Key**)

---

### 📅 Quản lý Lịch hẹn (Appointments)

- Theo dõi lịch khám
- Quản lý trạng thái điều trị

---

### 🛡️ Tiện ích

- Dashboard thống kê
- Logging hệ thống
- Chống Spam
  - Honeypot
  - Rate Limit
- Bảo mật CSRF

---

# 🗄️ Database Schema (`clinic_crm`)

Hệ thống sử dụng cơ sở dữ liệu **clinic_crm** gồm các bảng sau:

| Table | Mô tả |
|--------|------|
| **users** | Lưu thông tin tài khoản đăng nhập (`id`, `email`, `password_hash`, `role`, `created_at`) |
| **patients** | Lưu thông tin bệnh nhân (`id`, `name`, `email`, `phone`, `status`, `note`, `created_at`, `updated_at`, `deleted_at`) |
| **appointments** | Lưu lịch hẹn (`id`, `appointment_code`, `patient_name`, `patient_email`, `appointment_date`, `status`, `created_at`) |

---

# 📁 Cấu trúc thư mục dự án (MVC Architecture)

Toàn bộ logic nghiệp vụ, giao diện và truy xuất cơ sở dữ liệu được phân tách theo mô hình **MVC**.

```text
clinic-crm/
├── public/
│   └── index.php
│
├── config/
│   ├── app.php
│   └── database.php
│
├── app/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── helpers.php
│   │   └── Exception.php
│   │
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── PublicBookingController.php
│   │   ├── PatientController.php
│   │   └── AppointmentController.php
│   │
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── PatientService.php
│   │   └── AppointmentService.php
│   │
│   ├── Repositories/
│   │   ├── UserRepository.php
│   │   ├── PatientRepository.php
│   │   └── AppointmentRepository.php
│   │
│   └── Views/
│       ├── layouts/
│       │   └── main.php
│       │
│       ├── partials/
│       │   ├── nav.php
│       │   └── flash.php
│       │
│       ├── errors/
│       │   ├── 404.php
│       │   ├── 405.php
│       │   └── 500.php
│       │
│       ├── auth/
│       │   └── login.php
│       │
│       ├── dashboard/
│       │   └── index.php
│       │
│       ├── patients/
│       │   ├── index.php
│       │   ├── create.php
│       │   └── edit.php
│       │
│       └── appointments/
│           ├── index.php
│           ├── create.php
│           └── edit.php
│
├── database/
│   ├── schema.sql
│   └── seed_data.php
│
├── storage/
│   └── logs/
│       └── app.log
│
└── README.md
```

---

# ⚙️ Hướng dẫn cài đặt và chạy ứng dụng

## 1️⃣ Cấu hình Cơ sở dữ liệu

- Truy cập **phpMyAdmin**
- Tạo database:

```text
clinic_crm
```

- Charset:

```text
utf8mb4_unicode_ci
```

- Import file:

```text
database/schema.sql
```

để tạo các bảng:

- users
- patients
- appointments

- Chạy file:

```text
database/seed_data.php
```

(hoặc `seed.sql`) để tạo:

- Tài khoản Admin
- Dữ liệu mẫu

---

## 2️⃣ Cấu hình kết nối Database

Mở file:

```text
config/database.php
```

Đảm bảo:

- Database Name:

```text
clinic_crm
```

- Username
- Password
- Host

được cấu hình chính xác.

Ngoài ra hãy chắc chắn extension **pdo_mysql** đã được bật trong file:

```text
php.ini
```

---

## 3️⃣ Khởi động Server

Mở **Terminal** hoặc **Command Prompt** tại thư mục gốc của project.

Chạy lệnh:

```bash
php -S localhost:8000 -t public
```

---

## 4️⃣ Đăng nhập hệ thống

Sau khi server chạy thành công, truy cập:

```text
http://localhost:8000/login
```

### Tài khoản Demo

**Email**

```text
admin@example.com
```

**Password**

```text
123456
```

---

# 🎯 Chạy nhanh

```bash
# Khởi động PHP Built-in Server
php -S localhost:8000 -t public
```

Sau đó mở trình duyệt:

```text
http://localhost:8000/login
```
