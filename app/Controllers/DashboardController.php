<?php
class DashboardController {
    public function index(): void {
        require_login(); 

        $db = Database::connect(require __DIR__ . '/../../config/database.php');

        // 1. Lấy 5 bệnh nhân mới nhất cho danh sách bên dưới
        $stmt = $db->query("SELECT * FROM patients ORDER BY created_at DESC LIMIT 5");
        $recentPatients = $stmt->fetchAll();

        // 2. Đếm số Bệnh nhân mới (trạng thái 'new')
        $stmtNew = $db->query("SELECT COUNT(*) as total FROM patients WHERE status = 'new'");
        $newPatientsCount = $stmtNew->fetch()['total'] ?? 0;

        // 3. Đếm số Bệnh nhân đang tư vấn (trạng thái 'consulting')
        $stmtConsulting = $db->query("SELECT COUNT(*) as total FROM patients WHERE status = 'consulting'");
        $consultingCount = $stmtConsulting->fetch()['total'] ?? 0;

        // 4. Đếm tổng số Lịch hẹn
        $stmtAppt = $db->query("SELECT COUNT(*) as total FROM appointments");
        $appointmentsCount = $stmtAppt->fetch()['total'] ?? 0;

        // 5. Tính doanh thu dự kiến (Giả sử mỗi lịch hẹn trị giá 500.000 VNĐ)
        // Chia 1.000.000 để ra đơn vị Triệu (M)
        $expectedRevenue = ($appointmentsCount * 500000) / 1000000;

        // Truyền toàn bộ data thật ra View
        render('dashboard/index', [
            'title' => 'Dashboard',
            'recentPatients' => $recentPatients,
            'newPatientsCount' => $newPatientsCount,
            'consultingCount' => $consultingCount,
            'appointmentsCount' => $appointmentsCount,
            'expectedRevenue' => number_format($expectedRevenue, 1) . 'M'
        ]);
    }
}