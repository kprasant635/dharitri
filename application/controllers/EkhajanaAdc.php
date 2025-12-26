<?php


class EkhajanaAdc extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('eKhajana/EkhajanaAdc/EkhajanaAdcModel');
        $this->load->model('eKhajana/Common/EkhajanaHelperModel');
        $this->load->model('eKhajana/EkhajanaCO/EkhajanaCoModel');
        $this->load->library('AES');
        $this->dbswitch();
    }

    //db switch method
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

    //script-validation-callback
    function check_script($str){

        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }
        
        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }

    //date-validation-callback
    function date_valid($date){
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
            return false;
        
        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);                        
        return checkdate($month, $day, $year);
    }

    //index method of adc end
    public function index()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        if(in_array($this->session->userdata('dist_code'),EKHAJANA_EXCLUDE_DISTRICT_FROM_EKHAJANA_PROCESS))
        {
            echo json_encode("E-Khajana Service is on Hold For This District. Will be resumed Soon");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['pendingCount'] = $this->EkhajanaAdcModel->pendingForAdcCount($dist_code);
        $data['_view'] = 'e_khajana/adc_views/index';
        $this->load->view('layouts/main',$data);
    }

    //methd to get pending list in adc end 
    public function pendingList()
    {
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['pendingList'] = $this->EkhajanaAdcModel->pendingForAdcList($dist_code);
        $data['_view'] = 'e_khajana/adc_views/pending_list';
        $this->load->view('layouts/main',$data);       
    }

    //method to get pending case details in adc end
    public function pendingCaseDetails($id)
    {
        $data['caseDetails'] = $caseDetails = $this->EkhajanaAdcModel->getPendingCaseDetailsFromId($id);
        $data['arrear_data'] = $this->EkhajanaAdcModel->getArrearData($caseDetails->dist_code, 
            $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, 
            $caseDetails->lot_no, $caseDetails->vill_townprt_code, $caseDetails->patta_type_code, $caseDetails->patta_no);
        $data['_view'] = 'e_khajana/adc_views/pending_case_details';
        $this->load->view('layouts/main',$data);
    }

    //method to dipsose case by adc in dharitree
    public function AdcDisposeCase(){
        error_reporting(0);
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
    
        $error_msg = array();
        $adc_validation = [
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'dist_code',
                'label' => 'District code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'subdiv_code',
                'label' => 'Sub division code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'cir_code',
                'label' => 'Circle code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'lot No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village town port Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'is_urban',
                'label' => 'Is urban',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'patta_type',
                'label' => 'Patta Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[150]'
            ],
            [
                'field' => 'patta_type_code',
                'label' => 'Patta type code',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[4]'
            ],
            [
                'field' => 'pdar_id',
                'label' => 'pdar id',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'pdar_name',
                'label' => 'pdar name',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'pdar_father_name',
                'label' => 'pdar father name',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[20]'
            ],
            [
                'field' => 'applicant_name_eng',
                'label' => 'applicant name in english',
                'rules' => 'required|callback_check_script|trim|xss_clean||max_length[100]'
            ],
            [
                'field' => 'applicant_name_asm',
                'label' => 'applicant name in assamese',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            // [
            //     'field' => 'guardian_name_eng',
            //     'label' => 'gurdian name in english',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_name_asm',
            //     'label' => 'gurdian name in assamese',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            // ],
            // [
            //     'field' => 'guardian_relation',
            //     'label' => 'gurdian relation',
            //     'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            // ],
            [
                'field' => 'date_of_birth',
                'label' => 'date of birth',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid'
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            [
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[200]'
            ],
            [
                'field' => 'mobile_no',
                'label' => 'mobile no',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[10]'
            ],
            [
                'field' => 'rtps_doc_id',
                'label' => 'rtps document id',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'co_report',
                'label' => 'CO Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'lm_report',
                'label' => 'lm Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'tn_report',
                'label' => 'Tn Branch Report',
                'rules' => 'required|trim|max_length[200]'
            ],
            [
                'field' => 'aadhaar_pan_ref_no',
                'label' => 'Aadhar Ref No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'aadhaar_pan_type',
                'label' => 'Aadhar Pan Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[20]'
            ],
        ];
        $this->form_validation->set_rules($adc_validation);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($adc_validation as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $posted_data = $_POST;

        //checks after revenue year change
        if (date('Y-m-d') >= EKHAJANA_NEW_REVENUE_YEAR_START_DATE) {
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'e-Khazana case processing has been temporarily restricted as the Doul for the revenue year 2025–2026 is yet to be approved. Processing will resume once the Doul is approved.']);
            exit;
            $doul_approval_status = null;
            //checkDoulApproval 2025
            $check_doul_approval_query = $this->db->query("select * from current_dp_doul_approve where dist_code=? and subdiv_code=? and cir_code=? and yeardoul=? ",array($_POST['dist_code'], $_POST['subdiv_code'],$_POST['cir_code'],doul_year_no));
            if($check_doul_approval_query->num_rows() == 0)
            {
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'DP Doul For The Current Revenue Year Has Not Been Generated,Kindly genrated The Doul before Disposing  Application..!!']);
                exit;
            }else{
                $doul_approval_status = $check_doul_approval_query->row()->status;
            }
            if($doul_approval_status == 'A')
            {   
                $dhar_db = $this->db;
                $dhar_db->trans_begin();
                //check if 26 nos of pre arrear rows are present before disposing the application
                $ekh_year_wise_arr_query = $dhar_db->query("select * from ekhajana_year_wise_arrear_dp_estate where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and year_arrear is not null order by revenue_year desc", array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']));

                $ekh_year_wise_arr_count = $ekh_year_wise_arr_query->num_rows(); 
                $last_row = $ekh_year_wise_arr_query->result()[0]->revenue_year;
                $year = doul_year_no;
                $old_year = ($year-1);
                $current_demand_archive = 'current_dp_doul_demand_'.$old_year;
                if($last_row =='2024' && $ekh_year_wise_arr_count =='25'){
                    $archive_doul_query = $dhar_db->query("select * from $current_demand_archive where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
                    and lot_no =? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']));
                    if($archive_doul_query->num_rows() == 0)
                    {
                        log_message("error","#ERRARCDNF001 archive doul demand not found for the patta with last query".json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => '#ERRARCDNF001 Some Error Occurred Please contact System Admin..']);
                        exit;
                    }
                    $archive_doul =  $archive_doul_query->row();
                    $ekhajana_arrear_pre_updation_table_row = $dhar_db->query("select * from ekhajana_arrear_pre_updation_dp_estate where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code =?
                                    and lot_no =? and vill_townprt_code=? and patta_type_code =? and patta_no =? ",array($_POST['dist_code'],$_POST['subdiv_code'],$_POST['cir_code'],$_POST['mouza_pargona_code'],
                                    $_POST['lot_no'],$_POST['vill_townprt_code'],$_POST['patta_type_code'],$_POST['patta_no']))->row();
                    
                    $pre_arrear_revenue     =  $archive_doul->dag_revenue + $ekhajana_arrear_pre_updation_table_row->revenue;
                    $pre_arrear_tax         =  $archive_doul->dag_local_tax + $ekhajana_arrear_pre_updation_table_row->tax;
                    $pre_arrear_arrear      =  $archive_doul->dag_local_tax + $archive_doul->dag_revenue + $ekhajana_arrear_pre_updation_table_row->arrear;
                    $pre_arrear_surcharge   =  $archive_doul->surcharge + $ekhajana_arrear_pre_updation_table_row->surcharge;
                    $pre_arrear_id          =  $ekhajana_arrear_pre_updation_table_row->id;
                    
                    $update_pre_arrear= array(
                        'revenue'           => $pre_arrear_revenue,
                        'tax'               => $pre_arrear_tax,
                        'arrear'            => $pre_arrear_arrear,
                        'surcharge'         => $pre_arrear_surcharge,
                        'modified_at'       => date('Y-m-d h:i:s'),
                    );
                    $dhar_db->where('id', $pre_arrear_id);
                    $dhar_db->update('ekhajana_arrear_pre_updation_dp_estate', $update_pre_arrear);    
                    if($dhar_db->affected_rows() != 1){ 
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in update, table 'ekhajana_arrear_pre_updation_dp_estate'  with query- ". ($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012']);
                        exit;
                    }

                    //inserting into  in pre arrear table year wise table
                    $year_wise_arrear= array(
                            'pre_arrear_id'         => $pre_arrear_id,
                            'dist_code'             => $_POST['dist_code'],
                            'subdiv_code'           => $_POST['subdiv_code'],
                            'cir_code'              => $_POST['cir_code'],            
                            'mouza_pargona_code'    => $_POST['mouza_pargona_code'],
                            "lot_no"                => $_POST['lot_no'],
                            "vill_townprt_code"     => $_POST['vill_townprt_code'],
                            'village_uuid'          => $ekhajana_arrear_pre_updation_table_row->village_uuid,
                            'patta_type_code'       => $_POST['patta_type_code'],
                            'patta_no'              => $_POST['patta_no'],
                            'total_arrear'          => $pre_arrear_arrear,
                            'total_revenue'         => $pre_arrear_revenue,
                            'total_tax'             => $pre_arrear_tax,
                            'total_surcharge'       => $pre_arrear_surcharge,
                            'user_code'             => $this->session->all_userdata()['user_code'],
                            'financial_year'        => ekhajana_previous_financial_year,
                            'year_arrear'           => $archive_doul->dag_revenue + $archive_doul->dag_local_tax + $archive_doul->surcharge,
                            'year_revenue'          => $archive_doul->dag_revenue,
                            'year_tax'              => $archive_doul->dag_local_tax,
                            'year_surcharge'        => $archive_doul->surcharge,
                            "created_at"            => date('Y-m-d h:i:s'),
                            'modified_at'           => null,
                            "status"                => PORT_DOUL_PRE_ARREAR_UPDATE_STATUS,
                            "revenue_year"          => $archive_doul->year_no,
                            'modified_at'           => date('Y-m-d h:i:s'),
                        );
                    $tstatus38 = $dhar_db->insert('ekhajana_year_wise_arrear_dp_estate', $year_wise_arrear);
                    if ($tstatus38 != 1)
                    {
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR0012, Error in insert on ekhajana_year_wise_arrear_dp_estate table with query- ". json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR0012']);
                        exit;
                    }

                    $update_year_wise =array(
                        'total_arrear'          => $pre_arrear_arrear,
                        'total_revenue'         => $pre_arrear_revenue,
                        'total_tax'             => $pre_arrear_tax,
                        'total_surcharge'       => $pre_arrear_surcharge,
                    );
                    $dhar_db->where('pre_arrear_id', $pre_arrear_id);
                    $dhar_db->update('ekhajana_year_wise_arrear_dp_estate', $update_year_wise);    
                    if($dhar_db->affected_rows() != 26){ 
                        $dhar_db->trans_rollback();
                        log_message("error", "#EKHPAUR001845, Error in update, table 'ekhajana_year_wise_arrear_dp_estate'  with query- ". json_encode($dhar_db->last_query()));
                        echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHPAUR001845']);
                        exit;
                    }

                } 
                $count_pre_year_wise = $dhar_db->query("select count(*) as count from ekhajana_year_wise_arrear_dp_estate where dist_code=? and subdiv_code=? 
                                            and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and
                                            patta_type_code=? and patta_no=? and year_arrear is not null ", array($_POST['dist_code'], $_POST['subdiv_code'], 
                                            $_POST['cir_code'], $_POST['mouza_pargona_code'], $_POST['lot_no'], $_POST['vill_townprt_code'],
                                            $_POST['patta_type_code'], $_POST['patta_no']))->row()->count;
                if($count_pre_year_wise != 26){
                    log_message("error", "EKHMOUYEARWARRNF,ekhajana_year_wise_arrear_dp_estate not found to be 26 count for ". $_POST['ld_application_no']);
                    echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Arrear for the Previous revenue year has not been entered by concerned Mouzadar, Kindly ask to re-enter the arrear data again..']);
                    exit;
                }else{
                    $dhar_db->trans_commit();
                }
            }else{
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Dp Doul For The Current Revenue Year Has Not Been Approved From DC, Hence application cannot be forwarded..!!']);
                exit;
            }

        }

        
        //****************************************/
        date_default_timezone_set('Asia/Kolkata');
        $getJamaWasilData = $this->EkhajanaAdcModel->CheckJamaWasil($posted_data);
        
        if(!$getJamaWasilData){
        
            $checkArearData = $this->EkhajanaAdcModel->getEkhajanaArrearDetails($posted_data);
            if(!$checkArearData){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDC001']);
                exit;
            }else{
                $ArrearData = $this->EkhajanaAdcModel->getEkhajanaArrearDetails($posted_data);
                $ekBasicDetails = $this->EkhajanaAdcModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            if(!$ekBasicDetails){
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDC002']);
                exit;
            }
            $pre_arrear_data = $this->EkhajanaAdcModel->getPreArrearDetails($posted_data);
            if($pre_arrear_data =='NO-DATA-FOUND')
            {
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHEKPADA002']);
                exit;  
            }
            $currentDpDoulDemand = $this->EkhajanaAdcModel->getCurrentDpDoulDemand($posted_data);
            if($currentDpDoulDemand =='NO-DATA-FOUND')
            {
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHEKPADA003']);
                exit;  
            }
            //financial_year
            if (date('m') <= 6) {
                $financial_year = (date('Y')-1) . '-' . date('Y');
            } else {
                $financial_year = date('Y') . '-' . (date('Y') + 1);
            }

            $financial_year = ekhajana_financial_year;
            //if payment is done by self
            if($ArrearData->payment_by == "self"){
                $_POST['payee_name'] = null;
                $_POST['payee_relation'] = null;
                $_POST['payee_contact_no'] = null;
                $_POST['payee_email'] = null;
            }
            //jama_wasil_table_data_array
            $jama_wasil_data = [
                "dist_code"             => $ekBasicDetails->dist_code,
                "subdiv_code"           => $ekBasicDetails->subdiv_code,
                "cir_code"              => $ekBasicDetails->cir_code,
                "mouza_pargona_code"    => $ekBasicDetails->mouza_pargona_code,
                "lot_no"                => $ekBasicDetails->lot_no,
                "vill_townprt_code"     => $ekBasicDetails->vill_townprt_code,
                "village_uuid"          => $ekBasicDetails->village_uuid,
                "patta_type_code"       => $ekBasicDetails->patta_type_code,
                "patta_no"              => $ekBasicDetails->patta_no,
                "dag_no"                => "", 
                "financial_year"        => $financial_year,
                "entry_year"            => date('Y'),
                "entry_date"            => date('Y-m-d'),
                "revenue"               => $currentDpDoulDemand->dag_revenue,
                "local_tax"             => $currentDpDoulDemand->dag_local_tax,
                "surcharge"             => $pre_arrear_data->surcharge, 
                "opening_balance"       => $pre_arrear_data->arrear, // total arrear = arrear + surcharge
                "due_payment"           => $currentDpDoulDemand->dag_revenue + $currentDpDoulDemand->dag_local_tax 
                                           + $currentDpDoulDemand->surcharge + $pre_arrear_data->revenue 
                                           + $pre_arrear_data->tax + $pre_arrear_data->surcharge , 
                                            //$pre_arrear_data->arrear includes surcharge also so $pre_arrear_data->surcharge
                                            //  should not be added again 
                "other_payment"                 => null,
                "last_revenue_payment_amount"   => $ArrearData->last_revenue_payment, 
                "last_local_tax_payment_amount" => $ArrearData->last_local_tax_payment,
                "dol_year_no"           => $pre_arrear_data->doul_year_no,
                "pdar_id"               => $ekBasicDetails->pdar_id, 
                "pdar_name"             => $ekBasicDetails->pdar_name,
                "pdar_father_name"      => $ekBasicDetails->pdar_father_name,
                "status"                => JAMA_WASIL_STATUS_OFFLINE, 
                "created_at"            => date('Y-m-d h:i:s'),
                "modified_at"           => null,
                'user_code'             => $this->session->all_userdata()['user_code'],
                "application_no"        => $ArrearData->application_no,
                "ld_application_no"     => $ArrearData->ld_application_no,
                "case_no"               => $ArrearData->case_no,
                "pay_status"            => JAMA_WASIL_STATUS_UNPAID,
                "is_dp"                 => 'Y',
            ];

            //jama_wasil_payee_list_data
            $jama_wasil_payee_list_data = [
                "dist_code"         => $ekBasicDetails->dist_code,
                "subdiv_code"       => $ekBasicDetails->subdiv_code,
                "cir_code"          => $ekBasicDetails->cir_code,
                "mouza_pargona_code"=> $ekBasicDetails->mouza_pargona_code,
                "lot_no"            => $ekBasicDetails->lot_no,
                "vill_townprt_code" => $ekBasicDetails->vill_townprt_code,
                "village_uuid"      => $ekBasicDetails->village_uuid,
                "patta_type_code"   => $ekBasicDetails->patta_type_code,
                "patta_no"          => $ekBasicDetails->patta_no,
                "dag_no"            => "",
                "pdar_id"           => $ekBasicDetails->pdar_id, 
                "pdar_name"         => $ekBasicDetails->pdar_name,
                "pdar_father_name"  => $ekBasicDetails->pdar_father_name,
                "payment_by"        => $ArrearData->payment_by,
                "payee_name"        => $_POST['payee_name'],
                "payee_contant_no"  => $_POST['payee_contact_no'],
                "payee_relation"    => $_POST['payee_relation'],
                "payee_email"       => $_POST['payee_email'],
                "created_at"        => date('Y-m-d h:i:s'),
                "modified_at"       => null,
                'user_code'         => $this->session->all_userdata()['user_code'],
                "application_no"    => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no"           => $ArrearData->case_no,
            ];

            //jama_wasil_backup_data
            $jama_wasil_backup_table_data = [
                "data"              => json_encode($_POST),
                "action"            => 'JAMA_WASIL_ACTION_ADC_REGISTRATION',
                'user_data'         => json_encode($this->session->all_userdata()),
                'ip_address'        => $this->session->all_userdata()['ip_address'],
                "created_at"        => date('Y-m-d h:i:s'),
                "application_no"    => $ArrearData->application_no,
                "ld_application_no" => $ArrearData->ld_application_no,
                "case_no"           => $ArrearData->case_no
            ];
        
            $insertdata = $this->EkhajanaAdcModel->AdcdisposeCaseDpEstate($posted_data,$ArrearData,$ekBasicDetails,
            $jama_wasil_data,$jama_wasil_payee_list_data,$jama_wasil_backup_table_data);
            echo json_encode($insertdata);
        }
        }else{
            $ekBasicDetails = $this->EkhajanaAdcModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
            $updateData = $this->EkhajanaAdcModel->AdcdisposeCaseDpEstateWithoutInsert($posted_data,$ekBasicDetails,$getJamaWasilData);
            echo json_encode($updateData);
            
        }
    }


    public function verifyMouzadarAccount()
    {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $getAllMouzadarDetails = $this->EkhajanaAdcModel->getAllMouzadarDetails($dist_code);
        if($getAllMouzadarDetails['result'] =='SERVER-ERROR'){
            echo "Error In Fetching Mouzadar Bank Account Details";
            log_message("error","#ERRBANKMOU Error In Fetching Mouzadar Bank Account Details");
        }
        $data['getAllMouzadarDetails'] = $getAllMouzadarDetails['msg'];
        $data['_view'] = 'e_khajana/adc_views/mouzadarBankDetails';
        $this->load->view('layouts/main',$data);
    }

    public function MouzadarVerifiedSubmit()
    {
     
        $all_data = array();
        foreach($_POST['account_code'] as $account_code_ins){
            list($account_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code) = explode('_', $account_code_ins);
            $formated_data = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'account_code' => $account_code,
            ];
            array_push($all_data,$formated_data);
        }
        $update_in_basundhara = $this->EkhajanaAdcModel->updateAdcVerifed(json_encode($all_data));
        echo json_encode($update_in_basundhara); 
    }


    public function EcfrMouzadarDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['ecfr_data'] = $this->EkhajanaAdcModel->getEcfrDetails($dist_code);
        if($data['ecfr_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['ecfr_details'] = $data['ecfr_data']['msg'];
        $data['_view'] = 'e_khajana/adc_views/ecfr_report';
        $this->load->view('layouts/main',$data);
        
    }

    public function MouzadarDashboard()
    {
        $data['dist_code'] = $dist_code = $this->session->userdata('dist_code');
        $data['mouzadari_data'] = $this->EkhajanaAdcModel->getMouzadariDetails($dist_code);
        if($data['mouzadari_data']['flag'] == 'ERROR'){
            echo "Some error Occurred In Fetching Details.. Kindly Try After Some Time";
            exit;
        }
        $data['mouzadari_details'] = $data['mouzadari_data']['msg'];
        $data['_view'] = 'e_khajana/adc_views/mouzadari_report';
        $this->load->view('layouts/main',$data);
    }

    //case reject with category in mouzadari system
    public function rejectCaseDpEstate(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "ADC"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        $ld_application_no = $_POST['ld_application_no'];
        $ekBasicDetails = $this->EkhajanaCoModel->getEkBasicDetailsFromldAppNo($_POST['ld_application_no']);
        //checking whether the pattadar is identifeid before rejecting
        if($_POST['adc_pattadar_identification_flag']=='Y'){
            $link_aadhaaar = $this->EkhajanaCoModel->linkAadharInRejectCase($ekBasicDetails);
            if($link_aadhaaar['result'] == false){
                log_message('error', 'linking aadhaar pattadar identified2'.$link_aadhaaar);
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKIAUCRL0086']);
                exit;
            }
        }
        //***********************validation-starts*****************/
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');
        $error_msg = array();
        $validation = [
            [
                'field' => 'ek_details_id',
                'label' => 'ID',
                'rules' => 'required|callback_check_script|trim|xss_clean|integer'
            ],
            [
                'field' => 'application_no',
                'label' => 'Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'ld_application_no',
                'label' => 'Land Details Application No',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'case_no',
                'label' => 'case number',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[100]'
            ],
            [
                'field' => 'reject_code',
                'label' => 'Reject Reason(Atleast-One)',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason(Other)',
                'rules' => 'required|trim|callback_check_script|xss_clean|min_length[50]',
            ],
            [
                'field' => 'patta_no',
                'label' => 'patta no',
                'rules' => 'required',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters entered in %s field');
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($validation as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************validation-end*****************/
        
        $posted_data = $_POST;
        $rejectedFlag = $this->EkhajanaAdcModel->rejectCaseDpEstate($posted_data);
        echo json_encode($rejectedFlag);
    }

}
?>

