<style>
    body {
        /* Thay 'anh-cua-minh.jpg' bằng tên file ảnh của bạn */
        background: url('/images/back.jpg') no-repeat center center fixed;
        background-size: cover;
    }
    
    /* Lớp phủ mờ trắng nhẹ (White overlay with blur) */
    .login-bg-overlay {
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        background-color: rgba(255, 255, 255, 0); 
        backdrop-filter: blur(5px); /* Hiệu ứng làm mờ ảnh (như kính) */
        z-index: -1; /* Đẩy lớp phủ xuống dưới form đăng nhập */
    }
    
    /* Làm form đăng nhập nổi bật hơn một chút trên nền mờ */
    .login-card {
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="login-bg-overlay"></div>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom login-card p-4 border-0 mt-4">
            <h2 class="fw-bold mb-2">Login</h2>
            <p class="text-muted small mb-4 border-bottom pb-3">Sau khi login đúng: session_regenerate_id(true), set session user, flash success, redirect /dashboard.</p>
            
            <form action="/login" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email" name="email" class="form-control bg-light" value="<?= e($old['email'] ?? '') ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Password</label>
                    <input type="password" name="password" class="form-control bg-light" required>
                </div>
                
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label text-muted" for="rememberMe">
                        <span class="small d-block text-dark">Remember me</span>
                        <span style="font-size: 0.75rem;">Không lưu password trong cookie; chỉ giới thiệu rủi ro và token nhớ đăng nhập.</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-3">Login</button>
            </form>
        </div>
    </div>
</div>