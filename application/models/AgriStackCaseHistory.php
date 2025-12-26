<?php
class AgriStackCaseHistory extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function CreateLog($dist_code, $case_no)
    {
        $CI =& get_instance();
        $router = $CI->router;
        $controller = $router->fetch_class();
        $method = $router->fetch_method();

        // Now you can use $controller and $method as needed
        $data = [
            'dist_code' => $dist_code, // fill from context
            'case_no'   => $case_no,   // fill from context
            'date'      => date('Y-m-d H:i:s'),
            'json'      => json_encode(['type' => 'test']),
            'controller'=> $controller,
            'method'    => $method,
            'status'    => 'not_processed',
        ];
        $exists = $this->db
            ->where('case_no', $case_no)
            ->where('dist_code', $dist_code) // optional, if uniqueness is by both
            ->get('agri_stack_case_histry_log')
            ->num_rows();
        if ($exists == 0) {
            $this->db->insert('agri_stack_case_histry_log', $data);
        }
    }

    public function CreateLogFile($dist_code = null, $case_no = null)
    {
        $CI =& get_instance();
        $router = $CI->router;
        $controller = $router->fetch_class();
        $method = $router->fetch_method();

        $log_dir = APPPATH . 'logs/agri_stack/';
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true); // Create dir if not exists
        }

        $log_file = $log_dir . 'case_history.log';

        $log_message = sprintf(
            "[%s] DIST: %s | CASE NO: %s | CONTROLLER: %s | METHOD: %s\n",
            date('Y-m-d H:i:s'),
            $dist_code,
            $case_no,
            $controller,
            $method
        );

        file_put_contents($log_file, $log_message, FILE_APPEND);
    }


}