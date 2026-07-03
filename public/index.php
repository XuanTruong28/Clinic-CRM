<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Bật session an toàn
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../app/Core/Exceptions.php';
require_once __DIR__ . '/../app/Core/helpers.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';

// Tự động load Controllers, Services, Repositories (Đơn giản hóa thay vì dùng Composer autoloader)
$directories = ['Controllers', 'Services', 'Repositories'];
foreach ($directories as $dir) {
    foreach (glob(__DIR__ . "/../app/{$dir}/*.php") as $file) {
        require_once $file;
    }
}

try {
    verify_csrf(); // BONUS: Kiểm tra CSRF cho mọi request POST
    
    $router = new Router();

    // Khai báo Routes
    $router->get('/', [AuthController::class, 'login']);
    $router->get('/login', [AuthController::class, 'login']);
    $router->post('/login', [AuthController::class, 'handleLogin']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->get('/dashboard', [DashboardController::class, 'index']);
    
    // Patient Routes
    $router->get('/patients', [PatientController::class, 'index']);
    $router->get('/patients/create', [PatientController::class, 'create']);
    $router->post('/patients/store', [PatientController::class, 'store']);
    $router->get('/patients/edit', [PatientController::class, 'edit']);
    $router->post('/patients/update', [PatientController::class, 'update']);
    $router->post('/patients/delete', [PatientController::class, 'delete']);

    // Appointment Routes
    $router->get('/appointments', [AppointmentController::class, 'index']);
    $router->get('/appointments/create', [AppointmentController::class, 'create']);
    $router->post('/appointments/store', [AppointmentController::class, 'store']);
    $router->get('/appointments/edit', [AppointmentController::class, 'edit']);
    $router->post('/appointments/update', [AppointmentController::class, 'update']);
    $router->post('/appointments/delete', [AppointmentController::class, 'delete']);

    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

} catch (CsrfTokenMismatchException $e) {
    http_response_code(419);
    die($e->getMessage());
} catch (Throwable $e) {
    log_error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    $appConfig = require __DIR__ . '/../config/app.php';
    
    http_response_code(500);
    if ($appConfig['debug']) {
        die("<h1>Lỗi hệ thống (Debug Mode):</h1><p>" . $e->getMessage() . "</p><pre>" . $e->getTraceAsString() . "</pre>");
    } else {
        render('errors/500', ['title' => '500 Internal Server Error']);
    }
}