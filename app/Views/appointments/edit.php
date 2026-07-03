    <?php
    /**
     * @var int $id
     */
    ?>
<div style="max-width: 600px; margin: 0 auto;">
    <h2>Cập nhật Lịch hẹn #<?= e((string)$id) ?></h2>
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <form action="/appointments/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= e((string)$id) ?>">
            <div class="form-group">
                <label>Mã Lịch Hẹn (*)</label>
                <input type="text" name="appointment_code" value="<?= old('appointment_code') ?>" required readonly style="background: #eee;">
                <?php if (isset($errors['appointment_code'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['appointment_code']) ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Tên Bệnh nhân (*)</label>
                <input type="text" name="patient_name" value="<?= old('patient_name') ?>" required>
                <?php if (isset($errors['patient_name'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['patient_name']) ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="patient_email" value="<?= old('patient_email') ?>">
            </div>
            <div class="form-group">
                <label>Ngày giờ hẹn (*)</label>
                <input type="datetime-local" name="appointment_date" value="<?= old('appointment_date') ?>" required>
            </div>
            <div class="form-group">
                <label>Trạng thái</label>
                <select name="status">
                    <option value="pending" <?= old('status') === 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="confirmed" <?= old('status') === 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="completed" <?= old('status') === 'completed' ? 'selected' : '' ?>>Đã hoàn tất</option>
                    <option value="cancelled" <?= old('status') === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Cập nhật Lịch Hẹn</button>
        </form>
    </div>

    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <div style="background: #fff3f3; padding: 20px; border-radius: 8px; border: 1px solid #ffcccc;">
            <form action="/appointments/delete" method="POST" onsubmit="return confirm('Xác nhận xóa lịch hẹn này?');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= e((string)$id) ?>">
                <button type="submit" style="background: #e74c3c; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">Xóa Lịch Hẹn</button>
            </form>
        </div>
    <?php endif; ?>
</div>