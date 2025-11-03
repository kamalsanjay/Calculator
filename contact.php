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

<!-- Keep the same HTML as before -->
<!-- ... rest of contact.php stays the same ... -->

<div class="contact-page">
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
/* Contact Page Styles */
.contact-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 5rem 0;
    text-align: center;
}

.contact-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: white;
}

.contact-section {
    padding: 5rem 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 4rem;
}

.contact-form-container h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.contact-form-container > p {
    color: #6c757d;
    margin-bottom: 2rem;
}

.contact-form {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    text-align: center;
}

.info-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.75rem;
    color: white;
}

.info-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.info-card p {
    color: #6c757d;
    margin-bottom: 1rem;
}

.text-muted {
    font-size: 0.875rem;
    color: #adb5bd;
}

.social-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.social-card h3 {
    color: white;
}

.social-links {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.social-btn {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
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
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
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
}
</style>


<?php require_once 'includes/footer.php'; ?>