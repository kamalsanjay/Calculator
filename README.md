# Scientific Calculator

A comprehensive, full-featured scientific calculator built with HTML, CSS, and JavaScript.

## Features

### Basic Operations
- Addition (+)
- Subtraction (-)
- Multiplication (×)
- Division (÷)
- Percentage calculation (a % b) - Calculates "a percent of b"

### Scientific Functions
- **Trigonometric Functions**: sin, cos, tan
- **Logarithmic Functions**:
  - log (base 10)
  - ln (natural logarithm)
  - **logb (custom base)** - Calculate log with any base (e.g., log₂(8) = 3)
- **Power Functions**:
  - x² (square)
  - x³ (cube)
  - xʸ (power)
  - √ (square root)
  - ∛ (cube root)
- **Other Functions**:
  - 1/x (reciprocal)

### Memory Functions
- MC (Memory Clear)
- MR (Memory Recall)
- M+ (Memory Add)
- M- (Memory Subtract)
- MS (Memory Store)

### Angle Modes
- DEG (Degrees) - default
- RAD (Radians)

### Constants
- π (Pi)
- e (Euler's number)

### Additional Features
- Expression display showing current calculation
- Memory indicator
- Keyboard support for basic operations
- Error handling for invalid operations
- Responsive design for mobile and desktop
- Beautiful gradient UI

## Usage

### Opening the Calculator
Simply open `scientific-calculator.php` in your web browser, or use `index.html` which will redirect automatically.

### Example Operations

#### Percentage (a%b)
To calculate "5 percent of 20":
1. Enter `5`
2. Click `%`
3. Enter `20`
4. Click `=`
5. Result: `1` (which is 5% of 20)

#### Logarithm with Base (alogb)
To calculate log₂(8):
1. Enter `2` (the base)
2. Click `logb`
3. Enter `8` (the number)
4. Click `=`
5. Result: `3` (because 2³ = 8)

#### Power (xʸ)
To calculate 2⁸:
1. Enter `2`
2. Click `xʸ`
3. Enter `8`
4. Click `=`
5. Result: `256`

#### Trigonometric Functions
1. Select angle mode (DEG or RAD)
2. Enter a number
3. Click sin, cos, or tan
4. Result is displayed immediately

### Keyboard Shortcuts
- Numbers (0-9) and decimal point (.)
- Basic operators: +, -, *, /
- Enter or = : Calculate result
- Escape or C: Clear
- %: Percentage
- Backspace: Delete last digit

## Technical Details

### Fixed Issues
1. **Percentage Operation**: Now correctly calculates "a percent of b" instead of prematurely showing value
2. **Logarithm Base**: Properly implements log with custom base using the formula: log_a(b) = ln(b) / ln(a)
3. **Expression Display**: Shows the full expression before calculating
4. **Error Handling**: Prevents division by zero, invalid logarithms, and other mathematical errors

### Browser Compatibility
Works on all modern browsers including:
- Chrome
- Firefox
- Safari
- Edge

## Files
- `scientific-calculator.php` - Main calculator application
- `index.html` - Redirect page
- `README.md` - This documentation

## License
Open source - feel free to use and modify
