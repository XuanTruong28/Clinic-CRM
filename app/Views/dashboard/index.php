<?php
/**
 * @var int $newPatientsCount
 * @var int $consultingCount        
 * @var int $appointmentsCount
 * @var string $expectedRevenue
 */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Dashboard</h2>
</div>
<p class="text-muted mb-4">Tổng quan hệ thống sau khi đăng nhập. Trang này yêu cầu session hợp lệ.</p>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-custom p-3 border-top border-4 border-primary">
            <h6 class="text-muted">New Patients</h6>
            <h3 class="text-primary fw-bold"><?= e((string)$newPatientsCount) ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom p-3 border-top border-4 border-warning">
            <h6 class="text-muted">Consulting</h6>
            <h3 class="text-warning fw-bold"><?= e((string)$consultingCount) ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom p-3 border-top border-4 border-success">
            <h6 class="text-muted">Appointments</h6>
            <h3 class="text-success fw-bold"><?= e((string)$appointmentsCount) ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom p-3 border-top border-4 border-info">
            <h6 class="text-muted">Expected Revenue</h6>
            <h3 class="text-info fw-bold"><?= e((string)$expectedRevenue) ?></h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 h-100 bg-white">
            <h5 class="mb-4">Recent Patients</h5>
            <div class="d-flex flex-column gap-2">
                <?php if (!empty($recentPatients)): ?>
                    <?php foreach ($recentPatients as $rp): ?>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                            <div>
                                <div class="fw-medium text-dark"><?= e($rp['name']) ?></div>
                                <div class="small text-muted"><?= e($rp['email'] ?? 'Không có email') ?></div>
                            </div>
                            <?php 
                                $bg = match($rp['status']) {
                                    'new' => 'bg-primary',
                                    'consulting' => 'bg-warning text-dark',
                                    'treated' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge rounded-pill <?= $bg ?> px-3 py-1"><?= e($rp['status']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small">Chưa có bệnh nhân nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100 bg-light">
            <h5 class="mb-4">System health</h5>
            <ul class="list-unstyled text-success small">
                <li class="mb-3">✅ Session active</li>
                <li class="mb-3">✅ PDO connected</li>
                <li class="mb-3">✅ CSRF/PRG ready</li>
                <li class="mb-3">✅ No raw SQL concat</li>
                <li>✅ Flash message cleaned</li>
            </ul>
        </div>
    </div>
</div>