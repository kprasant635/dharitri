<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class JamaEditEntry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('AgriStackCaseHistory');
        $this->dbswitch();
    }
     public function dbswitch(){       
         //$CI=&get_instance();
         if($this->session->userdata('dist_code') == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
         } else if($this->session->userdata('dist_code') == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
          } else if($this->session->userdata('dist_code') == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
         } else if($this->session->userdata('dist_code') == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
         }  else if($this->session->userdata('dist_code') == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
         }  else if($this->session->userdata('dist_code') == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
         }  else if($this->session->userdata('dist_code') == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
         }  else if($this->session->userdata('dist_code') == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
         }  else if($this->session->userdata('dist_code') == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
         }  else if($this->session->userdata('dist_code') == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
         }  else if($this->session->userdata('dist_code') == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
         }  else if($this->session->userdata('dist_code') == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
         }  else if($this->session->userdata('dist_code') == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($this->session->userdata('dist_code') == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
         }  else if($this->session->userdata('dist_code') == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
         }  else if($this->session->userdata('dist_code') == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
         }  else if($this->session->userdata('dist_code') == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
         }  else if($this->session->userdata('dist_code') == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
         }  else if($this->session->userdata('dist_code') == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
         }  else if($this->session->userdata('dist_code') == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
         }  else if($this->session->userdata('dist_code') == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
         }  else if($this->session->userdata('dist_code') == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
         }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
         }                                                                                                                                                                                                            
}

    public function index() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $location = array(
                'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no, 'vill_code' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            redirect(base_url() . "index.php/JamaEditEntry/pattalist");
        } else {
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $villages = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['m'] = $mouza_code;
            $district['l'] = $lot_no;
            $district['village'] = $villages;

            $patta_types = $this->db->query("select type_code,patta_type from    patta_code where jamabandi='y'")->result();
            $district['patta_types'] = $patta_types;
            // $this->load->view('../views/JamaEditEntry/index', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'JamaEditEntry/index';
            $this->load->view('layouts/main',$district);
        }
    }

    public function pattalist() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data['d'] = $dist_code;
            $data['s'] = $subdiv_code;
            $data['c'] = $cir_code;
            $data['m'] = $mouza_pargona_code;
            $data['l'] = $lot_no;
            $data['v'] = $vill_townprt_code;
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code where jamabandi='y'")->result();
            $data['patta_types'] = $patta_types;
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/pattalist', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pattalist';
            $this->load->view('layouts/main',$data);
        } else {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $location = array(
                'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no, 'vill_code' => $vill_townprtcode
            );
            $this->session->set_userdata($location);
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type = $this->input->post('patta_type_code');
            $this->session->set_userdata(array('patta_no' => $patta_no, 'patta_type_code' => $patta_type));
            redirect(base_url() . "index.php/JamaEditEntry/displayBasic/$patta_no/$patta_type");
        }
    }

    public function displayBasic($patta_no = "", $patta_type_code = "") {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $district_code = $this->session->userdata('dist_code');
            $subdivision_code = $this->session->userdata('subdiv_code');
            $circlecode = $this->session->userdata('cir_code');
            $mouzacode = $this->session->userdata('mouza_pargona_code');
            $lot_code = $this->session->userdata('lot_no');
            $village_code = $this->session->userdata('vill_code');
            $dist_name = $this->utilityclass->getDistrictName($district_code);
            $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
            $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
            $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
            $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
            $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

            $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name,
                'lot' => $lot_no, 'vill' => $vill_townprt_code_name, 'patta_no' => trim($this->session->userdata('patta_no')), 'patta_type_code' => $patta_type_code);

            //var_dump($this->session->all_userdata());
            //var_dump($data);
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/displaybasic', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/displaybasic';
            $this->load->view('layouts/main',$data);
        } else {
            redirect('/home');
        }
    }

    public function pdaradd()
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');

        if ($this->input->server('REQUEST_METHOD') == 'GET') 
        {
            // -----------------------------------------------------
            // 1️⃣ SELECT pending edit_jama_pattadar
            // -----------------------------------------------------
            $q1 = "
                SELECT * 
                FROM edit_jama_pattadar p
                WHERE p.dist_code = ? 
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.status = 'P'
                AND p.action = '0'
            ";

            $data['elist'] = $this->db->query($q1, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code
            ])->result();


            // -----------------------------------------------------
            // 2️⃣ SELECT distinct dag_no from chitha_basic
            // -----------------------------------------------------
            $q2 = "
                SELECT DISTINCT(dag_no) AS dag_no
                FROM chitha_basic p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
            ";

            $data['dag'] = $this->db->query($q2, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code
            ])->result();


            // -----------------------------------------------------
            // 3️⃣ SELECT remarks
            // -----------------------------------------------------
            $q3 = "
                SELECT remark, rmk_line_no
                FROM jama_remark p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.entry_mode != 'P'
            ";

            $data['rmk'] = $this->db->query($q3, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code
            ])->result();

            $data['_view'] = 'JamaEditEntry/pdaradd';
            $this->load->view('layouts/main', $data);
        } 
        
        else 
        {
            // -------------------------------
            // File Upload + Insert Logic
            // -------------------------------

            $dir = ADD_PATTADAR_BASE_DIR;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $config = [
                'upload_path'   => ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR,
                'allowed_types' => 'jpg|jpeg|png|doc|docx|pdf|txt',
                'encrypt_name'  => TRUE,
                'detect_mime'   => TRUE,
                'mod_mime_fix'  => TRUE,
            ];

            $this->load->library('upload', $config);

            $file_upload = $_FILES['file_upload']['name'];
            $ext = pathinfo($file_upload, PATHINFO_EXTENSION);

            // Validate file extension
            if (!in_array($ext, explode('|', $config['allowed_types']))) {
                $this->session->set_flashdata('message', "Wrong file type uploaded!");
                redirect(base_url().'index.php/jamaeditentry/pdaradd');
            }

            // Upload file
            if ($file_upload !== "" && $this->upload->do_upload('file_upload')) 
            {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];

                $dag_arr = $this->input->post('dag_no');
                if ($dag_arr == null) {
                    redirect(base_url() . "index.php/JamaEditEntry/pattadarlist");
                    return;
                }

                // Convert dag array to comma separated
                $value = implode(",", $dag_arr);

                // Prepare insert array
                $insert_data = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'patta_type_code' => $patta_type_code,
                    'patta_no' => $patta_no,
                    'pdar_name' => $this->input->post('pdar_name'),
                    'pdar_father' => $this->input->post('pdar_father'),
                    'pdar_add1' => $this->input->post('pdar_add1'),
                    'pdar_add2' => $this->input->post('pdar_add2'),
                    'pdar_land_b' => $this->input->post('pdar_land_b'),
                    'pdar_land_k' => $this->input->post('pdar_land_k'),
                    'pdar_land_lc' => $this->input->post('pdar_land_lc'),
                    'pdar_land_g' => $this->input->post('pdar_land_g'),
                    'pdar_land_kr' => $this->input->post('pdar_land_kr'),
                    'pdar_land_revenue' => $this->input->post('pdar_land_revenue'),
                    'pdar_land_localtax' => $this->input->post('pdar_land_localtax'),
                    'p_flag' => $this->input->post('p_flag'),
                    'new_pdar_name' => $this->input->post('new_pdar_name'),
                    'lm_comment' => addslashes($this->input->post('lm_note')),
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'O',
                    'user_code' => $this->session->userdata('user_code'),
                    'status' => 'P',
                    'action' => 0,
                    'attachment' => $file_name,
                    'dag_no' => $value
                ];

                // Insert into DB
                $this->db->insert('edit_jama_pattadar', $insert_data);

                if ($this->db->affected_rows() != 1) {
                    log_message('error', "ERRORPATTADARINSERT#001 " . $this->db->last_query());
                }
                redirect(base_url() . "index.php/JamaEditEntry/pattadarlist");
            } 
            else 
            {
                redirect(base_url() . "index.php/JamaEditEntry/pdaradd");
            }
        }
    }


    public function pattadarList()
    {
        $db = $this->session->userdata('db');

        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            set_time_limit(0);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');

            // Location names
            $dist_name = $this->utilityclass->getDistrictName($dist_code);
            $subdiv_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
            $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            // ✅ Query with bindings
            $query = "
                SELECT * 
                FROM jama_pattadar p 
                WHERE p.dist_code = ? 
                AND p.subdiv_code = ? 
                AND p.cir_code = ? 
                AND p.mouza_pargona_code = ? 
                AND p.vill_townprt_code = ? 
                AND p.lot_no = ? 
                AND TRIM(p.patta_no) = ? 
                AND p.patta_type_code = ? 
                ORDER BY CAST(p.pdar_id AS INT)
            ";

            $params = [
                $dist_code, $subdiv_code, $cir_code, 
                $mouza_pargona_code, $vill_townprt_code, 
                $lot_no, $patta_no, $patta_type_code
            ];

            $data['pattadars'] = $this->db->query($query, $params)->result();

            $data['location'] = [
                'dist' => $dist_name,
                'sub' => $subdiv_name,
                'cir' => $cir_name,
                'mouza' => $mouza_name,
                'lot' => $lot_name,
                'vill' => $vill_name,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code
            ];

            $data['_view'] = 'JamaEditEntry/pattadars';
            $this->load->view('layouts/main', $data);

        } else {
            // POST request (update/delete section)
            set_time_limit(0);
            $data = $this->input->post('pattadar');

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');

            foreach ($data as $p) {
                $pdar_serial_no = !empty($p['pdar_sl_no']) ? $p['pdar_sl_no'] : '0';

                // ✅ Delete query with bindings
                if ($p['delete'] == '1') {
                    $delete_query = "
                        DELETE FROM jama_pattadar 
                        WHERE dist_code = ? 
                        AND subdiv_code = ? 
                        AND cir_code = ? 
                        AND mouza_pargona_code = ? 
                        AND vill_townprt_code = ? 
                        AND lot_no = ? 
                        AND TRIM(patta_no) = ? 
                        AND patta_type_code = ? 
                        AND pdar_id = ?
                    ";
                    $delete_params = [
                        $dist_code, $subdiv_code, $cir_code,
                        $mouza_pargona_code, $vill_townprt_code,
                        $lot_no, $patta_no, $patta_type_code, $p['pdar_id']
                    ];
                    // $this->db->query($delete_query, $delete_params);
                }

                // ✅ Update query with bindings
                $update_query = "
                    UPDATE jama_pattadar 
                    SET pdar_id = ?, 
                        pdar_name = ?, 
                        pdar_father = ?, 
                        p_flag = ?, 
                        pdar_sl_no = ? 
                    WHERE dist_code = ? 
                    AND subdiv_code = ? 
                    AND cir_code = ? 
                    AND mouza_pargona_code = ? 
                    AND vill_townprt_code = ? 
                    AND lot_no = ? 
                    AND TRIM(patta_no) = ? 
                    AND patta_type_code = ? 
                    AND pdar_id = ?
                ";

                $update_params = [
                    $p['new_pdar_id'], $p['pdar_name'], $p['pdar_father'], 
                    $p['strike'], $pdar_serial_no,
                    $dist_code, $subdiv_code, $cir_code, 
                    $mouza_pargona_code, $vill_townprt_code, 
                    $lot_no, $patta_no, $patta_type_code, $p['pdar_id']
                ];

                // $this->db->query($update_query, $update_params);
            }

            exit;
            // redirect(base_url() . "index.php/JamaEditEntry/pattadarList");
        }
    }


    function modifypdar() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = trim($this->session->userdata('patta_type_code'));
        $user_code = $this->session->userdata('user_code');
        
        $jama_query = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' order by cast(pdar_id as int)";
        $data['pattadar'] = $this->db->query($jama_query)->result();
        $sql = "Select * from    edit_jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and patta_no='$patta_no' and status='P' and user_code='$user_code' and action='4' ";
        $data['existname'] = $this->db->query($sql)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/JamaEditEntry/modifypattadarlist', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'JamaEditEntry/modifypattadarlist';
        $this->load->view('layouts/main',$data);
        //var_dump($data);
    }

    function modifypattdarUpdate() {
		 $db=  $this->session->userdata('db');
        if ($_POST) {
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                //redirect('JamaEditEntry/modifypdar');
                redirect('JamaEditEntry/modifypdarbothways');
            }
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $user_code = $this->session->userdata('user_code');
            $note_1 = $this->input->post('note_1');
            $note_2 = $this->input->post('note_2');
            $pname = $this->input->post('pname');
            $gurdian = $this->input->post('gurdian');
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note_1 . " &nbsp;&nbsp;" . $pname . " &nbsp;&nbsp;" . $gurdian . $note_2 . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $array = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code' => $this->session->userdata('patta_type_code'),
                'patta_no' => $this->session->userdata('patta_no'),
                'pdar_name' => $this->input->post('pname'),
                'pdar_father' => $this->input->post('gurdian'),
                'pdar_old_name' => $this->input->post('oldpdar'),
                'pdar_old_father' => $this->input->post('oldguard'),
                'pdar_id' => $this->input->post('bookId'),
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'O',
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'P',
                'action' => 4,
                'attachment' => $file_name,
                'lm_comment' => $lm_note,
            );
            
            $this->db->insert('edit_jama_pattadar', $array);
            redirect('JamaEditEntry/modifypdar');
        }
        redirect('JamaEditEntry/modifypdar');
    }

    public function remarks() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));

            $patta_type_code = $this->session->userdata('patta_type_code');
            $query = "select * from    jama_remark p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and entry_mode!='P' order by rmk_line_no";
            //echo $query;
            $data['remarks'] = $this->db->query($query)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/remarks', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/remarks';
            $this->load->view('layouts/main',$data);
        } else {
            //var_dump($_POST);
            $remark_line = $this->input->post('remak_line_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));

            $patta_type_code = $this->session->userdata('patta_type_code');
            $query = "select remark from    jama_remark p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and rmk_line_no='$remark_line' ";
            $data = $this->db->query($query)->row()->remark;
            //$remarks=$this->input->post('remarks');
            $this->session->set_userdata('remark', $data);
            //var_dump($remarks);
            //echo $remarks[$remark_line];

            $this->session->set_userdata('rmk_line_no', $remark_line);
            //var_dump($this->session->all_userdata());
            redirect('/JamaEditEntry/Oldremarks');
            exit;
            //$remarks = $this->input->post('remarks');
            //var_dump($remarks);
            foreach ($remarks as $r) {
                $checkbox_checked = count($r); //to determine the remarks to be updated

                $data = $this->input->post('pattadar');
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                $lot_no = $this->session->userdata('lot_no');
                $vill_townprt_code = $this->session->userdata('vill_code');
                $patta_no = trim($this->session->userdata('patta_no'));
                $patta_type_code = $this->session->userdata('patta_type_code');
                $remark = pg_escape_string($r['remark']);
                $date = date('Y-m-d');
                $user_code = $this->session->userdata('user_code');
                if ($checkbox_checked == '3') {
                    $update_query = "update jama_remark p set remark='$remark',entry_mode='K',entry_date='$date',user_code='$user_code' where p.rmk_line_no=$r[rmk_line_no]"
                            . " and p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                            . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                            . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code'";

                    //$this->db->query($update_query);
                }
            }
            // redirect(base_url() . "index.php/JamaEditEntry/remarks");
        }
    }

    function Oldremarks() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $user_code = $this->session->userdata('user_code');
        // $this->load->view('../views/header');
        // $this->load->view('../views/JamaEditEntry/oldremarkadd');
        // $this->load->view('../views/footer');
        $data['_view'] = 'JamaEditEntry/oldremarkadd';
        $this->load->view('layouts/main',$data);
        if ($_POST) {
            $dir = ADD_REMARKS_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_REMARKS_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];

            $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
           // var_dump($ext);exit;

            $FILES_TYPE_VALIDATION_ARR = explode('|', $config['allowed_types']);
            $checkFileExt = false;
            foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }

            if(!$checkFileExt){
                 $this->session->set_flashdata('message', "Wrong file type. Kindly upload a file with correct format !!");
            redirect(base_url() . 'index.php/jamaeditentry/Oldremarks');
            }
            else
            {
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('JamaEditEntry/Oldremarks');
            }
            }
            $remarks = strip_tags($this->input->post('remarks'));
            $old_remark = $this->session->userdata('remark');
            $remark_line = $this->session->userdata('rmk_line_no');
            $note = strip_tags($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $array = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code' => $this->session->userdata('patta_type_code'),
                'patta_no' => $this->session->userdata('patta_no'),
                'remark' => $remarks,
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'O',
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'P',
                'rmk_line_no' => $remark_line,
                'old_remark' => $old_remark,
                'fresh_old' => 2,
                'attachment' => $file_name,
                'lm_comment' => $lm_note,
            );
            $this->db->insert('edit_jama_remark', $array);
            redirect(base_url() . "index.php/JamaEditEntry/remarks");
        }
    }

    public function remarkadd() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $user_code = $this->session->userdata('user_code');

        $patta_type_code = $this->session->userdata('patta_type_code');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $query = "select remark as r from    edit_jama_remark p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and status!='F'";
            $data['remark'] = $this->db->query($query)->result();
            $query = "select distinct(dag_no) from    chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' ";
            $data['dag'] = $this->db->query($query)->result();
            // if ($rmk_max == null) {
            // $rmk_max = 1;
            // }
            // $data['rmk_line_no'] = $rmk_max;
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/remarkadd', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/remarkadd';
            $this->load->view('layouts/main',$data);
        } else {
            $dir =  ADD_REMARKS_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_REMARKS_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('JamaEditEntry/remarkadd');
            }
            $remarks = strip_tags($this->input->post('remarks'));
            $note = strip_tags($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $array = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code' => $this->session->userdata('patta_type_code'),
                'patta_no' => $this->session->userdata('patta_no'),
                'remark' => $remarks,
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'O',
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'P',
                'fresh_old' => 1,
                'attachment' => $file_name,
                'lm_comment' => $lm_note
            );
            $this->db->insert('edit_jama_remark', $array);
            redirect(base_url() . "index.php/JamaEditEntry/remarkadd");
            var_dump($array);
            exit;
        }
    }

    public function deopdarremove() {
 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/deopdarremove');
            }
            for ($i = 0; $i < sizeof($_POST['pdar']); $i++) {
                $pdar_id = $_POST['pdar'][$i];
                $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                        . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                        . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id' ";
                $data = $this->db->query($q)->row();
                unset($data->pdar_land_n);
                unset($data->pdar_land_s);
                unset($data->pdar_land_e);
                unset($data->pdar_land_w);
                unset($data->pdar_land_map);
                unset($data->pdar_sl_no);
                unset($data->pdar_gender);
                unset($data->pdar_minor_yn);
                unset($data->pdar_minor_dob);
                unset($data->pdar_mother);
                unset($data->pdar_aadharno);
                unset($data->pdar_mobile);
                unset($data->pdar_nrcno);
                unset($data->pdar_pan_no);
                unset($data->pdar_citizen_no);
                unset($data->pdar_thumb_imp);
                unset($data->pdar_add3);
                unset($data->pdar_photo);
                unset($data->created_on);
                unset($data->updated_on);
                unset($data->marital_status);
                unset($data->serial_no);
		        unset($data->dag_no_int);
                $data->p_flag = 1;
                $data->status = 'P';
                $data->action = 1;
                $data->attachment = $file_name;
                $data->user_code = $this->session->userdata('user_code');
                $data->entry_date = date('Y-m-d H:i:s');
                $data->entry_mode = 'O';
                $this->db->insert('edit_jama_pattadar', $data);
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' ";
            $data['pattadars'] = $this->db->query($q)->result();
            $q = "SElect * from    edit_jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and p.action='1' and status='P' and patta_type_code='$patta_type_code' ";
            $data['insert'] = $this->db->query($q)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/pdarremove', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pdarremove';
            $this->load->view('layouts/main',$data);
        }
    }

    public function deopdarstrike() {
 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $user_code = $this->session->userdata('user_code');
            $note = addslashes($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/deopdarstrike');
            }
            for ($i = 0; $i < sizeof($_POST['dag_no']); $i++) {
                $dag_no = $_POST['dag_no'][$i];
                $pdar_id = $_POST['pdar'];
                $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                        . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                        . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id' ";
                $data = $this->db->query($q)->row();
                unset($data->pdar_land_n);
                unset($data->pdar_land_s);
                unset($data->pdar_land_e);
                unset($data->pdar_land_w);
                unset($data->pdar_land_map);
                unset($data->pdar_sl_no);
                unset($data->pdar_gender);
                unset($data->pdar_minor_yn);
                unset($data->pdar_minor_dob);
                unset($data->pdar_mother);
                unset($data->pdar_aadharno);
                unset($data->pdar_mobile);
                unset($data->pdar_nrcno);
                unset($data->pdar_pan_no);
                unset($data->pdar_citizen_no);
                unset($data->pdar_thumb_imp);
                unset($data->pdar_add3);
                unset($data->pdar_photo);
                unset($data->created_on);
                unset($data->updated_on);
                unset($data->marital_status);
                unset($data->serial_no);
		        unset($data->dag_no_int);
                $data->dag_no = $dag_no;
                $data->action = 2;
                $data->status = 'P';
                $data->user_code = $this->session->userdata('user_code');
                $data->entry_date = date('Y-m-d H:i:s');
                $data->entry_mode = 'O';
                $data->attachment = $file_name;
                $data->lm_comment = $lm_note;
                //var_dump($data);
                $this->db->insert('edit_jama_pattadar', $data);
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and p_flag!='1' ";
            $data['pattadars'] = $this->db->query($q)->result();
            $q = "SElect * from    edit_jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and status='P' and p.action='2' and patta_type_code='$patta_type_code' ";
            $data['insert'] = $this->db->query($q)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/pdarstrike', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'chitha_basic/pdarstrike';
            $this->load->view('layouts/main',$data);
        }
    }

    public function deopdarustrike() {
 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $user_code = $this->session->userdata('user_code');
            $note = addslashes($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/deopdarustrike');
            }
            for ($i = 0; $i < sizeof($_POST['dag_no']); $i++) {
                $dag_no = $_POST['dag_no'][$i];
                $pdar_id = $_POST['pdar'];
                $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                        . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                        . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id' ";
                $data = $this->db->query($q)->row();
                unset($data->pdar_land_n);
                unset($data->pdar_land_s);
                unset($data->pdar_land_e);
                unset($data->pdar_land_w);
                unset($data->pdar_land_map);
                unset($data->pdar_sl_no);
                unset($data->pdar_gender);
                unset($data->pdar_minor_yn);
                unset($data->pdar_minor_dob);
                unset($data->pdar_mother);
                unset($data->pdar_aadharno);
                unset($data->pdar_mobile);
                unset($data->pdar_nrcno);
                unset($data->pdar_pan_no);
                unset($data->pdar_citizen_no);
                unset($data->pdar_thumb_imp);
                unset($data->pdar_add3);
                unset($data->pdar_photo);
                unset($data->created_on);
                unset($data->updated_on);
                unset($data->marital_status);
                unset($data->serial_no);
		        unset($data->dag_no_int);
                $data->action = 3;
                $data->dag_no = $dag_no;
                $data->status = 'P';
                $data->user_code = $this->session->userdata('user_code');
                $data->entry_date = date('Y-m-d H:i:s');
                $data->entry_mode = 'O';
                $data->attachment = $file_name;
                $data->lm_comment = $lm_note;
                unset($data->not_consistent);
                //var_dump($data);
                echo $this->db->insert('edit_jama_pattadar', $data);
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and p_flag='1' ";
            $data['pattadars'] = $this->db->query($q)->result();
            $q = "SElect * from    edit_jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and status='P' and p.action='3' and patta_type_code='$patta_type_code' ";
            $data['insert'] = $this->db->query($q)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/chitha_basic/pdarustrike', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'chitha_basic/pdarustrike';
            $this->load->view('layouts/main',$data);
        }
    }

    public function dagEdit($dag_no) {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));


            $patta_type_code = $this->session->userdata('patta_type_code');
            $query = "select * from    jama_dag p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' ";
            //echo $query;
            $data['dag'] = $this->db->query($query)->row();
            $query = "select * from    landclass_code ";
            $data['classes'] = $this->db->query($query)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/dagEdit', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/dagEdit';
            $this->load->view('layouts/main',$data);
        } else {

            // var_dump($this->input->post());
            $array = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code' => $this->session->userdata('patta_type_code'),
                'patta_no' => $patta_no,
                'dag_no' => $dag_no,
                'dag_class_code' => $this->input->post('dag_class_code'),
                'dag_area_b' => $this->input->post('dag_area_b'),
                'dag_area_k' => $this->input->post('dag_area_k'),
                'dag_area_lc' => $this->input->post('dag_area_lc'),
                //'dag_area_g'=>$this->input->post('dag_class_code'),
                //'dag_area_kr'=>$this->input->post('dag_class_code'),
                'dag_revenue' => $this->input->post('dag_revenue'),
                'dag_localtax' => $this->input->post('dag_localtax'),
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'O',
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'P'
            );
            $this->db->insert('edit_jama_dag', $array);
            $cid = $this->db->insert_id();
            //var_dump($array);
            $this->session->set_userdata('editid', $cid);
            //var_dump($this->session->all_userdata());
            // $where = array(
            // 'dist_code' => $dist_code,
            // 'subdiv_code' => $subdiv_code,
            // 'cir_code' => $cir_code,
            // 'mouza_pargona_code' => $mouza_pargona_code,
            // 'lot_no' => $lot_no,
            // 'vill_townprt_code' => $vill_townprt_code,
            // 'patta_no' => $patta_no,
            // 'dag_no' => $dag_no
            // );
            //$this->db->where($where);
            //$this->db->update('jama_dag', $this->input->post());
            redirect(base_url() . "index.php/JamaEditEntry/daglist");
        }
    }

    public function dagList() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));


            $patta_type_code = $this->session->userdata('patta_type_code');
            $query = "select * from    jama_dag p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' "
                    . " order by cast(dag_no as int)";
            //echo $query;
            $data['dags'] = $this->db->query($query)->result();

            $query = "select * from    landclass_code ";
            $data['classes'] = $this->db->query($query)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/dags', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/dags';
            $this->load->view('layouts/main',$data);
        }
    }

    function dagsRemove() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $user_code = $this->session->userdata('user_code');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));


            $patta_type_code = $this->session->userdata('patta_type_code');
            $q = "select dag_no from    chitha_basic p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' ";

            $query = "select * from    jama_dag p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and dag_no not in ($q) "
                    . " order by cast(dag_no as int)";
            //echo $query;
            $data['dags'] = $this->db->query($query)->result();

            $query = "select * from    landclass_code ";
            $data['classes'] = $this->db->query($query)->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/dagsremove', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/dagsremove';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dir = REMOVE_DAG_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = REMOVE_DAG_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
             $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
           // var_dump($ext);exit;

            $FILES_TYPE_VALIDATION_ARR = explode('|', $config['allowed_types']);
            $checkFileExt = false;
            foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }

            if(!$checkFileExt){
                 $this->session->set_flashdata('message', "Wrong file type. Kindly upload a file with correct format !!");
            redirect(base_url() . 'index.php/jamaeditentry/dagsRemove');
            }
            else
            {
            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/JamaEditEntry/dagsRemove');
            }
            }
            $p_d_action = $this->input->post('remove');
            $dagsremove = $this->input->post('dagsremove');
            $note = addslashes($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $size = sizeof($dagsremove);
            for ($i = 0; $i < $size; $i++) {
                $array = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'patta_type_code' => $this->session->userdata('patta_type_code'),
                    'patta_no' => $patta_no,
                    'dag_no' => $dagsremove[$i],
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'O',
                    'user_code' => $this->session->userdata('user_code'),
                    'status' => 'P',
                    'p_d_action' => $p_d_action,
                    'attachment' => $file_name,
                    'lm_comment' => $lm_note,
                );
                $this->db->insert('edit_jama_dag', $array);
            }
            redirect('/jamaeditentry/displaybasic/' . $patta_no . "/" . $this->session->userdata('patta_type_code'));
        }
    }

    public function basicdetails() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $data['d'] = $dist_code;
            $data['s'] = $subdiv_code;
            $data['c'] = $cir_code;
            $data['m'] = $mouza_pargona_code;
            $data['l'] = $lot_no;
            $data['v'] = $vill_townprt_code;
            $patta_types = $this->db->query("select type_code,patta_type from    patta_code")->result();
            $data['patta_types'] = $patta_types;
            $land_classes = $this->db->query("select class_code,land_type from    landclass_code")->result();
            $data['land_classes'] = $land_classes;
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/basicdetails', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/basicdetails';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('submit');
            if ($action === 'submit') {
                $this->session->set_userdata($this->input->post());
                $data = $this->input->post();
                $data['user_code'] = $this->session->userdata('user_code');
                $data['operation'] = 'E';
                $data['date_entry'] = date('Y-m-d');
                unset($data['submit']);
                if (!$this->input->post('edit') == '1') {
                    // $this->db->insert('chitha_basic', $data);
                    $this->Chitha_basic_model->insert_table('chitha_basic',$data);
                }
                redirect(base_url() . "index.php/JamaEditEntry/pattadardetails");
            } else {
                redirect(base_url() . "index.php/JamaEditEntry/pattadardetails");
            }
        }
    }

    public function getdagdetails() {
		 $db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type_code');
        $data = $this->db->get_where('chitha_basic', array('dag_no' => $dag_no, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code
                ))->result();
        //echo json_encode($data);
    }

    public function pattadardetails() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code'";
            $data['pattadars'] = $this->db->query($q)->result();
            if ($this->session->userdata('pattadars_new') != null) {
                $pattadars = $this->session->userdata('pattadars_new');
                foreach ($pattadars as $key => $value) {
                    $object = new stdClass();
                    foreach ($value as $k => $v) {
                        $object->$k = $v;
                    }
                    $object->newFlag = true;
                    $data['pattadars'][] = $object;
                }
            }
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/pattadars', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pattadars';
            $this->load->view('layouts/main',$data);
        }
    }

    public function pdaredit($pdar_id) {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $dag_no = $this->session->userdata('dag_no');
            $q = "select * from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' and p.pdar_id='$pdar_id' and d.pdar_id='$pdar_id'";
            $data['pattadar'] = $this->db->query($q)->row();

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/pdaredit', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pdaredit';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->input->post('submit') == 'Submit') {
                $pdar_name = $this->input->post('pdar_name');
                $pdar_father = $this->input->post('pdar_father');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_mother = $this->input->post('pdar_mother');
                $dag_por_b = $this->input->post('dag_por_b');
                $dag_por_k = $this->input->post('dag_por_k');
                $dag_por_lc = $this->input->post('dag_por_lc');
                $dag_por_g = $this->input->post('dag_por_g');
                $dag_por_kr = $this->input->post('dag_por_kr');
                $pdar_land_n = $this->input->post('pdar_land_n');
                $pdar_land_s = $this->input->post('pdar_land_s');
                $pdar_land_e = $this->input->post('pdar_land_e');
                $pdar_land_w = $this->input->post('pdar_land_w');
                $pdar_land_acre = $this->input->post('pdar_land_acre');
                $pdar_land_revenue = $this->input->post('pdar_land_revenue');
                $pdar_land_localtax = $this->input->post('pdar_land_localtax');

                // $query = "update chitha_pattadar p set pdar_name ='$pdar_name',pdar_father='$pdar_father',pdar_mother='$pdar_mother',"
                //         . " pdar_add1='$pdar_add1' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
                // $this->db->query($query);

                $table = 'chitha_pattadar';

                $params = [
                    'pdar_name'   => $pdar_name,
                    'pdar_father' => $pdar_father,
                    'pdar_mother' => $pdar_mother,
                    'pdar_add1'   => $pdar_add1,
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'patta_no'           => trim($patta_no),  // handle TRIM here in PHP
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $pdar_id,
                ];

                // Call your model method to update
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                // $query = "update chitha_dag_pattadar p set dag_por_b ='$dag_por_b',dag_por_k='$dag_por_k',dag_por_lc='$dag_por_lc',"
                //         . " dag_por_g='$dag_por_g', dag_por_kr='$dag_por_kr',pdar_land_n='$pdar_land_n',pdar_land_n='$pdar_land_n', "
                //         . " pdar_land_n='$pdar_land_n',pdar_land_n='$pdar_land_n',pdar_land_acre=$pdar_land_acre,pdar_land_revenue=$pdar_land_revenue "
                //         . " pdar_land_localtax=$pdar_land_localtax"
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";

                $table = 'chitha_dag_pattadar';
                $params = [
                    'dag_por_b'          => $dag_por_b,
                    'dag_por_k'          => $dag_por_k,
                    'dag_por_lc'         => $dag_por_lc,
                    'dag_por_g'          => $dag_por_g,
                    'dag_por_kr'         => $dag_por_kr,
                    'pdar_land_n'        => $pdar_land_n,
                    'pdar_land_acre'     => $pdar_land_acre,
                    'pdar_land_revenue'  => $pdar_land_revenue,
                    'pdar_land_localtax' => $pdar_land_localtax,
                ];
                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no), // trim in PHP replaces SQL TRIM
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $pdar_id,
                ];
                // Then call your update function
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                redirect(base_url() . "index.php/JamaEditEntry/pattadardetails");
            } else {
                redirect(base_url() . "index.php/JamaEditEntry/orderList");
            }
        }
    }

    public function colEightOrderEdit($order_cron_no) {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $ord_type_query = "select * from    master_field_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    loginuser_table where priv='mut' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    loginuser_table where priv='adm' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $query = "select * from    chitha_col8_order p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";

            $data['order'] = $this->db->query($query)->row();
            $query = "select * from    chitha_col8_occup p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";
            $data['occupants'] = $this->db->query($query)->result();
            $query = "select * from    chitha_col8_inplace p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and col8order_cron_no='$order_cron_no' "
                    . " ";
            $data['inplaces'] = $this->db->query($query)->result();

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/orderedit', $data);
            // $this->load->view('../views/footer');
             $data['_view'] = 'JamaEditEntry/orderedit';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $orderfinal = $this->input->post('finalorder');
            $occupants = $this->input->post('occup');
            $inplaces = $this->input->post('inplace');
            $this->session->set_userdata(array('final' => $orderfinal));
            $this->session->set_userdata(array('inplaces' => $inplaces));
            $this->session->set_userdata(array('occupants' => $occupants));
            redirect(base_url() . "index.php/JamaEditEntry/finalSave");
        }
    }

    public function colEightOrderAdd() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $dag_no = $this->session->userdata('dag_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $ord_type_query = "select * from    master_field_mut_type";
            $data['ord_types'] = $this->db->query($ord_type_query)->result();

            $trans_code_query = "select * from    nature_trans_code";
            $data['trans_codes'] = $this->db->query($trans_code_query)->result();
            $mandals_query = "select * from    loginuser_table where priv='mut' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
                    . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code'";

            $data['mandals'] = $this->db->query($mandals_query)->result();
            $cos_query = "select * from    loginuser_table where priv='adm' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ";


            $data['cos'] = $this->db->query($cos_query)->result();
            $q = "select * from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' ";


            $data['inplaces'] = $this->db->query($q)->result();
            $col8_order_cron_no_q = "select max(col8order_cron_no)+1 as max from    chitha_col8_order p where  p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and p.dag_no='$dag_no' 
            ";
            $max = $this->db->query($col8_order_cron_no_q)->row()->max;
            if ($max == null) {
                $max = 1;
            }
            $data['max_number'] = $max;

            $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/orderadd', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/orderadd';
            $this->load->view('layouts/main',$data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $orderfinal = $this->input->post('finalorder');
            $occupants = $this->input->post('occup');
            $inplaces = $this->input->post('inplace');
            $this->session->set_userdata(array('final' => $orderfinal));
            $this->session->set_userdata(array('inplaces' => $inplaces));
            $this->session->set_userdata(array('occupants' => $occupants));
            if ($orderfinal['order_type_code'] == '02') {
                $this->savePartition($this->input->post());
                return;
            }
            redirect(base_url() . "index.php/JamaEditEntry/finalSaveNewOrder");
        }
    }

    public function savePartition($post) {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dag_no = $this->session->userdata('dag_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $post['finalorder']['new_dag'],
            'dag_no_int' => $post['finalorder']['new_dag'] . "00",
            'old_dag_no' => $post['finalorder']['dag_no'],
            'patta_no' => trim($post['finalorder']['new_patta']),
            'old_patta_no' => trim($post['finalorder']['old_patta']),
            'dag_area_b' => $post['finalorder']['dag_area_b'],
            'dag_area_k' => $post['finalorder']['dag_area_k'],
            'dag_area_lc' => $post['finalorder']['dag_area_lc'],
            'dag_area_g' => $post['finalorder']['dag_area_g'],
            'dag_area_kr' => $post['finalorder']['dag_area_kr'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'patta_type_code' => $patta_type_code,
            'land_class_code' => $this->session->userdata('land_class_code')
        );

        // $this->db->insert('chitha_basic', $data);
        $this->Chitha_basic_model->insert_table('chitha_basic',$data);
        $pdar_id = 1;


        $inplaces = $this->session->userdata('inplaces');


        foreach ($inplaces as $inplace) {

            if (isset($inplace['include'])) {

                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($post['finalorder']['new_patta']),
                    'patta_type_code' => $this->session->userdata('patta_type_code'),
                    'pdar_name' => $inplace['inplace_of_name'],
                    'pdar_father' => $inplace['inplace_of_father'],
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d'),
                    'jama_yn' => 'N'
                );
                // $this->db->insert('chitha_pattadar', $data);
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $post['finalorder']['new_dag'],
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($post['finalorder']['new_patta']),
                    'patta_type_code' => $patta_type_code,
                    'dag_por_b' => $post['finalorder']['dag_area_b'],
                    'dag_por_k' => $post['finalorder']['dag_area_b'],
                    'dag_por_lc' => $post['finalorder']['dag_area_b'],
                    'dag_por_g' => 0,
                    'dag_por_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d')
                );
                // $this->db->insert('chitha_dag_pattadar', $data);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $post['finalorder']['new_dag'],
                    'col8order_cron_no' => $post['finalorder']['col8order_cron_no'],
                    'occupant_id' => $pdar_id,
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d')
                );
                $values = array(
                    'occupant_name' => $inplace['inplace_of_name'],
                    'occupant_fmh_name' => $inplace['inplace_of_father'],
                );
                $this->db->insert('chitha_col8_occup', array_merge($values, $data));
                $data['dag_no'] = $dag_no;
                $data['new_dag_no'] = $post['finalorder']['new_dag'];
                $data['new_patta_no'] = trim($post['finalorder']['new_patta']);
                $this->db->insert('chitha_col8_occup', array_merge($values, $data));
                // $query = "update chitha_dag_pattadar p set p_flag='1' "
                //         . "where dag_no='$dag_no' and p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // $this->db->query($query);

                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dag_no'             => $dag_no,
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'patta_no'           => trim($patta_no),  // Trim in PHP instead of SQL TRIM
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'],
                ];

                // Execute the update
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

               
                $pdar_id++;
            }
        }

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $post['finalorder']['new_dag'],
            'col8order_cron_no' => $post['finalorder']['col8order_cron_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'mut_land_area_b' => $post['finalorder']['dag_area_b'],
            'mut_land_area_k' => $post['finalorder']['dag_area_k'],
            'mut_land_area_lc' => $post['finalorder']['dag_area_lc'],
            'mut_land_area_g' => 0,
            'mut_land_area_kr' => 0,
            'land_area_left_b' => 0,
            'land_area_left_k' => 0,
            'land_area_left_lc' => 0,
            'land_area_left_g' => 0,
            'land_area_left_kr' => 0
        );
        unset($post['finalorder']['old_patta']);
        unset($post['finalorder']['new_dag']);
        unset($post['finalorder']['new_patta']);
        unset($post['finalorder']['dag_area_b']);
        unset($post['finalorder']['dag_area_k']);
        unset($post['finalorder']['dag_area_lc']);
        unset($post['finalorder']['dag_area_g']);
        unset($post['finalorder']['dag_area_kr']);
        unset($post['finalorder']['dag_no']);
        $this->db->insert('chitha_col8_order', array_merge($data, $post['finalorder']));
        $post['finalorder']['dag_no'] = $dag_no;

        return;
    }

    public function finalSave() {
		 $db=  $this->session->userdata('db');
        $orderfinal = $this->session->userdata('final');

        $occupants = $this->session->userdata('occupants');
        //var_dump($occupants);
        $inplaces = $this->session->userdata('inplaces');
        $removals = $this->session->userdata('removals');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $l_b = 0;
        $l_k = 0;
        $l_lc = 0;
        $l_g = 0;
        $l_kr = 0;
        foreach ($occupants as $occup) {
            $l_b += $occup['land_area_b'];
            $l_k += $occup['land_area_k'];
            $l_lc += $occup['land_area_lc'];
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $occup['occupant_id']
            );
            $values = array(
                'occupant_name' => $occup['occupant_name'],
                'occupant_fmh_name' => $occup['occupant_fmh_name'],
                'occupant_add1' => $occup['occupant_add1'],
            );
            $this->db->where($data);

            $this->db->update('chitha_col8_occup', $values);
            if ($this->db->affected_rows() == 0) {
                $other_data = array(
                    'land_area_b' => $occup['land_area_b'],
                    'land_area_k' => $occup['land_area_k'],
                    'land_area_lc' => $occup['land_area_lc'],
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'user_code' => $this->session->userdata('user_code')
                );
                $final = array_merge($values, $data, $other_data);
                $this->db->insert('chitha_col8_occup', $final);
            } else {
                //echo "Updated";
            }
        }
        //echo $l_b . " " . $l_k . " " . $l_lc;
        $rem = $l_b * 100 + $l_k * 20 + $l_lc;

        $bigha_r = floor($rem / 100.0);
        //echo $bigha_r;
        $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
        $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'col8order_cron_no' => $orderfinal['col8order_cron_no'],
        );
        $this->db->where($data);
        $values = array(
            'mut_land_area_b' => $bigha_r,
            'mut_land_area_k' => $katha_r,
            'mut_land_area_lc' => $lessa_r,
        );

        $this->db->update('chitha_col8_order', $values);
        foreach ($inplaces as $inplace) {
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
            );
            $values = array(
                'inplace_of_name' => $inplace['inplace_of_name'],
                'inplace_of_father' => $inplace['inplace_of_father'],
                'inplaceof_alongwith' => $inplace['inplaceof_alongwith'],
            );
            $this->db->where($data);
            $this->db->update('chitha_col8_inplace', $values);
            if ($inplace['inplaceof_alongwith'] == 'i') {
                // $query = "update chitha_dag_pattadar p set p_flag='1' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // //echo $query;
                // $this->db->query($query);

                $table = 'chitha_dag_pattadar';
                $params = [
                    'p_flag' => '1',
                ];
                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no),  // Trim in PHP instead of SQL TRIM
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'],
                ];

                // Call the update function
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

            } else {
                // $query = "update chitha_dag_pattadar p set p_flag='0' "
                //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";
                // //echo $query;
                // $this->db->query($query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '0',
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'lot_no'             => $lot_no,
                    'dag_no'             => $dag_no,
                    'patta_no'           => trim($patta_no),  // trim in PHP
                    'patta_type_code'    => $patta_type_code,
                    'pdar_id'            => $inplace['inplace_of_id'],
                ];

                // Then call your update function:
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

            }
        }

        foreach ($removals as $key => $value) {
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $value['id']
            );
            $this->db->where($data);
            $this->db->delete('chitha_col8_occup');
            $this->session->unset_userdata('removals');
            $this->session->unset_userdata('occupants');
            $this->session->unset_userdata('inplaces');
            $this->session->unset_userdata('final');
        }
    }

    public function finalSaveNewOrder() {
		 $db=  $this->session->userdata('db');
        $orderfinal = $this->session->userdata('final');

        $occupants = $this->session->userdata('occupants');
        //var_dump($occupants);

        $inplaces = $this->session->userdata('inplaces');

        $removals = $this->session->userdata('removals');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $occupant_id = 1;
        $l_b = 0;
        $l_k = 0;
        $l_lc = 0;
        $l_g = 0;
        $l_kr = 0;
        foreach ($occupants as $occup) {
            $q = "select max(p.pdar_id)+1 as pdar_id from    chitha_pattadar p where p.dist_code='$dist_code' and"
                    . " p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' ";
            //echo $q;

            $pdar_id = $this->db->query($q)->row()->pdar_id;

            if ($pdar_id == null) {
                $pdar_id = 1;
            }
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                'occupant_id' => $occupant_id++,
                'land_area_g' => 0,
                'land_area_kr' => 0,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
            );

            $l_b += $occup['land_area_b'];
            $l_k += $occup['land_area_k'];
            $l_lc += $occup['land_area_lc'];

            $final = array_merge($data, $occup);
            $this->db->insert('chitha_col8_occup', $final);

            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'pdar_id' => $pdar_id,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'pdar_name' => $occup['occupant_name'],
                'pdar_father' => $occup['occupant_fmh_name'],
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d'),
                'jama_yn' => 'N'
            );
            // $this->db->insert('chitha_pattadar', $data);
            $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'pdar_id' => $pdar_id,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'dag_por_b' => $occup['land_area_b'],
                'dag_por_k' => $occup['land_area_k'],
                'dag_por_lc' => $occup['land_area_lc'],
                'dag_por_g' => 0,
                'dag_por_kr' => 0,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d')
            );
            // $this->db->insert('chitha_dag_pattadar', $data);
            $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
        }

        $rem = $l_b * 100 + $l_k * 20 + $l_lc;

        $bigha_r = floor($rem / 100.0);
        $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
        $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'col8order_cron_no' => $orderfinal['col8order_cron_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'mut_land_area_b' => $bigha_r,
            'mut_land_area_k' => $katha_r,
            'mut_land_area_lc' => $lessa_r,
            'mut_land_area_g' => 0,
            'mut_land_area_kr' => 0,
            'land_area_left_b' => 0,
            'land_area_left_k' => 0,
            'land_area_left_lc' => 0,
            'land_area_left_g' => 0,
            'land_area_left_kr' => 0
        );
        unset($orderfinal['old_patta']);
        unset($orderfinal['new_dag']);
        unset($orderfinal['new_patta']);
        unset($orderfinal['dag_area_b']);
        unset($orderfinal['dag_area_k']);
        unset($orderfinal['dag_area_lc']);
        unset($orderfinal['dag_area_g']);
        unset($orderfinal['dag_area_kr']);

        $this->db->insert('chitha_col8_order', array_merge($orderfinal, $data));

        $inplace_of_id = 1;
        foreach ($inplaces as $inplace) {
            //var_dump($inplace);
            if (isset($inplace['include'])) {
                $data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag_no,
                    'col8order_cron_no' => $orderfinal['col8order_cron_no'],
                    'inplace_of_id' => $inplace_of_id++,
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                );
                $values = array(
                    'inplace_of_name' => $inplace['inplace_of_name'],
                    'inplace_of_father' => $inplace['inplace_of_father'],
                    'inplaceof_alongwith' => $inplace['inplaceof_alongwith'],
                );
                $final = array_merge($values, $data);
                $this->db->insert('chitha_col8_inplace', $final);
                if ($inplace['inplaceof_alongwith'] == 'i') {
                    // $query = "update chitha_dag_pattadar p set p_flag='1' "
                    //         . "where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    //         . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$inplace[inplace_of_id]'";

                    // $this->db->query($query);

                    $table = 'chitha_dag_pattadar';
                    $params = [
                        'p_flag' => '1',
                    ];
                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_townprt_code,
                        'lot_no'             => $lot_no,
                        'dag_no'             => $dag_no,
                        'patta_no'           => trim($patta_no),  // Trim here in PHP, instead of TRIM in SQL
                        'patta_type_code'    => $patta_type_code,
                        'pdar_id'            => $inplace['inplace_of_id'],
                    ];
                    // Then call your update method
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }
            }
        }
        $this->session->unset_userdata('removals');
        $this->session->unset_userdata('occupants');
        $this->session->unset_userdata('inplaces');
        $this->session->unset_userdata('final');
    }

    public function orderList() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = $this->session->userdata('patta_type_code');
            $dag_no = $this->session->userdata('dag_no');
            $query = "select * from    chitha_col8_order p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                    . " and p.lot_no='$lot_no' and p.dag_no='$dag_no'  "
                    . " ";
            $data['orders'] = $this->db->query($query)->result();
            //var_dump($data['orders']);
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/orderlist', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/orderlist';
            $this->load->view('layouts/main',$data);
        }
    }

    public function removeApplicant($id) {
		 $db=  $this->session->userdata('db');
        $data = $this->input->post();
        //var_dump($data);
        if ($this->session->userdata('removals') == null) {
            $this->session->set_userdata('removals', array());
            $removals = $this->session->userdata('removals');
            $removals[] = $data;
            $this->session->set_userdata(array('removals' => $removals));
        } else {
            $removals = $this->session->userdata('removals');
            $removals[] = $data;
            $this->session->set_userdata(array('removals' => $removals));
        }
        //var_dump($this->session->userdata('removals'));
    }

    public function deletepattadars() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $pdar_id = $this->input->post('id');
        $query = "delete from    chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        $query = "delete from    chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
        $pattadars_new = $this->session->userdata('pattadars_new');
        foreach ($pattadars_new as $key => $p) {
            if ($p['pdar_id'] == $pdar_id) {
                //echo $key;
                unset($pattadars_new[$key]);
                $max_pdar_id = $this->session->userdata('max_pdar_id') - 1;
                $this->session->set_userdata('max_pdar_id', $max_pdar_id);
            }
        }
        $this->session->set_userdata('pattadars_new', $pattadars_new);
    }

    public function strikeoutPattadar() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $pdar_id = $this->input->post('id');
        $query = "update from    chitha_dag_pattadar p set p_flag='1' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
    }

    public function unstrikeoutPattadar() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $pdar_id = $this->input->post('id');
        $query = "update from    chitha_dag_pattadar p set p_flag='0' where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                . " and p.lot_no='$lot_no' and p.dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pdar_id'";
        $this->db->query($query);
    }

    function dageditlist() {
		 $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'LM') {

            $sql = "Select * from    edit_jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code='$user_code' ";
        } else {

            $sql = "Select * from    edit_jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='P'  ";
        }
        $data['basic'] = $this->db->query($sql)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/chitha_basic/editdaglist', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'chitha_basic/editdaglist';
        $this->load->view('layouts/main',$data);
    }

    function editpattadar() {
        $this->load->library('pagination');
        $this->load->model('legacyModel');
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $searchKeyword=null;
        if($this->input->post('submitSearch')){
              $inputKeywords = $this->input->post('searchKeyword');
              $searchKeyword = strip_tags($inputKeywords);
              if(!empty($searchKeyword)){
                  $this->session->set_userdata('searchKeyword',$searchKeyword);
              }else{
                  $this->session->unset_userdata('searchKeyword');
              }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }
        $this->load->model('legacyModel');
        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        $config['base_url'] = base_url().'index.php/JamaEditEntry/editpattadar';
        $config['total_rows'] = $this->legacyModel->getCountPendingRoRCases();        
        $config['per_page'] = 10;        
        $config['uri_segment'] = 3;        
        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li>';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="prev">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li>';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li>';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li>';        
        $config['num_tag_close'] = '</li>';
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);        
        $cases['links'] = $this->pagination->create_links();
        $cases['basic'] = $this->legacyModel->getPendingRoRCases($config["per_page"],$page,$searchKeyword);
        $cases['_view'] = 'chitha_basic/editpattadar';
        $this->load->view('layouts/main',$cases);
    }

    function editremark() {
		 $db=  $this->session->userdata('db');
        $this->load->helper('html');
        $user_code = $this->session->userdata('user_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code == 'LM') {
            //$this->load->view('../views/chitha_basic/header');
            $sql = "Select * from    edit_jama_remark where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code='$user_code' ";
        } else {
            //$this->load->view('../views/header');
            $sql = "Select * from    edit_jama_remark where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='P'  ";
        }
        $data['basic'] = $this->db->query($sql)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/chitha_basic/editremark', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'chitha_basic/editremark';
        $this->load->view('layouts/main',$data);
    }

    function updateddag() {
		 $db=  $this->session->userdata('db');
        $id = $this->input->post('bookId');
        $final_report = addslashes($this->input->post('final_report'));
        $user_code = $this->session->userdata('user_desig_code');
        $code = $this->session->userdata('user_code');

        if ($user_code == 'CO') {
            $q = "Select * from    edit_jama_dag where id=$id";
            $data = $this->db->query($q)->row();
            $lm = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->user_code);
            $lm_note = "( **** টোকা :-  ভূমিলেখ্য সহায়ক --- " . $lm->lm_name . " Dated :-" . date('Y-m-d', strtotime($data->entry_date));
            $lm_note = $lm_note . "&nbsp;&nbsp; " . $data->dag_no . " নং  দাগ এই পট্টাৰ পৰা আতৰোৱা হল | ";
            $coname = $this->utilityclass->getSelectedCOName($data->dist_code, $data->subdiv_code, $data->cir_code, $user_code);
            $final_report = $lm_note . $final_report . "<br> চক্ৰ বিষয়া :-" . $coname->username . " Dated: " . date('Y-m-d') . " )";
            $udata = array('co_code' => $code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'F', 'co_confirmation' => $final_report);
            $this->db->where('id', $id);
            $this->db->update('edit_jama_dag', $udata);
            $this->remarksAdd($id, 3);
            $this->db->where('dist_code', $data->dist_code);
            $this->db->where('subdiv_code', $data->subdiv_code);
            $this->db->where('cir_code', $data->cir_code);
            $this->db->where('mouza_pargona_code', $data->mouza_pargona_code);
            $this->db->where('lot_no', $data->lot_no);
            $this->db->where('vill_townprt_code', $data->vill_townprt_code);
            $this->db->where('patta_type_code', $data->patta_type_code);
            $this->db->where('patta_no', $data->patta_no);
            $this->db->where('dag_no', $data->dag_no);
            $this->db->delete('jama_dag');
            redirect('JamaEditEntry/dageditlist');
        } else {
            redirect('JamaEditEntry/dageditlist');
        }
    }

    function updatedpattadar() {
        // dd("here");
		// $db=  $this->session->userdata('db');
        $id = $this->input->post('bookId');
        $final_report = addslashes($this->input->post('final_report'));
        $user_code = $this->session->userdata('user_desig_code');
        $rmk = "";
        if ($user_code == 'CO') {
            $this->db->trans_begin();
            $user_code = $this->session->userdata('user_code');
            $sql = "SELECT * FROM edit_jama_pattadar WHERE id = ?";
            $data = $this->db->query($sql, [$id])->row();

            // $code_to_find_out = $data->dist_code.'/'.$data->subdiv_code.'/'.$data->cir_code.'/'.$data->mouza_pargona_code.'/'.$data->lot_no.'/'.$data->vill_townprt_code.'/'.$data->patta_type_code.'/'.$data->patta_no.'/'.$data->pdar_id;
            $code_to_find_out = $id;
            $this->AgriStackCaseHistory->CreateLogFile($data->dist_code, $code_to_find_out);
            // var_dump($data);exit;

            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $this->load->model('propChain/PropChainCommonModel');


                if($data->action=='2' || $data->action=='3')
                {

                    $where="dist_code = ? 
                      and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?
                      and vill_townprt_code = ? and patta_type_code = ? and patta_no= ? and pdar_id =?";

                    $sql="select cp.pdar_id,cp.pdar_name,cp.pdar_father,cdp.dag_no from 
                      (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where )
                      as cp 
                      join (select pdar_id,dag_no from chitha_dag_pattadar where $where) as cdp on cp.pdar_id = cdp.pdar_id ";

                    $dag_list= $this->db->query($sql, array(
                      $data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code,
                       $data->lot_no, $data->vill_townprt_code, $data->patta_type_code,trim($data->patta_no),$data->pdar_id,$data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code,
                       $data->lot_no, $data->vill_townprt_code, $data->patta_type_code,trim($data->patta_no),$data->pdar_id
                    ))->result();

                    
                    //var_dump($dag_list);exit;

                    foreach ($dag_list as $key => $value) {

                        $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$data->vill_townprt_code,$value->dag_no);

                       if($block_status==true){

                           $this->session->set_flashdata('message', "#ERROR2266: Modification Entry cannot be passed for the given Dag as it is in Property chain!!");
                           redirect(base_url() . "index.php/home");
                           return;
                       }
                        // code...
                    }

                }

               $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$data->vill_townprt_code,$data->dag_no);

               if($block_status==true){

                   $this->session->set_flashdata('message', "#ERROR2279: Modification Entry cannot be passed for the given Dag as it is in Property chain!!");
                   redirect(base_url() . "index.php/home");
                   return;
               }

            }



            $sql_jama_side = "
                SELECT MAX(CAST(pdar_id AS int)) + 1 AS c
                FROM jama_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND mouza_pargona_code = ?
                AND lot_no = ?
                AND vill_townprt_code = ?
                AND patta_type_code = ?
                AND TRIM(patta_no) = ?
            ";

            $count_jama = $this->db->query($sql_jama_side, [
                $data->dist_code,
                $data->subdiv_code,
                $data->cir_code,
                $data->mouza_pargona_code,
                $data->lot_no,
                $data->vill_townprt_code,
                $data->patta_type_code,
                $data->patta_no
            ])->row()->c;



            $sql_chitha_side = "
                SELECT MAX(CAST(pdar_id AS int)) + 1 AS c
                FROM chitha_dag_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND mouza_pargona_code = ?
                AND lot_no = ?
                AND vill_townprt_code = ?
                AND patta_type_code = ?
                AND TRIM(patta_no) = ?
            ";

            $count_chitha = $this->db->query($sql_chitha_side, [
                $data->dist_code,
                $data->subdiv_code,
                $data->cir_code,
                $data->mouza_pargona_code,
                $data->lot_no,
                $data->vill_townprt_code,
                $data->patta_type_code,
                $data->patta_no
            ])->row()->c;

            
            if($count_jama > $count_chitha){
                $count = $count_jama;
            } else {
                $count = $count_chitha;
            }
            
            if ($count == null) {
                $count = $count+1;
            }
            
            $check = $data->action;
            
            if ($check == 0) {
                /********** this is foradding new pattadar name **************/
                $rmk = $data->pdar_name . " ( " . $data->pdar_father . " ) নাম অন্তৰ্ভুক্ত কৰা হল  | ";
                $data->pdar_id = $count;
                $dag = $data->dag_no;
                $flag = $data->p_flag;
                $entry_date = $data->entry_date;
                unset($data->action);
                unset($data->id);
                unset($data->co_updated_date);
                unset($data->status);
                unset($data->co_code);
                unset($data->attachment);
                unset($data->dag_no);
                unset($data->co_confirmation);
                unset($data->pdar_old_name);
                unset($data->pdar_old_father);
                unset($data->lm_comment);
                unset($data->cluster_key);
                //var_dump($data);
                $this->db->insert('jama_pattadar', $data);
                if($this->db->affected_rows()!=1){
                    log_message('error','JAMAEDITPATTADAR0003'.$this->db->last_query());
                    $this->db->trans_rollback();
                    redirect('JamaEditEntry/editpattadar');
                }
                unset($data->entry_date);
                unset($data->entry_mode);
                $dag_por_b = $data->pdar_land_b;
                $dag_por_k = $data->pdar_land_k;
                $dag_por_lc = $data->pdar_land_lc;
                $dag_por_g = $data->pdar_land_g;
                unset($data->pdar_land_b);
                unset($data->pdar_land_k);
                unset($data->pdar_land_lc);
                unset($data->pdar_land_g);
                unset($data->pdar_land_kr);
                unset($data->pdar_land_acre);
                unset($data->pdar_land_revenue);
                unset($data->pdar_land_localtax);
                unset($data->p_flag);
                $data->date_entry = date('Y-m-m H:i:s');
                $data->operation = 'M';
                $data->jama_yn = 'n';
                //var_dump($data);
                // $this->db->insert('chitha_pattadar', $data);
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                if($this->db->affected_rows()!=1){
                    log_message('error','JAMAEDITPATTADAR0004'.$this->db->last_query());
                    $this->db->trans_rollback();
                    redirect('JamaEditEntry/editpattadar');
                }
                $data->p_flag = $flag;
                unset($data->pdar_name);
                unset($data->pdar_father);
                unset($data->pdar_add1);
                unset($data->pdar_add2);
                unset($data->new_pdar_name);
                unset($data->pdar_name_eng);
                unset($data->pdar_guard_eng);
                unset($data->mask_id);
                unset($data->pdar_occupation);
                unset($data->pdar_caste);
                unset($data->dob);
                $data->dag_por_b = $dag_por_b;
                $data->dag_por_k = $dag_por_k;
                $data->dag_por_lc = $dag_por_lc;
                $data->dag_por_g = $dag_por_g;
                $dag_array = explode(',', $dag);
                foreach ($dag_array as $key => $no) {
                    $data->dag_no = $no;
                    //var_dump($data);
                    // $this->db->insert('chitha_dag_pattadar', $data);
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$data);
                    if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0005'.$this->db->last_query());
                        $this->db->trans_rollback();
                        redirect('JamaEditEntry/editpattadar');
                    }
                }
            } elseif (($check == 2) or ( $check == 3)) {
                /********** this is for strike out and unstike out pattadar name **************/
                if ($check == 2) {
                    $flag = 1;
                    $rmk = $data->pdar_name . " নাম কৰ্তন  কৰা হল  |";
                } else {
                    $flag = 0;
                    $rmk = $data->pdar_name . " নাম বাহাল ৰখা হল  |";
                }
                $upjamadag = array(
                    'p_flag' => $flag,
                    'entry_date' => $data->entry_date,
                    'user_code' => $user_code
                );
                /********* Updating Jamabandi ***********/
                $this->db->where('dist_code', $data->dist_code);
                $this->db->where('subdiv_code', $data->subdiv_code);
                $this->db->where('cir_code', $data->cir_code);
                $this->db->where('mouza_pargona_code', $data->mouza_pargona_code);
                $this->db->where('lot_no', $data->lot_no);
                $this->db->where('vill_townprt_code', $data->vill_townprt_code);
                $this->db->where('patta_type_code', $data->patta_type_code);
                $this->db->where('patta_no', $data->patta_no);
                $this->db->where('pdar_id', $data->pdar_id);
                $this->db->update('jama_pattadar', $upjamadag);
                if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0006'.$this->db->last_query());
                        $this->db->trans_rollback();
                        redirect('JamaEditEntry/editpattadar');
                }
                /********* Updating Chitha***********/
                $sql = "
                    SELECT *
                    FROM edit_jama_pattadar
                    WHERE entry_mode = 'C'
                    AND cluster_key = ?
                ";
                $datac = $this->db->query($sql, [$data->cluster_key])->result();

                
                foreach($datac as $chitha){
                    $upjamadag = array(
                        'p_flag' => $flag,
                        'date_entry' => $chitha->entry_date,
                        'user_code' => $user_code,
                    );
                    if ($chitha->dag_no) {
                        // $this->db->where('dist_code', $chitha->dist_code);
                        // $this->db->where('subdiv_code', $chitha->subdiv_code);
                        // $this->db->where('cir_code', $chitha->cir_code);
                        // $this->db->where('mouza_pargona_code', $chitha->mouza_pargona_code);
                        // $this->db->where('lot_no', $chitha->lot_no);
                        // $this->db->where('vill_townprt_code', $chitha->vill_townprt_code);
                        // $this->db->where('patta_type_code', $chitha->patta_type_code);
                        // $this->db->where('patta_no', $chitha->patta_no);
                        // $this->db->where('pdar_id', $chitha->pdar_id);
                        // $this->db->where('dag_no', $chitha->dag_no);
                        // $this->db->update('chitha_dag_pattadar', $upjamadag);
                        $table = 'chitha_dag_pattadar';
                        $params = $upjamadag;
                        $where = [
                            'dist_code'          => $chitha->dist_code,
                            'subdiv_code'        => $chitha->subdiv_code,
                            'cir_code'           => $chitha->cir_code,
                            'mouza_pargona_code' => $chitha->mouza_pargona_code,
                            'lot_no'             => $chitha->lot_no,
                            'vill_townprt_code'  => $chitha->vill_townprt_code,
                            'patta_type_code'    => $chitha->patta_type_code,
                            'patta_no'           => $chitha->patta_no,
                            'pdar_id'            => $chitha->pdar_id,
                            'dag_no'             => $chitha->dag_no,
                        ];

                        // Call model function
                        $this->Chitha_basic_model->update_table($table, $params, $where);

                        if($this->db->affected_rows()!=1){
                                log_message('error','JAMAEDITPATTADAR0007'.$this->db->last_query());
                                $this->db->trans_rollback();
                                redirect('JamaEditEntry/editpattadar');
                        }
                    }
                }
                
            } elseif ($check == 4) {
                /********** this is for modifiying pattadar name **************/
                $rmk = $data->pdar_old_name . " ( " . $data->pdar_old_father . " ) নাম সংশোধন কৰি ".$data->pdar_name . " ( " . $data->pdar_father." ) কৰা হল  | ";
                /********* Updating Jamabandi ***********/
                $upjamadag = array(
                    'pdar_name' => $data->pdar_name,
                    'pdar_father' => $data->pdar_father,
                    'entry_date' => $data->entry_date,
                    'user_code' => $user_code
                );
                $this->db->where('dist_code', $data->dist_code);
                $this->db->where('subdiv_code', $data->subdiv_code);
                $this->db->where('cir_code', $data->cir_code);
                $this->db->where('mouza_pargona_code', $data->mouza_pargona_code);
                $this->db->where('lot_no', $data->lot_no);
                $this->db->where('vill_townprt_code', $data->vill_townprt_code);
                $this->db->where('patta_type_code', $data->patta_type_code);
                $this->db->where('patta_no', $data->patta_no);
                $this->db->where('pdar_id', $data->pdar_id);
                $this->db->update('jama_pattadar', $upjamadag);
                if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0008'.$this->db->last_query());
                        $this->db->trans_rollback();
                        redirect('JamaEditEntry/editpattadar');
                }
                /********* Updating Chitha***********/
                $sql = "
                    SELECT *
                    FROM edit_jama_pattadar
                    WHERE entry_mode = 'C'
                    AND cluster_key = ?
                ";
                $datac = $this->db->query($sql, [$data->cluster_key])->result();

                
                foreach($datac as $chitha){
                    // $this->db->where('dist_code', $chitha->dist_code);
                    // $this->db->where('subdiv_code', $chitha->subdiv_code);
                    // $this->db->where('cir_code', $chitha->cir_code);
                    // $this->db->where('mouza_pargona_code', $chitha->mouza_pargona_code);
                    // $this->db->where('lot_no', $chitha->lot_no);
                    // $this->db->where('vill_townprt_code', $chitha->vill_townprt_code);
                    // $this->db->where('patta_type_code', $chitha->patta_type_code);
                    // $this->db->where('patta_no', $chitha->patta_no);
                    // $this->db->where('pdar_id', $chitha->pdar_id);
                    // unset($upjamadag['entry_date']);
                    // $this->db->update('chitha_pattadar', $upjamadag);
                    $table = 'chitha_pattadar';
                    unset($upjamadag['entry_date']);
                    $params = $upjamadag;
                    $where = [
                        'dist_code'           => $chitha->dist_code,
                        'subdiv_code'         => $chitha->subdiv_code,
                        'cir_code'            => $chitha->cir_code,
                        'mouza_pargona_code'  => $chitha->mouza_pargona_code,
                        'lot_no'              => $chitha->lot_no,
                        'vill_townprt_code'   => $chitha->vill_townprt_code,
                        'patta_type_code'     => $chitha->patta_type_code,
                        'patta_no'            => $chitha->patta_no,
                        'pdar_id'             => $chitha->pdar_id,
                    ];
                    $this->Chitha_basic_model->update_table($table, $params, $where);
                    if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0009'.$this->db->last_query());
                        $this->db->trans_rollback();
                        redirect('JamaEditEntry/editpattadar');
                    }
                }
                
            } else {
                /********** this is for deleting pattadar name **************/
                $rmk = $data->pdar_name . " ( " . $data->pdar_father . " ) নাম নহোৱা কৰা হল |";
                $this->db->where('dist_code', $data->dist_code);
                $this->db->where('subdiv_code', $data->subdiv_code);
                $this->db->where('cir_code', $data->cir_code);
                $this->db->where('mouza_pargona_code', $data->mouza_pargona_code);
                $this->db->where('lot_no', $data->lot_no);
                $this->db->where('vill_townprt_code', $data->vill_townprt_code);
                $this->db->where('patta_type_code', $data->patta_type_code);
                $this->db->where('patta_no', $data->patta_no);
                $this->db->where('pdar_id', $data->pdar_id);
                $this->db->delete('jama_pattadar');
                if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0010'.$this->db->last_query());
                        $this->db->trans_rollback();
                        redirect('JamaEditEntry/editpattadar');
                }
            }
            if ($check == 0) {
                $data->entry_date = $entry_date;
            }
            $lm = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->user_code);
            $lm_note = "( **** টোকা :-  ভূমিলেখ্য সহায়ক --- " . $lm->lm_name . " Dated :-" . date('Y-m-d', strtotime($data->entry_date));
            $lm_note = $lm_note . "&nbsp;&nbsp; " . $rmk;
            $coname = $this->utilityclass->getSelectedCOName($data->dist_code, $data->subdiv_code, $data->cir_code, $user_code);
            $final_report = $lm_note . $final_report . "<br> চক্ৰ বিষয়া :-" . $coname->username . " Dated: " . date('Y-m-d') . " )";
            $udata = array('co_code' => $user_code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'F', 'co_confirmation' => $final_report);
            // if(!empty($data->cluster_key)){
            //      $this->db->where('cluster_key', $data->cluster_key);
            // } else {
            //     $this->db->where('id', $id);
            // }
            $this->db->where('id', $id);
            $this->db->update('edit_jama_pattadar', $udata);
            if($this->db->affected_rows()!=1){
                log_message('error','JAMAEDITPATTADAR00011'.$this->db->last_query());
                $this->db->trans_rollback();
                redirect('JamaEditEntry/editpattadar');
            }
            $val = $this->remarksAdd($id, 1);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                if (isset($datac)) {
                    foreach ($datac as $chitha) {
                        if($chitha->dag_no !== null && $chitha->dag_no !== ""){
                            $this->AgriStackCaseHistory->CreateLog($data->dist_code,$chitha->id,json_encode($chitha));
                        }
                    }
                }
                
            }
            redirect('JamaEditEntry/editpattadar');
        } else {
            redirect('JamaEditEntry/editpattadar');
        }
    }

    function removepattadar() {
		 $db=  $this->session->userdata('db');
        $id = $_GET['sl'];
        $md5 = $_GET['id'];
        $user_code = $this->session->userdata('user_desig_code');
        if (($md5 == md5($id)) and $user_code == 'CO') {
            $user_code = $this->session->userdata('user_code');
            $udata = array('co_code' => $user_code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'R');
            $this->db->where('id', $id);
            $this->db->update('edit_jama_pattadar', $udata);
            redirect('JamaEditEntry/editpattadar');
        } else {
            redirect('JamaEditEntry/editpattadar');
        }
    }

    function rejectdag() {
		 $db=  $this->session->userdata('db');
        $id = $_GET['sl'];
        $md5 = $_GET['id'];
        $user_code = $this->session->userdata('user_desig_code');
        if (($md5 == md5($id)) and $user_code == 'CO') {
            $user_code = $this->session->userdata('user_code');
            $udata = array('co_code' => $user_code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'R');
            $this->db->where('id', $id);
            $this->db->update('edit_jama_dag', $udata);
            redirect('JamaEditEntry/dageditlist');
        } else {
            redirect('JamaEditEntry/dageditlist');
        }
    }

    function updateremarkorder() {
		 $db=  $this->session->userdata('db');
        $id = $this->input->post('bookId');
        $final_report = addslashes($this->input->post('final_report'));
        $user_code = $this->session->userdata('user_desig_code');
        if ($user_code == 'CO') {
            $user_code = $this->session->userdata('user_code');
            //////////////////
            $q = "Select * from    edit_jama_remark where id=$id";
            $data = $this->db->query($q)->row();

            $lm = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->user_code);
            $lm_note = "( **** টোকা :-  ভূমিলেখ্য সহায়ক --- " . $lm->lm_name . " Dated :-" . date('Y-m-d', strtotime($data->entry_date));
            $coname = $this->utilityclass->getSelectedCOName($data->dist_code, $data->subdiv_code, $data->cir_code, $user_code);
            $final_report = $lm_note . $final_report . "<br> চক্ৰ বিষয়া :-" . $coname->username . " Dated: " . date('Y-m-d') . " )";

            $sql = "Select max(rmk_line_no)+1 as c from    jama_remark WHERE
 dist_code='$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code='$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and 
 vill_townprt_code='$data->vill_townprt_code' and patta_type_code='$data->patta_type_code' and TRIM(patta_no)='$data->patta_no'";
            $count = $this->db->query($sql)->row()->c;
            if ($count == null) {
                $count = 1;
            }
            $check = $data->fresh_old;
            if ($check == 1) {
                unset($data->rmk_line_no);
                unset($data->fresh_old);
                unset($data->id);
                unset($data->co_updated_date);
                unset($data->status);
                unset($data->co_code);
                unset($data->old_remark);
                unset($data->attachment);
                unset($data->co_confirmation);
                unset($data->lm_comment);
                $data->rmk_line_no = $count;
                $data->user_code = $user_code;
                $data->entry_date = date('Y-m-d H:i:s');
                //var_dump($data);
                echo $this->db->insert('jama_remark', $data);
            } elseif ($check == 2) {

                $add = "<br>" . $lm_note . " প্রতিবেদন মৰ্মে হাতৰ জমাবন্দীৰ তথ্যৰ ভিত্তিত উপৰোক্ত মন্তব্যৰ সংশোধন  কৰা হ'ল | চক্ৰ বিষয়া :-" . $coname->username . " Dated: " . date('Y-m-d') . " )";
                $upremark = array(
                    'remark' => $data->remark . $add,
                    'user_code' => $user_code,
                    'entry_date' => date('Y-m-d'),
                );
                $this->db->where('dist_code', $data->dist_code);
                $this->db->where('subdiv_code', $data->subdiv_code);
                $this->db->where('cir_code', $data->cir_code);
                $this->db->where('mouza_pargona_code', $data->mouza_pargona_code);
                $this->db->where('lot_no', $data->lot_no);
                $this->db->where('vill_townprt_code', $data->vill_townprt_code);
                $this->db->where('patta_type_code', $data->patta_type_code);
                $this->db->where('patta_no', $data->patta_no);
                $this->db->where('rmk_line_no', $data->rmk_line_no);
                $this->db->update('jama_remark', $upremark);
            }
            /////////////////
            //$coname=$this->utilityclass->getSelectedCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$user_code);
            //$final_report=$final_report."<br> চক্ৰ বিষয়া :-".$coname->username;
            ////////////////
            $udata = array('co_code' => $user_code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'F', 'co_confirmation' => $final_report);
            $this->db->where('id', $id);
            $this->db->update('edit_jama_remark', $udata);
            if ($check == 1) {
                $val = $this->remarksAdd($id, 2);
            }
            redirect('JamaEditEntry/editremark');
        } else {
            redirect('JamaEditEntry/editremark');
        }
    }

    function rejectrmkorder() {
		 $db=  $this->session->userdata('db');
        $id = $_GET['sl'];
        $md5 = $_GET['id'];
        $user_code = $this->session->userdata('user_desig_code');
        if (($md5 == md5($id)) and $user_code == 'CO') {
            $user_code = $this->session->userdata('user_code');
            $udata = array('co_code' => $user_code, 'co_updated_date' => date('Y-m-d H:i:s'), 'status' => 'R');
            $this->db->where('id', $id);
            $this->db->update('edit_jama_remark', $udata);
            redirect('JamaEditEntry/editremark');
        } else {
            redirect('JamaEditEntry/editremark');
        }
    }

    function remarksAdd($id, $tp) {
		 $db=  $this->session->userdata('db');
        if ($tp == 3) {
            $q = "Select * from    edit_jama_dag where id=$id";
        } elseif ($tp == 2) {
            $q = "Select * from    edit_jama_remark where id=$id";
        } elseif ($tp == 1) {
            $q = "Select * from    edit_jama_pattadar where id=$id";
        }
        $data = $this->db->query($q)->row();
        $sql = "Select max(rmk_line_no)+1 as c from    jama_remark WHERE
 dist_code='$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code='$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and 
 vill_townprt_code='$data->vill_townprt_code' and patta_type_code='$data->patta_type_code' and TRIM(patta_no)='$data->patta_no'";
        $count = $this->db->query($sql)->row()->c;
        if ($count == null) {
            $count = 1;
        }
        $array = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'patta_type_code' => $data->patta_type_code,
            'patta_no' => $data->patta_no,
            'rmk_line_no' => $count,
            'remark' => $data->co_confirmation,
            'user_code' => $this->session->userdata('user_code'),
            'entry_date' => date('Y-m-m H:i:s'),
            'entry_mode' => 'P'
        );
        //var_dump($array);
        $this->db->insert('jama_remark', $array);
        $val = $this->db->affected_rows();
        return $val;
    }

    function getPdarDag($id) {
		 $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $sql = "select dag_no from    chitha_dag_pattadar where pdar_id='$id' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and 
 vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)='$patta_no'";
        $data = $this->db->query($sql)->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag' => trim($object->dag_no));
        }
        echo json_encode($json);
    }
    
    //********************* done by sarathi **********************//
    function modifypdarbothways() {        
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $user_code = $this->session->userdata('user_code');
            $note_1 = $this->input->post('note_1');
            $note_2 = $this->input->post('note_2');
            $pdar_name = $this->input->post('pname');
            $pdar_father = $this->input->post('gurdian');
            $pdar_old_name = $this->input->post('oldpdar');
            $pdar_old_father = $this->input->post('oldguard');
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note_1."".$pdar_old_name." ( ".$pdar_old_father." ) পৰা ".$pdar_name." ( ".$pdar_father." ) ".$note_2."<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];

            $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
           // var_dump($ext);exit;

            $FILES_TYPE_VALIDATION_ARR = explode('|', $config['allowed_types']);
            $checkFileExt = false;
            foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }

            if(!$checkFileExt){
                 $this->session->set_flashdata('message', "Wrong file type. Kindly upload a file with correct format !!");
            redirect(base_url() . 'index.php/jamaeditentry/modifypdarbothways');
            }
            else
            {

            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/modifypdarbothways');
            }
            }
	
            $fname = date("dmyhmis");
            $get_cluster_sql = "
                SELECT COUNT(id) AS id
                FROM edit_jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND p.cluster_key IS NOT NULL
            ";
            $get_cluster_id = $this->db->query($get_cluster_sql, [
                $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $vill_townprt_code, $lot_no
            ])->row()->id;
            $cluster_id = "MD/" . $fname . "/" . ($get_cluster_id + 1);
            $jamabandi_pdar_id = $this->input->post('pdar');
            $q = "
                SELECT *
                FROM jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.pdar_id = ?
            ";
            $data = $this->db->query($q, [
                $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $vill_townprt_code, $lot_no,
                $patta_no, $patta_type_code, $jamabandi_pdar_id
            ])->row();

            unset($data->pdar_land_n);
            unset($data->pdar_land_s);
            unset($data->pdar_land_e);
            unset($data->pdar_land_w);
            unset($data->pdar_land_map);
            unset($data->pdar_sl_no);
            unset($data->pdar_gender);
            unset($data->pdar_minor_yn);
            unset($data->pdar_minor_dob);
            unset($data->pdar_mother);
            unset($data->pdar_aadharno);
            unset($data->pdar_mobile);
            unset($data->pdar_nrcno);
            unset($data->pdar_pan_no);
            unset($data->pdar_citizen_no);
            unset($data->pdar_thumb_imp);
            unset($data->pdar_add3);
            unset($data->pdar_photo);
            unset($data->created_on);
            unset($data->updated_on);
            unset($data->marital_status);
            unset($data->serial_no);
	        unset($data->dag_no_int);
            $data->pdar_name = $this->input->post('pname');
            $data->pdar_father = $this->input->post('gurdian');
            $data->pdar_old_name = $this->input->post('oldpdar');
            $data->pdar_old_father = $this->input->post('oldguard');
            $data->action = 4;
            $data->dag_no = '';
            $data->status = 'P';
            $data->user_code = $this->session->userdata('user_code');
            $data->entry_date = date('Y-m-d H:i:s');
            $data->entry_mode = 'J'; // Updates in Jamabandi
            $data->attachment = $file_name;
            $data->lm_comment = $lm_note;
            $data->cluster_key = $cluster_id;
            unset($data->not_consistent);
            //var_dump($data);
            $this->db->insert('edit_jama_pattadar', $data);
            
            $dag_dag_no = $this->input->post('dag_dag_no');
            $dag_pdar_id = $this->input->post('dag_pdar_id');
            
            $count = count($dag_dag_no);
            
            for ($i = 0; $i < $count; $i++) {
                    $dag_no = $dag_dag_no[$i];
                    $pdar_id = $dag_pdar_id[$dag_no];
                    
                    $sql = "
                        SELECT *
                        FROM chitha_pattadar p
                        JOIN chitha_dag_pattadar d 
                            ON p.dist_code = d.dist_code
                        AND p.subdiv_code = d.subdiv_code
                        AND p.cir_code = d.cir_code
                        AND p.lot_no = d.lot_no
                        AND p.vill_townprt_code = d.vill_townprt_code
                        AND p.mouza_pargona_code = d.mouza_pargona_code
                        AND p.pdar_id = d.pdar_id
                        AND TRIM(p.patta_no) = TRIM(d.patta_no)
                        AND p.patta_type_code = d.patta_type_code
                        WHERE d.dist_code = ?
                        AND d.subdiv_code = ?
                        AND d.cir_code = ?
                        AND d.mouza_pargona_code = ?
                        AND d.vill_townprt_code = ?
                        AND d.lot_no = ?
                        AND TRIM(d.patta_no) = TRIM(?)
                        AND d.patta_type_code = ?
                        AND d.dag_no = ?
                        AND p.pdar_id = ?
                    ";

                    $data = $this->db->query($sql, [
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $vill_townprt_code,
                        $lot_no,
                        $patta_no,
                        $patta_type_code,
                        $dag_no,
                        $pdar_id
                    ])->row();          
                    unset($data->pdar_land_n);
                    unset($data->pdar_land_s);
                    unset($data->pdar_land_e);
                    unset($data->pdar_land_w);
                    unset($data->pdar_land_map);
                    unset($data->pdar_sl_no);
                    unset($data->pdar_gender);
                    unset($data->pdar_minor_yn);
                    unset($data->pdar_minor_dob);
                    unset($data->pdar_mother);
                    unset($data->pdar_aadharno);
                    unset($data->pdar_mobile);
                    unset($data->pdar_nrcno);
                    unset($data->pdar_pan_no);
                    unset($data->pdar_citizen_no);
                    unset($data->pdar_thumb_imp);
                    unset($data->pdar_add3);
                    unset($data->pdar_photo);
                    unset($data->date_entry);
                    unset($data->operation);
                    unset($data->jama_yn);
                    unset($data->pdar_guard_reln);
                    unset($data->f1_case_no);
                    unset($data->f2_case_no);
                    unset($data->o1_case_no);
                    unset($data->o2_case_no);
                    unset($data->dag_por_b);
                    unset($data->dag_por_k);
                    unset($data->dag_por_lc);
                    unset($data->dag_por_g);
                    unset($data->dag_por_kr);
                    unset($data->uuid);
                    unset($data->pdar_name_eng);
                    unset($data->pdar_guard_eng);
                    unset($data->created_on);
                    unset($data->updated_on);
                    unset($data->marital_status);
                    unset($data->serial_no);
		            unset($data->dag_no_int);
                    $data->pdar_name = $this->input->post('pname');
                    $data->pdar_father = $this->input->post('gurdian');
                    $data->pdar_old_name = $this->input->post('oldpdar');
                    $data->pdar_old_father = $this->input->post('oldguard');
                    $data->action = 4;
                    $data->dag_no = $dag_no;
                    $data->status = 'P';
                    $data->user_code = $this->session->userdata('user_code');
                    $data->entry_date = date('Y-m-d H:i:s');
                    $data->entry_mode = 'C';
                    $data->attachment = $file_name;
                    $data->lm_comment = $lm_note;
                    $data->cluster_key = $cluster_id;
                    unset($data->not_consistent);
                    //var_dump($data);
                    $this->db->insert('edit_jama_pattadar', $data);
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $user_code = $this->session->userdata('user_code');

            $jama_query = "
                SELECT *
                FROM jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                ORDER BY CAST(pdar_id AS INT)
            ";
            $data['pattadar'] = $this->db->query($jama_query, [
                $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $vill_townprt_code,
                $lot_no, $patta_no, $patta_type_code
            ])->result();
            $jama_dag_query = "
                SELECT *
                FROM jama_dag p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                ORDER BY p.dag_no
            ";

            $assoc_dag = $this->db->query($jama_dag_query, [
                $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $vill_townprt_code,
                $lot_no, $patta_no, $patta_type_code
            ])->result();
            $result = [];

            foreach ($assoc_dag as $dag_details) {
                $chitha_query = "
                    SELECT p.pdar_id, p.pdar_name, p.pdar_father
                    FROM chitha_pattadar p
                    JOIN chitha_dag_pattadar d
                        ON p.dist_code = d.dist_code
                        AND p.subdiv_code = d.subdiv_code
                        AND p.cir_code = d.cir_code
                        AND p.lot_no = d.lot_no
                        AND p.vill_townprt_code = d.vill_townprt_code
                        AND p.mouza_pargona_code = d.mouza_pargona_code
                        AND p.pdar_id = d.pdar_id
                        AND TRIM(p.patta_no) = TRIM(d.patta_no)
                        AND p.patta_type_code = d.patta_type_code
                    WHERE d.dist_code = ?
                    AND d.subdiv_code = ?
                    AND d.cir_code = ?
                    AND d.mouza_pargona_code = ?
                    AND d.vill_townprt_code = ?
                    AND d.lot_no = ?
                    AND d.dag_no = ?
                    AND TRIM(d.patta_no) = TRIM(?)
                    AND d.patta_type_code = ?
                ";

                $result[$dag_details->dag_no] = $this->db->query($chitha_query, [
                    $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $vill_townprt_code,
                    $lot_no, $dag_details->dag_no,
                    $patta_no, $patta_type_code
                ])->result();
            }

            $data['pattadar_dag'] = $result;
            $sql_exist = "
                SELECT *
                FROM edit_jama_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND patta_no = ?
                AND status = 'P'
                AND user_code = ?
                AND action = '4'
                AND (entry_mode = 'O' OR entry_mode = 'J')
            ";

            $data['existname'] = $this->db->query($sql_exist, [
                $dist_code, $subdiv_code, $cir_code,
                $patta_no, $user_code
            ])->result();

            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/modifypattadarlistSara', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/modifypattadarlistSara';
            $this->load->view('layouts/main',$data);
        }
    
    }

    public function deopdarstrikebothways() {

		 $db=  $this->session->userdata('db');
         if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $user_code = $this->session->userdata('user_code');
            $note = addslashes($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $dir = ADD_PATTADAR_BASE_DIR;
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = ADD_PATTADAR_BASE_DIR . UPLOAD_SEPARATOR;
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
           // var_dump($ext);exit;

            $FILES_TYPE_VALIDATION_ARR = explode('|', $config['allowed_types']);
            $checkFileExt = false;
            foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }

            if(!$checkFileExt){
                 $this->session->set_flashdata('message', "Wrong file type. Kindly upload a file with correct format !!");
            redirect(base_url() . 'index.php/jamaeditentry/deopdarstrikebothways');
            }
            else
            {

            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/deopdarstrikebothways');
            }
            }
	
            $fname = date("dmyhmis");
            $get_cluster_sql = "
                SELECT COUNT(id) AS id
                FROM edit_jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
            ";
            $get_cluster_id = $this->db->query($get_cluster_sql, [
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $vill_townprt_code,
                $lot_no
            ])->row()->id;
            $cluster_id = "MD/" . $fname . "/" . ($get_cluster_id + 1);
            $jamabandi_pdar_id = $this->input->post('pdar');
            $q = "
                SELECT *
                FROM jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.pdar_id = ?
            ";
            $data = $this->db->query($q, [
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $vill_townprt_code,
                $lot_no,
                $patta_no,
                $patta_type_code,
                $jamabandi_pdar_id
            ])->row();
            unset($data->pdar_land_n);
            unset($data->pdar_land_s);
            unset($data->pdar_land_e);
            unset($data->pdar_land_w);
            unset($data->pdar_land_map);
            unset($data->pdar_sl_no);
            unset($data->pdar_gender);
            unset($data->pdar_minor_yn);
            unset($data->pdar_minor_dob);
            unset($data->pdar_mother);
            unset($data->pdar_aadharno);
            unset($data->pdar_mobile);
            unset($data->pdar_nrcno);
            unset($data->pdar_pan_no);
            unset($data->pdar_citizen_no);
            unset($data->pdar_thumb_imp);
            unset($data->pdar_add3);
            unset($data->pdar_photo);
            $data->action = 2;
            $data->dag_no = '';
            $data->status = 'P';
            $data->user_code = $this->session->userdata('user_code');
            $data->entry_date = date('Y-m-d H:i:s');
            $data->entry_mode = 'J'; // Updates in Jamabandi
            $data->attachment = $file_name;
            $data->lm_comment = $lm_note;
            unset($data->not_consistent);
            unset($data->uuid);
            unset($data->pdar_name_eng);
            unset($data->pdar_guard_eng);
            unset($data->created_on);
            unset($data->updated_on);
            unset($data->marital_status);
            unset($data->serial_no);
	        unset($data->dag_no_int);
            $data->cluster_key = $cluster_id;
            //var_dump($data);
            $this->db->insert('edit_jama_pattadar', $data);
            if($this->db->affected_rows()!=1){
                log_message('error','JAMAEDITPATTADAR001'.$this->db->last_query());
            }
            
            $dag_dag_no = $this->input->post('dag_dag_no');
            $dag_pdar_id = $this->input->post('dag_pdar_id');
            
            $count = count($dag_dag_no);
            
            for ($i = 0; $i < $count; $i++) {
                    $dag_no = $dag_dag_no[$i];
                    $pdar_id = $dag_pdar_id[$dag_no];
                    
                    $sql = "
                            SELECT *
                            FROM chitha_pattadar p
                            JOIN chitha_dag_pattadar d
                            ON p.dist_code = d.dist_code
                            AND p.subdiv_code = d.subdiv_code
                            AND p.cir_code = d.cir_code
                            AND p.lot_no = d.lot_no
                            AND p.vill_townprt_code = d.vill_townprt_code
                            AND p.mouza_pargona_code = d.mouza_pargona_code
                            AND p.pdar_id = d.pdar_id
                            AND TRIM(p.patta_no) = TRIM(d.patta_no)
                            AND p.patta_type_code = d.patta_type_code
                            WHERE d.dist_code = ?
                            AND d.subdiv_code = ?
                            AND d.cir_code = ?
                            AND d.mouza_pargona_code = ?
                            AND d.vill_townprt_code = ?
                            AND d.lot_no = ?
                            AND TRIM(d.patta_no) = TRIM(?)
                            AND d.patta_type_code = ?
                            AND d.dag_no = ?
                            AND p.pdar_id = ?
                        ";

                        $data = $this->db->query($sql, [
                            $dist_code,
                            $subdiv_code,
                            $cir_code,
                            $mouza_pargona_code,
                            $vill_townprt_code,
                            $lot_no,
                            $patta_no,
                            $patta_type_code,
                            $dag_no,
                            $pdar_id
                        ])->row();

                    
                    unset($data->pdar_land_n);
                    unset($data->pdar_land_s);
                    unset($data->pdar_land_e);
                    unset($data->pdar_land_w);
                    unset($data->pdar_land_map);
                    unset($data->pdar_sl_no);
                    unset($data->pdar_gender);
                    unset($data->pdar_minor_yn);
                    unset($data->pdar_minor_dob);
                    unset($data->pdar_mother);
                    unset($data->pdar_aadharno);
                    unset($data->pdar_mobile);
                    unset($data->pdar_nrcno);
                    unset($data->pdar_pan_no);
                    unset($data->pdar_citizen_no);
                    unset($data->pdar_thumb_imp);
                    unset($data->pdar_add3);
                    unset($data->pdar_photo);
                    unset($data->date_entry);
                    unset($data->operation);
                    unset($data->jama_yn);
                    unset($data->pdar_guard_reln);
                    unset($data->f1_case_no);
                    unset($data->f2_case_no);
                    unset($data->o1_case_no);
                    unset($data->o2_case_no);
                    unset($data->dag_por_b);
                    unset($data->dag_por_k);
                    unset($data->dag_por_lc);
                    unset($data->dag_por_g);
                    unset($data->dag_por_kr);
                    
                    $data->action = 2;
                    $data->dag_no = $dag_no;
                    $data->status = 'P';
                    $data->user_code = $this->session->userdata('user_code');
                    $data->entry_date = date('Y-m-d H:i:s');
                    $data->entry_mode = 'C';
                    $data->attachment = $file_name;
                    $data->lm_comment = $lm_note;
                    $data->cluster_key = $cluster_id;
                    unset($data->not_consistent);
                    unset($data->uuid);
                    unset($data->pdar_name_eng);
                    unset($data->pdar_guard_eng);
                    unset($data->created_on);
                    unset($data->updated_on);
                    unset($data->marital_status);
                    unset($data->serial_no);
		            unset($data->dag_no_int);
                    //var_dump($data);
                    $this->db->insert('edit_jama_pattadar', $data);
                    if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR001'.$this->db->last_query());
                    }
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            $sql1 = "
                        SELECT *
                        FROM jama_pattadar p
                        WHERE p.dist_code = ?
                        AND p.subdiv_code = ?
                        AND p.cir_code = ?
                        AND p.mouza_pargona_code = ?
                        AND p.vill_townprt_code = ?
                        AND p.lot_no = ?
                        AND TRIM(p.patta_no) = ?
                        AND p.patta_type_code = ?
                        AND p.p_flag != '1'
                    ";

                    $data['pattadars'] = $this->db->query($sql1, [
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $vill_townprt_code,
                        $lot_no,
                        $patta_no,
                        $patta_type_code
                    ])->result();


                    $sql2 = "
                        SELECT *
                        FROM edit_jama_pattadar p
                        WHERE p.dist_code = ?
                        AND p.subdiv_code = ?
                        AND p.cir_code = ?
                        AND p.mouza_pargona_code = ?
                        AND p.vill_townprt_code = ?
                        AND p.lot_no = ?
                        AND TRIM(p.patta_no) = ?
                        AND p.status = 'P'
                        AND p.action = '2'
                        AND p.patta_type_code = ?
                        AND (p.entry_mode = 'O' OR p.entry_mode = 'C')
                    ";

                    $data['insert'] = $this->db->query($sql2, [
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $vill_townprt_code,
                        $lot_no,
                        $patta_no,
                        $patta_type_code
                    ])->result();

            // $this->load->view('../views/header');
            // $this->load->view('../views/JamaEditEntry/pdarstrike', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pdarstrike';
            $this->load->view('layouts/main',$data);
        }
    }

    public function deopdarustrikebothways() {
		 $db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = $this->session->userdata('patta_no');
            $patta_type_code = $this->session->userdata('patta_type_code');
            $user_code = $this->session->userdata('user_code');
            $note = addslashes($this->input->post('lm_note'));
            $data = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $lm_note = $note . "<br> ভূমিলেখ্য সহায়ক --- " . $data->lm_name;
            $dir = UPLOAD_BASE ."AddPattadar";
            if (is_dir($dir) === false) {
                mkdir($dir, 0777, true);
            }
            $config['upload_path'] = UPLOAD_BASE .'AddPattadar/';
            $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|txt';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $file_upload = $_FILES['file_upload']['name'];
            $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
           // var_dump($ext);exit;

            $FILES_TYPE_VALIDATION_ARR = explode('|', $config['allowed_types']);
            $checkFileExt = false;
            foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }

            if(!$checkFileExt){
                 $this->session->set_flashdata('message', "Wrong file type. Kindly upload a file with correct format !!");
            redirect(base_url() . 'index.php/jamaeditentry/deopdarustrikebothways');
            }
            else
            {

            if ($file_upload !== "") {
                $this->upload->do_upload('file_upload');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                redirect('/jamaeditentry/deopdarustrikebothways');
            }
            }
            
            $fname=date("dmyhmis");
            $get_cluster_sql = "
                SELECT COUNT(id) AS id
                FROM edit_jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
            ";

            $get_cluster_id = $this->db->query($get_cluster_sql, [
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $vill_townprt_code,
                $lot_no
            ])->row()->id;

            $cluster_id = "MD/" . $fname . "/" . ($get_cluster_id + 1);


            $jamabandi_pdar_id = $this->input->post('pdar');

            $q = "
                SELECT *
                FROM jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.pdar_id = ?
            ";

            $data = $this->db->query($q, [
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $vill_townprt_code,
                $lot_no,
                $patta_no,
                $patta_type_code,
                $jamabandi_pdar_id
            ])->row();

            unset($data->pdar_land_n);
            unset($data->pdar_land_s);
            unset($data->pdar_land_e);
            unset($data->pdar_land_w);
            unset($data->pdar_land_map);
            unset($data->pdar_sl_no);
            unset($data->pdar_gender);
            unset($data->pdar_minor_yn);
            unset($data->pdar_minor_dob);
            unset($data->pdar_mother);
            unset($data->pdar_aadharno);
            unset($data->pdar_mobile);
            unset($data->pdar_nrcno);
            unset($data->pdar_pan_no);
            unset($data->pdar_citizen_no);
            unset($data->pdar_thumb_imp);
            unset($data->pdar_add3);
            unset($data->pdar_photo);
            $data->action = 3;
            $data->dag_no = '';
            $data->status = 'P';
            $data->user_code = $this->session->userdata('user_code');
            $data->entry_date = date('Y-m-d H:i:s');
            $data->entry_mode = 'J'; // Updates in Jamabandi
            $data->attachment = $file_name;
            $data->lm_comment = $lm_note;
            $data->cluster_key = $cluster_id;
            unset($data->not_consistent);
            unset($data->uuid);
            unset($data->created_on);
            unset($data->updated_on);
            unset($data->marital_status);
            unset($data->serial_no);
            unset($data->dag_no_int);
            //var_dump($data);
            $this->db->insert('edit_jama_pattadar', $data);
            if($this->db->affected_rows()!=1){
                        log_message('error','JAMAEDITPATTADAR0011'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', 'Error');
                        redirect(base_url() . "index.php/home");
            }
            $dag_dag_no = $this->input->post('dag_dag_no');
            $dag_pdar_id = $this->input->post('dag_pdar_id');
            
            $count = count($dag_dag_no);
            
            for ($i = 0; $i < $count; $i++) {
                    $dag_no = $dag_dag_no[$i];
                    $pdar_id = $dag_pdar_id[$dag_no];
                    
                    $sql = "
                        SELECT *
                        FROM chitha_pattadar p
                        JOIN chitha_dag_pattadar d
                        ON p.dist_code = d.dist_code
                        AND p.subdiv_code = d.subdiv_code
                        AND p.cir_code = d.cir_code
                        AND p.lot_no = d.lot_no
                        AND p.vill_townprt_code = d.vill_townprt_code
                        AND p.mouza_pargona_code = d.mouza_pargona_code
                        AND p.pdar_id = d.pdar_id
                        AND TRIM(p.patta_no) = TRIM(d.patta_no)
                        AND p.patta_type_code = d.patta_type_code
                        WHERE d.dist_code = ?
                        AND d.subdiv_code = ?
                        AND d.cir_code = ?
                        AND d.mouza_pargona_code = ?
                        AND d.vill_townprt_code = ?
                        AND d.lot_no = ?
                        AND TRIM(d.patta_no) = TRIM(?)
                        AND d.patta_type_code = ?
                        AND d.dag_no = ?
                        AND p.pdar_id = ?
                    ";

                    $data = $this->db->query($sql, [
                        $dist_code,
                        $subdiv_code,
                        $cir_code,
                        $mouza_pargona_code,
                        $vill_townprt_code,
                        $lot_no,
                        $patta_no,
                        $patta_type_code,
                        $dag_no,
                        $pdar_id
                    ])->row();

                    
                    unset($data->pdar_land_n);
                    unset($data->pdar_land_s);
                    unset($data->pdar_land_e);
                    unset($data->pdar_land_w);
                    unset($data->pdar_land_map);
                    unset($data->pdar_sl_no);
                    unset($data->pdar_gender);
                    unset($data->pdar_minor_yn);
                    unset($data->pdar_minor_dob);
                    unset($data->pdar_mother);
                    unset($data->pdar_aadharno);
                    unset($data->pdar_mobile);
                    unset($data->pdar_nrcno);
                    unset($data->pdar_pan_no);
                    unset($data->pdar_citizen_no);
                    unset($data->pdar_thumb_imp);
                    unset($data->pdar_add3);
                    unset($data->pdar_photo);
                    unset($data->date_entry);
                    unset($data->operation);
                    unset($data->jama_yn);
                    unset($data->pdar_guard_reln);
                    unset($data->f1_case_no);
                    unset($data->f2_case_no);
                    unset($data->o1_case_no);
                    unset($data->o2_case_no);
                    unset($data->dag_por_b);
                    unset($data->dag_por_k);
                    unset($data->dag_por_lc);
                    unset($data->dag_por_g);
                    unset($data->dag_por_kr);
                    
                    $data->action = 3;
                    $data->dag_no = $dag_no;
                    $data->status = 'P';
                    $data->user_code = $this->session->userdata('user_code');
                    $data->entry_date = date('Y-m-d H:i:s');
                    $data->entry_mode = 'C';
                    $data->attachment = $file_name;
                    $data->lm_comment = $lm_note;
                    $data->cluster_key = $cluster_id;
                    unset($data->not_consistent);
                    unset($data->uuid);
                    unset($data->pdar_name_eng);
                    unset($data->pdar_guard_eng);
                    unset($data->created_on);
                    unset($data->updated_on);
                    unset($data->marital_status);
                    unset($data->serial_no);
                    unset($data->dag_no_int);
                    //var_dump($data);
                    $this->db->insert('edit_jama_pattadar', $data);
            if($this->db->affected_rows()!=1){
                log_message('error','JAMAEDITPATTADAR0011'.$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error');
                redirect(base_url() . "index.php/home");
            }
            }
            redirect('/jamaeditentry/pattadarlist/');
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));
            // $q = "select * from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and"
            //         . " p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
            //         . " and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' and patta_type_code='$patta_type_code' and p_flag='1' ";
            $sql1 = "
                    SELECT 
                        c.*, 
                        p.pdar_name,
                        p.pdar_father
                    FROM chitha_dag_pattadar c
                    JOIN chitha_pattadar p 
                    ON p.dist_code = c.dist_code
                    AND p.subdiv_code = c.subdiv_code
                    AND p.cir_code = c.cir_code
                    AND p.mouza_pargona_code = c.mouza_pargona_code
                    AND p.lot_no = c.lot_no
                    AND p.vill_townprt_code = c.vill_townprt_code
                    AND p.patta_type_code = c.patta_type_code
                    AND p.patta_no = c.patta_no
                    AND p.pdar_id = c.pdar_id
                    WHERE c.p_flag = '1'
                    AND EXISTS (
                            SELECT 1
                            FROM chitha_dag_pattadar x
                            WHERE x.dist_code = c.dist_code
                            AND x.subdiv_code = c.subdiv_code
                            AND x.cir_code = c.cir_code
                            AND x.mouza_pargona_code = c.mouza_pargona_code
                            AND x.lot_no = c.lot_no
                            AND x.vill_townprt_code = c.vill_townprt_code
                            AND x.patta_no = c.patta_no
                            AND x.pdar_id = c.pdar_id
                            GROUP BY x.dist_code, x.subdiv_code, x.cir_code, x.mouza_pargona_code,
                                    x.lot_no, x.vill_townprt_code, x.patta_no, x.pdar_id
                    )
                    AND c.dist_code = ?
                    AND c.subdiv_code = ?
                    AND c.cir_code = ?
                    AND c.mouza_pargona_code = ?
                    AND c.vill_townprt_code = ?
                    AND c.lot_no = ?
                    AND TRIM(c.patta_no) = ?
                    AND c.patta_type_code = ?
                ";

                $data['pattadars'] = $this->db->query($sql1, [
                    $dist_code,
                    $subdiv_code,
                    $cir_code,
                    $mouza_pargona_code,
                    $vill_townprt_code,
                    $lot_no,
                    $patta_no,
                    $patta_type_code
                ])->result();



                $sql2 = "
                    SELECT *
                    FROM edit_jama_pattadar p
                    WHERE p.dist_code = ?
                    AND p.subdiv_code = ?
                    AND p.cir_code = ?
                    AND p.mouza_pargona_code = ?
                    AND p.vill_townprt_code = ?
                    AND p.lot_no = ?
                    AND TRIM(p.patta_no) = ?
                    AND p.status = 'P'
                    AND p.action = '3'
                    AND p.patta_type_code = ?
                    AND (p.entry_mode = 'O' OR p.entry_mode = 'C')
                ";

                $data['insert'] = $this->db->query($sql2, [
                    $dist_code,
                    $subdiv_code,
                    $cir_code,
                    $mouza_pargona_code,
                    $vill_townprt_code,
                    $lot_no,
                    $patta_no,
                    $patta_type_code
                ])->result();

            // $this->load->view('../views/header');
            // $this->load->view('../views/jamaeditentry/pdarustrike', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'JamaEditEntry/pdarustrike';
            $this->load->view('layouts/main',$data);
        }
    }
    
    public function transferpattadars()
    {
        $db = $this->session->userdata('db');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $this->db->trans_begin();

            $dist_code = $this->session->userdata('dist_code');
            $this->AgriStackCaseHistory->CreateLogFile($dist_code, 'legacy_entry');

            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));

            $jamabandi_pdar_id = $this->input->post('pdar');
            $dag_dag_no = $this->input->post('dag_dag_no');


            // ----------------------------------------------------------
            // 1️⃣ FETCH FROM JAMA PATTADAR
            // ----------------------------------------------------------
            $q = "
                SELECT * FROM jama_pattadar p
                WHERE p.dist_code = ? 
                AND p.subdiv_code = ? 
                AND p.cir_code = ? 
                AND p.mouza_pargona_code = ? 
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.pdar_id = ?
            ";

            $data = $this->db->query($q, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code, $jamabandi_pdar_id
            ])->row();


            // ----------------------------------------------------------
            // 2️⃣ CHECK IF EXISTS IN CHITHA PATTADAR
            // ----------------------------------------------------------
            $check_q = "
                SELECT COUNT(*) AS count 
                FROM chitha_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
                AND p.pdar_id = ?
            ";

            $checkc = $this->db->query($check_q, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code, $jamabandi_pdar_id
            ])->row()->count;


            // ----------------------------------------------------------
            // 3️⃣ INSERT INTO CHITHA PATTADAR IF NOT EXISTS
            // ----------------------------------------------------------
            if ($checkc <= 0) {

                $chitha_pattadar = [
                    'pdar_name' => $data->pdar_name,
                    'pdar_father' => $data->pdar_father,
                    'patta_no' => trim($data->patta_no),
                    'patta_type_code' => $data->patta_type_code,
                    'pdar_add1' => $data->pdar_add1,
                    'pdar_add2' => $data->pdar_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',

                    'dist_code' => $data->dist_code,
                    'subdiv_code' => $data->subdiv_code,
                    'cir_code' => $data->cir_code,
                    'mouza_pargona_code' => $data->mouza_pargona_code,
                    'lot_no' => $data->lot_no,
                    'vill_townprt_code' => $data->vill_townprt_code,
                    'pdar_id' => $data->pdar_id,

                    'new_pdar_name' => 'N',
                    'jama_yn' => 'y',
                    'pdar_gender' => $data->pdar_gender,
                    'pdar_mother' => $data->pdar_mother,
                    'pdar_guard_reln' => '',
                ];

                $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
            }


            // ----------------------------------------------------------
            // 4️⃣ LOOP DAG LIST AND INSERT INTO CHITHA DAG PATTADAR
            // ----------------------------------------------------------
            foreach ($dag_dag_no as $dag_no) {

                // check existence
                $check_dag_q = "
                    SELECT COUNT(*) AS count 
                    FROM chitha_dag_pattadar p
                    WHERE p.dist_code = ?
                    AND p.subdiv_code = ?
                    AND p.cir_code = ?
                    AND p.mouza_pargona_code = ?
                    AND p.vill_townprt_code = ?
                    AND p.lot_no = ?
                    AND TRIM(p.patta_no) = ?
                    AND p.patta_type_code = ?
                    AND p.pdar_id = ?
                    AND p.dag_no = ?
                ";

                $checkcd = $this->db->query($check_dag_q, [
                    $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                    $vill_townprt_code, $lot_no, $patta_no, $patta_type_code,
                    $jamabandi_pdar_id, $dag_no
                ])->row()->count;


                if ($checkcd <= 0) {
                    $dag_pattadar = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'pdar_id' => $jamabandi_pdar_id,
                        'patta_no' => $patta_no,
                        'dag_no' => $dag_no,
                        'patta_type_code' => $patta_type_code,

                        'dag_por_b' => $data->pdar_land_b,
                        'dag_por_k' => $data->pdar_land_k,
                        'dag_por_lc' => $data->pdar_land_lc,
                        'dag_por_g' => 0.0,
                        'dag_por_kr' => 0,

                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'p_flag' => '0',
                    ];

                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $dag_pattadar);
                }
            }


            // ----------------------------------------------------------
            // 5️⃣ COMMIT OR ROLLBACK
            // ----------------------------------------------------------
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code, 'legacy_entry');
            }

            redirect('JamaEditEntry/transferpattadars');

        } else {

            // GET — load transfer list
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_code');
            $patta_no = trim($this->session->userdata('patta_no'));
            $patta_type_code = trim($this->session->userdata('patta_type_code'));

            $q = "
                SELECT * 
                FROM jama_pattadar p
                WHERE p.dist_code = ?
                AND p.subdiv_code = ?
                AND p.cir_code = ?
                AND p.mouza_pargona_code = ?
                AND p.vill_townprt_code = ?
                AND p.lot_no = ?
                AND TRIM(p.patta_no) = ?
                AND p.patta_type_code = ?
            ";

            $data['pattadars'] = $this->db->query($q, [
                $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
                $vill_townprt_code, $lot_no, $patta_no, $patta_type_code
            ])->result();

            $data['_view'] = 'JamaEditEntry/transferpattadars';
            $this->load->view('layouts/main', $data);
        }
    }

    
    function getPdarDagDetails($id)
    {
        $db = $this->session->userdata('db');

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no             = $this->session->userdata('lot_no');
        $vill_townprt_code  = $this->session->userdata('vill_code');
        $patta_no           = trim($this->session->userdata('patta_no'));
        $patta_type_code    = $this->session->userdata('patta_type_code');

        $sql1 = "
            SELECT pdar_id, pdar_name
            FROM jama_pattadar p
            WHERE p.dist_code = ?
            AND p.subdiv_code = ?
            AND p.cir_code = ?
            AND p.mouza_pargona_code = ?
            AND p.vill_townprt_code = ?
            AND p.lot_no = ?
            AND TRIM(p.patta_no) = ?
            AND p.patta_type_code = ?
            AND p.pdar_id = ?
        ";

        $pattadars = $this->db->query($sql1, [
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $vill_townprt_code,
            $lot_no, $patta_no, $patta_type_code, $id
        ])->row();

        $sql2 = "
            SELECT *
            FROM chitha_pattadar p
            JOIN chitha_dag_pattadar d
            ON p.dist_code = d.dist_code
            AND p.subdiv_code = d.subdiv_code
            AND p.cir_code = d.cir_code
            AND p.lot_no = d.lot_no
            AND p.vill_townprt_code = d.vill_townprt_code
            AND p.mouza_pargona_code = d.mouza_pargona_code
            AND p.pdar_id = d.pdar_id
            AND TRIM(p.patta_no) = TRIM(d.patta_no)
            AND p.patta_type_code = d.patta_type_code
            WHERE d.dist_code = ?
            AND d.subdiv_code = ?
            AND d.cir_code = ?
            AND d.mouza_pargona_code = ?
            AND d.vill_townprt_code = ?
            AND d.lot_no = ?
            AND TRIM(d.patta_no) = TRIM(?)
            AND d.patta_type_code = ?
            AND p.pdar_id = ?
            AND d.p_flag = '1'
        ";

        $result_by_id = $this->db->query($sql2, [
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $vill_townprt_code,
            $lot_no, $patta_no, $patta_type_code, $id
        ])->result();

        $sql3 = "
            SELECT *
            FROM chitha_pattadar p
            JOIN chitha_dag_pattadar d
            ON p.dist_code = d.dist_code
            AND p.subdiv_code = d.subdiv_code
            AND p.cir_code = d.cir_code
            AND p.lot_no = d.lot_no
            AND p.vill_townprt_code = d.vill_townprt_code
            AND p.mouza_pargona_code = d.mouza_pargona_code
            AND p.pdar_id = d.pdar_id
            AND TRIM(p.patta_no) = TRIM(d.patta_no)
            AND p.patta_type_code = d.patta_type_code
            WHERE d.dist_code = ?
            AND d.subdiv_code = ?
            AND d.cir_code = ?
            AND d.mouza_pargona_code = ?
            AND d.vill_townprt_code = ?
            AND d.lot_no = ?
            AND TRIM(d.patta_no) = TRIM(?)
            AND p.pdar_name LIKE ?
            AND d.patta_type_code = ?
            AND d.p_flag = '1'
        ";

        $like_name = '%' . $pattadars->pdar_name . '%';

        $result_by_name = $this->db->query($sql3, [
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $vill_townprt_code,
            $lot_no, $patta_no, $like_name, $patta_type_code
        ])->result();

        $result = array_merge($result_by_id, $result_by_name);

        $results = $this->unique_multidim_array($result, 'pdar_id', 'dag_no');

        $json = [];
        foreach ($results as $object) {
            $json[] = [
                'pdar_id'     => $object->pdar_id,
                'dag'         => trim($object->dag_no),
                'pdar_name'   => $object->pdar_name,
                'pdar_father' => $object->pdar_father,
                'p_flag'      => $object->p_flag
            ];
        }

        echo json_encode($json);
    }

    
    function getPdarAllocatedDagDetails($id){
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        
        $dags = "select * from    jama_dag p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
                . "and patta_type_code='$patta_type_code' ";
        $all_dags = $this->db->query($dags)->result();
        //log_message('error',$this->db->last_query());
        foreach ($all_dags as $d){
            $q = "select pdar_id, pdar_name from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                    . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
                    . "and patta_type_code='$patta_type_code' and pdar_id = '$id' ";
            $pattadars = $this->db->query($q)->row();
            $name=str_replace("'"," ",$pattadars->pdar_name);
            $query_by_id = "select * from    chitha_pattadar p join chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code 
                        and p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and 
                        p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and p.patta_type_code = d.patta_type_code where d.dist_code='$dist_code' and d.subdiv_code='$subdiv_code' "
                            . "and d.cir_code='$cir_code' and d.mouza_pargona_code='$mouza_pargona_code' and d.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' and "
                            . "TRIM(d.patta_no)=trim('$patta_no') and d.patta_type_code='$patta_type_code' and d.dag_no='$d->dag_no' and p.pdar_id = '$id'";
            $result_by_id = $this->db->query($query_by_id)->result();
            //log_message('error',"CDP#1091010".$this->db->last_query());
            $query_by_name = "select * from    chitha_pattadar p join chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code 
                        and p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and 
                        p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) and p.patta_type_code = d.patta_type_code where d.dist_code='$dist_code' and d.subdiv_code='$subdiv_code' "
                            . "and d.cir_code='$cir_code' and d.mouza_pargona_code='$mouza_pargona_code' and d.vill_townprt_code='$vill_townprt_code' and d.lot_no='$lot_no' and "
                            . "TRIM(d.patta_no)=trim('$patta_no') and p.pdar_name like '%$name%' and d.patta_type_code='$patta_type_code' and d.dag_no='$d->dag_no'";
            $result_by_name = $this->db->query($query_by_name);
            //log_message('error',"CDP#1091011".$this->db->last_query());
            // if($result_by_name->num_rows()==0)
            //     continue;
            // else
            $result_by_name=$result_by_name->result();
            $result[$d->dag_no] = array_merge($result_by_id, $result_by_name);
        }  
        if(empty($result))
            {
                $json[] = array('pdar_id' => '', 
                            'dag' => $d->dag_no, 'pdar_name' => 'Pattadar not assigned to this dag '.$d->dag_no, 
                            'pdar_father' => '', 'p_flag' => '1'
                        );
                echo json_encode($json);
                return;
            }
        $json = array();
        foreach ($result as $key => $value) {
            if(!empty($value)){
                $results = $this->unique_multidim_array($value, 'pdar_id', 'dag_no');
                foreach ($results as $object) {
                    $json[] = array('pdar_id' => $object->pdar_id, 'dag' => trim($object->dag_no), 'pdar_name' => $object->pdar_name, 'pdar_father' => $object->pdar_father, 'p_flag' => $object->p_flag);
                }
            } else {
                $json[] = array('pdar_id' => '', 'dag' => $key, 'pdar_name' => 'Pattadar not assigned to this dag '.$key, 'pdar_father' => '', 'p_flag' => '1');
            }
        }
        echo json_encode($json);
    }
            
    function unique_multidim_array($array, $key1, $key2) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array[] = array(); 
        
        foreach($array as $val) { 
            if ((!in_array($val->$key1, $key_array)) && (!in_array($val->$key2, $key_array))) { 
                $key_array[$i] = $val->$key1; 
                $key_array[$i] = $val->$key2;
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        //var_dump($key_array);
        return $temp_array; 
    } 
    
    function getPdarGurdianName($id) {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        
        $q = "select pdar_id, pdar_name,pdar_father from    jama_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and "
                . "p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no' and TRIM(p.patta_no)='$patta_no' "
                . "and patta_type_code='$patta_type_code' and pdar_id = '$id' ";
        $pattadars = $this->db->query($q)->row();
        
        echo json_encode($pattadars);
    }
    
}
