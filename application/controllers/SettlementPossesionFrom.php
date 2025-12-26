<?php


class SettlementPossesionFrom extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('AES');
        $this->load->model('SettlementPossessionFrom/SettlementPossesionFromModel');
        $this->load->model('basundhara/SettlementApiModel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('NcModel/NcServiceModel');
        $this->load->model('Bhoodan/ADC/BhoodanAdcModel');
        $this->load->model('Bhoodan/BhoodanModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('basundhara3/ReclassCommonDcModel');
        $this->load->model('basundhara3/reclassSuiteADCModel');
        $this->load->model('basundhara3/reclassModel');
        $this->load->model('basundhara3/reclassPullModel');
        $this->load->model('SettlementMb/SettlementTenantUrbanDcModel');
        
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

    public function index()
    {
        //***************checking-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code']              = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code']            = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code']               = $cir_code = $this->session->userdata('cir_code');
        $data['mouza_pargona_code']     = $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $data['lot_no']                 = $lot_no = $this->session->userdata('lot_no'); 
        $data['wrong_possesion_from']   = $this->SettlementPossesionFromModel->getWrongPossessionFromData($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
        // echo "<pre>";
        // var_dump($data['wrong_possesion_from']);
        // exit;
        $data['_view'] = 'possession_from/lm_views/possession_from_landing_page';
        $this->load->view('layouts/main',$data);
       
    }

    //masud reza code
    //view Application details
    public function viewApplicationDetailsOnly()
    {
        $case_no        = trim($this->input->get('case'));
        $application_no = trim($this->input->get('case'));
        $dist_code      = trim($this->session->userdata('dist_code'));
        $caseCount      = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        $caseCountReCla = $this->ReclassCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        $data['wrong_possession_from_flag'] = 'yes';


        if($caseCount == 0 AND $caseCountReCla == 0)
        {
            $this->getCaseSearchCommon();
        }
        else
        {
            if($caseCount == 0)
            {
                $caseDetails = $this->ReclassCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            }
            if($caseCountReCla == 0)
            {
                $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);
            }

            $inArr = 0;
            if (in_array($caseDetails->service_code, MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if (in_array($caseDetails->service_code, MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if (in_array($caseDetails->service_code, NC_SERVICE_CODE_ALLOW_FOR_PROPOSAL) )
            {
                $inArr = 1;
            }
            if ($caseDetails->service_code == RECLASS_ID)
            {
                $inArr = 1;
            }
            if ($caseDetails->service_code == SETTLEMENT_TENANT_URBAN_ID)
            {
                $inArr = 1;
            }

            if($inArr == 0)
            {
                echo 'Coming soon';
                die();
            }


            // khas land
            if($caseDetails->service_code == SETTLEMENT_KHAS_LAND_ID)
            {
                $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
                $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;

                }
                $data['encdata']=$lmdata;

                $data['basic']=$basic;

                $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['dhardocuments']=$dhardocuments;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;
                $data['premium'] = $this->SettlementCommonModel->getPremium($application_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_KHAS_LAND_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }
                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'settlementView/Dc/Common/application_details_common_khas';
                $this->load->view('layouts/main', $data);
            }

            // Ap Transfer
            if($caseDetails->service_code == SETTLEMENT_AP_TRANSFER_ID)
            {
                $basic   = $this->SettlementApModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementApModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementApModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementApModel->getAllApplicantEncroacher($application_no);
                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);

                $dags   = $this->SettlementApModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementApModel->getSettlementApLmNote($application_no);
                $proceedings   = $this->SettlementApModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementApModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);

                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }

                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'settlementView/Dc/Common/application_details_common_ap';
                $this->load->view('layouts/main', $data);

            }

            // tribal
            if($caseDetails->service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID)
            {   
                // $data['wrong_possession_from_flag'] = 'yes';
                $basic   = $this->SettlementTribalModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementTribalModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementTribalModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementTribalModel->getAllApplicantEncroacher($application_no);
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementTribalModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementTribalModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementTribalModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementTribalModel->getDocuments($application_no);

                $data['basic']=$basic;

                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;

                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);
                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TRIBAL_COMMUNITY_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }

                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tribal';
                $this->load->view('layouts/main', $data);

            }

            // special cultivator tea
            if($caseDetails->service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID)
            {
                
                $basic   = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementKhasModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementKhasModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);

                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->SettlementCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_SPECIAL_CULTIVATORS_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }
                $data['wrong_possession_from_flag'] = 'yes';
                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tea';
                $this->load->view('layouts/main', $data);

            }

            // vgr pgr
            if($caseDetails->service_code == SETTLEMENT_PGR_VGR_LAND_ID)
            {

                $basic   = $this->SettlementVgrModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->SettlementVgrModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementVgrModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementVgrModel->getAllApplicantEncroacher($application_no);
                $reservation   = $this->SettlementVgrModel->getSettlementReservation($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    if($encroacher->enc_id==null || $encroacher->enc_id==""){

                        $this->session->set_flashdata('message', "Case no # $encroacher->case_no encroacher not avaialble");
                        redirect(base_url() . 'index.php/Home/index');

                    }else{

                        $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                        // echo $query; die();
                        $encdata=$this->db->query($query)->result();



                        $data[] = $encdata;
                    }

                }
                $data['encdata']=$data;

                $dags   = $this->SettlementVgrModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementVgrModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementVgrModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementVgrModel->getDocuments($application_no);
                $vgrReservation = $this->SettlementVgrModel->getSettlementVgrReservation($application_no);

                $data['basic']=$basic;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;
                $data['reservation']=$reservation;
                $data['vgrReservation']=$vgrReservation;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);

                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_PGR_VGR_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_PGR_VGR_LAND_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'SettlementView/Dc/Common/application_vgr_view';
                $this->load->view('layouts/main',$data);
            }

            // tenant
            if($caseDetails->service_code == SETTLEMENT_TENANT_ID)
            {
                $basic   = $this->SettlementTenantModel->getSettlementBasic($application_no);
                //  result
                $applicants_buyers = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok   = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);

                $dags   = $this->SettlementTenantModel->getSettlementDag($application_no);
                $lmnotes   = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->SettlementTenantModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->SettlementTenantModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;
                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);

                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }


                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';

                }

                $data['_view'] = 'settlementView/Dc/Common/application_details_common_tenant';
                $this->load->view('layouts/main', $data);

            }


            // MB3

            // Institution land
            if($caseDetails->service_code == SLIJE_ID)
            {
                $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
                $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;

                }
                $data['encdata']=$lmdata;

                $data['basic']=$basic;

                $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['dhardocuments']=$dhardocuments;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;
                $data['premium'] = $this->db->query("SELECT *  from settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SLIJE_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }
                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }
                $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($application_no));

                $data['ins_data'] = $sql->result();
                $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($application_no);

                $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();
                $data['_view'] = 'settlementView/Dc/Common/application_details_common_ins';
                $this->load->view('layouts/main', $data);
            }

            // Bhoodan land
            if($caseDetails->service_code == BHODDAN_SERVICE_CODE)
            {

                $basic = $this->BhoodanModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->BhoodanModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->BhoodanModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->BhoodanModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->BhoodanModel->getAllApplicantRioteeNok($application_no);
                $dags = $this->BhoodanModel->getSettlementDag($application_no);
                $lmnotes = $this->BhoodanModel->getSettlementTenantLmNote($application_no);
                $proceedings = $this->BhoodanModel->getSettlementProceeding($application_no);
                $dhardocuments = $this->BhoodanModel->getDocuments($application_no);
                $nominee = $this->BhoodanModel->getAllNomineeDetail($application_no);

                $lmdata = [];
                foreach ($applicants_encroacher as $encroacher) {
                    // getting the encroacher details
                    $query = "select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata = $this->db->query($query)->result();
                    $lmdata[] = $encdata;
                }

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }


                $premium_data = $this->SettlementCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;
                $data['encdata'] = $lmdata;
                $data['basic'] = $basic;
                $data['applicants_buyers'] = $applicants_buyers;
                $data['applicants_owners'] = $applicants_owners;
                $data['applicants_encroacher'] = $applicants_encroacher;
                $data['applicants_riotee_nok'] = $applicants_riotee_nok;
                $data['dags'] = $dags;
                $data['lmnotes'] = $lmnotes;
                $data['proceedings'] = $proceedings;
                $data['dhardocuments'] = $dhardocuments;
                $data['nominee'] = $nominee;
                $data['deleted_dags'] = $this->SettlementCommonModel->getDeletedDags($application_no);

                $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
                $data['caseCount']     = $caseCount;
                $data['caseDetails']   = $caseDetails;
                $data['proceedings']   = $proceedings;



                $data['reservation']   = $this->SettlementVgrModel->getSettlementReservation($application_no);

                foreach ($data['applicants_encroacher'] as $applicant_enc)
                {
                    $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

                    if ($enc_check->num_rows() > 0) {

                        $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid, $enc_check->row()->dag_no, $enc_check->row()->encroacher_id));

                        // echo $this->db->last_query();
                        if ($sql_land_bank->num_rows() > 0) {
                            $added_enc_data[] = $sql_land_bank->row();
                        }
                    }
                }



                if (isset($added_enc_data)) {
                    $data['new_added_enc_data'] = $added_enc_data;
                }

                $data['additional_property'] = $this->BhoodanModel->getAdditionalProperty($application_no);
                $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

                if (isset($areaModificationCheck)) {
                    if ($areaModificationCheck) {
                        foreach ($areaModificationCheck as $areaHis) {
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

                                if (($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)) {

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            } else {
                                $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                                $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                                $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                                $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                                //check if area modified
                                if (($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)) {

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            }
                        }
                    }
                }

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc = $this->SettlementCommonModel->getDeletedEncroacher($application_no);
                $deletedEncArray = array();
                foreach ($deletedEnc as $encroacherDeleted_data) {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags = $this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach ($deletedDags as $deleteDag) {
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(BHODDAN_SERVICE_CODE);
                if ($rejected_data == 'n') {
                    $data['rejected_list'] = false;
                } else {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach (json_decode(VALIDATION_BYPASS_BHOODAN) as $val_bypas) {
                    if ($val_bypas->SERVICE_CODE == BHODDAN_SERVICE_CODE) {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $checkArea = 0;
                $totalLandArea = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa = 0;

                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag) {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if ((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea) {
                        $checkArea = 1;
                    }
                }
                else {
                    foreach ($data['dags'] as $singleDag) {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag) {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if ((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach ($data['lmnotes'] as $lm_rr) {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if ($decoded_r) {
                        foreach ($decoded_r as $lm_rejected_code) {
                            if (isset($lm_rejected_code->reject_code)) {
                                if (in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)) {
                                    $data['validation_bypass'] = 1;
                                }
                            } else {
                                if (in_array($lm_rejected_code, $const_bypass_arr_code)) {
                                    $data['validation_bypass'] = 1;
                                }
                            }
                        }
                    }
                }

                $data['reject_list_type'] = '';

                foreach ($lmnotes as $r_remark)
                {
                    $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                    if ($rejected_list_json) {
                        foreach ($rejected_list_json as $re_list) {

                            if (isset($re_list->reject_code)) {
                                $r_code = $re_list->reject_code;
                            } else {
                                $r_code = $re_list;
                            }

                            $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                            if ($sql->row()->remark_head != null) {
                                $data['reject_list_type'] = 'new';
                            } else {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $data['checkAppliedArea'] = $checkArea;
                $data['_view'] = 'Bhoodan/ADC/bhoodan_app_details_only';
                $this->load->view('layouts/main', $data);

            }

            // NC khas land
            if($caseDetails->service_code == NC_KHAS_LAND_ID)
            {

                $service_code          = NC_KHAS_LAND_ID;
                $basic                 = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($application_no);
                $applicants_buyers     = $this->NcCommonSdoAdcDcModel->getAllNcApplicantBuyers($application_no);
                $applicants_owners     = $this->NcCommonSdoAdcDcModel->getAllNcApplicantOwners($application_no);
                $applicants_encroacher = $this->NcCommonSdoAdcDcModel->getAllNcApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->NcCommonSdoAdcDcModel->getAllNcApplicantRioteeNok($application_no);
                $dags                  = $this->NcCommonSdoAdcDcModel->getNcApplicationDag($application_no);
                $lmNotes               = $this->NcCommonSdoAdcDcModel->getNcLmNote($application_no);
                $proceedings           = $this->NcCommonSdoAdcDcModel->getNcApplicationProceeding($application_no);
                $documents             = $this->NcCommonSdoAdcDcModel->getNcDocuments($application_no);
                $nominee               = $this->NcCommonSdoAdcDcModel->getAllNcNomineeDetail($application_no);
                $premium_data          = $this->NcCommonSdoAdcDcModel->getNcPremium($application_no);
                $deleted_dags          = $this->NcCommonSdoAdcDcModel->getNcDeletedDags($application_no);

                $lmData = [];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $encData = $this->NcCommonSdoAdcDcModel->getAllNcEncroacherDetailsWithId($encroacher->enc_id);
                    $lmData[] = $encData;
                }

                // for guardian relation
                $relation = $this->NcCommonSdoAdcDcModel->getNcGuardRelation();
                $row      = $relation->num_rows();
                if ($row != 0)
                {
                    $data['guar_rel'] = $relation->result();
                }


                $data['premium_data']          = $premium_data;
                $data['premium']               = $premium_data;
                $data['encdata']               = $lmData;
                $data['basic']                 = $basic;
                $data['applicants_buyers']     = $applicants_buyers;
                $data['applicants_owners']     = $applicants_owners;
                $data['applicants_encroacher'] = $applicants_encroacher;
                $data['applicants_riotee_nok'] = $applicants_riotee_nok;
                $data['dags']                  = $dags;
                $data['lmnotes']               = $lmNotes;
                $data['proceedings']           = $proceedings;
                $data['dhardocuments']         = $documents;
                $data['nominee']               = $nominee;
                $data['deleted_dags']          = $deleted_dags;

                $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];
                $data['caseCount']     = $caseCount;
                $data['caseDetails']   = $caseDetails;
                $data['reservation']   = $this->NcCommonSdoAdcDcModel->getNcReservation($application_no);


                foreach($data['applicants_encroacher'] as $applicant_enc)
                {
                    $enc_check = $this->NcCommonSdoAdcDcModel->getNcLandBankDetails($caseDetails->applid,$applicant_enc->dag_no);

                    if($enc_check->num_rows() > 0)
                    {
                        $enc_Data = $enc_check->row();
                        $sql_land_bank = $this->NcCommonSdoAdcDcModel->getNcLandBankDetailsWithVillage($enc_Data->land_bank_details_id, $enc_Data->uuid,$enc_Data->dag_no,$enc_Data->encroacher_id);
                        if($sql_land_bank->num_rows() > 0)
                        {
                            $added_enc_data[] = $sql_land_bank->row();
                        }
                    }
                }

                if(isset($added_enc_data))
                {
                    $data['new_added_enc_data'] = $added_enc_data;
                }


                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc = $this->NcCommonSdoAdcDcModel->getNcDeletedEncroacher($application_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags = $deleted_dags;
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;


                $rejected_data = $this->NcCommonSdoAdcDcModel->getNcRejectModal(NC_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }


                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == NC_KHAS_LAND_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['additional_property'] = $this->NcCommonSdoAdcDcModel->getNcAdditionalProperty($application_no);

                $checkArea = 0;
                $totalLandArea = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa = 0;
                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->ncutility->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );

                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->ncutility->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda

                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
                else
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->ncutility->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->ncutility->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;

                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }


                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                        }
                    }
                }

                $data['reject_list_type'] = '';

                foreach($lmNotes as $r_remark)
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

                            $rejectedHead = $this->NcCommonSdoAdcDcModel->getNcRejectHead($r_code);
                            if($rejectedHead->remark_head != null)
                            {
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $data['checkAppliedArea'] = $checkArea;

                $data['_view'] = 'NcVillageService/Common/application_details_common_khas';
                $this->load->view('layouts/main', $data);
            }

            // NC tribal
            if($caseDetails->service_code == NC_TRIBAL_ID)
            {
                $basic   = $this->NcServiceModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->NcServiceModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->NcServiceModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->NcServiceModel->getAllApplicantEncroacher($application_no);
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->NcServiceModel->getSettlementDag($application_no);
                $lmnotes   = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->NcServiceModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->NcServiceModel->getDocuments($application_no);

                $data['basic']=$basic;

                $reservation   = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;

                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;


                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB3."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);
                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $data['premium_data'] = $this->NcCommonModel->getPremium($application_no);

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->NcCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->NcCommonModel->getRejectModal(NC_TRIBAL_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $data['_view'] = 'NcVillageService/Common/application_details_common_tribal';
                $this->load->view('layouts/main', $data);

            }

            // NC special cultivator tea
            if($caseDetails->service_code == NC_CULTIVATOR_ID)
            {
                $basic   = $this->NcServiceModel->getSettlementBasic($application_no);
                $applicants_buyers   = $this->NcServiceModel->getAllApplicantBuyers($application_no);
                $applicants_owners   = $this->NcServiceModel->getAllApplicantOwners($application_no);
                $applicants_encroacher   = $this->NcServiceModel->getAllApplicantEncroacher($application_no);

                $data=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $data[] = $encdata;

                }
                $data['encdata']=$data;

                $dags   = $this->NcServiceModel->getSettlementDag($application_no);
                $lmnotes   = $this->NcServiceModel->getSettlementTenantLmNote($application_no);
                $proceedings   = $this->NcServiceModel->getSettlementProceeding($application_no);
                $dhardocuments   = $this->NcServiceModel->getDocuments($application_no);

                $data['basic']=$basic;
                $data['reservation'] = $this->NcServiceModel->getSettlementReservation($application_no);
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;

                $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();
                $url = API_LINK_MB3."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);

                $data['document']=$output->documents;
                $data['query']=$output->query;
                $data['property']=$output->property;
                $data['aadhar']=$output->aadhar;
                $data['nextKin']=$output->nextKin;
                foreach($output->selfDeclaration as $selfDec){
                    $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->NcCommonModel->getPremium($application_no);
                $data['premium_data'] = $premium_data;
                $data['premium'] = $premium_data;

                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->NcCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;
                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->NcCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->NcCommonModel->getRejectModal(NC_CULTIVATOR_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }
                $data['_view'] = 'NcVillageService/Common/application_details_common_tea';
                $this->load->view('layouts/main', $data);

            }

            // Reclass
            if ($caseDetails->service_code == RECLASS_ID)
            {
                $basic= $this->reclassModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->reclassModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->reclassModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->reclassModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->reclassModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->reclassModel->getSettlementDag($application_no);
                $lmnotes = $this->reclassModel->getSettlementTenantLmNote($application_no);
                $proceedings = $this->reclassModel->getSettlementProceeding($application_no);
                $dhardocuments = $this->reclassModel->getDocuments($application_no);
                $nominee = $this->reclassModel->getAllNomineeDetail($application_no);


                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;
                }

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }

                $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;

                $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' ")->row();
                $data['premium_data_lm'] = $premium_data_lm;


                $data['encdata']=$lmdata;
                $data['basic']=$basic;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;
                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['proceedings']=$proceedings;
                $data['dhardocuments']=$dhardocuments;
                $data['nominee'] = $nominee;
                $data['deleted_dags']=$this->SettlementCommonModel->getDeletedDags($application_no);


                $caseCount = $this->reclassSuiteADCModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $data['chithaArea']    = '';
                $data['reservedArea']  = '';
                $data['areaCheck']     = '';
                $data['appliedDags']   = '';
                $data['lmProcessArea'] = '';


                $caseDetails = $this->reclassSuiteADCModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);

                //var_dump($caseDetails);exit;
                $proceedings = $this->reclassSuiteADCModel->getSettlementProceeding($case_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;
                $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);

                foreach($data['applicants_encroacher'] as $applicant_enc){
                    $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

                    if($enc_check->num_rows() > 0){

                        $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid,$enc_check->row()->dag_no,$enc_check->row()->encroacher_id));

                        // echo $this->db->last_query();
                        if($sql_land_bank->num_rows() > 0){
                            $added_enc_data[] = $sql_land_bank->row();
                        }
                    }
                }

                if(isset($added_enc_data)){
                    $data['new_added_enc_data'] = $added_enc_data;
                }


                $data['additional_property'] = $this->SettlementKhasModel->getAdditionalProperty($application_no);


                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == RECLASS_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }


                $checkArea = 0;
                $totalLandArea = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa = 0;
                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );

                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda

                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
                else
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;

                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }


                $data['checkAppliedArea'] = $checkArea;

                $data['_view'] = 'reclass_suite/Adc/reclass_app_details_only_view';
                $this->load->view('layouts/main', $data);

            }

            // Urban Tenant
            if ($caseDetails->service_code == SETTLEMENT_TENANT_URBAN_ID) {


                // $application_no        = $this->input->get('case');
                $basic                 = $this->SettlementApModel->getSettlementBasic($application_no);
                $applicants            = $this->SettlementApModel->getAllApplicant($application_no);
                $dags                  = $this->SettlementApModel->getSettlementDag($application_no);
                $lmnotes               = $this->SettlementApModel->getSettlementApLmNote($application_no);
                $proceedings           = $this->SettlementApModel->getSettlementProceeding($application_no);
                $dhardocuments         = $this->SettlementApModel->getDocuments($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_buyers     = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners     = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);
                $dags                  = $this->SettlementApModel->getSettlementDag($application_no);


                $data['basic']                 = $basic;
                $data['applicants']            = $applicants;
                $data['dags']                  = (array) $dags[0];
                $data['lmnotes']               = $lmnotes;
                $data['proceedings']           = $proceedings;
                $data['dhardocuments']         = $dhardocuments;
                $data['applicants_encroacher'] = $applicants_encroacher;
                $data['applicants_buyers']     = $applicants_buyers;
                $data['applicants_owners']     = $applicants_owners;
                $data['applicants_riotee_nok'] = $applicants_riotee_nok;
                $data['validation_bypass']     = 0;

                $sql        = "Select basundhara from basundhar_application where dharitree='$application_no' ";
                $basundhara = $this->db->query($sql)->row();

                $url = API_LINK_MB3 . "serviceResponseBasu?application_no=" . $basundhara->basundhara;
                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                $output = curl_exec($ch);
                curl_close($ch);
                $output = json_decode($output);
                //var_dump($output);
                $data['document'] = $output->documents;
                $data['query']    = $output->query;
                $data['property'] = $output->property;
                $data['aadhar']   = $output->aadhar;
                $data['nextKin']  = $output->nextKin;
                foreach ($output->selfDeclaration as $selfDec) {
                    $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
                }

                $caseCount = $this->SettlementTenantUrbanDcModel->countSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);

                if ($caseCount == 0) {
                    $this->getCaseSearchCommon();
                } else {
                    $caseDetails         = $this->SettlementTenantUrbanDcModel->getSettlementAppDetailsByCaseNoOnlyView($case_no, $dist_code);
                    $proceedings         = $this->SettlementTenantUrbanDcModel->getSettlementProceeding($case_no);
                    $data['caseCount']   = $caseCount;
                    $data['caseDetails'] = $caseDetails;
                    $data['proceedings'] = $proceedings;

                    $data['_view'] = 'SettlementView/Dc/TenantUrban/settlement_app_details_only_view_tenant';
                    $this->load->view('layouts/main', $data);
                }
            }



            // Tea Grant
            if ($caseDetails->service_code == TEA_SERVICE_CODE)
            {
                $this->load->model('TeaGrant/LM/TeaGrantModel');
                $this->load->model('TeaGrant/ADC/TeaGrantAdcModel');
                $basic                  = $this->TeaGrantModel->getSettlementBasic($application_no);
                $applicants_buyers      = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
                $applicants_owners      = $this->TeaGrantModel->getAllApplicantOwners($application_no);
                $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

                $adcdata                = [];
                $dags                   = $this->TeaGrantModel->getSettlementDag($application_no);
                $lmnotes                = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
                $proceedings            = $this->TeaGrantModel->getSettlementProceeding($application_no);
                $dhardocuments          = $this->TeaGrantModel->getDocuments($application_no);
                $nominee                = $this->TeaGrantModel->getAllNomineeDetail($application_no);
                $existing_pattadar      = $this->TeaGrantModel->getAllExistingPattadar($application_no);
                $deed_applicant         = $this->TeaGrantModel->getAllDeedPattadar($application_no);
                $family_tree            = $this->TeaGrantModel->getAllFamilyTree($application_no);

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }

                // $premium_data                   = $this->SettlementCommonModel->getPremium($application_no);
                $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
                $data['premium_data']           = $premium_data;
                $data['premium']                = $premium_data;

                $data['encdata']                = $adcdata;
                $data['basic']                  = $basic;
                $data['applicants_buyers']      = $applicants_buyers;
                $data['applicants_owners']      = $applicants_owners;
                $data['applicants_dag_details'] = $applicants_dag_details;
                $data['dags']                   = $dags;
                $data['lmnotes']                = $lmnotes;
                $data['proceedings']            = $proceedings;
                $data['dhardocuments']          = $dhardocuments;
                $data['nominee']                = $nominee;
                $data['deleted_dags']           = $this->SettlementCommonModel->getDeletedDags($application_no);

                $data['existing_pattadar']      = $existing_pattadar;
                $data['deed_applicant']         = $deed_applicant;
                $data['family_tree']            = $family_tree;

                $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                
                $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

                $data['chithaArea']    = $checkAreaDetails['chithaArea'];
                $data['reservedArea']  = $checkAreaDetails['reservedArea'];
                $data['areaCheck']     = $checkAreaDetails['areaCheck'];
                $data['appliedDags']   = $checkAreaDetails['appliedDags'];
                $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

                $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
                $proceedings         = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;
                $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
                $data['additional_property'] = $this->TeaGrantModel->getAdditionalProperty($application_no);

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

                                    $data['area_modified'] = $areaModificationCheck;
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

                                    $data['area_modified'] = $areaModificationCheck;
                                }
                            }
                        }
                    }
                }

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS_TEA_GRANT) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == TEA_SERVICE_CODE)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }


                $checkArea                   = 0;
                $totalLandArea               = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa   = 0;

                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );

                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda

                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
                else
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                        }
                    }
                }

                $data['reject_list_type'] = '';

                foreach($lmnotes as $r_remark)
                {
                    $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);
                    if($rejected_list_json)
                    {
                        foreach ($rejected_list_json as $re_list)
                        {
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
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                // get basundhara appl no from basundhar application table
                $basundharCaseNo = $this->TeaGrantModel->fromBasundharApplication($case_no);
                $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($basundharCaseNo);
                if($get_aadhaar_photo != 'n'){
                  $data['base64_decoded_adhar_file'] = "<img src = data:".$this->TeaGrantModel->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $data['checkAppliedArea'] = $checkArea;
                $data['_view'] = 'TeaGrant/ADC/TeaGrantPullBackViewOnly';
                $this->load->view('layouts/main', $data);


            }



        }
    }

    // case search page
    public function getCaseSearchCommon()
    {
        $dist_code = $this->session->userdata('dist_code');
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng 
        from location where dist_code='$dist_code' and cir_code!='00' and  mouza_pargona_code='00' and  
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data['circles']    = $circle->result();
        $data['dist_code']  = $dist_code;
        $data['cases']      = '';
        $data['casesCount'] = 0;

        $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
        $this->load->view('layouts/main', $data);

    }

    // search data
    public function searchCasesWithData()
    {
        $caseNo        = trim($this->input->post('caseNo'));
        $applicationNo = trim($this->input->post('applicationNo'));
        $serviceType   = trim($this->input->post('serviceType'));
        $appStatus     = trim($this->input->post('appStatus'));
        $pendingOffice = trim($this->input->post('pendingOffice'));
        $fromDate      = trim($this->input->post('fromDate'));
        $toDate        = trim($this->input->post('toDate'));
        $selectCircle  = trim($this->input->post('selectCircle'));
        $dist_code     = $this->session->userdata('dist_code');
        $rezaBhai      = 0;
        $cases         = '';
        $casesCount    = 0;

        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng 
                from location where dist_code='$dist_code' and cir_code!='00' and  mouza_pargona_code='00' and  
                vill_townprt_code='00000' and lot_no='00' order by loc_name ");
        $data['circles']   = $circle->result();
        $data['dist_code'] = $dist_code;


        if($applicationNo == 'RTPS-OMUT/2022/12649' || $caseNo == 'GOL/DER/2022-23/7767/OMUT')
        {
            $this->load->model('CurlModel');
            $applId = '20471416';

            $get_attachement_api_link = "https://landhub.assam.gov.in/webapi/dhar_api_land/mutation/mutation_case_details.php?application_ref_no=$applicationNo&applid=$applId";

            $api_response = $this->CurlModel->apiCall($get_attachement_api_link);

            $data['files'] = $api_response["data"][0]->attachment;
            $data['_view'] = 'settlementView/Dc/Common/get_Attachment_List';
            $this->load->view('layouts/main', $data);
        }



        if ($caseNo == '' AND $applicationNo == '' AND $serviceType == '' AND $appStatus == '' AND $pendingOffice == '' AND $fromDate == '' AND $toDate == '' AND $selectCircle == '' )
        {
            $data['cases']      = '';
            $data['casesCount'] = 0;
            $data['reClass']    = $rezaBhai;

            $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            // only case number
            if($caseNo != '')
            {
                $cases = $this->SettlementCommonDcModel->getCasesByCaseNo($caseNo);
                if($cases->num_rows() == 0)
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByCaseNoReCla($caseNo);
                    $rezaBhai = 1;
                }
                $data['cases']      = $cases->result();
                $data['casesCount'] = $cases->num_rows();
                $data['reClass']    = $rezaBhai;

                $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                $this->load->view('layouts/main', $data);
            }
            elseif ($applicationNo != '')
            {
                $cases = $this->SettlementCommonDcModel->getCasesByApplicationNo($applicationNo);
                if($cases->num_rows() == 0)
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByApplicationNoReCla($caseNo);
                    $rezaBhai = 1;
                }
                $data['cases']      = $cases->result();
                $data['casesCount'] = $cases->num_rows();
                $data['reClass']    = $rezaBhai;

                $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                $this->load->view('layouts/main', $data);
            }
            else
            {
                if($fromDate != '' AND $toDate != '')
                {
                    $cases = $this->SettlementCommonDcModel->getCasesByRespectedDataWithDateRage
                    ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);

                    $data['cases']      = $cases->result();
                    $data['casesCount'] = $cases->num_rows();
                    $data['reClass']    = $rezaBhai;

                    $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                    $this->load->view('layouts/main', $data);
                }
                else
                {

                    if($serviceType == RECLASS_ID)
                    {
                        $cases = $this->SettlementCommonDcModel->getCasesByRespectedDataReCla
                        ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);
                        $rezaBhai = 1;
                    }
                    else
                    {
                        $cases = $this->SettlementCommonDcModel->getCasesByRespectedData
                        ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate);
                    }


                    $data['cases']      = $cases->result();
                    $data['casesCount'] = $cases->num_rows();
                    $data['reClass']    = $rezaBhai;

                    $data['_view'] = 'settlementView/Dc/Common/case_search_page_dc';
                    $this->load->view('layouts/main', $data);
                }
            }
        }
    }

    public function formSubmitFromLra()
    {
        $error_msg = array();
        $lm_approve_form_val = [
            [
                'field' => 'date_of_possession_modified',
                'label' => 'Modified Date Of posession',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'wrong_poseesion_from_remarks',
                'label' => 'LRA Remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'case_no',
                'label' => 'Case Number',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'existing_possession_from_date',
                'label' => 'Date Of Possession',
                'rules' => 'required|trim|xss_clean'
            ],
            
        ];
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules($lm_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($lm_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        $case_no = $this->input->post('case_no');
        $corrected_possession_from_date = $this->input->post('date_of_possession_modified');
        $existing_possession_from_date = $this->input->post('existing_possession_from_date');
        $lra_remarks = $this->input->post('wrong_poseesion_from_remarks');
        $support_doc_name = null;
        $support_doc_type = null;
        $support_doc_size = null;
        $file_uploading = "no";
        $file_path_uploaded = 'NA';
        $basic_pf_id = null;
        if(isset($_FILES['supporting_document_wrong_possession_document']) && $_FILES['supporting_document_wrong_possession_document']['size'] > 0)
        {
            $file_uploading = "yes";
            $support_doc_name = $_FILES['supporting_document_wrong_possession_document']['name'];
            $support_doc_type = $_FILES['supporting_document_wrong_possession_document']['type'];
            $support_doc_size = $_FILES['supporting_document_wrong_possession_document']['size'];
        }

        $basic = $this->db->query("select * from settlement_basic where case_no=?",array($case_no))->row();
        $application_no = $basic->applid;
        $chitha_pattadar_row = $this->db->query("select * from chitha_pattadar where o1_case_no =? and pdar_occupation is not null",array($case_no))->row();

        if($file_uploading == "yes")
        {
            $ext = explode("/",$support_doc_type);
            $extension =  $ext['1'];
            $fileRename = 'wrong_possession_from'.time(). '.' .$extension;
            $config['upload_path']   = UPLOAD_SUPPORTING_DOC_PATH_WRONG_POSSESSION_FROM;
            $config['allowed_types'] = EKHAJANA_UPLOAD_ALLOW_TYPE;
            $config['max_size']  = EKHAJANA_UPLOAD_MAX_SIZE;
            $config['file_name'] = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('supporting_document_wrong_possession_document'))
            {
                $file_path_uploaded = UPLOAD_SUPPORTING_DOC_PATH_WRONG_POSSESSION_FROM . $fileRename;

            }
            else
            {
                log_message("error","could not insert into ekhajana additional document  #EKHFU002");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Some Error Occured Please Try Again #EKHFU002!!!']);
                exit();
            }
        }
        $this->db->trans_begin();

        //checking if the new possession from date is less than the digital patta generated date
        $query = $this->db->query("SELECT created_at FROM digital_patta_all_data 
            WHERE application_no=?", array($application_no));

        if ($query->num_rows() == 0) {
            log_message("error", "#EKHPIOKJ200, No digital patta record found for patta_no - " . $chitha_pattadar_row->patta_no);
            echo json_encode([
                'result' => 'SERVER-ERROR',
                'msg' => 'No Digital Patta data found for this record. Please verify the Patta details : #EKHPIOKJ200'
            ]);
            exit;
        } else {
            $digital_patta_generated_date = $query->row()->created_at;
            $digi_patta_only_date = date('Y-m-d', strtotime($digital_patta_generated_date));
        }

        if (strtotime($corrected_possession_from_date) > strtotime($digi_patta_only_date)) {
            log_message("error", "#EKHPIOKJ201, corrected possession date is greater than digital patta generated date - " . $digital_patta_generated_date);
            echo json_encode([
                'result' => 'SERVER-ERROR',
                'msg' => 'Possession From date cannot be greater than the Digital Patta generated date, Please check again : #EKHPIOKJ201'
            ]);
            exit;
        }

        if (strtotime($corrected_possession_from_date) > strtotime(date('Y-m-d'))) {
            log_message("error", "#EKHPIOKJ202, corrected possession date is in the future - " . $corrected_possession_from_date);
            echo json_encode([
                'result' => 'SERVER-ERROR',
                'msg' => 'Possession From date cannot be a future date. Please check again : #EKHPIOKJ202'
            ]);
            exit;
        }

        $basic_insert_data =array(
            'dist_code'                     => $chitha_pattadar_row->dist_code,
            'subdiv_code'                   => $chitha_pattadar_row->subdiv_code,
            'cir_code'                      => $chitha_pattadar_row->cir_code,
            'mouza_pargona_code'            => $chitha_pattadar_row->mouza_pargona_code,
            'lot_no'                        => $chitha_pattadar_row->lot_no,
            'vill_townprt_code'             => $chitha_pattadar_row->vill_townprt_code,
            'patta_type_code'               => $chitha_pattadar_row->patta_type_code,
            'patta_no'                      => $chitha_pattadar_row->patta_no,
            'dharitree_case_no'             => $case_no,
            'rtps_case_no'                  => $application_no,
            'status'                        => 'P',
            'attachment_url'                => $file_path_uploaded,
            'lra_remark'                    => $lra_remarks,
            'lra_user_details'              => json_encode($this->session->userdata('user_code')),
            'lra_post_data'                 => json_encode($_POST),
            'possesion_from_correct_date'   => $corrected_possession_from_date,
            'possession_from_existing_date' => $existing_possession_from_date,
            'lra_forward_timestamp'         => date('Y-m-d h:i:s'),
            'created_at'                    => date('Y-m-d h:i:s'),
            'modified_at'                   => null,
        );
        $tstatus38 = $this->SettlementPossesionFromModel->insertBasicDetails($basic_insert_data);

        if (!$tstatus38) {
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0012, Error in insert on settlement_pf_basic table with query- " . $this->db->last_query());
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0012']);
            exit;
        }
        
        $basic_pf_query = $this->db->query("select * from settlement_pf_basic where dharitree_case_no=? order by id desc limit 1",array($case_no));
        if($basic_pf_query->num_rows() == 0)
        {
            $basic_pf_id = 1;
        }else{
            $basic_pf_id = $basic_pf_query->row()->id;
        }

        $proceed_insert_data =array(
            'settlement_pf_basic_id'    => $basic_pf_id,
            'dharitree_case_no'         => $case_no,
            'rtps_case_no'              => $application_no,
            'status'                    => 'P',
            'remark'                    => $lra_remarks,
            'user_code'                 => $this->session->userdata('user_code'),
            'user_details'              => json_encode($this->session->all_userdata()),
            'attachment_url'            => $file_path_uploaded,
            'created_at'                => date('Y-m-d h:i:s'),
            'modified_at'               => null
        );
        $tstatus39 = $this->SettlementPossesionFromModel->insertProceedingDetails($proceed_insert_data);
        if (!$tstatus39) {
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0012, Error in insert on settlement_pf_proceedings table with query- " . $this->db->last_query());
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0012']);
            exit;
        } else {
            $this->db->trans_commit();
            echo json_encode(['result' => 'SUCCESS', 'msg' => 'Case-Forwarded Successfully']);
        }
    }

    public function coLanding()
    {
        //***************checking-user-designation**********/
        if($this->session->userdata('user_desig_code') != "CO"){
            echo json_encode("Not Authorised!!");
            exit;
        }
        //**************************************************/
        $data['dist_code']              = $dist_code = $this->session->userdata('dist_code');
        $data['subdiv_code']            = $subdiv_code = $this->session->userdata('subdiv_code');
        $data['cir_code']               = $cir_code = $this->session->userdata('cir_code');
        $data['wrong_possesion_from']   = $this->SettlementPossesionFromModel->getWrongPossessionFromDataForCo($dist_code,$subdiv_code,$cir_code);
        // echo "<pre>";
        // var_dump($data['wrong_possesion_from']);
        // exit;
        $data['_view'] = 'possession_from/co_views/possesion_from_landing_page_co';
        $this->load->view('layouts/main',$data);
    }

    public function formSubmitFromCo()
    {
        $error_msg = array();
        $co_approve_form_val = [
            [
                'field' => 'wrong_poseesion_from_remarks_co',
                'label' => 'CO Remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'case_no',
                'label' => 'Case Number',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
            [
                'field' => 'chitha_remarks_correction',
                'label' => 'Chitha Remarks',
                'rules' => 'required|callback_check_script|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules($co_approve_form_val);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($co_approve_form_val as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        
        $case_no = $this->input->post('case_no');
        $co_remarks = $this->input->post('wrong_poseesion_from_remarks_co');
        $chitha_remarks_correction = $this->input->post('chitha_remarks_correction');

        $basic_pf_query = $this->db->query("select * from settlement_pf_basic where dharitree_case_no=? order by id desc limit 1",array($case_no))->row();
        $this->db->trans_begin();

        $chitha_basic_query = $this->db->query("select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
            and lot_no=? and vill_townprt_code=? and patta_type_code=? and patta_no=?",array($basic_pf_query->dist_code,$basic_pf_query->subdiv_code,$basic_pf_query->cir_code,
            $basic_pf_query->mouza_pargona_code,$basic_pf_query->lot_no,$basic_pf_query->vill_townprt_code,$basic_pf_query->patta_type_code,$basic_pf_query->patta_no))->result();
        
    
        foreach($chitha_basic_query as $row)
        {
            $remark_chitha_array =array(
                'dist_code'         => $basic_pf_query->dist_code,
                'subdiv_code'       => $basic_pf_query->subdiv_code,
                'cir_code'          => $basic_pf_query->cir_code,
                'mouza_pargona_code'=> $basic_pf_query->mouza_pargona_code,
                'lot_no'            => $basic_pf_query->lot_no,
                'vill_townprt_code' => $basic_pf_query->vill_townprt_code,
                'dag_no'            => $row->dag_no,
                'lm_note_cron_no'   => $count = $this->SettlementPossesionFromModel->getChithaRmkCountForDag($basic_pf_query->dist_code,$basic_pf_query->subdiv_code,$basic_pf_query->cir_code,$basic_pf_query->mouza_pargona_code,$basic_pf_query->lot_no,$basic_pf_query->vill_townprt_code,$row->dag_no),
                'rmk_type_hist_no'  => $count,
                'lm_note_lno'       => $count,
                'lm_note'           => $chitha_remarks_correction,
                'lm_note_date'      => $basic_pf_query->lra_forward_timestamp,
                'lm_code'           => $basic_pf_query->lra_user_details,
                'lm_sign'           => 'y',
                'co_approval'       => 'y',
                'user_code'         => $this->session->userdata('user_code'),
                'date_entry'        => date('Y-m-d h:i:s'),
                'operation'         => 'E', 
            );
            $tstatus78 = $this->SettlementPossesionFromModel->insertChithaRemarksDetails($remark_chitha_array);
            if (!$tstatus78) {
                $this->db->trans_rollback();
                log_message("error", "#EKHPAUR0087, Error in insert on chitha_rmk_lmnote table with query- " . $this->db->last_query());
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0087']);
                exit;
            }
        }
        
        $update_pf_basic = array(
            'status'                => 'F',
            'co_remark'             => $co_remarks,
            'co_user_details'       => json_encode($this->session->all_userdata()),
            'co_post_data'          => json_encode($_POST),
            'co_forward_timestamp'  => date('Y-m-d h:i:s'),
            'modified_at'           => date('Y-m-d h:i:s'),
        );
        $this->db->where('dharitree_case_no', $case_no);
        $this->db->update('settlement_pf_basic', $update_pf_basic);
        if($this->db->affected_rows() < 0){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0015, Error in update  table 'settlement_pf_basic' with query- ". json_encode($this->db->last_query()));
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0015']);
            exit;
        }


        $update_pf_basic = array(
            'status'                => 'F',
            'co_remark'             => $co_remarks,
            'co_user_details'       => json_encode($this->session->all_userdata()),
            'co_post_data'          => json_encode($_POST),
            'co_forward_timestamp'  => date('Y-m-d h:i:s'),
            'modified_at'           => date('Y-m-d h:i:s'),
        );
        $this->db->where('dharitree_case_no', $case_no);
        $this->db->update('settlement_pf_basic', $update_pf_basic);
        if($this->db->affected_rows() < 0){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0015, Error in update  table 'settlement_pf_basic' with query- ". json_encode($this->db->last_query()));
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0015']);
            exit;
        }

        $proceed_insert_data =array(
            'settlement_pf_basic_id'    => $basic_pf_query->id,
            'dharitree_case_no'         => $case_no,
            'rtps_case_no'              => $basic_pf_query->rtps_case_no,
            'status'                    => 'F',
            'remark'                    => $co_remarks,
            'user_code'                 => $this->session->userdata('user_code'),
            'user_details'              => json_encode($this->session->all_userdata()),
            'attachment_url'            => $basic_pf_query->attachment_url,
            'created_at'                => date('Y-m-d h:i:s'),
            'modified_at'               => null
        );
        $tstatus39 = $this->SettlementPossesionFromModel->insertProceedingDetails($proceed_insert_data);
        if (!$tstatus39) {
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0012, Error in insert on settlement_pf_proceedings table with query- " . $this->db->last_query());
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0012']);
            exit;
        }

        $chitha_pattadar_details = $this->SettlementPossesionFromModel->chithaPattadarDetailsFromCaseNo($case_no);
        if($chitha_pattadar_details == null)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHPAUR0021, No Data Found In Chitha pattadar table- " . $this->db->last_query());
            echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0021']);
            exit; 
        }

        foreach($chitha_pattadar_details as $row){
            $dist_code    = $row->dist_code;
            $subdiv_code  = $row->subdiv_code;
            $cir_code     = $row->cir_code;
            $mouza_pargona_code = $row->mouza_pargona_code;
            $lot_no             = $row->lot_no;
            $vill_townprt_code  = $row->vill_townprt_code;
            $patta_type_code    = $row->patta_type_code;
            $patta_no           = $row->patta_no;

            $update_data = array(
                'dist_code'         => $dist_code,
                'subdiv_code'       => $subdiv_code,
                'cir_code'          => $cir_code,
                'mouza_pargona_code'=> $mouza_pargona_code,
                'lot_no'            => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code'   => $patta_type_code,
                'patta_no'          => $patta_no,
                'possession_from'   => $basic_pf_query->possesion_from_correct_date
            );

            $tstatus39 = $this->SettlementPossesionFromModel->updateChithaBasicPossessionFrom($update_data);
            if ($tstatus39 <= 0) {
                $this->db->trans_rollback();
                log_message("error", "#EKHPAUR0020, Error in update table 'chitha_basic' with query- " . json_encode($this->db->last_query()));
                echo json_encode(['result' => 'SERVER-ERROR', 'msg' => 'Some error occurred, Error-Code : #EKHPAUR0020']);
                exit;
            }

        }
        $this->db->trans_commit();
        echo json_encode(['result' => 'SUCCESS', 'msg' => 'Posession From Date Corrected Successfully']);
    }

    public function viewSupportingDocument()
    {
        $case_no = $this->input->get('case_no', true);
        $query = $this->db->select('attachment_url')
                        ->from('settlement_pf_basic')
                        ->where('dharitree_case_no', $case_no)
                        ->get();
        if ($query->num_rows() > 0) {
                $row = $query->row();

                $file_path = $row->attachment_url;
                $path = $file_path;
                if (file_exists($path)) {
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="' . basename($path) . '"');
                    readfile($path);   
                    exit; 
                } else {
                    show_error('File not found: ' . $file_path, 404);
                }

        } else {
            show_error('No record found for case number: ' . $case_no, 404);
        }
    }
}
?>