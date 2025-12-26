<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get 32-byte AES key from ENV or constant ENC_QUERY_KEY_HEX.
 * Generate one: php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
 */
if (!function_exists('enc_key')) {
    function enc_key(): string {
        static $k = null;
        if ($k !== null) return $k;

        $hex = getenv('ENC_QUERY_KEY_HEX') ?: (defined('ENC_QUERY_KEY_HEX') ? ENC_QUERY_KEY_HEX : '');
        if (!$hex || !preg_match('/^[0-9a-fA-F]{64}$/', $hex)) {
            throw new RuntimeException('ENC_QUERY_KEY_HEX missing or invalid (need 64 hex chars).');
        }
        return $k = hex2bin($hex);
    }
}

/**
 * Encrypt one parameter with name/value, bind to current session user_code, and set expiry.
 */
if (!function_exists('enc_param')) {
    function enc_param(string $name, string $value, int $ttl = 300): string {
        $CI =& get_instance();
        $uid = $CI->session->userdata('user_code'); // adjust if your session key differs

        $payload = [
            'param' => $name,
            'val'   => $value,
            'uid'   => $uid,
            'exp'   => time() + $ttl
        ];

        $json = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $iv   = random_bytes(12); $tag = '';
        $ct   = openssl_encrypt($json, 'aes-256-gcm', enc_key(), OPENSSL_RAW_DATA, $iv, $tag);

        // return base64url token
        return rtrim(strtr(base64_encode($iv.$tag.$ct), '+/', '-_'), '=');
    }
}

/**
 * Decrypt a token, validate name/user/expiry, return original value or null.
 */
if (!function_exists('dec_param')) {
    function dec_param(?string $token, string $expected_name): ?string {
        if (!$token || !preg_match('~^[A-Za-z0-9\-_]+$~', $token)) return null;

        $raw = base64_decode(strtr($token, '-_', '+/'), true);
        if ($raw === false || strlen($raw) < 28) return null;

        $iv = substr($raw, 0, 12);
        $tag = substr($raw, 12, 16);
        $ct = substr($raw, 28);

        $json = openssl_decrypt($ct, 'aes-256-gcm', enc_key(), OPENSSL_RAW_DATA, $iv, $tag);
        if ($json === false) return null;

        $p = json_decode($json, true);
        if (!is_array($p)) return null;

        $CI =& get_instance();
        $uid = $CI->session->userdata('user_code');

        if ($p['param'] !== $expected_name) return null;
        if ($p['uid']   !== $uid) return null;
        if ($p['exp']   < time()) return null;

        return (string) $p['val'];
    }
}