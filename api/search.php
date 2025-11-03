<?php
/**
 * Search API
 * Returns calculator search results from database
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config.php';

try {
    $query = trim($_GET['q'] ?? '');
    
    if (empty($query) || strlen($query) < 2) {
        echo json_encode([
            'success' => false,
            'message' => 'Query too short',
            'results' => []
        ]);
        exit;
    }
    
    $db = Database::getInstance();
    
    // Search in calculators table
    $stmt = $db->prepare("
        SELECT 
            c.id,
            c.name,
            c.slug,
            c.category,
            c.description,
            cat.name as category_name
        FROM calculators c
        LEFT JOIN categories cat ON c.category = cat.slug
        WHERE c.is_active = 1 
        AND (
            c.name LIKE ? 
            OR c.description LIKE ?
            OR c.category LIKE ?
            OR cat.name LIKE ?
        )
        ORDER BY c.page_views DESC
        LIMIT 20
    ");
    
    $searchTerm = "%{$query}%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    $results = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'query' => $query,
        'results' => $results,
        'count' => count($results)
    ]);
    
} catch (Exception $e) {
    error_log('Search API error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Search failed',
        'results' => []
    ]);
}