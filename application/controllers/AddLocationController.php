<?php

class AddLocationController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basundhara/basundharamodel');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
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
        }else if ($dist_code == "auth") {
            $this->db = $this->load->database('auth', TRUE);
        }
        return $this->db;
    }

    /********** View Village Form *********/
    public function viewVillageForm(){
        $data['_view'] = 'Location/AddVillage';
        $this->load->view('layouts/main', $data);
    }

    /********** get sub division *********/
    public function getSubdivJson($distcode) {
        $this->dbswitch($distcode);
        $district = $this->db->query("select * from   location where dist_code =?  and "
            . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'",array($distcode));
        $data = $district->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'subdiv_code' => $object->subdiv_code);
        }
        echo json_encode($json);
    }

    /********** get circle *********/
    public function getCircleJson($distCode, $subdivcode) {
        $district = $this->db->query("select * from location where dist_code =?  and "
            . " subdiv_code=? and cir_code!='00' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'",array($distCode,$subdivcode));
        $data = $district->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'cir_code' => $object->cir_code);
        }
        echo json_encode($json);
    }

    /********** get Mouza *********/
    public function getMouzaJson($distcode, $subdivcode, $circode){
        $district = $this->db->query("select * from location where dist_code =?  and "
            . " subdiv_code=? and cir_code=? and mouza_pargona_code!='00' and "
            . " vill_townprt_code='00000' and lot_no='00'",array($distcode,$subdivcode,$circode));
        $data = $district->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'mouza_pargona_code' => $object->mouza_pargona_code);
        }
        echo json_encode($json);
    }

    /********** get lot *********/
    public function getLotNoJson($distcode, $subdivcode, $circode, $mouzacode) {
        $district = $this->db->query("select *  from location where dist_code =?  and "
            . " subdiv_code=? and cir_code=? and mouza_pargona_code=? and "
            . " vill_townprt_code='00000' and lot_no!='00' order by lot_no",
            array($distcode,$subdivcode,$circode,$mouzacode));
        $data = $district->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'lot_no' => $object->lot_no);
        }
        echo json_encode($json);
    }

    //*********** validate Location Data *************//
    public function validateLocationData()
    {
        $this->dbswitch('auth');
        $data = null;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean'
            ),
            array(
                'field' => 'lotcode',
                'label' => 'Lot No',
                'rules' => 'trim|required|is_natural|xss_clean|callback_lotValidate'
            ),
        );

        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');

            $data['villages'] = $this->db->query("select * from location where 
            dist_code =?  and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code!=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, $lot_no,'00000'))->result_array();

            $data['success'] = true;
        }
        echo json_encode($data);
    }

    //*********** CHECK LOT NO VALIDATE *************//
    public function lotValidate()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->post('mouzacode');
        $lot_no = $this->input->post('lotcode');

        $lot_no_check = $this->db->query("select lot_no from location where 
            dist_code =?  and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code,
                $mouza_code, $lot_no,'00000'));
        if ($lot_no_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('lotValidate', 'Invalid Data.');
            return FALSE;
        }
    }

    //*********** CHECK ENGLISH NAME REGEX *************//
    public function englishRegex_check($str)
    {
        if (!preg_match('/^[A-Za-z0-9? ,\/._-]+$/', $str)) {
            $this->form_validation->set_message('englishRegex_check', 'Only alpha characters,white spaces,_,-,/, & numeric values are allowed');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    //********** Save New Village *****************//
    public function saveNewVillage()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean'
            ),
            array(
                'field' => 'lotcode',
                'label' => 'Lot No',
                'rules' => 'trim|required|is_natural|xss_clean|callback_lotValidate'
            ),
            array(
                'field' => 'vill_as_name',
                'label' => 'Village Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'vill_eng_name',
                'label' => 'Village English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
            array(
                'field' => 'rural_urban',
                'label' => 'Rural / Urban',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
            array(
                'field' => 'village_status',
                'label' => 'Village Type',
                'rules' => 'trim|required|max_length[2]|xss_clean'
            ),
            array(
                'field' => 'is_map',
                'label' => 'Is Map Updated',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
            array(
                'field' => 'is_mc',
                'label' => 'Municipal Corporation',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_as_name = $this->input->post('vill_as_name');
            $vill_eng_name = strtoupper($this->input->post('vill_eng_name'));
            $rural_urban = $this->input->post('rural_urban');
            $village_status = $this->input->post('village_status');
            $is_map = $this->input->post('is_map');
            $is_mc = $this->input->post('is_mc');

            $vill_check = $this->input->post('vill_check');

            $data['vill_exist'] = null;
            if($vill_check == 'Y')
            {
                $data['vill_exist'] = null;
                $check_vill_sql = "select loc_name, locname_eng,uuid from location 
                            where dist_code=? and subdiv_code=? and cir_code=? 
                            and mouza_pargona_code=? and lot_no=? and vill_townprt_code!=?
                            and (loc_name like '%$vill_as_name%' or locname_eng like '%$vill_eng_name%')";
                $check_vill_res = $this->db->query($check_vill_sql,
                    array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,'00000'));
                if($check_vill_res->num_rows()>0)
                {
                    $data['vill_exist'] = $check_vill_res->result();
                    echo json_encode($data);
                    return;
                }
            }

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Get max UUID *************/
            $uuid = $this->dba->query("select max(uuid)+1 as uuid from location")->row();

            $vill_townprt_code_data = null;
            /*********** Get max vill_townprt_code *************/
            $vill_townprt_code_data = $this->db->query("select max(CAST(vill_townprt_code as int)) as vill from 
                location where dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code!=?",
                array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,'00000'))->row()->vill;
            if($vill_townprt_code_data == null)
            {
                $vill_townprt_code = "10001";
            }else{
                $vill_townprt_code = ((int)$vill_townprt_code_data)+1;
            }

            /*********** Get cir_abbr,dist_abbr from district *************/
            $loc_data = $this->db->query("select cir_abbr,dist_abbr from 
                location where dist_code=? and subdiv_code=? and cir_code=?",
                array($dist_code,$subdiv_code,$cir_code))->row();

            /*********** Insert Array *************/
            $new_village_loc = array();
            $new_village_loc['dist_code'] = $dist_code;
            $new_village_loc['subdiv_code'] = $subdiv_code;
            $new_village_loc['cir_code'] = $cir_code;
            $new_village_loc['mouza_pargona_code'] = $mouza_code;
            $new_village_loc['lot_no'] = $lot_no;
            $new_village_loc['vill_townprt_code'] = $vill_townprt_code;
            $new_village_loc['loc_name'] = $vill_as_name;
            $new_village_loc['unique_loc_code'] = $dist_code.$subdiv_code.$cir_code.$mouza_code.$lot_no.$vill_townprt_code;
            $new_village_loc['locname_eng'] = $vill_eng_name;
            $new_village_loc['cir_abbr'] = $loc_data->cir_abbr;
            $new_village_loc['dist_abbr'] = $loc_data->dist_abbr;
            $new_village_loc['rural_urban'] = $rural_urban;
            $new_village_loc['village_status'] = $village_status;
            $new_village_loc['is_map'] = $is_map;
            $new_village_loc['is_gmc'] = $is_mc;
            $new_village_loc['uuid'] = $uuid->uuid;
            $new_village_loc['user_code'] = $this->session->userdata('user_code');
            $new_village_loc['created_date'] = date('Y-m-d G:i:s');
            $new_village_loc['updated_date'] = date('Y-m-d G:i:s');

            /*********** Insert Into Central Auth Location *************/
            $insert_auth = $this->dba->insert('location',$new_village_loc);
            if($insert_auth != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10001 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10001 Unable to insert data into Central Auth Location.');
                log_message('error', $this->db->last_query());
                echo json_encode($data);
                return;
            }

            /*********** Insert Into Central Auth Location *************/
            $insert_db = $this->db->insert('location',$new_village_loc);
            if($insert_db != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10002 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10002 Unable to insert data into '.$dist_code.' Location');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['villages'] = $this->db->query("select * from location where 
                    dist_code =? and subdiv_code=? and 
                    cir_code=? and mouza_pargona_code=? and lot_no=? and 
                    vill_townprt_code!=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, $lot_no,'00000'))->result_array();
            $data['t_error'] = false;
            $data['uuid'] = $uuid->uuid;
            echo json_encode($data);
            return;
        }
    }

    //************ Get data using uuid for edit *********//
    function editModalView()
    {
        $uuid = $this->input->post('uuid');
        $data['village'] = $this->db->query("select * from location where 
                    uuid=?",
            array($uuid))->row();
        echo json_encode($data);
        return;
    }

    //********** Save Edit Village *****************//
    public function editNewVillage()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean'
            ),
            array(
                'field' => 'lotcode',
                'label' => 'Lot No',
                'rules' => 'trim|required|is_natural|xss_clean|callback_lotValidate'
            ),
            array(
                'field' => 'vill_as_name',
                'label' => 'Village Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'vill_eng_name',
                'label' => 'Village English Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'rural_urban',
                'label' => 'Rural / Urban',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
            array(
                'field' => 'village_status',
                'label' => 'Village Type',
                'rules' => 'trim|required|max_length[2]|xss_clean'
            ),
            array(
                'field' => 'is_map',
                'label' => 'Is Map Updated',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
            array(
                'field' => 'is_mc',
                'label' => 'Municipal Corporation',
                'rules' => 'trim|required|max_length[1]|xss_clean'
            ),
            array(
                'field' => 'nc_btad',
                'label' => 'NC/BTAD',
                'rules' => 'trim|required|max_length[4]|xss_clean'
            ),
            array(
                'field' => 'is_periphary',
                'label' => 'Is Periphary',
                'rules' => 'trim|required|max_length[5]|xss_clean'
            ),
            array(
                'field' => 'is_tribal',
                'label' => 'Is Tribal',
                'rules' => 'trim|required|max_length[5]|xss_clean'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $uuid = $this->input->post('uuid');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $vill_as_name = $this->input->post('vill_as_name');
            $vill_eng_name = strtoupper($this->input->post('vill_eng_name'));
            $rural_urban = $this->input->post('rural_urban');
            $village_status = $this->input->post('village_status');
            $is_map = $this->input->post('is_map');
            $is_mc = $this->input->post('is_mc');
            $nc_btad = $this->input->post('nc_btad') == 'None' ? null : $this->input->post('nc_btad');
            $is_periphary = $this->input->post('is_periphary');
            $is_tribal = $this->input->post('is_tribal');

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Update Village *************/
            $updated_date = date('Y-m-d G:i:s');
            $sql_update = "update location set loc_name=?, locname_eng=?, 
                        rural_urban=?, village_status=?, is_map=?, 
                        is_gmc=?, updated_date=?, user_code=?,nc_btad=?,is_periphary=?,is_tribal=? where uuid=? and dist_code=? and 
                        subdiv_code=? and cir_code=? and 
                        mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $this->db->query($sql_update,
                    array($vill_as_name, $vill_eng_name,$rural_urban,
                        $village_status,$is_map,$is_mc, $updated_date, $this->session->userdata('user_code'),
                        $nc_btad,$is_periphary,$is_tribal,
                        $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                        $lot_no,$vill_townprt_code));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10010 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10010 Unable to update data into District Location.');
                echo json_encode($data);
                return;
            }
            $this->dba->query($sql_update,
                array($vill_as_name, $vill_eng_name,$rural_urban,
                    $village_status,$is_map,$is_mc, $updated_date,$this->session->userdata('user_code'),
                    $nc_btad,$is_periphary,$is_tribal,
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));
            if($this->dba->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10011 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10011 Unable to update data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['villages'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code=? and 
                cir_code=? and mouza_pargona_code=? and lot_no=? and 
                vill_townprt_code!=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, $lot_no,'00000'))->result_array();
            $data['t_error'] = false;
            echo json_encode($data);
            return;
        }
    }

    /************** LOT ****************/

    /********** View Lot Form *********/
    public function viewLotForm(){
        $data['_view'] = 'Location/AddLot';
        $this->load->view('layouts/main', $data);
    }

    //*********** validate Lot Data *************//
    public function validateLocationLotData()
    {
        $this->dbswitch('auth');
        $data = null;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean|callback_mouzaValidate'
            ),
        );

        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');

            $data['lots'] = $this->db->query("select * from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no!=? and 
            vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, '00','00000'))->result_array();

            $data['success'] = true;
        }
        echo json_encode($data);
    }

    //*********** CHECK MOUZA NO VALIDATE *************//
    public function mouzaValidate()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->post('mouzacode');

        $lot_no_check = $this->db->query("select mouza_pargona_code from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code,
                $mouza_code, '00','00000'));
        if ($lot_no_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('mouzaValidate', 'Invalid Data.');
            return FALSE;
        }
    }

    //********** Save New Lot *****************//
    public function saveNewLot()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean|callback_mouzaValidate'
            ),
            array(
                'field' => 'lot_as_name',
                'label' => 'Lot Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'lot_eng_name',
                'label' => 'Lot English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $vill_townprt_code = '00000';

            $lot_as_name = $this->input->post('lot_as_name');
            $lot_eng_name = strtoupper($this->input->post('lot_eng_name'));

            $check = $this->input->post('check');

            $data['exist'] = null;
            if($check == 'Y')
            {
                $check_lot_sql = "select loc_name, locname_eng, uuid from location 
                            where dist_code=? and subdiv_code=? and cir_code=? 
                            and mouza_pargona_code=? and lot_no!=? and vill_townprt_code=?
                            and (loc_name like '%$lot_as_name%' or locname_eng like '%$lot_eng_name%')";
                $check_lot_res = $this->db->query($check_lot_sql,
                    array($dist_code,$subdiv_code,$cir_code,$mouza_code,'00','00000'));
                if($check_lot_res->num_rows()>0)
                {
                    $data['exist'] = $check_lot_res->result();
                    echo json_encode($data);
                    return;
                }
            }

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Get max UUID *************/
            $uuid = $this->dba->query("select max(uuid)+1 as uuid from location")->row();

            $lot_no = null;
            /*********** Get max lot code *************/
            $lot_no_data = $this->db->query("select max(CAST(lot_no as int)) as lot from 
                location where dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code=? and lot_no!=? and vill_townprt_code=?",
                array($dist_code,$subdiv_code,$cir_code,$mouza_code,'00','00000'))->row()->lot;
            if($lot_no_data == null)
            {
                $lot_no = "01";
            }else{
                if($lot_no_data < 9) {
                    $lot_no = $lot_no_data+1;
                    $lot_no = '0'.$lot_no;
                }else{
                    $lot_no = ((int)$lot_no_data)+1;
                }
            }

            /*********** Get cir_abbr,dist_abbr from district *************/
            $loc_data = $this->db->query("select cir_abbr,dist_abbr from 
                location where dist_code=? and subdiv_code=? and cir_code=?",
                array($dist_code,$subdiv_code,$cir_code))->row();

            /*********** Insert Array *************/
            $new_loc = array();
            $new_loc['dist_code'] = $dist_code;
            $new_loc['subdiv_code'] = $subdiv_code;
            $new_loc['cir_code'] = $cir_code;
            $new_loc['mouza_pargona_code'] = $mouza_code;
            $new_loc['lot_no'] = $lot_no;
            $new_loc['vill_townprt_code'] = $vill_townprt_code;
            $new_loc['loc_name'] = $lot_as_name;
            $new_loc['unique_loc_code'] = $dist_code.$subdiv_code.$cir_code.$mouza_code.$lot_no.$vill_townprt_code;
            $new_loc['locname_eng'] = $lot_eng_name;
            $new_loc['cir_abbr'] = $loc_data->cir_abbr;
            $new_loc['dist_abbr'] = $loc_data->dist_abbr;

            $new_loc['uuid'] = $uuid->uuid;
            $new_loc['user_code'] = $this->session->userdata('user_code');
            $new_loc['created_date'] = date('Y-m-d G:i:s');
            $new_loc['updated_date'] = date('Y-m-d G:i:s');

            /*********** Insert Into Central Auth Location *************/
            $insert_auth = $this->dba->insert('location',$new_loc);
            if($insert_auth != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10021 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10021 Unable to insert data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Insert Into Central Auth Location *************/
            $insert_db = $this->db->insert('location',$new_loc);
            if($insert_db != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10022 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10022 Unable to insert data into '.$dist_code.' Location');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['lots'] = $this->db->query("select * from location where 
                    dist_code =? and subdiv_code=? and 
                    cir_code=? and mouza_pargona_code=? and lot_no!=? and 
                    vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, '00','00000'))->result_array();
            $data['t_error'] = false;
            $data['uuid'] = $uuid->uuid;
            echo json_encode($data);
            return;
        }
    }

    //********** Save Edit LOT *****************//
    public function editNewLot()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'mouzacode',
                'label' => 'Mouza',
                'rules' => 'trim|required|is_natural|xss_clean|callback_mouzaValidate'
            ),
            array(
                'field' => 'lot_as_name',
                'label' => 'Lot Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'lot_eng_name',
                'label' => 'Lot English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $uuid = $this->input->post('uuid');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $lot_as_name = $this->input->post('lot_as_name');
            $lot_eng_name = strtoupper($this->input->post('lot_eng_name'));

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Update Lot *************/
            $updated_date = date('Y-m-d G:i:s');
            $sql_update = "update location set loc_name=?, locname_eng=?, 
                        updated_date=?, user_code=? where uuid=? and dist_code=? and 
                        subdiv_code=? and cir_code=? and 
                        mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $this->db->query($sql_update,
                array($lot_as_name, $lot_eng_name,$updated_date, $this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10023 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10023 Unable to update data into District Location.');
                echo json_encode($data);
                return;
            }
            $this->dba->query($sql_update,
                array($lot_as_name, $lot_eng_name,$updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));
            if($this->dba->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10024 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10024 Unable to update data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['lots'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code=? and 
                cir_code=? and mouza_pargona_code=? and lot_no!=? and 
                vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, '00','00000'))->result_array();
            $data['t_error'] = false;
            echo json_encode($data);
            return;
        }
    }

    /************** MOUZA ****************/

    /********** View MOUZA Form *********/
    public function viewMouzaForm(){
        $data['_view'] = 'Location/AddMouza';
        $this->load->view('layouts/main', $data);
    }

    //*********** validate MOUZA Data *************//
    public function validateLocationMouzaData()
    {
        $this->dbswitch('auth');
        $data = null;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean|callback_circleValidate',
            ),
        );

        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $data['mouzas'] = $this->db->query("select * from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code!=? and lot_no=? and 
            vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    '00', '00','00000'))->result_array();

            $data['success'] = true;
        }
        echo json_encode($data);
    }

    //*********** CHECK CIRCLE VALIDATE *************//
    public function circleValidate()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $circle_no_check = $this->db->query("select cir_code from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code,
                '00', '00','00000'));
        if ($circle_no_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('circleValidate', 'Invalid Data.');
            return FALSE;
        }
    }

    //********** Save New Mouza *****************//
    public function saveNewMouza()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean|callback_circleValidate',
            ),
            array(
                'field' => 'mouza_as_name',
                'label' => 'Mouza Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mouza_eng_name',
                'label' => 'Mouza English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $lot_no = '00';
            $vill_townprt_code = '00000';

            $mouza_as_name = $this->input->post('mouza_as_name');
            $mouza_eng_name = strtoupper($this->input->post('mouza_eng_name'));

            $check = $this->input->post('check');

            $data['exist'] = null;
            if($check == 'Y')
            {
                $check_mouza_sql = "select loc_name, locname_eng, uuid from location 
                            where dist_code=? and subdiv_code=? and cir_code=? 
                            and mouza_pargona_code!=? and lot_no=? and vill_townprt_code=?
                            and (loc_name like '%$mouza_as_name%' or locname_eng like '%$mouza_eng_name%')";
                $check_mouza_res = $this->db->query($check_mouza_sql,
                    array($dist_code,$subdiv_code,$cir_code,'00','00','00000'));
                if($check_mouza_res->num_rows()>0)
                {
                    $data['exist'] = $check_mouza_res->result();
                    echo json_encode($data);
                    return;
                }
            }

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Get max UUID *************/
            $uuid = $this->dba->query("select max(uuid)+1 as uuid from location")->row();

            $mouza_code = null;
            /*********** Get max code *************/
            $mouza_no_data = $this->db->query("select max(CAST(mouza_pargona_code as int)) as mouza from 
                location where dist_code=? and subdiv_code=? and cir_code=? 
                and mouza_pargona_code!=? and lot_no=? and vill_townprt_code=?",
                array($dist_code,$subdiv_code,$cir_code,'00','00','00000'))->row()->mouza;
            if($mouza_no_data == null)
            {
                $mouza_code = "01";
            }else{
                if($mouza_no_data < 9) {
                    $mouza_code = $mouza_no_data+1;
                    $mouza_code = '0'.$mouza_code;
                }else{
                    $mouza_code = ((int)$mouza_no_data)+1;
                }
            }

            /*********** Get cir_abbr,dist_abbr from district *************/
            $loc_data = $this->db->query("select cir_abbr,dist_abbr from 
                location where dist_code=? and subdiv_code=? and cir_code=?",
                array($dist_code,$subdiv_code,$cir_code))->row();

            /*********** Insert Array *************/
            $new_loc = array();
            $new_loc['dist_code'] = $dist_code;
            $new_loc['subdiv_code'] = $subdiv_code;
            $new_loc['cir_code'] = $cir_code;
            $new_loc['mouza_pargona_code'] = $mouza_code;
            $new_loc['lot_no'] = $lot_no;
            $new_loc['vill_townprt_code'] = $vill_townprt_code;
            $new_loc['loc_name'] = $mouza_as_name;
            $new_loc['unique_loc_code'] = $dist_code.$subdiv_code.$cir_code.$mouza_code.$lot_no.$vill_townprt_code;
            $new_loc['locname_eng'] = $mouza_eng_name;
            $new_loc['cir_abbr'] = $loc_data->cir_abbr;
            $new_loc['dist_abbr'] = $loc_data->dist_abbr;

            $new_loc['uuid'] = $uuid->uuid;
            $new_loc['user_code'] = $this->session->userdata('user_code');
            $new_loc['created_date'] = date('Y-m-d G:i:s');
            $new_loc['updated_date'] = date('Y-m-d G:i:s');

            /*********** Insert Into Central Auth Location *************/
            $insert_auth = $this->dba->insert('location',$new_loc);
            if($insert_auth != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10031 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10031 Unable to insert data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Insert Into Central Auth Location *************/
            $insert_db = $this->db->insert('location',$new_loc);
            if($insert_db != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10032 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10032 Unable to insert data into '.$dist_code.' Location');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['mouzas'] = $this->db->query("select * from location where 
                    dist_code =? and subdiv_code=? and 
                    cir_code=? and mouza_pargona_code!=? and lot_no=? and 
                    vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            $data['uuid'] = $uuid->uuid;
            echo json_encode($data);
            return;
        }
    }

    //********** Save Edit Mouza *****************//
    public function editNewMouza()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'circode',
                'label' => 'Circle',
                'rules' => 'trim|required|is_natural|xss_clean|callback_circleValidate',
            ),
            array(
                'field' => 'mouza_as_name',
                'label' => 'Mouza Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mouza_eng_name',
                'label' => 'Mouza English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $uuid = $this->input->post('uuid');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $mouza_as_name = $this->input->post('mouza_as_name');
            $mouza_eng_name = strtoupper($this->input->post('mouza_eng_name'));

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Update Lot *************/
            $updated_date = date('Y-m-d G:i:s');
            $sql_update = "update location set loc_name=?, locname_eng=?, 
                        updated_date=?, user_code=? where uuid=? and dist_code=? and 
                        subdiv_code=? and cir_code=? and 
                        mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $this->db->query($sql_update,
                array($mouza_as_name, $mouza_eng_name,$updated_date, $this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10033 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10033 Unable to update data into District Location.');
                echo json_encode($data);
                return;
            }
            $this->dba->query($sql_update,
                array($mouza_as_name, $mouza_eng_name,$updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));
            if($this->dba->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10034 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10034 Unable to update data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['mouzas'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code=? and 
                cir_code=? and mouza_pargona_code!=? and lot_no=? and 
                vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            echo json_encode($data);
            return;
        }
    }

    /************** CIRCLE ****************/

    /********** View CIRCLE Form *********/
    public function viewCircleForm(){
        redirect(base_url() . 'index.php/home');
        $data['_view'] = 'Location/AddCircle';
        $this->load->view('layouts/main', $data);
    }

    //*********** Validate Circle Data *************//
    public function validateLocationCircleData()
    {
        $this->dbswitch('auth');
        $data = null;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean|callback_subdivValidate',
            ),
        );

        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');

            $data['circles'] = $this->db->query("select * from location where 
            dist_code =? and subdiv_code=? and 
            cir_code!=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, '00',
                    '00', '00','00000'))->result_array();

            $data['success'] = true;
        }
        echo json_encode($data);
    }

    //*********** CHECK SUB DIVISION VALIDATE *************//
    public function subdivValidate()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');

        $subdiv_no_check = $this->db->query("select subdiv_code from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=?",
            array($dist_code, $subdiv_code, '00',
                '00', '00','00000'));
        if ($subdiv_no_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('subdivValidate', 'Invalid Data.');
            return FALSE;
        }
    }

    //********** Save New Circle *****************//
    public function saveNewCircle()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean|callback_subdivValidate',
            ),
            array(
                'field' => 'circle_as_name',
                'label' => 'Circle Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'circle_eng_name',
                'label' => 'Circle English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
            array(
                'field' => 'cir_abbr',
                'label' => 'Circle Abbreviation',
                'rules' => 'trim|required|alpha|xss_clean|exact_length[3]',
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = '00';
            $mouza_code = '00';
            $lot_no = '00';
            $vill_townprt_code = '00000';
            $cir_abbr = strtoupper($this->input->post('cir_abbr'));

            $circle_as_name = $this->input->post('circle_as_name');
            $circle_eng_name = strtoupper($this->input->post('circle_eng_name'));

            $check = $this->input->post('check');

            $data['exist'] = null;
            if($check == 'Y')
            {
                $check_sql = "select loc_name, locname_eng, uuid, cir_abbr from location 
                            where dist_code=? and subdiv_code=? and cir_code!=? 
                            and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?
                            and (loc_name like '%$circle_as_name%' or locname_eng like '%$circle_eng_name%')";
                $check_res = $this->db->query($check_sql,
                    array($dist_code,$subdiv_code,'00','00','00','00000'));
                if($check_res->num_rows()>0)
                {
                    $data['exist'] = $check_res->result();
                    echo json_encode($data);
                    return;
                }
            }

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Get max UUID *************/
            $uuid = $this->dba->query("select max(uuid)+1 as uuid from location")->row();

            $circle_code = null;
            /*********** Get max code *************/
            $circle_no_data = $this->db->query("select max(CAST(cir_code as int)) as circle from 
                location where dist_code=? and subdiv_code=? and cir_code!=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",
                array($dist_code,$subdiv_code,$cir_code,'00','00','00000'))->row()->circle;
            if($circle_no_data == null)
            {
                $circle_code = "01";
            }else{
                if($circle_no_data < 9) {
                    $circle_code = $circle_no_data+1;
                    $circle_code = '0'.$circle_code;
                }else{
                    $circle_code = ((int)$circle_no_data)+1;
                }
            }

            /*********** Get dist_abbr from district *************/
            $loc_data = $this->db->query("select dist_abbr from 
                location where dist_code=? and subdiv_code=? and cir_code=?",
                array($dist_code,$subdiv_code,$cir_code))->row();

            /*********** Insert Array *************/
            $new_loc = array();
            $new_loc['dist_code'] = $dist_code;
            $new_loc['subdiv_code'] = $subdiv_code;
            $new_loc['cir_code'] = $circle_code;
            $new_loc['mouza_pargona_code'] = $mouza_code;
            $new_loc['lot_no'] = $lot_no;
            $new_loc['vill_townprt_code'] = $vill_townprt_code;
            $new_loc['loc_name'] = $circle_as_name;
            $new_loc['unique_loc_code'] = $dist_code.$subdiv_code.$circle_code.$mouza_code.$lot_no.$vill_townprt_code;
            $new_loc['locname_eng'] = $circle_eng_name;
            $new_loc['cir_abbr'] = $cir_abbr;
            $new_loc['dist_abbr'] = $loc_data->dist_abbr;

            $new_loc['uuid'] = $uuid->uuid;
            $new_loc['user_code'] = $this->session->userdata('user_code');
            $new_loc['created_date'] = date('Y-m-d G:i:s');
            $new_loc['updated_date'] = date('Y-m-d G:i:s');

            /*********** Insert Into Central Auth Location *************/
            $insert_auth = $this->dba->insert('location',$new_loc);
            if($insert_auth != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10041 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10041 Unable to insert data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Insert Into Central Auth Location *************/
            $insert_db = $this->db->insert('location',$new_loc);
            if($insert_db != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10042 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10042 Unable to insert data into '.$dist_code.' Location');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['circles'] = $this->db->query("select * from location where 
                    dist_code =? and subdiv_code=? and 
                    cir_code!=? and mouza_pargona_code=? and lot_no=? and 
                    vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, '00',
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            $data['uuid'] = $uuid->uuid;
            echo json_encode($data);
            return;
        }
    }

    //********** Save Edit Circle *****************//
    public function editNewCircle()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdivcode',
                'label' => 'Sub-Division',
                'rules' => 'trim|required|is_natural|xss_clean|callback_subdivValidate',
            ),
            array(
                'field' => 'circle_as_name',
                'label' => 'Circle Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'circle_eng_name',
                'label' => 'Circle English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
            array(
                'field' => 'cir_abbr',
                'label' => 'Circle Abbreviation',
                'rules' => 'trim|required|alpha|xss_clean|exact_length[3]',
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $uuid = $this->input->post('uuid');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $circle_as_name = $this->input->post('circle_as_name');
            $circle_eng_name = strtoupper($this->input->post('circle_eng_name'));
            $cir_abbr = strtoupper($this->input->post('cir_abbr'));

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Update *************/
            $updated_date = date('Y-m-d G:i:s');
            $sql_update = "update location set loc_name=?, locname_eng=?,cir_abbr=?, 
                        updated_date=?, user_code=? where uuid=? and dist_code=? and 
                        subdiv_code=? and cir_code=? and 
                        mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $this->db->query($sql_update,
                array($circle_as_name, $circle_eng_name, $cir_abbr, $updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10043 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10043 Unable to update data into District Location.');
                echo json_encode($data);
                return;
            }
            $this->dba->query($sql_update,
                array($circle_as_name, $circle_eng_name, $cir_abbr,
                    $updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));
            if($this->dba->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10044 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10044 Unable to update data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['circles'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code=? and 
                cir_code!=? and mouza_pargona_code=? and lot_no=? and 
                vill_townprt_code=? order by uuid desc",
                array($dist_code, $subdiv_code, '00',
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            echo json_encode($data);
            return;
        }
    }

    /************** SUB DIVISION ****************/

    /********** View SUB DIVISION Form *********/
    public function viewSubdivisionForm(){
        redirect(base_url() . 'index.php/home');
        $data['_view'] = 'Location/AddSubdivision';
        $this->load->view('layouts/main', $data);
    }

    //*********** Validate Subdiv Data *************//
    public function validateLocationSubdivData()
    {
        $this->dbswitch('auth');
        $data = null;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean|callback_districtValidate',
            ),
        );

        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');

            $data['subdivs'] = $this->db->query("select * from location where 
            dist_code =? and subdiv_code!=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=? order by uuid desc",
                array($dist_code, '00', '00',
                    '00', '00','00000'))->result_array();

            $data['success'] = true;
        }
        echo json_encode($data);
    }

    //*********** CHECK DISTRICT VALIDATE *************//
    public function districtValidate()
    {
        $dist_code = $this->session->userdata('dist_code');

        $check = $this->db->query("select dist_code from location where 
            dist_code =? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and 
            vill_townprt_code=?",
            array($dist_code, '00', '00',
                '00', '00','00000'));
        if ($check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('districtValidate', 'Invalid Data.');
            return FALSE;
        }
    }

    //********** Save New Sub Division *****************//
    public function saveNewSubdiv()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdiv_as_name',
                'label' => 'Sub Division Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'subdiv_eng_name',
                'label' => 'Sub Division English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $dist_code = $this->session->userdata('dist_code');
            $cir_code = '00';
            $mouza_code = '00';
            $lot_no = '00';
            $vill_townprt_code = '00000';

            $subdiv_as_name = $this->input->post('subdiv_as_name');
            $subdiv_eng_name = strtoupper($this->input->post('subdiv_eng_name'));

            $check = $this->input->post('check');

            $data['exist'] = null;
            if($check == 'Y')
            {
                $check_sql = "select loc_name, locname_eng, uuid, cir_abbr from location 
                            where dist_code=? and subdiv_code!=? and cir_code=? 
                            and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?
                            and (loc_name like '%$subdiv_as_name%' or locname_eng like '%$subdiv_eng_name%')";
                $check_res = $this->db->query($check_sql,
                    array($dist_code,'00','00','00','00','00000'));
                if($check_res->num_rows()>0)
                {
                    $data['exist'] = $check_res->result();
                    echo json_encode($data);
                    return;
                }
            }

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Get max UUID *************/
            $uuid = $this->dba->query("select max(uuid)+1 as uuid from location")->row();

            $subdiv_code = null;
            /*********** Get max code *************/
            $subdiv_code_data = $this->db->query("select max(CAST(subdiv_code as int)) as subdiv_code from 
                location where dist_code=? and subdiv_code!=? and cir_code=? 
                and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?",
                array($dist_code,'00','00','00','00','00000'))->row()->subdiv_code;
            if($subdiv_code_data == null)
            {
                $subdiv_code = "01";
            }else{
                if($subdiv_code_data < 9) {
                    $subdiv_code = $subdiv_code_data+1;
                    $subdiv_code = '0'.$subdiv_code;
                }else{
                    $subdiv_code = ((int)$subdiv_code_data)+1;
                }
            }

            /*********** Get dist_abbr from district *************/
            $loc_data = $this->db->query("select dist_abbr from 
                location where dist_code=?",
                array($dist_code))->row();

            /*********** Insert Array *************/
            $new_loc = array();
            $new_loc['dist_code'] = $dist_code;
            $new_loc['subdiv_code'] = $subdiv_code;
            $new_loc['cir_code'] = $cir_code;
            $new_loc['mouza_pargona_code'] = $mouza_code;
            $new_loc['lot_no'] = $lot_no;
            $new_loc['vill_townprt_code'] = $vill_townprt_code;
            $new_loc['loc_name'] = $subdiv_as_name;
            $new_loc['unique_loc_code'] = $dist_code.$subdiv_code.$cir_code.$mouza_code.$lot_no.$vill_townprt_code;
            $new_loc['locname_eng'] = $subdiv_eng_name;
            $new_loc['dist_abbr'] = $loc_data->dist_abbr;

            $new_loc['uuid'] = $uuid->uuid;
            $new_loc['user_code'] = $this->session->userdata('user_code');
            $new_loc['created_date'] = date('Y-m-d G:i:s');
            $new_loc['updated_date'] = date('Y-m-d G:i:s');

            /*********** Insert Into Central Auth Location *************/
            $insert_auth = $this->dba->insert('location',$new_loc);
            if($insert_auth != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10051 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10051 Unable to insert data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Insert Into Central Auth Location *************/
            $insert_db = $this->db->insert('location',$new_loc);
            if($insert_db != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10052 Unable to insert data.';
                $data['flag'] = true;
                log_message('error', '#LOC10052 Unable to insert data into '.$dist_code.' Location');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['subdivs'] = $this->db->query("select * from location where 
                    dist_code =? and subdiv_code!=? and 
                    cir_code=? and mouza_pargona_code=? and lot_no=? and 
                    vill_townprt_code=? order by uuid desc",
                array($dist_code, '00', '00',
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            $data['uuid'] = $uuid->uuid;
            echo json_encode($data);
            return;
        }
    }

    //********** Save Edit Sub Division *****************//
    public function editNewSubdiv()
    {
        $this->dbswitch($this->session->userdata('dist_code'));
        $data = null;
        $data['flag'] = false;
        $data_array = array(
            array(
                'field' => 'distcode',
                'label' => 'District',
                'rules' => 'trim|required|is_natural|xss_clean',
            ),
            array(
                'field' => 'subdiv_as_name',
                'label' => 'Sub Division Assamese Name',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'subdiv_eng_name',
                'label' => 'Sub Division English Name',
                'rules' => 'trim|required|xss_clean|callback_englishRegex_check'
            ),
        );

        /*********** Validation *************/
        $this->form_validation->set_rules($data_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($data_array as $rule) {
                if (form_error($rule['field'])) {
                    $data['error'][] = form_error($rule['field']);
                }
            }
            echo json_encode($data);
            return;
        } else {
            $data['validation'] = true;

            $uuid = $this->input->post('uuid');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->input->post('mouzacode');
            $lot_no = $this->input->post('lotcode');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $subdiv_as_name = $this->input->post('subdiv_as_name');
            $subdiv_eng_name = strtoupper($this->input->post('subdiv_eng_name'));

            /*********** Transactions Begin *************/
            $this->db->trans_begin();
            $this->dba = $this->load->database('auth', TRUE);
            $this->dba->trans_begin();

            /*********** Update *************/
            $updated_date = date('Y-m-d G:i:s');
            $sql_update = "update location set loc_name=?, locname_eng=?, 
                        updated_date=?, user_code=? where uuid=? and dist_code=? and 
                        subdiv_code=? and cir_code=? and 
                        mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $this->db->query($sql_update,
                array($subdiv_as_name, $subdiv_eng_name, $updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10053 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10053 Unable to update data into District Location.');
                echo json_encode($data);
                return;
            }
            $this->dba->query($sql_update,
                array($subdiv_as_name, $subdiv_eng_name,
                    $updated_date,$this->session->userdata('user_code'),
                    $uuid, $dist_code,$subdiv_code,$cir_code,$mouza_code,
                    $lot_no,$vill_townprt_code));
            if($this->dba->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->dba->trans_rollback();
                $data['t_error'] = '#LOC10054 Unable to update data.';
                $data['flag'] = true;
                log_message('error', '#LOC10054 Unable to update data into Central Auth Location.');
                echo json_encode($data);
                return;
            }

            /*********** Commit into District DB *************/
            $this->db->trans_commit();

            /*********** Commit into Central Auth DB *************/
            $this->dba->trans_commit();

            $data['subdivs'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code!=? and 
                cir_code=? and mouza_pargona_code=? and lot_no=? and 
                vill_townprt_code=? order by uuid desc",
                array($dist_code, '00', '00',
                    '00', '00','00000'))->result_array();
            $data['t_error'] = false;
            echo json_encode($data);
            return;
        }
    }
    ///////////////////
    function removeVillage(){
        $uuid = $this->input->post('uuid');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->input->post('mouzacode');
        $lot_no = $this->input->post('lotcode');
        /////////////
        $numMainCon = $this->db->query("select * from location where 
                    uuid=?",array($uuid));
        $numMain =$numMainCon->num_rows();
        //echo $this->db->last_query();
        if($numMain > 1){
            $data['t_error'] = $numMain." ##Same Village ID available";
            echo json_encode($data);
            return;
        }
        $mainData=$numMainCon->row_array();
        //var_dump($mainData);
        $sql3="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $chithaData=$this->db->query($sql3,array($mainData['dist_code'],$mainData['subdiv_code'],$mainData['cir_code'],$mainData['mouza_pargona_code'],$mainData['lot_no'],$mainData['vill_townprt_code']))->num_rows();
        if($chithaData>1)
        {
            $data['t_error'] = $chithaData." ##Chitha Records available";
            echo json_encode($data);
            return;
        }
        $sql4="Select * from jama_patta where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $jamaData=$this->db->query($sql3,array($mainData['dist_code'],$mainData['subdiv_code'],$mainData['cir_code'],$mainData['mouza_pargona_code'],$mainData['lot_no'],$mainData['vill_townprt_code']))->num_rows();
        if($jamaData >1)
        {
            $data['t_error'] = $jamaData." ##Jama Records available";
            echo json_encode($data);
            return;
        }
        $this->dba = $this->load->database('auth', TRUE);
        $numAuth = $this->dba->query("select * from location where 
                    uuid=?",array($uuid))->num_rows();
        if($numAuth==1 && $numMain==1){
            $this->dba->query("delete from location where 
                    uuid=?",array($uuid));
            log_message('error',$this->dba->last_query());
            //echo $this->db->affected_rows();
            if($this->dba->affected_rows()==1){
                $this->db->query("delete from location where 
                    uuid=?",array($uuid));
                $data['villages'] = $this->db->query("select * from location where 
                dist_code =? and subdiv_code=? and 
                cir_code=? and mouza_pargona_code=? and lot_no=? and 
                vill_townprt_code!=? order by uuid desc",
                array($dist_code, $subdiv_code, $cir_code,
                    $mouza_code, $lot_no,'00000'))->result_array();
                $data['t_error'] = false;
                echo json_encode($data);
                return;
            }else{
                $data['t_error'] = "##0001919 Error in removing";
                echo json_encode($data);
                return;
            }
        }else{
                $data['t_error'] = "##0001920 Error in removing";
                echo json_encode($data);
                return;
        }
    }
}
