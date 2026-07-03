USE clinic_crm;

-- Tạo tài khoản Admin mặc định (Password: 123456)
INSERT INTO users (name, email, password_hash, role)
VALUES
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Seed 22 dòng Bệnh nhân để test Phân trang (Pagination)
INSERT INTO patients (name, email, phone, status, note) VALUES
('Nguyen Van A', 'nva@example.com', '0901000001', 'new', 'Khám tổng quát'),
('Tran Thi B', 'ttb@example.com', '0901000002', 'consulting', 'Đau dạ dày'),
('Le Van C', 'lvc@example.com', '0901000003', 'treated', 'Đã bốc thuốc'),
('Pham Thi D', 'ptd@example.com', '0901000004', 'new', ''),
('Hoang Van E', 'hve@example.com', '0901000005', 'consulting', 'Tái khám'),
('Vu Thi F', 'vtf@example.com', '0901000006', 'cancelled', 'Hủy do bận việc'),
('Do Van G', 'dvg@example.com', '0901000007', 'new', ''),
('Bui Thi H', 'bth@example.com', '0901000008', 'treated', 'Hoàn tất'),
('Ngo Van I', 'nvi@example.com', '0901000009', 'consulting', 'Đang đợi xét nghiệm'),
('Ly Thi J', 'ltj@example.com', '0901000010', 'new', 'Tư vấn niềng răng'),
('Truong Van K', 'tvk@example.com', '0901000011', 'treated', ''),
('Dang Thi L', 'dtl@example.com', '0901000012', 'consulting', 'Khám da liễu'),
('Ton Van M', 'tvm@example.com', '0901000013', 'new', ''),
('Mac Thi N', 'mtn@example.com', '0901000014', 'cancelled', 'Chưa liên hệ được'),
('Chau Van O', 'cvo@example.com', '0901000015', 'treated', ''),
('Diep Thi P', 'dtp@example.com', '0901000016', 'new', 'Tư vấn phẫu thuật'),
('Trinh Van Q', 'tvq@example.com', '0901000017', 'consulting', ''),
('La Thi R', 'ltr@example.com', '0901000018', 'new', ''),
('Dinh Van S', 'dvs@example.com', '0901000019', 'treated', ''),
('Lam Thi T', 'ltt@example.com', '0901000020', 'consulting', 'Khám mắt'),
('Phan Van U', 'pvu@example.com', '0901000021', 'new', ''),
('Cao Thi V', 'ctv@example.com', '0901000022', 'treated', 'Hoàn tất liệu trình');

-- Seed 22 dòng Lịch hẹn khám để test Phân trang (Pagination)
INSERT INTO appointments (appointment_code, patient_name, patient_email, appointment_date, status) VALUES
('APT-2026-0001', 'Nguyen Van A', 'nva@example.com', '2026-07-10 08:30:00', 'confirmed'),
('APT-2026-0002', 'Tran Thi B', 'ttb@example.com', '2026-07-10 09:00:00', 'completed'),
('APT-2026-0003', 'Le Van C', 'lvc@example.com', '2026-07-10 09:30:00', 'completed'),
('APT-2026-0004', 'Pham Thi D', 'ptd@example.com', '2026-07-10 10:00:00', 'pending'),
('APT-2026-0005', 'Hoang Van E', 'hve@example.com', '2026-07-11 08:00:00', 'confirmed'),
('APT-2026-0006', 'Vu Thi F', 'vtf@example.com', '2026-07-11 08:30:00', 'cancelled'),
('APT-2026-0007', 'Do Van G', 'dvg@example.com', '2026-07-11 09:00:00', 'pending'),
('APT-2026-0008', 'Bui Thi H', 'bth@example.com', '2026-07-11 09:30:00', 'completed'),
('APT-2026-0009', 'Ngo Van I', 'nvi@example.com', '2026-07-12 14:00:00', 'confirmed'),
('APT-2026-0010', 'Ly Thi J', 'ltj@example.com', '2026-07-12 14:30:00', 'pending'),
('APT-2026-0011', 'Truong Van K', 'tvk@example.com', '2026-07-12 15:00:00', 'completed'),
('APT-2026-0012', 'Dang Thi L', 'dtl@example.com', '2026-07-13 08:30:00', 'confirmed'),
('APT-2026-0013', 'Ton Van M', 'tvm@example.com', '2026-07-13 09:00:00', 'pending'),
('APT-2026-0014', 'Mac Thi N', 'mtn@example.com', '2026-07-13 09:30:00', 'cancelled'),
('APT-2026-0015', 'Chau Van O', 'cvo@example.com', '2026-07-14 10:00:00', 'completed'),
('APT-2026-0016', 'Diep Thi P', 'dtp@example.com', '2026-07-14 10:30:00', 'pending'),
('APT-2026-0017', 'Trinh Van Q', 'tvq@example.com', '2026-07-14 11:00:00', 'confirmed'),
('APT-2026-0018', 'La Thi R', 'ltr@example.com', '2026-07-15 08:00:00', 'pending'),
('APT-2026-0019', 'Dinh Van S', 'dvs@example.com', '2026-07-15 08:30:00', 'completed'),
('APT-2026-0020', 'Lam Thi T', 'ltt@example.com', '2026-07-15 09:00:00', 'confirmed'),
('APT-2026-0021', 'Phan Van U', 'pvu@example.com', '2026-07-16 14:00:00', 'pending'),
('APT-2026-0022', 'Cao Thi V', 'ctv@example.com', '2026-07-16 14:30:00', 'completed');