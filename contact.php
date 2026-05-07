<?php
$page_title = 'Contact';
require_once 'includes/header.php';

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($conn, $_POST['name'] ?? '');
    $email = sanitize($conn, $_POST['email'] ?? '');
    $phone = sanitize($conn, $_POST['phone'] ?? '');
    $subject = sanitize($conn, $_POST['subject'] ?? '');
    $message = sanitize($conn, $_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        if ($stmt->execute()) $success = "Thank you! Your message has been sent. We'll get back to you soon.";
        else $error = "Something went wrong. Please try again.";
        $stmt->close();
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<section style="background:var(--gradient2);padding:80px 0 50px;">
    <div class="container text-center">
        <h1 class="text-white fw-800" style="font-size:2.8rem;font-weight:800;">Contact <span style="background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Us</span></h1>
        <p style="color:#aaa;">Have questions? We'd love to hear from you.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="contact-form-box">
                    <h4 style="font-weight:700;color:var(--dark);margin-bottom:25px;">Send us a Message</h4>
                    <?php if ($success): ?><div class="alert alert-success alert-custom"><?= $success ?></div><?php endif; ?>
                    <?php if ($error): ?><div class="alert alert-danger alert-custom"><?= $error ?></div><?php endif; ?>
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Full Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Subject</label>
                                <select name="subject" class="form-control">
                                    <option value="">Select a subject</option>
                                    <option>Course Inquiry</option>
                                    <option>Admission</option>
                                    <option>Fee Structure</option>
                                    <option>Batch Schedule</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600">Message *</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-grad w-100"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <h4 class="fw-bold mb-4">Get in Touch</h4>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;">Address</div>
                            <div style="color:#aaa;font-size:0.88rem;">123 Tech Street, Silicon Valley, CA 94025</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;">Phone</div>
                            <div style="color:#aaa;font-size:0.88rem;">+1 (555) 123-4567<br>+1 (555) 987-6543</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;">Email</div>
                            <div style="color:#aaa;font-size:0.88rem;">info@acetech.com<br>admissions@acetech.com</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;">Working Hours</div>
                            <div style="color:#aaa;font-size:0.88rem;">Mon - Sat: 9:00 AM - 7:00 PM<br>Sunday: Closed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
