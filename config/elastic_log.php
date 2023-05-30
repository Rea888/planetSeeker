<?php
return [
    'host' => env('ELASTIC_HOST'),
    'index' => 'laravel_log',
    'suffix' => 'laravel_log_suffix',
    'type' => '_doc',
];
