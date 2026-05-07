<?php
$page_title = 'Courses';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM courses WHERE id=$id");
    redirect(SITE_URL . '/admin/courses.php?msg=deleted');
}

$msg = $_GET['msg'] ?? '';
$courses = $conn->query("SELECT * FROM courses ORDER BY created_at DESC");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title">Courses Management</div>
        </div>
        <a href="course_form.php" class="btn btn-grad"><i class="fas fa-plus me-2"></i>Add Course</a>
    </div>
    <div class="admin-main">
        <?php if ($msg === 'saved'): ?><div class="alert alert-success alert-custom">Course saved successfully!</div><?php endif; ?>
        <?php if ($msg === 'deleted'): ?><div class="alert alert-danger alert-custom">Course deleted!</div><?php endif; ?>

        <div class="admin-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-book me-2" style="color:var(--secondary);"></i>All Courses</div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="tableSearch" class="form-control" placeholder="Search courses...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>#</th><th>Course</th><th>Code</th><th>Duration</th><th>Fee</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if ($courses && $courses->num_rows > 0): $i=1; while ($c = $courses->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#aaa;"><?= $i++ ?></td>
                        <td>
                            <div style="font-weight:600;"><?= htmlspecialchars($c['course_name']) ?></div>
                            <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars(substr($c['description'],0,60)) ?>...</div>
                        </td>
                        <td><span style="background:#f0f0f0;padding:3px 10px;border-radius:6px;font-size:0.82rem;font-weight:600;"><?= htmlspecialchars($c['course_code']) ?></span></td>
                        <td style="font-size:0.88rem;"><?= htmlspecialchars($c['duration']) ?></td>
                        <td style="font-weight:700;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">₹<?= number_format($c['fee']) ?></td>
                        <td><span class="badge-<?= $c['status'] ?>"><?= ucfirst($c['status']) ?></span></td>
                        <td>
                            <a href="course_form.php?id=<?= $c['id'] ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete('courses.php?delete=<?= $c['id'] ?>','<?= htmlspecialchars($c['course_name']) ?>')" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">No courses found</td></tr>
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
