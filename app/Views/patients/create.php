<?php
/**
 * @var string $title
 * @var array $errors
 * @var array $old
 */
?>

<h2 class="fw-bold mb-4">Create Patient</h2>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 border-0">
            <form action="/patients/store" method="POST">
                <?= csrf_field() ?>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Họ và Tên</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= e($old['name'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['name'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= e($old['email'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['email'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Số điện thoại</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" value="<?= e($old['phone'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['phone'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Trạng thái</label>
                    <div class="col-sm-9">
                        <select name="status" class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>">
                            <option value="new" <?= ($old['status'] ?? '') === 'new' ? 'selected' : '' ?>>Mới (New)</option>
                            <option value="consulting" <?= ($old['status'] ?? '') === 'consulting' ? 'selected' : '' ?>>Đang tư vấn</option>
                            <option value="treated" <?= ($old['status'] ?? '') === 'treated' ? 'selected' : '' ?>>Đã điều trị</option>
                        </select>
                        <div class="invalid-feedback"><?= e($errors['status'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label fw-medium">Ghi chú</label>
                    <div class="col-sm-9">
                        <textarea name="note" class="form-control" rows="3"><?= e($old['note'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary px-4 py-2">Save Patient</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom p-4 bg-light">
            <h5 class="mb-4">Secure flow</h5>
            <div class="d-flex flex-column gap-3">
                <div class="p-2 bg-white rounded shadow-sm text-muted">1. Read POST safely</div>
                <div class="p-2 bg-white rounded shadow-sm text-muted">2. Server-side validation</div>
                <div class="p-2 bg-white rounded shadow-sm text-muted">3. Honeypot/rate limit</div>
                <div class="p-2 bg-white rounded shadow-sm text-muted">4. Prepared INSERT</div>
                <div class="p-2 bg-white rounded shadow-sm text-muted">5. DuplicateRecordException</div>
                <div class="p-2 bg-white rounded shadow-sm text-muted">6. Render friendly error</div>
            </div>
        </div>
    </div>
</div>