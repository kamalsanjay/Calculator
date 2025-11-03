<?php
require_once 'config.php';
$page_title = "404 - Page Not Found";
require_once 'includes/header.php';
?>

<div class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">Page Not Found</h2>
            <p class="error-description">
                Sorry, the page you are looking for doesn't exist or has been moved.
            </p>
            <div class="error-actions">
                <a href="<?php echo SITE_URL; ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i> Go to Homepage
                </a>
                <a href="<?php echo SITE_URL; ?>/calculators/financial/" class="btn btn-secondary btn-lg">
                    <i class="fas fa-calculator"></i> Browse Calculators
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    min-height: 60vh;
    display: flex;
    align-items: center;
    padding: 4rem 0;
}

.error-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.error-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 4rem;
    color: white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.error-title {
    font-size: 6rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.error-subtitle {
    font-size: 2rem;
    color: #1a1a1a;
    margin-bottom: 1rem;
}

.error-description {
    font-size: 1.125rem;
    color: #6c757d;
    margin-bottom: 2.5rem;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .error-title {
        font-size: 4rem;
    }
    
    .error-subtitle {
        font-size: 1.5rem;
    }
    
    .error-actions {
        flex-direction: column;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>