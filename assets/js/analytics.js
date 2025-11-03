/**
 * Analytics Tracking
 * Track user interactions and events
 */

(function() {
    'use strict';

    class Analytics {
        constructor() {
            this.sessionId = this.getSessionId();
            this.userId = this.getUserId();
        }

        /**
         * Get or Create Session ID
         */
        getSessionId() {
            let sessionId = sessionStorage.getItem('session_id');
            if (!sessionId) {
                sessionId = this.generateId();
                sessionStorage.setItem('session_id', sessionId);
            }
            return sessionId;
        }

        /**
         * Get User ID
         */
        getUserId() {
            return localStorage.getItem('user_id') || null;
        }

        /**
         * Generate Unique ID
         */
        generateId() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        /**
         * Track Page View
         */
        trackPageView() {
            this.track('page_view', {
                page_url: window.location.href,
                page_title: document.title,
                referrer: document.referrer
            });
        }

        /**
         * Track Event
         */
        trackEvent(eventName, eventData = {}) {
            this.track('event', {
                event_name: eventName,
                event_data: eventData
            });
        }

        /**
         * Track Calculation
         */
        trackCalculation(calculatorName, inputData, resultData) {
            this.track('calculation', {
                calculator_name: calculatorName,
                input_data: inputData,
                result_data: resultData
            });
        }

        /**
         * Track Click
         */
        trackClick(element, label = null) {
            this.track('click', {
                element_type: element.tagName,
                element_id: element.id,
                element_class: element.className,
                label: label || element.textContent.trim().substring(0, 50)
            });
        }

        /**
         * Track Form Submission
         */
        trackFormSubmission(formName) {
            this.track('form_submission', {
                form_name: formName
            });
        }

        /**
         * Track Error
         */
        trackError(error, context = {}) {
            this.track('error', {
                error_message: error.message,
                error_stack: error.stack,
                context: context
            });
        }

        /**
         * Track Performance
         */
        trackPerformance() {
            if (window.performance && window.performance.timing) {
                const timing = window.performance.timing;
                const loadTime = timing.loadEventEnd - timing.navigationStart;
                const domReady = timing.domContentLoadedEventEnd - timing.navigationStart;

                this.track('performance', {
                    load_time: loadTime,
                    dom_ready: domReady,
                    page_url: window.location.href
                });
            }
        }

        /**
         * Main Track Method
         */
        track(type, data) {
            const payload = {
                type: type,
                data: data,
                session_id: this.sessionId,
                user_id: this.userId,
                timestamp: new Date().toISOString(),
                user_agent: navigator.userAgent,
                screen_resolution: `${screen.width}x${screen.height}`,
                viewport_size: `${window.innerWidth}x${window.innerHeight}`
            };

            // Send to server
            this.send(payload);

            // Send to Google Analytics if available
            if (typeof gtag !== 'undefined') {
                this.sendToGoogleAnalytics(type, data);
            }
        }

        /**
         * Send Data to Server
         */
        send(payload) {
            // Use sendBeacon for reliability
            if (navigator.sendBeacon) {
                navigator.sendBeacon('/api/track', JSON.stringify(payload));
            } else {
                // Fallback to fetch
                fetch('/api/track', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload),
                    keepalive: true
                }).catch(error => {
                    console.error('Analytics tracking error:', error);
                });
            }
        }

        /**
         * Send to Google Analytics
         */
        sendToGoogleAnalytics(type, data) {
            if (type === 'page_view') {
                gtag('config', 'GA_MEASUREMENT_ID', {
                    page_path: data.page_url
                });
            } else if (type === 'event') {
                gtag('event', data.event_name, data.event_data);
            }
        }
    }

    // Initialize Analytics
    const analytics = new Analytics();

    // Track page view on load
    window.addEventListener('load', function() {
        analytics.trackPageView();
        analytics.trackPerformance();
    });

    // Track outbound links
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.hostname !== window.location.hostname) {
            analytics.trackEvent('outbound_click', {
                url: link.href,
                text: link.textContent.trim()
            });
        }
    });

    // Track errors
    window.addEventListener('error', function(e) {
        analytics.trackError(e.error || new Error(e.message), {
            filename: e.filename,
            lineno: e.lineno,
            colno: e.colno
        });
    });

    // Track before unload (session time)
    let startTime = Date.now();
    window.addEventListener('beforeunload', function() {
        const sessionTime = Math.floor((Date.now() - startTime) / 1000);
        analytics.track('session_end', {
            session_time: sessionTime
        });
    });

    // Make analytics globally available
    window.analytics = analytics;

})();