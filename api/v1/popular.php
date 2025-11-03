<?php
/**
 * Popular Calculators API
 * Get most popular calculators
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

$limit = min(intval($_GET['limit'] ?? 10), 50);
$days = min(intval($_GET['days'] ?? 30), 365);

try {
    $db = Database::getInstance();
    
    $calculators = $db->fetchAll("
        SELECT 
            c.id,
            c.name,
            c.slug,
            c.category,
            c.description,
            COUNT(cu.id) as usage_count
        FROM calculators c
        LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id
            AND cu.created_at > DATE_SUB(NOW(), INTERVAL ? DAY)
        WHERE c.is_active = 1
        GROUP BY c.id
        ORDER BY usage_count DESC, c.page_views DESC
        LIMIT ?
    ", [$days, $limit]);
    
    $formatted = array_map(function($calc) {
        return [
            'id' => $calc['id'],
            'name' => $calc['name'],
            'slug' => $calc['slug'],
            'category' => $calc['category'],
            'description' => truncate_text($calc['description'], 100),
            'usage_count' => intval($calc['usage_count']),
            'url' => "/calculators/{$calc['category']}/{$calc['slug']}"
        ];
    }, $calculators);
    
    json_response([
        'success' => true,
        'period_days' => $days,
        'count' => count($formatted),
        'calculators' => $formatted
    ]);
    
} catch (Exception $e) {
    json_response([
        'error' => 'Database error',
        'message' => $e->getMessage()
    ], 500);
}
?>