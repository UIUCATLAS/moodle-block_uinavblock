<?php
/*   _ _____   _   _            ______ _            _    
| | | |_   _| | \ | |           | ___ \ |          | |   
| | | | | |   |  \| | __ ___   _| |_/ / | ___   ___| | __
| | | | | |   | . ` |/ _` \ \ / / ___ \ |/ _ \ / __| |/ /
| |_| |_| |_  | |\  | (_| |\ V /| |_/ / | (_) | (__|   < 
 \___/ \___/  \_| \_/\__,_| \_/ \____/|_|\___/ \___|_|\_\	
 
 Moodle Block Database Permissions

*/

    $capabilities = array(
 
    'block/uinavblock:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),
 
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),
 
    'block/uinavblock:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
 
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
 
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
);
