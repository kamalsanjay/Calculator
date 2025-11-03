<?php
/**
 * Search API
 * Search calculators
 */

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../config.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(['error' => 'Method not allowed'], 405);
}

// Get search query
$query = $_GET['q'] ?? '';
$limit = min(intval($_GET['limit'] ?? 10), 50);

if (strlen($query) < 2) {
    json_response(['error' => 'Query must be at least 2 characters'], 400);
}

try {
    $db = Database::getInstance();
    
    $searchTerm = '%' . $query . '%';
    
    $results = $db->fetchAll("
        SELECT 
            id,
            name,
            slug,
            category,
            subcategory,
            description,
            page_views
        FROM calculators
        WHERE is_active = 1
        AND (
            name LIKE ? OR
            description LIKE ? OR
            category LIKE ? OR
            subcategory LIKE ?
        )
        ORDER BY 
            CASE 
                WHEN name LIKE ? THEN 1
                WHEN category LIKE ? THEN 2
                ELSE 3
            END,
            page_views DESC
        LIMIT ?
    ", [
        $searchTerm, $searchTerm, $searchTerm, $searchTerm,
        $searchTerm, $searchTerm,
        $limit
    ]);
    
    // Format results
    $formatted_results = array_map(function($result) {
        return [
            'id' => $result['id'],
            'name' => $result['name'],
            'slug' => $result['slug'],
            'category' => $result['category'],
            'subcategory' => $result['subcategory'],
            'description' => truncate_text($result['description'], 100),
            'url' => "/calculators/{$result['category']}/{$result['slug']}"
        ];
    }, $results);
    
    // Track search
    track_search($query, count($formatted_results));
    
    json_response([
        'success' => true,
        'query' => $query,
        'count' => count($formatted_results),
        'results' => $formatted_results
    ]);
    
} catch (Exception $e) {
    json_response([
        'error' => 'Search error',
        'message' => $e->getMessage()
    ], 500);
}

/**
 * Track Search
 */
function track_search(string $query, int $results_count): void {
    try {
        $db = Database::getInstance();
        $db->query("
            INSERT INTO search_logs (
                query,
                results_count,
                ip_address,
                user_agent,
                created_at
            ) VALUES (?, ?, ?, ?, NOW())
        ", [
            $query,
            $results_count,
            get_client_ip(),
            get_user_agent()
        ]);
    } catch (Exception $e) {
        error_log("Search tracking error: " . $e->getMessage());
    }
}
?>