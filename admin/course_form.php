<?php
$page_title = 'Course Form';
require_once 'includes/sidebar.php';

$course = ['id'=>'','course_name'=>'','course_code'=>'','description'=>'','duration'=>'','fee'=>'','status'=>'active'];
$edit = false;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM courses WHERE id=$id");
    if ($res && $res->num_rows) { $course = $res->fetch_assoc(); $edit = true; }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = sanitize($conn, $_POST['course_name']);
    $course_code = sanitize($conn, $_POST['course_code']);
    $description = sanitize($conn, $_POST['description']);
    $duration = sanitize($conn, $_POST['duration']);
    $fee = (float)$_POST['fee'];
    $status = sanitize($conn, $_POST['status']);
    $cid = (int)$_POST['id'];

    if ($cid) {
        $sql = "UPDATE courses SET course_name='$course_name', course_code='$course_code', description='$description', duration='$duration', fee=$fee, status='$status' WHERE id=$cid";
    } else {
        $sql = "INSERT INTO courses (course_name, course_code, description, duration, fee, status) VALUES ('$course_name','$course_code','$description','$duration',$fee,'$status')";
    }

    if ($conn->query($sql)) redirect(SITE_URL . '/admin/courses.php?msg=saved');
    else $error = "Error: " . $conn->error;
}
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title"><?= $edit ? 'Edit Course' : 'Add New Course' ?></div>
        </div>
        <a href="courses.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>
    <div class="admin-main">
        <?php if ($error): ?><div class="alert alert-danger alert-custom"><?= $error ?></div><?php endif; ?>
        <div class="admin-card" style="max-width:700px;">
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $course['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-600" style="font-weight:600;">Course Name *</label>
                        <input type="text" name="course_name" class="form-control" value="<?= htmlspecialchars($course['course_name']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-weight:600;">Course Code *</label>
                        <input type="text" name="course_code" class="form-control" value="<?= htmlspecialchars($course['course_code']) ?>" placeholder="e.g. PY101" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-weight:600;">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($course['description']) ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-weight:600;">Duration</label>
                        <input type="text" name="duration" class="form-control" value="<?= htmlspecialchars($course['duration']) ?>" placeholder="e.g. 3 Months">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-weight:600;">Fee (₹)</label>
                        <input type="number" name="fee" class="form-control" value="<?= $course['fee'] ?>" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-weight:600;">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?= $course['status']=='active'?'selected':'' ?>>Active</option>
                            <option value="inactive" <?= $course['status']=='inactive'?'selected':'' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-3">
                        <button type="submit" class="btn btn-grad"><i class="fas fa-save me-2"></i><?= $edit ? 'Update Course' : 'Add Course' ?></button>
                        <a href="courses.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
