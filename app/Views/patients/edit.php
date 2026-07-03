<div style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Cập nhật Bệnh nhân #<?= e((string)$id) ?></h2>
        <a href="/patients" style="color: #7f8c8d; text-decoration: none;">&larr; Quay lại</a>
    </div>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-error"><?= e($errors['general']) ?></div>
    <?php endif; ?>

    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <form action="/patients/update" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= e((string)$id) ?>">
            
            <div class="form-group">
                <label>Tên bệnh nhân (*)</label>
                <input type="text" name="name" value="<?= old('name') ?>" required>
                <?php if (isset($errors['name'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['name']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Số điện thoại (*)</label>
                <input type="text" name="phone" value="<?= old('phone') ?>" required>
                <?php if (isset($errors['phone'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['phone']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Email (Tùy chọn)</label>
                <input type="email" name="email" value="<?= old('email') ?>">
                <?php if (isset($errors['email'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['email']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select name="status">
                    <option value="new" <?= old('status') === 'new' ? 'selected' : '' ?>>Mới</option>
                    <option value="consulting" <?= old('status') === 'consulting' ? 'selected' : '' ?>>Đang tư vấn</option>
                    <option value="treated" <?= old('status') === 'treated' ? 'selected' : '' ?>>Đã điều trị</option>
                    <option value="cancelled" <?= old('status') === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                </select>
                <?php if (isset($errors['status'])): ?><span style="color: red; font-size: 13px;"><?= e($errors['status']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="note" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><?= old('note') ?></textarea>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Cập nhật Bệnh nhân</button>
        </form>
    </div>

    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <div style="background: #fff3f3; padding: 20px; border-radius: 8px; border: 1px solid #ffcccc;">
            <h3 style="color: #c0392b; margin-top: 0;">Khu vực nguy hiểm</h3>
            <p style="font-size: 14px;">Hành động này sẽ xóa mềm hồ sơ bệnh nhân khỏi hệ thống.</p>
            <form action="/patients/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bệnh nhân này?');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= e((string)$id) ?>">
                <button type="submit" style="background: #e74c3c; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">Xóa Bệnh nhân</button>
            </form>
        </div>
    <?php endif; ?>
</div>