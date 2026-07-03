<?php
/**
 * @var string $title
 * @var array $errors
 * @var array $old
 */
?>
<h2 class="fw-bold mb-4">Create Appointment</h2>
<p class="text-muted small mb-4">POST /appointments/store - mã lịch không được trùng, email hợp lệ nếu có.</p>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 border-0 shadow-sm">
            <form action="/appointments/store" method="POST">
                <input type="text" name="website_url" id="honeypot_field" style="display:none;" value="">
                <?= csrf_field() ?>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Mã lịch hẹn</label>
                    <div class="col-sm-9">
                        <input type="text" name="appointment_code" class="form-control bg-light <?= isset($errors['appointment_code']) ? 'is-invalid' : '' ?>" value="<?= e($old['appointment_code'] ?? 'APT-2026-') ?>">
                        <div class="invalid-feedback"><?= e($errors['appointment_code'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Tên Bệnh nhân</label>
                    <div class="col-sm-9">
                        <input type="text" name="patient_name" class="form-control <?= isset($errors['patient_name']) ? 'is-invalid' : '' ?>" value="<?= e($old['patient_name'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['patient_name'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Email Bệnh nhân</label>
                    <div class="col-sm-9">
                        <input type="email" name="patient_email" class="form-control <?= isset($errors['patient_email']) ? 'is-invalid' : '' ?>" value="<?= e($old['patient_email'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['patient_email'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Ngày hẹn</label>
                    <div class="col-sm-9">
                        <input type="datetime-local" name="appointment_date" class="form-control <?= isset($errors['appointment_date']) ? 'is-invalid' : '' ?>" value="<?= e($old['appointment_date'] ?? '') ?>">
                        <div class="invalid-feedback"><?= e($errors['appointment_date'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <label class="col-sm-3 col-form-label fw-medium">Trạng thái</label>
                    <div class="col-sm-9">
                        <select name="status" class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>">
                            <option value="pending" <?= ($old['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Chờ xác nhận (Pending)</option>
                            <option value="confirmed" <?= ($old['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                            <option value="completed" <?= ($old['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Đã khám xong</option>
                            <option value="cancelled" <?= ($old['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Hủy bỏ</option>
                        </select>
                        <div class="invalid-feedback"><?= e($errors['status'] ?? '') ?></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary px-4 py-2">Save Appointment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom p-4 bg-light shadow-sm">
            <h5 class="mb-4">Appointment rules</h5>
            <div class="d-flex flex-column gap-3">
                <div class="text-success small">✅ appointment_code required + unique</div>
                <div class="text-success small">✅ patient_name required</div>
                <div class="text-success small">✅ patient_email format if entered</div>
                <div class="text-success small">✅ status in whitelist</div>
                <div class="text-success small">✅ PRG after success</div>
            </div>
        </div>
    </div>
</div>