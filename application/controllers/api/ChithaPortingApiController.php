<?php

class ChithaPortingApiController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insertNcVillageData()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $from_application = $this->input->post('from_application');
        $to_application = $this->input->post('to_application');
        $user_id = $this->input->post('user_id');
        $this->dbswitch($dist_code);
        $is_loc_exists = $this->db->get_where('location', [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code
        ])->num_rows();
        if ($is_loc_exists == 0) {
            echo json_encode(['msgs' => '<p style="color:red">Village does not exists.</p>', 'st' => 'failed']);
            die;
        }
        $tables = json_decode($this->input->post('data'));

        $msgs = [];
        if (count($tables) > 0) {
            $this->db->trans_begin();
            $this->dbswitch($dist_code);
            foreach ($tables as $table) {
                $table_details = $this->getTableDetails($table->table_name);
                if ($table_details) {
                    $table_name = $table->table_name;
                    $primary_cols = $table_details['primary_cols'];
                    $data = $table->data;
                    $inserted = 0;
                    $exists = 0;
                    $msgs[] = ['st' => 'info', 'msg' => 'Dhar Porting started on - ' . $table_name];

                    foreach ($data as $data_row) {

                        $data_arr = (array)$data_row;
                        $where = [];

                        foreach ($primary_cols as $pkey_col) {
                            $where[$pkey_col] = $data_arr[$pkey_col];
                        }
                        $is_exists = $this->db->get_where($table_name, $where)->num_rows();

                        if ($is_exists == 0) {
                            $this->db->insert($table_name, $data_arr);
                            $inserted = $inserted + 1;
                        } else {
                            // $msg = 'Data exists for table - ' . $table_name . '. ';
                            // foreach ($primary_cols as $pkey_col) {
                            //     $where[$pkey_col] = $data_arr[$pkey_col];
                            //     $msg = $msg . $pkey_col . ' - ' . $data_arr[$pkey_col] . ' , ';
                            // }
                            // $msg = ['st' => 'warning', 'msg' => $msg];
                            // $msgs[] = $msg;
                            $exists = $exists + 1;
                        }
                    }
                    if ($inserted > 0) {
                        $msgs[] = ['st' => 'success', 'msg' => 'Inserted - ' . $table_name . '-' . $inserted];
                    } else {
                        $msgs[] = ['st' => 'warning', 'msg' => 'Inserted - ' . $table_name . '-' . $inserted];
                    }
                    if ($exists > 0) {
                        $msgs[] = ['st' => 'error', 'msg' => 'Duplicate - ' . $table_name . '-' . $exists];
                    }
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['msgs' => '<p style="color:red;">Server Error Occured. Rolled Back.</p>', 'st' => 'failed']);
                die;
            } else {
                $this->db->trans_commit();
                $msgs[] = ['st' => 'success', 'msg' => 'Ported Successfully'];
                $messages  = '';
                foreach($msgs as $msg){
                    $messages = $messages.'<p>'.$msg['msg'].'</p>';
                }
                echo json_encode(['msgs' => $messages, 'st' => 'success']);
                die;
            }
        } else {
            echo json_encode(['msgs' => '<p style="color:red;">Server Error Occured. Rolled Back.</p>', 'st' => 'failed']);
            die;
        }
    }
    public function getTableDetails($name)
    {
        $table_details = null;
        foreach (ALLOWED_PORTING_TABLES as $table_port) {
            if ($table_port['table'] == $name) {
                $table_details = $table_port;
            }
        }
        return $table_details;
    }

    public function dbswitch($dist_code)
    {
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        } else if ($dist_code == "auth") {
            $this->db = $this->load->database('auth', TRUE);
        } else if ($dist_code == "22") {
            $this->db = $this->load->database('dha41', TRUE);
        }
        return $this->db;
    }
}

