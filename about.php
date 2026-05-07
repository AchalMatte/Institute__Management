<?php
$page_title = 'About';
require_once 'includes/header.php';
$total_students = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];
$total_courses = $conn->query("SELECT COUNT(*) as c FROM courses WHERE status='active'")->fetch_assoc()['c'];
?>

<section style="background:var(--gradient2);padding:80px 0 50px;">
    <div class="container text-center">
        <h1 class="text-white fw-800" style="font-size:2.8rem;font-weight:800;">About <span style="background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Acetech</span></h1>
        <p style="color:#aaa;">Learn more about our institute and our mission</p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge d-inline-block mb-3">Our Story</div>
                <h2 class="section-title">Shaping the <span>Future</span> of Programming</h2>
                <div class="section-divider"></div>
                <p class="text-muted mt-3" style="line-height:1.8;">Founded in 2018, Acetech Institute of Programming has been at the forefront of tech education. We believe that quality programming education should be accessible to everyone who has the passion to learn.</p>
                <p class="text-muted mt-3" style="line-height:1.8;">Our curriculum is constantly updated to match industry demands, ensuring our students are always job-ready with the latest skills and technologies.</p>
                <div class="row g-3 mt-3">
                    <div class="col-6">
                        <div style="background:#f8f9fa;border-radius:12px;padding:20px;text-align:center;">
                            <div style="font-size:2rem;font-weight:800;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;"><?= $total_students ?>+</div>
                            <div style="color:#888;font-size:0.9rem;">Students Enrolled</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#f8f9fa;border-radius:12px;padding:20px;text-align:center;">
                            <div style="font-size:2rem;font-weight:800;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;"><?= $total_courses ?>+</div>
                            <div style="color:#888;font-size:0.9rem;">Active Courses</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="background:var(--gradient2);border-radius:20px;padding:40px;color:#fff;">
                    <h4 class="fw-bold mb-4">Our Mission & Values</h4>
                    <?php
                    $values = [
                        ['🎯','Quality Education','We deliver world-class programming education with practical, hands-on approach.'],
                        ['🤝','Student Success','Every student\'s success is our success. We go above and beyond to support our learners.'],
                        ['🔄','Continuous Learning','Technology evolves, and so do we. Our curriculum is always up-to-date.'],
                        ['🌍','Inclusive Community','We welcome learners from all backgrounds and experience levels.'],
                    ];
                    foreach ($values as $v): ?>
                    <div class="d-flex gap-3 mb-4">
                        <div style="font-size:1.5rem;flex-shrink:0;"><?= $v[0] ?></div>
                        <div>
                            <div style="font-weight:700;margin-bottom:4px;"><?= $v[1] ?></div>
                            <div style="color:#aaa;font-size:0.88rem;"><?= $v[2] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5" style="background:#f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Meet Our <span>Team</span></h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $team = [
                ['A','Arjun Mehta','Founder & CEO','Python & AI Expert','var(--gradient)'],
                ['S','Sneha Gupta','Lead Instructor','Web Development','linear-gradient(135deg,#f7971e,#ffd200)'],
                ['V','Vikram Singh','Java Instructor','Java & Spring Boot','linear-gradient(135deg,#11998e,#38ef7d)'],
                ['N','Neha Sharma','JS Instructor','React & Node.js','linear-gradient(135deg,#fc466b,#3f5efb)'],
            ];
            foreach ($team as $t): ?>
            <div class="col-lg-3 col-md-6">
                <div class="text-center" style="background:#fff;border-radius:16px;padding:30px;box-shadow:0 5px 20px rgba(0,0,0,0.05);">
                    <div style="width:80px;height:80px;border-radius:50%;background:<?= $t[4] ?>;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;margin:0 auto 15px;"><?= $t[0] ?></div>
                    <h5 style="font-weight:700;color:var(--dark);"><?= $t[1] ?></h5>
                    <div style="color:var(--primary);font-size:0.85rem;font-weight:600;"><?= $t[2] ?></div>
                    <div style="color:#888;font-size:0.82rem;margin-top:5px;"><?= $t[3] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
