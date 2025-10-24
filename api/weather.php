<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Weather {
    
    private $cacheFile = '../data/weather_cache.json';
    private $cacheExpiry = 1800; // 30 minutes
    
    // You can add your API key here from openweathermap.org (free tier)
    private $apiKey = ''; // Add your API key or leave empty for demo data
    
    public function __construct() {
        // Ensure data directory exists
        if (!is_dir('../data')) {
            mkdir('../data', 0755, true);
        }
    }
    
    public function getCurrentWeather($city) {
        try {
            // Check cache first
            $cachedWeather = $this->getFromCache($city);
            if ($cachedWeather !== null) {
                return [
                    'success' => true,
                    'data' => $cachedWeather,
                    'source' => 'cache'
                ];
            }
            
            // Try to fetch from API if key is available
            if (!empty($this->apiKey)) {
                $weather = $this->fetchFromAPI($city);
                
                if ($weather !== null) {
                    $this->saveToCache($city, $weather);
                    return [
                        'success' => true,
                        'data' => $weather,
                        'source' => 'api'
                    ];
                }
            }
            
            // Fallback to demo data
            $weather = $this->getDemoWeather($city);
            return [
                'success' => true,
                'data' => $weather,
                'source' => 'demo',
                'note' => 'Using demo weather data. Add API key for real data.'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getForecast($city, $days = 5) {
        try {
            // Check cache first
            $cacheKey = $city . '_forecast_' . $days;
            $cachedForecast = $this->getFromCache($cacheKey);
            if ($cachedForecast !== null) {
                return [
                    'success' => true,
                    'data' => $cachedForecast,
                    'source' => 'cache'
                ];
            }
            
            // Try to fetch from API if key is available
            if (!empty($this->apiKey)) {
                $forecast = $this->fetchForecastFromAPI($city, $days);
                
                if ($forecast !== null) {
                    $this->saveToCache($cacheKey, $forecast);
                    return [
                        'success' => true,
                        'data' => $forecast,
                        'source' => 'api'
                    ];
                }
            }
            
            // Fallback to demo data
            $forecast = $this->getDemoForecast($city, $days);
            return [
                'success' => true,
                'data' => $forecast,
                'source' => 'demo',
                'note' => 'Using demo forecast data. Add API key for real data.'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function fetchFromAPI($city) {
        if (empty($this->apiKey)) {
            return null;
        }
        
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid={$this->apiKey}&units=metric";
        
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
        
        if (isset($data['main']) && isset($data['weather'])) {
            return [
                'city' => $data['name'],
                'country' => $data['sys']['country'],
                'temperature' => round($data['main']['temp']),
                'feels_like' => round($data['main']['feels_like']),
                'temp_min' => round($data['main']['temp_min']),
                'temp_max' => round($data['main']['temp_max']),
                'humidity' => $data['main']['humidity'],
                'pressure' => $data['main']['pressure'],
                'description' => ucfirst($data['weather'][0]['description']),
                'icon' => $data['weather'][0]['icon'],
                'wind_speed' => $data['wind']['speed'],
                'wind_deg' => $data['wind']['deg'] ?? 0,
                'clouds' => $data['clouds']['all'],
                'visibility' => isset($data['visibility']) ? $data['visibility'] / 1000 : 10,
                'sunrise' => date('H:i', $data['sys']['sunrise']),
                'sunset' => date('H:i', $data['sys']['sunset']),
                'timezone' => $data['timezone'],
                'timestamp' => time()
            ];
        }
        
        return null;
    }
    
    private function fetchForecastFromAPI($city, $days) {
        if (empty($this->apiKey)) {
            return null;
        }
        
        $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=" . urlencode($city) . "&appid={$this->apiKey}&units=metric&cnt=" . ($days * 8);
        
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
        
        if (isset($data['list'])) {
            $forecast = [];
            $currentDay = '';
            
            foreach ($data['list'] as $item) {
                $day = date('Y-m-d', $item['dt']);
                
                if ($day !== $currentDay) {
                    $forecast[] = [
                        'date' => $day,
                        'day' => date('l', $item['dt']),
                        'temp' => round($item['main']['temp']),
                        'temp_min' => round($item['main']['temp_min']),
                        'temp_max' => round($item['main']['temp_max']),
                        'description' => ucfirst($item['weather'][0]['description']),
                        'icon' => $item['weather'][0]['icon'],
                        'humidity' => $item['main']['humidity'],
                        'wind_speed' => $item['wind']['speed'],
                        'clouds' => $item['clouds']['all']
                    ];
                    $currentDay = $day;
                }
            }
            
            return [
                'city' => $data['city']['name'],
                'country' => $data['city']['country'],
                'forecast' => array_slice($forecast, 0, $days),
                'timestamp' => time()
            ];
        }
        
        return null;
    }
    
    private function getDemoWeather($city) {
        $cities = [
            'london' => ['temp' => 15, 'desc' => 'Cloudy', 'country' => 'GB'],
            'paris' => ['temp' => 18, 'desc' => 'Partly cloudy', 'country' => 'FR'],
            'new york' => ['temp' => 22, 'desc' => 'Clear sky', 'country' => 'US'],
            'tokyo' => ['temp' => 24, 'desc' => 'Sunny', 'country' => 'JP'],
            'sydney' => ['temp' => 26, 'desc' => 'Clear sky', 'country' => 'AU'],
            'delhi' => ['temp' => 32, 'desc' => 'Hot and sunny', 'country' => 'IN'],
            'mumbai' => ['temp' => 30, 'desc' => 'Humid', 'country' => 'IN'],
            'bangalore' => ['temp' => 28, 'desc' => 'Pleasant', 'country' => 'IN'],
            'hyderabad' => ['temp' => 31, 'desc' => 'Sunny', 'country' => 'IN'],
            'chennai' => ['temp' => 33, 'desc' => 'Hot and humid', 'country' => 'IN']
        ];
        
        $cityLower = strtolower($city);
        $cityData = isset($cities[$cityLower]) ? $cities[$cityLower] : ['temp' => 25, 'desc' => 'Partly cloudy', 'country' => 'XX'];
        
        return [
            'city' => ucwords($city),
            'country' => $cityData['country'],
            'temperature' => $cityData['temp'],
            'feels_like' => $cityData['temp'] + rand(-2, 2),
            'temp_min' => $cityData['temp'] - rand(2, 5),
            'temp_max' => $cityData['temp'] + rand(2, 5),
            'humidity' => rand(40, 80),
            'pressure' => rand(1010, 1020),
            'description' => $cityData['desc'],
            'icon' => '01d',
            'wind_speed' => rand(5, 20),
            'wind_deg' => rand(0, 360),
            'clouds' => rand(0, 100),
            'visibility' => rand(8, 10),
            'sunrise' => '06:30',
            'sunset' => '18:45',
            'timezone' => 0,
            'timestamp' => time()
        ];
    }
    
    private function getDemoForecast($city, $days) {
        $forecast = [];
        $baseTemp = rand(20, 30);
        
        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime("+{$i} days"));
            $temp = $baseTemp + rand(-5, 5);
            
            $conditions = ['Clear sky', 'Partly cloudy', 'Cloudy', 'Light rain', 'Sunny'];
            $icons = ['01d', '02d', '03d', '10d', '01d'];
            $index = $i % count($conditions);
            
            $forecast[] = [
                'date' => $date,
                'day' => date('l', strtotime($date)),
                'temp' => $temp,
                'temp_min' => $temp - rand(2, 4),
                'temp_max' => $temp + rand(2, 4),
                'description' => $conditions[$index],
                'icon' => $icons[$index],
                'humidity' => rand(40, 80),
                'wind_speed' => rand(5, 20),
                'clouds' => rand(0, 100)
            ];
        }
        
        return [
            'city' => ucwords($city),
            'country' => 'XX',
            'forecast' => $forecast,
            'timestamp' => time()
        ];
    }
    
    private function getFromCache($key) {
        if (!file_exists($this->cacheFile)) {
            return null;
        }
        
        $cache = json_decode(file_get_contents($this->cacheFile), true);
        
        if (!$cache) {
            return null;
        }
        
        $cacheKey = strtolower($key);
        
        if (isset($cache[$cacheKey])) {
            $cachedData = $cache[$cacheKey];
            
            // Check if cache is still valid
            if (time() - $cachedData['timestamp'] < $this->cacheExpiry) {
                unset($cachedData['timestamp']);
                return $cachedData;
            }
        }
        
        return null;
    }
    
    private function saveToCache($key, $data) {
        $cache = [];
        
        if (file_exists($this->cacheFile)) {
            $cache = json_decode(file_get_contents($this->cacheFile), true) ?: [];
        }
        
        $cacheKey = strtolower($key);
        $data['timestamp'] = time();
        $cache[$cacheKey] = $data;
        
        // Keep only last 20 entries in cache
        if (count($cache) > 20) {
            $cache = array_slice($cache, -20, 20, true);
        }
        
        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
    
    public function clearCache() {
        try {
            if (file_exists($this->cacheFile)) {
                unlink($this->cacheFile);
            }
            
            return [
                'success' => true,
                'message' => 'Weather cache cleared successfully'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function getWeatherIcon($iconCode) {
        $icons = [
            '01d' => '☀️', '01n' => '🌙',
            '02d' => '⛅', '02n' => '☁️',
            '03d' => '☁️', '03n' => '☁️',
            '04d' => '☁️', '04n' => '☁️',
            '09d' => '🌧️', '09n' => '🌧️',
            '10d' => '🌦️', '10n' => '🌧️',
            '11d' => '⛈️', '11n' => '⛈️',
            '13d' => '❄️', '13n' => '❄️',
            '50d' => '🌫️', '50n' => '🌫️'
        ];
        
        return isset($icons[$iconCode]) ? $icons[$iconCode] : '🌤️';
    }
}

// Handle the request
$weather = new Weather();
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    switch ($action) {
        case 'current':
            if (isset($_GET['city'])) {
                $response = $weather->getCurrentWeather($_GET['city']);
            } else {
                $response = ['success' => false, 'error' => 'City parameter is required'];
            }
            break;
            
        case 'forecast':
            if (isset($_GET['city'])) {
                $days = isset($_GET['days']) ? intval($_GET['days']) : 5;
                $days = min(max($days, 1), 7); // Limit between 1-7 days
                $response = $weather->getForecast($_GET['city'], $days);
            } else {
                $response = ['success' => false, 'error' => 'City parameter is required'];
            }
            break;
            
        case 'icon':
            if (isset($_GET['code'])) {
                $icon = $weather->getWeatherIcon($_GET['code']);
                $response = ['success' => true, 'icon' => $icon];
            } else {
                $response = ['success' => false, 'error' => 'Icon code parameter is required'];
            }
            break;
            
        case 'clear-cache':
            $response = $weather->clearCache();
            break;
            
        default:
            $response = ['success' => false, 'error' => 'Unknown action'];
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'current':
                if (isset($data['city'])) {
                    $response = $weather->getCurrentWeather($data['city']);
                } else {
                    $response = ['success' => false, 'error' => 'City parameter is required'];
                }
                break;
                
            case 'forecast':
                if (isset($data['city'])) {
                    $days = isset($data['days']) ? intval($data['days']) : 5;
                    $days = min(max($days, 1), 7);
                    $response = $weather->getForecast($data['city'], $days);
                } else {
                    $response = ['success' => false, 'error' => 'City parameter is required'];
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
