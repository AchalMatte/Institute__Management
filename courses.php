<?php
$page_title = 'Courses';
require_once 'includes/header.php';
$courses = $conn->query("SELECT * FROM courses ORDER BY status DESC, created_at DESC");
?>

<section style="background:var(--gradient2);padding:80px 0 50px;">
    <div class="container text-center">
        <h1 class="text-white fw-800" style="font-size:2.8rem;font-weight:800;">Our <span style="background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Courses</span></h1>
        <p style="color:#aaa;font-size:1.05rem;margin-top:10px;">Explore our comprehensive programming courses designed for all skill levels</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php
            $icons = ['🐍','🌐','☕','⚙️','⚡','🗄️','🔷','🎯'];
            $i = 0;
            if ($courses): while ($course = $courses->fetch_assoc()):
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="course-card">
                    <div class="course-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="course-icon"><?= $icons[$i % 8] ?></div>
                            <span class="badge <?= $course['status']=='active' ? 'badge-active' : 'badge-inactive' ?>"><?= ucfirst($course['status']) ?></span>
                        </div>
                        <h5 class="text-white mt-3 mb-0 fw-bold"><?= htmlspecialchars($course['course_name']) ?></h5>
                        <small style="color:rgba(255,255,255,0.6);">Code: <?= htmlspecialchars($course['course_code']) ?></small>
                    </div>
                    <div class="course-card-body">
                        <p class="course-desc"><?= htmlspecialchars($course['description']) ?></p>
                        <div class="d-flex gap-3 mt-3">
                            <span style="font-size:0.85rem;color:#888;"><i class="fas fa-clock me-1" style="color:var(--primary);"></i><?= htmlspecialchars($course['duration']) ?></span>
                        </div>
                    </div>
                    <div class="course-meta">
                        <div>
                            <div class="course-fee">₹<?= number_format($course['fee']) ?></div>
                            <small style="color:#aaa;">Course Fee</small>
                        </div>
                        <a href="contact.php" class="btn btn-grad"><i class="fas fa-paper-plane me-1"></i>Enroll</a>
                    </div>
                </div>
            </div>
            <?php $i++; endwhile; else: ?>
            <div class="col-12 text-center py-5">
                <div style="font-size:4rem;">📚</div>
                <h4 class="mt-3 text-muted">No courses available yet</h4>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
