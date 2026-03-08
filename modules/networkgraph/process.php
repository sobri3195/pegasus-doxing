<?php

function run_networkgraph($input) {
    return [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'nodes' => [
            ['id' => 'target', 'label' => $input, 'type' => 'entity'],
            ['id' => 'email', 'label' => 'Potential email account', 'type' => 'account'],
            ['id' => 'social', 'label' => 'Potential social profile', 'type' => 'account']
        ],
        'edges' => [
            ['from' => 'target', 'to' => 'email', 'relation' => 'possible_match'],
            ['from' => 'target', 'to' => 'social', 'relation' => 'possible_match']
        ]
    ];
}
