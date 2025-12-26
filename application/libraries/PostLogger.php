<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostLogger {

    private $db_log;
    private $table;
    private $log_dir;

    public function __construct() {
        $CI =& get_instance();
        if (!IS_ACTIVITY_LOG) return;
        if (ARCHIVE_LOG_DRIVER=='DB'){
            $this->db_log = $CI->load->database(ARCHIVE_DB, TRUE); // Use 'log_db' group from database.php
            $this->table = ACTIVITY_LOG_TABLE . date('Y');
            $this->_ensure_table();
        }
        else
        {
            $this->log_dir = rtrim(ACTIVITY_LOG_DIR, '/') . '/';
            if (!file_exists($this->log_dir)) {
                mkdir($this->log_dir, 0777, true);
            }
        }
    }

    /**
     * Log the request to the appropriate table
     */
    public function log_request($user_id, $uri, $post_data, $headers, $user_agent, $ip, $compressed_session) {
        if (!IS_ACTIVITY_LOG) return;

        if (in_array($user_id, BY_PASS_USERS)) return;
        if (ARCHIVE_LOG_DRIVER=='DB')
        {
            $this->_ensure_table(); // Ensures table exists again in case of year rollover

            $data = [
                'user_id'            => $user_id,
                'uri'                => $uri,
                'method'             => 'POST',
                'ip_address'         => $ip,
                'post_data'          => json_encode($post_data, JSON_UNESCAPED_UNICODE),
                'headers'            => $headers!=null ? pg_escape_bytea($headers) : null,
                'user_agent'         => $user_agent,
                'timestamp'          => date('Y-m-d H:i:s'),
                'compressed_session' => pg_escape_bytea($compressed_session),
            ];

            $this->db_log->insert($this->table, $data);
        }
        else
        {
            $file = $this->log_dir . 'activity_' . date('Y-m-d') . '.log';
            $entry = [
                '__t' => date('Y-m-d H:i:s'),
                '__u' => $user_id,
                '__m' => 'POST',
                '__ur'=> $uri,
                '__i' => $ip,
                '__h' => $headers,
                '__p' => $post_data,
                '__a' => $user_agent,
                '__s' => $compressed_session
            ];
            file_put_contents($file, json_encode($entry, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);
        }
    }

    /**
     * Ensure the yearly request log table exists
     */
    private function _ensure_table() {
        if ($this->db_log->table_exists($this->table)) return;
        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                id SERIAL PRIMARY KEY,
                user_id VARCHAR(50),
                uri TEXT,
                method VARCHAR(10),
                ip_address VARCHAR(45),
                post_data JSONB,
                headers BYTEA,
                user_agent TEXT,
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                compressed_session BYTEA
            );
        ";
        $this->db_log->query($sql);
        $this->db_log->query("CREATE INDEX IF NOT EXISTS idx_{$this->table}_user_id ON {$this->table}(user_id)");
        $this->db_log->query("CREATE INDEX IF NOT EXISTS idx_{$this->table}_timestamp ON {$this->table}(timestamp)");
        $this->db_log->query("CREATE INDEX IF NOT EXISTS idx_{$this->table}_uri ON {$this->table}(uri)");
    }
    public function read_logs($date = null, $start_line = 0, $end_line = null)
    {
        if (ARCHIVE_LOG_DRIVER=='DB')
            return [];

        $file = $this->log_dir . 'activity_' . ($date ?? date('Y-m-d')) . '.log';
        if (!file_exists($file)) return [];

        $handle = fopen($file, 'r');
        if (!$handle) return [];

        $logs = [];
        $line_no = 0;

        while (($line = fgets($handle)) !== false) {
            if ($line_no < $start_line) {
                $line_no++;
                continue;
            }

            if ($end_line !== null && $line_no > $end_line) {
                break;
            }

            $entry = json_decode(trim($line), true);
            if (!$entry) {
                $line_no++;
                continue;
            }
            if ($entry['__h']!=null)
            {
                $decoded = base64_decode($entry['__h'] ?? '');
                $decompressed = @gzuncompress($decoded);
                $entry['__h'] = $decompressed ? json_decode($decompressed, true) : '[UNREADABLE]';
            }
            if ($entry['__s']!=null){
                $decoded = base64_decode($entry['__s'] ?? '');
                $decompressed = @gzuncompress($decoded);
                $entry['__s'] = $decompressed ? json_decode($decompressed, true) : '[UNREADABLE]';
            }
            $logs[] = $entry;
            $line_no++;
        }

        fclose($handle);
        return $logs;
    }
}
