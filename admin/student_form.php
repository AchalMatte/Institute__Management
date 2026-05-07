<?php
$page_title = 'Student Form';
require_once 'includes/sidebar.php';

$student = ['id'=>'','full_name'=>'','student_id'=>'','email'=>'','phone'=>'','address'=>'','batch_id'=>'','enrollment_date'=>'','status'=>'active'];
$edit = false;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM students WHERE id=$id");
    if ($res && $res->num_rows) { $student = $res->fetch_assoc(); $edit = true; }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($conn, $_POST['full_name']);
    $student_id = sanitize($conn, $_POST['student_id']);
    $email = sanitize($conn, $_POST['email']);
    $phone = sanitize($conn, $_POST['phone']);
    $address = sanitize($conn, $_POST['address']);
    $batch_id = (int)$_POST['batch_id'];
    $enrollment_date = sanitize($conn, $_POST['enrollment_date']);
    $status = sanitize($conn, $_POST['status']);
    $sid = (int)$_POST['id'];

    if ($sid) {
        $sql = "UPDATE students SET full_name='$full_name', student_id='$student_id', email='$email', phone='$phone', address='$address', batch_id=" . ($batch_id ?: 'NULL') . ", enrollment_date=" . ($enrollment_date ? "'$enrollment_date'" : 'NULL') . ", status='$status' WHERE id=$sid";
    } else {
        $sql = "INSERT INTO students (full_name, student_id, email, phone, address, batch_id, enrollment_date, status) VALUES ('$full_name','$student_id','$email','$phone','$address'," . ($batch_id ?: 'NULL') . "," . ($enrollment_date ? "'$enrollment_date'" : 'NULL') . ",'$status')";
    }

    if ($conn->query($sql)) redirect(SITE_URL . '/admin/students.php?msg=saved');
    else $error = "Error: " . $conn->error;
}

$batches = $conn->query("SELECT b.*, c.course_name FROM batches b LEFT JOIN courses c ON b.course_id=c.id ORDER BY b.batch_name");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title"><?= $edit ? 'Edit Student' : 'Add New Student' ?></div>
        </div>
        <a href="students.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>
    <div class="admin-main">
        <?php if ($error): ?><div class="alert alert-danger alert-custom"><?= $error ?></div><?php endif; ?>
        <div class="admin-card" style="max-width:800px;">
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $student['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Full Name *</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Student ID *</label>
                        <input type="text" name="student_id" class="form-control" value="<?= htmlspecialchars($student['student_id']) ?>" placeholder="e.g. ACE2024001" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Email *</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Phone</label>
                        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($student['phone']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Batch</label>
                        <select name="batch_id" class="form-control">
                            <option value="">-- Select Batch --</option>
                            <?php if ($batches): while ($b = $batches->fetch_assoc()): ?>
                            <option value="<?= $b['id'] ?>" <?= $student['batch_id']==$b['id']?'selected':'' ?>><?= htmlspecialchars($b['batch_name']) ?> (<?= htmlspecialchars($b['course_name'] ?? '') ?>)</option>
                            <?php endwhile; endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Enrollment Date</label>
                        <input type="date" name="enrollment_date" class="form-control" value="<?= $student['enrollment_date'] ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-weight:600;">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($student['address']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?= $student['status']=='active'?'selected':'' ?>>Active</option>
                            <option value="inactive" <?= $student['status']=='inactive'?'selected':'' ?>>Inactive</option>
                            <option value="completed" <?= $student['status']=='completed'?'selected':'' ?>>Completed</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-3">
                        <button type="submit" class="btn btn-grad"><i class="fas fa-save me-2"></i><?= $edit ? 'Update Student' : 'Add Student' ?></button>
                        <a href="students.php" class="btn btn-outline-secondary">Cancel</a>
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
