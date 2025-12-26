<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['password_policy'] = [
    'min_length'        => 8,
    'max_length'        => 20,
    'require_uppercase' => true,
    'require_lowercase' => true,
    'require_number'    => true,
    'require_special'   => true,
    'allowed_specials'  => '!@#$%^&*()_+=-{}[]<>?',
    'password_expiry_days' => 90,
    'password_history_limit' => 3, // prevent reuse of last 3
];

$config['username_policy'] = [
    'min_length'       => 5,
    'require_special'  => true,
    'allowed_specials' => '_-.@',  // define what’s allowed
];