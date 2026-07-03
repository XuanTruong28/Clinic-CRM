<?php
require_once __DIR__ . '/../Core/helpers.php';

class AppointmentController {
    private AppointmentService $service;

    public function __construct() {
        $this->service = new AppointmentService();
    }

    public function index(): void {
        require_login();
        $data = $this->service->getList($_GET);
        render('appointments/index', ['title' => 'Quản lý Lịch hẹn'] + $data);
    }

    public function create(): void {
        require_login();
        // Generate mã hẹn tự động (Ví dụ: APT-2026-XXXX)
        if (empty($_SESSION['old']['appointment_code'])) {
            $_SESSION['old']['appointment_code'] = 'APT-' . date('Y') . '-' . rand(1000, 9999);
        }
        render('appointments/create', ['title' => 'Thêm Lịch hẹn', 'errors' => []]);
    }

    public function store(): void {
        require_login();
        $result = $this->service->createAppointment($_POST);
        
        if (!$result['success']) {

            render('appointments/create', [
                'title' => 'Thêm Lịch hẹn',
                'errors' => $result['errors'],
                'old' => $_POST
            ]);
            return;
        }

        flash('success', 'Đã tạo lịch hẹn thành công.');
        redirect('/appointments');
    }

    public function edit(): void {
        require_login();
        $id = (int)($_GET['id'] ?? 0);
        $appointment = $this->service->getAppointmentById($id);

        if (!$appointment) {
            flash('error', 'Lịch hẹn không tồn tại.');
            redirect('/appointments');
        }

        if (empty($_SESSION['old'])) {
            // Chuyển đổi định dạng DATETIME của MySQL sang thẻ <input type="datetime-local">
            $appointment['appointment_date'] = date('Y-m-d\TH:i', strtotime($appointment['appointment_date']));
            $_SESSION['old'] = $appointment;
        }

        render('appointments/edit', ['title' => 'Cập nhật Lịch hẹn', 'errors' => [], 'id' => $id]);
    }

    public function update(): void {
        require_login();
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->service->updateAppointment($id, $_POST);

        if (!$result['success']) {
            $_SESSION['old'] = $_POST;
            render('appointments/edit', [
                'title' => 'Cập nhật Lịch hẹn',
                'errors' => $result['errors'],
                'id' => $id
            ]);
            return;
        }

        clear_old();
        flash('success', 'Cập nhật lịch hẹn thành công.');
        redirect('/appointments');
    }

    public function delete(): void {
        require_role('admin'); // Bonus: Chỉ Admin được xóa lịch hẹn
        $id = (int)($_POST['id'] ?? 0);
        
        if ($this->service->deleteAppointment($id)) {
            flash('success', 'Đã xóa lịch hẹn thành công.');
        } else {
            flash('error', 'Không thể xóa lịch hẹn này.');
        }
        
        redirect('/appointments');
    }
}