<?php
require_once __DIR__ . '/../Core/helpers.php';

class PatientController {
    private PatientService $service;

    public function __construct() {
        $this->service = new PatientService();
    }

    public function index(): void {
        require_login();
        $data = $this->service->getList($_GET);
        render('patients/index', ['title' => 'Quản lý Bệnh nhân'] + $data);
    }

    public function create(): void {
        require_login();
        render('patients/create', ['title' => 'Thêm Bệnh nhân mới', 'errors' => []]);
    }

    public function store(): void {
        $result = $this->service->createPatient($_POST);
        
        if (!$result['success']) {
            render('patients/create', [
                'title' => 'Create Patient',
                'errors' => $result['errors'],
                'old' => $_POST
            ]);
            return;
        }   
        
        flash('success', 'Thêm bệnh nhân thành công.');
        redirect('/patients');
    }

    public function edit(): void {
        require_login();
        $id = (int)($_GET['id'] ?? 0);
        $patient = $this->service->getPatientById($id);

        if (!$patient) {
            flash('error', 'Bệnh nhân không tồn tại hoặc đã bị xóa.');
            redirect('/patients');
        }

        if (empty($_SESSION['old'])) {
            $_SESSION['old'] = $patient;
        }

        render('patients/edit', ['title' => 'Cập nhật Bệnh nhân', 'errors' => [], 'id' => $id]);
    }

    public function update(): void {
        require_login();
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->service->updatePatient($id, $_POST);

        if (!$result['success']) {
            $_SESSION['old'] = $_POST;
            render('patients/edit', [
                'title' => 'Cập nhật Bệnh nhân',
                'errors' => $result['errors'],
                'id' => $id
            ]);
            return;
        }

        clear_old();
        flash('success', 'Cập nhật thông tin thành công.');
        redirect('/patients');
    }

    public function delete(): void {
        require_role('admin'); // Bonus: Chỉ Admin được phép xóa [cite: 996]
        $id = (int)($_POST['id'] ?? 0);
        
        if ($this->service->deletePatient($id)) {
            flash('success', 'Đã xóa hồ sơ bệnh nhân thành công.');
        } else {
            flash('error', 'Không thể xóa hồ sơ này.');
        }
        
        redirect('/patients');
    }
}