<?php
class AuthService {
    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function login(string $email, string $password): array {
        $user = $this->userRepo->findActiveByEmail($email);
        
        // Xóa var_dump và die() ở trên đi, rồi dùng đoạn này:
        if (!$user) {
            return ['success' => false, 'error' => 'Không tìm thấy user.'];
        }

        // Kiểm tra xem mật khẩu nhập vào có khớp với hash không
        if (!password_verify($password, $user['password_hash'])) {
            // Log thử xem mật khẩu nhập vào là gì (CHỈ ĐỂ TEST, XÓA SAU KHI XONG)
            log_error("Mật khẩu nhập vào: [" . $password . "] không khớp với hash: [" . $user['password_hash'] . "]");
            return ['success' => false, 'error' => 'Mật khẩu không đúng.'];
        }
        // Task T11: Bắt buộc Regenerate ID chống Session Fixation
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['last_activity'] = time();
        
        return ['success' => true];
    }
}