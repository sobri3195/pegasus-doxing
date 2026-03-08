<?php

function get_available_modules() {
    return [
        'doxid' => [
            'label' => 'Doxid',
            'description' => 'Identity and relationship search based on name'
        ],
        'webbio' => [
            'label' => 'Webbio',
            'description' => 'Public web biography search'
        ],
        'usernamedna' => [
            'label' => 'UsernameDNA',
            'description' => 'Username pattern tracking across platforms'
        ],
        'geopost' => [
            'label' => 'Geopost',
            'description' => 'Geographic location detection from posts'
        ],
        'whatsapp_check' => [
            'label' => 'WhatsApp Check',
            'description' => 'WhatsApp number verification'
        ],
        'timepattern' => [
            'label' => 'TimePattern',
            'description' => 'Online activity time pattern analysis'
        ],
        'emailcross' => [
            'label' => 'EmailCross',
            'description' => 'Cross-platform email footprint search'
        ],
        'exifscan' => [
            'label' => 'ExifScan',
            'description' => 'EXIF data extraction from images'
        ],
        'socialsigs' => [
            'label' => 'SocialSigs',
            'description' => 'Social media signal mapping'
        ],
        'redirectchain' => [
            'label' => 'RedirectChain',
            'description' => 'Link redirect chain tracking'
        ],
        'breachradar' => [
            'label' => 'BreachRadar',
            'description' => 'Exposure and breach footprint triage'
        ],
        'domainintel' => [
            'label' => 'DomainIntel',
            'description' => 'Domain ownership and infrastructure profiling'
        ],
        'darkmention' => [
            'label' => 'DarkMention',
            'description' => 'Dark-web mention risk indicators'
        ],
        'phonecarrier' => [
            'label' => 'PhoneCarrier',
            'description' => 'Carrier and line type profiling'
        ],
        'keywordpulse' => [
            'label' => 'KeywordPulse',
            'description' => 'Keyword trend and context pulse'
        ],
        'networkgraph' => [
            'label' => 'NetworkGraph',
            'description' => 'Entity relation graph seed builder'
        ],
        'reputationscore' => [
            'label' => 'ReputationScore',
            'description' => 'Behavioral and trust scoring model'
        ],
        'docsnapshot' => [
            'label' => 'DocSnapshot',
            'description' => 'Public document trace and metadata snapshot'
        ],
        'eventtrace' => [
            'label' => 'EventTrace',
            'description' => 'Event and timeline correlation'
        ],
        'profilematcher' => [
            'label' => 'ProfileMatcher',
            'description' => 'Cross-profile similarity matching'
        ]
    ];
}

function render_module_checkboxes($selected_modules = []) {
    $modules = get_available_modules();
    $chunks = array_chunk($modules, 3, true);

    foreach ($chunks as $group) {
        echo '<div class="row mt-2">';
        foreach ($group as $key => $module) {
            $is_checked = in_array($key, $selected_modules, true) ? 'checked' : '';
            echo '<div class="col-md-4">';
            echo '<div class="form-check module-check">';
            echo '<input class="form-check-input" type="checkbox" name="modules[]" value="' . htmlspecialchars($key) . '" id="' . htmlspecialchars($key) . '" ' . $is_checked . '>';
            echo '<label class="form-check-label" for="' . htmlspecialchars($key) . '">';
            echo htmlspecialchars($module['label']);
            echo '<small class="d-block text-muted">' . htmlspecialchars($module['description']) . '</small>';
            echo '</label>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}
