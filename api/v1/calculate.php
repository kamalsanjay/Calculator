<?php
/**
 * Calculation API
 * Process calculator requests via API
 */

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../config.php';
require_once '../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method not allowed'], 405);
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    json_response(['error' => 'Invalid JSON'], 400);
}

// Validate required fields
if (!isset($input['calculator']) || !isset($input['data'])) {
    json_response(['error' => 'Missing required fields: calculator, data'], 400);
}

$calculator = sanitize_input($input['calculator']);
$data = $input['data'];

try {
    // Perform calculation based on calculator type
    $result = perform_calculation($calculator, $data);
    
    // Track calculation
    track_api_calculation($calculator, $data, $result);
    
    json_response([
        'success' => true,
        'calculator' => $calculator,
        'input' => $data,
        'result' => $result,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    json_response([
        'error' => 'Calculation error',
        'message' => $e->getMessage()
    ], 500);
}

/**
 * Perform Calculation
 */
function perform_calculation(string $calculator, array $data): array {
    switch ($calculator) {
        case 'bmi':
            return calculate_bmi($data);
        
        case 'mortgage':
            return calculate_mortgage($data);
        
        case 'loan':
            return calculate_loan($data);
        
        case 'compound-interest':
            return calculate_compound_interest($data);
        
        case 'percentage':
            return calculate_percentage($data);
        
        default:
            throw new Exception("Calculator '{$calculator}' not found");
    }
}

/**
 * BMI Calculator
 */
function calculate_bmi(array $data): array {
    if (!isset($data['weight']) || !isset($data['height'])) {
        throw new Exception('Missing weight or height');
    }
    
    $weight = floatval($data['weight']);
    $height = floatval($data['height']);
    
    if ($weight <= 0 || $height <= 0) {
        throw new Exception('Weight and height must be positive');
    }
    
    $bmi = $weight / ($height * $height);
    
    if ($bmi < 18.5) {
        $category = 'Underweight';
    } elseif ($bmi < 25) {
        $category = 'Normal weight';
    } elseif ($bmi < 30) {
        $category = 'Overweight';
    } else {
        $category = 'Obese';
    }
    
    return [
        'bmi' => round($bmi, 2),
        'category' => $category,
        'weight' => $weight,
        'height' => $height
    ];
}

/**
 * Mortgage Calculator
 */
function calculate_mortgage(array $data): array {
    if (!isset($data['principal']) || !isset($data['rate']) || !isset($data['years'])) {
        throw new Exception('Missing required fields: principal, rate, years');
    }
    
    $principal = floatval($data['principal']);
    $annualRate = floatval($data['rate']);
    $years = intval($data['years']);
    
    if ($principal <= 0 || $annualRate < 0 || $years <= 0) {
        throw new Exception('Invalid input values');
    }
    
    $monthlyRate = ($annualRate / 100) / 12;
    $numberOfPayments = $years * 12;
    
    if ($monthlyRate == 0) {
        $monthlyPayment = $principal / $numberOfPayments;
    } else {
        $monthlyPayment = $principal * ($monthlyRate * pow(1 + $monthlyRate, $numberOfPayments)) /
                         (pow(1 + $monthlyRate, $numberOfPayments) - 1);
    }
    
    $totalPayment = $monthlyPayment * $numberOfPayments;
    $totalInterest = $totalPayment - $principal;
    
    return [
        'monthly_payment' => round($monthlyPayment, 2),
        'total_payment' => round($totalPayment, 2),
        'total_interest' => round($totalInterest, 2),
        'principal' => $principal,
        'rate' => $annualRate,
        'years' => $years
    ];
}

/**
 * Loan Calculator
 */
function calculate_loan(array $data): array {
    // Similar to mortgage
    return calculate_mortgage($data);
}

/**
 * Compound Interest Calculator
 */
function calculate_compound_interest(array $data): array {
    if (!isset($data['principal']) || !isset($data['rate']) || !isset($data['years'])) {
        throw new Exception('Missing required fields');
    }
    
    $principal = floatval($data['principal']);
    $rate = floatval($data['rate']) / 100;
    $years = floatval($data['years']);
    $compoundFrequency = intval($data['compound_frequency'] ?? 12);
    $contribution = floatval($data['monthly_contribution'] ?? 0);
    
    // Future value of principal
    $fvPrincipal = $principal * pow(1 + $rate / $compoundFrequency, $compoundFrequency * $years);
    
    // Future value of contributions
    $monthlyRate = $rate / 12;
    $months = $years * 12;
    $fvContributions = 0;
    
    if ($contribution > 0 && $monthlyRate > 0) {
        $fvContributions = $contribution * ((pow(1 + $monthlyRate, $months) - 1) / $monthlyRate);
    } elseif ($contribution > 0) {
        $fvContributions = $contribution * $months;
    }
    
    $totalValue = $fvPrincipal + $fvContributions;
    $totalContributions = $principal + ($contribution * $months);
    $totalInterest = $totalValue - $totalContributions;
    
    return [
        'future_value' => round($totalValue, 2),
        'total_contributions' => round($totalContributions, 2),
        'total_interest' => round($totalInterest, 2),
        'principal' => $principal,
        'rate' => $rate * 100,
        'years' => $years
    ];
}

/**
 * Percentage Calculator
 */
function calculate_percentage(array $data): array {
    if (!isset($data['value']) || !isset($data['total'])) {
        throw new Exception('Missing value or total');
    }
    
    $value = floatval($data['value']);
    $total = floatval($data['total']);
    
    if ($total == 0) {
        throw new Exception('Total cannot be zero');
    }
    
    $percentage = ($value / $total) * 100;
    
    return [
        'percentage' => round($percentage, 2),
        'value' => $value,
        'total' => $total
    ];
}

/**
 * Track API Calculation
 */
function track_api_calculation(string $calculator, array $input, array $result): void {
    try {
        $db = Database::getInstance();
        $db->query("
            INSERT INTO api_usage (
                calculator_type, 
                input_data, 
                result_data, 
                ip_address, 
                user_agent,
                created_at
            ) VALUES (?, ?, ?, ?, ?, NOW())
        ", [
            $calculator,
            json_encode($input),
            json_encode($result),
            get_client_ip(),
            get_user_agent()
        ]);
    } catch (Exception $e) {
        error_log("API tracking error: " . $e->getMessage());
    }
}
?>