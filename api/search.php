<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Search {
    
    private $historyFile = '../data/history.json';
    private $constantsFile = '../data/constants.json';
    
    public function __construct() {
        // Ensure data directory exists
        if (!is_dir('../data')) {
            mkdir('../data', 0755, true);
        }
        
        // Initialize files if they don't exist
        if (!file_exists($this->historyFile)) {
            file_put_contents($this->historyFile, json_encode([]));
        }
        if (!file_exists($this->constantsFile)) {
            $this->initializeConstants();
        }
    }
    
    private function initializeConstants() {
        $constants = [
            'mathematical' => [
                ['name' => 'Pi', 'symbol' => 'π', 'value' => M_PI, 'description' => 'Ratio of circle circumference to diameter'],
                ['name' => 'Euler\'s number', 'symbol' => 'e', 'value' => M_E, 'description' => 'Base of natural logarithm'],
                ['name' => 'Golden ratio', 'symbol' => 'φ', 'value' => 1.618033988749895, 'description' => 'Divine proportion'],
                ['name' => 'Square root of 2', 'symbol' => '√2', 'value' => M_SQRT2, 'description' => 'Pythagoras constant'],
                ['name' => 'Square root of 3', 'symbol' => '√3', 'value' => 1.7320508075688772, 'description' => 'Theodorus constant']
            ],
            'physical' => [
                ['name' => 'Speed of light', 'symbol' => 'c', 'value' => 299792458, 'unit' => 'm/s', 'description' => 'Speed of light in vacuum'],
                ['name' => 'Gravitational constant', 'symbol' => 'G', 'value' => 6.67430e-11, 'unit' => 'm³/kg·s²', 'description' => 'Newton\'s gravitational constant'],
                ['name' => 'Planck constant', 'symbol' => 'h', 'value' => 6.62607015e-34, 'unit' => 'J·s', 'description' => 'Quantum of action'],
                ['name' => 'Avogadro constant', 'symbol' => 'Nₐ', 'value' => 6.02214076e23, 'unit' => 'mol⁻¹', 'description' => 'Number of particles per mole'],
                ['name' => 'Boltzmann constant', 'symbol' => 'k', 'value' => 1.380649e-23, 'unit' => 'J/K', 'description' => 'Relates energy to temperature']
            ],
            'other' => [
                ['name' => 'Absolute zero', 'symbol' => '', 'value' => -273.15, 'unit' => '°C', 'description' => 'Lowest possible temperature'],
                ['name' => 'Standard gravity', 'symbol' => 'g', 'value' => 9.80665, 'unit' => 'm/s²', 'description' => 'Earth\'s gravitational acceleration'],
                ['name' => 'Atmospheric pressure', 'symbol' => 'atm', 'value' => 101325, 'unit' => 'Pa', 'description' => 'Standard atmospheric pressure at sea level']
            ]
        ];
        
        file_put_contents($this->constantsFile, json_encode($constants, JSON_PRETTY_PRINT));
    }
    
    public function searchHistory($query) {
        try {
            $history = $this->getHistory();
            $query = strtolower(trim($query));
            
            if (empty($query)) {
                return [
                    'success' => true,
                    'results' => array_slice($history, 0, 10),
                    'count' => count($history)
                ];
            }
            
            $results = array_filter($history, function($item) use ($query) {
                return stripos($item['expression'], $query) !== false ||
                       stripos($item['result'], $query) !== false;
            });
            
            return [
                'success' => true,
                'results' => array_values($results),
                'count' => count($results),
                'query' => $query
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function searchConstants($query) {
        try {
            $constants = json_decode(file_get_contents($this->constantsFile), true);
            $query = strtolower(trim($query));
            
            if (empty($query)) {
                return [
                    'success' => true,
                    'results' => $constants,
                    'count' => $this->countAllConstants($constants)
                ];
            }
            
            $results = [];
            foreach ($constants as $category => $items) {
                $filtered = array_filter($items, function($item) use ($query) {
                    return stripos($item['name'], $query) !== false ||
                           stripos($item['symbol'], $query) !== false ||
                           stripos($item['description'], $query) !== false;
                });
                
                if (!empty($filtered)) {
                    $results[$category] = array_values($filtered);
                }
            }
            
            return [
                'success' => true,
                'results' => $results,
                'count' => $this->countAllConstants($results),
                'query' => $query
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function addHistory($expression, $result) {
        try {
            $history = $this->getHistory();
            
            $newEntry = [
                'id' => uniqid(),
                'expression' => $expression,
                'result' => $result,
                'timestamp' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d')
            ];
            
            // Add to beginning of array
            array_unshift($history, $newEntry);
            
            // Keep only last 100 entries
            $history = array_slice($history, 0, 100);
            
            file_put_contents($this->historyFile, json_encode($history, JSON_PRETTY_PRINT));
            
            return [
                'success' => true,
                'entry' => $newEntry
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getHistory() {
        if (!file_exists($this->historyFile)) {
            return [];
        }
        
        $content = file_get_contents($this->historyFile);
        return json_decode($content, true) ?: [];
    }
    
    public function clearHistory() {
        try {
            file_put_contents($this->historyFile, json_encode([]));
            
            return [
                'success' => true,
                'message' => 'History cleared successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function deleteHistoryItem($id) {
        try {
            $history = $this->getHistory();
            
            $history = array_filter($history, function($item) use ($id) {
                return $item['id'] !== $id;
            });
            
            file_put_contents($this->historyFile, json_encode(array_values($history), JSON_PRETTY_PRINT));
            
            return [
                'success' => true,
                'message' => 'Item deleted successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getStatistics() {
        try {
            $history = $this->getHistory();
            
            $totalCalculations = count($history);
            $today = date('Y-m-d');
            $todayCount = 0;
            $thisWeekCount = 0;
            $thisMonthCount = 0;
            
            $weekAgo = date('Y-m-d', strtotime('-7 days'));
            $monthAgo = date('Y-m-d', strtotime('-30 days'));
            
            foreach ($history as $item) {
                if ($item['date'] === $today) {
                    $todayCount++;
                }
                if ($item['date'] >= $weekAgo) {
                    $thisWeekCount++;
                }
                if ($item['date'] >= $monthAgo) {
                    $thisMonthCount++;
                }
            }
            
            return [
                'success' => true,
                'statistics' => [
                    'total' => $totalCalculations,
                    'today' => $todayCount,
                    'week' => $thisWeekCount,
                    'month' => $thisMonthCount
                ]
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function countAllConstants($constants) {
        $count = 0;
        foreach ($constants as $items) {
            $count += count($items);
        }
        return $count;
    }
}

// Handle the request
$search = new Search();
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'history':
            $query = isset($_GET['q']) ? $_GET['q'] : '';
            $response = $search->searchHistory($query);
            break;
            
        case 'constants':
            $query = isset($_GET['q']) ? $_GET['q'] : '';
            $response = $search->searchConstants($query);
            break;
            
        case 'statistics':
            $response = $search->getStatistics();
            break;
            
        case 'get-history':
            $response = [
                'success' => true,
                'results' => $search->getHistory()
            ];
            break;
            
        default:
            $response = ['success' => false, 'error' => 'Unknown action'];
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'add':
                if (isset($data['expression']) && isset($data['result'])) {
                    $response = $search->addHistory($data['expression'], $data['result']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing expression or result'];
                }
                break;
                
            case 'clear':
                $response = $search->clearHistory();
                break;
                
            case 'delete':
                if (isset($data['id'])) {
                    $response = $search->deleteHistoryItem($data['id']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing item ID'];
                }
                break;
                
            default:
                $response = ['success' => false, 'error' => 'Unknown action'];
        }
    } else {
        $response = ['success' => false, 'error' => 'No action specified'];
    }
    
} else {
    $response = ['success' => false, 'error' => 'Invalid request method'];
}

echo json_encode($response);
?>  
