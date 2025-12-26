<?php
class ValidationLib {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function checkAccess() {
        $CI =& get_instance();
        $map = [
            'dist_code'          => ['dist_code', 'district_code', 'district'],
            'subdiv_code'        => ['subdiv_code', 'subdivision_code', 'subdivision'],
            'cir_code'           => ['cir_code', 'circle_code', 'circle'],
            'mouza_pargona_code' => ['mouza_pargona_code', 'mouza_code', 'pargona_code'],
            'lot_no'             => ['lot_no', 'lotnumber', 'lot'],
            'case_no'            => ['case_no', 'ord_no', 'order_no', 'order'],
        ];
        $result = [];
        foreach ($map as $standard => $aliases) {
            foreach ($aliases as $alias) {
                $value = $CI->input->get_post($alias);
                if (!empty($value)) {
                    $result[$standard] = $value;
                    break;
                }
            }
        }
        $dist_code          = $result['dist_code'] ?? null;
        $subdiv_code        = $result['subdiv_code'] ?? null;
        $cir_code           = $result['cir_code'] ?? null;
        $mouza_pargona_code = $result['mouza_pargona_code'] ?? null;
        $lot_no             = $result['lot_no'] ?? null;
        $case_no            = $result['case_no'] ?? null;

        

        
        if($case_no){
            $table = [
                        't_legacyupdation',
                        'settlement_basic'
                    ];
            foreach ($table as $t) {
                $query = $this->CI->db->select('dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no')
                                ->from($t)
                                ->where('case_no',$case_no)
                                ->get();
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $dist_code          = $row->dist_code;
                    $subdiv_code        = $row->subdiv_code;
                    $cir_code           = $row->cir_code;
                    $mouza_pargona_code = $row->mouza_pargona_code;
                    $lot_no             = $row->lot_no;
                    break;
                }
            }
        }
        $user_code = $CI->session->userdata('user_desig_code');
        $session_dist_code          = $CI->session->userdata('dist_code');
        $session_subdiv_code        = $CI->session->userdata('subdiv_code');
        $session_cir_code           = $CI->session->userdata('cir_code');
        $session_mouza_pargona_code = $CI->session->userdata('mouza_pargona_code');
        $session_lot_no             = $CI->session->userdata('lot_no');
        // var_dump($dist_code, 
        // $subdiv_code, 
        // $cir_code, 
        // $mouza_pargona_code, 
        // $lot_no);
        // var_dump($session_dist_code, 
        // $session_subdiv_code, 
        // $session_cir_code, 
        // $session_mouza_pargona_code, 
        // $session_lot_no);
        if (in_array($user_code, ['DC','ADC'])) {
            if ($dist_code != false) {
                if ($dist_code != $session_dist_code) {
                    $this->CI->output->set_status_header(403);
                        $html = $this->CI->load->view('ErrorPage/forbidden', [], true);
                        echo $html;
                        exit;
                }
            }
        } elseif (in_array($user_code, ['CO','SK','AST'])) {
            if ($dist_code != false && $subdiv_code != false && $cir_code != false) {
                // dd("ok");
                if ($dist_code != $session_dist_code ||
                    $subdiv_code != $session_subdiv_code ||
                    $cir_code != $session_cir_code) {
                    $this->CI->output->set_status_header(403);
                    $html = $this->CI->load->view('ErrorPage/forbidden', [], true);
                    echo $html;
                    exit;
                }
            }
        } elseif ($user_code === 'LM') {
            if ($dist_code != false && $subdiv_code != false && $cir_code != false && $mouza_pargona_code != false && $lot_no != false) {
                if ($dist_code != $session_dist_code ||
                    $subdiv_code != $session_subdiv_code ||
                    $cir_code != $session_cir_code ||
                    $mouza_pargona_code != $session_mouza_pargona_code ||
                    $lot_no != $session_lot_no) {
                    $this->CI->output->set_status_header(403);
                    $html = $this->CI->load->view('ErrorPage/forbidden', [], true);
                    echo $html;
                    exit;
                }
            }
        }
    }
}
