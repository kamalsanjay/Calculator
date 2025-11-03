<?php
/**
 * Email Class
 * Handles email sending functionality
 */

class Email {
    private $to = [];
    private $from = [];
    private $subject = '';
    private $body = '';
    private $altBody = '';
    private $attachments = [];
    private $headers = [];
    private $isHTML = true;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->from = [
            'email' => getenv('MAIL_FROM_ADDRESS') ?: 'noreply@calculator.com',
            'name' => getenv('MAIL_FROM_NAME') ?: 'Calculator'
        ];
    }
    
    /**
     * Set recipient
     */
    public function to($email, $name = '') {
        $this->to[] = ['email' => $email, 'name' => $name];
        return $this;
    }
    
    /**
     * Set sender
     */
    public function from($email, $name = '') {
        $this->from = ['email' => $email, 'name' => $name];
        return $this;
    }
    
    /**
     * Set subject
     */
    public function subject($subject) {
        $this->subject = $subject;
        return $this;
    }
    
    /**
     * Set body
     */
    public function body($body) {
        $this->body = $body;
        return $this;
    }
    
    /**
     * Set alt body (plain text)
     */
    public function altBody($altBody) {
        $this->altBody = $altBody;
        return $this;
    }
    
    /**
     * Add attachment
     */
    public function attach($file, $name = '') {
        $this->attachments[] = ['file' => $file, 'name' => $name];
        return $this;
    }
    
    /**
     * Set HTML mode
     */
    public function html($isHTML = true) {
        $this->isHTML = $isHTML;
        return $this;
    }
    
    /**
     * Send email
     */
    public function send() {
        try {
            if (function_exists('mail')) {
                return $this->sendWithPHPMail();
            } else {
                return $this->sendWithSMTP();
            }
        } catch (Exception $e) {
            error_log("Email send error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send with PHP mail()
     */
    private function sendWithPHPMail() {
        $headers = $this->buildHeaders();
        $to = $this->to[0]['email'];
        
        return mail($to, $this->subject, $this->body, $headers);
    }
    
    /**
     * Send with SMTP
     */
    private function sendWithSMTP() {
        $host = getenv('MAIL_HOST');
        $port = getenv('MAIL_PORT') ?: 587;
        $username = getenv('MAIL_USERNAME');
        $password = getenv('MAIL_PASSWORD');
        $encryption = getenv('MAIL_ENCRYPTION') ?: 'tls';
        
        // Open connection
        $socket = $this->connectSMTP($host, $port, $encryption);
        
        if (!$socket) {
            return false;
        }
        
        // SMTP conversation
        $this->smtpCommand($socket, "EHLO {$host}");
        $this->smtpCommand($socket, "AUTH LOGIN");
        $this->smtpCommand($socket, base64_encode($username));
        $this->smtpCommand($socket, base64_encode($password));
        $this->smtpCommand($socket, "MAIL FROM:<{$this->from['email']}>");
        
        foreach ($this->to as $recipient) {
            $this->smtpCommand($socket, "RCPT TO:<{$recipient['email']}>");
        }
        
        $this->smtpCommand($socket, "DATA");
        
        // Send email content
        $message = $this->buildMessage();
        fwrite($socket, $message . "\r\n.\r\n");
        
        // Close connection
        $this->smtpCommand($socket, "QUIT");
        fclose($socket);
        
        return true;
    }
    
    /**
     * Connect to SMTP server
     */
    private function connectSMTP($host, $port, $encryption) {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        if ($encryption === 'ssl') {
            $host = 'ssl://' . $host;
        }
        
        $socket = stream_socket_client(
            "{$host}:{$port}",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );
        
        if (!$socket) {
            error_log("SMTP connection error: {$errstr} ({$errno})");
            return false;
        }
        
        if ($encryption === 'tls') {
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        }
        
        return $socket;
    }
    
    /**
     * Send SMTP command
     */
    private function smtpCommand($socket, $command) {
        fwrite($socket, $command . "\r\n");
        return fgets($socket, 512);
    }
    
    /**
     * Build headers
     */
    private function buildHeaders() {
        $headers = [];
        $headers[] = "From: {$this->from['name']} <{$this->from['email']}>";
        $headers[] = "Reply-To: {$this->from['email']}";
        $headers[] = "MIME-Version: 1.0";
        
        if ($this->isHTML) {
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }
        
        return implode("\r\n", $headers);
    }
    
    /**
     * Build message
     */
    private function buildMessage() {
        $message = "From: {$this->from['name']} <{$this->from['email']}>\r\n";
        $message .= "To: {$this->to[0]['email']}\r\n";
        $message .= "Subject: {$this->subject}\r\n";
        $message .= $this->buildHeaders() . "\r\n\r\n";
        $message .= $this->body;
        
        return $message;
    }
    
    /**
     * Send from template
     */
    public static function sendTemplate($to, $template, $data = []) {
        $templatePath = BASE_PATH . '/emails/templates/' . $template . '.php';
        
        if (!file_exists($templatePath)) {
            error_log("Email template not found: {$template}");
            return false;
        }
        
        // Extract data for template
        extract($data);
        
        // Capture template output
        ob_start();
        include $templatePath;
        $body = ob_get_clean();
        
        $email = new self();
        return $email->to($to)
                     ->subject($data['subject'] ?? 'Email from Calculator')
                     ->body($body)
                     ->html(true)
                     ->send();
    }
}