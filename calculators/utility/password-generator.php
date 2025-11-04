<?php
/**
 * Password Generator
 * File: utility/password-generator.php
 * Description: Advanced secure password generator with multiple options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator - Advanced Secure Password Creator</title>
    <meta name="description" content="Generate strong, secure passwords with custom options including length, character types, and special requirements.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .password-display { position: relative; margin-bottom: 25px; }
        .password-input { width: 100%; padding: 16px 50px 16px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; font-family: monospace; background: #f8f9fa; }
        .copy-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #667eea; color: white; border: none; border-radius: 5px; padding: 8px 12px; cursor: pointer; transition: all 0.3s; }
        .copy-btn:hover { background: #5a6fd8; }
        
        .options-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .option-group { background: #f8f9fa; padding: 20px; border-radius: 10px; }
        .option-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .slider-container { margin-bottom: 15px; }
        .slider-label { display: flex; justify-content: between; margin-bottom: 8px; }
        .slider-label span { color: #34495e; font-weight: 600; }
        .slider-value { color: #667eea; font-weight: bold; }
        .length-slider { width: 100%; height: 8px; border-radius: 5px; background: #e0e0e0; outline: none; }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .checkbox-item { display: flex; align-items: center; gap: 10px; }
        .checkbox-item input[type="checkbox"] { width: 18px; height: 18px; accent-color: #667eea; }
        .checkbox-item label { color: #34495e; cursor: pointer; }
        
        .strength-meter { margin: 20px 0; }
        .strength-label { display: flex; justify-content: between; margin-bottom: 8px; }
        .strength-text { font-weight: 600; }
        .meter-bar { height: 10px; background: #e0e0e0; border-radius: 5px; overflow: hidden; }
        .meter-fill { height: 100%; width: 0%; transition: all 0.3s; }
        
        .buttons-row { display: flex; gap: 15px; margin-top: 25px; }
        .generate-btn { flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .reset-btn { background: #95a5a6; color: white; border: none; padding: 14px 20px; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .reset-btn:hover { background: #7f8c8d; }
        
        .history-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .history-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .history-list { display: flex; flex-direction: column; gap: 10px; max-height: 200px; overflow-y: auto; }
        .history-item { display: flex; justify-content: between; align-items: center; padding: 12px; background: white; border-radius: 8px; border-left: 4px solid #667eea; }
        .history-password { font-family: monospace; font-size: 0.9rem; }
        .history-copy { background: #667eea; color: white; border: none; border-radius: 4px; padding: 5px 10px; font-size: 0.8rem; cursor: pointer; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .tip-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .tip-card h4 { color: #4527a0; margin-bottom: 10px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .options-grid { grid-template-columns: 1fr; }
            .buttons-row { flex-direction: column; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Advanced Password Generator</h1>
            <p>Create strong, secure passwords with custom options and security analysis</p>
        </div>

        <div class="generator-card">
            <div class="password-display">
                <input type="text" id="passwordOutput" class="password-input" readonly placeholder="Your password will appear here">
                <button class="copy-btn" id="copyButton">Copy</button>
            </div>

            <div class="options-grid">
                <div class="option-group">
                    <h3>📏 Password Length</h3>
                    <div class="slider-container">
                        <div class="slider-label">
                            <span>Length:</span>
                            <span class="slider-value" id="lengthValue">16</span>
                        </div>
                        <input type="range" id="lengthSlider" class="length-slider" min="4" max="64" value="16">
                    </div>
                    
                    <div class="strength-meter">
                        <div class="strength-label">
                            <span>Strength:</span>
                            <span class="strength-text" id="strengthText">Medium</span>
                        </div>
                        <div class="meter-bar">
                            <div class="meter-fill" id="strengthMeter"></div>
                        </div>
                    </div>
                </div>

                <div class="option-group">
                    <h3>🔤 Character Types</h3>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="uppercase" checked>
                            <label for="uppercase">Uppercase Letters (A-Z)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="lowercase" checked>
                            <label for="lowercase">Lowercase Letters (a-z)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="numbers" checked>
                            <label for="numbers">Numbers (0-9)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="symbols" checked>
                            <label for="symbols">Symbols (!@#$%^&*)</label>
                        </div>
                    </div>
                </div>

                <div class="option-group">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="excludeSimilar">
                            <label for="excludeSimilar">Exclude similar characters (i, l, 1, L, o, 0, O)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="excludeAmbiguous">
                            <label for="excludeAmbiguous">Exclude ambiguous characters ({ } [ ] ( ) / \ ' " ` ~ , ; : . < >)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="requireEach">
                            <label for="requireEach">Require at least one character from each selected type</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons-row">
                <button class="generate-btn" id="generateButton">Generate Password</button>
                <button class="reset-btn" id="resetButton">Reset Options</button>
            </div>

            <div class="history-section">
                <h3>📋 Password History</h3>
                <div class="history-list" id="passwordHistory"></div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔐 Password Security Guide</h2>
            
            <p>Creating strong, unique passwords is essential for protecting your online accounts and personal information.</p>

            <h3>📊 Password Strength Factors</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Impact on Security</th>
                        <th>Recommendation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Length</td><td>Most important factor</td><td>Minimum 12 characters</td></tr>
                    <tr><td>Character Variety</td><td>Increases complexity</td><td>Use multiple character types</td></tr>
                    <tr><td>Unpredictability</td><td>Prevents guessing</td><td>Avoid patterns & dictionary words</td></tr>
                    <tr><td>Uniqueness</td><td>Prevents credential stuffing</td><td>Different password for each account</td></tr>
                </tbody>
            </table>

            <div class="tips-grid">
                <div class="tip-card">
                    <h4>💡 Strong Password Tips</h4>
                    <ul>
                        <li>Use at least 12 characters</li>
                        <li>Include uppercase, lowercase, numbers, and symbols</li>
                        <li>Avoid personal information</li>
                        <li>Don't use common words or patterns</li>
                        <li>Consider using passphrases</li>
                    </ul>
                </div>
                
                <div class="tip-card">
                    <h4>🛡️ Security Best Practices</h4>
                    <ul>
                        <li>Use a password manager</li>
                        <li>Enable two-factor authentication</li>
                        <li>Change passwords after security breaches</li>
                        <li>Never reuse passwords across accounts</li>
                        <li>Be cautious of phishing attempts</li>
                    </ul>
                </div>
            </div>

            <h3>🔢 Password Mathematics</h3>
            <div class="formula-box">
                <strong>Password Complexity Calculation:</strong><br>
                Possible combinations = (character set size)<sup>password length</sup><br><br>
                <strong>Examples:</strong><br>
                • 8-character lowercase: 26<sup>8</sup> = 209 billion combinations<br>
                • 12-character mixed: 72<sup>12</sup> = 19 sextillion combinations<br>
                • 16-character full set: 94<sup>16</sup> = 44 tredecillion combinations
            </div>

            <h3>📈 Character Set Sizes</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Character Type</th>
                        <th>Count</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Lowercase letters</td><td>26</td><td>a, b, c, ... z</td></tr>
                    <tr><td>Uppercase letters</td><td>26</td><td>A, B, C, ... Z</td></tr>
                    <tr><td>Numbers</td><td>10</td><td>0, 1, 2, ... 9</td></tr>
                    <tr><td>Basic symbols</td><td>32</td><td>! @ # $ % ^ & * ( ) etc.</td></tr>
                    <tr><td>Full ASCII printable</td><td>94</td><td>All standard keyboard characters</td></tr>
                </tbody>
            </table>

            <h3>⏱️ Password Cracking Times</h3>
            <p>Estimated time to crack passwords (assuming 10 billion guesses per second):</p>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Password Type</th>
                        <th>Length</th>
                        <th>Time to Crack</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Lowercase only</td><td>8 characters</td><td>Less than 1 second</td></tr>
                    <tr><td>Mixed case + numbers</td><td>8 characters</td><td>About 5 hours</td></tr>
                    <tr><td>Full character set</td><td>8 characters</td><td>About 6 months</td></tr>
                    <tr><td>Full character set</td><td>12 characters</td><td>Over 60 years</td></tr>
                    <tr><td>Full character set</td><td>16 characters</td><td>Billions of years</td></tr>
                </tbody>
            </table>

            <h3>🔍 Common Password Mistakes</h3>
            <ul>
                <li><strong>Using personal information:</strong> Names, birthdays, pet names</li>
                <li><strong>Simple patterns:</strong> "123456", "qwerty", "password"</li>
                <li><strong>Short passwords:</strong> Under 8 characters are easily cracked</li>
                <li><strong>Password reuse:</strong> One breach compromises multiple accounts</li>
                <li><strong>Writing down passwords:</strong> Especially in insecure locations</li>
                <li><strong>Not updating passwords:</strong> Especially after security incidents</li>
            </ul>

            <h3>🔐 Password Manager Benefits</h3>
            <div class="formula-box">
                <strong>Why use a password manager:</strong><br>
                • Generate and store strong, unique passwords<br>
                • Auto-fill login credentials<br>
                • Sync across devices securely<br>
                • Alert you about compromised passwords<br>
                • Simplify two-factor authentication<br>
                • Secure sharing with family/team members
            </div>

            <h3>🌐 Website-Specific Requirements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Website Type</th>
                        <th>Common Requirements</th>
                        <th>Recommendations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Financial</td><td>Strict length & complexity</td><td>16+ characters, all character types</td></tr>
                    <tr><td>Email</td><td>Gateway to all accounts</td><td>Very strong, unique password</td></tr>
                    <tr><td>Social Media</td><td>Variable requirements</td><td>12+ characters, avoid personal info</td></tr>
                    <tr><td>Work Accounts</td><td>Corporate policies</td><td>Follow organizational guidelines</td></tr>
                </tbody>
            </table>

            <h3>🔄 Password Rotation Strategy</h3>
            <ul>
                <li><strong>High-security accounts:</strong> Change every 3-6 months</li>
                <li><strong>Medium-security accounts:</strong> Change every 6-12 months</li>
                <li><strong>Low-security accounts:</strong> Change when prompted or after breaches</li>
                <li><strong>Always change:</strong> After any security incident or suspicion</li>
            </ul>

            <h3>🔒 Two-Factor Authentication (2FA)</h3>
            <div class="formula-box">
                <strong>2FA adds an essential security layer:</strong><br>
                • Something you know (password)<br>
                • Something you have (phone, security key)<br>
                • Something you are (biometrics)<br><br>
                <strong>Best 2FA methods:</strong><br>
                • Authenticator apps (Google Authenticator, Authy)<br>
                • Hardware security keys (YubiKey)<br>
                • Biometric authentication (fingerprint, face ID)
            </div>

            <h3>📱 Mobile Password Security</h3>
            <ul>
                <li>Use biometric authentication when available</li>
                <li>Enable remote wipe capabilities</li>
                <li>Keep your device updated</li>
                <li>Use a VPN on public Wi-Fi</li>
                <li>Be cautious of app permissions</li>
            </ul>

            <h3>🚨 Password Breach Response</h3>
            <ul>
                <li>Change the compromised password immediately</li>
                <li>Change similar passwords on other accounts</li>
                <li>Enable two-factor authentication if not already</li>
                <li>Monitor accounts for suspicious activity</li>
                <li>Check haveibeenpwned.com for breach information</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔐 Advanced Password Generator | Create Strong, Secure Passwords</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate passwords with custom length, character types, and security options</p>
        </div>
    </div>

    <div class="toast" id="toast">Password copied to clipboard!</div>

    <script>
        // Character sets
        const charSets = {
            uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            lowercase: 'abcdefghijklmnopqrstuvwxyz',
            numbers: '0123456789',
            symbols: '!@#$%^&*()_+-=[]{}|;:,.<>?'
        };

        // Similar characters to exclude
        const similarChars = 'il1Lo0O';
        
        // Ambiguous characters to exclude
        const ambiguousChars = '{}[]()/\\\'"`~,;:.<>';

        // DOM elements
        const passwordOutput = document.getElementById('passwordOutput');
        const copyButton = document.getElementById('copyButton');
        const lengthSlider = document.getElementById('lengthSlider');
        const lengthValue = document.getElementById('lengthValue');
        const generateButton = document.getElementById('generateButton');
        const resetButton = document.getElementById('resetButton');
        const strengthText = document.getElementById('strengthText');
        const strengthMeter = document.getElementById('strengthMeter');
        const passwordHistory = document.getElementById('passwordHistory');
        const toast = document.getElementById('toast');

        // Options checkboxes
        const uppercaseCheck = document.getElementById('uppercase');
        const lowercaseCheck = document.getElementById('lowercase');
        const numbersCheck = document.getElementById('numbers');
        const symbolsCheck = document.getElementById('symbols');
        const excludeSimilarCheck = document.getElementById('excludeSimilar');
        const excludeAmbiguousCheck = document.getElementById('excludeAmbiguous');
        const requireEachCheck = document.getElementById('requireEach');

        // Initialize
        let history = JSON.parse(localStorage.getItem('passwordHistory')) || [];
        updateHistoryDisplay();
        generatePassword();

        // Event listeners
        lengthSlider.addEventListener('input', function() {
            lengthValue.textContent = this.value;
            generatePassword();
        });

        copyButton.addEventListener('click', copyPassword);
        generateButton.addEventListener('click', generatePassword);
        resetButton.addEventListener('click', resetOptions);

        // Add event listeners to all option checkboxes
        const optionCheckboxes = [
            uppercaseCheck, lowercaseCheck, numbersCheck, symbolsCheck,
            excludeSimilarCheck, excludeAmbiguousCheck, requireEachCheck
        ];
        
        optionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', generatePassword);
        });

        function generatePassword() {
            let length = parseInt(lengthSlider.value);
            let charset = '';
            
            // Build character set based on selected options
            if (uppercaseCheck.checked) charset += charSets.uppercase;
            if (lowercaseCheck.checked) charset += charSets.lowercase;
            if (numbersCheck.checked) charset += charSets.numbers;
            if (symbolsCheck.checked) charset += charSets.symbols;
            
            // Remove similar characters if option is selected
            if (excludeSimilarCheck.checked) {
                for (let char of similarChars) {
                    charset = charset.replace(char, '');
                }
            }
            
            // Remove ambiguous characters if option is selected
            if (excludeAmbiguousCheck.checked) {
                for (let char of ambiguousChars) {
                    charset = charset.replace(char, '');
                }
            }
            
            // Check if at least one character type is selected
            if (charset.length === 0) {
                passwordOutput.value = 'Select at least one character type';
                updateStrengthIndicator(0);
                return;
            }
            
            let password = '';
            
            // If we need to include at least one character from each selected type
            if (requireEachCheck.checked) {
                let requiredChars = '';
                if (uppercaseCheck.checked) {
                    requiredChars += getRandomChar(charSets.uppercase);
                }
                if (lowercaseCheck.checked) {
                    requiredChars += getRandomChar(charSets.lowercase);
                }
                if (numbersCheck.checked) {
                    requiredChars += getRandomChar(charSets.numbers);
                }
                if (symbolsCheck.checked) {
                    requiredChars += getRandomChar(charSets.symbols);
                }
                
                // Shuffle the required characters
                requiredChars = shuffleString(requiredChars);
                
                // Generate the rest of the password
                for (let i = requiredChars.length; i < length; i++) {
                    password += getRandomChar(charset);
                }
                
                // Insert required characters at random positions
                for (let char of requiredChars) {
                    const pos = Math.floor(Math.random() * (password.length + 1));
                    password = password.slice(0, pos) + char + password.slice(pos);
                }
            } else {
                // Simple random generation
                for (let i = 0; i < length; i++) {
                    password += getRandomChar(charset);
                }
            }
            
            passwordOutput.value = password;
            updateStrengthIndicator(calculatePasswordStrength(password));
            addToHistory(password);
        }

        function getRandomChar(str) {
            return str[Math.floor(Math.random() * str.length)];
        }

        function shuffleString(str) {
            let arr = str.split('');
            for (let i = arr.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arr[i], arr[j]] = [arr[j], arr[i]];
            }
            return arr.join('');
        }

        function calculatePasswordStrength(password) {
            let score = 0;
            const length = password.length;
            
            // Length score (up to 40 points)
            if (length >= 12) score += 40;
            else if (length >= 8) score += 30;
            else if (length >= 6) score += 20;
            else score += 10;
            
            // Character variety score (up to 40 points)
            let hasUpper = /[A-Z]/.test(password);
            let hasLower = /[a-z]/.test(password);
            let hasNumber = /[0-9]/.test(password);
            let hasSymbol = /[^A-Za-z0-9]/.test(password);
            
            let varietyCount = [hasUpper, hasLower, hasNumber, hasSymbol].filter(Boolean).length;
            score += varietyCount * 10;
            
            // Entropy bonus (up to 20 points)
            let charsetSize = 0;
            if (hasUpper) charsetSize += 26;
            if (hasLower) charsetSize += 26;
            if (hasNumber) charsetSize += 10;
            if (hasSymbol) charsetSize += 32;
            
            let entropy = Math.log2(Math.pow(charsetSize, length));
            if (entropy > 80) score += 20;
            else if (entropy > 60) score += 15;
            else if (entropy > 40) score += 10;
            else if (entropy > 20) score += 5;
            
            return Math.min(score, 100);
        }

        function updateStrengthIndicator(score) {
            let strength, color, width;
            
            if (score >= 80) {
                strength = 'Very Strong';
                color = '#27ae60';
                width = '100%';
            } else if (score >= 60) {
                strength = 'Strong';
                color = '#2ecc71';
                width = '80%';
            } else if (score >= 40) {
                strength = 'Medium';
                color = '#f39c12';
                width = '60%';
            } else if (score >= 20) {
                strength = 'Weak';
                color = '#e74c3c';
                width = '40%';
            } else {
                strength = 'Very Weak';
                color = '#c0392b';
                width = '20%';
            }
            
            strengthText.textContent = strength;
            strengthMeter.style.width = width;
            strengthMeter.style.background = color;
        }

        function copyPassword() {
            if (!passwordOutput.value || passwordOutput.value.includes('Select at least')) return;
            
            navigator.clipboard.writeText(passwordOutput.value).then(() => {
                showToast('Password copied to clipboard!');
            }).catch(err => {
                // Fallback for older browsers
                passwordOutput.select();
                document.execCommand('copy');
                showToast('Password copied to clipboard!');
            });
        }

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function addToHistory(password) {
            // Add to beginning of history
            history.unshift({
                password: password,
                timestamp: new Date().toLocaleString()
            });
            
            // Keep only last 10 passwords
            if (history.length > 10) {
                history = history.slice(0, 10);
            }
            
            // Save to localStorage
            localStorage.setItem('passwordHistory', JSON.stringify(history));
            
            // Update display
            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            passwordHistory.innerHTML = '';
            
            if (history.length === 0) {
                passwordHistory.innerHTML = '<div style="text-align: center; color: #7f8c8d; padding: 20px;">No password history yet</div>';
                return;
            }
            
            history.forEach(item => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
                    <div>
                        <div class="history-password">${item.password}</div>
                        <div style="font-size: 0.8rem; color: #7f8c8d;">${item.timestamp}</div>
                    </div>
                    <button class="history-copy" onclick="copyFromHistory('${item.password}')">Copy</button>
                `;
                passwordHistory.appendChild(historyItem);
            });
        }

        function copyFromHistory(password) {
            navigator.clipboard.writeText(password).then(() => {
                showToast('Password copied to clipboard!');
            }).catch(err => {
                // Fallback
                const tempInput = document.createElement('input');
                tempInput.value = password;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast('Password copied to clipboard!');
            });
        }

        function resetOptions() {
            lengthSlider.value = 16;
            lengthValue.textContent = '16';
            uppercaseCheck.checked = true;
            lowercaseCheck.checked = true;
            numbersCheck.checked = true;
            symbolsCheck.checked = true;
            excludeSimilarCheck.checked = false;
            excludeAmbiguousCheck.checked = false;
            requireEachCheck.checked = false;
            generatePassword();
        }

        // Make function available globally for history items
        window.copyFromHistory = copyFromHistory;
    </script>
</body>
</html>
