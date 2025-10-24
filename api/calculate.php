
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Calculator {
    
    public function evaluate($expression) {
        try {
            // Remove whitespace
            $expression = str_replace(' ', '', $expression);
            
            // Handle special functions
            $expression = $this->handleFunctions($expression);
            
            // Security check - only allow safe characters
            if (!preg_match('/^[0-9+\-*\/().eE\s]+$/', $expression)) {
                throw new Exception('Invalid characters in expression');
            }
            
            // Evaluate the expression
            $result = $this->safeEval($expression);
            
            return [
                'success' => true,
                'result' => $result,
                'expression' => $expression
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function handleFunctions($expr) {
        // Handle sqrt
        $expr = preg_replace_callback('/sqrt\(([^)]+)\)/', function($matches) {
            return sqrt($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle sin
        $expr = preg_replace_callback('/sin\(([^)]+)\)/', function($matches) {
            return sin($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle cos
        $expr = preg_replace_callback('/cos\(([^)]+)\)/', function($matches) {
            return cos($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle tan
        $expr = preg_replace_callback('/tan\(([^)]+)\)/', function($matches) {
            return tan($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle log (natural logarithm)
        $expr = preg_replace_callback('/log\(([^)]+)\)/', function($matches) {
            return log($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle ln (natural logarithm)
        $expr = preg_replace_callback('/ln\(([^)]+)\)/', function($matches) {
            return log($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle exp
        $expr = preg_replace_callback('/exp\(([^)]+)\)/', function($matches) {
            return exp($this->safeEval($matches[1]));
        }, $expr);
        
        // Handle pow
        $expr = preg_replace_callback('/pow\(([^,]+),([^)]+)\)/', function($matches) {
            return pow($this->safeEval($matches[1]), $this->safeEval($matches[2]));
        }, $expr);
        
        return $expr;
    }
    
    private function safeEval($expr) {
        // Replace ^ with ** for power operation
        $expr = str_replace('^', '**', $expr);
        
        // Use a safe evaluation method
        $result = @eval('return ' . $expr . ';');
        
        if ($result === false) {
            throw new Exception('Invalid mathematical expression');
        }
        
        return $result;
    }
    
    public function scientific($operation, $value) {
        try {
            $result = 0;
            
            switch ($operation) {
                case 'sin':
                    $result = sin($value);
                    break;
                case 'cos':
                    $result = cos($value);
                    break;
                case 'tan':
                    $result = tan($value);
                    break;
                case 'sqrt':
                    if ($value < 0) {
                        throw new Exception('Cannot calculate square root of negative number');
                    }
                    $result = sqrt($value);
                    break;
                case 'log':
                    if ($value <= 0) {
                        throw new Exception('Cannot calculate logarithm of non-positive number');
                    }
                    $result = log10($value);
                    break;
                case 'ln':
                    if ($value <= 0) {
                        throw new Exception('Cannot calculate natural logarithm of non-positive number');
                    }
                    $result = log($value);
                    break;
                case 'exp':
                    $result = exp($value);
                    break;
                case 'factorial':
                    if ($value < 0 || $value != floor($value)) {
                        throw new Exception('Factorial only works for non-negative integers');
                    }
                    $result = $this->factorial($value);
                    break;
                case 'square':
                    $result = pow($value, 2);
                    break;
                case 'cube':
                    $result = pow($value, 3);
                    break;
                case 'inverse':
                    if ($value == 0) {
                        throw new Exception('Cannot divide by zero');
                    }
                    $result = 1 / $value;
                    break;
                default:
                    throw new Exception('Unknown operation');
            }
            
            return [
                'success' => true,
                'result' => $result,
                'operation' => $operation,
                'input' => $value
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function factorial($n) {
        if ($n <= 1) return 1;
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }
    
    public function convert($value, $from, $to, $type) {
        try {
            $result = 0;
            
            switch ($type) {
                case 'length':
                    $result = $this->convertLength($value, $from, $to);
                    break;
                case 'weight':
                    $result = $this->convertWeight($value, $from, $to);
                    break;
                case 'temperature':
                    $result = $this->convertTemperature($value, $from, $to);
                    break;
                case 'volume':
                    $result = $this->convertVolume($value, $from, $to);
                    break;
                case 'area':
                    $result = $this->convertArea($value, $from, $to);
                    break;
                case 'speed':
                    $result = $this->convertSpeed($value, $from, $to);
                    break;
                default:
                    throw new Exception('Unknown conversion type');
            }
            
            return [
                'success' => true,
                'result' => $result,
                'value' => $value,
                'from' => $from,
                'to' => $to,
                'type' => $type
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function convertLength($value, $from, $to) {
        $meters = 0;
        
        // Convert to meters first
        switch ($from) {
            case 'mm': $meters = $value / 1000; break;
            case 'cm': $meters = $value / 100; break;
            case 'm': $meters = $value; break;
            case 'km': $meters = $value * 1000; break;
            case 'in': $meters = $value * 0.0254; break;
            case 'ft': $meters = $value * 0.3048; break;
            case 'yd': $meters = $value * 0.9144; break;
            case 'mi': $meters = $value * 1609.34; break;
            default: throw new Exception('Unknown length unit: ' . $from);
        }
        
        // Convert from meters to target unit
        switch ($to) {
            case 'mm': return $meters * 1000;
            case 'cm': return $meters * 100;
            case 'm': return $meters;
            case 'km': return $meters / 1000;
            case 'in': return $meters / 0.0254;
            case 'ft': return $meters / 0.3048;
            case 'yd': return $meters / 0.9144;
            case 'mi': return $meters / 1609.34;
            default: throw new Exception('Unknown length unit: ' . $to);
        }
    }
    
    private function convertWeight($value, $from, $to) {
        $kg = 0;
        
        // Convert to kilograms first
        switch ($from) {
            case 'mg': $kg = $value / 1000000; break;
            case 'g': $kg = $value / 1000; break;
            case 'kg': $kg = $value; break;
            case 't': $kg = $value * 1000; break;
            case 'oz': $kg = $value * 0.0283495; break;
            case 'lb': $kg = $value * 0.453592; break;
            default: throw new Exception('Unknown weight unit: ' . $from);
        }
        
        // Convert from kilograms to target unit
        switch ($to) {
            case 'mg': return $kg * 1000000;
            case 'g': return $kg * 1000;
            case 'kg': return $kg;
            case 't': return $kg / 1000;
            case 'oz': return $kg / 0.0283495;
            case 'lb': return $kg / 0.453592;
            default: throw new Exception('Unknown weight unit: ' . $to);
        }
    }
    
    private function convertTemperature($value, $from, $to) {
        // Convert to Celsius first
        $celsius = 0;
        switch ($from) {
            case 'C': $celsius = $value; break;
            case 'F': $celsius = ($value - 32) * 5/9; break;
            case 'K': $celsius = $value - 273.15; break;
            default: throw new Exception('Unknown temperature unit: ' . $from);
        }
        
        // Convert from Celsius to target unit
        switch ($to) {
            case 'C': return $celsius;
            case 'F': return ($celsius * 9/5) + 32;
            case 'K': return $celsius + 273.15;
            default: throw new Exception('Unknown temperature unit: ' . $to);
        }
    }
    
    private function convertVolume($value, $from, $to) {
        $liters = 0;
        
        // Convert to liters first
        switch ($from) {
            case 'ml': $liters = $value / 1000; break;
            case 'l': $liters = $value; break;
            case 'm3': $liters = $value * 1000; break;
            case 'gal': $liters = $value * 3.78541; break;
            case 'qt': $liters = $value * 0.946353; break;
            case 'pt': $liters = $value * 0.473176; break;
            case 'cup': $liters = $value * 0.236588; break;
            case 'floz': $liters = $value * 0.0295735; break;
            default: throw new Exception('Unknown volume unit: ' . $from);
        }
        
        // Convert from liters to target unit
        switch ($to) {
            case 'ml': return $liters * 1000;
            case 'l': return $liters;
            case 'm3': return $liters / 1000;
            case 'gal': return $liters / 3.78541;
            case 'qt': return $liters / 0.946353;
            case 'pt': return $liters / 0.473176;
            case 'cup': return $liters / 0.236588;
            case 'floz': return $liters / 0.0295735;
            default: throw new Exception('Unknown volume unit: ' . $to);
        }
    }
    
    private function convertArea($value, $from, $to) {
        $sqm = 0;
        
        // Convert to square meters first
        switch ($from) {
            case 'mm2': $sqm = $value / 1000000; break;
            case 'cm2': $sqm = $value / 10000; break;
            case 'm2': $sqm = $value; break;
            case 'km2': $sqm = $value * 1000000; break;
            case 'in2': $sqm = $value * 0.00064516; break;
            case 'ft2': $sqm = $value * 0.092903; break;
            case 'yd2': $sqm = $value * 0.836127; break;
            case 'ac': $sqm = $value * 4046.86; break;
            case 'ha': $sqm = $value * 10000; break;
            default: throw new Exception('Unknown area unit: ' . $from);
        }
        
        // Convert from square meters to target unit
        switch ($to) {
            case 'mm2': return $sqm * 1000000;
            case 'cm2': return $sqm * 10000;
            case 'm2': return $sqm;
            case 'km2': return $sqm / 1000000;
            case 'in2': return $sqm / 0.00064516;
            case 'ft2': return $sqm / 0.092903;
            case 'yd2': return $sqm / 0.836127;
            case 'ac': return $sqm / 4046.86;
            case 'ha': return $sqm / 10000;
            default: throw new Exception('Unknown area unit: ' . $to);
        }
    }
    
    private function convertSpeed($value, $from, $to) {
        $mps = 0;
        
        // Convert to meters per second first
        switch ($from) {
            case 'mps': $mps = $value; break;
            case 'kph': $mps = $value / 3.6; break;
            case 'mph': $mps = $value * 0.44704; break;
            case 'fps': $mps = $value * 0.3048; break;
            case 'knot': $mps = $value * 0.514444; break;
            default: throw new Exception('Unknown speed unit: ' . $from);
        }
        
        // Convert from meters per second to target unit
        switch ($to) {
            case 'mps': return $mps;
            case 'kph': return $mps * 3.6;
            case 'mph': return $mps / 0.44704;
            case 'fps': return $mps / 0.3048;
            case 'knot': return $mps / 0.514444;
            default: throw new Exception('Unknown speed unit: ' . $to);
        }
    }
}

// Handle the request
$calculator = new Calculator();
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'evaluate':
                if (isset($data['expression'])) {
                    $response = $calculator->evaluate($data['expression']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing expression'];
                }
                break;
                
            case 'scientific':
                if (isset($data['operation']) && isset($data['value'])) {
                    $response = $calculator->scientific($data['operation'], $data['value']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing operation or value'];
                }
                break;
                
            case 'convert':
                if (isset($data['value']) && isset($data['from']) && isset($data['to']) && isset($data['type'])) {
                    $response = $calculator->convert($data['value'], $data['from'], $data['to'], $data['type']);
                } else {
                    $response = ['success' => false, 'error' => 'Missing conversion parameters'];
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





























































































































































