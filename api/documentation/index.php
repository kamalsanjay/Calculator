<?php
/**
 * API Documentation
 * Interactive API documentation page
 */

$page_title = "API Documentation - Calculator";
$page_description = "Complete API documentation for Calculator. Learn how to integrate our calculators into your applications.";

require_once '../../includes/header.php';
?>

<div class="api-docs-page">
    <div class="container">
        <div class="docs-header">
            <h1>API Documentation</h1>
            <p>Welcome to the Calculator API documentation. Access 300+ calculators programmatically.</p>
            <div class="api-version">
                <span class="badge badge-primary">Version 1.0</span>
                <span class="badge badge-success">Stable</span>
            </div>
        </div>

        <!-- Quick Start -->
        <section class="docs-section">
            <h2>Quick Start</h2>
            <p>Get started with the Calculator API in minutes.</p>
            
            <div class="code-block">
                <div class="code-header">
                    <span>Example Request</span>
                    <button class="copy-btn" onclick="copyCode(this)">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
                <pre><code class="language-bash">curl -X POST https://calculator.com/api/v1/calculate \
  -H "Content-Type: application/json" \
  -d '{
    "calculator": "bmi",
    "data": {
      "weight": 70,
      "height": 1.75
    }
  }'</code></pre>
            </div>
            
            <div class="code-block">
                <div class="code-header">
                    <span>Example Response</span>
                </div>
                <pre><code class="language-json">{
  "success": true,
  "calculator": "bmi",
  "input": {
    "weight": 70,
    "height": 1.75
  },
  "result": {
    "bmi": 22.86,
    "category": "Normal weight",
    "weight": 70,
    "height": 1.75
  },
  "timestamp": 1699564800
}</code></pre>
            </div>
        </section>

        <!-- Authentication -->
        <section class="docs-section">
            <h2>Authentication</h2>
            <p>Most endpoints are public, but authentication is required for user-specific features.</p>
            
            <h3>Register</h3>
            <div class="endpoint">
                <span class="method post">POST</span>
                <span class="path">/api/v1/auth/register</span>
            </div>
            
            <div class="code-block">
                <pre><code class="language-json">{
  "username": "john_doe",
  "email": "john@example.com",
  "password": "SecurePass123!"
}</code></pre>
            </div>
            
            <h3>Login</h3>
            <div class="endpoint">
                <span class="method post">POST</span>
                <span class="path">/api/v1/auth/login</span>
            </div>
            
            <div class="code-block">
                <pre><code class="language-json">{
  "email": "john@example.com",
  "password": "SecurePass123!"
}</code></pre>
            </div>
            
            <h3>Using Access Tokens</h3>
            <p>Include the access token in the Authorization header:</p>
            <div class="code-block">
                <pre><code class="language-bash">curl -X GET https://calculator.com/api/v1/user/profile \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN"</code></pre>
            </div>
        </section>

        <!-- Endpoints -->
        <section class="docs-section">
            <h2>Endpoints</h2>
            
            <!-- Calculate -->
            <div class="endpoint-card">
                <h3>Calculate</h3>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="path">/api/v1/calculate</span>
                </div>
                <p>Perform calculations using any available calculator.</p>
                
                <h4>Request Body</h4>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>calculator</code></td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Calculator type (bmi, mortgage, loan, etc.)</td>
                        </tr>
                        <tr>
                            <td><code>data</code></td>
                            <td>object</td>
                            <td>Yes</td>
                            <td>Input data for the calculator</td>
                        </tr>
                    </tbody>
                </table>
                
                <h4>Available Calculators</h4>
                <ul class="calculator-list">
                    <li><code>bmi</code> - BMI Calculator</li>
                    <li><code>mortgage</code> - Mortgage Calculator</li>
                    <li><code>loan</code> - Loan Calculator</li>
                    <li><code>compound-interest</code> - Compound Interest Calculator</li>
                    <li><code>percentage</code> - Percentage Calculator</li>
                </ul>
            </div>
            
            <!-- Search -->
            <div class="endpoint-card">
                <h3>Search</h3>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="path">/api/v1/search</span>
                </div>
                <p>Search for calculators.</p>
                
                <h4>Query Parameters</h4>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>q</code></td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Search query (min 2 characters)</td>
                        </tr>
                        <tr>
                            <td><code>limit</code></td>
                            <td>integer</td>
                            <td>No</td>
                            <td>Maximum results (default: 10, max: 50)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Categories -->
            <div class="endpoint-card">
                <h3>Categories</h3>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="path">/api/v1/categories</span>
                </div>
                <p>Get all calculator categories.</p>
            </div>
            
            <!-- Popular -->
            <div class="endpoint-card">
                <h3>Popular Calculators</h3>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="path">/api/v1/popular</span>
                </div>
                <p>Get most popular calculators.</p>
                
                <h4>Query Parameters</h4>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>limit</code></td>
                            <td>integer</td>
                            <td>No</td>
                            <td>Maximum results (default: 10, max: 50)</td>
                        </tr>
                        <tr>
                            <td><code>days</code></td>
                            <td>integer</td>
                            <td>No</td>
                            <td>Time period in days (default: 30, max: 365)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Error Handling -->
        <section class="docs-section">
            <h2>Error Handling</h2>
            <p>The API uses standard HTTP status codes and returns errors in JSON format.</p>
            
            <h3>HTTP Status Codes</h3>
            <table class="params-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>200</code></td>
                        <td>Success</td>
                    </tr>
                    <tr>
                        <td><code>400</code></td>
                        <td>Bad Request - Invalid parameters</td>
                    </tr>
                    <tr>
                        <td><code>401</code></td>
                        <td>Unauthorized - Invalid or missing authentication</td>
                    </tr>
                    <tr>
                        <td><code>404</code></td>
                        <td>Not Found - Resource doesn't exist</td>
                    </tr>
                    <tr>
                        <td><code>429</code></td>
                        <td>Too Many Requests - Rate limit exceeded</td>
                    </tr>
                    <tr>
                        <td><code>500</code></td>
                        <td>Internal Server Error</td>
                    </tr>
                </tbody>
            </table>
            
            <h3>Error Response Format</h3>
            <div class="code-block">
                <pre><code class="language-json">{
  "error": "Error type",
  "message": "Detailed error message"
}</code></pre>
            </div>
        </section>

        <!-- Rate Limiting -->
        <section class="docs-section">
            <h2>Rate Limiting</h2>
            <p>API requests are rate limited to ensure fair usage:</p>
            <ul>
                <li><strong>Public endpoints:</strong> 100 requests per hour per IP</li>
                <li><strong>Authenticated endpoints:</strong> 1000 requests per hour per user</li>
            </ul>
            
            <p>Rate limit headers are included in all responses:</p>
            <div class="code-block">
                <pre><code>X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1699568400</code></pre>
            </div>
        </section>

        <!-- SDKs -->
        <section class="docs-section">
            <h2>SDKs & Libraries</h2>
            <p>Official SDKs are coming soon. In the meantime, you can use any HTTP client library.</p>
            
            <h3>JavaScript Example</h3>
            <div class="code-block">
                <pre><code class="language-javascript">async function calculateBMI(weight, height) {
  const response = await fetch('https://calculator.com/api/v1/calculate', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      calculator: 'bmi',
      data: { weight, height }
    })
  });
  
  const result = await response.json();
  return result;
}</code></pre>
            </div>
            
            <h3>Python Example</h3>
            <div class="code-block">
                <pre><code class="language-python">import requests

def calculate_bmi(weight, height):
    response = requests.post(
        'https://calculator.com/api/v1/calculate',
        json={
            'calculator': 'bmi',
            'data': {
                'weight': weight,
                'height': height
            }
        }
    )
    return response.json()</code></pre>
            </div>
        </section>

        <!-- Support -->
        <section class="docs-section">
            <h2>Support</h2>
            <p>Need help? We're here for you!</p>
            <ul>
                <li><strong>Email:</strong> api@calculator.com</li>
                <li><strong>Documentation:</strong> <a href="/docs">https://calculator.com/docs</a></li>
                <li><strong>Status:</strong> <a href="/status">https://calculator.com/status</a></li>
            </ul>
        </section>
    </div>
</div>

<style>
.api-docs-page {
    padding: var(--spacing-3xl) 0;
    background: #f8f9fa;
}

.docs-header {
    text-align: center;
    margin-bottom: var(--spacing-3xl);
    padding: var(--spacing-3xl);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: var(--radius-xl);
}

.docs-header h1 {
    color: white;
    margin-bottom: var(--spacing-md);
}

.api-version {
    margin-top: var(--spacing-lg);
}

.docs-section {
    background: white;
    padding: var(--spacing-2xl);
    margin-bottom: var(--spacing-xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.docs-section h2 {
    color: var(--primary-color);
    border-bottom: 2px solid var(--light-color);
    padding-bottom: var(--spacing-md);
    margin-bottom: var(--spacing-xl);
}

.endpoint {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    margin: var(--spacing-lg) 0;
    padding: var(--spacing-md);
    background: var(--light-color);
    border-radius: var(--radius-md);
}

.method {
    padding: var(--spacing-xs) var(--spacing-md);
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem;
    color: white;
}

.method.get { background: #28a745; }
.method.post { background: #007bff; }
.method.put { background: #ffc107; color: var(--dark-color); }
.method.delete { background: #dc3545; }

.path {
    font-family: var(--font-mono);
    font-size: 1.125rem;
    color: var(--dark-color);
}

.code-block {
    background: #2d3748;
    border-radius: var(--radius-md);
    overflow: hidden;
    margin: var(--spacing-lg) 0;
}

.code-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--spacing-md) var(--spacing-lg);
    background: #1a202c;
    color: white;
    font-size: 0.875rem;
}

.copy-btn {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    padding: var(--spacing-xs) var(--spacing-md);
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-size: 0.875rem;
}

.copy-btn:hover {
    background: rgba(255,255,255,0.1);
}

.code-block pre {
    margin: 0;
    padding: var(--spacing-lg);
    overflow-x: auto;
}

.code-block code {
    color: #e2e8f0;
    font-family: var(--font-mono);
    font-size: 0.875rem;
    line-height: 1.6;
}

.endpoint-card {
    border: 1px solid #dee2e6;
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    margin-bottom: var(--spacing-xl);
}

.params-table {
    width: 100%;
    border-collapse: collapse;
    margin: var(--spacing-lg) 0;
}

.params-table th {
    background: var(--light-color);
    padding: var(--spacing-md);
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.params-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid #dee2e6;
}

.params-table code {
    background: #f1f3f5;
    padding: 0.2rem 0.4rem;
    border-radius: var(--radius-sm);
    font-family: var(--font-mono);
    font-size: 0.875rem;
}

.calculator-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--spacing-sm);
    margin-top: var(--spacing-md);
}

.calculator-list li {
    background: var(--light-color);
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
}
</style>

<script>
function copyCode(button) {
    const codeBlock = button.closest('.code-block').querySelector('code');
    const text = codeBlock.textContent;
    
    navigator.clipboard.writeText(text).then(() => {
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-copy"></i> Copy';
        }, 2000);
    });
}
</script>

<?php require_once '../../includes/footer.php'; ?>