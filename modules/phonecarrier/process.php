<?php

function run_phonecarrier($input) {
    $phone = preg_replace('/[^0-9]/', '', $input);
    $is_valid = strlen($phone) >= 10;

    return [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'normalized_phone' => $phone,
        'is_valid_length' => $is_valid,
        'line_profile' => [
            'country_code_guess' => $is_valid ? substr($phone, 0, 2) : null,
            'line_type' => $is_valid ? 'unknown' : 'invalid',
            'carrier' => 'unknown'
        ]
    ];
}
