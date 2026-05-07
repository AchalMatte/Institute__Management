<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Acetech Institute</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= SITE_URL ?>">
            <span class="logo-text">Acetech</span>
            <span class="logo-sub">INSTITUTE OF PROGRAMMING</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item"><a class="nav-link <?= $current_page=='index.php'?'active':'' ?>" href="<?= SITE_URL ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page=='about.php'?'active':'' ?>" href="<?= SITE_URL ?>/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page=='courses.php'?'active':'' ?>" href="<?= SITE_URL ?>/courses.php">Courses</a></li>
                <li class="nav-item"><a class="nav-link <?= $current_page=='contact.php'?'active':'' ?>" href="<?= SITE_URL ?>/contact.php">Contact</a></li>
                <li class="nav-item ms-2"><a class="btn btn-primary-custom btn-sm" href="<?= SITE_URL ?>/admin/login.php"><i class="fas fa-lock me-1"></i>Admin</a></li>
            </ul>
        </div>
    </div>
</nav>
