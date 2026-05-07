// Acetech Institute - Main JS

// Typing effect for hero
const typingTexts = ['Python', 'JavaScript', 'Java', 'C/C++', 'React', 'PHP'];
let textIndex = 0, charIndex = 0, isDeleting = false;

function typeEffect() {
    const el = document.getElementById('typing-text');
    if (!el) return;
    const current = typingTexts[textIndex];
    el.textContent = isDeleting ? current.substring(0, charIndex--) : current.substring(0, charIndex++);
    if (!isDeleting && charIndex === current.length + 1) { isDeleting = true; setTimeout(typeEffect, 1500); return; }
    if (isDeleting && charIndex === 0) { isDeleting = false; textIndex = (textIndex + 1) % typingTexts.length; }
    setTimeout(typeEffect, isDeleting ? 80 : 120);
}

// Counter animation
function animateCounters() {
    document.querySelectorAll('.counter').forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const step = target / 60;
        let current = 0;
        const timer = setInterval(() => {
            current += step;
            if (current >= target) { counter.textContent = target + '+'; clearInterval(timer); }
            else counter.textContent = Math.floor(current) + '+';
        }, 30);
    });
}

// Intersection Observer for animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
            if (entry.target.classList.contains('stats-section')) animateCounters();
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (navbar) navbar.style.boxShadow = window.scrollY > 50 ? '0 5px 30px rgba(108,63,197,0.4)' : '0 2px 20px rgba(108,63,197,0.3)';
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});

// Delete confirmation
function confirmDelete(url, name) {
    if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
        window.location.href = url;
    }
}

// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 3000);

// Admin sidebar toggle
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.querySelector('.admin-sidebar');
if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('show'));
}

// Form validation
document.querySelectorAll('form.needs-validation').forEach(form => {
    form.addEventListener('submit', e => {
        if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
        form.classList.add('was-validated');
    });
});

// Search filter for tables
const searchInput = document.getElementById('tableSearch');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    typeEffect();
    // Trigger counter animation if stats visible
    const statsEl = document.querySelector('.stats-section');
    if (statsEl) observer.observe(statsEl);
});
