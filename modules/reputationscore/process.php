<?php

function run_reputationscore($input) {
    $base = strlen($input) % 100;

    return [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'score' => $base,
        'grade' => $base >= 70 ? 'A' : ($base >= 40 ? 'B' : 'C'),
        'factors' => [
            'consistency' => min(100, $base + 10),
            'exposure' => max(0, 100 - $base),
            'confidence' => 55
        ]
    ];
}
