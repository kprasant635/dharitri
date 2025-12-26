<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('validate_password_policy')) {
    function validate_password_policy($password, $config) {
        $errors = [];

        if (strlen($password) < $config['min_length']) {
            $errors[] = "Password must be at least {$config['min_length']} characters long.";
        }

        if (strlen($password) > $config['max_length']) {
            $errors[] = "Password cannot exceed {$config['max_length']} characters.";
        }

        if ($config['require_uppercase'] && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }

        if ($config['require_lowercase'] && !preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }

        if ($config['require_number'] && !preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number.";
        }

        if ($config['require_special'] && !preg_match('/[' . preg_quote($config['allowed_specials'], '/') . ']/', $password)) {
            $errors[] = "Password must contain at least one special character (" . $config['allowed_specials'] . ").";
        }

        return $errors;
    }
}

if (!function_exists('validate_username_policy')) {
    function validate_username_policy($username, $config) {
        $errors = [];

        if (strlen($username) < $config['min_length']) {
            $errors[] = "Username must be at least {$config['min_length']} characters long.";
        }

        if ($config['require_special'] && !preg_match('/[' . preg_quote($config['allowed_specials'], '/') . ']/', $username)) {
            $errors[] = "Username must contain at least one special character (" . $config['allowed_specials'] . ").";
        }

        return $errors;
    }
}