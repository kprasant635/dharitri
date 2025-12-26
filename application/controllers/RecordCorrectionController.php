<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RecordCorrectionController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
    }

    public function index() {
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/common/bar');
        $data = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        ////var_dump($this->session->all_userdata());
        //$this->load->view('menu/menu4');
        $this->load->view('../views/RecordCorrection/select_location', $district);
        $this->load->view('../views/footer');
    }

    public function ShowOptions() {

        $this->session->set_userdata('chitha_dist_code', $this->input->post('dist_code'));
        $this->session->set_userdata('chitha_subdiv_code', $this->input->post('subdiv_code'));
        $this->session->set_userdata('chitha_cir_code', $this->input->post('circle_code'));
        $this->session->set_userdata('chitha_mouza_pargona_code', $this->input->post('mouza_code'));
        $this->session->set_userdata('chitha_lot_no', $this->input->post('lot_no'));
        $this->session->set_userdata('chitha_vill_code', $this->input->post('vill_code'));

        $this->load->view('../views/header');
        $this->load->view('../views/common/bar');
        $this->load->view('../views/RecordCorrection/show_options');
        $this->load->view('../views/footer');
    }

    public function editPattadars() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->helper('html');
            $this->load->view('header');

            $dist_code = $this->session->userdata('chitha_dist_code');
            $subdiv_code = $this->session->userdata('chitha_subdiv_code');
            $circle_code = $this->session->userdata('chitha_cir_code');
            $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_no = $this->session->userdata('chitha_lot_no');
            $vill_code = $this->session->userdata('chitha_vill_code');

            $this->load->model('misreport/MisModel');

            $districtdata = $this->MisModel->getDistrictName($dist_code);
            $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
            $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
            $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
            $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);



            $this->load->model('chitha/ChithaModel');
            $daginfo = $this->ChithaModel->getDagforchitha1($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
            //var_dump ($daginfo);
            $daginformation['dagrange'] = $daginfo;

            $pattatype = $this->ChithaModel->pattatypeforchitha();
            $pattatypeinformation['pattatype'] = $pattatype;
            $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
            ////var_dump($chithadetailsmain);

            $this->load->view('RecordCorrection/select_dag', $chithadetailsmain);
            $this->load->view('footer');
        }
    }

    public function edit() {
			$db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no_lower');

        $patta_type = $this->input->post('patta_code');
        $this->session->set_userdata('patta_code_pdar_edit', $patta_type);
        $dist_code = $this->session->userdata('chitha_dist_code');
        $subdiv_code = $this->session->userdata('chitha_subdiv_code');
        $circle_code = $this->session->userdata('chitha_cir_code');
        $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
        $lot_no = $this->session->userdata('chitha_lot_no');
        $vill_code = $this->session->userdata('chitha_vill_code');

        $dag_no_char = $this->db->query("select dag_no from    chitha_basic cp where "
                        . " cp.dist_code='$dist_code' and "
                        . " cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and "
                        . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and"
                        . " cp.vill_townprt_code='$vill_code' and cp.dag_no_int='$dag_no' and cp.patta_type_code='$patta_type'")->row()->dag_no;
        $this->session->set_userdata('dag_no_pdar_edit', $dag_no_char);
        $q = "select * from    chitha_dag_pattadar cdp ,chitha_pattadar cp where "
                . " cdp.dist_code=cp.dist_code and cp.subdiv_code=cdp.subdiv_code and cp.cir_code = cdp.cir_code "
                . " and cdp.mouza_pargona_code=cp.mouza_pargona_code and cdp.lot_no=cp.lot_no and "
                . " cdp.vill_townprt_code = cp.vill_townprt_code and TRIM(cp.patta_no) = TRIM(cdp.patta_no) and   "
                . " cp.pdar_id = cdp.pdar_id "
                . " and cp.dist_code='$dist_code' and "
                . " cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and "
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and"
                . " cp.vill_townprt_code='$vill_code' and cdp.dag_no='$dag_no_char' and"
                . " cp.patta_type_code='$patta_type'";
        //echo $q;
        $pattadars = $this->db->query("select * from    chitha_dag_pattadar cdp ,chitha_pattadar cp where "
                        . " cdp.dist_code=cp.dist_code and cp.subdiv_code=cdp.subdiv_code and cp.cir_code = cdp.cir_code "
                        . " and cdp.mouza_pargona_code=cp.mouza_pargona_code and cdp.lot_no=cp.lot_no and "
                        . " cdp.vill_townprt_code = cp.vill_townprt_code and TRIM(cp.patta_no) = TRIM(cdp.patta_no) and   "
                        . " cp.pdar_id = cdp.pdar_id "
                        . " and cp.dist_code='$dist_code' and "
                        . " cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and "
                        . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and"
                        . " cp.vill_townprt_code='$vill_code' and cdp.dag_no='$dag_no_char' and"
                        . " cp.patta_type_code='$patta_type'")->result();
        $data['pattadars'] = $pattadars;
        $this->load->view('../views/header');
        $this->load->view('../views/RecordCorrection/edit', $data);
        $this->load->view('../views/footer');
    }

    public function editForm($id = 0) {
			$db=  $this->session->userdata('db');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->session->userdata('chitha_dist_code');
            $subdiv_code = $this->session->userdata('chitha_subdiv_code');
            $circle_code = $this->session->userdata('chitha_cir_code');
            $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_no = $this->session->userdata('chitha_lot_no');
            $vill_code = $this->session->userdata('chitha_vill_code');
            $dag_no_char = $this->session->userdata('dag_no_pdar_edit');
            $patta_type = $this->session->userdata('patta_code_pdar_edit');
            $data['pattadar'] = $this->db->query("select * from    chitha_dag_pattadar cdp ,chitha_pattadar cp where "
                            . " cdp.dist_code=cp.dist_code and cp.subdiv_code=cdp.subdiv_code and cp.cir_code = cdp.cir_code "
                            . " and cdp.mouza_pargona_code=cp.mouza_pargona_code and cdp.lot_no=cp.lot_no and "
                            . " cdp.vill_townprt_code = cp.vill_townprt_code and TRIM(cp.patta_no) = TRIM(cdp.patta_no) and   "
                            . " cp.pdar_id = cdp.pdar_id "
                            . " and cp.dist_code='$dist_code' and "
                            . " cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and "
                            . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and"
                            . " cp.vill_townprt_code='$vill_code' and cdp.dag_no='$dag_no_char' and"
                            . " cp.patta_type_code='$patta_type' and cp.pdar_id = $id")->row();
            $data['relations'] = $this->db->query("select * from    master_guard_rel");
            $data['genders'] = array('M', 'F', 'O');
            $data['dag_no'] = $dag_no_char;
            $data['patta_type'] = $patta_type;
            $data['pdar_id'] = $id;


            $this->load->view('../views/header');
            $this->load->view('../views/RecordCorrection/pattadardetails', $data);
            $this->load->view('../views/footer');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post(NULL, TRUE);
            $patta_type = $data['patta_type_code'];
            $patta_no = trim($data['patta_no']);
            unset($data['dag_no']);
            if ($data['pdar_minor_dob'] !== null) {
                unset($data['pdar_minor_dob']);
            }
            $dist_code = $this->session->userdata('chitha_dist_code');
            $subdiv_code = $this->session->userdata('chitha_subdiv_code');
            $circle_code = $this->session->userdata('chitha_cir_code');
            $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_no = $this->session->userdata('chitha_lot_no');
            $vill_code = $this->session->userdata('chitha_vill_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = 'E';
            // $count = $this->db->update('chitha_pattadar', $data, array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_code,
            //     'lot_no' => $lot_no, 'vill_townprt_code' => $vill_code, 'patta_no' => $patta_no, 'patta_type_code' => $patta_type,
            //     'pdar_id' => $data['pdar_id']
            // ));
            $table = 'chitha_pattadar';
            $params = $data;
            $where = [
                'dist_code'           => $dist_code,
                'subdiv_code'         => $subdiv_code,
                'cir_code'            => $circle_code,
                'mouza_pargona_code'  => $mouza_code,
                'lot_no'              => $lot_no,
                'vill_townprt_code'   => $vill_code,
                'patta_no'            => $patta_no,
                'patta_type_code'     => $patta_type,
                'pdar_id'             => $data['pdar_id'],
            ];
            $count = $this->Chitha_basic_model->update_table($table, $params, $where);
            $this->session->set_flashData('message', "$count Record Updated");
            redirect(base_url() . "index.php/home/");
        }
    }

}
