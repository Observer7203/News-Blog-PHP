<?php

return [
    'name' => 'Simple Blog',
    'url' => getenv('APP_URL') ?: 'http://localhost:8080',
    'debug' => (bool)(getenv('APP_DEBUG') ?: true),
    'per_page' => 9,
];
