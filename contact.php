<?php
require_once 'config.php';

$page_title = "Contact Us - Calculator";
$page_description = "Get in touch with the Calculator team. We're here to help with questions, feedback, or suggestions.";

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        try {
            $db = Database::getInstance();
            
            // Save to database
            $stmt = $db->prepare("
                INSERT INTO contact_messages (name, email, subject, message, ip_address, user_agent, created_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            $stmt->execute([$name, $email, $subject, $message, $ip, $userAgent]);
            
            // Send email notification (optional)
            $to = MAIL_FROM_ADDRESS;
            $emailSubject = "New Contact Form Submission: " . $subject;
            $emailMessage = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
            $headers = "From: $email\r\nReply-To: $email";
            
            @mail($to, $emailSubject, $emailMessage, $headers);
            
            $success = 'Thank you for contacting us! We\'ll get back to you soon.';
            
            // Clear form
            $name = $email = $subject = $message = '';
        } catch (Exception $e) {
            error_log('Contact form error: ' . $e->getMessage());
            $error = 'Sorry, there was an error sending your message. Please try again.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="contact-page">
    <!-- Theme Toggle -->
    <div class="theme-toggle-container">
        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
            <span class="theme-text">Dark Mode</span>
        </button>
    </div>

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="contact-hero-content">
                <h1>Get in Touch</h1>
                <p class="lead">We'd love to hear from you. Send us a message!</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2>Send us a Message</h2>
                    <p>Have a question or feedback? Fill out the form below and we'll get back to you as soon as possible.</p>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Your Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($name ?? ''); ?>"
                                       placeholder="John Doe"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                       placeholder="john@example.com"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" 
                                   name="subject" 
                                   class="form-control" 
                                   value="<?php echo htmlspecialchars($subject ?? ''); ?>"
                                   placeholder="What is this about?"
                                   required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" 
                                      class="form-control" 
                                      rows="6"
                                      placeholder="Tell us more..."
                                      required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>support@calculator.com</p>
                        <p class="text-muted">We typically respond within 24 hours</p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Live Chat</h3>
                        <p>Available 24/7</p>
                        <button class="btn btn-secondary">
                            <i class="fas fa-comment"></i> Start Chat
                        </button>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>FAQs</h3>
                        <p>Find answers to common questions</p>
                        <a href="<?php echo SITE_URL; ?>/faq.php" class="btn btn-secondary">
                            <i class="fas fa-book"></i> View FAQs
                        </a>
                    </div>

                    <div class="info-card social-card">
                        <h3>Follow Us</h3>
                        <div class="social-links">
                            <a href="#" class="social-btn">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* CSS Variables for Theme */
:root {
    /* Light Theme (Default) */
    --bg-primary: #ffffff;
    --bg-secondary: #f8f9fa;
    --bg-hero: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    --bg-card: #ffffff;
    --bg-form: #ffffff;
    --bg-info-icon: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-card: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-btn: rgba(255, 255, 255, 0.2);
    --bg-alert-success: #d4edda;
    --bg-alert-danger: #f8d7da;
    
    --text-primary: #2d3748;
    --text-secondary: #4a5568;
    --text-muted: #718096;
    --text-hero: #2d3748;
    --text-social: #ffffff;
    
    --border-color: #e2e8f0;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    
    --btn-primary-bg: #667eea;
    --btn-primary-text: #ffffff;
    --btn-secondary-bg: #718096;
    --btn-secondary-text: #ffffff;
}

[data-theme="dark"] {
    /* Dark Theme */
    --bg-primary: #1a202c;
    --bg-secondary: #2d3748;
    --bg-hero: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    --bg-card: #2d3748;
    --bg-form: #2d3748;
    --bg-info-icon: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-card: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-social-btn: rgba(255, 255, 255, 0.1);
    --bg-alert-success: #0f5132;
    --bg-alert-danger: #842029;
    
    --text-primary: #e2e8f0;
    --text-secondary: #cbd5e0;
    --text-muted: #a0aec0;
    --text-hero: #e2e8f0;
    --text-social: #ffffff;
    
    --border-color: #4a5568;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    
    --btn-primary-bg: #667eea;
    --btn-primary-text: #ffffff;
    --btn-secondary-bg: #718096;
    --btn-secondary-text: #ffffff;
}

/* Base Styles */
body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color 0.3s ease, color 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
}

/* Theme Toggle */
.theme-toggle-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.theme-toggle {
    background: var(--bg-card);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 30px;
    padding: 10px 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.theme-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.theme-text {
    font-weight: 500;
}

/* Contact Page Styles */
.contact-hero {
    background: var(--bg-hero);
    color: var(--text-hero);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.contact-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
    background-size: cover;
}

.contact-hero-content {
    position: relative;
    z-index: 1;
}

.contact-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-hero);
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.contact-hero-content .lead {
    font-size: 1.25rem;
    color: var(--text-hero);
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.contact-section {
    padding: 5rem 0;
    background-color: var(--bg-secondary);
}

.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 4rem;
}

.contact-form-container h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-weight: 700;
}

.contact-form-container > p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.contact-form {
    background: var(--bg-form);
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card {
    background: var(--bg-card);
    padding: 2rem;
    border-radius: 16px;
    box-shadow: var(--shadow);
    text-align: center;
    border: 1px solid var(--border-color);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.info-icon {
    width: 70px;
    height: 70px;
    background: var(--bg-info-icon);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.75rem;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.info-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-weight: 600;
}

.info-card p {
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.text-muted {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.social-card {
    background: var(--bg-social-card);
    color: var(--text-social);
    border: none;
}

.social-card h3 {
    color: var(--text-social);
}

.social-links {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.social-btn {
    width: 50px;
    height: 50px;
    background: var(--bg-social-btn);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background: white;
    color: #667eea;
    transform: translateY(-5px);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border: 1px solid transparent;
}

.alert-success {
    background: var(--bg-alert-success);
    color: #155724;
    border-color: #c3e6cb;
}

.alert-danger {
    background: var(--bg-alert-danger);
    color: #721c24;
    border-color: #f5c6cb;
}

/* Form Elements */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 12px 16px;
    width: 100%;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control::placeholder {
    color: var(--text-muted);
}

.form-label {
    color: var(--text-primary);
    margin-bottom: 8px;
    display: block;
    font-weight: 600;
}

.btn {
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    text-decoration: none;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.btn-primary {
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: var(--btn-secondary-bg);
    color: var(--btn-secondary-text);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .contact-hero-content h1 {
        font-size: 2.5rem;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .contact-form {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .theme-toggle-container {
        position: relative;
        top: 0;
        right: 0;
        display: flex;
        justify-content: flex-end;
        padding: 10px 15px;
    }
    
    .social-links {
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .contact-hero {
        padding: 3rem 0;
    }
    
    .contact-section {
        padding: 3rem 0;
    }
    
    .contact-hero-content h1 {
        font-size: 2rem;
    }
    
    .info-card {
        padding: 1.5rem;
    }
}
</style>

<script>
// Theme Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');
    const themeText = themeToggle.querySelector('.theme-text');
    
    // Check for saved theme preference or default to light
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply the saved theme
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateThemeToggle(currentTheme);
    
    // Toggle theme on button click
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        updateThemeToggle(newTheme);
    });
    
    function updateThemeToggle(theme) {
        if (theme === 'dark') {
            themeIcon.className = 'fas fa-sun';
            themeText.textContent = 'Light Mode';
        } else {
            themeIcon.className = 'fas fa-moon';
            themeText.textContent = 'Dark Mode';
        }
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>