<?php
class AppointmentRepository {
    private PDO $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = Database::connect($config);
    }

    public function countAll(string $keyword = ''): int {
        $sql = "SELECT COUNT(*) AS total FROM appointments";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE appointment_code LIKE :keyword OR patient_name LIKE :keyword";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort = 'appointment_date', string $dir = 'DESC'): array {
        $allowedSorts = ['id', 'appointment_code', 'appointment_date', 'status'];
        $sortColumn = in_array($sort, $allowedSorts) ? $sort : 'appointment_date';
        $direction = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM appointments";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE appointment_code LIKE :keyword OR patient_name LIKE :keyword";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY {$sortColumn} {$direction} LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $appointment = $stmt->fetch();
        return $appointment ?: null;
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO appointments (appointment_code, patient_name, patient_email, appointment_date, status) 
                VALUES (:appointment_code, :patient_name, :patient_email, :appointment_date, :status)";
        $stmt = $this->db->prepare($sql);
        
        try {
            return $stmt->execute($data);
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Mã lịch hẹn (Appointment Code) đã tồn tại.');
            }
            throw $e;
        }
    }

    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        $sql = "UPDATE appointments 
                SET appointment_code=:appointment_code, patient_name=:patient_name, patient_email=:patient_email, 
                    appointment_date=:appointment_date, status=:status, updated_at=NOW() 
                WHERE id=:id";
        
        try {
            return $this->db->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Mã lịch hẹn (Appointment Code) bị trùng với lịch khác.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}