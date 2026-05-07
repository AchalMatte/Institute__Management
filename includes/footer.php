<?php
$courses_footer = $conn->query("SELECT course_name, course_code FROM courses WHERE status='active' LIMIT 5");
?>
<footer class="pt-5 pb-0">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">Acetech</div>
                <p style="font-size:0.9rem;line-height:1.7;">Acetech Institute of Programming — empowering students with cutting-edge programming skills since 2018. Learn, Build, Succeed.</p>
                <div class="mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-700 mb-3" style="font-weight:700;">Quick Links</h6>
                <a href="<?= SITE_URL ?>" class="footer-link">Home</a>
                <a href="<?= SITE_URL ?>/about.php" class="footer-link">About Us</a>
                <a href="<?= SITE_URL ?>/courses.php" class="footer-link">Courses</a>
                <a href="<?= SITE_URL ?>/contact.php" class="footer-link">Contact</a>
                <a href="<?= SITE_URL ?>/admin/login.php" class="footer-link">Admin Panel</a>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="text-white mb-3" style="font-weight:700;">Our Courses</h6>
                <?php if ($courses_footer): while ($cf = $courses_footer->fetch_assoc()): ?>
                <a href="<?= SITE_URL ?>/courses.php" class="footer-link"><i class="fas fa-code me-2" style="color:var(--secondary);font-size:0.75rem;"></i><?= htmlspecialchars($cf['course_name']) ?></a>
                <?php endwhile; endif; ?>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white mb-3" style="font-weight:700;">Contact Info</h6>
                <p class="footer-link"><i class="fas fa-map-marker-alt me-2" style="color:var(--secondary);"></i>123 Tech Street, Silicon Valley, CA</p>
                <p class="footer-link"><i class="fas fa-phone me-2" style="color:var(--secondary);"></i>+1 (555) 123-4567</p>
                <p class="footer-link"><i class="fas fa-envelope me-2" style="color:var(--secondary);"></i>info@acetech.com</p>
                <p class="footer-link"><i class="fas fa-clock me-2" style="color:var(--secondary);"></i>Mon-Sat: 9AM - 7PM</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>&copy; <?= date('Y') ?> Acetech Institute. All rights reserved.</span>
            <span>Made with <i class="fas fa-heart" style="color:#e74c3c;"></i> for programmers</span>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
