<?php
$page_title = 'Students';
require_once 'includes/sidebar.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    redirect(SITE_URL . '/admin/students.php?msg=deleted');
}

$msg = $_GET['msg'] ?? '';
$search = sanitize($conn, $_GET['search'] ?? '');
$where = $search ? "WHERE s.full_name LIKE '%$search%' OR s.student_id LIKE '%$search%' OR s.email LIKE '%$search%'" : '';
$students = $conn->query("SELECT s.*, b.batch_name, c.course_name FROM students s LEFT JOIN batches b ON s.batch_id=b.id LEFT JOIN courses c ON b.course_id=c.id $where ORDER BY s.created_at DESC");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title">Students Management</div>
        </div>
        <a href="student_form.php" class="btn btn-grad"><i class="fas fa-plus me-2"></i>Add Student</a>
    </div>
    <div class="admin-main">
        <?php if ($msg === 'saved'): ?><div class="alert alert-success alert-custom">Student saved successfully!</div><?php endif; ?>
        <?php if ($msg === 'deleted'): ?><div class="alert alert-danger alert-custom">Student deleted successfully!</div><?php endif; ?>

        <div class="admin-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-user-graduate me-2" style="color:var(--primary);"></i>All Students</div>
                <form method="GET" class="d-flex gap-2">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Search students..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <button type="submit" class="btn btn-grad">Search</button>
                    <?php if ($search): ?><a href="students.php" class="btn btn-outline-secondary">Clear</a><?php endif; ?>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Student</th><th>Contact</th><th>Batch / Course</th><th>Enrolled</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                    <?php if ($students && $students->num_rows > 0): $i=1; while ($s = $students->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#aaa;font-size:0.85rem;"><?= $i++ ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="student-avatar"><?= strtoupper(substr($s['full_name'],0,1)) ?></div>
                                <div>
                                    <div style="font-weight:600;font-size:0.9rem;"><?= htmlspecialchars($s['full_name']) ?></div>
                                    <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($s['student_id']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:0.85rem;"><?= htmlspecialchars($s['email']) ?></div>
                            <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($s['phone']) ?></div>
                        </td>
                        <td>
                            <div style="font-size:0.85rem;font-weight:600;"><?= htmlspecialchars($s['batch_name'] ?? 'N/A') ?></div>
                            <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($s['course_name'] ?? '') ?></div>
                        </td>
                        <td style="font-size:0.82rem;color:#888;"><?= $s['enrollment_date'] ? date('d M Y', strtotime($s['enrollment_date'])) : 'N/A' ?></td>
                        <td><span class="badge-<?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
                        <td>
                            <a href="student_form.php?id=<?= $s['id'] ?>" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete('students.php?delete=<?= $s['id'] ?>','<?= htmlspecialchars($s['full_name']) ?>')" class="btn-action btn-delete" title="Delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-5"><i class="fas fa-user-graduate fa-2x mb-2 d-block"></i>No students found</td></tr>
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
