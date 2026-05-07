<?php
$page_title = 'Batches';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM batches WHERE id=$id");
    redirect(SITE_URL . '/admin/batches.php?msg=deleted');
}

$msg = $_GET['msg'] ?? '';
$batches = $conn->query("SELECT b.*, c.course_name, (SELECT COUNT(*) FROM students WHERE batch_id=b.id) as student_count FROM batches b LEFT JOIN courses c ON b.course_id=c.id ORDER BY b.created_at DESC");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title">Batches Management</div>
        </div>
        <a href="batch_form.php" class="btn btn-grad"><i class="fas fa-plus me-2"></i>Add Batch</a>
    </div>
    <div class="admin-main">
        <?php if ($msg === 'saved'): ?><div class="alert alert-success alert-custom">Batch saved successfully!</div><?php endif; ?>
        <?php if ($msg === 'deleted'): ?><div class="alert alert-danger alert-custom">Batch deleted!</div><?php endif; ?>

        <div class="admin-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-layer-group me-2" style="color:#28a745;"></i>All Batches</div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="tableSearch" class="form-control" placeholder="Search batches...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>#</th><th>Batch Name</th><th>Course</th><th>Timing</th><th>Duration</th><th>Students</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if ($batches && $batches->num_rows > 0): $i=1; while ($b = $batches->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#aaa;"><?= $i++ ?></td>
                        <td style="font-weight:600;"><?= htmlspecialchars($b['batch_name']) ?></td>
                        <td style="font-size:0.88rem;"><?= htmlspecialchars($b['course_name'] ?? 'N/A') ?></td>
                        <td style="font-size:0.85rem;"><?= htmlspecialchars($b['timing'] ?? 'N/A') ?></td>
                        <td style="font-size:0.82rem;color:#888;">
                            <?= $b['start_date'] ? date('d M Y', strtotime($b['start_date'])) : 'N/A' ?>
                            <?= $b['end_date'] ? ' - ' . date('d M Y', strtotime($b['end_date'])) : '' ?>
                        </td>
                        <td>
                            <span style="background:rgba(108,63,197,0.1);color:var(--primary);padding:3px 10px;border-radius:50px;font-size:0.82rem;font-weight:600;">
                                <?= $b['student_count'] ?>/<?= $b['capacity'] ?>
                            </span>
                        </td>
                        <td><span class="badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                        <td>
                            <a href="batch_form.php?id=<?= $b['id'] ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete('batches.php?delete=<?= $b['id'] ?>','<?= htmlspecialchars($b['batch_name']) ?>')" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-5">No batches found</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
