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
    <h2 class="fw-bold">Patients</h2>
    <a href="/patients/create" class="btn btn-primary px-4">+ Create Patient</a>
</div>

<div class="card card-custom p-3 mb-4 bg-white">
    <form method="GET" action="/patients" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">Search</span>
                <input type="text" name="q" class="form-control border-start-0" value="<?= e($keyword ?? '') ?>" placeholder="Tên, email, SĐT...">
            </div>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select text-muted">
                <option value="created_at" <?= ($sort ?? '') === 'created_at' ? 'selected' : '' ?>>Sắp xếp: Ngày tạo</option>
                <option value="name" <?= ($sort ?? '') === 'name' ? 'selected' : '' ?>>Sắp xếp: Tên</option>
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

<div class="card card-custom bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên Bệnh nhân</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr><td colspan="7" class="text-center py-4">Không tìm thấy dữ liệu.</td></tr>
                <?php else: ?>
                    <?php foreach ($patients as $p): ?>
                    <tr>
                        <td class="text-muted">#<?= e((string)$p['id']) ?></td>
                        <td class="fw-medium"><?= e($p['name']) ?></td>
                        <td><?= e($p['email']) ?></td>
                        <td><?= e($p['phone']) ?></td>
                        <td>
                            <?php 
                                $bg = match($p['status']) {
                                    'new' => 'bg-primary',
                                    'consulting' => 'bg-warning text-dark',
                                    'treated' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge rounded-pill <?= $bg ?> px-3 py-2"><?= e($p['status']) ?></span>
                        </td>
                        <td class="text-muted small"><?= e(date('d/m/Y', strtotime($p['created_at']))) ?></td>
                        <td>
                            <a href="/patients/edit?id=<?= e((string)$p['id']) ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                        </td>
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
                    <a class="page-link" href="/patients?page=<?= $i ?>&q=<?= urlencode($keyword ?? '') ?>&sort=<?= urlencode($sort ?? '') ?>&dir=<?= urlencode($dir ?? '') ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php endif; ?>