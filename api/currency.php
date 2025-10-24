 <?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Currency {
    
    private $cacheFile = '../data/currency_cache.json';
    private $cacheExpiry = 3600; // 1 hour
    
    // Fallback exchange rates (base: USD)
    private $fallbackRates = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'GBP' => 0.79,
        'JPY' => 149.50,
        'AUD' => 1.52,
        'CAD' => 1.36,
        'CHF' => 0.88,
        'CNY' => 7.24,
        'INR' => 83.12,
        'MXN' => 17.15,
        'BRL' => 4.98,
        'ZAR' => 18.75,
        'RUB' => 92.50,
        'KRW' => 1320.00,
        'SGD' => 1.34,
        'HKD' => 7.82,
        'NOK' => 10.65,
        'SEK' => 10.45,
        'DKK' => 6.87,
        'NZD' => 1.65,
        'TRY' => 28.50,
        'PLN' => 3.98,
        'THB' => 35.20,
        'MYR' => 4.72,
        'IDR' => 15600.00,
        'PHP' => 56.25,
        'CZK' => 22.80,
        'ILS' => 3.65,
        'AED' => 3.67,
        'SAR' => 3.75
    ];
    
    public function __construct() {
        // Ensure data directory exists
        if (!is_dir('../data')) {
            mkdir('../data', 0755, true);
        }
    }
    
    public function getRates($base = 'USD') {
        try {
            // Check cache first
            $cachedRates = $this->getFromCache($base);
            if ($cachedRates !== null) {
                return [
                    'success' => true,
                    'base' => $base,
                    'rates' => $cachedRates,
                    'timestamp' => time(),
                    'source' => 'cache'
                ];
            }
            
            // Try to fetch from API
            $rates = $this->fetchFromAPI($base);
            
            if ($rates !== null) {
                $this->saveToCache($base, $rates);
                return [
                    'success' => true,
                    'base' => $base,
                    'rates' => $rates,
                    'timestamp' => time(),
                    'source' => 'api'
                ];
            }
            
            // Fallback to static rates
            $rates = $this->convertFromFallback($base);
            return [
                'success' => true,
                'base' => $base,
                'rates' => $rates,
                'timestamp' => time(),
                'source' => 'fallback',
                'note' => 'Using static exchange rates. Rates may not be current.'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function convert($amount, $from, $to) {
        try {
            $amount = floatval($amount);
            
            if ($from === $to) {
                return [
                    'success' => true,
                    'amount' => $amount,
                    'from' => $from,
                    'to' => $to,
                    'result' => $amount,
                    'rate' => 1.0
                ];
            }
            
            // Get rates with base currency = from
            $ratesData = $this->getRates($from);
            
            if (!$ratesData['success']) {
                throw new Exception('Failed to get exchange rates');
            }
            
            $rates = $ratesData['rates'];
            
            if (!isset($rates[$to])) {
                throw new Exception('Target currency not found');
            }
            
            $rate = $rates[$to];
            $result = $amount * $rate;
            
            return [
                'success' => true,
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
                'result' => round($result, 2),
                'rate' => $rate,
                'timestamp' => $ratesData['timestamp'],
                'source' => $ratesData['source']
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getCurrencyList() {
        return [
            'success' => true,
            'currencies' => [
                'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'flag' => '🇺🇸'],
                'EUR' => ['name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺'],
                'GBP' => ['name' => 'British Pound', 'symbol' => '£', 'flag' => '🇬🇧'],
                'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥', 'flag' => '🇯🇵'],
                'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$', 'flag' => '🇦🇺'],
                'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'C$', 'flag' => '🇨🇦'],
                'CHF' => ['name' => 'Swiss Franc', 'symbol' => 'Fr', 'flag' => '🇨🇭'],
                'CNY' => ['name' => 'Chinese Yuan', 'symbol' => '¥', 'flag' => '🇨🇳'],
                'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹', 'flag' => '🇮🇳'],
                'MXN' => ['name' => 'Mexican Peso', 'symbol' => '$', 'flag' => '🇲🇽'],
                'BRL' => ['name' => 'Brazilian Real', 'symbol' => 'R$', 'flag' => '🇧🇷'],
                'ZAR' => ['name' => 'South African Rand', 'symbol' => 'R', 'flag' => '🇿🇦'],
                'RUB' => ['name' => 'Russian Ruble', 'symbol' => '₽', 'flag' => '🇷🇺'],
                'KRW' => ['name' => 'South Korean Won', 'symbol' => '₩', 'flag' => '🇰🇷'],
                'SGD' => ['name' => 'Singapore Dollar', 'symbol' => 'S$', 'flag' => '🇸🇬'],
                'HKD' => ['name' => 'Hong Kong Dollar', 'symbol' => 'HK$', 'flag' => '🇭🇰'],
                'NOK' => ['name' => 'Norwegian Krone', 'symbol' => 'kr', 'flag' => '🇳🇴'],
                'SEK' => ['name' => 'Swedish Krona', 'symbol' => 'kr', 'flag' => '🇸🇪'],
                'DKK' => ['name' => 'Danish Krone', 'symbol' => 'kr', 'flag' => '🇩🇰'],
                'NZD' => ['name' => 'New Zealand Dollar', 'symbol' => 'NZ$', 'flag' => '🇳🇿'],
                'TRY' => ['name' => 'Turkish Lira', 'symbol' => '₺', 'flag' => '🇹🇷'],
                'PLN' => ['name' => 'Polish Zloty', 'symbol' => 'zł', 'flag' => '🇵🇱'],
                'THB' => ['name' => 'Thai Baht', 'symbol' => '฿', 'flag' => '🇹🇭'],
                'MYR' => ['name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'flag' => '🇲🇾'],
                'IDR' => ['name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'flag' => '🇮🇩'],
                'PHP' => ['name' => 'Philippine Peso', 'symbol' => '₱', 'flag' => '🇵🇭'],
                'CZK' => ['name' => 'Czech Koruna', 'symbol' => 'Kč', 'flag' => '🇨🇿'],
                'ILS' => ['name' => 'Israeli Shekel', 'symbol' => '₪', 'flag' => '🇮🇱'],
                'AED' => ['name' => 'UAE Dirham', 'symbol' => 'د.إ', 'flag' => '🇦🇪'],
                'SAR' => ['name' => 'Saudi Riyal', 'symbol' => '﷼', 'flag' => '🇸🇦']
            ]
        ];
    }
    
    private function fetchFromAPI($base) {
        // Try exchangerate-api.com (free tier)
        $apiUrl = "https://api.exchangerate-api.com/v4/latest/{$base}";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'ignore_errors' => true
            ]
        ]);
        
        $response = @file_get_contents($apiUrl, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        $data = json_decode($response, true);
        
        if (isset($data['rates'])) {
            return $data['rates'];
        }
        
        return null;
    }
    
    private function getFromCache($base) {
        if (!file_exists($this->cacheFile)) {
            return null;
        }
        
        $cache = json_decode(file_get_contents($this->cacheFile), true);
        
        if (!$cache) {
            return null;
        }
        
        $cacheKey = $base;
        
        if (isset($cache[$cacheKey])) {
            $cachedData = $cache[$cacheKey];
            
            // Check if cache is still valid
            if (time() - $cachedData['timestamp'] < $this->cacheExpiry) {
                return $cachedData['rates'];
            }
        }
        
        return null;
    }
    
    private function saveToCache($base, $rates) {
        $cache = [];
        
        if (file_exists($this->cacheFile)) {
            $cache = json_decode(file_get_contents($this->cacheFile), true) ?: [];
        }
        
        $cache[$base] = [
            'rates' => $rates,
            'timestamp' => time()
        ];
        
        // Keep only last 10 base currencies in cache
        if (count($cache) > 10) {
            $cache = array_slice($cache, -10, 10, true);
        }
        
        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
    
    private function convertFromFallback($base) {
        if (!isset($this->fallbackRates[$base])) {
            throw new Exception('Base currency not found in fallback rates');
        }
        
        $baseRate = $this->fallbackRates[$base];
        $rates = [];
        
        foreach ($this->fallbackRates as $currency => $rate) {
            $rates[$currency] = $rate / $baseRate;
        }
        
        return $rates;
    }
    
    public function clearCache() {
        try {
            if (file_exists($this->cacheFile)) {
                unlink($this->cacheFile);
            }
            
            return [
                'success' => true,
                'message' => 'Cache cleared successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}

// Handle the request
$currency = new Currency();
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'rates':
            $base = isset($_GET['base']) ? strtoupper($_GET['base']) : 'USD';
            $response = $currency->getRates($base);
            break;
            
        case 'convert':
            if (isset($_GET['amount']) && isset($_GET['from']) && isset($_GET['to'])) {
                $amount = $_GET['amount'];
                $from = strtoupper($_GET['from']);
                $to = strtoupper($_GET['to']);
                $response = $currency->convert($amount, $from, $to);
            } else {
                $response = ['success' => false, 'error' => 'Missing parameters'];
            }
            break;
            
        case 'list':
            $response = $currency->getCurrencyList();
            break;
            
        case 'clear-cache':
            $response = $currency->clearCache();
            break;
            
        default:
            $response = ['success' => false, 'error' => 'Unknown action'];
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'convert':
                if (isset($data['amount']) && isset($data['from']) && isset($data['to'])) {
                    $response = $currency->convert($data['amount'], $data['from'], $data['to']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing parameters'];
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
