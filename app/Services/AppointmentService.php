<?php
class AppointmentService {
    private AppointmentRepository $repo;

    public function __construct() {
        $this->repo = new AppointmentRepository();
    }

    public function getList(array $query): array {
        $keyword = trim($query['q'] ?? '');
        $page = max(1, (int)($query['page'] ?? 1));
        $sort = $query['sort'] ?? 'appointment_date';
        $dir = $query['dir'] ?? 'desc';
        $perPage = 10;
        
        $totalItems = $this->repo->countAll($keyword);
        $totalPages = max(1, (int)ceil($totalItems / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;

        return [
            'appointments' => $this->repo->getPaginated($keyword, $perPage, $offset, $sort, $dir),
            'keyword' => $keyword,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'sort' => $sort,
            'dir' => $dir
        ];
    }

    private function validate(array $input): array {
        $errors = [];
        $values = [
            'appointment_code' => trim($input['appointment_code'] ?? ''),
            'patient_name' => trim($input['patient_name'] ?? ''),
            'patient_email' => trim($input['patient_email'] ?? ''),
            'appointment_date' => trim($input['appointment_date'] ?? ''),
            'status' => trim($input['status'] ?? 'pending')
        ];

        if ($values['appointment_code'] === '') $errors['appointment_code'] = 'Mã lịch hẹn là bắt buộc.';
        if ($values['patient_name'] === '') $errors['patient_name'] = 'Tên bệnh nhân là bắt buộc.';
        if ($values['appointment_date'] === '') $errors['appointment_date'] = 'Ngày hẹn là bắt buộc.';
        
        if ($values['patient_email'] !== '' && !filter_var($values['patient_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['patient_email'] = 'Email không đúng định dạng.';
        }
        
        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (!in_array($values['status'], $validStatuses, true)) {
            $errors['status'] = 'Trạng thái không hợp lệ.';
        }

        return compact('errors', 'values');
    }

    public function createAppointment(array $input): array {
        $validation = $this->validate($input);
        if (!empty($validation['errors'])) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        try {
            $this->repo->create($validation['values']);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['appointment_code' => $e->getMessage()]];
        }
    }

    public function getAppointmentById(int $id): ?array {
        return $this->repo->findById($id);
    }

    public function updateAppointment(int $id, array $input): array {
        $validation = $this->validate($input);
        if (!empty($validation['errors'])) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        try {
            $this->repo->update($id, $validation['values']);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['appointment_code' => $e->getMessage()]];
        }
    }

    public function deleteAppointment(int $id): bool {
        return $this->repo->delete($id);
    }
}