<?php
/**
 * UsernameDNA Module - Process File
 * Tracks username patterns and similarities across platforms
 */

function run_usernamedna($input) {
    $results = [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'platforms' => [],
        'pattern_analysis' => []
    ];
    
    // Common social media platforms to check
    $platforms = [
        'Twitter' => [
            'base_url' => 'https://twitter.com/',
            'api_url' => 'https://api.twitter.com/2/users/by/username/',
            'requires_auth' => true
        ],
        'Instagram' => [
            'base_url' => 'https://instagram.com/',
            'api_url' => 'https://www.instagram.com/api/v1/users/web_profile_info/?username=',
            'requires_auth' => true
        ],
        'GitHub' => [
            'base_url' => 'https://github.com/',
            'api_url' => 'https://api.github.com/users/',
            'requires_auth' => false
        ],
        'Reddit' => [
            'base_url' => 'https://reddit.com/user/',
            'api_url' => 'https://www.reddit.com/user/',
            'requires_auth' => false
        ],
        'LinkedIn' => [
            'base_url' => 'https://linkedin.com/in/',
            'api_url' => 'https://www.linkedin.com/voyager/api/identity/profiles/',
            'requires_auth' => true
        ]
    ];
    
    // Check username availability/usage on each platform
    foreach ($platforms as $platform => $config) {
        $url = $config['base_url'] . urlencode($input);
        $status = check_username_availability($url, $config);
        
        $results['platforms'][] = [
            'platform' => $platform,
            'url' => $url,
            'status' => $status,
            'exists' => $status === 'exists',
            'last_checked' => date('Y-m-d H:i:s')
        ];
    }
    
    // Analyze username patterns
    $results['pattern_analysis'] = analyze_username_patterns($input);
    
    return $results;
}

function check_username_availability($url, $config) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    
    if ($config['requires_auth']) {
        // Add authentication headers if needed
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer YOUR_TOKEN']);
    }
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Analyze response to determine if username exists
    if ($http_code === 200) {
        return 'exists';
    } elseif ($http_code === 404) {
        return 'available';
    } else {
        return 'unknown';
    }
}

function analyze_username_patterns($username) {
    $analysis = [
        'username' => $username,
        'length' => strlen($username),
        'contains_numbers' => preg_match('/[0-9]/', $username),
        'contains_special_chars' => preg_match('/[^a-zA-Z0-9]/', $username),
        'common_patterns' => [],
        'similar_usernames' => [],
        'security_analysis' => []
    ];
    
    // Check for common patterns
    if (preg_match('/^[a-z]+[0-9]+$/', $username)) {
        $analysis['common_patterns'][] = 'letters_followed_by_numbers';
    }
    if (preg_match('/^[0-9]+[a-z]+$/', $username)) {
        $analysis['common_patterns'][] = 'numbers_followed_by_letters';
    }
    if (preg_match('/^[a-z]+[0-9]+[a-z]+$/', $username)) {
        $analysis['common_patterns'][] = 'letters_numbers_letters';
    }
    
    // Generate similar username variations
    $variations = generate_username_variations($username);
    $analysis['similar_usernames'] = $variations;
    
    // Security analysis
    $analysis['security_analysis'] = [
        'is_common_pattern' => count($analysis['common_patterns']) > 0,
        'is_predictable' => is_username_predictable($username),
        'strength_score' => calculate_username_strength($username)
    ];
    
    return $analysis;
}

function generate_username_variations($username) {
    $variations = [];
    
    // Add/remove numbers
    if (preg_match('/[0-9]/', $username)) {
        $variations[] = preg_replace('/[0-9]/', '', $username);
    } else {
        for ($i = 0; $i <= 9; $i++) {
            $variations[] = $username . $i;
            $variations[] = $i . $username;
        }
    }
    
    // Add common suffixes/prefixes
    $common_suffixes = ['123', '456', '789', 'xyz', 'abc'];
    foreach ($common_suffixes as $suffix) {
        $variations[] = $username . $suffix;
    }
    
    return array_unique($variations);
}

function is_username_predictable($username) {
    // Check if username follows common patterns
    $common_patterns = [
        '/^[a-z]+[0-9]+$/',  // letters followed by numbers
        '/^[0-9]+[a-z]+$/',  // numbers followed by letters
        '/^[a-z]+[0-9]+[a-z]+$/',  // letters, numbers, letters
        '/^[a-z]+$/',  // all letters
        '/^[0-9]+$/'   // all numbers
    ];
    
    foreach ($common_patterns as $pattern) {
        if (preg_match($pattern, $username)) {
            return true;
        }
    }
    
    return false;
}

function calculate_username_strength($username) {
    $score = 0;
    
    // Length score
    $length = strlen($username);
    if ($length >= 12) $score += 3;
    elseif ($length >= 8) $score += 2;
    elseif ($length >= 6) $score += 1;
    
    // Character variety score
    if (preg_match('/[A-Z]/', $username)) $score += 1;
    if (preg_match('/[a-z]/', $username)) $score += 1;
    if (preg_match('/[0-9]/', $username)) $score += 1;
    if (preg_match('/[^a-zA-Z0-9]/', $username)) $score += 2;
    
    // Pattern score
    if (!is_username_predictable($username)) $score += 2;
    
    return $score;
} 