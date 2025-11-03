/**
 * Calculator JavaScript
 * Core calculation functionality
 */

(function() {
    'use strict';

    /**
     * Base Calculator Class
     */
    class Calculator {
        constructor(formId, options = {}) {
            this.form = document.getElementById(formId);
            this.options = options;
            this.currency = localStorage.getItem('preferred_currency') || 'USD';
            
            if (this.form) {
                this.init();
            }
        }

        /**
         * Initialize Calculator
         */
        init() {
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.calculate();
            });

            // Reset button
            const resetBtn = this.form.querySelector('.btn-reset');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    this.reset();
                });
            }

            // Real-time calculation
            if (this.options.realtime) {
                const inputs = this.form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('input', debounce(() => {
                        this.calculate();
                    }, 500));
                });
            }

            // Listen for currency changes
            window.addEventListener('currencyChanged', (e) => {
                this.currency = e.detail.currency;
                if (this.lastResult) {
                    this.displayResult(this.lastResult);
                }
            });
        }

        /**
         * Get Form Data
         */
        getFormData() {
            const formData = new FormData(this.form);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                // Convert numeric values
                if (!isNaN(value) && value !== '') {
                    data[key] = parseFloat(value);
                } else {
                    data[key] = value;
                }
            }
            
            return data;
        }

        /**
         * Validate Inputs
         */
        validate(data) {
            const errors = [];
            
            // Override this method in child classes
            
            return {
                isValid: errors.length === 0,
                errors: errors
            };
        }

        /**
         * Calculate
         */
        calculate() {
            const data = this.getFormData();
            const validation = this.validate(data);

            if (!validation.isValid) {
                this.showErrors(validation.errors);
                return;
            }

            // Show loading
            this.showLoading();

            // Perform calculation
            try {
                const result = this.performCalculation(data);
                this.lastResult = result;
                this.displayResult(result);
                this.trackCalculation(data, result);
            } catch (error) {
                this.showError(error.message);
            }
        }

        /**
         * Perform Calculation (Override in child classes)
         */
        performCalculation(data) {
            throw new Error('performCalculation method must be implemented');
        }

        /**
         * Display Result
         */
        displayResult(result) {
            const resultContainer = document.getElementById('result-container');
            
            if (!resultContainer) return;

            resultContainer.innerHTML = this.formatResult(result);
            resultContainer.classList.add('animate-slide-in-up');
            resultContainer.style.display = 'block';
        }

        /**
         * Format Result (Override in child classes)
         */
        formatResult(result) {
            return `<div class="result-card"><h3>Result: ${result}</h3></div>`;
        }

        /**
         * Show Loading
         */
        showLoading() {
            const resultContainer = document.getElementById('result-container');
            if (resultContainer) {
                resultContainer.innerHTML = '<div class="loading-spinner"><div class="spinner"></div></div>';
                resultContainer.style.display = 'block';
            }
        }

        /**
         * Show Errors
         */
        showErrors(errors) {
            const errorHtml = errors.map(error => 
                `<div class="alert alert-danger">${error}</div>`
            ).join('');
            
            const resultContainer = document.getElementById('result-container');
            if (resultContainer) {
                resultContainer.innerHTML = errorHtml;
                resultContainer.style.display = 'block';
            }
        }

        /**
         * Show Error
         */
        showError(message) {
            const resultContainer = document.getElementById('result-container');
            if (resultContainer) {
                resultContainer.innerHTML = `<div class="alert alert-danger">${message}</div>`;
                resultContainer.style.display = 'block';
            }
        }

        /**
         * Reset Form
         */
        reset() {
            this.form.reset();
            const resultContainer = document.getElementById('result-container');
            if (resultContainer) {
                resultContainer.style.display = 'none';
            }
            this.lastResult = null;
        }

        /**
         * Track Calculation
         */
        trackCalculation(inputData, resultData) {
            fetch('/api/track/calculation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    calculator: this.options.name || 'unknown',
                    input_data: inputData,
                    result_data: resultData
                })
            }).catch(error => {
                console.error('Tracking error:', error);
            });
        }

        /**
         * Save Calculation
         */
        saveCalculation(name) {
            if (!this.lastResult) {
                showNotification('No calculation to save', 'warning');
                return;
            }

            const data = {
                calculator_name: this.options.name,
                calculation_name: name,
                input_data: this.getFormData(),
                result_data: this.lastResult
            };

            fetch('/api/calculations/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Calculation saved successfully!', 'success');
                } else {
                    showNotification('Failed to save calculation', 'error');
                }
            })
            .catch(error => {
                console.error('Save error:', error);
                showNotification('Failed to save calculation', 'error');
            });
        }

        /**
         * Print Result
         */
        printResult() {
            window.print();
        }

        /**
         * Share Result
         */
        shareResult() {
            if (navigator.share) {
                navigator.share({
                    title: this.options.name || 'Calculator Result',
                    text: 'Check out my calculation result!',
                    url: window.location.href
                }).catch(error => {
                    console.error('Share error:', error);
                });
            } else {
                copyToClipboard(window.location.href);
                showNotification('Link copied to clipboard!', 'success');
            }
        }
    }

    // Make Calculator class globally available
    window.Calculator = Calculator;

    /**
     * Financial Calculator Helper Functions
     */
    window.FinancialCalculator = {
        /**
         * Calculate Monthly Payment
         */
        calculateMonthlyPayment(principal, annualRate, years) {
            const monthlyRate = annualRate / 100 / 12;
            const numberOfPayments = years * 12;
            
            if (monthlyRate === 0) {
                return principal / numberOfPayments;
            }
            
            const payment = principal * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                           (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            
            return payment;
        },

        /**
         * Calculate Compound Interest
         */
        calculateCompoundInterest(principal, annualRate, years, compoundsPerYear = 12) {
            const rate = annualRate / 100;
            const amount = principal * Math.pow((1 + rate / compoundsPerYear), compoundsPerYear * years);
            return amount;
        },

        /**
         * Calculate Future Value
         */
        calculateFutureValue(principal, monthlyContribution, annualRate, years) {
            const monthlyRate = annualRate / 100 / 12;
            const months = years * 12;
            
            // Future value of principal
            const fvPrincipal = principal * Math.pow(1 + monthlyRate, months);
            
            // Future value of contributions
            const fvContributions = monthlyContribution * 
                ((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate);
            
            return fvPrincipal + fvContributions;
        },

        /**
         * Calculate Present Value
         */
        calculatePresentValue(futureValue, annualRate, years) {
            const rate = annualRate / 100;
            return futureValue / Math.pow(1 + rate, years);
        },

        /**
         * Calculate ROI
         */
        calculateROI(initialInvestment, finalValue) {
            return ((finalValue - initialInvestment) / initialInvestment) * 100;
        }
    };

    /**
     * Health Calculator Helper Functions
     */
    window.HealthCalculator = {
        /**
         * Calculate BMI
         */
        calculateBMI(weight, height) {
            // weight in kg, height in meters
            return weight / (height * height);
        },

        /**
         * Get BMI Category
         */
        getBMICategory(bmi) {
            if (bmi < 18.5) return 'Underweight';
            if (bmi < 25) return 'Normal weight';
            if (bmi < 30) return 'Overweight';
            return 'Obese';
        },

        /**
         * Calculate BMR (Mifflin-St Jeor)
         */
        calculateBMR(weight, height, age, gender) {
            // weight in kg, height in cm
            let bmr = (10 * weight) + (6.25 * height) - (5 * age);
            return gender === 'male' ? bmr + 5 : bmr - 161;
        },

        /**
         * Calculate TDEE
         */
        calculateTDEE(bmr, activityLevel) {
            const multipliers = {
                'sedentary': 1.2,
                'light': 1.375,
                'moderate': 1.55,
                'active': 1.725,
                'very_active': 1.9
            };
            return bmr * (multipliers[activityLevel] || 1.2);
        },

        /**
         * Calculate Ideal Weight (Robinson Formula)
         */
        calculateIdealWeight(height, gender) {
            // height in cm
            const inches = height / 2.54;
            const baseHeight = 60;
            
            if (gender === 'male') {
                return 52 + (1.9 * (inches - baseHeight));
            } else {
                return 49 + (1.7 * (inches - baseHeight));
            }
        },

        /**
         * Calculate Body Fat Percentage (Navy Method)
         */
        calculateBodyFat(waist, neck, height, hip = null, gender = 'male') {
            if (gender === 'male') {
                return 495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 
                       0.15456 * Math.log10(height)) - 450;
            } else {
                return 495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 
                       0.22100 * Math.log10(height)) - 450;
            }
        }
    };

    /**
     * Math Calculator Helper Functions
     */
    window.MathCalculator = {
        /**
         * Calculate Percentage
         */
        calculatePercentage(value, total) {
            return (value / total) * 100;
        },

        /**
         * Calculate Percentage Change
         */
        calculatePercentageChange(oldValue, newValue) {
            return ((newValue - oldValue) / oldValue) * 100;
        },

        /**
         * Calculate Standard Deviation
         */
        calculateStandardDeviation(values) {
            const n = values.length;
            const mean = values.reduce((a, b) => a + b) / n;
            const squaredDiffs = values.map(value => Math.pow(value - mean, 2));
            const variance = squaredDiffs.reduce((a, b) => a + b) / n;
            return Math.sqrt(variance);
        },

        /**
         * Calculate Mean
         */
        calculateMean(values) {
            return values.reduce((a, b) => a + b) / values.length;
        },

        /**
         * Calculate Median
         */
        calculateMedian(values) {
            const sorted = values.slice().sort((a, b) => a - b);
            const mid = Math.floor(sorted.length / 2);
            return sorted.length % 2 !== 0 ? sorted[mid] : (sorted[mid - 1] + sorted[mid]) / 2;
        },

        /**
         * Calculate Mode
         */
        calculateMode(values) {
            const frequency = {};
            let maxFreq = 0;
            let modes = [];
            
            values.forEach(value => {
                frequency[value] = (frequency[value] || 0) + 1;
                if (frequency[value] > maxFreq) {
                    maxFreq = frequency[value];
                }
            });
            
            for (let key in frequency) {
                if (frequency[key] === maxFreq) {
                    modes.push(Number(key));
                }
            }
            
            return modes;
        }
    };

})();