<?php
/**
 * @var string $title
 * @var array $patients
 * @var string $keyword
 * @var int $page
 * @var int $totalPages
 */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Appointments</h2>
    <a href="/appointments/create" class="btn btn-primary px-4">+ Create Appointment</a>
</div>

<div class="card card-custom p-3 mb-4 bg-white">
    <form method="GET" action="/appointments" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">Search</span>
                <input type="text" name="q" class="form-control border-start-0" value="<?= e($keyword ?? '') ?>" placeholder="Mã hẹn, email, tên...">
            </div>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select text-muted">
                <option value="created_at" <?= ($sort ?? '') === 'created_at' ? 'selected' : '' ?>>Sắp xếp: Ngày tạo</option>
                <option value="appointment_code" <?= ($sort ?? '') === 'appointment_code' ? 'selected' : '' ?>>Sắp xếp: Mã lịch</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="dir" class="form-select text-muted">
                <option value="DESC" <?= strtoupper($dir ?? '') === 'DESC' ? 'selected' : '' ?>>Giảm dần</option>
                <option value="ASC" <?= strtoupper($dir ?? '') === 'ASC' ? 'selected' : '' ?>>Tăng dần</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark w-100">Filter</button>
        </div>
    </form>
</div>

<div class="card card-custom bg-white shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Mã lịch (Order Code)</th><th>Tên Bệnh nhân</th><th>Email</th><th>Trạng thái</th><th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                    <tr><td colspan="6" class="text-center py-4">Chưa có lịch hẹn nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($appointments as $apt): ?>
                    <tr>
                        <td class="text-muted">#<?= e((string)$apt['id']) ?></td>
                        <td class="fw-medium"><?= e($apt['appointment_code']) ?></td>
                        <td><?= e($apt['patient_name']) ?></td>
                        <td><?= e($apt['patient_email']) ?></td>
                        <td>
                            <?php 
                                $bg = match($apt['status']) {
                                    'pending' => 'bg-warning text-dark',
                                    'confirmed' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge rounded-pill <?= $bg ?> px-3 py-2"><?= e($apt['status']) ?></span>
                        </td>
                        <td class="text-muted small"><?= e(date('d/m/Y', strtotime($apt['created_at']))) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (($totalPages ?? 1) > 1): ?>
<div class="d-flex justify-content-between align-items-center mt-4">
    <span class="text-muted small">Showing results</span>
    <nav>
        <ul class="pagination pagination-sm mb-0">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($page ?? 1) === $i ? 'active' : '' ?>">
                    <a class="page-link" href="/appointments?page=<?= $i ?>&q=<?= urlencode($keyword ?? '') ?>&sort=<?= urlencode($sort ?? '') ?>&dir=<?= urlencode($dir ?? '') ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php endif; ?>