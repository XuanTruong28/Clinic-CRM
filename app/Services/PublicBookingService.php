<?php
class PublicBookingService {
    public function handlePublicBooking(array $postData): array {
    $errors = [];
    
        // 1. RATE LIMIT: Chặn nếu submit quá nhanh (dưới 5 giây)
        if (isset($_SESSION['last_submit_time'])) {
            $timePassed = time() - $_SESSION['last_submit_time'];
            if ($timePassed < 5) {
                $errors['general'] = 'Bạn thao tác quá nhanh. Vui lòng đợi 5 giây!';
                return ['success' => false, 'errors' => $errors];
            }
        }

        // 2. HONEYPOT: Chặn nếu ô ẩn bị điền
        if (!empty($postData['website_url'])) {
            $errors['general'] = 'Hệ thống phát hiện hành vi nghi ngờ là bot!';
            return ['success' => false, 'errors' => $errors];
        }
        
        
        // [T07] - VALIDATE DỮ LIỆU BẮT BUỘC
        $name = trim($postData['name'] ?? '');
        $email = trim($postData['email'] ?? '');

        if ($name === '') {
            $errors['name'] = 'Họ tên không được để trống.';
        }
        if ($email === '') {
            $errors['email'] = 'Email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors, 'old' => $postData];
        }

        // Ghi nhận thời gian submit thành công
        $_SESSION['last_submit_time'] = time();
        return ['success' => true, 'errors' => []];
    }
}