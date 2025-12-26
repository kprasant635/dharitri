<?php
class SettlementAp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
        $this->dbswitch();


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
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
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    // Settlement AP CO view starts here
    public function settlementApCo()
    {
        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        if($_GET['case'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $application_no = $this->input->get('app');
        $district['dist_code'] = $this->SettlementApModel->getDistCode($application_no);
        if($this->session->userdata('user_desig_code')=='ADC' )
        {
            $district['_view'] = 'basundhara/settlementap_updation';
        }
        else
        {
            //    $district['_view'] = 'basundhara/settlementap_updation';
            $district['_view'] = 'SettlementView/Co/SettlementApTransferred';
        }
        $this->load->view('layouts/main',$district);
    }

    public function secondProceeding()
    {
        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();
        $this->dbswitch();
        $application_no = $this->input->get('case');

        $this->utilityclass->lmAuthBasic($application_no);

        $basic = $this->SettlementApModel->getSettlementBasic($application_no);
        $dags  = $this->SettlementApModel->getSettlementDagRow($application_no);
        $lmnotes       = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings   = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementApModel->getDocuments($application_no);
        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $dags_premium = $this->SettlementApModel->getSettlementDagPremium($application_no);
        $dags_result  = $this->SettlementApModel->getSettlementDag($application_no);
        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
        $lmdata['application_no'] = $applid = $this->utilityclass->getApplidFromCaseNo($application_no);


        /// additional property for LM note
        $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$applid'");
        if($additional_property->num_rows() > 0)
        {
            $totallesaa = 0;
            $totalganda = 0;
            foreach($additional_property->result() as $addprop)
            {
                if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY)))
                {
                    $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                    $totalganda = $totalganda+$total_g;
                }
                else
                {
                    $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                    $totallesaa = $totallesaa+$total_l;
                }
            }
            if(!empty($totallesaa))
            {
                $lmdata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
            }
            if(!empty($totalganda))
            {
                $lmdata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
            }
            $lmdata['additional_property']=$additional_property->result();
        }

        $lmdata['geo_date'] = $geo_date;
        $lmdata['basic']    = $basic;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['dags']    = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
        $lmdata['reservation']   = $this->SettlementApModel->getSettlementReservation($application_no);
        $lmdata['dags_premium']  = $dags_premium;
        $lmdata['dags_result']   = $dags_result;
        $lmdata['nextKin']       = $this->SettlementKhasModel->getAllNomineeDetail($application_no);
        // var_dump($lmdata['dags']); die;

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;

                    if(!file_exists($adhar_photo_link))
                    {
                        //****Directory Change */
                        $parts = explode("uploads".UPLOAD_SEPARATOR, $adhar_photo_link, 2);
                        if (count($parts) > 1)
                        {
                            $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                        }
                        else
                        {
                            $path = $adhar_photo_link;
                        }

                        if(!file_exists($path))
                        {
                            $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                        }
                        else
                        {
                            $path = $path;
                        }
                        
                        
                        if(!file_exists($path))
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
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file 5!");
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
                        else
                        {
                            $adhar_photo_link = $path;
                        }
                    }

                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable

                    $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";

                endif;
            endif;
        endforeach;

        /// premium
        // $s_area = $this->db->query("Select * from settlement_premium_area where not paid in(2,6,8) order by paid asc")->result();
        // $lmdata['s_area'] = $s_area;
        $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();
        $premiumData = $this->db->query("Select * from settlement_premium where case_no='$application_no' and is_final=1")->row();
        $lmdata['premiumData'] = $premiumData;

        //get data from settlement_ap_lmnote
        $apLmNote = $this->db->query("Select * from settlement_ap_lmnote where 
            case_no='$application_no'")->row()->is_landless;
        $lmdata['apLmNote'] = $apLmNote;


        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);

        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        foreach($output->selfDeclaration as $selfDec)
        {
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        // for guardian relation
        $query_for_guar_rel   = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0)
        {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        if($lmdata['sk_name'] == 'n')
        {
            //************if SK is not available then load CO */
            $lmdata['sk_availability'] = 'n';

            $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        }
        else
        {
            $lmdata['sk_availability'] = 'y';
        }
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }

        $sqlToCheckPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($application_no));
        if($sqlToCheckPremium->num_rows() <= 0)
        {
            $lmdata['premium_not_calculated'] = 1;
        }
        else
        {
            $lmdata['premium_not_calculated'] = 0;
        }

        $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags_result, $lmdata['rejected_list']);	

        $lmdata['enc_case']= null;
        if(ENABLE_MODIFY_MAIN_APPLICANT == 1)
        {
            // var_dump($application_no.','.$basic['dist_code'].','.$basic['service_code']);
            $this->load->model('ApplicantChangeModel');
            $lmdata['deceased'] = $this->ApplicantChangeModel->getDeceasedData($basic['applid']);
            $lmdata['enc_case'] = $this->ApplicantChangeModel->ekycVerify($application_no, $basic['dist_code'], $basic['service_code']);
        }

        $lmdata['citizen_nrc_doc'] = null;
        $lmdata['lm_nrc_doc'] = null;
        $lmdata['rejected_cat'] = 0;
        $lmdata['status_not_in_d'] = null;
        if(NRC_FILE_UPLOAD_ENABLED == 1) {
            $this->load->model('NrcDocModel');
            $citizen_nrc_doc = json_decode($this->NrcDocModel->getNrcDocsUploadedByCitizen($basic['applid']));
            $lmdata['citizen_nrc_doc'] = $citizen_nrc_doc;
            $lmdata['lm_nrc_doc'] = $this->NrcDocModel->getNrcDocsUploadedByLm($basic['case_no']);
            $lmdata['rejected_cat'] = $this->NrcDocModel->getRejectedCategoryForNrcUp($basic['case_no']);
            $lmdata['status_not_in_d'] = $this->NrcDocModel->getFromBasicNotD($basic['case_no']);
        }


        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $lmdata['_view'] = 'SettlementView/Lm/SettlementApDharitree';
            $this->load->view('layouts/main',$lmdata);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // var_dump($_POST); die;

            $is_prem_update = $this->input->post('prem_update');
            $this->load->library('form_validation');
            $distCode = trim($this->input->post('dist_code'));
            if($distCode == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementApLm?service='.SETTLEMENT_AP_TRANSFER_ID);
            }
            $case_no = $this->input->post('case_no');
            $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);
            if($case_no == NULL)
            {
                redirect(base_url(). 'index.php/home/SettlementApLm?service='.SETTLEMENT_AP_TRANSFER_ID);
            }

            // $recordExist=$this->SettlementApiModel->checkExistDharitree($case_no);


            $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($case_no);
            $reservation = $this->SettlementApModel->getSettlementReservation($case_no);

            $dags_premium = $this->SettlementApModel->getSettlementDagPremium($case_no);

            // ************* added on 19/09/2023 - new premium validation starts here

            $prem_dist              = $this->input->post('dist_code');
            $mb_land                = 0;
            $prem_dag               = $this->input->post('dag_no');
            // $prem_concession        = $this->input->post('concession'.$prem_dag);
            $prem_concession        = $this->input->post('concession');
            $prem_rate              = $this->input->post('rate'.$prem_dag);
            $prem_rate_type         = $this->input->post('rate_type'.$prem_dag);
            $prem_amount_type       = $this->input->post('amount_type'.$prem_dag);

            $prem_bigha             = $this->input->post('home_b')+$this->input->post('agri_b');
            $prem_katha             = $this->input->post('home_k')+$this->input->post('agri_k');
            $prem_lessa             = $this->input->post('home_lc')+$this->input->post('agri_lc');
            $prem_ganda             = $this->input->post('home_g')+$this->input->post('agri_g');
            $prem_zonal_valuation   = $this->input->post('zonal_valuation_prem'.$prem_dag);

            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            $this->form_validation->set_rules('is_nr_settlement', 'Whether applicant eligible for NR or NR with Settlement', 'trim|required');

            if($applicants_owners == true)
            {
                foreach($applicants_owners as $owners)
                {
                    $this->form_validation->set_rules('owners_name'.$owners->id, 'Owners Name', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('owners_guardian'.$owners->id, 'Owners Guardian', 'trim|required|min_length[1]|max_length[70]');
                    $this->form_validation->set_rules('owners_in_place'.$owners->id, 'Owners In Place', 'trim|required');

                }
            }

            $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');
            $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
            $this->form_validation->set_rules('lm_remark_additional', 'LM NR Remarks (Text Area)', 'trim|required');

            $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');
            $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
            if($is_prem_update=='YES')
            {
                $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
            }
            // $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');

            // additional file upload validation
            // upload additional files
            if(isset($_FILES['fileUpload']['name']))
            {
                $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                $fileCount = count($_FILES['fileUpload']['name']);
                // validation for file type and file size

                for($i = 0; $i < $fileCount; $i++)
                {
                    if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                        $name = $_FILES['fileUpload']['name'][$i];
                        $size = $_FILES['fileUpload']['size'][$i];

                        $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                        $exp  = explode("/",$mime);
                        $ext  = $exp[1];

                        if($name != NULL)
                        {
                            if($ext == NULL)
                            {
                                // todo error show extension missing
                                $this->form_validation->set_rules('additional_doc_err','File extension','required');

                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                // todo error show file size
                                $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
                            }
                        }
                        else
                        {
                            // todo error show file not nullable
                            $this->form_validation->set_rules('additional_doc_err','File name','required');
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('additional_doc_err','File','required');
                    }
                }
            }




            $is_nr_validation = trim($this->input->post('is_nr_settlement'));

            //********validation bypass */
            $validation_bypass = 0;
            $totalSettlementAreaNotMatchHomeAgri = 0;

            if(isset($_POST['lm_note']) == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_AP_TRANSFER_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    { 

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

            if($validation_bypass == 1)
            {
                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }
                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }

                }

                if($applicants_owners)
                {
                    foreach($applicants_owners as $settlement_owers)
                    {
                        $this->form_validation->set_rules('owners_name'.$settlement_owers->id, 'Owners Name', '');
                        $this->form_validation->set_rules('owners_guardian'.$settlement_owers->id, 'Owners Guardian', '');
                        $this->form_validation->set_rules('owners_in_place'.$settlement_owers->id, 'Owners In Place', '');
                        $this->form_validation->set_rules('owners_mobile_number'.$settlement_owers->id, 'Owners Mobile number', '');
                        // $this->form_validation->set_rules('owners_mobile_number'.$settlement_owers->id, 'Owners Mobile number', '');
                    }
                }

                $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', '');
                $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', '');
                $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', '');
                $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', '');

                $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', '');
                $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', '');
                $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', '');
                $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', '');

                $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', '');
                $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', '');
                $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', '');
                $this->form_validation->set_rules('nr_ganda', 'TDeed/Agreement Ganda area', '');


                if($is_nr_validation=='NR')
                {
                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');

                    //****area validation ***************************************************/
                    $roadsideMoreThanDagA = 0;
                    $appAreaMoreThanDagA = 0;
                    $familyMoreThanDagA = 0;
                    $totalRoadSideRev = 0;
                    $totalFamilyRev = 0;
                    $totalAppArea = 0;

                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$case_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;

                    $isUrbanRevertBack = $this->SettlementCommonModel->getUrbanForRevertBack($case_no);
                    $checkUrbanCon = $isUrbanRevertBack->is_urban;

                    // for barak valley
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        // $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }


                        $totalAppArea += $appAreaLessaValidation;
                       
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Aggreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Aggreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Aggreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        // $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        $totalAppArea += $appAreaLessaValidation;
                  

                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }

                    // new additional property calculation end here
                    $deleted_applicants = $this->input->post('deleted_applicant');
                    $deleteAppCon = 0;
                    $delApplicants = [];
                    if($deleted_applicants != '' or $deleted_applicants != NULL)
                    {
                        $deleteAppCon = 1;
                        $allSplitApplicants = (explode(",",$deleted_applicants));
                        $delApplicants = [];
                        foreach ($allSplitApplicants as $mm)
                        {
                            $splitApplicants = (explode("_",$mm));
                            $delApplicants[] = $splitApplicants[0];
                        }
                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }

                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    if($roadsideMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area!', 'required|callback_roadsideMoreThanDagA');
                    }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }

                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }


                    $land_exceed =0;
                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }else{
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }

                    if($_POST['lm_note'] == '1' && $land_exceed == 1)
                    {
                        $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                    }
                    //****area validation end***************************************************/

                }

            }


            if($validation_bypass == 0)
            {
                if(isset($_POST['lm_note']))
                {
                    if($_POST['lm_note'] == '2')
                    {
                        $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');
    
                        if(isset($_POST['rejected_reasons']))
                        {
                            foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                            {
                                $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                            }
                        }
                        if(isset($_POST['sub_rejected_reasons']))
                        {
                            foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                            {
                                $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                            }
                        }
                    }
                }

                if($is_nr_validation=='NR')
                {
                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                    $this->form_validation->set_rules('period_possession_lm', 'Possession from', 'trim|required');

                    //****area validation ***************************************************/
                    $roadsideMoreThanDagA = 0;
                    $appAreaMoreThanDagA = 0;
                    $familyMoreThanDagA = 0;
                    $totalRoadSideRev = 0;
                    $totalFamilyRev = 0;
                    $totalAppArea = 0;

                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$case_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;

                    $isUrbanRevertBack = $this->SettlementCommonModel->getUrbanForRevertBack($case_no);
                    $checkUrbanCon = $isUrbanRevertBack->is_urban;

                    // for barak valley
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        // $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }


                        $totalAppArea += $appAreaLessaValidation;
                        foreach($reservation as $setl)
                        {
                            if($setl->type=='R')
                            {

                                $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                $this->form_validation->set_rules('reserved_ganda'.$setl->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                $this->form_validation->set_rules('reserved_kranti'.$setl->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);
                                $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$setl->dag_no), 0);

                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad ;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;

                            }
                            if($setl->type == 'F')
                            {
                                $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                $this->form_validation->set_rules('reserved_ganda_family'.$setl->dag_no, 'Reserved for Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                $this->form_validation->set_rules('reserved_kranti_family'.$setl->dag_no, 'Reserved for Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                                $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                                $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);
                                $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$setl->dag_no), 0);

                                $dagAreaLessaValidationFamily = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;

                                if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                                {
                                    $familyMoreThanDagA = 1;
                                }
                                $totalFamilyRev += $dagAreaLessaValidationFamily;
                            }
                        }
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Aggreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Aggreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Aggreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        // $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        // $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        $totalAppArea += $appAreaLessaValidation;
                        foreach($reservation as $setl)
                        {
                            if($setl->type=='R')
                            {
                                $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);

                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad ;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;
                            }
                            if($setl->type == 'F')
                            {
                                $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                                $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                                $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);

                                $dagAreaLessaValidationFamily = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                                if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                                {
                                    $familyMoreThanDagA = 1;
                                }
                                $totalFamilyRev += $dagAreaLessaValidationFamily;
                            }
                        }
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }

                    // new additional property calculation end here
                    $deleted_applicants = $this->input->post('deleted_applicant');
                    $deleteAppCon = 0;
                    $delApplicants = [];
                    if($deleted_applicants != '' or $deleted_applicants != NULL)
                    {
                        $deleteAppCon = 1;
                        $allSplitApplicants = (explode(",",$deleted_applicants));
                        $delApplicants = [];
                        foreach ($allSplitApplicants as $mm)
                        {
                            $splitApplicants = (explode("_",$mm));
                            $delApplicants[] = $splitApplicants[0];
                        }
                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }

                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    if($roadsideMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area!', 'required|callback_roadsideMoreThanDagA');
                    }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }

                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }


                    $land_exceed =0;
                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }else{
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }

                    if(isset($_POST['lm_note']))
                    {
                        if($_POST['lm_note'] == '1' && $land_exceed == 1)
                        {
                            $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                        }
                    }
                    //****area validation end***************************************************/

                }
                else
                {

                    

                    if(NRC_FILE_UPLOAD_ENABLED == 1)
                    {
                        $nrc_file1 = $this->input->post('nrc_file1');
                        $nrc_file2 = $this->input->post('nrc_file2');
                        $nrc_file3 = $this->input->post('nrc_file3');
                        $nrc_file4 = $this->input->post('nrc_file4');
                        $nrc_file5 = $this->input->post('nrc_file5');


                        $this->form_validation->set_rules('nrc_file1', 'NRC_1951 Details', 'trim|xss_clean|required');
                        $this->form_validation->set_rules('nrc_file2', 'Link Document 1 Details', 'trim|xss_clean|required');
                        $this->form_validation->set_rules('nrc_file3', 'Link Document 2 Details', 'trim|xss_clean|required');
                        $this->form_validation->set_rules('nrc_file4', 'Link Document 3', 'trim|xss_clean|required');
                        $this->form_validation->set_rules('nrc_file5', 'Link Document 4', 'trim|xss_clean|required');

                        for ($i = 1; $i <= 5; $i++) 
                        { 

                            if($_FILES['nrc_file_upload'.$i]['name'] && $_FILES['nrc_file_upload'.$i]['size'] && $_FILES['nrc_file_upload'.$i]['tmp_name'])
                                {

                                    $name = $_FILES['nrc_file_upload'.$i]['name'];
                                    $size = $_FILES['nrc_file_upload'.$i]['size'];

                                    $mime = mime_content_type($_FILES['nrc_file_upload'.$i]['tmp_name']);
                                    $exp  = explode("/",$mime);
                                    $ext  = $exp[1];

                                    if($name != NULL)
                                    {
                                        if($ext == NULL)
                                        {
                                            // todo error show extension missing
                                            $this->form_validation->set_rules('nrc_file_upload'.$i,'File extension','required');

                                        }
                                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                        {
                                            // todo error show file allow type not match
                                            $this->form_validation->set_rules('nrc_file_upload'.$i,'Only JPG/PNG/PDF file','required');
                                        }
                                        if($size > UPLOAD_MAX_SIZE)
                                        {
                                            // todo error show file size
                                            $this->form_validation->set_rules('nrc_file_upload'.$i,'Maximum 2MB file size','required');
                                        }
                                    }
                                    else
                                    {
                                        // todo error show file not nullable
                                        $this->form_validation->set_rules('nrc_file_upload'.$i,'File name','required');
                                    }
                                }
                                else
                                {
                                    $this->form_validation->set_rules('nrc_file_upload'.$i,'File','required');
                                }
                            // code...
                        }
                    }
                    $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside', 'trim|required');
                    $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                    $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                    $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
                    $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                    $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
                    $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                    $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
                    $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                    $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
                    $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                    $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
                    $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                    $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                    $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
                    $this->form_validation->set_rules('period_possession_lm', 'Possession from', 'trim|required');
                    $this->form_validation->set_rules('is_tribal_belt', 'Land falls under Tribal Belt', 'trim|required');
                    $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
                    $this->form_validation->set_rules('protected_class_lm', 'Does applicant falls under protected category', 'trim|required|is_natural');
                    $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide prone ?', 'trim|required');
                    $this->form_validation->set_rules('possession_verified', 'Is Area Under cover landslide prone ?', 'trim|required');
                    $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                    $this->form_validation->set_rules('is_landless', 'Whether applicant is landless', 'trim|required');
                    $this->form_validation->set_rules('litigation', 'Whether proposed land is under litigation', 'trim|required');
                    $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('falls_und_gmc', 'land falls within 15 KM radius from the periphery of GMC  ', 'trim|required');
        
                    $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
                    $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

                    $this->form_validation->set_rules('dag_no', 'Dag Number', 'trim|required|is_natural');
                    $this->form_validation->set_rules('patta_no', 'Patta Number', 'trim|required');
                    $this->form_validation->set_rules('patta_type_code', 'Patta Type Code', 'trim|required|is_natural');
                    $this->form_validation->set_rules('gramdan_bhudan', 'Land falls category', 'required');
                    $this->form_validation->set_rules('eksona_transfered', 'Is Eksona Land Transferred?', 'required');

                    $roadsideMoreThanDagA = 0;
                    $appAreaMoreThanDagA = 0;
                    $familyMoreThanDagA = 0;
                    $totalRoadSideRev = 0;
                    $totalFamilyRev = 0;
                    $totalAppArea = 0;

                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$case_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;

                    $isUrbanRevertBack = $this->SettlementCommonModel->getUrbanForRevertBack($case_no);
                    $checkUrbanCon = $isUrbanRevertBack->is_urban;

                    // for barak valley
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }


                        $totalAppArea += $appAreaLessaValidation;

                        if(count($reservation) == 0)
                        {
                            foreach($lmdata['dags_result'] as $roaddag)
                            {
                                $this->form_validation->set_rules('reserved_bigha'.$roaddag->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$roaddag->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$roaddag->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                $this->form_validation->set_rules('reserved_ganda'.$roaddag->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                $this->form_validation->set_rules('reserved_kranti'.$roaddag->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$roaddag->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$roaddag->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$roaddag->dag_no), 0);
                                $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$roaddag->dag_no), 0);

                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad ;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;

                            }

                        }
                        else
                        {
                            foreach($reservation as $setl)
                            {
                                if($setl->type=='R')
                                {
                                    $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                    $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                    $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                    $this->form_validation->set_rules('reserved_ganda'.$setl->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                    $this->form_validation->set_rules('reserved_kranti'.$setl->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                                    $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                                    $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                                    $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);
                                    $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$setl->dag_no), 0);
    
                                    $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad ;
    
                                    if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                    {
                                        $roadsideMoreThanDagA = 1;
                                    }
                                    $totalRoadSideRev += $dagAreaLessaValidationRoad;
    
                                }
                                if($setl->type == 'F')
                                {
                                    $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                    $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                    $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                    $this->form_validation->set_rules('reserved_ganda_family'.$setl->dag_no, 'Reserved for Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                    $this->form_validation->set_rules('reserved_kranti_family'.$setl->dag_no, 'Reserved for Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);
                                    $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$setl->dag_no), 0);
    
                                    $dagAreaLessaValidationFamily = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
    
                                    if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                                    {
                                        $familyMoreThanDagA = 1;
                                    }
                                    $totalFamilyRev += $dagAreaLessaValidationFamily;
                                }
                            }
                        }


                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Aggreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Aggreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Aggreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        

                        $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $this->form_validation->set_rules('zonal_valuation_prem'.$prem_dag, 'Zonal Value', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        $totalAppArea += $appAreaLessaValidation;


                        if(count($reservation) == 0)
                        {
                            foreach($lmdata['dags_result'] as $roaddag)
                            {
                                $this->form_validation->set_rules('reserved_bigha'.$roaddag->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$roaddag->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$roaddag->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$roaddag->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$roaddag->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$roaddag->dag_no), 0);
                                // $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$roaddag->dag_no), 0);

                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad ;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;

                            }

                        }
                        else
                        {
                            foreach($reservation as $setl)
                            {
                                if($setl->type=='R')
                                {
    
                                    $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                    $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                                    $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                                    $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                                    $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                                    $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);
    
                                    $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad ;
    
                                    if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                    {
                                        $roadsideMoreThanDagA = 1;
                                    }
                                    $totalRoadSideRev += $dagAreaLessaValidationRoad;
                                }
                                if($setl->type == 'F')
                                {
                                    $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                    $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                                    $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
    
                                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);
    
                                    $dagAreaLessaValidationFamily = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;
    
                                    if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                                    {
                                        $familyMoreThanDagA = 1;
                                    }
                                    $totalFamilyRev += $dagAreaLessaValidationFamily;
                                }
                            }
                        }

                       
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                    }

                    // new additional property calculation end here

                    $deleted_applicants = $this->input->post('deleted_applicant');
                    $deleteAppCon = 0;
                    $delApplicants = [];
                    if($deleted_applicants != '' or $deleted_applicants != NULL)
                    {
                        $deleteAppCon = 1;
                        $allSplitApplicants = (explode(",",$deleted_applicants));
                        $delApplicants = [];
                        foreach ($allSplitApplicants as $mm)
                        {
                            $splitApplicants = (explode("_",$mm));
                            $delApplicants[] = $splitApplicants[0];
                        }
                    }

                    if($applicants_owners == true)
                    {
                        foreach($applicants_owners as $owners)
                        {
                            $this->form_validation->set_rules('owners_name'.$owners->id, 'Owners Name', 'trim|required|min_length[3]|max_length[70]');
                            $this->form_validation->set_rules('owners_guardian'.$owners->id, 'Owners Guardian', 'trim|required|min_length[1]|max_length[70]');
                            $this->form_validation->set_rules('owners_in_place'.$owners->id, 'Owners In Place', 'trim|required');

                        }
                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }

                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    if($roadsideMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area!', 'required|callback_roadsideMoreThanDagA');
                    }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }

                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }


                    $land_exceed =0;
                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }
                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }
                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag)))
                        {
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }else{
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }
                    }

                    if(isset($_POST['lm_note']))
                    {
                        if($_POST['lm_note'] == '1' && $land_exceed == 1)
                        {
                            $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                        }
                    }

                    //// premium insert lm update start
                    // if($this->input->post('is_nr_settlement') == '' || $this->input->post('is_nr_settlement') == null) 
                    // {
                    //     log_message('error', "#ERR312: Whether applicant eligible for NR or NR with Settlement is not selected for case no ".$case_no);
                    //     $this->session->set_flashdata('error_data', "#ERR312: Whether applicant eligible for NR or NR with Settlement is not selected for case no ".$case_no);
                    //     redirect(base_url() . "index.php/home");
                    //     return false;
                    // }

                    if($this->input->post('is_nr_settlement') == 'NR with Settlement')
                    {
                        if($is_prem_update == 'YES') 
                        {
                            if($prem_rate == '' || $prem_rate == null) {
                                log_message('error', "#ERR318: Rate field is empty. Premium calculation no done for case no ".$case_no);
                                $this->session->set_flashdata('error_data', "#ERR318: Premium calculation is required for case no ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                            else if($prem_amount_type == '' || $prem_amount_type == null) {
                                log_message('error', "#ERR324: Amount field is empty. Premium calculation no done for case no ".$case_no);
                                $this->session->set_flashdata('error_data', "#ERR324: Premium calculation is required for case no ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                            else if($this->input->post('area_cat_new'.$prem_dag) == '' || $this->input->post('area_cat_new'.$prem_dag) == null) {
                                log_message('error', "#ERR330: Dag area is not flagged in chitha for case no ".$case_no);
                                $this->session->set_flashdata('error_data', "#ERR330: Dag area is not flagged in chitha for case no ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                        else if($is_prem_update == 'NO') {
                            if($this->input->post('area_cat_new'.$prem_dag) == '' || $this->input->post('area_cat_new'.$prem_dag) == null) {
                                log_message('error', "#ERR338: Dag area is not flagged in chitha for case no ".$case_no);
                                $this->session->set_flashdata('error_data', "#ERR338: Dag area is not flagged in chitha for case no ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }                
                    }
                }
            }


            if ($this->form_validation->run() == FALSE)
            {
                $lmdata['all_errors'] = validation_errors();
                $lmdata['err_return'] = true;
                if(isset($fileCount))
                {
                    $lmdata['fileCount'] = $fileCount;
                }
                $lmdata['_view'] = 'SettlementView/Lm/SettlementApDharitree';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {
                $this->db->trans_begin();

                if($lmdata['sk_availability'] == 'yyyyyyy') // As discuussed sk not required so y replaced by yyyyyyy
                {
                    $pending_officer = 'SK';
                }
                else
                {
                    $pending_officer = 'CO';
                }
                if($validation_bypass == 1)
                {
                    $pending_officer = 'CO';
                }
                // insertion in backup table

                $phase_count   = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'LM'")->row()->ct;
                $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);
                $phase_count   = (int)$phase_count+1;
                $backup_array_lm = [
                    'applid' => $applid_backup,
                    'case_no' => $case_no,
                    'from_office' => 'LM',
                    'to_office' => $pending_officer,
                    'status' => 'X',
                    'phase' => 'LM_'.$phase_count,
                    'data' => json_encode($_POST)
                ];

                $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);

                if($backup_insertion_lm != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP0032: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

                    $this->session->set_flashdata('error_data', "#BACKUP0032: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $pro_class = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');
                $basic=array(
                    'date_update' => date('Y-m-d G:i:s'),
                    'status'=>'X',
                    'user_code'=>$this->session->userdata('user_code'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'period_possession'=>$this->input->post('period_possession_lm'),
                    'occupation_applicant'=>$this->input->post('occupation_applicant'),
                    'protected_class' => $protected_class_vr,
                    'from_office' => 'LM',
                    'pending_officer' => $pending_officer,
                    'pending_office'  => $pending_officer,
                    'tribal_belt' => $this->input->post('tribal_belt'),
                    'approve_by' => $this->input->post('approval'.$prem_dag),
                );

                if ($is_prem_update=='NO'){
                    unset($basic['approve_by']);
                }
                
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basic);

                if($this->db->affected_rows() == 0 )
                {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No '.$case_no);
                    $data = array(
                        'error'=>"#SETUP0001: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                







                // upload additional file
                if(isset($_FILES['fileUpload']['name']))
                {
                    for($i = 0; $i < $fileCount; $i++)
                    {
                        $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                        $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                        $exp  = explode("/",$mime);
                        $onlyExtension  = $exp[1];

                        $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                        $config['upload_path']   = UPLOAD_DIR;
                        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                        $config['max_size']  = UPLOAD_MAX_SIZE;;
                        $config['file_name'] = $fileRename;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('file'))
                        {
                            $document= array(
                                'case_no'   => $case_no,
                                'file_name' => $_POST['fileText'][$i],
                                'user_code' => $this->session->userdata('user_code'),
                                // 'fetch_file_name' => $_FILES['file']['name'],
                                'fetch_file_name' => $_POST['fileText'][$i],
                                'file_type'  => $_FILES['file']['type'],
                                'file_path'  => UPLOAD_DIR . $fileRename,
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type'   => SETTLEMENT_AP_TRANSFER_ID,
                            );

                            // save data in attachment file
                            $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                            if($addMoreDocQuery != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRADDDOC34301: Insertion failed in supportive document RTPS Case No '.$case_no);

                                $this->session->set_flashdata('error_data', "#ERRADDDOC34301: Registration of Settlement failed for case no : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            // todo error show
                            // redirect to respected route with error mgs
                            log_message('error', '#ERRADDDOC04501: Insertion failed in supportive document RTPS Case No '.$case_no);

                            $this->session->set_flashdata('error_data', "#ERRADDDOC04501: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }

                    }
                }
                //end of additional file upload

                ////settlement_dag_details insert start
                $fmd=array(
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d G:i:s'),
                );

                $landmark_east = $this->input->post('landmark_east');
                $landmark_west = $this->input->post('landmark_west');
                $landmark_north = $this->input->post('landmark_north');
                $landmark_south = $this->input->post('landmark_south');
                $landmark = [
                    'east'  => $landmark_east,
                    'west'  => $landmark_west,
                    'north' => $landmark_north,
                    'south' => $landmark_south,
                ];

                $fmd['s_dag_area_b']  = $this->input->post('s_dag_area_b');
                $fmd['s_dag_area_k']  = $this->input->post('s_dag_area_k');
                $fmd['s_dag_area_lc'] = $this->input->post('s_dag_area_lc');
                $fmd['s_dag_area_g']  = $this->input->post('s_dag_area_g');
                $fmd['s_dag_area_kr'] = $this->input->post('s_dag_area_kr');
                $fmd['nr_bigha']  = $this->input->post('nr_bigha');
                $fmd['nr_katha']  = $this->input->post('nr_katha');
                $fmd['nr_lessa']  = $this->input->post('nr_lessa');
                $fmd['nr_ganda']  = $this->input->post('nr_ganda');
                $fmd['nr_kranti'] = $this->input->post('nr_kranti');
                $fmd['landmark']  = json_encode($landmark);

                $fmd['home_b']  = $this->input->post('home_b');
                $fmd['home_k']  = $this->input->post('home_k');
                $fmd['home_lc'] = $this->input->post('home_lc');
                $fmd['home_g']  = $this->input->post('home_g');
                $fmd['home_kr'] = $this->input->post('home_kr');

                $fmd['agri_b']  = $this->input->post('agri_b');
                $fmd['agri_k']  = $this->input->post('agri_k');
                $fmd['agri_lc'] = $this->input->post('agri_lc');
                $fmd['agri_g']  = $this->input->post('agri_g');
                $fmd['agri_kr'] = $this->input->post('agri_kr');

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_dag_details', $fmd);

                if($this->db->affected_rows() == 0 ){
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0002: Updation failed in settlement_dag_details Dharitree Case No '.$case_no);
                    $data = array(
                        'error'=>"#SETUP0002: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $sql1 = "SELECT petition_no FROM settlement_basic WHERE case_no = '$case_no'";
                $result1 = $this->db->query($sql1);
                if($result1->num_rows() > 0)
                {
                    $petition_no = (int)$result1->row()->petition_no;
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '$case_no'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0)
                {
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($applicants_owners == true)
                {
                    foreach($applicants_owners as $owners)
                    {
                        if($this->input->post('pdar_id'.$owners->id)=="" || $this->input->post('pdar_id'.$owners->id)==null || empty($this->input->post('pdar_id'.$owners->id)))
                        {
                            $chitha_pdar_id=-1;
                        }
                        else
                        {
                            $chitha_pdar_id=$this->input->post('pdar_id'.$owners->id);
                        }
                        $owners_update=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'date_update' => date('Y-m-d G:i:s'),
                            'pdar_name' =>$this->input->post('owners_name'.$owners->id),
                            'pdar_guardian' =>$this->input->post('owners_guardian'.$owners->id),
                            'inplace_alongwith' => $this->input->post('owners_in_place'.$owners->id),
                        );
                        $this->db->where('id', $owners->id);
                        $this->db->update('settlement_applicant', $owners_update);
                        if($this->db->affected_rows() == 0 )
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP0004: Updation failed in settlement_applicant Dharitree Case No '.$case_no);
                            $data = array(
                                'error'=>"#SETUP0004: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                ////////////////////file///////////////////////////
                if(isset($_FILES))
                {
                    foreach ($_FILES as $file => $key)
                    {
                        if ($key['tmp_name'] == false)
                        {
                            continue;
                        }
                        $doc_dag_no =  strstr($file,  '_', true);
                        $doc_id = substr($file, strpos($file, "_") + 1);
                        preg_match('/DOCMAIN/', $file, $match);
                        if($match)
                        {
                            if ($match[0] == 'DOCMAIN')
                            {
                                $timestamp = date('mdYhis', time()).uniqid();
                                $config['file_name']     = 'updated_file'.$timestamp;
                                $config['upload_path']   = UPLOAD_DIR;
                                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                                $config['max_size']      = 2000;

                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ( ! $this->upload->do_upload($file))
                                {
                                    $error = array('error' => $this->upload->display_errors());
                                    echo json_encode($error);
                                    return false;
                                }
                                else
                                {
                                    $data = array('upload_data' => $this->upload->data());
                                    $document= array(
                                        'file_type' => $data['upload_data']['file_type'],
                                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                    );
                                    $this->db->where('id', $doc_id);
                                    $this->db->update('supportive_document', $document);
                                    if ($this->db->affected_rows() == 0) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#SETUP6845545: Updation failed in supprotive_documents Dharitree Case No ' . $case_no);
                                        $data = array(
                                            'error' => "#SETUP6845545: Failed to upload documents, Please compress the file and reupload. case no : " . $case_no,
                                        );
                                        echo json_encode($data);
                                        log_message("error", "last query" . json_encode($this->db->last_query()));
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                }

                $comment = addslashes($this->input->post('lm_note'));
                $pro_class_lm = $this->input->post('protected_class_lm');
                $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    // $this->SettlementCommonModel->secondProceedingValidationBypassTrue(
                    //     SETTLEMENT_AP_TRANSFER_ID, 
                    //     $case_no, 
                    //     $application_no, 
                    //     $lmdata['rejected_list']
                    // ); 
                    //*********if LM if case of case rejected the rejected remarks */
                    $responseMasterObj = $this->SettlementCommonModel->lmRejectedValidationBypassTrue(SETTLEMENT_AP_TRANSFER_ID, $lmdata['rejected_list']); 

                    if ($is_nr_validation=='NR')
                    {
                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
    
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            
                            'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks),
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                        );
                    }
                    else
                    {
                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
                            // 'vlb_verified'=>$this->input->post('vlb_verified'),
                            'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                            'erosion' => $this->input->post('erosion'),
                            'possession_verification'=>$this->input->post('possession_verified'),
                            // 'period_possession'=>date('Y-m-d'),
                            'period_possession'=>$this->input->post('period_possession_lm'),
                            'nature_possession'=>$this->input->post('nature_possession'),
                            'is_landless'=>$this->input->post('is_landless'),
                            // 'ceiling_limit'=>$this->input->post('ceiling_limit'),
                            'roadside_reservation'=>$this->input->post('roadside_reservation'),
                            // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
                            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                            // 'chitha_copy'=>$this->input->post('chitha_copy'),
                            'trace_map_copy'=>'NA',
                            'chitha_copy'=>'NA',
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'land_falls'=>$this->input->post('land_falls'),
                            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            'total_bigha'=>$this->input->post('total_bigha'),
                            'total_Katha'=>$this->input->post('total_Katha'),
                            'total_lessa'=>$this->input->post('total_lessa'),
                            'total_ganda'=>$this->input->post('total_ganda'),
                            'total_kranti'=>$this->input->post('total_kranti'),
                            // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                            'landslide'            => $this->input->post('landslide'),
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            'protected_class_lm' => $protected_class_lm,
                            'litigation' => $this->input->post('litigation'),
                            'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                            'eksona_type' => $this->input->post('gramdan_bhudan'),
                            'eksona_transfered' => $this->input->post('eksona_transfered'),
                            'lm_rejected_remarks' => json_encode($responseMasterObj->reject_remarks),
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                        );
                    }
                }

                if($validation_bypass == 0)
                {
                    // ************* added on 19/09/2023 - new premium validation starts here
                    if($is_prem_update=='YES')
                    {
                        $checkingPremiumExistSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ?", array($case_no));

                        if($checkingPremiumExistSql->num_rows() > 0)
                        {
                            $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
                            $resultprem = $this->db->query($sqlprem);
                            if ($this->db->affected_rows() == 0)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRSET000311: Updation Settlement failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }

                        if($this->input->post('is_nr_settlement') != 'NR') { //validation will takes place if not NR

                            

                            $total_road_reserved    = 0;
                            $total_family_reserved  = 0;

                            // var_dump($prem_concession); die;



                            $reserved_bigha = $this->input->post('reserved_bigha'.$prem_dag);
                            $reserved_katha = $this->input->post('reserved_katha'.$prem_dag);
                            $reserved_lessa = $this->input->post('reserved_lessa'.$prem_dag);

                            $reserved_bigha_family = 0;
                            $reserved_katha_family = 0;
                            $reserved_lessa_family = 0;

                            if (in_array($prem_dist, json_decode(BARAK_VALLEY))) {
                                $reserved_ganda = $this->input->post('reserved_ganda'.$prem_dag);
                                $reserved_ganda_family = 0;
                            }
                            

                            if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                            {
                                $total_applied_area = ($prem_bigha * 6400) + ($prem_katha * 320) + ($prem_lessa * 20) + $prem_ganda;
                                if ($this->input->post('roadside_comment_check') == "YES") {
                                    $total_road_reserved = ($reserved_bigha * 6400) + ($reserved_katha * 320) + ($reserved_lessa * 20) + $reserved_ganda;
                                }

                                if ($this->input->post('family_comment_check') == "YES") {
                                    $total_family_reserved = ($reserved_bigha_family * 6400) + ($reserved_katha_family * 320) + ($reserved_lessa_family * 20) + $reserved_ganda_family;
                                }
                            }
                            else 
                            {
                                $total_applied_area = ($prem_bigha * 100) + ($prem_katha * 20) + $prem_lessa;

                                if ($this->input->post('roadside_comment_check') == "YES") {
                                    $total_road_reserved = ($reserved_bigha * 100) + ($reserved_katha * 20) + $reserved_lessa;
                                }

                                if ($this->input->post('family_comment_check') == "YES") {
                                    $total_family_reserved = ($reserved_bigha_family * 100) + ($reserved_katha_family * 20) + $reserved_lessa_family;
                                }
                            }

                            $mb_land         = $this->input->post('mb_land'.$prem_dag);
                            $getPrice        = 25;
                            $total_s_area    = 0;

                            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                            $area_in_bigha=6400;
                            }else{
                                $area_in_bigha=100;
                            }

                            // var_dump($_POST);

                            if (in_array($prem_dist, json_decode(BARAK_VALLEY))){
                                if($mb_land == 25){
                                    $mb_land=1600;
                                }else if ($mb_land == 30){
                                    $mb_land=1920;
                                }else if ($mb_land == 40){
                                    $mb_land=2560;
                                }
                            }

                            $concession_rate=25;
                            $total_s_area = $total_applied_area - $total_road_reserved - $total_family_reserved;
                            
                            if($prem_concession == 'YES')
                            {
                                if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                                {
                                    if($prem_amount_type == 'P'){
                                                        
                                        if($total_s_area > $mb_land){
                                            // $premium     = $mb_land * $prem_zonal_valuation / 6400;
                                            // $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                            // $amount1     = ceil($premium * $discount / 100);
                                            // $access_area = $total_s_area - $mb_land;
                                            // $premium2    = ($access_area * ($prem_zonal_valuation*1.5)) / 6400;
                                            // $amount2     = ceil($premium2 * $discount / 100);
                                            // $amount      = ceil($amount1 + $amount2);

                                            $concession_factor = (100 - $concession_rate) / 100;

                                            $base_premium1 = ($mb_land * $prem_zonal_valuation) / 6400;
                                            $amount1 = ceil($base_premium1 * $prem_rate / 100 * $concession_factor);

                                            //for access area
                                            $access_area = max(0, $total_s_area - $mb_land);
                                            $base_premium2 = ($access_area * ($prem_zonal_valuation * 1.5)) / 6400;
                                            $amount2 = ceil($base_premium2 * $concession_factor);
                                    
                                            $amount = ceil($amount1 + $amount2);

                                        }else{
                                            // $premium     = $total_s_area * $prem_zonal_valuation / 6400;
                                            // $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                            // $amount      = ceil($premium * $discount / 100);
                                            $concession_factor = (100 - $concession_rate) / 100;

                                            $base_premium = ($total_s_area * $prem_zonal_valuation) / 6400;
                                            $amount = $base_premium * ($prem_rate / 100) * $concession_factor;

                                            $amount = ceil($amount);
                                            
                                        }                        
                                    }
                                    else if($prem_amount_type == 'R'){
                                        // $premium         = $total_s_area * $prem_rate / 6400;
                                        // $discount        = $prem_rate - $getPrice;
                                        // $amount          = ceil($premium * $discount / 100);
                                        $premium = $total_s_area * $prem_rate / 6400;
                                        $discount = ceil($premium * ($getPrice/100));
                                        $amount = ceil($premium - $discount);
                                    }
                                }
                                else 
                                {
                                    if($prem_amount_type == 'P')
                                    {
                                        if($total_s_area > $mb_land)
                                        {
                                            
                                            // $premium     = $mb_land * $prem_zonal_valuation / 100;
                                            // $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                            // $amount1     = ceil($premium * $discount / 100);
                                            // $access_area = $total_s_area - $mb_land;
                                            // $premium2    = ($access_area * ($prem_zonal_valuation*1.5)) / 100;
                                            // $amount2     = ceil($premium2 * $discount / 100);
                                            // $amount      = ceil($amount1 + $amount2);

                                            $concession_factor = (100 - $concession_rate) / 100;

                                            $base_premium1 = ($mb_land * $prem_zonal_valuation) / 100;
                                            $amount1 = ceil($base_premium1 * $prem_rate / 100 * $concession_factor);

                                            //for access area
                                            $access_area = max(0, $total_s_area - $mb_land);
                                            $base_premium2 = ($access_area * ($prem_zonal_valuation * 1.5)) / 100;
                                            $amount2 = ceil($base_premium2 * $concession_factor);
                                    
                                            $amount = ceil($amount1 + $amount2);
                                        }
                                        else
                                        {
                                            
                                            // $premium     = $total_s_area * $prem_zonal_valuation / 100;
                                            // $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                            // $amount      = ceil($premium * $discount / 100);

                                            $premium = $total_s_area * $prem_rate / 100;
                                            $discount = ceil($premium * ($getPrice/100));
                                            $amount = ceil($premium - $discount);
                                        }
                                    }
                                    else if($prem_amount_type == 'R')
                                    {
                                        // $premium  = $total_s_area * $prem_rate / 100;
                                        // $discount = $prem_rate - $getPrice;
                                        // $amount   = ceil($premium * $discount / 100);
                                        $premium = $total_s_area * $prem_rate / 100;
                                        $discount = ceil($premium * ($getPrice/100));
                                        $amount = ceil($premium - $discount);
                                    }
                                }
                            }

                            else if($prem_concession == 'NO') 
                            {
                                $discount =0;
                                if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                                {
                                    if($prem_amount_type == 'P') 
                                    {
                                        if($total_s_area > $mb_land) 
                                        {
                                            // $premium     = $mb_land * $prem_zonal_valuation / 6400;
                                            // $amount1     = ceil($premium * $prem_rate / 100);
                                            // $access_area = $total_s_area - $mb_land;
                                            // $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 6400;
                                            // $amount2     = ceil($premium2 * $prem_rate / 100);
                                            // $amount      = ceil($amount1 + $amount2);

                                            // --- Part 1: within mb_land ---
                                            $premium1 = ($mb_land * $prem_zonal_valuation) / 6400;
                                            $amount1  = ceil($premium1 * $prem_rate / 100);

                                            // --- Part 2: excess area at flat 150% zonal (no prem_rate applied) ---
                                            $access_area = $total_s_area - $mb_land;
                                            $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 6400;
                                            $amount2     = ceil($premium2);

                                            $amount = $amount1 + $amount2;
                                        }
                                        else
                                        {
                                            // $premium     = $total_s_area * $prem_zonal_valuation / 6400;
                                            // $amount      = ceil($premium * $prem_rate / 100);

                                            $premium = ($total_s_area * $prem_zonal_valuation) / 6400;
                                            $amount  = $premium * $prem_rate / 100;
                                            $amount = ceil($amount);
                                        }
                                    }
                                    else if($prem_amount_type == 'R')
                                    {
                                        // $premium = $total_s_area * $prem_rate / 6400;
                                        // $amount  = ceil($premium * $prem_rate / 100);
                                        $amount = ceil($total_s_area * $prem_rate / 6400);
                                    }
                                }
                                else 
                                {
                                    if($prem_amount_type == 'P')
                                    {
                                        if($total_s_area > $mb_land)
                                        {
                                            // var_dump($total_s_area.'----'.$mb_land);
                                            // $premium     = $mb_land * $prem_zonal_valuation / 100;
                                            // $amount1     = ceil($premium * $prem_rate / 100);

                                            // $access_area = $total_s_area - $mb_land;
                                            // $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 100;
                                            // $amount2     = ceil($premium2 * $prem_rate / 100);

                                            // $amount      = ceil($amount1 + $amount2);

                                            // --- Part 1: within mb_land ---
                                            $premium1 = ($mb_land * $prem_zonal_valuation) / 100;
                                            $amount1  = ceil($premium1 * $prem_rate / 100);

                                            // --- Part 2: excess area at flat 150% zonal (no prem_rate applied) ---
                                            $access_area = $total_s_area - $mb_land;
                                            $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 100;
                                            $amount2     = ceil($premium2);

                                            $amount = $amount1 + $amount2;
                                        }
                                        else
                                        {
                                            // $premium = $total_s_area * $prem_zonal_valuation / 100;
                                            // $amount  = ceil($premium * $prem_rate / 100);

                                            $premium = ($total_s_area * $prem_zonal_valuation) / 100;
                                            $amount  = $premium * $prem_rate / 100;
                                            $amount = ceil($amount);
                                        }
                                    }
                                    else if($prem_amount_type == 'R')
                                    {
                                        // $premium = $total_s_area * $prem_rate / 100;
                                        // $amount  = ceil($premium * $prem_rate / 100);
                                        $amount = ceil($total_s_area * $prem_rate / 100);
                                    }
                                }
                            }

                            $log_json = [
                                'total_s_area'         => $total_s_area,
                                'mb_land'              => $mb_land,
                                'prem_zonal_valuation' => $prem_zonal_valuation,
                                'premium'              => $premium,
                                'prem_rate'            => $prem_rate,
                                'getPrice'             => $getPrice,
                                'discount'             => $discount,
                                'amount'               => $amount,
                                'final_amount'         => $this->input->post('finalamount'),
                                'case_no'              => $case_no,
                                'prem_concession'      => $prem_concession,
                                'prem_amount_type'     => $prem_amount_type,

                            ];
                            

                            if(ceil($amount) != $this->input->post('finalamount')) 
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERR7439266: Premium ghotala by LM : '.json_encode($log_json));
                                $this->session->set_flashdata('message', "Error #ERR7439266: Some issue occured on premium for case no. ".$case_no.". Kindly contact system administrator !!");                    
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                            $fmd=array(
                                'case_no'=>$case_no,
                                'user_code'=>$this->session->userdata('user_code'),
                                'dag_no'=>$prem_dag,
                                'zonal_valuation'=>$this->input->post('zonal_valuation_prem'.$prem_dag),
                                'area_name'=>$this->input->post('area'.$prem_dag),
                                'land_type'=>$this->input->post('land_type'.$prem_dag),
                                'rate_type'=>$this->input->post('rate_type'.$prem_dag),
                                'rate'=>$this->input->post('rate'.$prem_dag),
                                // 'concession'=>$this->input->post('concession'.$prem_dag),
                                'concession'=>$this->input->post('concession'),
                                'amount_dag'=>$this->input->post('amount'.$prem_dag),
                                'final_amount'=>$this->input->post('finalamount'),
                                'due_amount'=>$this->input->post('totaldue'),
                                'total_lessa'=>$this->input->post('total_lessa'.$prem_dag),
                                'is_full_pay'=>$this->input->post('paymode'),
                                'is_final'=>1,
                                'date_entry'=>date('Y-m-d h:i:s'),
                                'approve_by'=>$this->input->post('approval'.$prem_dag),

                            );

                            $insPremium = $this->db->insert('settlement_premium', $fmd);
                            // echo $this->db->last_query();

                            if ($insPremium != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$case_no);
                                $data = array(
                                    'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$case_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                            
                        }
                    }
                    // ************* added on 19/09/2023 - new premium validation ends here

                    if ($is_nr_validation=='NR')
                    {
                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
    
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            
                            'lm_rejected_remarks' => null,
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                        );
                    }
                    else
                    {


                        //NRC FILE UPLOAD =================
                        if(NRC_FILE_UPLOAD_ENABLED ==1)
                        {
                            $nrc_file1 = $this->input->post('nrc_file1');
                            $nrc_file2 = $this->input->post('nrc_file2');
                            $nrc_file3 = $this->input->post('nrc_file3');
                            $nrc_file4 = $this->input->post('nrc_file4');
                            $nrc_file5 = $this->input->post('nrc_file5');
                            $nrc_file6 = $this->input->post('nrc_file6');

                            $nrc_fileName1 = 'NRC_1951';
                            $nrc_fileName2 = 'DOC_1';
                            $nrc_fileName3 = 'DOC_2';
                            $nrc_fileName4 = 'DOC_3';
                            $nrc_fileName5 = 'DOC_4';
                            $nrc_fileName6 = 'DOC_5';


                            $nrcFileName = array($nrc_fileName1,$nrc_fileName2,$nrc_fileName3,$nrc_fileName4,$nrc_fileName5,$nrc_fileName6);
                            $nrcDesc     = array($nrc_file1,$nrc_file2,$nrc_file3,$nrc_file4,$nrc_file5,$nrc_file6);

                            $nrcFileArray  = array($_FILES["nrc_file_upload1"],$_FILES["nrc_file_upload2"],$_FILES["nrc_file_upload3"],$_FILES["nrc_file_upload4"],$_FILES["nrc_file_upload5"],$_FILES["nrc_file_upload6"]);
                            $service_code = SETTLEMENT_AP_TRANSFER_ID;

                            $nrcFilesUploadStatus = $this->SettlementNRCFileUploadModel->uploadNrcFiles($case_no,$nrcDesc,$nrcFileArray,$nrcFileName,$service_code);
                            if($nrcFilesUploadStatus['responseType'] == 1)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "#ERRAPNRCDOC0001: Registration of Settlement failed for case no : ".$case_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                        }
                        //end=====================
                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
                            // 'vlb_verified'=>$this->input->post('vlb_verified'),
                            'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                            'erosion' => $this->input->post('erosion'),
                            'possession_verification'=>$this->input->post('possession_verified'),
                            // 'period_possession'=>date('Y-m-d'),
                            'period_possession'=>$this->input->post('period_possession_lm'),
                            
                            'nature_possession'=>$this->input->post('nature_possession'),
                            'is_landless'=>$this->input->post('is_landless'),
                            // 'ceiling_limit'=>$this->input->post('ceiling_limit'),
                            'roadside_reservation'=>$this->input->post('roadside_reservation'),
                            // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
                            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                            // 'chitha_copy'=>$this->input->post('chitha_copy'),
                            'trace_map_copy'=>'NA',
                            'chitha_copy'=>'NA',
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'land_falls'=>$this->input->post('land_falls'),
                            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            'total_bigha'=>$this->input->post('total_bigha'),
                            'total_Katha'=>$this->input->post('total_Katha'),
                            'total_lessa'=>$this->input->post('total_lessa'),
                            'total_ganda'=>$this->input->post('total_ganda'),
                            'total_kranti'=>$this->input->post('total_kranti'),
                            // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                            'landslide'            => $this->input->post('landslide'),
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            'protected_class_lm' => $protected_class_lm,
                            'litigation' => $this->input->post('litigation'),
                            'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                            'eksona_type' => $this->input->post('gramdan_bhudan'),
                            'eksona_transfered' => $this->input->post('eksona_transfered'),
                            'lm_rejected_remarks' => null,
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                        );

                        ///// road side reserve area start /////
                        $roadside_comment_check=$this->input->post('roadside_comment_check');
                        if($reservation == true)
                        {
                            if ($roadside_comment_check=='YES') 
                            {
                                foreach ($reservation as $reservation_road)
                                {
                                    if($reservation_road->type == 'R')
                                    {
                                        $reservedarea_road = array(
                                            'bigha' => $this->input->post('reserved_bigha' . $reservation_road->dag_no),
                                            'katha' => $this->input->post('reserved_katha' . $reservation_road->dag_no),
                                            'lessa' => $this->input->post('reserved_lessa' . $reservation_road->dag_no),
                                            'ganda' => $this->input->post('reserved_ganda' . $reservation_road->dag_no),
                                            'kranti' => $this->input->post('reserved_kranti' . $reservation_road->dag_no),
                                            'lm_code' => $this->session->userdata('user_code'),
                                            'date_update' => date('Y-m-d h:i:s'),
                                        );

                                        $this->db->where('case_no', $case_no);
                                        $this->db->where('type', 'R');
                                        $this->db->where('dag_no', $this->input->post('dag_no' . $reservation_road->dag_no));
                                        $this->db->update('settlement_reservation', $reservedarea_road);

                                        if ($this->db->affected_rows() == 0) {
                                            $this->db->trans_rollback();
                                            log_message('error', '#SETUP000444: Updation failed in settlement_reservation Dharitree Case No ' . $application_no);
                                            $data = array(
                                                'error' => "#SETUP000444: Registration of settlement_reservation failed for case no : " . $application_no,
                                            );
                                            echo json_encode($data);
                                            return false;
                                        }
                                    }

                                }
                            }

                            if ($roadside_comment_check=='NO') 
                            {
                                $resUpdate = "UPDATE settlement_reservation SET is_deleted = 1  WHERE case_no = '$case_no' AND type = 'R'";

                                $this->db->query($resUpdate);

                                if ($this->db->affected_rows() == 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#RESUPDTT000311: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#RESUPDTT000311: Updation Settlement failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }


                        }
                        else
                        {
                            //insert reservation
                            ///// road side reserve area start /////
                            if ($roadside_comment_check=='YES') {
                                foreach ($dags_result as $dags_roadside) {
                                    $reservedarea=array(
                                        'dist_code'=>$this->input->post('dist_code'),
                                        'subdiv_code'=>$this->input->post('subdiv_code'),
                                        'cir_code'=>$this->input->post('cir_code'),
                                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                        'lot_no'=>$this->input->post('lot_no'),
                                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                        'dag_no'=>$this->input->post('reserved_dag_road'.$dags_roadside->dag_no),
                                        'patta_no'=>$this->input->post('reserved_patta_road'.$dags_roadside->dag_no),
                                        'bigha'=>$this->input->post('reserved_bigha'.$dags_roadside->dag_no),
                                        'katha'=>$this->input->post('reserved_katha'.$dags_roadside->dag_no),
                                        'lessa'=>$this->input->post('reserved_lessa'.$dags_roadside->dag_no),
                                        'ganda'=>$this->input->post('reserved_ganda'.$dags_roadside->dag_no),
                                        'kranti'=>$this->input->post('reserved_kranti'.$dags_roadside->dag_no),
                                        'case_no'=>$case_no,
                                        'applid'=>$this->input->post('applid'),
                                        'lm_code'=>$this->session->userdata('user_code'),
                                        'date_entry'=>date('Y-m-d h:i:s'),
                                        'date_update'=>date('Y-m-d h:i:s'),
                                        'type'=>'R'
                                    );

                                    $reserveData = $this->db->insert('settlement_reservation', $reservedarea);
                                    // echo $this->db->last_query(); die();
                                    if ($reserveData != 1) {
                                        $this->db->trans_rollback();
                                        log_message('error', '#UPDTT00052: Update failed in settlement_reservation RTPS Case No '.$application_no);
                                        $data = array(
                                            'error'=>"#UPDTT00052: Update failed for case no : ".$application_no
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_ap_lmnote', $lmnote);
                if($this->db->affected_rows() == 0 )
                {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No '.$case_no);
                    $data = array(
                        'error'=>"#SETUP0004: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $this->input->post('lm_remark_additional'). "\n" .$this->input->post('lm_remark_text'),
                    'status' => 'X',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'LM updated note submitted'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
                //////proceeding end//////


                if($this->db->trans_status()==FALSE)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk    = 'Forwarded to '.$pending_officer;
                    $status = 'M';
                    $task   = 'LM';
                    $pen    = 'CO';
                    // $pen    = $pending_officer;
                    $case   = $case_no;
                    $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status = json_decode($rtps_status);
                    if (trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Settlement Application Updated Successfully with case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
        }
    }


    function settlementApUpdate()
    {

        $is_prem_update = $this->input->post('prem_update');
        $this->load->library('form_validation');

        $distCode = trim($this->input->post('dist_code'));
        if($distCode == NULL)
        {
            redirect(base_url(). 'index.php/home/SettlementApLm?service='.SETTLEMENT_AP_TRANSFER_ID);
        }

        $case_no = $this->input->post('application_no');
        if($case_no == NULL)
        {
            redirect(base_url(). 'index.php/home/SettlementApLm?service='.SETTLEMENT_AP_TRANSFER_ID);
        }

        $recordExist=$this->SettlementApiModel->checkExistDharitree($case_no);
        if($recordExist){
            $data=array(
                'error'=>"This Case Already Registered. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        $applicants_buyers = $this->SettlementApModel->getAllApplicantBuyers($case_no);
        $applicants_owners = $this->SettlementApModel->getAllApplicantOwners($case_no);
        $reservation  = $this->SettlementApModel->getSettlementReservation($case_no);
        $dags_premium = $this->SettlementApModel->getSettlementDagPremium($case_no);

        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
        $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
        $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
        $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
        $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
        $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
        $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

        $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Land falls under Tribal Belt', 'trim|required');
        $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Does applicant falls under protected category', 'trim|required|is_natural');
        $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide prone ?', 'trim|required');
        $this->form_validation->set_rules('possession_verified', 'Is Area Under cover landslide prone ?', 'trim|required');
        $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
        $this->form_validation->set_rules('is_landless', 'Whether applicant is landless', 'trim|required');
        $this->form_validation->set_rules('litigation', 'Whether proposed land is under litigation', 'trim|required');
        $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under ', 'trim|required|is_natural');
        $this->form_validation->set_rules('falls_und_gmc', 'land falls within 15 KM radius from the periphery of GMC  ', 'trim|required');
        // $this->form_validation->set_rules('zonal_valuation', 'Zonal valuation/current market value of the proposed land ', 'trim|required|numeric|greater_than[-1]');
        $this->form_validation->set_rules('is_nr_settlement', 'Whether applicant eligible for NR or NR with Settlement', 'trim|required');
        $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|greater_than[-1]');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
        $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
        $this->form_validation->set_rules('prem_update', 'Do you want to change the premium', 'trim|required');
        $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
        if($is_prem_update=='YES')
        {
            $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
            $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');
        }

        $this->form_validation->set_rules('dag_no', 'Dag Number', 'trim|required|is_natural');
        $this->form_validation->set_rules('patta_no', 'Patta Number', 'trim|required');
        $this->form_validation->set_rules('patta_type_code', 'Patta Type Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('gramdan_bhudan', 'Land falls category', 'required');
        $this->form_validation->set_rules('eksona_transfered', 'Is Eksona Land Transferred?', 'required');

        $roadsideMoreThanDagA = 0;
        $appAreaMoreThanDagA = 0;
        $familyMoreThanDagA = 0;
        $totalRoadSideRev = 0;
        $totalFamilyRev = 0;
        $totalAppArea = 0;

        // new additional property calculation
        $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$case_no'")->result();
        $singleAdditionalProToLessa = 0;
        $totalAdditionalProToLessa = 0;

        $isUrbanRevertBack = $this->SettlementCommonModel->getUrbanForRevertBack($case_no);
        $checkUrbanCon = $isUrbanRevertBack->is_urban;

        // for barak valley
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
            $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');

            $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
            $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

            $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
            $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
            $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
            $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
            $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

            if($dagAreaLessaValidation < $appAreaLessaValidation)
            {
                $appAreaMoreThanDagA = 1;
            }

            $totalAppArea += $appAreaLessaValidation;

            foreach($reservation as $setl)
            {
                if($setl->type=='R')
                {

                    $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda'.$setl->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti'.$setl->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                    $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                    $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);
                    $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$setl->dag_no), 0);

                    $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad ;

                    if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                    {
                        $roadsideMoreThanDagA = 1;
                    }
                    $totalRoadSideRev += $dagAreaLessaValidationRoad;

                }

                if($setl->type == 'F')
                {
                    $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda_family'.$setl->dag_no, 'Reserved for Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti_family'.$setl->dag_no, 'Reserved for Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);
                    $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$setl->dag_no), 0);

                    $dagAreaLessaValidationFamily = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;

                    if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                    {
                        $familyMoreThanDagA = 1;
                    }
                    $totalFamilyRev += $dagAreaLessaValidationFamily;
                }
            }

            foreach ($additional_properties as $singleProperty)
            {
                $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                $totalAdditionalProToLessa += $singleAdditionalProToLessa;
            }

        }
        else
        {
            $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('nr_bigha', 'Deed/Aggreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_katha', 'Deed/Aggreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('nr_lessa', 'Deed/Aggreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

            $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

            $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
            $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
            $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
            $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

            if($dagAreaLessaValidation < $appAreaLessaValidation)
            {
                $appAreaMoreThanDagA = 1;
            }

            $totalAppArea += $appAreaLessaValidation;

            foreach($reservation as $setl)
            {
                if($setl->type=='R')
                {
                    $this->form_validation->set_rules('reserved_bigha'.$setl->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$setl->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$setl->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$setl->dag_no), 0);
                    $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$setl->dag_no), 0);
                    $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$setl->dag_no), 0);

                    $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad ;

                    if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                    {
                        $roadsideMoreThanDagA = 1;
                    }
                    $totalRoadSideRev += $dagAreaLessaValidationRoad;
                }
                if($setl->type == 'F')
                {
                    $this->form_validation->set_rules('reserved_bigha_family'.$setl->dag_no, 'Reserved for Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$setl->dag_no, 'Reserved for Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$setl->dag_no, 'Reserved for Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$setl->dag_no), 0);
                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$setl->dag_no), 0);
                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$setl->dag_no), 0);

                    $dagAreaLessaValidationFamily = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                    if($appAreaLessaValidation < $dagAreaLessaValidationFamily)
                    {
                        $familyMoreThanDagA = 1;
                    }
                    $totalFamilyRev += $dagAreaLessaValidationFamily;
                }
            }
            foreach ($additional_properties as $singleProperty)
            {
                $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                $totalAdditionalProToLessa += $singleAdditionalProToLessa;
            }
        }



        // new additional property calculation end here

        $deleted_applicants = $this->input->post('deleted_applicant');
        $deleteAppCon = 0;
        $delApplicants = [];
        if($deleted_applicants != '' or $deleted_applicants != NULL)
        {
            $deleteAppCon = 1;
            $allSplitApplicants = (explode(",",$deleted_applicants));
            $delApplicants = [];
            foreach ($allSplitApplicants as $mm)
            {
                $splitApplicants = (explode("_",$mm));
                $delApplicants[] = $splitApplicants[0];
            }
        }
        if($applicants_owners == true)
        {
            foreach($applicants_owners as $owners)
            {
                $this->form_validation->set_rules('owners_name'.$owners->id, 'Owners Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('owners_guardian'.$owners->id, 'Owners Guardian', 'trim|required|min_length[1]|max_length[70]');
                $this->form_validation->set_rules('owners_in_place'.$owners->id, 'Owners In Place', 'trim|required');

            }
        }
        // additional file upload validation
        // upload additional files
        if(isset($_FILES['fileUpload']['name']))
        {
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size

            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i])
                {
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];
                    if($name != NULL)
                    {
                        if($ext == NULL)
                        {
                            // todo error show extension missing
                            $this->form_validation->set_rules('additional_doc_err','File extension','required');
                        }
                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                        {
                            // todo error show file allow type not match
                            $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                        }
                        if($size > UPLOAD_MAX_SIZE)
                        {
                            // todo error show file size
                            $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
                        }
                    }
                    else
                    {
                        // todo error show file not nullable
                        $this->form_validation->set_rules('additional_doc_err','File name','required');
                    }
                }
                else
                {
                    $this->form_validation->set_rules('additional_doc_err','File','required');
                }
            }
        }
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            if(isset($fileCount)){
                $district['fileCount'] = $fileCount;
            }
            $this->session->set_flashdata('error',$errors);
            return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
        }
        else
        {
            if($appAreaLessaValidation == 0)
            {
                $this->session->set_flashdata('error','Total applied area should not be Zero !');
                return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
            }
            if($appAreaMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total applied area should not be more than total Dag Area !');
                return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
            }
            if($roadsideMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total roadside reserved area should not be more than total applied area !');
                return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
            }
            if($familyMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total family reserved area should not be more than total applied area !');
                return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
            }
            if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
            {
                $this->session->set_flashdata('error','Total reserved area should not be more than total applied area !');
                return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
            }

            if(in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                if((MAX_APPLIED_ADDITIONAL_AREA * 6400) <  $totalAppArea + $totalAdditionalProToLessa)
                {
                    $this->session->set_flashdata('error','Total Land Area (Applied Area + Additional Area) 
                     cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !');
                    return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
                }
                if($checkUrbanCon == 'Y')
                {
                    if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $totalAppArea - $roadsideMoreThanDagA)
                    {
                        $this->session->set_flashdata('error','Total Applied Area in Urban cannot exceed  more than '.
                            MAX_APPLIED_URBAN_AREA_BARAK_KATHA . ' Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . ' Lessa !');
                        return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);

                    }
                }
            }
            else
            {
                if((MAX_APPLIED_ADDITIONAL_AREA * 100) <  $totalAppArea + $totalAdditionalProToLessa)
                {
                    $this->session->set_flashdata('error','Total Land Area (Applied Area + Additional Area)
                      cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !');
                    return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);
                }
                if($checkUrbanCon == 'Y')
                {
                    if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA  < $totalAppArea - $roadsideMoreThanDagA)
                    {
                        $this->session->set_flashdata('error','Total Applied Area in Urban cannot exceed  more than '.
                            MAX_APPLIED_URBAN_AREA_KATHA . ' Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . ' Lessa !');
                        return redirect(base_url(). 'index.php/SettlementAp/secondProceeding?case='.$case_no);

                    }
                }
            }

            $this->db->trans_begin();

            // insertion in backup table
            $phase_count   = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE case_no = '$case_no' AND from_office = 'LM'")->row()->ct;
            $applid_backup = $this->utilityclass->getApplidFromCaseNo($case_no);
            $phase_count   = (int)$phase_count+1;
            $backup_array_lm = [
                'applid' => $applid_backup,
                'case_no' => $case_no,
                'from_office' => 'LM',
                'to_office' => 'CO',
                'status' => 'X',
                'phase' => 'LM_'.$phase_count,
                'data' => json_encode($_POST)
            ];

            $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);

            if($backup_insertion_lm != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUP0032: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

                $this->session->set_flashdata('error_data', "#BACKUP0032: Registration of Settlement failed for case no : ".$case_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            // upload additional file
            if(isset($_FILES['fileUpload']['name'])){
                for($i = 0; $i < $fileCount; $i++)
                {
                    $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];

                    $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                    $config['upload_path']   = UPLOAD_DIR;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = UPLOAD_MAX_SIZE;;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $case_no,
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => UPLOAD_DIR . $fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => SETTLEMENT_AP_TRANSFER_ID,
                        );

                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRADDDOC34301: Insertion failed in supportive document RTPS Case No '.$case_no);

                            $this->session->set_flashdata('error_data', "#ERRADDDOC34301: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRADDDOC04501: Insertion failed in supportive document RTPS Case No '.$case_no);

                        $this->session->set_flashdata('error_data', "#ERRADDDOC04501: Registration of Settlement failed for case no : ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }

                }
            }
            //end of additional file upload


            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');
            $basic=array(
                'date_update' => date('Y-m-d G:i:s'),
                'status'=>'X',
                'user_code'=>$this->session->userdata('user_code'),
                'lm_code'=>$this->session->userdata('user_code'),
                'period_possession'=>$this->input->post('period_possession'),
                'occupation_applicant'=>$this->input->post('occupation_applicant'),
                'protected_class' => $protected_class_vr,
                'from_office' => 'LM',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'tribal_belt' => $this->input->post('tribal_belt')
                /////////
            );

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basic);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No '.$case_no);
                $data = array(
                    'error'=>"#SETUP0001: Registration of Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }
            ////settlement_dag_details insert start
            $fmd=array(
                'user_code'=>$this->session->userdata('user_code'),
                'date_update' => date('Y-m-d G:i:s'),
            );
            $landmark_east = $this->input->post('landmark_east');
            $landmark_west = $this->input->post('landmark_west');
            $landmark_north = $this->input->post('landmark_north');
            $landmark_south = $this->input->post('landmark_south');

            $landmark = [
                'east' => $landmark_east,
                'west' => $landmark_west,
                'north' => $landmark_north,
                'south' => $landmark_south,
            ];

            $fmd['s_dag_area_b']  = $this->input->post('s_dag_area_b');
            $fmd['s_dag_area_k']  = $this->input->post('s_dag_area_k');
            $fmd['s_dag_area_lc'] = $this->input->post('s_dag_area_lc');
            $fmd['s_dag_area_g']  = $this->input->post('s_dag_area_g');
            $fmd['s_dag_area_kr'] = $this->input->post('s_dag_area_kr');
            $fmd['nr_bigha']  = $this->input->post('nr_bigha');
            $fmd['nr_katha']  = $this->input->post('nr_katha');
            $fmd['nr_lessa']  = $this->input->post('nr_lessa');
            $fmd['nr_ganda']  = $this->input->post('nr_ganda');
            $fmd['nr_kranti'] = $this->input->post('nr_kranti');
            $fmd['landmark']  = json_encode($landmark);

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_dag_details', $fmd);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#SETUP0002: Updation failed in settlement_dag_details Dharitree Case No '.$case_no);
                $data = array(
                    'error'=>"#SETUP0002: Registration of Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }

            $sql1 = "SELECT petition_no FROM settlement_basic WHERE case_no = '$case_no'";
            $result1 = $this->db->query($sql1);
            if($result1->num_rows() > 0)
            {
                $petition_no = (int)$result1->row()->petition_no;
            }
            else
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                $data = array(
                    'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }

            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '$case_no'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0)
            {
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }
            else
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                $data = array(
                    'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }

            /// new dynamic applicant add/////
            if(isset($_POST['pdar_name2']))
            {
                foreach($_POST['pdar_name2'] as $key =>$value)
                {
                    $applicant2=array(
                        'dist_code'=>$this->input->post('dist_code'),
                        'subdiv_code'=>$this->input->post('subdiv_code'),
                        'cir_code'=>$this->input->post('cir_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no,
                        'petition_no'=>$petition_no,
                        'pdar_cron_no'=>(int) $cron_no++,
                        'operation'=>'E',
                        'dag_no' =>$this->input->post('dag_no'),
                        'patta_no' =>$this->input->post('patta_no'),
                        'patta_type_code'=>$this->input->post('patta_type_code'),
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' =>-1,
                        'pdar_name' =>$value,
                        'pdar_guardian' =>$_POST['pdar_guardian2'][$key],
                        'pdar_rel_guar' =>$_POST['pdar_rel_guar2'][$key],
                        'pdar_gender'=>$_POST['pdar_gender2'][$key],
                        'pdar_add1' => $_POST['pdar_add12'][$key],
                        'pdar_add2' => $_POST['pdar_add22'][$key],
                        'pdar_mobile' => $_POST['pdar_mobile2'][$key],
                        'pdar_type' => 'B',
                        'dob' => $_POST['dob2'][$key]
                    );

                    $insSetApplicant2 = $this->db->insert('settlement_applicant',$applicant2);
                    if($insSetApplicant2 != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                        $data = array(
                            'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }
            $deleteApplicantsReverted = [];
            foreach ($delApplicants as $app)
            {
                $sqlA = "SELECT * FROM settlement_applicant WHERE id = '$app'";
                $resultA = $this->db->query($sqlA);
                $deleteApplicantsReverted[] = $resultA->row();
            }
            foreach ($deleteApplicantsReverted as $singleDeleteApplicant)
            {
                $allDeletedApplicants=array(
                    'dist_code'  =>$singleDeleteApplicant->dist_code,
                    'subdiv_code'=>$singleDeleteApplicant->subdiv_code,
                    'cir_code'   =>$singleDeleteApplicant->cir_code,
                    'mouza_pargona_code'=>$singleDeleteApplicant->mouza_pargona_code,
                    'lot_no'=>$singleDeleteApplicant->lot_no,
                    'vill_townprt_code'=>$singleDeleteApplicant->vill_townprt_code,
                    'user_code'=>$singleDeleteApplicant->user_code,
                    'case_no'=>$singleDeleteApplicant->case_no,
                    'petition_no'=>$singleDeleteApplicant->petition_no,
                    'pdar_cron_no'=>$singleDeleteApplicant->pdar_cron_no,
                    'operation'=>'D',
                    'dag_no' =>$singleDeleteApplicant->dag_no,
                    'patta_no' =>$singleDeleteApplicant->patta_no,
                    'patta_type_code'=>$singleDeleteApplicant->patta_type_code,
                    'year_no'=>$singleDeleteApplicant->year_no,
                    'date_entry'=>date('Y-m-d'),
                    'pdar_id' =>$singleDeleteApplicant->pdar_id,
                    'pdar_name' =>$singleDeleteApplicant->pdar_name,
                    'pdar_guardian' =>$singleDeleteApplicant->pdar_guardian,
                    'pdar_rel_guar' =>$singleDeleteApplicant->pdar_rel_guar,
                    'pdar_gender'=>$singleDeleteApplicant->pdar_gender,
                    'pdar_add1' => $singleDeleteApplicant->pdar_add1,
                    'pdar_add2' => $singleDeleteApplicant->pdar_add2,
                    'pdar_mobile' => $singleDeleteApplicant->pdar_mobile,
                    'pdar_type' => $singleDeleteApplicant->pdar_type,
                );

                $insSetApplicantInDeleted = $this->db->insert('settlement_applicant_delete',$allDeletedApplicants);
                if($insSetApplicantInDeleted != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00039: Insertion failed in settlement_applicant RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERRSET00039: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            foreach ($delApplicants as $app)
            {
                $sqlD = "DELETE FROM settlement_applicant WHERE id = '$app'";
                $this->db->query($sqlD);
            }

            ////settlement_applicant insert start
            foreach ($applicants_buyers as $setl)
            {
                if (in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                if ($this->input->post('pdar_id' . $setl->id) == "" || $this->input->post('pdar_id' . $setl->id) == null || empty($this->input->post('pdar_id' . $setl->id)))
                {
                    $chitha_pdar_id = -1;
                }
                else
                {
                    $chitha_pdar_id = $this->input->post('pdar_id' . $setl->id);
                }
                $applicant = array(
                    'user_code' => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d G:i:s'),
                    'pdar_id' => $chitha_pdar_id,
                    'pdar_name' => $this->input->post('pdar_name' . $setl->id),
                    'pdar_guardian' => $this->input->post('pdar_guardian' . $setl->id),
                    'pdar_rel_guar' => $this->input->post('pdar_rel_guar' . $setl->id),
                    'pdar_gender' => $this->input->post('pdar_gender' . $setl->id),
                    'pdar_add1' => $this->input->post('pdar_add1' . $setl->id),
                    'pdar_add2' => $this->input->post('pdar_add2' . $setl->id),
                    'pdar_mobile' => $this->input->post('pdar_mobile' . $setl->id),
                    'eng_pdar_guardian' => $this->input->post('eng_pdar_guardian'.$setl->id),
                );
                $this->db->where('id', $setl->id);
                $this->db->update('settlement_applicant', $applicant);

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#SETUP0003: Updation failed in settlement_applicant Dharitree Case No ' . $case_no);
                    $data = array(
                        'error' => "#SETUP0003: Registration of Settlement failed for case no : " . $case_no,
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            if($applicants_owners == true)
            {
                foreach($applicants_owners as $owners)
                {
                    if($this->input->post('pdar_id'.$owners->id)=="" || $this->input->post('pdar_id'.$owners->id)==null || empty($this->input->post('pdar_id'.$owners->id)))
                    {
                        $chitha_pdar_id=-1;
                    }
                    else
                    {
                        $chitha_pdar_id=$this->input->post('pdar_id'.$owners->id);
                    }
                    $owners_update=array(
                        'user_code'=>$this->session->userdata('user_code'),
                        'date_update' => date('Y-m-d G:i:s'),
                        'pdar_name' =>$this->input->post('owners_name'.$owners->id),
                        'pdar_guardian' =>$this->input->post('owners_guardian'.$owners->id),
                        'inplace_alongwith' => $this->input->post('owners_in_place'.$owners->id),
                    );
                    $this->db->where('id', $owners->id);
                    $this->db->update('settlement_applicant', $owners_update);

                    if($this->db->affected_rows() == 0 )
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0004: Updation failed in settlement_applicant Dharitree Case No '.$case_no);
                        $data = array(
                            'error'=>"#SETUP0004: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ////////////////////file///////////////////////////
            if(isset($_FILES))
            {
                foreach ($_FILES as $file => $key)
                {
                    if ($key['tmp_name'] == false)
                    {
                        continue;
                    }
                    $doc_dag_no =  strstr($file,  '_', true);
                    $doc_id = substr($file, strpos($file, "_") + 1);
                    preg_match('/DOCMAIN/', $file, $match);
                    if($match)
                    {
                        if ($match[0] == 'DOCMAIN')
                        {
                            $timestamp = date('mdYhis', time()).uniqid();
                            $config['file_name']     = 'updated_file'.$timestamp;
                            $config['upload_path']   = UPLOAD_DIR;
                            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                            $config['max_size']      = 2000;

                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);

                            if ( ! $this->upload->do_upload($file))
                            {
                                $error = array('error' => $this->upload->display_errors());
                                echo json_encode($error);
                                return false;
                            }
                            else
                            {
                                $data = array('upload_data' => $this->upload->data());
                                $document= array(
                                    'file_type' => $data['upload_data']['file_type'],
                                    'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                );

                                $this->db->where('id', $doc_id);
                                $this->db->update('supportive_document', $document);
                                if ($this->db->affected_rows() == 0)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#SETUP6845545: Updation failed in supprotive_documents Dharitree Case No ' . $case_no);
                                    $data = array(
                                        'error' => "#SETUP6845545: Failed to upload documents, Please compress the file and reupload. case no : " . $case_no,
                                    );
                                    echo json_encode($data);
                                    log_message("error", "last query" . json_encode($this->db->last_query()));
                                    return false;
                                }
                            }
                        }
                    }
                }
            }

            ///////////////////////////////////////////////
            $comment = addslashes($this->input->post('lm_note'));
            $pro_class_lm = $this->input->post('protected_class_lm');
            $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'chitha_verified'=>$this->input->post('chitha_verified'),
                // 'vlb_verified'=>$this->input->post('vlb_verified'),
                'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                'erosion' => $this->input->post('erosion'),
                'possession_verification'=>$this->input->post('possession_verified'),
                'period_possession'=>date('Y-m-d'),
                'nature_possession'=>$this->input->post('nature_possession'),
                'is_landless'=>$this->input->post('is_landless'),
                // 'ceiling_limit'=>$this->input->post('ceiling_limit'),
                'roadside_reservation'=>$this->input->post('roadside_reservation'),
                // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
                // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                // 'chitha_copy'=>$this->input->post('chitha_copy'),
                'trace_map_copy'=>'NA',
                'chitha_copy'=>'NA',
                'lm_note'=>$comment,
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'land_falls'=>$this->input->post('land_falls'),
                'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                'lm_remark_text'=>$this->input->post('lm_remark_text'),
                'total_bigha'=>$this->input->post('total_bigha'),
                'total_Katha'=>$this->input->post('total_Katha'),
                'total_lessa'=>$this->input->post('total_lessa'),
                'total_ganda'=>$this->input->post('total_ganda'),
                'total_kranti'=>$this->input->post('total_kranti'),
                // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                'landslide'            => $this->input->post('landslide'),
                'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                'protected_class_lm' => $protected_class_lm,
                'litigation' => $this->input->post('litigation'),
                'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                'eksona_type' => $this->input->post('gramdan_bhudan'),
                'eksona_transfered' => $this->input->post('eksona_transfered')
            );

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_ap_lmnote', $lmnote);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No '.$case_no);
                $data = array(
                    'error'=>"#SETUP0004: Registration of Settlement failed for case no : ".$case_no
                );
                echo json_encode($data);
                return false;
            }


            ///// road side reserve area start /////
            $roadside_comment_check=$this->input->post('roadside_comment_check');
            foreach($reservation as $roads)
            {
                if($roads->type=='R')
                {
                    $reservedarea = [
                        'bigha'   => $this->input->post('reserved_bigha'.$roads->dag_no),
                        'katha'   => $this->input->post('reserved_katha'.$roads->dag_no),
                        'lessa'   => $this->input->post('reserved_lessa'.$roads->dag_no),
                        'ganda'   => $this->input->post('reserved_ganda'.$roads->dag_no),
                        'kranti'  => $this->input->post('reserved_kranti'.$roads->dag_no),
                        'lm_code' => $this->session->userdata('user_code'),
                        'date_update' => date('Y-m-d h:i:s'),
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('type', 'R');
                    $this->db->update('settlement_reservation', $reservedarea);
                    if($this->db->affected_rows() == 0 )
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP00041: Updation failed in settlement_reservation Dharitree Case No '.$case_no);
                        $data = array(
                            'error'=>"#SETUP00041: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                    // echo $this->db->last_query(); die();

                }
                if($roads->type == 'F')
                {
                    $reservedareafamily = [
                        'bigha'   => $this->input->post('reserved_bigha_family'.$roads->dag_no),
                        'katha'   => $this->input->post('reserved_katha_family'.$roads->dag_no),
                        'lessa'   => $this->input->post('reserved_lessa_family'.$roads->dag_no),
                        'ganda'   => $this->input->post('reserved_ganda_family'.$roads->dag_no),
                        'kranti'  => $this->input->post('reserved_kranti_family'.$roads->dag_no),
                        'lm_code' => $this->session->userdata('user_code'),
                        'date_update' => date('Y-m-d h:i:s'),
                    ];

                    $this->db->where('case_no', $case_no);
                    $this->db->where('type', 'F');
                    $this->db->update('settlement_reservation', $reservedareafamily);
                    if($this->db->affected_rows() == 0 )
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP00042: Updation failed in settlement_reservation Dharitree Case No '.$case_no);
                        $data = array(
                            'error'=>"#SETUP00042: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            //// premium insert lm update start
            if($is_prem_update=='YES')
            {
                $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no'";
                $resultprem = $this->db->query($sqlprem);
                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000311: Updation failed in settlement_applicant RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERRSET000311: Updation Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $sumMbAmount=0;
                foreach ($dags_premium as $premdags)
                {
                    // premium verify start ******************
                    if (in_array($premdags->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $area_in_bigha=6400;
                    }
                    else
                    {
                        $area_in_bigha=100;
                    }
                    $concession_rate=25;
                    $ratetype=$this->input->post('rate_type'.$premdags->dag_no);
                    $ratepr2=$this->db->query("Select rate_type from settlement_premium_rate where prid=$ratetype ")->row();
                    $ratepr = $ratepr2->rate_type;
                    // var_dump($ratepr->rate_type); die;
                    $is_full_pay=$this->input->post('paymode');
                    $uuid=$this->input->post('uuid');
                    $prem_zonal = $this->utilityclass->getZonalValue($premdags->dist_code,$uuid,$premdags->dag_no);
                    $prem_area = $this->input->post('total_lessa'.$premdags->dag_no);
                    $prem_rate = $this->input->post('rate'.$premdags->dag_no);
                    $prem_concession =$this->input->post('concession'.$premdags->dag_no);
                    $mb_land =$this->input->post('mb_land'.$premdags->dag_no);
                        

                    if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                        if($mb_land == 25){
                            $mb_land=1600;
                        }else if ($mb_land == 30){
                            $mb_land=1920;
                        }else if ($mb_land == 40){
                            $mb_land=2560;
                        }
                    }

                    // if ($prem_concession=="YES")
                    // {
                    //     if($ratepr =='P')
                    //     {
                    //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                    //         $discount = $prem_rate-($prem_rate * $concession_rate / 100);
                    //         $amount = ($premium * $discount / 100);
                    //         // $finalamount = round($amount,2);
                    //         $finalamount = ceil($amount);
                    //     }
                    //     else if($ratepr =='R')
                    //     {
                    //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                    //         $discount = $prem_rate - $concession_rate;
                    //         $amount = ($premium * $discount / 100);
                    //         $finalamount = ceil($amount);
                    //     }

                    // }else if($prem_concession=="NO"){
                    //     if($ratepr =='P'){
                    //         $premium = $prem_area * $prem_zonal / $area_in_bigha;
                    //         $amount = ($premium * $prem_rate / 100);
                    //         $finalamount = ceil($amount);
                    //     }else if($ratepr =='R'){
                    //         $premium = $prem_area * $prem_rate / $area_in_bigha;
                    //         $amount = ($premium * $prem_rate / 100);
                    //         $finalamount = ceil($amount);
                    //     }
                    // }

                     if ($prem_concession=="YES"){
                        if($ratepr =='P'){
                            if($prem_area>$mb_land){

                                $concession_factor = (100 - $concession_rate) / 100;

                                $base_premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                $amount1 = ceil($base_premium1 * $prem_rate / 100 * $concession_factor);

                                //for access area
                                $access_area = max(0, $prem_area - $mb_land);
                                $base_premium2 = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                $amount2 = ceil($base_premium2 * $concession_factor);
                                
                                $finalamount = ceil($amount1 + $amount2);
                                
                                
                            }else{
                                
                                $concession_factor = (100 - $concession_rate) / 100;

                                $base_premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                $amount = $base_premium * ($prem_rate / 100) * $concession_factor;

                                $finalamount = ceil($amount);
                            }

                        }else if($ratepr =='R'){
                            $premium = $prem_area * $prem_rate / $area_in_bigha;
                            $discount = ceil($premium * ($concession_rate/100));
                            $finalamount = ceil($premium - $discount);
                        }

                    }else if($prem_concession=="NO"){
                        if($ratepr =='P'){
                            
                            if ($prem_area > $mb_land) {
                                // --- Part 1: within mb_land ---
                                $premium1 = ($mb_land * $prem_zonal) / $area_in_bigha;
                                $amount1  = ceil($premium1 * $prem_rate / 100);

                                // --- Part 2: excess area at flat 150% zonal (no prem_rate applied) ---
                                $access_area = $prem_area - $mb_land;
                                $premium2    = ($access_area * ($prem_zonal * 1.5)) / $area_in_bigha;
                                $amount2     = ceil($premium2);

                                $finalamount = $amount1 + $amount2;

                            } else {
                                // --- No excess area ---
                                $premium = ($prem_area * $prem_zonal) / $area_in_bigha;
                                $amount  = $premium * $prem_rate / 100;
                                $finalamount = ceil($amount);  
                        }

                        }else if($ratepr =='R'){
                            $finalamount = ceil($prem_area * $prem_rate / $area_in_bigha);
                        }
                    }

                    $sumMbAmount += $finalamount;

                    // premium verify end ******************

                    $premdata=array(
                        'case_no'=>$case_no,
                        'user_code'=>$this->session->userdata('user_code'),
                        // 'uuid'=>$premdags->uuid,
                        'dag_no'=>$premdags->dag_no,
                        'zonal_valuation'=>$this->input->post('zonal_valuation_prem'),
                        'area_name'=>$this->input->post('area'.$premdags->dag_no),
                        'land_type'=>$this->input->post('land_type'.$premdags->dag_no),
                        'rate_type'=>$this->input->post('rate_type'.$premdags->dag_no),
                        'rate'=>$this->input->post('rate'.$premdags->dag_no),
                        'concession'=>$this->input->post('concession'.$premdags->dag_no),
                        'amount_dag'=>$this->input->post('amount'.$premdags->dag_no),
                        'final_amount'=>$this->input->post('finalamount'),
                        'due_amount'=>$this->input->post('totaldue'),
                        'total_lessa'=>$this->input->post('total_lessa'.$premdags->dag_no),
                        'is_full_pay'=>$this->input->post('paymode'),
                        'is_final'=>1,
                        'date_entry'=>date('Y-m-d h:i:s'),

                    );

                    $insPremiumUpdate = $this->db->insert('settlement_premium', $premdata);

                    if ($insPremiumUpdate != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No '.$case_no);
                        $data = array(
                            'error'=>"#ERRSET000102: Update of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // premium verify 2 start ******************
                if($sumMbAmount != $this->input->post('finalamount')){
                    // var_dump("Amount mismatch!!!"); die;
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAM0003: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }
                if ($is_full_pay=="NO"){
                    $discount = 30;
                    $finaldue = ($sumMbAmount * $discount / 100);
                    // $finaldueamount = round($finaldue,2);
                    $finaldueamount = ceil($finaldue);
                }else if ($is_full_pay=="YES"){
                    $finaldueamount= $sumMbAmount;
                }

                if($finaldueamount != $this->input->post('totaldue')){
                    // var_dump("Due Amount mismatch!!!");
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAM0004: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }

                // premium verify 2 end ******************
            }


            /// premium insert lm update end


            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

            if($proceeding_id==null){
                $proceeding_id=1;
            }

            $insPetProceed = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => $this->input->post('lm_remark_text'),
                'status' => 'X',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'LM',
                'office_to' => 'CO',
                'task' => 'LM updated note submitted'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            // echo $this->db->last_query(); die();
            if($insertProceeding != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
            //////proceeding end//////

            ////settlement AP LM Report insert end

            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
            }
            else
            {
                //  $basundhara=array(
                //      'dharitree'=>$case_no,
                //      'basundhara'=>$case_no,
                //      'date_reg'=>date('Y-m-d'),
                //      'reg_by'=>$this->session->userdata('user_code'),
                //      'app_status'=>'W',
                //      'pending_with'=>'LM'
                //  );
                //  $this->db->insert('basundhar_application',$basundhara);

                $this->db->trans_commit();

                //////
                //////////////////////////////////
                $this->session->set_flashdata('message', "Settlement Application Updated Successfully with case no # $case_no");
                redirect(base_url() . "index.php/home");

            }
        }

    }


    function statusChange($status,$fromOffice,$penOfficer){
        $case_no=$this->input->get('case');
        // $status=$this->input->get('s');
        // $penOfficer=$this->input->get('p');
        // $fromOffice=$this->input->get('f');
        $array=[
            'status'=>$status,
            'pending_officer'=>$penOfficer,
            'from_office'=>$fromOffice,
        ];
        $this->db->where('case_no',$case_no);
        $this->db->update('settlement_basic',$array);
        echo $this->db->affected_rows();
    }


    public function nrToSettlement(){
        $application_no = $this->input->get('case');
        // $user= $this->session->userdata('user_code');

        // if($this->session->userdata('lot_no')=='' ){

        // }else{

        //    $this->session->set_flashdata('message', "Unauthorized Access!!");
        //    redirect(base_url() . "index.php/home");
        // }
        $basic   = $this->SettlementApModel->getSettlementBasic($application_no);
        //  result
        $applicants_buyers   = $this->SettlementApModel->getAllApplicantBuyers($application_no);
        $applicants_owners   = $this->SettlementApModel->getAllApplicantOwners($application_no);
        $applicants_encroacher   = $this->SettlementApModel->getAllApplicantEncroacher($application_no);
        $applicants_riotee_nok   = $this->SettlementApModel->getAllApplicantRioteeNok($application_no);

        $dags   = $this->SettlementApModel->getSettlementDag($application_no);
        $lmnotes   = $this->SettlementApModel->getSettlementApLmNote($application_no);
        $proceedings   = $this->SettlementApModel->getSettlementProceeding($application_no);
        $dhardocuments   = $this->SettlementApModel->getDocuments($application_no);

        $lmdata['basic']=$basic;

        $lmdata['applicants_buyers']=$applicants_buyers;
        $lmdata['applicants_owners']=$applicants_owners;
        $lmdata['applicants_encroacher']=$applicants_encroacher;
        $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

        $lmdata['dags']=$dags;
        $lmdata['lmnotes']=$lmnotes;
        $lmdata['proceedings']=$proceedings;
        $lmdata['dhardocuments']=$dhardocuments;

        $d=$basic["dist_code"];
        $s=$basic["subdiv_code"];
        $c=$basic["cir_code"];
        $m=$basic["mouza_pargona_code"];
        $l=$basic["lot_no"];
        $v=$basic["vill_townprt_code"];


        if($applicants_encroacher == true){
            foreach($applicants_encroacher as $encroacher){
                //echo "<pre>";
                //var_dump($encroacher);

                $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                $district['vlb_enc'] = $vlb_encroacher;

                if($vlb_encroacher == true){
                    // getting the encroacher details
                    $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                    //var_dump($vlb_encroacher_in_dag); die();

                    $lmdata['vlb_enc_details'] = $vlb_encroacher_in_dag;
                }else{
                    $lmdata['empty_err'] = "No Land Bank Details found!!";
                }
            }

        }

        //   calling API for self declaration data

        //   $lmdata['pattaNo']=$this->utilityclass->getPattaTypeNo($lmdata['basic']["dist_code"],$lmdata['basic']["subdiv_code"],$lmdata['basic']["cir_code"],$lmdata['basic']["mouza_pargona_code"],$lmdata['basic']["lot_no"],$lmdata['basic']["vill_townprt_code"],$lmdata['dags']["dag_no"]);

        $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        $basundhara = $this->db->query($sql)->row();
        // var_dump($basundhara->basundhara); die();
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $basundhara->basundhara,
            'api_key' => API_KEY,
            'token' => $token
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType == 3){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);

        $output = json_decode($output);
        //var_dump($output);

        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        $lmdata['nextKin']=$output->nextKin;
        foreach($output->selfDeclaration as $selfDec){
            $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        // var_dump($lmdata['applicants_owners']); die();

        $lmdata['_view'] = 'SettlementView/Lm/SettlementApNr';

        $this->load->view('layouts/main',$lmdata);

    }


    function settlementApNrUpdate()
    {

        $application_no=$this->input->post('application_no');
        $case_no=$application_no;
        //////////////////
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"This Case Already Registered. Please Check"
            );
            echo json_encode($data);
            exit;
        }


        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }

        $basic=array(
            'date_update' => date('Y-m-d G:i:s'),
            'status'=>'X',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO'
            /////////
        );

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basic);

        if($this->db->affected_rows() == 0 ){
            $this->db->trans_rollback();
            log_message('error', '#SETUP0001: Updation failed in settlement_basic Dharitree Case No '.$application_no);
            $data = array(
                'error'=>"#SETUP0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert start
        $fmd=array(
            'user_code'=>$this->session->userdata('user_code'),
            'date_update' => date('Y-m-d G:i:s'),
        );

        $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
        $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
        $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
        $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
        $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_dag_details', $fmd);
        if($this->db->affected_rows() == 0 )
        {
            $this->db->trans_rollback();
            log_message('error', '#SETUP0002: Updation failed in settlement_dag_details Dharitree Case No '.$application_no);
            $data = array(
                'error'=>"#SETUP0002: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ////settlement_applicant insert start
        $applicants = $this->SettlementApModel->getAllApplicant($application_no);
        $i=0;
        foreach($applicants as $setl)
        {
            $i = $i+1;
            if($this->input->post('pdar_id'.$i)=="" || $this->input->post('pdar_id'.$i)==null || empty($this->input->post('pdar_id'.$i)))
            {
                $chitha_pdar_id=-1;
            }
            else
            {
                $chitha_pdar_id=$this->input->post('pdar_id'.$i);
            }
            $applicant=array(
                'user_code'   => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d G:i:s'),
                'pdar_name'   => $this->input->post('pdar_name'.$i),
                'pdar_guardian' => $this->input->post('pdar_guardian'.$i),
                'pdar_rel_guar' => $this->input->post('pdar_rel_guar'.$i),
                'pdar_gender'   => $this->input->post('pdar_gender'.$i),
                'pdar_add1' => $this->input->post('pdar_add1'.$i),
                'pdar_add2' => $this->input->post('pdar_add2'.$i),
                'i_area_b'  => $this->input->post('i_area_b'.$i),
                'i_area_k'  => $this->input->post('i_area_k'.$i),
                'i_area_lc' => $this->input->post('i_area_lc'.$i),
                'i_area_g'  => $this->input->post('i_area_g'.$i),
                'i_area_kr' => $this->input->post('i_area_kr'.$i),
            );

            // $this->db->where('case_no', $case_no);
            $this->db->where('id', $setl->id);
            $this->db->update('settlement_applicant', $applicant);
            if($this->db->affected_rows() == 0 )
            {
                $this->db->trans_rollback();
                log_message('error', '#SETUP0003: Updation failed in settlement_applicant Dharitree Case No '.$application_no);
                $data = array(
                    'error'=>"#SETUP0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        ////settlement khas AP LM Report insert start

        ////////////////////file///////////////////////////
        header('content-type:application/json');
        $documents_config = json_decode(SETTLEMENT_KHAS_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>date('Y-m-d'),
            'nature_possession'=>$this->input->post('nature_possession'),
            'is_landless'=>$this->input->post('is_landless'),
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti,
            'total_bigha'=>$this->input->post('total_bigha'),
            'total_Katha'=>$this->input->post('total_Katha'),
            'total_lessa'=>$this->input->post('total_lessa'),
            'total_ganda'=>$this->input->post('total_ganda'),
            'total_kranti'=>$this->input->post('total_kranti'),
        );

        // $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        // if($insLmnote != 1)
        // {
        //       $this->db->trans_rollback();
        //       log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
        //       $data = array(
        //          'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
        //       );
        //       echo json_encode($data);
        //       return false;
        // }

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_ap_lmnote', $lmnote);

        if($this->db->affected_rows() == 0 ){
            $this->db->trans_rollback();
            log_message('error', '#SETUP0004: Updation failed in settlement_ap_lmnote Dharitree Case No '.$application_no);
            $data = array(
                'error'=>"#SETUP0004: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null)
        {
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $this->input->post('lm_remark_text'),
            'status' => 'X',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM NR to Settlement note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement AP LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            //  $basundhara=array(
            //      'dharitree'=>$case_no,
            //      'basundhara'=>$application_no,
            //      'date_reg'=>date('Y-m-d'),
            //      'reg_by'=>$this->session->userdata('user_code'),
            //      'app_status'=>'W',
            //      'pending_with'=>'LM'
            //  );
            //  $this->db->insert('basundhar_application',$basundhara);

            $this->db->trans_commit();
            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='X';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            // $this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Updated Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

        }
    }


    public function appAreaLessaValidation(){
        return false;
    }

    public function appAreaMoreThanDagA(){
        return false;
    }

    public function roadsideMoreThanDagA(){
        return false;
    }

    public function familyMoreThanDagA(){
        return false;
    }

    public function reserveAreaCheck(){
        return false;
    }

    public function totalSettlementAreaNotMatchHomeAgri(){
        return false;
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

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function getValidationBypass($service_code)
    {
        if(!$service_code)
        {
            return false;
        }

        foreach(json_decode(VALIDATION_BYPASS) as $cons_reasons)
        {
            if($cons_reasons->SERVICE_CODE == $service_code)
            {
                $validation_bypass_array = ($cons_reasons->REJECTED_CODE);
            }
        }
        return $validation_bypass_array;
    }

    function settlementApplication($review_flag = false)
    {
        $application_no = $this->input->get('app'); // get rtps application no
        // $application_no = $this->utilityclass->decryptJwtCase($application_no);

        // get data from basundhara end (API call)
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
            'api_key'        => API_KEY,
            'token'          => $token
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType == 3){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        //   header('content-type:application/json');
        $backup = $output;
        $output = json_decode($output);

        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        if($get_aadhaar_photo != 'n'){
            $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        $app = $output->application;
        $d   = $app->dist_code;
        $s   = $app->subdiv_code;
        $c   = $app->cir_code;
        $m   = $app->mouza_code;
        $l   = $app->lot_no;
        $v   = $app->village_code;
        $dag = $app->dag_no;

        // check if case already registered
        $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);

        if(!$recordExist) {

            $case_name=$this->SettlementApiModel->genearteCaseName(); // generate case name
            if(empty($case_name)){
                log_message('error', '#ERROR0002: Case name can not be generated for application
            no '.$application_no);
                $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                exit;
            }

            //generate case no
            $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_AP_TRANSFER;

            //check for tribal belt
            if($output->applicants['0']->under_tribe_belts == 1){
                $tribal_belt = 'YES';
            }
            else if($output->applicants['0']->under_tribe_belts == 0){
                $tribal_belt = 'NO';
            }
            else {
                $tribal_belt = '';
            }

            //check for bhumiputra certificate starts here
            if(!empty($output->bhumi['0'])) {

                if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                    $bhumiputra_confirmation     = 'YES';
                    $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'CERT';
                }
                else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                    $bhumiputra_confirmation     = 'YES';
                    $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                    $bhumiputra_certificate_type = 'ACK';
                }
                else {
                    $bhumiputra_confirmation     = '0';
                    $bhumiputra_certificate_no   = '0';
                    $bhumiputra_certificate_type = '0';
                }
            }
            else {
                $bhumiputra_confirmation     = '0';
                $bhumiputra_certificate_no   = '0';
                $bhumiputra_certificate_type = '0';
            }

            $this->db->trans_begin(); // transaction begins here

            foreach($output->applicants as $type_of_lands) {
                if($type_of_lands->is_applicant == 1) {
                    $type_of_transfer=$type_of_lands->type_of_transfer;
                    $type_of_patta =$type_of_lands->type_of_patta;
                    $applicant_occupation = $type_of_lands->applicant_occupation;
                    $applicant_ref_no = $type_of_lands->ref_no;
                    $applicant_caste_category= $type_of_lands->caste_category;
                    $applicant_uuid= $type_of_lands->uuid;
                }
            }

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM
            $settlement_basic=[
                'dist_code'                   => $d,
                'subdiv_code'                 => $s,
                'cir_code'                    => $c,
                'mouza_pargona_code'          => $m,
                'lot_no'                      => $l,
                'vill_townprt_code'           => $v,
                'service_code'                => SETTLEMENT_AP_TRANSFER_ID,
                'ref_no'                      => $applicant_ref_no,
                'case_no'                     => $case_no['case_no'],
                'trans_code'                  => 'F',
                'petition_no'                 => $case_no['petition_no'],
                'year_no'                     => date('Y'),
                'date_entry'                  => date('Y-m-d G:i:s'),
                'status'                      => 'Z',
                'submission_date'             => date('Y-m-d G:i:s'),
                'period_possession'           => date('Y-m-d'),
                'occupation_applicant'        => $applicant_occupation,
                'applid'                      => $application_no,
                'caste'                       => $applicant_caste_category,
                'uuid'                        => $applicant_uuid,
                'from_office'                 => 'API',
                'pending_officer'             => 'LM',
                'pending_office'              => 'CO',
                'tribal_belt'                 => $tribal_belt,
                'bhumiputra_confirmation'     => $bhumiputra_confirmation,
                'bhumiputra_certificate_no'   => $bhumiputra_certificate_no,
                'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                'user_code'                   => $this->session->userdata('user_code'),
                'type_of_transfer'            => $type_of_transfer,
                'type_of_patta'               => $type_of_patta,
            ];
            $settlement_basic_insertion = $this->db->insert('settlement_basic',$settlement_basic);
            if($settlement_basic_insertion != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Settlement failed for RTPS application no : ".$application_no);
                return false;
            }

            //insert into ADDITIONAL PROPERTY
            $checkAdditionalProperty = $this->SettlementCommonModel->getAdditionalPropertyDetail($application_no);
            if($checkAdditionalProperty->num_rows() == 0){
                if(isset($output->property)) {
                    foreach($output->property as $value) {
                        $add_property = [
                            'case_no'             => $case_no['case_no'],
                            'dist_code'           => $value->dist_code,
                            'subdiv_code'         => $value->subdiv_code,
                            'cir_code'            => $value->cir_code,
                            'mouza_pargona_code'  => $value->mouza_pargona_code,
                            'lot_no'              => $value->lot_no,
                            'vill_townprt_code'   => $value->vill_townprt_code,
                            'bigha'               => $value->bigha,
                            'katha'               => $value->katha,
                            'lessa'               => $value->lessa,
                            'chatak'              => $value->lessa,
                            'ganda'               => $value->ganda,
                            'kranti'              => $value->kranti,
                            'entry_date'          => date('Y-m-d h:i:s'),
                            'is_rural'            => $value->is_rural,
                            'dag_no'              => $value->dag_no,
                            'patta_no'            => $value->patta_no,
                            'service_id'          => SETTLEMENT_AP_TRANSFER_ID,
                            'applied_flag'        => CITIZEN,
                            'dist_name'           => trim($value->dist_name),
                            'cir_name'            => trim($value->cir_name),
                            'vill_name'           => trim($value->vill_name),
                            'applid'              => $application_no,
                        ];
                        $insAddProperty = $this->db->insert('settlement_additional_property',$add_property);

                        if ($insAddProperty != 1) {
                            log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No '.$application_no. ' and 
                  query is '.$this->db->last_qery());
                            $data = array(
                                'error'=>"#ERROR0004: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT DAG DETAILS
            if(!empty($output->settlements)) {
                foreach($output->settlements as $dag) {
                    if($dag->is_applicant == 1) {

                        $new_land_class = $this->utilityclass->getPattaTypeNo($d,$s,$c,$m,$l,$v,$dag->dag_no);

                        $insSettlementDagDetails = [

                            'dist_code'           => $d,
                            'subdiv_code'         => $s,
                            'cir_code'            => $c,
                            'mouza_pargona_code'  => $m,
                            'lot_no'              => $l,
                            'vill_townprt_code'   => $v,
                            'user_code'           => $this->session->userdata('user_code'),
                            'date_entry'          => date('Y-m-d'),
                            'case_no'             => $case_no['case_no'],
                            'petition_no'         => $case_no['petition_no'],
                            'year_no'             => date('Y'),
                            'operation'           => 'E',
                            'new_land_class_code' => $new_land_class->land_class_code,
                            'dag_no'              => $dag->dag_no,
                            'patta_no'            => $dag->patta_no,
                            'patta_type_code'     => $dag->patta_code,
                            'dag_area_b'          => $dag->applied_bigha,
                            'dag_area_k'          => $dag->applied_katha,
                            'dag_area_lc'         => $dag->applied_lessa,
                            'dag_area_g'          => $dag->applied_ganda,
                            'dag_area_kr'         => $dag->applied_kranti,
                            's_dag_area_b'        => $dag->mbigha,
                            's_dag_area_k'        => $dag->mkatha,
                            's_dag_area_lc'       => $dag->mlessa,
                            's_dag_area_g'        => $dag->mganda,
                            's_dag_area_kr'       => $dag->mkranti,
                            'is_urban'            => $dag->is_rural_urban,
                            'revenue'             => 0,
                            'nr_bigha'            => $dag->mbigha,
                            'nr_katha'            => $dag->mkatha,
                            'nr_lessa'            => $dag->mlessa,
                            'nr_ganda'            => $dag->mganda,
                            'nr_kranti'           => $dag->mkranti,
                            'home_b'              => $dag->mbigha,
                            'home_k'              => $dag->mkatha,
                            'home_lc'             => $dag->mlessa,
                            'home_g'              => $dag->mganda,
                            'home_kr'             => $dag->mkranti,

                            'agri_b'              => 0,
                            'agri_k'              => 0,
                            'agri_lc'             => 0,
                            'agri_g'              => 0,
                            'agri_kr'             => 0,
                        ];
                        $settlement_dag_details = $this->db->insert('settlement_dag_details',$insSettlementDagDetails);

                        if($settlement_dag_details != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0005: Insertion failed in settlement_dag_details for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : ".$application_no);
                            return false;
                        }
                    }
                }
            }

            //insert into SETTLEMENT APPLICANT, main applicant/encrochers details
            if(!empty($output->settlements)) {
                foreach($output->settlements as $appl) {

                    if($appl->dag_no == 0 || $appl->dag_no == null || $appl->dag_no == '') {
                        $dag_no            = 0;
                        $patta_no          = 0;
                        $patta_type_code   = 0;
                    }
                    else {
                        $dag_no            = $appl->dag_no;
                        $patta_no          = $appl->patta_no;
                        $patta_type_code   = $appl->patta_code;
                    }

                    if($appl->is_applicant == 1) { // main applicant, for identity authentication
                        if ($get_aadhaar_photo != 'n') {
                            $timestamp = date('mdYhis', time()).uniqid();
                            $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                            $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $get_aadhaar_photo;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        } else {
                            $aadhar_path = '';
                        }
                        if($output->aadhar->type == 'AADHAAR'){
                            $identity_ref_no = $output->aadhar->aadhaar_no;
                        }else{
                            $identity_ref_no = $output->aadhar->pan_no;
                        }
                        $identity_type     = $output->aadhar->type;
                        $identity_doc_link = $aadhar_path;
                    }
                    else {
                        $identity_ref_no   = '';
                        $identity_type     = '';
                        $identity_doc_link = '';
                    }


                    if (trim($appl->pdar_type) == 'B'){
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }else{
                        $pdar_rel_guar = 0;
                    }

                    //pdar_cron_no
                    $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no['case_no']);

                    if($appl->pdar_type=='O'){
                        $pdarId=$appl->chitha_pdar_id;
                    }else{
                        $pdarId=-1;
                    }

                    $insApplicant = [
                        'dist_code'         => $d,
                        'subdiv_code'       => $s,
                        'cir_code'          => $c,
                        'mouza_pargona_code'=> $m,
                        'lot_no'            => $l,
                        'vill_townprt_code' => $v,
                        'user_code'         => $this->session->userdata('user_code'),
                        'case_no'           => $case_no['case_no'],
                        'petition_no'       => $case_no['petition_no'],
                        'operation'         => 'E',
                        'dag_no'            => $dag_no,
                        'patta_no'          => $patta_no,
                        'patta_type_code'   => $patta_type_code,
                        'year_no'           => date('Y'),
                        'date_entry'        => date('Y-m-d'),
                        'pdar_id'           => $pdarId,
                        'pdar_cron_no'      => $cron_no,
                        'pdar_name'         => $appl->name_ass,
                        'pdar_guardian'     => $appl->gurdian_name_ass,
                        'pdar_rel_guar'     => $pdar_rel_guar,
                        'pdar_gender'       => $appl->gender,
                        'pdar_add1'         => $appl->pre_add,
                        'pdar_add2'         => $appl->per_add,
                        'pdar_mobile'       => $appl->mobile,
                        'pdar_type'         => $appl->pdar_type,
                        'is_applicant'      => $appl->is_applicant,
                        'marital_status'    => $appl->marital_status,
                        'dob'               => $appl->dob,
                        'eng_pdar_name'     => $appl->name_eng,
                        'eng_pdar_guardian' => $appl->gurdian_name_eng,
                        'identity_ref_no'   => $identity_ref_no,
                        'identity_type'     => $identity_type,
                        'identity_doc_link' => $identity_doc_link,
                        'period_possession' => $appl->possession_date,
                    ];
                    $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);
                    if($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : ".$application_no);
                        return false;
                    }
                }
            }

            // insert into settlement_nominee, NEXT OF KIN
            if(!empty($output->nextKin)) {
                foreach($output->nextKin as $nok) {
                    $nominee_data = [
                        'case_no'      => $case_no['case_no'],
                        'nominee_name' => $nok->next_of_kin_name,
                        'address'      => $nok->address,
                        'mobile_no'    => $nok->mobile_no,
                        'relation'     => $nok->relation_with_kin,
                    ];
                    $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                    if($insNominee != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0007: Insertion failed in settlement_nominee for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0007: Registration of Settlement failed for RTPS application no : ".$application_no);
                        return false;
                    }
                }
            }

            //insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree'    => $case_no['case_no'],
                'basundhara'   => $application_no,
                'date_reg'     => date('Y-m-d'),
                'reg_by'       => $this->session->userdata('user_code'),
                'app_status'   => 'M',
                'pending_with' => 'LM',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No '. $application_no. 'and query is '.$this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0008: Registration of Settlement failed for RTPS application no : ".$application_no);
                return false;
            }

            //insert into back up file
            $backup_array = [
                'applid'  => $application_no,
                'case_no' => $case_no['case_no'],
                'status'  => 'I',
                'data'    => $backup
            ];
            $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
            if($backup_insertion != 1){
                $this->db->trans_rollback();
                log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $this->db->trans_commit(); // transaction ends here

        }
        //********************case registration from API end********* */
        //************************************************************************************** */
        ////******* case data fetch from db for Lm start */

        $startTime = microtime(true);
        try{
        
            $district['review_flag'] = false;

            if($review_flag){
                $sql = $this->db->query('select * from settlement_basic where applid = ? and review_flag = ?', array($application_no, $review_flag));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->case_no;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
                $district['review_flag'] = true;

            }else{
                $sql = $this->db->query('SELECT dharitree FROM basundhar_application WHERE basundhara = ?', array($application_no));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->dharitree;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            //get petition no from basundhar_application
            $petition_no = $this->db->select()
                ->where('applid', $application_no)
                ->get('settlement_basic')->row()->petition_no;

            // $this->utilityclass->lmAuthBasic($case_no);

            $this->utilityclass->lmAuthFirstProceedingAp($case_no);

            $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($case_no);
            $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->SettlementKhasModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($case_no);
            $main_applicant = $this->SettlementKhasModel->getMainApplicant($case_no);

            $district['dags_result']  = $this->SettlementApModel->getSettlementDag($case_no);

            $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
            $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $district['premiumData'] = $premiumData;

            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDeclaration");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $basundhara->basundhara,
                'api_key' => API_KEY,
                'token' => $token
            )));
            $output = curl_exec($curl_handle);
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType == 3){
                    echo json_decode($output)->data." - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);

            $output = json_decode($output);
            /// premium end

            $district['app']         = $basic;

            $district['applicants']  = $this->SettlementKhasModel->getAllApplicant($case_no);
            $district['query']       = $output->query;
            $district['document']    = $output->documents;
            $district['encroachers'] = $applicants_encroacher;
            $district['owners']      = $applicants_owners;
            $district['riotee_noks'] = $applicants_riotee_nok;
            $district['property']    = $this->SettlementKhasModel->getAdditionalProperty($case_no);
            $district['settlements'] = $this->SettlementKhasModel->getAllApplicant($case_no);
            $district['nextKin']     = $this->SettlementKhasModel->getAllNomineeDetail($case_no);
            $district['bhumi']       = $this->SettlementKhasModel->getSettlementBasic($case_no);
            $district['aadhar']      = $this->SettlementKhasModel->getMainApplicant($case_no);

            $district['basic']                 = $basic;
            $district['applicants_buyers']     = $applicants_buyers;
            $district['applicants_owners']     = $applicants_owners;
            $district['applicants_encroacher'] = $applicants_encroacher;
            $district['applicants_riotee_nok'] = $applicants_riotee_nok;

            $district['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);
            $district['dags']        = $dags;
            $district['area_details']= $dags;
            $district['lmnotes']     = $lmnotes;
            $district['proceedings'] = $proceedings;

            $district['dhardocuments'] = $dhardocuments;
            $district['case_no']       = $case_no;

            //echo "<pre>"; var_dump($district['dags']);

            $this->db=$this->load->database('db2', TRUE);
            $district['district_all'] = $this->db->query("Select * from district_details")->result();

            $this->dbswitch();

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';
            $district['geo_date'] = $geo_date;

            $additional_property = $this->db->query("Select * from settlement_additional_property 
                where applid='$application_no'");
            if($additional_property->num_rows() > 0){
                $totallesaa=0;
                $totalganda=0;
                foreach($additional_property->result() as $addprop){
                    if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                        $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                        $totalganda = $totalganda+$total_g;
                    }else{
                        $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                        $totallesaa = $totallesaa+$total_l;
                    }
                }
                if(!empty($totallesaa)){
                    $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $district['additional_property']=$additional_property->result();
            }

            foreach($output->selfDeclaration as $selfDec){
                $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }

            $query_for_guar_rel = "select * from master_guard_rel";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();
            if ($row != 0) {
                $district['guar_rel'] = $relation_executation->result();
            }

            // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));
            if($supportive_document_sql == true){
                if($supportive_document_sql->num_rows() > 0){
                    $district['geo_tag_doc'] = $supportive_document_sql->result();
                }else{
                    $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
                }
            }

            ///aadhar photo

            if(isset($applicants_buyers)){
                if($applicants_buyers){
                    foreach($applicants_buyers as $adhar_photo):
                        if($adhar_photo->is_applicant == 1):
                            if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                                $adhar_photo_link = $adhar_photo->identity_doc_link;
                                if(!file_exists($adhar_photo_link))
                                {
                                    $url = API_LINK_MB2."getApplicantPhoto";
                                    $arrayData =array(
                                        'application_no' => $application_no,
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
                                $district['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                            endif;
                        endif;
                    endforeach;
                }
            }

            $applid_vlb = $this->utilityclass->getApplidFromCaseNo($case_no);
            if(isset($dags)){
                foreach($dags as $vlb_dag){
                    $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details 
                    WHERE application_no = ? AND dag_no = ?", array($applid_vlb, $vlb_dag->dag_no));

                    if($sqlvlbcheck->num_rows() > 0){
                        $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
                    }
                    else{
                        $vlb_newly_added[] = false;
                    }
                }
                $district['vlb_newly_added'] = $vlb_newly_added;
            }

            //************check if SK is available*/
            $district['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

            if($district['sk_name'] == 'n')
            {
                //************if SK is not available then load CO */
                $district['sk_availability'] = 'n';

                $district['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            }
            else
            {
                $district['sk_availability'] = 'y';

            }
            $district['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_AP_TRANSFER_ID);

            if($rejected_data == 'n')
            {
                $district['rejected_list'] = false;
            }
            else
            {
                $district['rejected_list'] = $rejected_data;
            }

            $district['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        }
        catch (Exception $e)
        {
            log_message('ERROR#LM_DATA_FETCH', 'Lm application data fetch...####'. $e);
        }
        finally
        {
            $endTime = microtime(true);
            $timeDiff = $endTime - $startTime;

            if($timeDiff > (float)2){
                log_message('EXECUTION_TIME', $this->router->fetch_class().'->'.$this->router->fetch_method().' # The execution time is : '.$timeDiff);
            }
        }


        //echo "<pre>";
        //var_dump($district['applicants']); die;
        $district['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $district['rejected_list']);	

        $land_exceed = 0;
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $district['_view'] = 'SettlementView/SettlementApTransferred';
            $this->load->view('layouts/main',$district);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') { // for updation

            // echo "<pre>"; var_dump($_POST); die;

            // ************* added on 19/09/2023 - new premium validation starts here

            // $application_no=$this->input->post('application_no');
            // $application_no = $this->utilityclass->decryptJwtCase($application_no);

            $sqlCheckExist="Select count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='LM'";
            $dataFound=$this->db->query($sqlCheckExist)->row();
            //echo json_encode($dataFound);
            if($dataFound->c >0)
            {

                $this->session->set_flashdata('error_data', "#ERRC00299: Case Already forwarded to circle office. case no : ".$application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }

            $prem_dist              = $this->input->post('dist_code');
            $mb_land                = 0;
            $prem_dag               = $this->input->post('dag_no');
            // $prem_concession        = $this->input->post('concession'.$prem_dag);
            $prem_concession        = $this->input->post('concession');
            $prem_rate              = $this->input->post('rate'.$prem_dag);
            $prem_rate_type         = $this->input->post('rate_type'.$prem_dag);
            $prem_amount_type       = $this->input->post('amount_type'.$prem_dag);

            $prem_bigha             = $this->input->post('home_b')+$this->input->post('agri_b');
            $prem_katha             = $this->input->post('home_k')+$this->input->post('agri_k');
            $prem_lessa             = $this->input->post('home_lc')+$this->input->post('agri_lc');
            $prem_ganda             = $this->input->post('home_g')+$this->input->post('agri_g');
            $prem_zonal_valuation   = $this->input->post('zonal_valuation_prem'.$prem_dag);

            if(ENABLE_LAND_OWNER_BUTTON == 1)
            {
                $owner_validation = $this->SettlementApModel->validationOfLandOwners($district['settlements']);
                if(isset($owner_validation['responseType']))
                {
                    if($owner_validation['responseType'] == 3)
                    {
                        $this->session->set_flashdata('error_data', $owner_validation['message']);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }

            $this->load->library('form_validation');

            $distCode = trim($this->input->post('dist_code'));
            if($distCode == NULL) {
                redirect(base_url(). 'index.php/SettlementAp/settlementApplication');
            }

            if($application_no == NULL) {
                redirect(base_url(). 'index.php/SettlementAp/settlementApplication');
            }

            $deleted_applicants = $this->input->post('deleted_applicant');
            $deleteAppCon = 0;
            $delApplicants = [];
            if($deleted_applicants != '' or $deleted_applicants != NULL) {
                $deleteAppCon = 1;
                $allSplitApplicants = (explode(",",$deleted_applicants));
                $delApplicants = [];
                foreach ($allSplitApplicants as $mm) {
                    $splitApplicants = (explode("_",$mm));
                    $delApplicants[] = $splitApplicants[0];
                }
            }

            $pno = $this->input->post('patta_no');
            $pc  = $this->input->post('patta_type_code');
            $dag = $this->input->post('dag_no');
            $family_comment_check = $this->input->post('family_comment_check');
            $roadside_comment_check = $this->input->post('roadside_comment_check');
            $appAreaMoreThanDagA = 0;
            $roadsideMoreThanDagA = 0;
            $familyMoreThanDagA = 0;
            $totalRoadSideRev = 0;
            $totalFamilyRev = 0;
            $totalSettlementAreaNotMatchHomeAgri = 0;

            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');

            $validation_bypass = 0;

            if($_POST['lm_note'] == '2')
            {
                if(isset($_POST['rejected_reasons']))
                { 

                    $validation_bypass_array = $this->getValidationBypass(SETTLEMENT_AP_TRANSFER_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    { 

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

            $is_nr_validation = trim($this->input->post('is_nr_settlement'));

            $this->form_validation->set_rules('is_nr_settlement', 'Whether applicant eligible for NR or NR with Settlement', 'trim|required');

            $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required');

            if($applicants_owners)
            {
                foreach($applicants_owners as $settlement_owers)
                {
                    $this->form_validation->set_rules('owners_name'.$settlement_owers->id, 'Owners Name', 'required');
                    $this->form_validation->set_rules('owners_guardian'.$settlement_owers->id, 'Owners Guardian', 'required');
                    $this->form_validation->set_rules('owners_in_place'.$settlement_owers->id, 'Owners In Place', 'required');
                    $this->form_validation->set_rules('owners_mobile_number'.$settlement_owers->id, 'Owners Mobile number', 'required');
                    // $this->form_validation->set_rules('owners_mobile_number'.$settlement_owers->id, 'Owners Mobile number', '');
                }
            }


            if($validation_bypass == 1)
            {

                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }
                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }
                }

                //*******if NR selected then requirecd validation */
                if($is_nr_validation == 'NR')
                {
                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');

                    if(isset($district['applicants']))
                    {
                        foreach($district['applicants'] as $documents_dag)
                        {
                            if($documents_dag->is_applicant == 1)
                            {
                                if (empty($_FILES['trace_map_copy'.$documents_dag->id]['name']))
                                {
                                    $this->form_validation->set_rules('trace_map_copy'.$documents_dag->id, 'Trace map document', 'required');
                                }
                            }
                        }
                    }
                    if (empty($_FILES['field_report']['name']))
                    {
                        $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                    }

                    //****area validation */
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');


                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }


                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if(in_array($setl->id, $delApplicants))
                                {
                                    continue;
                                }
                            }

                        }
                        else
                        {
                            foreach($district['applicants'] as $setl)
                            {

                                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('eng_pdar_name'.$setl->id, 'English Name', 'trim|required|min_length[3]|max_length[70]');

                                $this->form_validation->set_rules('eng_pdar_guardian'.$setl->id, 'Guardian English Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('dob'.$setl->id, 'DOB', 'required|max_length[70]');

                                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');
                            }
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if (in_array($setl->id, $delApplicants)) {
                                    continue;
                                }
                            }

                        }
                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    // if($roadsideMoreThanDagA == 1)
                    // {
                    //     $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area !', 'required|callback_roadsideMoreThanDagA');
                    // }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }
                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }
                    
                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa) {

                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // var_dump($appAreaLessaValidation.'-'.$totalAdditionalProToLessa);die;

                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag)))
                        {
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        else
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }

                    if($_POST['lm_note'] == '1' && $land_exceed == 1)
                    {
                        $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                    }
                }

                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }

                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }

                }

                $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                // $this->form_validation->set_rules('co_code', 'Select SK/Circle Officer', 'trim|required');
                $this->form_validation->set_rules('co_code_reject', 'Select Circle Officer', 'trim|required');

                if (in_array($distCode, json_decode(BARAK_VALLEY))) 
                {
                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');


                    $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                }
                else
                {
                    $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                    $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                }
            }


            if($validation_bypass == 0)
            {

                if($_POST['lm_note'] == '2')
                {
                    $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required');

                    if(isset($_POST['rejected_reasons']))
                    {
                        foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_list)
                        {   
                            $this->form_validation->set_rules('rejected_reasons['.$rej_list_key.']', '', '');
                        }
                    }
                    if(isset($_POST['sub_rejected_reasons']))
                    {
                        foreach($_POST['sub_rejected_reasons'] as $sub_rej_key => $val)
                        {
                            $this->form_validation->set_rules('sub_rejected_reasons['.$sub_rej_key.']', 'Sub Rejected reason', 'required|min_length[1]');
                        }
                    }
                }

                foreach($district['dags'] as $nc_dag)
                {
                    //******NCBTAD check  */
                    $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($nc_dag->dist_code, $nc_dag->subdiv_code, $nc_dag->cir_code, $nc_dag->mouza_pargona_code, $nc_dag->lot_no, $nc_dag->vill_townprt_code, $nc_dag->dag_no);

                    if($ncBtadCheck > 0)
                    {
                        //*******throw error for NCBTAD */
                        log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                        $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                } 

                //*******if NR selected then requirecd validation */
                if($is_nr_validation == 'NR')
                {
                    //****area validation */
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');


                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }


                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if(in_array($setl->id, $delApplicants))
                                {
                                    continue;
                                }
                            }

                        }
                        else
                        {
                            foreach($district['applicants'] as $setl)
                            {

                                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('eng_pdar_name'.$setl->id, 'English Name', 'trim|required|min_length[3]|max_length[70]');

                                $this->form_validation->set_rules('eng_pdar_guardian'.$setl->id, 'Guardian English Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('dob'.$setl->id, 'DOB', 'required|max_length[70]');

                                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');

                            }
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if (in_array($setl->id, $delApplicants)) {
                                    continue;
                                }
                            }

                        }
                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    // if($roadsideMoreThanDagA == 1)
                    // {
                    //     $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area !', 'required|callback_roadsideMoreThanDagA');
                    // }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }
                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }
					
					// new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa) {

                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // var_dump($appAreaLessaValidation.'-'.$totalAdditionalProToLessa);die;

                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                         // new premium addition
                         if(!empty($this->input->post('area_new'.$prem_dag)))
                         {
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        else
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }

                    if($_POST['lm_note'] == '1' && $land_exceed == 1)
                    {
                        $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                    }


                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');

                    if(isset($district['applicants']))
                    {
                        foreach($district['applicants'] as $documents_dag)
                        {
                            if($documents_dag->is_applicant == 1)
                            {
                                if (empty($_FILES['trace_map_copy'.$documents_dag->id]['name']))
                                {
                                    $this->form_validation->set_rules('trace_map_copy'.$documents_dag->id, 'Trace map document', 'required');
                                }
                            }
                        }
                    }
                    if (empty($_FILES['field_report']['name']))
                    {
                        $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                    }

                    $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|greater_than[-1]');
                    if($_POST['lm_note'] != '2')
                    {
                        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                    }

                    $this->form_validation->set_rules('lm_remark_additional', 'LM NR Remarks (Text Area)', 'trim|required');
                    $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                    $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                }
                else
                {
                    if($this->input->post('is_nr_settlement') == 'NR with Settlement')
                    {
                        if($prem_rate == '' || $prem_rate == null) 
                        {
                            log_message('error', "#ERR4539: Rate field is empty. Premium calculation no done for case no ".$case_no);
                            $this->session->set_flashdata('error_data', "#ERR4539: Premium calculation is required for case no ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                        else if($prem_amount_type == '' || $prem_amount_type == null) 
                        {
                            log_message('error', "#ERR4539: Amount field is empty. Premium calculation no done for case no ".$case_no);
                            $this->session->set_flashdata('error_data', "#ERR4539: Premium calculation is required for case no ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                        else if($this->input->post('area_cat_new'.$prem_dag) == '' || $this->input->post('area_cat_new'.$prem_dag) == null) 
                        {
                            log_message('error', "#ERR4553: Dag area is not flagged in chitha for case no ".$case_no);
                            $this->session->set_flashdata('error_data', "#ERR4553: Dag area is not flagged in chitha for case no ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }

                    $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|greater_than[-1]');
                    if($_POST['lm_note'] != '2')
                    {
                        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');
                    }

                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');

                    if(isset($district['applicants']))
                    {
                        foreach($district['applicants'] as $documents_dag)
                        {
                            if($documents_dag->is_applicant == 1)
                            {
                                if (empty($_FILES['trace_map_copy'.$documents_dag->id]['name']))
                                {
                                    $this->form_validation->set_rules('trace_map_copy'.$documents_dag->id, 'Trace map document', 'required');
                                }
                            }
                        }
                    }

                    if (empty($_FILES['field_report']['name']))
                    {
                        $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                    }

                    $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|greater_than[-1]');

                    //******Geo tag validation */
                    $geo_tag_dags = array();
                    foreach($district['dags'] as $geo_tag)
                    {
                        $geo_tag_dags[] = $geo_tag->dag_no;

                        //******NCBTAD check  */
                        $ncBtadCheck = $this->SettlementCommonModel->ncBtadCheck($geo_tag->dist_code, $geo_tag->subdiv_code, $geo_tag->cir_code, $geo_tag->mouza_pargona_code, $geo_tag->lot_no, $geo_tag->vill_townprt_code, $geo_tag->dag_no);

                        if($ncBtadCheck > 0)
                        {
                            //*******throw error for NCBTAD */
                            log_message('error', '#ERR1674: This village is mapped as NCBTAD! '.$case_no);
                            $this->session->set_flashdata('message', "#ERR1674: This village is mapped as NCBTAD! ".$case_no);
                            redirect(base_url() . "index.php/home");
                        }
                    }

                    $geo_tag_dags_array = "'" . implode ( "','", $geo_tag_dags ) . "'";

                    $get_tag_dag_count = $this->db->query("select count(t.applid) from (select distinct on (applid, dag_no) applid, dag_no from supportive_document where applid= ? AND file_name = ? and dag_no in ($geo_tag_dags_array)) t", array($application_no, GEO_TAG_PHOTO))->row()->count;

                    $total_dag_count = count($district['dags']);

                    if((int)$get_tag_dag_count != (int)$total_dag_count)
                    {
                        if(GEO_TAG_ACTIVE_STATUS == 1){
                            $this->form_validation->set_rules('geo_tag_photo', 'Geo tag photo', 'required');
                        }
                    }

                    $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
                    $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
                    $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
                    $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');

                    $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
                    $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
                    $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
                    $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
                    $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
                    $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
                    $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
                    $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
                    $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
                    $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

                    $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required');
                    $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
                    $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
                    $this->form_validation->set_rules('is_tribal_belt', 'Land falls under Tribal Belt', 'trim|required');
                    $this->form_validation->set_rules('protected_class_lm', 'Does applicant falls under protected category', 'trim|required|is_natural');
                    $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide prone ?', 'trim|required');
                    $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
                    $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
                    $this->form_validation->set_rules('is_landless', 'Whether applicant is landless', 'trim|required');
                    $this->form_validation->set_rules('litigation', 'Whether proposed land is under litigation', 'trim|required');
                    $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('falls_und_gmc', 'land falls within 15 KM radius from the periphery of GMC  ', 'trim|required');
                    $this->form_validation->set_rules('roadside_comment_check', 'roadside /riverside reservation  ', 'trim|required');
                    $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');

                    $this->form_validation->set_rules('is_nr_settlement', 'Whether applicant eligible for NR or NR with Settlement', 'trim|required');
                    $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|greater_than[-1]');

                    $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
                    $this->form_validation->set_rules('lm_remark_additional', 'LM NR Remarks (Text Area)', 'trim|required');
                    $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

                    $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
                    $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

                    $this->form_validation->set_rules('dag_no', 'Dag Number', 'trim|required|is_natural');
                    $this->form_validation->set_rules('patta_no', 'Patta Number', 'trim|required');
                    $this->form_validation->set_rules('patta_type_code', 'Patta Type Code', 'trim|required|is_natural');

                    $this->form_validation->set_rules('roadside_reservation','','');

                    $this->form_validation->set_rules('validationcheck', 'Premium Calculation', 'trim|required');
                    $this->form_validation->set_rules('totaldue', 'Premium Amount', 'trim|required');

                    $this->form_validation->set_rules('gramdan_bhudan', 'Land falls category', 'required');
                    $this->form_validation->set_rules('eksona_transfered', 'Is Eksona Land Transfered?', 'required');

                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');


                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_ganda', 'Deed/Agreement ganda area', 'trim|required|numeric|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_kranti', 'Deed/Agreement kranti area', 'trim|required|numeric|greater_than[-1]|xss_clean');


                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_g', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('home_kr', 'Total applied Area Home (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_g', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                        $this->form_validation->set_rules('agri_kr', 'Total applied Area Agriculture (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
                        $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
                        $gandaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 6400) + ($kathaValidationApp * 320) + ($lessaValidationApp * 20) + $gandaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }


                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);
                        $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_g'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);
                        $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_g'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if(in_array($setl->id, $delApplicants))
                                {
                                    continue;
                                }
                            }

                        }
                        else
                        {
                            foreach($district['applicants'] as $setl)
                            {

                                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('eng_pdar_name'.$setl->id, 'English Name', 'trim|required|min_length[3]|max_length[70]');

                                $this->form_validation->set_rules('eng_pdar_guardian'.$setl->id, 'Guardian English Name', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('dob'.$setl->id, 'DOB', 'required|max_length[70]');

                                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');
                            }
                        }

                        if($roadside_comment_check=='YES')
                        {
                            foreach($district['dags_result'] as $roadSS)
                            {
                                $this->form_validation->set_rules('reserved_dag_road'.$roadSS->dag_no, 'Reserved Roadside Dag No', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_patta_road'.$roadSS->dag_no, 'Reserved Roadside Patta', 'trim|required|is_natural|greater_than[-1]|xss_clean');

                                $this->form_validation->set_rules('reserved_bigha'.$roadSS->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$roadSS->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$roadSS->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
                                $this->form_validation->set_rules('reserved_ganda'.$roadSS->dag_no, 'Reserved Roadside Ganda', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
                                $this->form_validation->set_rules('reserved_kranti'.$roadSS->dag_no, 'Reserved Roadside Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$roadSS->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$roadSS->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$roadSS->dag_no), 0);
                                $gandaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$roadSS->dag_no), 0);

                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 6400) + ($kathaValidationRoad * 320) + ($lessaValidationRoad * 20) + $gandaValidationRoad;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;
                            }
                        }  
                    }
                    else
                    {
                        $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('nr_bigha', 'Deed/Agreement bigha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_katha', 'Deed/Agreement katha area', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('nr_lessa', 'Deed/Agreement lessa area', 'trim|required|numeric|greater_than[-1]|xss_clean');

                        $this->form_validation->set_rules('home_b', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('home_k', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('home_lc', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('agri_b', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                        $this->form_validation->set_rules('agri_k', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                        $this->form_validation->set_rules('agri_lc', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                        $this->form_validation->set_rules('landmark_east', 'East Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_west', 'West Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_north', 'North Landmark', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('landmark_south', 'South Landmark', 'trim|required|xss_clean');

                        $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
                        $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
                        $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

                        $bighaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
                        $kathaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
                        $lessaValidationApp = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

                        $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                        $appAreaLessaValidation = ($bighaValidationApp * 100) + ($kathaValidationApp * 20) + $lessaValidationApp;

                        if($dagAreaLessaValidation < $appAreaLessaValidation)
                        {
                            $appAreaMoreThanDagA = 1;
                        }

                        // new code 21/07/2023 Masud Reza
                        $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_b'), 0);
                        $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_k'), 0);
                        $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('home_lc'), 0);

                        $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_b'), 0);
                        $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_k'), 0);
                        $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lc'), 0);

                        $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                        $agriAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                        if($appAreaLessaValidation != $homeAreaLessaValidation + $agriAreaLessaValidation)
                        {
                            $totalSettlementAreaNotMatchHomeAgri = 1;
                        }

                        if($deleteAppCon == 1)
                        {
                            foreach($district['applicants'] as $setl)
                            {
                                if (in_array($setl->id, $delApplicants)) {
                                    continue;
                                }
                            }

                        }
                        
                        if($roadside_comment_check=='YES')
                        {
                            foreach($district['dags_result'] as $roadSS)
                            {
                                $this->form_validation->set_rules('reserved_dag_road'.$roadSS->dag_no, 'Reserved Roadside Dag No', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_patta_road'.$roadSS->dag_no, 'Reserved Roadside Patta', 'trim|required|is_natural|greater_than[-1]|xss_clean');

                                $this->form_validation->set_rules('reserved_bigha'.$roadSS->dag_no, 'Reserved Roadside Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                                $this->form_validation->set_rules('reserved_katha'.$roadSS->dag_no, 'Reserved Roadside Katha', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
                                $this->form_validation->set_rules('reserved_lessa'.$roadSS->dag_no, 'Reserved Roadside Lessa', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');

                                $bighaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$roadSS->dag_no), 0);
                                $kathaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$roadSS->dag_no), 0);
                                $lessaValidationRoad = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$roadSS->dag_no), 0);


                                $dagAreaLessaValidationRoad = ($bighaValidationRoad * 100) + ($kathaValidationRoad * 20) + $lessaValidationRoad ;

                                if($appAreaLessaValidation < $dagAreaLessaValidationRoad)
                                {
                                    $roadsideMoreThanDagA = 1;
                                }
                                $totalRoadSideRev += $dagAreaLessaValidationRoad;
                            }
                        }

                    }

                    $rr = $homeAreaLessaValidation + $agriAreaLessaValidation;
                    $kk = $totalRoadSideRev + $totalFamilyRev;

                    if($rr == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($rr - $kk == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total Settlement area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaLessaValidation == 0)
                    {
                        $this->form_validation->set_rules('appAreaLessaValidation','Total applied area should not be Zero !', 'required|callback_appAreaLessaValidation');
                    }
                    if($appAreaMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('appAreaMoreThanDagA','Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
                    }
                    if($roadsideMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('roadsideMoreThanDagA','Total roadside reserved area should not be more than total applied area !', 'required|callback_roadsideMoreThanDagA');
                    }
                    if($familyMoreThanDagA == 1)
                    {
                        $this->form_validation->set_rules('familyMoreThanDagA','Total family reserved area should not be more than total applied area !', 'required|callback_familyMoreThanDagA');
                    }
                    if($appAreaLessaValidation <  $totalRoadSideRev + $totalFamilyRev)
                    {
                        $this->form_validation->set_rules('reserveAreaCheck','Total reserved area should not be more than total applied area !', 'required|callback_reserveAreaCheck');
                    }
                    if($totalSettlementAreaNotMatchHomeAgri == 1)
                    {
                        $this->form_validation->set_rules('totalSettlementAreaNotMatchHomeAgri','Total settlement area not match with Homestead and Agriculture area !', 'required|callback_totalSettlementAreaNotMatchHomeAgri');
                    }

                    // new additional property calculation
                    $additional_properties = $district['additional_property']= $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
                    $singleAdditionalProToLessa = 0;
                    $totalAdditionalProToLessa = 0;
                    $checkUrbanCon = trim($this->input->post('is_urban'));
                    if(in_array($distCode, json_decode(BARAK_VALLEY)))
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);
                            $gandaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->ganda, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // BARAK_VALLEY
                        if(MAX_APPLIED_ADDITIONAL_AREA * 6400 < $appAreaLessaValidation + $totalAdditionalProToLessa) {

                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                        // new premium addition
                        if(!empty($this->input->post('area_new'.$prem_dag))){
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                // if ($maxland_check->max_land < ($totalAgrAreaLessaValidation + $totalHomeAreaLessaValidation)) {
                                //     $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                //     $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                // }
                                if($maxland_check->max_land =='40'){
                                    $maxland_ganda = 2560;
                                }elseif($maxland_check->max_land =='60'){
                                    $maxland_ganda = 3840;
                                }

                                if ($maxland_ganda < ($appAreaLessaValidation -  $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_ganda . 'Gonda !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_BARAK_KATHA * 320) + (MAX_APPLIED_URBAN_AREA_BARAK_LESSA * 20) < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_BARAK_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_BARAK_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }
                    else
                    {
                        foreach ($additional_properties as $singleProperty)
                        {
                            $bighaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->bigha, 0);
                            $kathaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->katha, 0);
                            $lessaAdditionalPro = $this->UtilsModel->defaultValue($singleProperty->lessa, 0);

                            $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro ;
                            $totalAdditionalProToLessa += $singleAdditionalProToLessa;
                        }

                        // var_dump($appAreaLessaValidation.'-'.$totalAdditionalProToLessa);die;

                        if(MAX_APPLIED_ADDITIONAL_AREA * 100 < $appAreaLessaValidation + $totalAdditionalProToLessa)
                        {
                            // $this->form_validation->set_rules('totalAppliedAdditionalArea','Total Land Area (Applied Area + Additional Area)  cannot exceed  more than '. MAX_APPLIED_ADDITIONAL_AREA . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
                            $land_exceed =1;
                        }

                         // new premium addition
                         if(!empty($this->input->post('area_new'.$prem_dag)))
                         {
                            $maxland_check = $this->SettlementCommonModel->checkMaxAreaAllowed($this->input->post('area_new'.$prem_dag));
                            if(!empty($maxland_check->max_land)){

                                if ($maxland_check->max_land < ($appAreaLessaValidation - $totalRoadSideRev)) {
                                    $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Total Applied Area cannot exceed  more than ' .
                                    $maxland_check->max_land . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                                }

                            }

                        }
                        else
                        {
                            $this->form_validation->set_rules('totalAppliedAreaInUrban', 'Area type missing!! ', 'required|callback_totalAppliedAreaInUrban');
                        }

                        // if($checkUrbanCon == 'Y')
                        // {
                        //     if((MAX_APPLIED_URBAN_AREA_KATHA * 20) + MAX_APPLIED_URBAN_AREA_LESSA < $appAreaLessaValidation - $totalRoadSideRev)
                        //     {
                        //         $this->form_validation->set_rules('totalAppliedAreaInUrban','Total Applied Area in Urban cannot exceed  more than '.
                        //             MAX_APPLIED_URBAN_AREA_KATHA . 'Katha ,' . MAX_APPLIED_URBAN_AREA_LESSA . 'Lessa !', 'required|callback_totalAppliedAreaInUrban');
                        //     }
                        // }
                    }

                    if($_POST['lm_note'] == '1' && $land_exceed == 1)
                    {
                        $this->form_validation->set_rules('land_exceed','Warning : Total Land Area (Applied Area + Additional Area) exceed  more than '. (MAX_APPLIED_ADDITIONAL_AREA) . ' Bigha ! You can select not recommend and proceed!!!', 'required|callback_land_exceed');
                    }

                    if(isset($_FILES['fileUpload']['name']))
                    {
                        $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                        $fileCount = count($_FILES['fileUpload']['name']);
                        // validation for file type and file size

                        for($i = 0; $i < $fileCount; $i++)
                        {
                            if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){

                                $name = $_FILES['fileUpload']['name'][$i];
                                $size = $_FILES['fileUpload']['size'][$i];

                                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                                $exp  = explode("/",$mime);
                                $ext  = $exp[1];

                                if($name != NULL)
                                {
                                    if($ext == NULL)
                                    {
                                        // todo error show extension missing
                                        $this->form_validation->set_rules('additional_doc_err','File extension','required');

                                    }
                                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                    {
                                        // todo error show file allow type not match
                                        $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                                    }
                                    if($size > UPLOAD_MAX_SIZE)
                                    {
                                        // todo error show file size
                                        $this->form_validation->set_rules('additional_doc_err','Maximum 2MB file size','required');
                                    }
                                }
                                else
                                {
                                    // todo error show file not nullable
                                    $this->form_validation->set_rules('additional_doc_err','File name','required');
                                }
                            }
                            else{
                                $this->form_validation->set_rules('additional_doc_err','File','required');
                            }
                        }
                    }

                    if(isset($district['applicants'])){
                        foreach($district['applicants'] as $documents_dag){
                            if($documents_dag->is_applicant == 1){
                                if (empty($_FILES['trace_map_copy'.$documents_dag->id]['name']))
                                {
                                    $this->form_validation->set_rules('trace_map_copy'.$documents_dag->id, 'Trace map document', 'required');
                                }
                            }
                        }
                    }

                    if(isset($district['applicants'])){
                        foreach($district['applicants'] as $documents_dag){
                            if($documents_dag->is_applicant == 1){
                                if (empty($_FILES['chitha_copy'.$documents_dag->id]['name']))
                                {
                                    $this->form_validation->set_rules('chitha_copy'.$documents_dag->id, 'Trace map document', 'required');
                                }
                            }
                        }
                    }

                    if (empty($_FILES['field_report']['name']))
                    {
                        $this->form_validation->set_rules('field_report', 'Field report document', 'required');
                    }
                }
            }

            if ($this->form_validation->run() == FALSE)
            {
                $district['all_errors'] = validation_errors();
                $district['err_return'] = true;
                if(isset($fileCount)){
                    $district['fileCount'] = $fileCount;
                }
                $district['_view'] = 'SettlementView/SettlementApTransferred';
                $this->load->view('layouts/main',$district);
            }
            else
            {
                $this->db->trans_begin();
                // upload additional file
                if(isset($_FILES['fileUpload']['name'])){
                    for($i = 0; $i < $fileCount; $i++)
                    {
                        $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];

                        $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                        $exp  = explode("/",$mime);
                        $onlyExtension  = $exp[1];

                        $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                        $config['upload_path']   = UPLOAD_DIR;
                        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                        $config['max_size']  = UPLOAD_MAX_SIZE;;
                        $config['file_name'] = $fileRename;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('file'))
                        {
                            $document= array(
                                'case_no'   => $case_no,
                                'file_name' => $_POST['fileText'][$i],
                                'user_code' => $this->session->userdata('user_code'),
                                // 'fetch_file_name' => $_FILES['file']['name'],
                                'fetch_file_name' => $_POST['fileText'][$i],
                                'file_type'  => $_FILES['file']['type'],
                                'file_path'  => UPLOAD_DIR . $fileRename,
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type'   => SETTLEMENT_AP_TRANSFER_ID,
                            );

                            // save data in attachment file
                            $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                            if($addMoreDocQuery != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

                                $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                        }
                        else
                        {
                            $this->db->trans_rollback();
                            // todo error show
                            // redirect to respected route with error mgs
                            log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$application_no);

                            $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$application_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                }
                //end of additional file upload

                $pro_class = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');

                // NR done check in old case no
                $nr_update_yn =null;
                if($review_flag){
                    $sql21 = $this->db->query('select nr_update_yn from settlement_basic where applid = ? and review_flag = ?', array($application_no, 0));
    
                    if($sql21->num_rows() > 0){
                        $nr_update_yn = $sql21->row()->nr_update_yn;
                    }
                    else{
                        $data = array(
                            'error' => 'Something went wrong! please contact administration!' .$application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
    
                }
                // End NR done check in old case no

                $sk_code = null;
                $co_code = null;
                $status = 'W';
                if(trim($district['sk_availability']) == 'yyyyyyy') // As discuussed sk not required so y replaced by yyyyyyy
                {
                    $pending_officer = 'SK';
                    $sk_code = $this->input->post('co_code');
                }
                else
                {
                    $pending_officer = 'CO';
                    $co_code = $this->input->post('co_code');
                }
                if($validation_bypass == 1)
                {
                    $pending_officer = 'CO';
                    $co_code = $this->input->post('co_code_reject');
                }

                if($nr_update_yn == 'Y')
                {
                    $co_code = $this->input->post('co_code');
                    $basic = [
                        'status'          => 'Y',
                        'lm_code'         => $this->session->userdata('user_code'),
                        'submission_date' => date('Y-m-d G:i:s'),
                        'from_office'     => 'DC',
                        'pending_officer' => 'CO',
                        'pending_office'  => 'CO',
                        'sk_code'         => $sk_code,
                        'co_code'         => $co_code,
                        'approve_by'      => $this->input->post('approval'.$prem_dag),
                        'nr_update_yn'    => 'Y',
                        'notice_generated_yn' => 'Y'
                    ];
                    
                }
                else
                {
                    $basic = [
                        'status'          => 'W',
                        'lm_code'         => $this->session->userdata('user_code'),
                        'submission_date' => date('Y-m-d G:i:s'),
                        'from_office'     => 'LM',
                        'pending_officer' => $pending_officer,
                        'pending_office'  => $pending_officer,
                        'sk_code'         => $sk_code,
                        'co_code'         => $co_code,
                        'approve_by'      => $this->input->post('approval'.$prem_dag)
                    ];

                }

                

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basic);

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = '$application_no' AND from_office = 'LM'")->row()->ct;
                $phase_count = (int)$phase_count+1;
                $backup_array_lm = [
                    'applid' => $application_no,
                    'case_no' => $case_no,
                    'from_office' => 'LM',
                    'to_office' => $pending_officer,
                    'status' => 'W',
                    'phase' => 'LM_'.$phase_count,
                    'data' => json_encode($_POST)
                ];
                $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);

                if($backup_insertion_lm != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP0032: Insertion failed in settlement_backup_json RTPS Case No '.$case_no);

                    $this->session->set_flashdata('error_data', "#BACKUP0032: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                //update additional property
                $additional_property_check = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");

                if($additional_property_check->num_rows() > 0){
                    $additionalPropertyUpdate = [
                        'case_no' => $case_no,
                    ];
                    $this->db->where('applid', $application_no);
                    $this->db->update('settlement_additional_property', $additionalPropertyUpdate);
                    if($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR4511: Updation failed in settlement_additional_property RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERROR4511: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // UPDATING Geo Tag Photo case number in supportive document
                if(isset($district['geo_tag_doc'])){
                    foreach($district['geo_tag_doc'] as $geo_tag_loop){
                        $geo_tag_array = array(
                            'case_no' => $case_no
                        );
                        $this->db->where('applid', $geo_tag_loop->applid);
                        $this->db->where('dag_no', $geo_tag_loop->dag_no);
                        $this->db->where('file_name', GEO_TAG_PHOTO);
                        $this->db->update('supportive_document', $geo_tag_array);

                        if($this->db->affected_rows() == 0 ){
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                            $data = array(
                                'error'=>"#SETUP0001S: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                // ************* added on 19/09/2023 - new premium validation ends here

                //******insertion in settlement_dag_details common insertion */
                if($is_nr_validation !='NR')
                {
                    $landmark_east = $this->input->post('landmark_east');
                    $landmark_west = $this->input->post('landmark_west');
                    $landmark_north = $this->input->post('landmark_north');
                    $landmark_south = $this->input->post('landmark_south');

                    $landmark = [
                        'east' => $landmark_east,
                        'west' => $landmark_west,
                        'north' => $landmark_north,
                        'south' => $landmark_south,
                    ];

                    ////settlement_dag_details update start
                    $fmd= [
                    
                        'landmark'   => json_encode($landmark),
                    ];
                }
                $fmd['date_entry']=date('Y-m-d');
                $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
                $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
                $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
                $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
                $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');

                $fmd['home_b']=$this->input->post('home_b');
                $fmd['home_k']=$this->input->post('home_k');
                $fmd['home_lc']=$this->input->post('home_lc');
                $fmd['home_g']=$this->input->post('home_g');
                $fmd['home_kr']=$this->input->post('home_kr');

                $fmd['agri_b']=$this->input->post('agri_b');
                $fmd['agri_k']=$this->input->post('agri_k');
                $fmd['agri_lc']=$this->input->post('agri_lc');
                $fmd['agri_g']=$this->input->post('agri_g');
                $fmd['agri_kr']=$this->input->post('agri_kr');

                $fmd['nr_bigha']=$this->input->post('nr_bigha');
                $fmd['nr_katha']=$this->input->post('nr_katha');
                $fmd['nr_lessa']=$this->input->post('nr_lessa');
                $fmd['nr_ganda']=$this->input->post('nr_ganda');
                $fmd['nr_kranti']=$this->input->post('nr_kranti');

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_dag_details', $fmd);

                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                ////settlement_dag_details update end

                ////upadte settlement_applicant owners
                if($applicants_owners == true){
                    foreach($applicants_owners as $ownersApplicant){
                        $owners_data_update=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'date_update' => date('Y-m-d G:i:s'),
                            'inplace_alongwith' => $this->input->post('owners_in_place'.$ownersApplicant->id),
                        );

                        $this->db->where('id', $ownersApplicant->id);
                        $this->db->update('settlement_applicant', $owners_data_update);
                        //   echo $this->db->last_query();

                        if($this->db->affected_rows() == 0 ){
                            $this->db->trans_rollback();
                            log_message('error', '#SETUP000409: Updation failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#SETUP000409: Registration of Settlement failed for RTPS case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                if($validation_bypass == 1)
                {
                    //*****insert LM note and rejected reason only*/
                    $this->SettlementCommonModel->firstProceedingValidationBypassTrue(
                            SETTLEMENT_AP_TRANSFER_ID,
                            $case_no,
                            $application_no,
                            $district['rejected_list']
                        );

                }

                if($validation_bypass == 0)
                {
                    ////settlement_applicant insert start
                    $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no."'";
                    $result = $this->db->query($sql);
                    if($result->num_rows() > 0)
                    {
                        $cron_no = (int)$result->row()->pdar_cron_no + 1;
                    }
                    else
                    {
                        $cron_no = 1;
                    }

                    //// API applicant add
                    foreach($district['applicants'] as $setl)
                    {
                        if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
                        {
                            $chitha_pdar_id=-1;
                        }else{
                            $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
                        }
                        if(in_array($setl->id, $delApplicants))
                        {
                            continue;
                        }
                        else {
                            if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1') {
                                $timestamp = date('mdYhis', time()).uniqid();
                                $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                                // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                                $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                                $aadhaar_encoded_file = $get_aadhaar_photo;
                                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                fclose($aadhaar_file_to_write_base64);
                            } else {
                                $aadhar_path = '';
                            }
                        }
                    }

                    $petition_no = $petition_no;
                    $case_no = $case_no;

                    $comment = addslashes($this->input->post('lm_note'));

                    //*********if LM if case of case rejected the rejected remarks */
                    if($is_nr_validation == 'NR')
                    {
                        // For uploading dag wise trace_map_copy
                        foreach($district['applicants'] as $dags_doc)
                        {
                            if($dags_doc->is_applicant == 1){

                                $timestamp = date('mdYhis', time()).uniqid();
                                // Trace Map copy upload
                                $config['file_name']            = 'trace_map_copy'.$timestamp;
                                $config['upload_path']          = UPLOAD_DIR;
                                $config['allowed_types']        = UPLOAD_ALLOW_TYPE;
                                $config['max_size']             = 2000;

                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);

                                if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                                {
                                    $error = array('error' => $this->upload->display_errors());
                                    echo json_encode($error);
                                    return false;
                                }
                                else
                                {
                                    $data = array('upload_data' => $this->upload->data());
                                    $document= array(
                                        'case_no' => $case_no,
                                        'file_name' => 'Trace Map Copy',
                                        'user_code' => $this->session->userdata('user_code'),
                                        'fetch_file_name' => $data['upload_data']['orig_name'],
                                        'file_type' => $data['upload_data']['file_type'],
                                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                        'date_entry' => date('Y-m-d h:i:s'),
                                        'mut_type' => $this->input->post('service_code'),
                                        'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                                    );

                                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                                    if($insert_supportive_doc != 1){
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                                        $json = [
                                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                                        ];
                                        echo json_encode($json);
                                        return false;
                                    }
                                }
                            }
                        }

                        // For uploading field report
                        $timestamp = date('mdYhis', time()).uniqid();
                        $config2['file_name']            = 'field_report'.$timestamp;
                        $config2['upload_path']          = UPLOAD_DIR;
                        $config2['allowed_types']        = UPLOAD_ALLOW_TYPE;
                        $config2['max_size']             = 2000;

                        $this->upload->initialize($config2);

                        if ( ! $this->upload->do_upload('field_report'))
                        {
                            $error = array('error' => $this->upload->display_errors());

                            var_dump($error);
                            die;
                        }
                        else
                        {
                            $data = array('upload_data' => $this->upload->data());
                            $document= array(
                                'case_no' => $case_no,
                                'file_name' => 'Field Report',
                                'user_code' => $this->session->userdata('user_code'),
                                'fetch_file_name' => $data['upload_data']['orig_name'],
                                'file_type' => $data['upload_data']['file_type'],
                                'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type' => $this->input->post('service_code'),
                            );

                            $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                            if($insert_supportive_doc != 1){
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                                $json = [
                                    'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                                ];
                                echo json_encode($json);
                                return false;
                            }
                        }

                        //******settlement_ap_lmnote  */
                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                            'lm_rejected_remarks' => null,

                        );


                    }
                    else
                    {
                        // For uploading dag wise trace_map_copy
                        foreach($district['applicants'] as $dags_doc)
                        {
                            if($dags_doc->is_applicant == 1){

                                $timestamp = date('mdYhis', time()).uniqid();
                                // Trace Map copy upload
                                $config['file_name']            = 'trace_map_copy'.$timestamp;
                                $config['upload_path']          = UPLOAD_DIR;
                                $config['allowed_types']        = UPLOAD_ALLOW_TYPE;
                                $config['max_size']             = 2000;

                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);

                                if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                                {
                                    $error = array('error' => $this->upload->display_errors());
                                    echo json_encode($error);
                                    return false;
                                }
                                else
                                {
                                    $data = array('upload_data' => $this->upload->data());
                                    $document= array(
                                        'case_no' => $case_no,
                                        'file_name' => 'Trace Map Copy',
                                        'user_code' => $this->session->userdata('user_code'),
                                        'fetch_file_name' => $data['upload_data']['orig_name'],
                                        'file_type' => $data['upload_data']['file_type'],
                                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                                        'date_entry' => date('Y-m-d h:i:s'),
                                        'mut_type' => $this->input->post('service_code'),
                                        'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                                    );

                                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                                    if($insert_supportive_doc != 1){
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                                        $json = [
                                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                                        ];
                                        echo json_encode($json);
                                        return false;
                                    }
                                }
                            }
                        }

                        // For uploading field report
                        $timestamp = date('mdYhis', time()).uniqid();
                        $config2['file_name']            = 'field_report'.$timestamp;
                        $config2['upload_path']          = UPLOAD_DIR;
                        $config2['allowed_types']        = UPLOAD_ALLOW_TYPE;
                        $config2['max_size']             = 2000;

                        $this->upload->initialize($config2);

                        if ( ! $this->upload->do_upload('field_report'))
                        {
                            $error = array('error' => $this->upload->display_errors());

                            var_dump($error);
                            die;
                        }
                        else
                        {
                            $data = array('upload_data' => $this->upload->data());
                            $document= array(
                                'case_no' => $case_no,
                                'file_name' => 'Field Report',
                                'user_code' => $this->session->userdata('user_code'),
                                'fetch_file_name' => $data['upload_data']['orig_name'],
                                'file_type' => $data['upload_data']['file_type'],
                                'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type' => $this->input->post('service_code'),
                            );

                            $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                            if($insert_supportive_doc != 1){
                                $this->db->trans_rollback();
                                log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                                $json = [
                                    'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                                ];
                                echo json_encode($json);
                                return false;
                            }
                        }

                        // For uploading dag wise chitha copy
                        foreach($district['applicants'] as $dags_doc)
                        {
                            if($dags_doc->is_applicant == 1){

                                $timestamp = date('mdYhis', time()).uniqid();
                                // Trace Map copy upload
                                $config3['file_name']            = 'chitha_copy'.$timestamp;
                                $config3['upload_path']          = UPLOAD_DIR;
                                $config3['allowed_types']        = UPLOAD_ALLOW_TYPE;
                                $config3['max_size']             = 2000;

                                $this->upload->initialize($config3);

                                if ( ! $this->upload->do_upload('chitha_copy'.$dags_doc->id))
                                {
                                    $error = array('error' => $this->upload->display_errors());
                                    echo json_encode($error);
                                    return false;
                                }
                                else
                                {
                                    $data = array('upload_data' => $this->upload->data());
                                    $document= array(
                                        'case_no' => $case_no,
                                        'file_name' => CHITHA_COPY,
                                        'user_code' => $this->session->userdata('user_code'),
                                        'fetch_file_name' => $data['upload_data']['orig_name'],
                                        'file_type' => $data['upload_data']['file_type'],
                                        'file_path' => $config3['upload_path'].$data['upload_data']['orig_name'],
                                        'date_entry' => date('Y-m-d h:i:s'),
                                        'mut_type' => $this->input->post('service_code'),
                                        'dag_no' => $this->input->post('dag_no_chitha'.$dags_doc->id)
                                    );

                                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                                    if($insert_supportive_doc != 1){
                                        $this->db->trans_rollback();
                                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                                        $json = [
                                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                                        ];
                                        echo json_encode($json);
                                        return false;
                                    }
                                }
                            }
                        }

                        $pro_class_lm = $this->input->post('protected_class_lm');
                        $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

                        $lmnote=array(
                            'user_code'=>$this->session->userdata('user_code'),
                            'chitha_verified'=>$this->input->post('chitha_verified'),
                            // 'vlb_verified'=>$this->input->post('vlb_verified'),
                            'is_tribal_belt' =>$this->input->post('is_tribal_belt'),
                            'erosion' =>$this->input->post('erosion'),
                            'possession_verification'=>$this->input->post('possession_verified'),
                            'period_possession'=>date('Y-m-d'),
                            'nature_possession'=>$this->input->post('nature_possession'),
                            'is_landless'=>$this->input->post('is_landless'),
                            // 'ceiling_limit'=>$this->input->post('ceiling_limit'),
                            'roadside_reservation'=>$this->input->post('roadside_reservation'),
                            // 'zonal_valuation'=>$this->input->post('zonal_valuation'),
                            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                            // 'chitha_copy'=>$this->input->post('chitha_copy'),
                            'trace_map_copy'=>'NA',
                            'chitha_copy'=>'NA',
                            'lm_note'=>$comment,
                            'date_entry'=>date('Y-m-d h:i:s'),
                            'case_no'=>$case_no,
                            'status'=>'W',
                            'land_falls'=>$this->input->post('land_falls'),
                            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                            'lm_remark_text'=>$this->input->post('lm_remark_text'),
                            'total_bigha'=>$this->input->post('total_bigha'),
                            'total_Katha'=>$this->input->post('total_Katha'),
                            'total_lessa'=>$this->input->post('total_lessa'),
                            'total_ganda'=>$this->input->post('total_ganda'),
                            'total_kranti'=>$this->input->post('total_kranti'),
                            // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                            'landslide'            =>$this->input->post('landslide'),
                            'is_nr_settlement'=>$this->input->post('is_nr_settlement'),
                            'protected_class_lm' => $protected_class_lm,
                            'litigation' => $this->input->post('litigation'),
                            'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
                            'eksona_type' => $this->input->post('gramdan_bhudan'),
                            'eksona_transfered' => $this->input->post('eksona_transfered'),
                            'lm_remark_additional'=>$this->input->post('lm_remark_additional'),
                            'lm_rejected_remarks' => null,
                        );

                        //****roadside reservation */
                        if($roadside_comment_check=='YES')
                        {
                            foreach($district['dags_result'] as $dags)
                            {
                                $reservedarea=array(

                                    'dist_code'=>$this->input->post('dist_code'),
                                    'subdiv_code'=>$this->input->post('subdiv_code'),
                                    'cir_code'=>$this->input->post('cir_code'),
                                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                                    'lot_no'=>$this->input->post('lot_no'),
                                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                                    'dag_no'=>$this->input->post('reserved_dag_road'.$dags->dag_no),
                                    'patta_no'=>$this->input->post('reserved_patta_road'.$dags->dag_no),
                                    'bigha'=>$this->input->post('reserved_bigha'.$dags->dag_no),
                                    'katha'=>$this->input->post('reserved_katha'.$dags->dag_no),
                                    'lessa'=>$this->input->post('reserved_lessa'.$dags->dag_no),
                                    'ganda'=>$this->input->post('reserved_ganda'.$dags->dag_no),
                                    'kranti'=>$this->input->post('reserved_kranti'.$dags->dag_no),
                                    'case_no'=>$case_no,
                                    'applid'=>$this->input->post('applid'),
                                    'lm_code'=>$this->session->userdata('user_code'),
                                    'date_entry'=>date('Y-m-d h:i:s'),
                                    'date_update'=>date('Y-m-d h:i:s'),
                                    'type'=>'R'
                                );

                                $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                                // echo $this->db->last_query(); die();
                                if($reserveData != 1)
                                {
                                    $this->db->trans_rollback();
                                    log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                                    $data = array(
                                        'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                                    );
                                    echo json_encode($data);
                                    return false;
                                }

                            }
                        }
                        ///// road reserve area end //////

                        //****premium calculation for non NR cases */
                        $total_road_reserved    = 0;
                        $total_family_reserved  = 0;
    
                        $reserved_bigha = $this->input->post('reserved_bigha'.$prem_dag);
                        $reserved_katha = $this->input->post('reserved_katha'.$prem_dag);
                        $reserved_lessa = $this->input->post('reserved_lessa'.$prem_dag);
    
                        $reserved_bigha_family = $this->input->post('reserved_bigha_family'.$prem_dag);
                        $reserved_katha_family = $this->input->post('reserved_katha_family'.$prem_dag);
                        $reserved_lessa_family = $this->input->post('reserved_lessa_family'.$prem_dag);
    
                        if (in_array($prem_dist, json_decode(BARAK_VALLEY))) {
                            $reserved_ganda = $this->input->post('reserved_ganda'.$prem_dag);
                            $reserved_ganda_family = $this->input->post('reserved_ganda_family'.$prem_dag);
                        }
    
                        if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                        {
                            $total_applied_area = ($prem_bigha * 6400) + ($prem_katha * 320) + ($prem_lessa * 20) + $prem_ganda;
                            if ($this->input->post('roadside_comment_check') == "YES") {
                                $total_road_reserved = ($reserved_bigha * 6400) + ($reserved_katha * 320) + ($reserved_lessa * 20) + $reserved_ganda;
                            }
    
                            if ($this->input->post('family_comment_check') == "YES") {
                                $total_family_reserved = ($reserved_bigha_family * 6400) + ($reserved_katha_family * 320) + ($reserved_lessa_family * 20) + $reserved_ganda_family;
                            }
                        }
                        else 
                        {
                            $total_applied_area = ($prem_bigha * 100) + ($prem_katha * 20) + $prem_lessa;
    
                            if ($this->input->post('roadside_comment_check') == "YES") {
                                $total_road_reserved = ($reserved_bigha * 100) + ($reserved_katha * 20) + $reserved_lessa;
                            }
    
                            if ($this->input->post('family_comment_check') == "YES") {
                                $total_family_reserved = ($reserved_bigha_family * 100) + ($reserved_katha_family * 20) + $reserved_lessa_family;
                            }
                        }
    
                        $mb_land         = $this->input->post('mb_land'.$prem_dag);
                        $getPrice        = 25;
                        $total_s_area    = 0;
    
                        // var_dump($_POST);
    
                        if (in_array($prem_dist, json_decode(BARAK_VALLEY))){
                            if($mb_land == 25){
                                $mb_land=1600;
                            }else if ($mb_land == 30){
                                $mb_land=1920;
                            }else if ($mb_land == 40){
                                $mb_land=2560;
                            }
                        }
    
                        $total_s_area = $total_applied_area - $total_road_reserved - $total_family_reserved;
                        // var_dump($prem_concession); die;
                        if($prem_concession == 'YES')
                        {
                            if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                            {
                                if($prem_amount_type == 'P'){
                                                    
                                    if($total_s_area > $mb_land){
                                        $premium     = $mb_land * $prem_zonal_valuation / 6400;
                                        $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                        $amount1     = ceil($premium * $discount / 100);
                                        $access_area = $total_s_area - $mb_land;
                                        $premium2    = ($access_area * ($prem_zonal_valuation*1.5)) / 6400;
                                        $amount2     = ceil($premium2 * $discount / 100);
                                        $amount      = ceil($amount1 + $amount2);
                                    }else{
                                        $premium     = $total_s_area * $prem_zonal_valuation / 6400;
                                        $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                        $amount      = ceil($premium * $discount / 100);
                                    }                        
                                }
                                else if($prem_amount_type == 'R'){
                                    // $premium         = $total_s_area * $prem_rate / 6400;
                                    // $discount        = $prem_rate - $getPrice;
                                    // $amount          = ceil($premium * $discount / 100);
                                    $premium = $total_s_area * $prem_rate / 6400;
                                    $discount = ceil($premium * ($getPrice/100));
                                    $amount = ceil($premium - $discount);
                                }
                            }
                            else 
                            {
                                if($prem_amount_type == 'P')
                                {
                                    if($total_s_area > $mb_land)
                                    {
                                        $premium     = $mb_land * $prem_zonal_valuation / 100;
                                        $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                        $amount1     = ceil($premium * $discount / 100);
                                        $access_area = $total_s_area - $mb_land;
                                        $premium2    = ($access_area * ($prem_zonal_valuation*1.5)) / 100;
                                        $amount2     = ceil($premium2 * $discount / 100);
                                        $amount      = ceil($amount1 + $amount2);
                                    }
                                    else
                                    {
    
                                        $premium     = $total_s_area * $prem_zonal_valuation / 100;
                                        $discount    = $prem_rate-($prem_rate * $getPrice / 100);
                                        $amount      = ceil($premium * $discount / 100);
                                    }
                                }
                                else if($prem_amount_type == 'R')
                                {
                                    // $premium  = $total_s_area * $prem_rate / 100;
                                    // $discount = $prem_rate - $getPrice;
                                    // $amount   = ceil($premium * $discount / 100);
                                    $premium = $total_s_area * $prem_rate / 100;
                                    $discount = ceil($premium * ($getPrice/100));
                                    $amount = ceil($premium - $discount);
                                }
                            }
                        }
                        else if($prem_concession == 'NO') 
                        {
                            $discount =0;
                            // var_dump($prem_amount_type); die;
                            if (in_array($prem_dist, json_decode(BARAK_VALLEY))) 
                            {
                                if($prem_amount_type == 'P') 
                                {
                                    if($total_s_area > $mb_land) 
                                    {
                                        $premium     = $mb_land * $prem_zonal_valuation / 6400;
                                        $amount1     = ceil($premium * $prem_rate / 100);
                                        $access_area = $total_s_area - $mb_land;
                                        $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 6400;
                                        $amount2     = ceil($premium2 * $prem_rate / 100);
                                        $amount      = ceil($amount1 + $amount2);
                                    }
                                    else
                                    {
                                        $premium     = $total_s_area * $prem_zonal_valuation / 6400;
                                        $amount      = ceil($premium * $prem_rate / 100);
                                    }
                                }
                                else if($prem_amount_type == 'R')
                                {
                                    // $premium = $total_s_area * $prem_rate / 6400;
                                    // $amount  = ceil($premium * $prem_rate / 100);

                                    $amount = ceil($total_s_area * $prem_rate / 6400);
                                }
                            }
                            else
                            {
                                if($prem_amount_type == 'P')
                                {
                                    if($total_s_area > $mb_land)
                                    {
                                        // var_dump($total_s_area.'----'.$mb_land);
                                        $premium     = $mb_land * $prem_zonal_valuation / 100;
                                        $amount1     = ceil($premium * $prem_rate / 100);
    
                                        $access_area = $total_s_area - $mb_land;
                                        $premium2    = ($access_area * ($prem_zonal_valuation * 1.5)) / 100;
                                        $amount2     = ceil($premium2 * $prem_rate / 100);
    
                                        $amount      = ceil($amount1 + $amount2);
                                    }
                                    else
                                    {
                                        $premium = $total_s_area * $prem_zonal_valuation / 100;
                                        $amount  = ceil($premium * $prem_rate / 100);
                                    }
                                }
                                else if($prem_amount_type == 'R')
                                {
                                    // $premium = $total_s_area * $prem_rate / 100;
                                    // $amount  = ceil($premium * $prem_rate / 100);

                                    $amount = ceil($total_s_area * $prem_rate / 100);
                                }
                            }
                        }
    
                        // var_dump($this->input->post('finalamount')); die;
    
                        $log_json = [
                            'total_s_area'         => $total_s_area,
                            'mb_land'              => $mb_land,
                            'prem_zonal_valuation' => $prem_zonal_valuation,
                            'premium'              => $premium,
                            'prem_rate'            => $prem_rate,
                            'getPrice'             => $getPrice,
                            'discount'             => $discount,
                            'amount'               => $amount,
                            'final_amount'         => $this->input->post('finalamount'),
                            'case_no'              => $case_no,
                            'prem_concession'      => $prem_concession,
                            'prem_amount_type'     => $prem_amount_type,
    
                        ];
    
                        if(ceil($amount) != $this->input->post('finalamount')) 
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERR4392: Premium ghotala by LM : '.json_encode($log_json));
                            $this->session->set_flashdata('message', "Error #ERR4392: Some issue occured on premium for case no. ".$case_no.". Kindly contact system administrator !!");                    
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
    
                        $fmd = [
                            'case_no'         => $case_no,
                            'user_code'       => $this->session->userdata('user_code'),
                            'uuid'            => $district['app']['uuid'],
                            'dag_no'          => $prem_dag,
                            'zonal_valuation' => $this->input->post('zonal_valuation_prem'.$prem_dag),
                            'area_name'       => $this->input->post('area'.$prem_dag),
                            'land_type'       => $this->input->post('land_type'.$prem_dag),
                            'rate_type'       => $this->input->post('rate_type'.$prem_dag),
                            'rate'            => $this->input->post('rate'.$prem_dag),
                            // 'concession'      => $this->input->post('concession'.$prem_dag),
                            'concession'      => $this->input->post('concession'),
                            'amount_dag'      => $this->input->post('amount'.$prem_dag),
                            'final_amount'    => $this->input->post('finalamount'),
                            'due_amount'      => $this->input->post('totaldue'),
                            'total_lessa'     => $this->input->post('total_lessa'.$prem_dag),
                            'is_full_pay'     => $this->input->post('paymode'),
                            'is_final'        => 1,
                            'date_entry'      => date('Y-m-d h:i:s'),
                            'approve_by'      => $this->input->post('approval'.$prem_dag),
                        ];
    
                        $insPremium = $this->db->insert('settlement_premium', $fmd);
                        // echo $this->db->last_query(); die;
    
                        if ($insPremium != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$case_no);
                            $data = array(
                                'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$case_no
                            );
                            echo json_encode($data);
                            return false;
                        }

                    }

                    //*****settlement_ap_lmnote insertion */
                    $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
                    if($insLmnote != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRAP0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRAP0005: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //////proceeding start common insertion//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if($proceeding_id==null){
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $this->input->post('lm_remark_additional'). "\n" .$this->input->post('lm_remark_text'),
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'LM',
                    'office_to' => $pending_officer,
                    'task' => 'LM note submitted'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                // echo $this->db->last_query(); die();
                if($insertProceeding != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                // $this->db->trans_rollback();
                // var_dump('success');
                // die;

                if($this->db->trans_status()==FALSE)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                }
                else
                {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to '.$pending_officer;
                    $status='M';
                    $task='LM';
                    $pen='CO';
                    // $pen=$pending_officer;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                    }
                    $this->session->set_flashdata('message', "Application Successfully Forwarded to ".$pending_officer." With Case No # $case_no");
                    redirect(base_url() . "index.php/home");
                }
            }
        }

    }

    public function getlistOfLandOwnerDetailsByDagNo() {
        $json = null;
        $draw = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $dist  = $this->input->post('dist');
        $sub   = $this->input->post('sub');
        $cir   = $this->input->post('cir');
        $mouza = $this->input->post('mouza');
        $lot   = $this->input->post('lot');
        $vill  = $this->input->post('vill');
        $dag   = trim($this->input->post('dag'));
        $pcode = trim($this->input->post('pcode'));
        $pno   = trim($this->input->post('pno'));

        $result = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father, 
                    A.patta_type_code, A.patta_no
                    FROM chitha_pattadar A LEFT JOIN chitha_dag_pattadar B ON
                    A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND 
                    A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND 
                    B.lot_no=A.lot_no AND A.vill_townprt_code=B.vill_townprt_code
                    AND B.patta_type_code=A.patta_type_code AND A.patta_no=B.patta_no AND
                    A.pdar_id = B.pdar_id
                    WHERE B.dist_code=? AND B.subdiv_code=? AND B.cir_code=? AND 
                    B.mouza_pargona_code=? AND B.lot_no=? AND B.vill_townprt_code=? AND
                    B.dag_no=? AND B.p_flag!=? AND B.patta_type_code=? AND B.patta_no=? 
                    GROUP BY A.pdar_id, A.pdar_name, A.pdar_father, A.patta_type_code, A.patta_no
                    LIMIT ? OFFSET ?", 
                    array($dist, $sub, $cir, $mouza, $lot, $vill, $dag, '1', $pcode, $pno, 
                        $length, $start));
        // log_message('error', '#6193 Get land owner list: '.$this->db->last_query());

        $total_records = $result->num_rows();

        if(!empty($result)){
            if($total_records > 0){
                $i = 1;
                foreach($result->result() as $row)
                {
                    $json[] = [
                        $row->pdar_id,                        
                        $row->pdar_name,
                        $row->pdar_father,
                    ];
                    $i++;
                }
            }
            else {
                $json = "";
            }
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json
            );
            echo json_encode($response);
        }
        else
        {
            $response = array();
            $response['sEcho']=0;
            $response['iTotalRecords']=0;
            $response['iTotalDisplayRecords']=0;
            $response['aaData']=[];
            echo json_encode($response);
        }
    }

    public function saveLandOwnerDetail() {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $cab_id = $this->input->post('cab_id');
        $status = $this->input->post('status');

        $selectedList   = $this->input->post('selectedList');
        $district_code  = $this->input->post('district_code');
        $subdiv_code    = $this->input->post('subdiv_code');
        $circle_code    = $this->input->post('circle_code');
        $mouza_code     = $this->input->post('mouza_code');
        $lot_no_code    = $this->input->post('lot_no_code');
        $village_code   = $this->input->post('village_code');
        $dag_no_code    = $this->input->post('dag_no_code');
        $pattatype_code = $this->input->post('pattatype_code');
        $pattano_code   = $this->input->post('pattano_code');
        $case_no        = $this->input->post('case_no');

        // get from settlement applicant
        $checkSettlementApplicant = $this->db->query("SELECT * FROM settlement_applicant WHERE 
                                        dist_code=? AND subdiv_code=? AND cir_code=? AND
                                        mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?
                                        AND case_no=? AND pdar_type=? AND is_applicant!=?", 
                                        array($district_code, $subdiv_code, $circle_code, $mouza_code, $lot_no_code, $village_code, $case_no, 'O', 1));
        
        if($checkSettlementApplicant->num_rows() > 0){

            $this->db->trans_begin();

            $patta_type_code_array = ['0202', '0204', '0221', '0229', '0230', '0231'];

            // if patta type code is belongs to data availbale in defined array
            if(!in_array($pattatype_code, $patta_type_code_array)){
                $this->db->trans_rollback();
                log_message('error', '#ERR6265 : Issue in patta_type_code =>'.json_decode(PATTA_TYPE_CODE));
                $json = [
                    'responseType' => 1,
                    'message'      => '#ERR6265 : Something went wrong with Patta Code. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            // update existing owner
            $updateExistingOwner = [
                'case_no' => $case_no.'__0',
            ];

            $this->db->where('dist_code', $district_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $circle_code);
            $this->db->where('mouza_pargona_code', $mouza_code);
            $this->db->where('lot_no', $lot_no_code);
            $this->db->where('vill_townprt_code', $village_code);
            $this->db->where('case_no', $case_no);
            $this->db->where('pdar_type', 'O');
            $this->db->where('is_applicant !=', 1);

            $this->db->update('settlement_applicant', $updateExistingOwner);

            if($this->db->affected_rows() <= 0){
                $this->db->trans_rollback();
                log_message('error', '#ERR6293 : Updation failed in settlement_applicant =>'.$this->db->last_query());
                $json = [
                    'responseType' => 1,
                    'message'      => '#ERR6293 : Something went wrong on editing land details. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;
            }

            if(!empty($selectedList)) {
                //insert new selected land owners in settlement_applicant
                foreach($selectedList as $pdarId) {

                    $resByPdarId = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father, 
                        A.patta_type_code, A.patta_no
                        FROM chitha_pattadar A LEFT JOIN chitha_dag_pattadar B ON
                        A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND 
                        A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND 
                        B.lot_no=A.lot_no AND A.vill_townprt_code=B.vill_townprt_code
                        AND B.patta_type_code=A.patta_type_code AND A.patta_no=B.patta_no
                        WHERE B.dist_code=? AND B.subdiv_code=? AND B.cir_code=? AND 
                        B.mouza_pargona_code=? AND B.lot_no=? AND B.vill_townprt_code=? AND
                        B.dag_no=? AND B.p_flag!=? AND B.patta_type_code=? AND B.patta_no=?
                        AND A.pdar_id=?", array($district_code, $subdiv_code, $circle_code, $mouza_code, 
                            $lot_no_code, $village_code, $dag_no_code, '1', $pattatype_code, 
                            $pattano_code, $pdarId));

                    if($resByPdarId->num_rows() <= 0){
                        $this->db->trans_rollback();
                        log_message('error', '#ERR6319 : No detail found in chitha for selected pdar_id =>'.$this->db->last_query());
                        $json = [
                            'responseType' => 1,
                            'message'      => '#ERR6319 : Something went wrong on editing land details. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $data = $resByPdarId->row();
                    $arrPetition = explode('/', $case_no);

                    $cronNo = $this->db->query("SELECT pdar_cron_no FROM settlement_applicant 
                                WHERE case_no=? ORDER BY id DESC LIMIT 1", array($case_no));
                    if($cronNo->num_rows() > 0)
                    {
                        $cron_no = (int)$cronNo->row()->pdar_cron_no + 1;
                    }
                    else {
                        $cron_no = 1;
                    }

                    $insLandOwner = [
                        'dist_code'         => $district_code,
                        'subdiv_code'       => $subdiv_code,
                        'cir_code'          => $circle_code,
                        'mouza_pargona_code'=> $mouza_code,
                        'lot_no'            => $lot_no_code,
                        'vill_townprt_code' => $village_code,
                        'user_code'         => $this->session->userdata('user_code'),
                        'case_no'           => $case_no,
                        'petition_no'       => $arrPetition['3'],
                        'operation'         => 'E',
                        'dag_no'            => $dag_no_code,
                        'patta_no'          => $data->patta_no,
                        'patta_type_code'   => $data->patta_type_code,
                        'year_no'           => date('Y'),
                        'date_entry'        => date('Y-m-d'),
                        'pdar_id'           => $data->pdar_id,
                        'pdar_cron_no'      => $cron_no,
                        'pdar_name'         => $data->pdar_name,
                        'pdar_guardian'     => $data->pdar_father,
                        'pdar_rel_guar'     => 0,
                        'pdar_type'         => 'O',
                        'is_applicant'      => 0,
                    ];
                    $insertOwner = $this->db->insert('settlement_applicant', $insLandOwner);

                    if($insertOwner != 1 || $insertOwner != true){
                        $this->db->trans_rollback();
                        log_message('error', '#ERR6369 : Insertion failed in settlement_applicant =>'.$this->db->last_query());
                        $json = [
                            'responseType' => 1,
                            'message'      => '#ERR6369 : Something went wrong on editing land details. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return;
                    }
                }

                $this->db->trans_commit();
                log_message('error', '#SUCCESS6380 : Successfully added land owner details');
                $json = [
                    'responseType' => 2,
                    'message'      => '#SUCCESS6380 : Successfully added land owner details',
                ];
                echo json_encode($json);
                return;
            }
            else {
                $this->db->trans_rollback();
                log_message('error', '#ERR6391 : No owner selected =>'.json_encode($selectedList));
                $json = [
                    'responseType' => 1,
                    'message'      => '#ERR6390 : Something went wrong on editing land details. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return;

            }                
        }

        $this->db->trans_rollback();
        log_message('error', '#ERR6403 : No detail found in settlement_applicant =>'.$this->db->last_query());
        $json = [
            'responseType' => 1,
            'message'      => '#ERR6403 : Something went wrong on editing land details. Kindly contact system administrator',
        ];
        echo json_encode($json);
        return;
    }



}