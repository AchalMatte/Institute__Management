<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';
requireLogin();
$admin_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Acetech Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-name">Acetech</div>
        <div class="brand-sub">ADMIN PANEL</div>
    </div>
    <nav class="mt-3">
        <div class="sidebar-section">Main</div>
        <a href="dashboard.php" class="nav-link <?= $admin_page=='dashboard.php'?'active':'' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <div class="sidebar-section">Management</div>
        <a href="students.php" class="nav-link <?= in_array($admin_page,['students.php','student_form.php'])?'active':'' ?>"><i class="fas fa-user-graduate"></i> Students</a>
        <a href="courses.php" class="nav-link <?= in_array($admin_page,['courses.php','course_form.php'])?'active':'' ?>"><i class="fas fa-book"></i> Courses</a>
        <a href="batches.php" class="nav-link <?= in_array($admin_page,['batches.php','batch_form.php'])?'active':'' ?>"><i class="fas fa-layer-group"></i> Batches</a>
        <div class="sidebar-section">Communication</div>
        <a href="contacts.php" class="nav-link <?= $admin_page=='contacts.php'?'active':'' ?>">
            <i class="fas fa-envelope"></i> Messages
            <?php
            $unread = $conn->query("SELECT COUNT(*) as c FROM contacts WHERE is_read=0")->fetch_assoc()['c'];
            if ($unread > 0): ?><span class="badge bg-danger ms-auto" style="font-size:0.7rem;"><?= $unread ?></span><?php endif; ?>
        </a>
        <div class="sidebar-section">Account</div>
        <a href="<?= SITE_URL ?>" class="nav-link" target="_blank"><i class="fas fa-globe"></i> View Website</a>
        <a href="logout.php" class="nav-link" style="color:#ff6b6b !important;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</div>
