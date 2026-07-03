<h2 class="fw-bold mb-4">Đặt lịch khám công khai</h2>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert-danger"><?= e($errors['general']) ?></div>
<?php endif; ?>

<form action="/public-booking" method="POST">
    <!-- [T09] - ẨN HONEYPOT FIELD BẰNG CSS -->
    <input type="text" name="website_url" style="display:none;" value="">

    <div class="mb-3">
        <label class="form-label">Họ và Tên</label>
        <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= e($old['name'] ?? '') ?>">
        <div class="invalid-feedback"><?= $errors['name'] ?? '' ?></div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= e($old['email'] ?? '') ?>">
        <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
    </div>

    <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
</form>
