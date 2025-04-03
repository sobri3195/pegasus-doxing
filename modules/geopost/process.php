<?php
/**
 * Geopost Module - Process File
 * Detects geographic locations from social media posts and content
 */

function run_geopost($input) {
    $results = [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'locations' => [],
        'sources' => [],
        'metadata' => []
    ];
    
    // Search social media platforms
    $platforms = [
        'Twitter' => [
            'search_url' => 'https://twitter.com/search?q=' . urlencode($input),
            'api_url' => 'https://api.twitter.com/2/tweets/search/recent?query=',
            'requires_auth' => true
        ],
        'Instagram' => [
            'search_url' => 'https://www.instagram.com/explore/tags/' . urlencode($input),
            'api_url' => 'https://www.instagram.com/api/v1/tags/',
            'requires_auth' => true
        ]
    ];
    
    foreach ($platforms as $platform => $config) {
        $results['sources'][] = [
            'platform' => $platform,
            'search_url' => $config['search_url'],
            'status' => 'searched',
            'posts_found' => 0
        ];
        
        // Simulate API call to get posts
        $posts = fetch_posts($platform, $input, $config);
        if ($posts) {
            foreach ($posts as $post) {
                $location = extract_location_from_post($post, $platform);
                if ($location) {
                    $results['locations'][] = $location;
                }
            }
        }
    }
    
    // Analyze collected locations
    if (!empty($results['locations'])) {
        $results['metadata'] = analyze_locations($results['locations']);
    }
    
    return $results;
}

function fetch_posts($platform, $query, $config) {
    $ch = curl_init();
    $url = $config['api_url'] . urlencode($query);
    
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
    
    if ($http_code === 200) {
        return json_decode($response, true);
    }
    
    return null;
}

function extract_location_from_post($post, $platform) {
    $location = null;
    
    switch ($platform) {
        case 'Twitter':
            if (isset($post['geo'])) {
                $location = [
                    'type' => 'coordinates',
                    'source' => 'Twitter Geo',
                    'coordinates' => [
                        'latitude' => $post['geo']['coordinates'][0],
                        'longitude' => $post['geo']['coordinates'][1]
                    ],
                    'confidence' => 'high',
                    'context' => 'Direct geotag'
                ];
            } elseif (isset($post['place'])) {
                $location = [
                    'type' => 'place',
                    'source' => 'Twitter Place',
                    'place' => $post['place']['full_name'],
                    'confidence' => 'medium',
                    'context' => 'Place tag'
                ];
            }
            break;
            
        case 'Instagram':
            if (isset($post['location'])) {
                $location = [
                    'type' => 'place',
                    'source' => 'Instagram Location',
                    'place' => $post['location']['name'],
                    'coordinates' => [
                        'latitude' => $post['location']['lat'],
                        'longitude' => $post['location']['lng']
                    ],
                    'confidence' => 'high',
                    'context' => 'Location tag'
                ];
            }
            break;
    }
    
    return $location;
}

function analyze_locations($locations) {
    $analysis = [
        'total_locations' => count($locations),
        'location_types' => [],
        'most_common_places' => [],
        'geographic_center' => null,
        'location_clusters' => []
    ];
    
    // Count location types
    $type_counts = [];
    $place_counts = [];
    $coordinates = [];
    
    foreach ($locations as $location) {
        // Count types
        $type = $location['type'];
        $type_counts[$type] = ($type_counts[$type] ?? 0) + 1;
        
        // Count places
        if ($location['type'] === 'place') {
            $place = $location['place'];
            $place_counts[$place] = ($place_counts[$place] ?? 0) + 1;
        }
        
        // Collect coordinates
        if (isset($location['coordinates'])) {
            $coordinates[] = $location['coordinates'];
        }
    }
    
    $analysis['location_types'] = $type_counts;
    
    // Find most common places
    arsort($place_counts);
    $analysis['most_common_places'] = array_slice($place_counts, 0, 5, true);
    
    // Calculate geographic center if coordinates available
    if (!empty($coordinates)) {
        $lat_sum = 0;
        $lon_sum = 0;
        $count = count($coordinates);
        
        foreach ($coordinates as $coord) {
            $lat_sum += $coord['latitude'];
            $lon_sum += $coord['longitude'];
        }
        
        $analysis['geographic_center'] = [
            'latitude' => $lat_sum / $count,
            'longitude' => $lon_sum / $count
        ];
    }
    
    return $analysis;
} 