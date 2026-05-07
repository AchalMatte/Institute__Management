<?php
$page_title = 'Dashboard';
require_once 'includes/sidebar.php';

$total_students = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];
$active_students = $conn->query("SELECT COUNT(*) as c FROM students WHERE status='active'")->fetch_assoc()['c'];
$total_courses = $conn->query("SELECT COUNT(*) as c FROM courses")->fetch_assoc()['c'];
$total_batches = $conn->query("SELECT COUNT(*) as c FROM batches")->fetch_assoc()['c'];
$ongoing_batches = $conn->query("SELECT COUNT(*) as c FROM batches WHERE status='ongoing'")->fetch_assoc()['c'];
$unread_msgs = $conn->query("SELECT COUNT(*) as c FROM contacts WHERE is_read=0")->fetch_assoc()['c'];

$recent_students = $conn->query("SELECT s.*, b.batch_name, c.course_name FROM students s LEFT JOIN batches b ON s.batch_id=b.id LEFT JOIN courses c ON b.course_id=c.id ORDER BY s.created_at DESC LIMIT 5");
$recent_contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title">Dashboard</div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span style="color:#888;font-size:0.88rem;"><i class="fas fa-calendar me-1"></i><?= date('D, d M Y') ?></span>
            <div style="width:38px;height:38px;border-radius:50%;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;"><?= strtoupper(substr($_SESSION['admin_name'],0,1)) ?></div>
        </div>
    </div>
    <div class="admin-main">
        <!-- Stats -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Students</div>
                            <div class="stat-value"><?= $total_students ?></div>
                            <div class="stat-change text-success"><i class="fas fa-arrow-up me-1"></i><?= $active_students ?> active</div>
                        </div>
                        <div class="stat-icon" style="background:rgba(108,63,197,0.1);color:var(--primary);">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Courses</div>
                            <div class="stat-value"><?= $total_courses ?></div>
                            <div class="stat-change text-info"><i class="fas fa-book me-1"></i>All programs</div>
                        </div>
                        <div class="stat-icon" style="background:rgba(247,151,30,0.1);color:var(--secondary);">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Batches</div>
                            <div class="stat-value"><?= $total_batches ?></div>
                            <div class="stat-change text-warning"><i class="fas fa-circle me-1"></i><?= $ongoing_batches ?> ongoing</div>
                        </div>
                        <div class="stat-icon" style="background:rgba(40,167,69,0.1);color:#28a745;">
                            <i class="fas fa-layer-group fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">New Messages</div>
                            <div class="stat-value"><?= $unread_msgs ?></div>
                            <div class="stat-change text-danger"><i class="fas fa-envelope me-1"></i>Unread</div>
                        </div>
                        <div class="stat-icon" style="background:rgba(220,53,69,0.1);color:#dc3545;">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Students -->
            <div class="col-lg-7">
                <div class="admin-card">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-user-graduate me-2" style="color:var(--primary);"></i>Recent Students</div>
                        <a href="students.php" class="btn btn-sm btn-grad">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>Student</th><th>Course</th><th>Status</th><th>Date</th></tr></thead>
                            <tbody>
                            <?php if ($recent_students): while ($s = $recent_students->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="student-avatar"><?= strtoupper(substr($s['full_name'],0,1)) ?></div>
                                        <div>
                                            <div style="font-weight:600;font-size:0.88rem;"><?= htmlspecialchars($s['full_name']) ?></div>
                                            <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($s['student_id']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:0.85rem;"><?= htmlspecialchars($s['course_name'] ?? 'N/A') ?></td>
                                <td><span class="badge-<?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
                                <td style="font-size:0.82rem;color:#888;"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No students yet</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="col-lg-5">
                <div class="admin-card">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-envelope me-2" style="color:var(--secondary);"></i>Recent Messages</div>
                        <a href="contacts.php" class="btn btn-sm btn-grad">View All</a>
                    </div>
                    <?php if ($recent_contacts): while ($c = $recent_contacts->fetch_assoc()): ?>
                    <div style="padding:12px 0;border-bottom:1px solid #f5f5f5;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="font-weight:600;font-size:0.88rem;"><?= htmlspecialchars($c['name']) ?> <?= !$c['is_read'] ? '<span class="badge bg-danger" style="font-size:0.65rem;">New</span>' : '' ?></div>
                            <div style="color:#aaa;font-size:0.75rem;"><?= date('d M', strtotime($c['created_at'])) ?></div>
                        </div>
                        <div style="color:#888;font-size:0.82rem;margin-top:3px;"><?= htmlspecialchars(substr($c['message'],0,60)) ?>...</div>
                    </div>
                    <?php endwhile; else: ?>
                    <div class="text-center text-muted py-4">No messages yet</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
