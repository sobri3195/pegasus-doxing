<?php

function run_domainintel($input) {
    $domain = filter_var($input, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) ? strtolower($input) : null;

    return [
        'input' => $input,
        'timestamp' => date('Y-m-d H:i:s'),
        'domain_detected' => $domain,
        'whois_summary' => [
            'registrar' => $domain ? 'Unknown' : 'N/A',
            'creation_date' => $domain ? 'Unavailable (offline mode)' : 'N/A'
        ],
        'infrastructure_hints' => [
            'mx_check' => $domain ? 'pending' : 'skipped',
            'dnssec' => 'unknown'
        ]
    ];
}
