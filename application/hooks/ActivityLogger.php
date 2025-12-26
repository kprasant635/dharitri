<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityLogger {
    public function log_post_request() {
        $CI = &get_instance();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        If(!IS_ACTIVITY_LOG) return;

        $uri = uri_string();
        if (defined('EXCLUDED_LOG_URIS') && in_array($uri, EXCLUDED_LOG_URIS)) return;

        // Capture POST (excluding sensitive fields)
        $post_data = $_POST;
        foreach (EXCLUDED_LOG_FIELDS as $field) {
            if (isset($post_data[$field])) {
                $post_data[$field] = '[FILTERED]';
            }
        }

        // Capture session (filtered + compressed)
        $session_data = $CI->session->all_userdata();
        unset($session_data['__ci_last_regenerate']);
        foreach (EXCLUDED_LOG_FIELDS as $field) {
            if (isset($session_data[$field])) {
                $session_data[$field] = '[FILTERED]';
            }
        }
        $compressed_session = base64_encode(gzcompress(json_encode($session_data), 9));

        // Capture headers except token-related
        $headers = (IS_HEADER_LOG) ? $this->get_filtered_headers() : null;

        $headers = (IS_HEADER_LOG) ? base64_encode(gzcompress(json_encode($headers), 9)) : null;

        // Load logger and write
        $CI->load->library('PostLogger');
        $CI->postlogger->log_request(
            $CI->session->userdata(SESSION_USER_CODE) ?? 'guest', current_url(),
            $post_data,
            $headers,
            $CI->input->user_agent(),
            $CI->input->ip_address(),
            $compressed_session
        );
    }

    private function get_filtered_headers() {
        $filtered = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = strtolower(str_replace('_', '-', substr($key, 5)));
                if (!in_array($header, ['authorization', 'x-auth-token', 'token','user-agent'])) {
                    $filtered[$header] = $value;
                }
            }
        }
        return $filtered;
    }
}
