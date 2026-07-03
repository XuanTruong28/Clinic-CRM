<?php
class PatientRepository {
    private PDO $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = Database::connect($config);
    }

    public function countAll(string $keyword = ''): int {
        $sql = "SELECT COUNT(*) AS total FROM patients WHERE deleted_at IS NULL";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (name LIKE :keyword OR phone LIKE :keyword OR email LIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort = 'created_at', string $dir = 'DESC'): array {
        // Whitelist sort an toàn [cite: 860]
        $allowedSorts = ['id', 'name', 'created_at', 'status'];
        $sortColumn = in_array($sort, $allowedSorts) ? $sort : 'created_at';
        $direction = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT id, name, email, phone, status, created_at FROM patients WHERE deleted_at IS NULL";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (name LIKE :keyword OR phone LIKE :keyword OR email LIKE :keyword)";
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
        $stmt = $this->db->prepare("SELECT * FROM patients WHERE id = :id AND deleted_at IS NULL LIMIT 1");
        $stmt->execute(['id' => $id]);
        $patient = $stmt->fetch();
        return $patient ?: null;
    }

    public function create(array $data): bool{

    $sql = "INSERT INTO patients (name, email, phone, status, note) 
            VALUES (:name, :email, :phone, :status, :note)";
    $stmt = $this->db->prepare($sql);
    
    try {
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? 'new',
            'note' => $data['note'] ?? null
        ]);
    } catch (PDOException $e) {
        if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
    
            throw new DuplicateRecordException('Email đã tồn tại');
        }
        // Nếu là lỗi DB khác (như sai tên cột, rớt mạng), cứ ném ra bình thường
        throw $e;
    }
}

    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        $sql = "UPDATE patients SET name=:name, email=:email, phone=:phone, status=:status, note=:note, updated_at=NOW() WHERE id=:id AND deleted_at IS NULL";
        
        try {
            return $this->db->prepare($sql)->execute($data);
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Số điện thoại hoặc Email đã tồn tại ở hồ sơ khác.');
            }
            throw $e;
        }
    }

    public function softDelete(int $id): bool {
        // Soft delete thay vì DELETE thật 
        $stmt = $this->db->prepare("UPDATE patients SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}