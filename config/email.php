<?php

// SMTP configs
return [
    'host' => getenv('SMTP_HOST'),
    'port' => getenv('SMTP_PORT'),
    'username' => getenv('SMTP_USERNAME'),
    'password' => getenv('SMTP_PASSWORD')
];