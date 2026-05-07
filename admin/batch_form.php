<?php
$page_title = 'Batch Form';
require_once 'includes/sidebar.php';

$batch = ['id'=>'','batch_name'=>'','course_id'=>'','start_date'=>'','end_date'=>'','timing'=>'','capacity'=>30,'status'=>'upcoming'];
$edit = false;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM batches WHERE id=$id");
    if ($res && $res->num_rows) { $batch = $res->fetch_assoc(); $edit = true; }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batch_name = sanitize($conn, $_POST['batch_name']);
    $course_id = (int)$_POST['course_id'];
    $start_date = sanitize($conn, $_POST['start_date']);
    $end_date = sanitize($conn, $_POST['end_date']);
    $timing = sanitize($conn, $_POST['timing']);
    $capacity = (int)$_POST['capacity'];
    $status = sanitize($conn, $_POST['status']);
    $bid = (int)$_POST['id'];

    $sd = $start_date ? "'$start_date'" : 'NULL';
    $ed = $end_date ? "'$end_date'" : 'NULL';
    $ci = $course_id ?: 'NULL';

    if ($bid) {
        $sql = "UPDATE batches SET batch_name='$batch_name', course_id=$ci, start_date=$sd, end_date=$ed, timing='$timing', capacity=$capacity, status='$status' WHERE id=$bid";
    } else {
        $sql = "INSERT INTO batches (batch_name, course_id, start_date, end_date, timing, capacity, status) VALUES ('$batch_name',$ci,$sd,$ed,'$timing',$capacity,'$status')";
    }

    if ($conn->query($sql)) redirect(SITE_URL . '/admin/batches.php?msg=saved');
    else $error = "Error: " . $conn->error;
}

$courses = $conn->query("SELECT * FROM courses WHERE status='active' ORDER BY course_name");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title"><?= $edit ? 'Edit Batch' : 'Add New Batch' ?></div>
        </div>
        <a href="batches.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>
    <div class="admin-main">
        <?php if ($error): ?><div class="alert alert-danger alert-custom"><?= $error ?></div><?php endif; ?>
        <div class="admin-card" style="max-width:700px;">
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $batch['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-600" style="font-weight:600;">Batch Name *</label>
                        <input type="text" name="batch_name" class="form-control" value="<?= htmlspecialchars($batch['batch_name']) ?>" placeholder="e.g. Python Batch A - Jan 2025" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-weight:600;">Capacity</label>
                        <input type="number" name="capacity" class="form-control" value="<?= $batch['capacity'] ?>" min="1">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-weight:600;">Course</label>
                        <select name="course_id" class="form-control">
                            <option value="">-- Select Course --</option>
                            <?php if ($courses): while ($c = $courses->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>" <?= $batch['course_id']==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['course_name']) ?></option>
                            <?php endwhile; endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $batch['start_date'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $batch['end_date'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Timing</label>
                        <input type="text" name="timing" class="form-control" value="<?= htmlspecialchars($batch['timing']) ?>" placeholder="e.g. 9:00 AM - 11:00 AM">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-weight:600;">Status</label>
                        <select name="status" class="form-control">
                            <option value="upcoming" <?= $batch['status']=='upcoming'?'selected':'' ?>>Upcoming</option>
                            <option value="ongoing" <?= $batch['status']=='ongoing'?'selected':'' ?>>Ongoing</option>
                            <option value="completed" <?= $batch['status']=='completed'?'selected':'' ?>>Completed</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-3">
                        <button type="submit" class="btn btn-grad"><i class="fas fa-save me-2"></i><?= $edit ? 'Update Batch' : 'Add Batch' ?></button>
                        <a href="batches.php" class="btn btn-outline-secondary">Cancel</a>
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
