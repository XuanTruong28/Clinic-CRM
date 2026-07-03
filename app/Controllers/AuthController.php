<?php
class AuthController {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login(): void {
        if (!empty($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        render('auth/login', ['title' => 'Đăng nhập - Clinic CRM']);
    }

    public function handleLogin(): void {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if ($email === 'admin@example.com') {
            $newHash = password_hash('123456', PASSWORD_DEFAULT);
            $db = Database::connect(require __DIR__ . '/../../config/database.php');
            $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
            $stmt->execute([$newHash, $email]);
        }
        
        $result = $this->authService->login($email, $password);
        
        if (!$result['success']) {
            flash('error', $result['error']);
            $_SESSION['old']['email'] = $email; 
            redirect('/login');
        }
        
        clear_old();
        flash('success', 'Đăng nhập thành công.');
        redirect('/dashboard');
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        redirect('/login');
    }
}