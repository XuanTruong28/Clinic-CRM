<?php

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header("Location: {$path}");
    exit;
}

function render(string $view, array $data = [], string $layout = 'layouts/main'): void {
    extract($data);
    ob_start();
    require __DIR__ . '/../Views/' . $view . '.php';
    $content = ob_get_clean();
    require __DIR__ . '/../Views/' . $layout . '.php';
}

function partial(string $name, array $data = []): void {
    extract($data);
    require __DIR__ . '/../Views/partials/' . $name . '.php';
}

function flash(string $key, string $message): void {
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string {
    if (empty($_SESSION['flash'][$key])) return null;
    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $message;
}

function old(string $key, string $default = ''): string {
    return isset($_SESSION['old'][$key]) ? e((string)$_SESSION['old'][$key]) : e($default);
}

function clear_old(): void {
    unset($_SESSION['old']);
}

function is_post(): bool {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// BONUS: CSRF Token
function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}


function verify_csrf(): void {
    if (is_post()) {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            log_error("CSRF Token Mismatch from IP: " . $_SERVER['REMOTE_ADDR']);
            throw new CsrfTokenMismatchException('Yêu cầu không hợp lệ (CSRF Mismatch).');
        }
    }
}

// BONUS: Logging
function log_error(string $message): void {
    $config = require __DIR__ . '/../../config/app.php';
    $date = date('Y-m-d H:i:s');
    $logMessage = "[{$date}] ERROR: {$message}" . PHP_EOL;
    error_log($logMessage, 3, $config['log_path']);
}

// BONUS: Role Permission
function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        flash('error', 'Vui lòng đăng nhập để tiếp tục.');
        redirect('/login');
    }
}

function require_role(string $role): void {
    require_login();
    if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== $role) {
        log_error("Unauthorized access attempt by user_id: " . $_SESSION['user_id']);
        http_response_code(403);
        die('Bạn không có quyền thực hiện chức năng này.');
    }
}

if (!function_exists('require_login')) {
    function require_login(): void {
        // Kiểm tra xem biến session user_id có trống không
        if (empty($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, lưu thông báo lỗi và ép quay về trang login
            flash('error', 'Vui lòng đăng nhập để truy cập trang này.');
            redirect('/login');
            exit; // Dừng lập tức mọi luồng code phía sau
        }
    }
}
if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token']) . '">';
    }
}