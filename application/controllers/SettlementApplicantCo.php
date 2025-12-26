<?php
class SettlementApplicantCo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementApplicantModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementModel/SettlementKhasModel');

        // if(HOLD_All_MB2_CASES_STATUS == 1)
        // {
        //     if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
        //     {
        //         $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
        //         redirect(base_url() . "index.php/Home/index");
        //     }
        // }

    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }


    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null){
            $lot_string = $this->convertLiteral($lot_array);
        }
        //log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
    }



    /// NEW LIST FOR PULL REQUEST BY MASUD REZA




    /// ************* CO *************************


    // get all case list for modification // CO
    public function applicantEditCaseList()
    {
        $service_code = $this->input->get('service');

        if ($this->session->userdata('user_desig_code') == 'CO')
        {
            // in query it is checked as not equal to D status
            $status = 'D';
            $data['select_data'] = $this->SettlementApplicantModel->locationSelectCo($service_code, $status);

            $data['_view'] = 'SettlementView/Co/Applicant/SettlementApplicantEditCoView';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', " You are not Authorized for modification Request ");
            redirect(base_url() . "index.php/home");
        }
    }


    // paginate for modification case list // CO
    public function paginationForCoApplicantEditCases()
    {

        if(LOT_BIFURCATE_PULL == 1 && $this->session->userdata('user_desig_code') == 'CO')
        {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'updated_at',
            // 1   => 'applid',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }
        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        $this->db->limit($length, $start);
        $this->db->where('a.service_code', $s_code);


        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }
        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }
        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no))
        {
            if(isset($lot_string) && $lot_string != null)
            {
                $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
            }
        }

        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        // $this->db->select('distinct(a.application_no), a.dist_code, a.subdiv_code, a.cir_code, a.mouza_code, a.lot_no, a.vill_townprt_code, a.updated_at,a.status_dhar');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where_in('a.status_dhar',array('LY','LN'));
        $this->db->from('t_changed_data a');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                if($this->session->userdata('user_desig_code') == 'CO')
                {
                   
                    $verify_report_button = '<a type="button" href="' . base_url() . 'index.php/SettlementApplicantCo/applicationView?case=' . $rows->application_no . '" class="btn-sm btn btn-primary">
                    write report</a>';

                }

                if ($rows->changed_for == 1)
                {
                    $applicant_update = '<span class="text-danger"><strong><small>Joint Pattdar Updated</small></strong></span>';
                }
                else if ($rows->changed_for == 3)
                {
                    $applicant_update = '<span class="text-danger"><strong><small>Marital Status Updated</small></strong></span>';
                }

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->application_no . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->vill_code),

                    // $rows->date_entry,

                    $applicant_update,
                    // (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                    $verify_report_button
                );
            }

            $this->db->where('a.service_code', $s_code);
            if(LOT_BIFURCATE ==1 && empty($mouza_code) && empty($lot_no)){

                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
            if(!empty($mouza_code))
            {
                $this->db->where('a.mouza_code', $mouza_code);
            }
            if(!empty($mouza_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }
            if (!empty($lot_no) && !empty($mouza_code) && !empty($is_cat)) {
                $this->db->where('a.vill_code', $is_cat);
            }
            $this->db->select('distinct(a.application_no)');
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where_in('a.status_dhar',array('LY','LN'));
            $this->db->from('t_changed_data a');
            $query = $this->db->get();
            // echo $this->db->last_query(); die;
            $total_records =$query->num_rows();
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function applicationView()
    {
        $app_no = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $dist_code = $this->session->userdata('dist_code');
        $application_no = $this->utilityclass->getCaseNoByApplId((string)$dist_code, (string)$app_no);
        $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);

        $d=$basic['dist_code'];
        $s=$basic['subdiv_code'];
        $c=$basic['cir_code'];
        $m=$basic['mouza_pargona_code'];
        $l=$basic['lot_no'];

        // if ($user_desig_code == 'CO')
        // {
        //     $this->utilityclass->authCheckCoSk($application_no, 'CO');
        //     $this->utilityclass->checkUserAuthForCaseForCo($application_no);
        // }
        // else
        // {
        //     $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
        //     redirect(base_url() . "index.php/home");
        //     return false;
        // }
      

        if ($this->SettlementApplicantModel->checkCoAuth($app_no) == 'n')
        {
            $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
            redirect(base_url() . "index.php/home");
        }

        


        $applicants_new = $this->SettlementApplicantModel->getAllApplicantBuyers($app_no);
        $applicant_marital_status = $this->SettlementApplicantModel->getMainApplicantMaritalStatus($app_no);
        // var_dump($applicant_marital_status); die;
        
        $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
        $lmdata = [];
        $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementKhasModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);
        $nominee = $this->SettlementKhasModel->getAllNomineeDetail($application_no);

        $lm_report_from_proceedings = $this->SettlementApplicantModel->getLmReportProceeding($application_no);

        $lmdata['applicants_new'] = $applicants_new;
        $lmdata['applicant_marital_status'] = $applicant_marital_status;

        $lmdata['basic'] = $basic;
        $lmdata['nominee'] = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;
        $lmdata['lm_report_from_proceedings'] = $lm_report_from_proceedings;

        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        $url = API_LINK_MB2."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $applid,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);

                        if($aadhaarPhotoReCall == true)
                        {
                            $aadhar_path = $adhar_photo_link;
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $aadhaarPhotoReCall;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }
                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                endif;
            endif;
        endforeach;


        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->SettlementKhasModel->getJsonDataFromBackup($application_no);
        if(isset($getJsonBackup))
        {
            if($getJsonBackup)
            {
                $json_settlement =  json_decode($getJsonBackup->data);

                foreach($json_settlement->settlements as $jsonSettle)
                {
                    if($jsonSettle->is_applicant == 1)
                    {
                        $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
                        $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                    }
                }

            }
        }

        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        // $lmdata['premium_data'] = $premium_data;
        // $lmdata['premium'] = $this->SettlementCommonModel->getPremium($application_no);
        // $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        // $lmdata['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);

        foreach($lmdata['applicants_encroacher'] as $applicant_enc){
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

            if($enc_check->num_rows() > 0){
                $added_enc_data[] = $enc_check->row();
            }
        }
        if(isset($added_enc_data)){
            $lmdata['new_added_enc_data'] = $added_enc_data;
        }

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';

            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }

        $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

        if(isset($areaModificationCheck)){
            if($areaModificationCheck){
                foreach($areaModificationCheck as $areaHis){
                    $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                    $applied_area_home_katha = $areaHis->applied_area_home_katha;
                    $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                    $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                    $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                    $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                    $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                    $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                    $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                    $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                    $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                    $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                    $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                    $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                    $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                    $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                    $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                    $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                    $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                    $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }

                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }

        // $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

        // $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        // $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        // $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        // $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        // $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }


        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == SETTLEMENT_KHAS_LAND_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $lmdata['validation_bypass'] = 0;

        foreach($lmdata['lmnotes'] as $lm_rr)
        {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

            if($decoded_r){
                foreach($decoded_r as  $lm_rejected_code)
                {
                    if(isset($lm_rejected_code->reject_code))
                    {
                        if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    else
                    {
                        if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    
                }
            }
           
        }

        $lmdata['reject_list_type'] = '';

        foreach($lmnotes as $r_remark)
        {
            $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

            if($rejected_list_json)
            {
                foreach ($rejected_list_json as $re_list) {

                    if(isset($re_list->reject_code))
                    {
                        $r_code = $re_list->reject_code;
                    }
                    else
                    {
                        $r_code = $re_list;
                    }

                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));
    
                    if($sql->row()->remark_head != null)
                    {
                        $lmdata['reject_list_type'] = 'new';
                    }
                    else
                    {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }

        $lmdata['_view'] = 'SettlementView/Co/Applicant/SettlementApplicantCoView';
        $this->load->view('layouts/main', $lmdata);
    }


    public function coReportSubmit()
    {

        $dist_code = $this->session->userdata('dist_code');
        $application_no = $this->input->post('case_no');

        $case_no = $this->utilityclass->getCaseNoByApplId((string)$dist_code, (string)$application_no);
        $remark_co = $this->input->post('remark_co');
        $remark_co_type = $this->input->post('remark_co_type');

        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);

        if ($this->SettlementApplicantModel->checkCoAuth($application_no) == 'n')
        {
            $this->session->set_flashdata('message', "Unauthorized access for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        if ($remark_co_type =='Approved'){
          $applicant_edit_status = 'CY';
        }else{
          $applicant_edit_status = 'CN';
        }

       
        $is_citizen_data = 1;
        $this->db->trans_begin();

        if ($applicant_edit_status == 'CY')
        {

            $applicants_new = $this->SettlementApplicantModel->getAllApplicantBuyersCo($application_no);
            if(!empty($applicants_new))
            {
                foreach($applicants_new as $appnew)
                {
                    //*******pdar_cron number generation */
                    // $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = ? order by pdar_cron_no desc";
                    // $result = $this->db->query($sql, array($case_no));
                    $result = $this->SettlementApplicantModel->getPdarCronNo($case_no);
                    if($result->num_rows() > 0){
                        $cron_no = (int)$result->row()->pdar_cron_no + 1;
                    }else{
                        $cron_no = 1;
                    }

                    $applicant=array(
                        'dist_code'=>$appnew->dist_code,
                        'subdiv_code'=>$appnew->subdiv_code,
                        'cir_code'=>$appnew->cir_code,
                        'mouza_pargona_code'=>$appnew->mouza_code,
                        'lot_no'=>$appnew->lot_no,
                        'vill_townprt_code'=>$appnew->vill_code,
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no,
                        'petition_no'=>$basic['petition_no'],
                        'operation'=>'E',
                        'dag_no' => 0,
                        'patta_no' => 0,
                        'patta_type_code' => 0,
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' => '-1',
                        'pdar_cron_no'=>$cron_no,
                        'pdar_name' =>$appnew->name_ass,
                        'pdar_guardian' =>$appnew->gurdian_name_ass,
                        'eng_pdar_name' => $appnew->name_eng,
                        'eng_pdar_guardian' => $appnew->gurdian_name_eng,
                        'pdar_rel_guar' =>$appnew->gurdian_relation_id,
                        'pdar_gender'=>$appnew->gender,
                        'pdar_add1' => $appnew->pre_add,
                        'pdar_add2' => $appnew->per_add,
                        'pdar_mobile' => $appnew->mobile,

                        'pdar_type' => 'B',
                        'is_applicant' => 0,
                        'marital_status' => $appnew->marital_status,
                        'dob' => $appnew->dob,
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                    // echo $this->db->last_query(); die();

                    if ($insSetApplicant != 1)
                    {

                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET600035: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET600035: Application submit failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                    $is_citizen_data = 1;
                }
                
            }
            else
            {
                $is_citizen_data = 0;
            }

            $applicant_marital_status = $this->SettlementApplicantModel->getMainApplicantMaritalStatusCo($application_no);
            if(!empty($applicant_marital_status))
            {
                foreach($applicant_marital_status as $mstatus)
                {
                    $updateMstatus = [
                        'date_update' => date('Y-m-d h:i:s'),
                        'marital_status' => $mstatus->marital_status,
                    ];
                    $this->db->where('case_no', $case_no);
                    $this->db->where('is_applicant', 1);
                    $this->db->update('settlement_applicant', $updateMstatus);
            
                    if ($this->db->affected_rows() == 0) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRC9O0543434: Failed to submit report by CO');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRC9O0543434: Failed to submit report by CO. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    $is_citizen_data = 1;

                }
                
            }
        }
        
        
        if($is_citizen_data == 1)
        {
            $updateArr = [
                'updated_at' => date('Y-m-d h:i:s'),
                'status_dhar' => $applicant_edit_status,
            ];
            $this->db->where('application_no', $application_no);
            $this->db->update('t_changed_data', $updateArr);
    
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRC4O05437743: Failed to forward to CO');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRC4O05437743: Failed to forward to CO. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }


            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'AE',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'LM',
                'office_to' => 'CO',
                'task' => 'Applicant Modifications '.$remark_co_type.' by CO',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRC8O0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRC8O0004: Failed to report by DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Case no # $case_no $remark_co_type by CO");
                redirect(base_url() . "index.php/home");

            }

        }
        else
        {
            $this->session->set_flashdata('message', "No records to update for case no # ".$case_no);
            redirect(base_url() . "index.php/home");
        }


        
    
    }


    public function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }

}
