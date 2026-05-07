<?php
$page_title = 'Home';
require_once 'includes/header.php';

$courses = $conn->query("SELECT * FROM courses WHERE status='active' LIMIT 6");
$total_students = $conn->query("SELECT COUNT(*) as c FROM students WHERE status='active'")->fetch_assoc()['c'];
$total_courses = $conn->query("SELECT COUNT(*) as c FROM courses WHERE status='active'")->fetch_assoc()['c'];
$total_batches = $conn->query("SELECT COUNT(*) as c FROM batches WHERE status='ongoing'")->fetch_assoc()['c'];
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-content">
                <div class="hero-badge"><i class="fas fa-star me-1"></i> #1 Programming Institute</div>
                <h1 class="hero-title">
                    Master <span id="typing-text">Python</span><span class="cursor">|</span><br>
                    Build Your Future
                </h1>
                <p class="hero-desc">Acetech Institute offers industry-leading programming courses designed to transform beginners into professional developers. Learn from experts, build real projects.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="courses.php" class="btn btn-primary-custom"><i class="fas fa-rocket me-2"></i>Explore Courses</a>
                    <a href="contact.php" class="btn btn-outline-custom"><i class="fas fa-phone me-2"></i>Contact Us</a>
                </div>
                <div class="hero-stats stats-section">
                    <div class="stat-item">
                        <div class="stat-num counter" data-target="<?= $total_students ?>">0+</div>
                        <div class="stat-label">Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num counter" data-target="<?= $total_courses ?>">0+</div>
                        <div class="stat-label">Courses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">98%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">6+</div>
                        <div class="stat-label">Years</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-box float-anim">
                    <div class="code-block">
                        <div class="code-line"><span class="code-comment"># Welcome to Acetech Institute</span></div>
                        <div class="code-line"><span class="code-keyword">class </span><span class="code-func">AcetechStudent</span>:</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">def </span><span class="code-func">__init__</span>(self, name):</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;self.<span class="code-var">name</span> = name</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;self.<span class="code-var">skills</span> = []</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">def </span><span class="code-func">learn</span>(self, skill):</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;self.<span class="code-var">skills</span>.append(skill)</div>
                        <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">return</span> <span class="code-string">"🚀 Skill Unlocked!"</span></div>
                        <div class="code-line mt-2"><span class="code-var">me</span> = <span class="code-func">AcetechStudent</span>(<span class="code-string">"You"</span>)</div>
                        <div class="code-line"><span class="code-var">me</span>.<span class="code-func">learn</span>(<span class="code-string">"Python"</span>)</div>
                        <div class="code-line"><span class="code-comment"># Output: 🚀 Skill Unlocked!</span></div>
                    </div>
                    <div class="row g-2 mt-3">
                        <div class="col-4 text-center p-2" style="background:rgba(255,255,255,0.05);border-radius:10px;">
                            <div style="font-size:1.5rem;">🐍</div><div style="color:#aaa;font-size:0.75rem;">Python</div>
                        </div>
                        <div class="col-4 text-center p-2" style="background:rgba(255,255,255,0.05);border-radius:10px;">
                            <div style="font-size:1.5rem;">⚡</div><div style="color:#aaa;font-size:0.75rem;">JavaScript</div>
                        </div>
                        <div class="col-4 text-center p-2" style="background:rgba(255,255,255,0.05);border-radius:10px;">
                            <div style="font-size:1.5rem;">☕</div><div style="color:#aaa;font-size:0.75rem;">Java</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5 animate-on-scroll">
            <div class="hero-badge d-inline-block mb-2">Our Programs</div>
            <h2 class="section-title">Popular <span>Courses</span></h2>
            <div class="section-divider mx-auto"></div>
            <p class="section-subtitle">Industry-aligned programming courses taught by expert instructors</p>
        </div>
        <div class="row g-4">
            <?php
            $icons = ['🐍','🌐','☕','⚙️','⚡','🗄️'];
            $i = 0;
            if ($courses): while ($course = $courses->fetch_assoc()):
            ?>
            <div class="col-lg-4 col-md-6 animate-on-scroll">
                <div class="course-card">
                    <div class="course-card-header">
                        <div class="course-icon"><?= $icons[$i % 6] ?></div>
                        <span class="course-badge"><?= htmlspecialchars($course['duration']) ?></span>
                        <h5 class="text-white mt-3 mb-0 fw-700"><?= htmlspecialchars($course['course_name']) ?></h5>
                        <small style="color:rgba(255,255,255,0.6);"><?= htmlspecialchars($course['course_code']) ?></small>
                    </div>
                    <div class="course-card-body">
                        <p class="course-desc"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                    </div>
                    <div class="course-meta">
                        <span class="course-fee">₹<?= number_format($course['fee']) ?></span>
                        <a href="courses.php" class="btn btn-sm btn-grad">Enroll Now</a>
                    </div>
                </div>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="courses.php" class="btn btn-primary-custom"><i class="fas fa-th-large me-2"></i>View All Courses</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="hero-badge d-inline-block mb-2" style="background:rgba(247,151,30,0.2);">Why Choose Us</div>
            <h2 class="section-title text-white">Why <span>Acetech?</span></h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php
            $features = [
                ['🏆','Expert Instructors','Learn from industry professionals with 10+ years of real-world experience.'],
                ['💻','Hands-on Projects','Build real-world projects that you can showcase in your portfolio.'],
                ['📜','Certification','Get industry-recognized certificates upon course completion.'],
                ['🕐','Flexible Timing','Morning, evening and weekend batches to fit your schedule.'],
                ['🤝','Placement Support','100% placement assistance with our network of 200+ partner companies.'],
                ['♾️','Lifetime Access','Get lifetime access to course materials and future updates.'],
            ];
            foreach ($features as $f): ?>
            <div class="col-lg-4 col-md-6 animate-on-scroll">
                <div class="feature-card">
                    <div class="feature-icon"><?= $f[0] ?></div>
                    <div class="feature-title"><?= $f[1] ?></div>
                    <div class="feature-desc"><?= $f[2] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <div class="hero-badge d-inline-block mb-2">Testimonials</div>
            <h2 class="section-title">Student <span>Reviews</span></h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php
            $testimonials = [
                ['R','Rahul Sharma','Python Course','Acetech completely changed my career. I got placed at a top MNC within 2 months of completing the Python course!'],
                ['P','Priya Patel','Web Development','The web development course is incredibly comprehensive. The instructors are patient and the projects are real-world.'],
                ['A','Amit Kumar','JavaScript & React','Best institute for programming! The React course helped me land a frontend developer job with a 40% salary hike.'],
            ];
            foreach ($testimonials as $t): ?>
            <div class="col-md-4 animate-on-scroll">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">"<?= $t[3] ?>"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar"><?= $t[0] ?></div>
                        <div>
                            <div class="author-name"><?= $t[1] ?></div>
                            <div class="author-course"><?= $t[2] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background:var(--gradient);padding:80px 0;">
    <div class="container text-center">
        <h2 style="color:#fff;font-size:2.5rem;font-weight:800;">Ready to Start Your Journey?</h2>
        <p style="color:rgba(255,255,255,0.85);font-size:1.1rem;margin:15px 0 35px;">Join thousands of students who transformed their careers with Acetech</p>
        <a href="contact.php" class="btn btn-outline-custom me-3"><i class="fas fa-envelope me-2"></i>Get in Touch</a>
        <a href="courses.php" class="btn" style="background:#fff;color:var(--primary);padding:14px 35px;border-radius:50px;font-weight:700;"><i class="fas fa-graduation-cap me-2"></i>Enroll Now</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
