<?php
session_start();
require_once '../config/db.php';

if (isLoggedIn()) redirect(SITE_URL . '/admin/dashboard.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
        // Auto-upgrade plain password to hash
        if ($password === $user['password']) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("UPDATE admin_users SET password='$newHash' WHERE id={$user['id']}");
        }
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['username'];
        redirect(SITE_URL . '/admin/dashboard.php');
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Acetech</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="login-logo">Acetech</div>
            <div style="color:#888;font-size:0.75rem;letter-spacing:3px;">ADMIN PANEL</div>
            <div style="width:50px;height:3px;background:var(--gradient);border-radius:2px;margin:10px auto;"></div>
        </div>
        <?php if ($error): ?>
        <div class="alert alert-danger alert-custom"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-600" style="font-weight:600;">Username</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f8f9fa;border:2px solid #eee;border-right:none;"><i class="fas fa-user" style="color:var(--primary);"></i></span>
                    <input type="text" name="username" class="form-control" style="border:2px solid #eee;border-left:none;" placeholder="Enter username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-600" style="font-weight:600;">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#f8f9fa;border:2px solid #eee;border-right:none;"><i class="fas fa-lock" style="color:var(--primary);"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control" style="border:2px solid #eee;border-left:none;border-right:none;" placeholder="Enter password" required>
                    <span class="input-group-text" style="background:#f8f9fa;border:2px solid #eee;border-left:none;cursor:pointer;" onclick="togglePass()"><i class="fas fa-eye" id="eyeIcon" style="color:#aaa;"></i></span>
                </div>
            </div>
            <button type="submit" class="btn btn-grad w-100 py-3"><i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel</button>
        </form>
        <div class="text-center mt-4">
            <a href="<?= SITE_URL ?>" style="color:#888;font-size:0.88rem;text-decoration:none;"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
        </div>
        <div class="text-center mt-3" style="color:#ccc;font-size:0.78rem;">Default: admin / password</div>
    </div>
</div>
<script>
function togglePass() {
    const f = document.getElementById('passwordField');
    const i = document.getElementById('eyeIcon');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
</script>
</body>
</html>
