<?php
// File: mod/livequiz/db/services.php

$functions = [
    'mod_livequiz_append_participation' => [
        'classname'   => 'mod_livequiz\external\append_participation',
        'methodname'  => 'execute',
        'description' => 'Record user participation in a live quiz.',
        'type'        => 'write',
        'ajax'        => true,
        'capabilities'=> 'mod/livequiz:participate',
    ],
];

$services = [];