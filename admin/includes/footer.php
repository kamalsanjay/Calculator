<?php
/**
 * Admin Footer Template
 * Closes the layout and includes necessary scripts
 */
?>

            </div> <!-- End content -->

            <!-- Footer -->
            <footer class="bg-white mt-auto py-3 border-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="text-muted">
                                &copy; <?php echo date('Y'); ?> Calculator Website. All rights reserved.
                            </span>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="text-muted">
                                Version 1.0.0 | 
                                <a href="https://github.com/yourusername/calculator-website" target="_blank">Documentation</a>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div> <!-- End content-wrapper -->
    </div> <!-- End wrapper -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin Scripts -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('toggled');
            document.getElementById('content-wrapper').classList.toggle('expanded');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirm delete actions
        document.querySelectorAll('[data-confirm]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                const message = this.getAttribute('data-confirm');
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });

        // Session timeout warning
        let sessionTimeout = <?php echo SESSION_TIMEOUT - 300; ?>000; // 5 minutes before timeout
        setTimeout(function() {
            if (confirm('Your session is about to expire. Would you like to extend it?')) {
                fetch('extend-session.php').then(() => location.reload());
            }
        }, sessionTimeout);

        // AJAX CSRF token helper
        function getCsrfToken() {
            return '<?php echo $_SESSION['csrf_token']; ?>';
        }

        // Format numbers with commas
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Copy to clipboard helper
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copied to clipboard!', 'success');
            }).catch(() => {
                showToast('Failed to copy', 'error');
            });
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const colors = {
                success: '#1cc88a',
                error: '#e74a3b',
                warning: '#f6c23e',
                info: '#36b9cc'
            };

            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colors[type]};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                animation: slideIn 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add slide animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>

    <?php if (isset($additionalScripts)): ?>
        <?php echo $additionalScripts; ?>
    <?php endif; ?>
</body>
</html>