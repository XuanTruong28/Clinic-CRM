<?php
class PatientService {
    private PatientRepository $repo;

    public function __construct() {
        $this->repo = new PatientRepository();
    }

    public function getList(array $query): array {
        $keyword = trim($query['q'] ?? '');
        $page = max(1, (int)($query['page'] ?? 1));
        $sort = $query['sort'] ?? 'created_at';
        $dir = $query['dir'] ?? 'desc';
        $perPage = 10;
        
        $totalItems = $this->repo->countAll($keyword);
        $totalPages = max(1, (int)ceil($totalItems / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;

        return [
            'patients' => $this->repo->getPaginated($keyword, $perPage, $offset, $sort, $dir),
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
            'name' => trim($input['name'] ?? ''),
            'email' => trim($input['email'] ?? ''),
            'phone' => trim($input['phone'] ?? ''),
            'status' => trim($input['status'] ?? 'new'),
            'note' => trim($input['note'] ?? '')
        ];

        if ($values['name'] === '') $errors['name'] = 'Tên bệnh nhân không được để trống.';
        if ($values['phone'] === '') $errors['phone'] = 'Số điện thoại không được để trống.';
        if ($values['email'] !== '' && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng.';
        }
        if (!in_array($values['status'], ['new', 'consulting', 'treated', 'cancelled'], true)) {
            $errors['status'] = 'Trạng thái không hợp lệ.';
        }

        return compact('errors', 'values');
    }

    public function createPatient(array $input): array {
        // Validate dữ liệu cơ bản giống T07
        $errors = [];
        if (empty($input['name'])) $errors['name'] = 'Tên không được trống.';
        if (empty($input['email'])) $errors['email'] = 'Email không được trống.';

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $this->repo->create($input);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            // [T21] - Bắt lỗi trùng key và đưa vào mảng lỗi của trường email
            return [
                'success' => false, 
                'errors' => ['email' => 'Email này đã tồn tại trên hệ thống phòng khám.']
            ];
        }
    }

    public function getPatientById(int $id): ?array {
        return $this->repo->findById($id);
    }

    public function updatePatient(int $id, array $input): array {
        $validation = $this->validate($input);
        if (!empty($validation['errors'])) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        try {
            $this->repo->update($id, $validation['values']);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['general' => $e->getMessage()]];
        }
    }

    public function deletePatient(int $id): bool {
        return $this->repo->softDelete($id);
    }
}