<?php
$page_title = 'Messages';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM contacts WHERE id=$id");
    redirect(SITE_URL . '/admin/contacts.php?msg=deleted');
}

if (isset($_GET['read'])) {
    $id = (int)$_GET['read'];
    $conn->query("UPDATE contacts SET is_read=1 WHERE id=$id");
}

// Mark all read
if (isset($_GET['readall'])) {
    $conn->query("UPDATE contacts SET is_read=1");
    redirect(SITE_URL . '/admin/contacts.php');
}

$msg = $_GET['msg'] ?? '';
$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<div class="admin-content">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button id="sidebarToggle" class="btn btn-sm d-lg-none" style="background:var(--gradient);color:#fff;border-radius:8px;"><i class="fas fa-bars"></i></button>
            <div class="page-title">Contact Messages</div>
        </div>
        <a href="contacts.php?readall=1" class="btn btn-outline-secondary btn-sm"><i class="fas fa-check-double me-1"></i>Mark All Read</a>
    </div>
    <div class="admin-main">
        <?php if ($msg === 'deleted'): ?><div class="alert alert-danger alert-custom">Message deleted!</div><?php endif; ?>

        <div class="admin-card">
            <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-envelope me-2" style="color:var(--secondary);"></i>All Messages</div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="tableSearch" class="form-control" placeholder="Search messages...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Sender</th><th>Subject</th><th>Message</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if ($contacts && $contacts->num_rows > 0): while ($c = $contacts->fetch_assoc()): ?>
                    <tr style="<?= !$c['is_read'] ? 'background:#fafafa;font-weight:500;' : '' ?>">
                        <td>
                            <div style="font-weight:600;font-size:0.9rem;"><?= htmlspecialchars($c['name']) ?></div>
                            <div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($c['email']) ?></div>
                            <?php if ($c['phone']): ?><div style="color:#aaa;font-size:0.78rem;"><?= htmlspecialchars($c['phone']) ?></div><?php endif; ?>
                        </td>
                        <td style="font-size:0.88rem;"><?= htmlspecialchars($c['subject'] ?: 'No Subject') ?></td>
                        <td style="font-size:0.85rem;max-width:250px;">
                            <span title="<?= htmlspecialchars($c['message']) ?>"><?= htmlspecialchars(substr($c['message'],0,80)) ?>...</span>
                        </td>
                        <td style="font-size:0.82rem;color:#888;white-space:nowrap;"><?= date('d M Y, h:i A', strtotime($c['created_at'])) ?></td>
                        <td>
                            <?php if (!$c['is_read']): ?>
                            <span class="badge bg-danger" style="font-size:0.75rem;">New</span>
                            <?php else: ?>
                            <span style="color:#aaa;font-size:0.82rem;"><i class="fas fa-check me-1"></i>Read</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$c['is_read']): ?>
                            <a href="contacts.php?read=<?= $c['id'] ?>" class="btn-action btn-view" title="Mark Read"><i class="fas fa-eye"></i></a>
                            <?php endif; ?>
                            <button onclick="confirmDelete('contacts.php?delete=<?= $c['id'] ?>','message from <?= htmlspecialchars($c['name']) ?>')" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-5"><i class="fas fa-inbox fa-2x mb-2 d-block"></i>No messages yet</td></tr>
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
