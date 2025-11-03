<?php
/**
 * Global Constants
 * Application-wide constant definitions
 */

// Prevent direct access
defined('APP_ACCESS') or die('Direct access not permitted');

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
*/
define('APP_VERSION', '1.0.0');
define('APP_BUILD', '20250101');

/*
|--------------------------------------------------------------------------
| Path Constants
|--------------------------------------------------------------------------
*/
define('CALCULATORS_PATH', BASE_PATH . '/calculators');
define('AUTH_PATH', BASE_PATH . '/auth');
define('ADMIN_PATH', BASE_PATH . '/admin');
define('API_PATH', BASE_PATH . '/api');
define('EMAILS_PATH', BASE_PATH . '/emails');
define('MIDDLEWARE_PATH', BASE_PATH . '/middleware');
define('DATABASE_PATH', BASE_PATH . '/database');
define('BACKUP_PATH', BASE_PATH . '/backup');
define('DOCS_PATH', BASE_PATH . '/docs');

/*
|--------------------------------------------------------------------------
| URL Constants
|--------------------------------------------------------------------------
*/
define('CALCULATORS_URL', BASE_URL . '/calculators');
define('AUTH_URL', BASE_URL . '/auth');
define('ADMIN_URL', BASE_URL . '/admin');
define('API_URL', BASE_URL . '/api');

/*
|--------------------------------------------------------------------------
| User Roles
|--------------------------------------------------------------------------
*/
define('ROLE_ADMIN', 1);
define('ROLE_MODERATOR', 2);
define('ROLE_USER', 3);
define('ROLE_GUEST', 4);

/*
|--------------------------------------------------------------------------
| Calculator Categories
|--------------------------------------------------------------------------
*/
define('CATEGORY_FINANCIAL', 'financial');
define('CATEGORY_HEALTH', 'health');
define('CATEGORY_MATH', 'math');
define('CATEGORY_CONVERSION', 'conversion');
define('CATEGORY_DATETIME', 'date-time');
define('CATEGORY_CONSTRUCTION', 'construction');
define('CATEGORY_ELECTRONICS', 'electronics');
define('CATEGORY_AUTOMOTIVE', 'automotive');
define('CATEGORY_EDUCATION', 'education');
define('CATEGORY_UTILITY', 'utility');
define('CATEGORY_WEATHER', 'weather');
define('CATEGORY_COOKING', 'cooking');
define('CATEGORY_GAMING', 'gaming');
define('CATEGORY_SPORTS', 'sports');

/*
|--------------------------------------------------------------------------
| Status Constants
|--------------------------------------------------------------------------
*/
define('STATUS_ACTIVE', 1);
define('STATUS_INACTIVE', 0);
define('STATUS_PENDING', 2);
define('STATUS_DELETED', 3);

/*
|--------------------------------------------------------------------------
| Calculator Status
|--------------------------------------------------------------------------
*/
define('CALC_STATUS_PUBLISHED', 1);
define('CALC_STATUS_DRAFT', 0);
define('CALC_STATUS_ARCHIVED', 2);

/*
|--------------------------------------------------------------------------
| HTTP Status Codes
|--------------------------------------------------------------------------
*/
define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_NO_CONTENT', 204);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('HTTP_METHOD_NOT_ALLOWED', 405);
define('HTTP_CONFLICT', 409);
define('HTTP_UNPROCESSABLE_ENTITY', 422);
define('HTTP_TOO_MANY_REQUESTS', 429);
define('HTTP_INTERNAL_SERVER_ERROR', 500);
define('HTTP_SERVICE_UNAVAILABLE', 503);

/*
|--------------------------------------------------------------------------
| Time Constants
|--------------------------------------------------------------------------
*/
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);
define('DAY_IN_SECONDS', 86400);
define('WEEK_IN_SECONDS', 604800);
define('MONTH_IN_SECONDS', 2592000);
define('YEAR_IN_SECONDS', 31536000);

/*
|--------------------------------------------------------------------------
| File Size Constants
|--------------------------------------------------------------------------
*/
define('KB_IN_BYTES', 1024);
define('MB_IN_BYTES', 1048576);
define('GB_IN_BYTES', 1073741824);

/*
|--------------------------------------------------------------------------
| Validation Constants
|--------------------------------------------------------------------------
*/
define('MIN_PASSWORD_LENGTH', 8);
define('MAX_PASSWORD_LENGTH', 128);
define('MIN_USERNAME_LENGTH', 3);
define('MAX_USERNAME_LENGTH', 50);
define('MAX_EMAIL_LENGTH', 255);

/*
|--------------------------------------------------------------------------
| Pagination Constants
|--------------------------------------------------------------------------
*/
define('DEFAULT_PAGE_SIZE', 20);
define('MAX_PAGE_SIZE', 100);

/*
|--------------------------------------------------------------------------
| Calculator Limits
|--------------------------------------------------------------------------
*/
define('MAX_CALCULATION_HISTORY', 50);
define('MAX_SAVED_CALCULATIONS', 100);
define('MAX_DECIMAL_PLACES', 10);

/*
|--------------------------------------------------------------------------
| Email Templates
|--------------------------------------------------------------------------
*/
define('EMAIL_WELCOME', 'welcome');
define('EMAIL_VERIFY', 'verify-email');
define('EMAIL_PASSWORD_RESET', 'password-reset');
define('EMAIL_PASSWORD_CHANGED', 'password-changed');
define('EMAIL_TWO_FACTOR', 'two-factor-code');
define('EMAIL_LOGIN_ALERT', 'login-alert');

/*
|--------------------------------------------------------------------------
| Cache Keys
|--------------------------------------------------------------------------
*/
define('CACHE_KEY_CALCULATORS', 'calculators_list');
define('CACHE_KEY_CATEGORIES', 'categories_list');
define('CACHE_KEY_POPULAR', 'popular_calculators');
define('CACHE_KEY_ANALYTICS', 'analytics_data');

/*
|--------------------------------------------------------------------------
| Session Keys
|--------------------------------------------------------------------------
*/
define('SESSION_USER_ID', 'user_id');
define('SESSION_USER_EMAIL', 'user_email');
define('SESSION_USER_ROLE', 'user_role');
define('SESSION_LAST_ACTIVITY', 'last_activity');
define('SESSION_FINGERPRINT', 'fingerprint');

/*
|--------------------------------------------------------------------------
| Error Messages
|--------------------------------------------------------------------------
*/
define('ERROR_GENERAL', 'An error occurred. Please try again.');
define('ERROR_DATABASE', 'Database error occurred.');
define('ERROR_VALIDATION', 'Validation failed.');
define('ERROR_UNAUTHORIZED', 'Unauthorized access.');
define('ERROR_NOT_FOUND', 'Resource not found.');
define('ERROR_RATE_LIMIT', 'Too many requests. Please try again later.');

/*
|--------------------------------------------------------------------------
| Success Messages
|--------------------------------------------------------------------------
*/
define('SUCCESS_GENERAL', 'Operation completed successfully.');
define('SUCCESS_SAVED', 'Data saved successfully.');
define('SUCCESS_UPDATED', 'Data updated successfully.');
define('SUCCESS_DELETED', 'Data deleted successfully.');

/*
|--------------------------------------------------------------------------
| Regular Expressions
|--------------------------------------------------------------------------
*/
define('REGEX_EMAIL', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
define('REGEX_PHONE', '/^[+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/');
define('REGEX_USERNAME', '/^[a-zA-Z0-9_-]{3,50}$/');
define('REGEX_PASSWORD', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/');

/*
|--------------------------------------------------------------------------
| API Constants
|--------------------------------------------------------------------------
*/
define('API_VERSION', 'v1');
define('API_TIMEOUT', 30);
define('API_MAX_RETRIES', 3);

/*
|--------------------------------------------------------------------------
| Ad Positions
|--------------------------------------------------------------------------
*/
define('AD_SIDEBAR_TOP', 'sidebar_top');
define('AD_SIDEBAR_BOTTOM', 'sidebar_bottom');
define('AD_HORIZONTAL_TOP', 'horizontal_top');
define('AD_HORIZONTAL_BOTTOM', 'horizontal_bottom');
define('AD_IN_CONTENT', 'in_content');
define('AD_MOBILE_ANCHOR', 'mobile_anchor');