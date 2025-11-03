<?php
/**
 * Categories API
 * Get calculator categories
 */

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../config.php';
require_once '../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(['error' => 'Method not allowed'], 405);
}

try {
    $db = Database::getInstance();
    
    // Get all categories with calculator count
    $categories = $db->fetchAll("
        SELECT 
            c.id,
            c.name,
            c.slug,
            c.icon,
            c.description,
            c.display_order,
            COUNT(calc.id) as calculator_count
        FROM categories c
        LEFT JOIN calculators calc ON c.slug = calc.category AND calc.is_active = 1
        WHERE c.is_active = 1
        GROUP BY c.id
        ORDER BY c.display_order ASC
    ");
    
    json_response([
        'success' => true,
        'count' => count($categories),
        'categories' => $categories
    ]);
    
} catch (Exception $e) {
    json_response([
        'error' => 'Database error',
        'message' => $e->getMessage()
    ], 500);
}
?>