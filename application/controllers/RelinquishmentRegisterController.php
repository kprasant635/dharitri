<?php
class RelinquishmentRegisterController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->model('Relinquishment/RelinquishmentCommonModel');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->dbswitch();

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


    //// ******************* 26-06-2024 / Masud Reza *************************

    public function checkAccessRelinquishment()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,RELINQUISHMENT_PROCESS_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }


    public function checkAccessRelinquishmentRegister()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // all relinquishment application without register
    public function unRegisterRelinquishmentAppList()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentRegister();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $mou_code    = trim($this->session->userdata('mouza_pargona_code'));
        $lot_code    = trim($this->session->userdata('lot_no'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        if(in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $url = API_LINK_MB2."getRelinquishListPagination/$serviceCode/$dist_code/$subdiv_code/$cir_code/$mou_code/$lot_code" ;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $output = curl_exec($ch);
            curl_close($ch);

            $outputM = json_decode($output);

            $data['selectList'] = $outputM;
            $data['service']    = $serviceCode;

            $data['_view'] = 'Relinquishment/un_register_case_list';
            $this->load->view('layouts/main',$data);

        }
        else
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }
    }



    // API call for un register case
    public function apiForUnRegisterRelinquishmentApp()
    {
        $this->checkAccessRelinquishment();
        $this->checkAccessRelinquishmentRegister();

        $service       = RELINQUISHMENT_ID;
        $draw          = intval($this->input->post('draw'));
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');
        $occupation    = trim($this->input->post('occupation'));
        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $is_cat        = $this->input->post('is_category');
        $is_rural      = $this->input->post('rural');
        $dist_code     = trim($this->session->userdata('dist_code'));
        $subdiv_code   = trim($this->session->userdata('subdiv_code'));
        $cir_code      = trim($this->session->userdata('cir_code'));
        $mou_code      = trim($this->session->userdata('mouza_pargona_code'));
        $lot_code      = trim($this->session->userdata('lot_no'));

        $url = API_LINK_MB2."getRelinquishListPagination/$service/$dist_code/$subdiv_code/$cir_code/$mou_code/$lot_code" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);

        $results = json_decode($output);


        if (isset($results))
        {
            //==============getting the reject_list
            $rejected_data = $this->RelinquishmentCommonModel->getRejectModal($service);
            if($rejected_data == 'n')
            {
                $rejected_list = false;
            }
            else
            {
                $rejected_list = $rejected_data;
            }

            $data_rows = $results->data_results;

            foreach ($data_rows as $rows) {

                $case_no = $this->utilityclass->getCaseNoByApplId((string)$dist_code, (string)$rows->application_no);

                $dags = $this->RelinquishmentCommonModel->getSettlementDag($case_no);

                $chithaRemarks = $this->RelinquishmentCommonModel->getChithaFlaggedRemarks($dags, $rejected_list);

                if($chithaRemarks == true)
                {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                }
                else
                {
                    $chithaFlag = 'No';
                }

                $her_link = '<a type="button" href="' . base_url() . 'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = array(
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $newDate = date("d-m-Y", strtotime( $rows->date_submission)),
                    '<b>'.$chithaFlag.'</b>',
                    $rows->rurban,

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),
                    $her_link
                );
            }

            $total_records = $results->total_records;
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





    // view un register case details case details
    public function viewUnRegisterCaseDetails()
    {
        $this->checkAccessRelinquishment();
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $app = $this->input->get('app');
            $application_no = $this->utilityclass->decryptJwtCase($app);

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

            // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0)
            {
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            }
            else
            {
                $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            // check and insert if case not registered
            $recordExist = $this->RelinquishmentCommonModel->checkExistDharitree($application_no);
            if(!$recordExist)
            {
                /// additional property for LM note
                $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
                if($additional_property->num_rows() > 0)
                {
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
                    //var_dump($district['additional_property']); die;
                }


                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
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
                $backup = $output;
                $output = json_decode($output);
            }

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
            if($get_aadhaar_photo != 'n')
            {
                $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            }

            //*******generating petition_no and case_no */
            $district['geo_date']    = $geo_date;
            $district['basic']       = $output->application;
            $district['app']         = $output->application;
            $district['pattaNo']     = $this->utilityclass->getPattaTypeNo($district['basic']->dist_code,$district['basic']->subdiv_code,$district['basic']->cir_code,$district['basic']->mouza_code,$district['basic']->lot_no,$district['basic']->village_code,$district['basic']->dag_no);
//            $district['applicants']  = $output->applicants;
            $district['document']    = $output->documents;
            $district['query']       = $output->query;
            $district['property']    = $output->property;
            $district['settlements'] = $output->settlements;
            $district['applicants']  = $output->settlements;
            $district['rel_dag']     = $output->rel_dag;
            $district['dags']        = $output->rel_dag;
            $district['dags_result'] = $output->rel_dag;
            $district['encroachers'] = $output->encroachers;
            $district['owners']      = $output->owners;
            $district['riotee_noks'] = $output->riotee_noks;
            $district['aadhar']      = $output->aadhar;
            $district['nextKin']     = $output->nextKin;
            $d                       = $district['basic']->dist_code;
            $s                       = $district['basic']->subdiv_code;
            $c                       = $district['basic']->cir_code;
            $m                       = $district['basic']->mouza_code;
            $l                       = $district['basic']->lot_no;
            $v                       = $district['basic']->village_code;
            $dag                     = $district['basic']->dag_no;
            $district['co_name']     = $this->RelinquishmentCommonModel->getCoName($d, $s, $c);
            $district['s_area']      = $this->RelinquishmentCommonModel->getPremiumArea();
            $district['bhumi']       = $output->bhumi;
            $district['caseDetails'] = $output;
            $district['case_no']     = $application_no;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();

            if ($row != 0)
            {
                $district['guar_rel'] = $relation_executation->result();
            }

            // fetch riotee noks
            if($output->riotee_noks == true)
            {
                $district['riotee_nok'] = $output->riotee_noks;
            }
            // $district['selfDeclarationDetails'] = $output->selfDeclaration;
            foreach($output->selfDeclaration as $selfDec)
            {
                $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }


            $rejected_data = $this->RelinquishmentCommonModel->getRejectModal(RELINQUISHMENT_ID);
            if($rejected_data == 'n')
            {
                $district['rejected_list'] = false;
            }
            else
            {
                $district['rejected_list'] = $rejected_data;
            }

            $district['dagFlagCheckChitha'] = $this->RelinquishmentCommonModel->getChithaFlaggedRemarks($output->rel_dag, $district['rejected_list']);


//            dd($district);

            $district['_view'] = 'Relinquishment/un_register_case_details';
            $this->load->view('layouts/main',$district);

        }
        else
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment');
        }

    }



    // case register on dharitee
    public function relinquishmentApplicationRegisterInDhar()
    {
        $this->checkAccessRelinquishment();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $user_code   = trim($this->session->userdata('user_code'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        $app         = trim($this->input->post('appNo'));

        if(in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('appNo', 'Application', 'trim|required|xss_clean');
            $this->form_validation->set_rules('forwardTo', 'Forwarding officer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|max_length[2000]|xss_clean');

            $this->form_validation->set_rules('chitha_verified', 'Chitha Verified', 'trim|required|in_list[YES,NO]|xss_clean');
            $this->form_validation->set_rules('lm_note', 'LM Remarks', 'trim|required|xss_clean');
            $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required|xss_clean');
            $this->form_validation->set_rules('lm_remark_additional', 'LM NR Remarks (Text Area)', 'trim|required|xss_clean');


            // todo all post data validate


            if(isset($_FILES['fileUpload']['name']))
            {
                $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');

                $fileCount = count($_FILES['fileUpload']['name']);
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
                                $this->form_validation->set_rules('additional_doc_err','File extension','required');

                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                $this->form_validation->set_rules('additional_doc_err','Only JPG/PNG/PDF file','required');
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->form_validation->set_rules('additional_doc_err','Maximum 5MB file size','required');
                            }
                        }
                        else
                        {
                            $this->form_validation->set_rules('additional_doc_err','File name','required');
                        }
                    }
                    else
                    {
                        $this->form_validation->set_rules('additional_doc_err','File','required');
                    }
                }
            }


            $validation_bypass = 0;
            $totalSettlementAreaNotMatchHomeAgri = 0;
            if(isset($_POST['lm_note']) == '2')
            {
                if(isset($_POST['rejected_reasons']))
                {

                    $validation_bypass_array = $this->getValidationBypass(RELINQUISHMENT_ID);

                    foreach($_POST['rejected_reasons'] as $rej_list_key => $rej_form_code)
                    {

                        $r_c = explode("_", $rej_form_code);

                        if (in_array($r_c[0], $validation_bypass_array)) {
                            $validation_bypass = 1;
                        }
                    }
                }
            }

            if($_POST['lm_note'] == '2')
            {
                $this->form_validation->set_rules('rejected_reasons', 'Rejected reason', 'required|max_length[2000]|xss_clean');

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


            $postData = $this->input->post();

            foreach ($postData as $key => $value)
            {
                if (strpos($key, 'owners_in_place') === 0)
                {

                    $ownerId = str_replace('owners_in_place', '', $key);
                    $this->form_validation->set_rules('owners_in_place'.$ownerId, 'Owners In Place', 'trim|required|in_list[i,a]|xss_clean');
                }
            }


            if ($this->form_validation->run() == FALSE)
            {
                $errors = validation_errors();
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
            }


            $application_no = $this->utilityclass->decryptJwtCase($app);
            $forwardTo      = trim($this->input->post('forwardTo'));
            $remarks        = trim($this->input->post('remarks'));

            $recordExist = $this->RelinquishmentCommonModel->checkExistDharitree($application_no);
            if(!$recordExist)
            {
                // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
                $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));
                if($supportive_document_sql->num_rows() > 0)
                {
                    $district['geo_tag_doc'] = $supportive_document_sql->result();
                }
                else
                {
                    $district['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
                }

                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
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
                $backup = $output;
                $output = json_decode($output);

                $district['app'] = $output->application;
                $d = $district['app']->dist_code;
                $s = $district['app']->subdiv_code;
                $c = $district['app']->cir_code;
                $m = $district['app']->mouza_code;
                $l = $district['app']->lot_no;
                $v = $district['app']->village_code;

                if($dist_code != $d)
                {
                    $errors = "You are not Authorized for this process";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }

                //****************generate case number********************
                $case_name=$this->RelinquishmentCommonModel->genearteCaseName($d,$s,$c);
                if(empty($case_name))
                {
                    $errors = "Network Issue or Session Out. Please try Again";
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }

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
                if($get_aadhaar_photo != 'n')
                {
                    $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                //*******generating petition_no and case_no */
                $case_no['petition_no']  = $petition_no=$this->RelinquishmentCommonModel->genearteSettlementPetitionNo();
                $case_no['case_no']      = $case_name.$petition_no."/".RELINQUISHMENT_NAME;
                $district['applicants']  = $output->settlements;
                $district['document']    = $output->documents;
                $district['query']       = $output->query;
                $district['property']    = $output->property;
                $district['settlements'] = $output->settlements;
                $district['encroachers'] = $output->encroachers;
                $district['owners']      = $output->owners;
                $district['riotee_noks'] = $output->riotee_noks;
                $district['aadhar']      = $output->aadhar;
                $district['nextKin']     = $output->nextKin;
                $district['co_name']     = $this->RelinquishmentCommonModel->getCoName($d, $s, $c);
                $district['s_area']      = $this->RelinquishmentCommonModel->getPremiumArea();
                $district['rel_dag']     = $output->rel_dag;
                $district['pattaNo']     = $this->utilityclass->getPattaTypeNo($d,$s,$c,$m,$l,$v,$district['rel_dag'][0]->dag_no);


                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows();
                if ($row != 0)
                {
                    $district['guar_rel'] = $relation_executation->result();
                }
                foreach($output->selfDeclaration as $selfDec)
                {
                    $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                $this->db->trans_begin();
                // insertion in backup table (lm)
                $backup_array = [
                    'applid'  => $application_no,
                    'case_no' => $case_no['case_no'],
                    'status'  => 'I',
                    'data'    => $backup
                ];
                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
                if($backup_insertion != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);
                    $errors = "#BACKUP001: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }



                // area validation
                $appAreaMoreThanDagA = 0;
                $totalAppArea        = 0;
                $dagAreaZero         = 0;
                $appliedAreaZero     = 0;
                foreach ($district['rel_dag'] as $dags)
                {
                    // for barak valley
                    if(in_array($d, json_decode(BARAK_VALLEY)))
                    {
                        $bighaInDag   = $this->UtilsModel->defaultValue($dags->available_bigha, 0);
                        $kathaInDag   = $this->UtilsModel->defaultValue($dags->available_katha, 0);
                        $lessaInDag   = $this->UtilsModel->defaultValue($dags->available_lessa, 0);
                        $gandaInDag   = $this->UtilsModel->defaultValue($dags->available_ganda, 0);
                        $bighaApplied = $this->UtilsModel->defaultValue($dags->applied_bigha, 0);
                        $kathaApplied = $this->UtilsModel->defaultValue($dags->applied_katha, 0);
                        $lessaApplied = $this->UtilsModel->defaultValue($dags->applied_lessa, 0);
                        $gandaApplied = $this->UtilsModel->defaultValue($dags->applied_ganda, 0);

                        $totalDagAreaDagWise     = ($bighaInDag * 6400) + ($kathaInDag * 320) + ($lessaInDag * 20) + $gandaInDag;
                        $totalAppliedAreaDagWise = ($bighaApplied * 6400) + ($kathaApplied * 320) + ($lessaApplied * 20) + $gandaApplied;

                        if($totalDagAreaDagWise < $totalAppliedAreaDagWise)
                        {
                            $appAreaMoreThanDagA = 1;
                        }
                        if($totalAppliedAreaDagWise <= 0)
                        {
                            $dagAreaZero = 1;
                        }
                        if($totalAppliedAreaDagWise <= 0)
                        {
                            $appliedAreaZero = 1;
                        }
                        $totalAppArea += $totalAppliedAreaDagWise;
                    }
                    else
                    {
                        $bighaInDag   = $this->UtilsModel->defaultValue($dags->available_bigha, 0);
                        $kathaInDag   = $this->UtilsModel->defaultValue($dags->available_katha, 0);
                        $lessaInDag   = $this->UtilsModel->defaultValue($dags->available_lessa, 0);
                        $bighaApplied = $this->UtilsModel->defaultValue($dags->applied_bigha, 0);
                        $kathaApplied = $this->UtilsModel->defaultValue($dags->applied_katha, 0);
                        $lessaApplied = $this->UtilsModel->defaultValue($dags->applied_lessa, 0);

                        $totalDagAreaDagWise = ($bighaInDag * 100) + ($kathaInDag * 20) + $lessaInDag;
                        $totalAppliedAreaDagWise = ($bighaApplied * 100) + ($kathaApplied * 20) + $lessaApplied;

                        if($totalDagAreaDagWise < $totalAppliedAreaDagWise)
                        {
                            $appAreaMoreThanDagA = 1;
                        }
                        if($totalAppliedAreaDagWise <= 0)
                        {
                            $dagAreaZero = 1;
                        }
                        if($totalAppliedAreaDagWise <= 0)
                        {
                            $appliedAreaZero = 1;
                        }
                        $totalAppArea += $totalAppliedAreaDagWise;
                    }

                }

                if($appAreaMoreThanDagA == 1)
                {
                    $this->db->trans_rollback();
                    $errors = "#MRQHMD0001: Total applied area should not be more than total Dag Area for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);

                }
                if($dagAreaZero == 1)
                {
                    $this->db->trans_rollback();
                    $errors = "#MRQHMD0002: Total dag area should not be Zero for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);

                }
                if($appliedAreaZero == 1)
                {
                    $this->db->trans_rollback();
                    $errors = "#MRQHMD0003: Total applied area should not be Zero for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);

                }



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
                        $config['max_size']      = UPLOAD_MAX_SIZE;;
                        $config['file_name']     = $fileRename;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('file'))
                        {
                            $document= array(
                                'case_no'   => $case_no['case_no'],
                                'file_name' => $_POST['fileText'][$i],
                                'user_code' => $this->session->userdata('user_code'),
                                'fetch_file_name' => $_POST['fileText'][$i],
                                'file_type'  => $_FILES['file']['type'],
                                'file_path'  => UPLOAD_DIR . $fileRename,
                                'date_entry' => date('Y-m-d h:i:s'),
                                'mut_type'   => RELINQUISHMENT_ID,
                            );

                            // save data in attachment file
                            $addMoreDocQuery = $this->db->insert('supportive_document',$document);

                            if($addMoreDocQuery != 1)
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#MRQHM0049: Insertion failed in supportive document RTPS Case No '.$application_no);

                                $this->session->set_flashdata('error_data', "#MRQHM0049: Registration of Settlement failed for case no : ".$application_no);
                                redirect(base_url() . "index.php/home");
                                return false;
                            }

                        }
                        else
                        {
                            $this->db->trans_rollback();
                            // redirect to respected route with error mgs
                            log_message('error', '#MRQHM0050: Insertion failed in supportive document RTPS Case No '.$application_no);

                            $this->session->set_flashdata('error_data', "#MRQHM0050: Registration of Settlement failed for case no : ".$application_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                }


                // For uploading dag wise trace_map_copy
                foreach($district['rel_dag'] as $dags_doc)
                {
                    $timestamp = date('mdYhis', time()) . uniqid();

                    // Trace Map copy upload
                    $field_name = 'trace_map_copy' . $dags_doc->id; // dynamic input name
                    $config = [
                        'file_name'     => 'trace_map_copy' . $timestamp,
                        'upload_path'   => UPLOAD_DIR,
                        'allowed_types' => UPLOAD_ALLOW_TYPE,
                        'max_size'      => UPLOAD_MAX_SIZE
                    ];

                    // Load upload library once
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload($field_name)) {
                        $error = ['error' => 'Trace Map ' . $this->upload->display_errors()];
                        echo json_encode($error);
                        return false;
                    } else {
                        $data = $this->upload->data();

                        $document = [
                            'case_no'         => $case_no['case_no'],
                            'file_name'       => 'Trace Map Copy',
                            'user_code'       => $this->session->userdata('user_code'),
                            'fetch_file_name' => $data['orig_name'],
                            'file_type'       => $data['file_type'],
                            'file_path'       => $config['upload_path'] . $data['orig_name'],
                            'date_entry'      => date('Y-m-d H:i:s'),
                            'mut_type'        => RELINQUISHMENT_ID,
                            'dag_no'          => $this->input->post('dag_no_doc' . $dags_doc->id)
                        ];

                        $insert_supportive_doc = $this->db->insert('supportive_document', $document);

                        if (!$insert_supportive_doc) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRQHM0011: Insertion failed in supportive_document for case no : ' . json_encode($case_no));
                            $json = [
                                'errorMessage' => "#MRQHM0011: Failed to forward the case for Case No : " . json_encode($case_no)
                            ];
                            echo json_encode($json);
                            return false;
                        }


                    }
                }

                // For uploading field report
                $this->load->library('upload');
                $timestamp = date('mdYhis', time()).uniqid();
                $config2['file_name']            = 'field_report'.$timestamp;
                $config2['upload_path']          = UPLOAD_DIR;
                $config2['allowed_types']        = UPLOAD_ALLOW_TYPE;
                $config2['max_size']             = UPLOAD_MAX_SIZE;

                $this->upload->initialize($config2);

                if ( ! $this->upload->do_upload('field_report'))
                {
                    $error = array('error' => 'Field Report'.$this->upload->display_errors());

                    var_dump($error);
                    die;
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $document= array(
                        'case_no'         => $case_no['case_no'],
                        'file_name'       => 'Field Report',
                        'user_code'       => $this->session->userdata('user_code'),
                        'fetch_file_name' => $data['upload_data']['orig_name'],
                        'file_type'       => $data['upload_data']['file_type'],
                        'file_path'       => $config2['upload_path'].$data['upload_data']['orig_name'],
                        'date_entry'      => date('Y-m-d h:i:s'),
                        'mut_type'        => RELINQUISHMENT_ID,
                    );

                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                    if($insert_supportive_doc != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#MRQHM0012: Insertion failed in supportive_document for case no :'. $case_no['case_no']);
                        $json = [
                            'errorMessage'=>"#MRQHM0012: Failed to forward the case for Case No : ".$case_no['case_no']
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

                // UPDATING Geo Tag Photo case number in supportive document
                if(isset($district['geo_tag_doc']))
                {
                    foreach($district['geo_tag_doc'] as $geo_tag_loop)
                    {
                        $geo_tag_array = array(
                            'case_no' => $case_no['case_no']
                        );
                        $this->db->where('applid', $geo_tag_loop->applid);
                        $this->db->where('dag_no', $geo_tag_loop->dag_no);
                        $this->db->where('file_name', GEO_TAG_PHOTO);
                        $this->db->update('supportive_document', $geo_tag_array);

                        if($this->db->affected_rows() == 0 ){
                            $this->db->trans_rollback();
                            log_message('error', '#MRQHM0052: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                            $data = array(
                                'error'=>"#MRQHM0052: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                $relinquishId = '';
                $deptName     = '';
                foreach ($district['applicants'] as $rrrr)
                {
                    if($rrrr->is_applicant == '1')
                    {
                        $relinquishId = $rrrr->relinquish_id;
                        $deptName     = $rrrr->dept_name;
                    }
                }

                if (empty($relinquishId) || empty($deptName))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRQHM000201: missing dept_name-relinquishId  for RTPS Case No '.$application_no);
                    $errors = "#MRQHM000201: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }


                //********settlement_basic insertation */
                $basic = array(
                    'dist_code'            => $district['app']->dist_code,
                    'subdiv_code'          => $district['app']->subdiv_code,
                    'cir_code'             => $district['app']->cir_code,
                    'mouza_pargona_code'   => $district['app']->mouza_code,
                    'lot_no'               => $district['app']->lot_no,
                    'vill_townprt_code'    => $district['app']->village_code,
                    'service_code'         => $serviceCode,
                    'ref_no'               => $district['app']->ref_no,
                    'case_no'              => $case_no['case_no'],
                    'trans_code'           => 'F',
                    'petition_no'          => $case_no['petition_no'],
                    'year_no'              => date('Y'),
                    'date_entry'           => date('Y-m-d G:i:s'),
                    'status'               => 'Z',
                    'user_code'            => $user_code,
                    'lm_code'              => $user_code,
                    'submission_date'      => date('Y-m-d G:i:s'),
                    'from_office'          => MB_LOT_MONDOL,
                    'pending_officer'      => $forwardTo,
                    'pending_office'       => 'CO',
                    'occupation_applicant' => $district['applicants'][0]->applicant_occupation,
                    'applid'               => $district['app']->application_no,
                    'caste'                => $district['applicants'][0]->caste_category,
                    'uuid'                 => $district['app']->uuid,
                    'dept_name'            => $deptName,
                    'relinquish_id'        => $relinquishId,
                );
                $insSetBasic = $this->db->insert('settlement_basic', $basic);
                if ($insSetBasic != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRQHM0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                    $errors = "#MRQHM0001: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }

                //*******pdar_cron number generation */
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0)
                {
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }
                else
                {
                    $cron_no = 1;
                }

                // settlement_applicant insertion */
                foreach ($district['applicants'] as $setl)
                {
                    if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1')
                    {
                        $timestamp = date('mdYhis', time()).uniqid();
                        $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                        $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                        $aadhaar_encoded_file = $get_aadhaar_photo;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);
                    }
                    else
                    {
                        $aadhar_path = '';
                    }
                    if($district['aadhar']->type == 'AADHAAR')
                    {
                        $identity_ref_no = $district['aadhar']->aadhaar_no;
                    }
                    else
                    {
                        $identity_ref_no = $district['aadhar']->pan_no;
                    }




                    if($setl->is_applicant == '1')
                    {
                        $applicant = array(
                            'dist_code'          => $d,
                            'subdiv_code'        => $s,
                            'cir_code'           => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no'             => $l,
                            'vill_townprt_code'  => $v,
                            'user_code'          => $user_code,
                            'case_no'            => $case_no['case_no'],
                            'petition_no'        => $case_no['petition_no'],
                            'operation'          => 'E',
                            'dag_no'             => $setl->dag_no,
                            'patta_no'           => $setl->patta_no,
                            'patta_type_code'    => $setl->patta_code,
                            'year_no'            => date('Y'),
                            'date_entry'         => date('Y-m-d'),
                            'pdar_id'            => $setl->chitha_pdar_id,
                            'pdar_cron_no'       => (int) $cron_no++,
                            'pdar_name'          => $setl->name_ass,
                            'pdar_guardian'      => $setl->gurdian_name_ass,
                            'eng_pdar_name'      => $setl->name_eng,
                            'eng_pdar_guardian'  => $setl->gurdian_name_eng,
                            'pdar_rel_guar'      => $setl->gurdian_relation_id,
                            'pdar_gender'        => $setl->gender,
                            'pdar_add1'          => $setl->pre_add.', City - '.$setl->pre_city.', Pin - '.$setl->pre_pin,
                            'pdar_add2'          => $setl->per_add.', City - '.$setl->per_city.', Pin - '.$setl->per_pin,
                            'pdar_mobile'        => $setl->mobile,
                            'pdar_type'          => $setl->pdar_type,
                            'is_applicant'       => $setl->is_applicant,
                            'identity_ref_no'    => $identity_ref_no,
                            'identity_type'      => $district['aadhar']->type,
                            'identity_doc_link'  => $aadhar_path,
                            'marital_status'     => $setl->marital_status,
                            'dob'                => $setl->dob,
                        );

                        $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                        if ($insSetApplicant != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRQHM0002: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $errors = "#MRQHM0002: Registration failed for case no : ".$application_no;
                            $this->session->set_flashdata('error', $errors);
                            redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                        }
                    }

                }

                // owner insertion
                foreach ($district['owners'] as $setl)
                {

                    if($setl->is_applicant == '0')
                    {
                        if (empty($setl->dag_no) || empty($setl->patta_no) || empty($setl->patta_code) || empty($setl->chitha_pdar_id) || empty($this->input->post('owners_in_place'.$setl->id)))
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRQHM000202: missing dag_no-patta_no-patta_code-chitha_pdar_id-owners_in_place  for RTPS Case No '.$application_no);
                            $errors = "#MRQHM000202: Registration failed for case no : ".$application_no;
                            $this->session->set_flashdata('error', $errors);
                            redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                        }

                        $owner = array(
                            'dist_code'          => $d,
                            'subdiv_code'        => $s,
                            'cir_code'           => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no'             => $l,
                            'vill_townprt_code'  => $v,
                            'user_code'          => $user_code,
                            'case_no'            => $case_no['case_no'],
                            'petition_no'        => $case_no['petition_no'],
                            'operation'          => 'E',
                            'dag_no'             => $setl->dag_no,
                            'patta_no'           => $setl->patta_no,
                            'patta_type_code'    => $setl->patta_code,
                            'year_no'            => date('Y'),
                            'date_entry'         => date('Y-m-d'),
                            'pdar_id'            => $setl->chitha_pdar_id,
                            'pdar_cron_no'       => (int) $cron_no++,
                            'pdar_name'          => $setl->name_ass,
                            'pdar_guardian'      => $setl->gurdian_name_ass,
                            'eng_pdar_name'      => $setl->name_eng,
                            'eng_pdar_guardian'  => $setl->gurdian_name_eng,
                            'pdar_rel_guar'      => '0',
                            'pdar_gender'        => '0',
                            'pdar_add1'          => '',
                            'pdar_add2'          => '',
                            'pdar_mobile'        => $setl->mobile,
                            'pdar_type'          => 'O',
                            'inplace_alongwith'  => $this->input->post('owners_in_place'.$setl->id),


                        );
                        $insSetOwner = $this->db->insert('settlement_applicant', $owner);
                        if ($insSetOwner != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRQHM002: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $errors = "#MRQHM002: Registration failed for case no : ".$application_no;
                            $this->session->set_flashdata('error', $errors);
                            redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                        }
                    }
                }

                // settlement_dag_details insert start
                foreach ($district['rel_dag'] as $dags)
                {

                    $district['class'] = $this->utilityclass->getPattaTypeNo($d,$s,$c,$m,$l,$v, $dags->dag_no);
                    // dd($district['class']);
                    $fmd = array(
                        'dist_code'           => $d,
                        'subdiv_code'         => $s,
                        'cir_code'            => $c,
                        'mouza_pargona_code'  => $m,
                        'lot_no'              => $l,
                        'vill_townprt_code'   => $v,
                        'user_code'           => $user_code,
                        'operation'           => 'E',
                        'date_entry'          => date('Y-m-d'),
                        'case_no'             => $case_no['case_no'],
                        'petition_no'         => $case_no['petition_no'],
                        'year_no'             => date('Y'),
                        'new_land_class_code' => $district['class']->land_class_code,
                        'dag_no'              => $dags->dag_no,
                        'patta_no'            => $dags->patta_no,
                        'patta_type_code'     => $dags->patta_type_code,
                        'is_urban'            => $district['app']->is_urban,
                        'land_type'           => RELINQUISHMENT_LAND_TYPE,
                        'revenue'             => 0,
                        'dag_area_b'          => $dags->available_bigha,
                        'dag_area_k'          => $dags->available_katha,
                        'dag_area_lc'         => $dags->available_lessa,
                        'dag_area_g'          => $dags->available_ganda,
                        'dag_area_kr'         => $dags->available_kranti,
                        'home_b'              => 0,
                        'home_k'              => 0,
                        'home_lc'             => 0,
                        'home_g'              => 0,
                        'home_kr'             => 0,
                        'agri_b'              => 0,
                        'agri_k'              => 0,
                        'agri_lc'             => 0,
                        'agri_g'              => 0,
                        'agri_kr'             => 0,
                        's_dag_area_b'        => $dags->applied_bigha,
                        's_dag_area_k'        => $dags->applied_katha,
                        's_dag_area_lc'       => $dags->applied_lessa,
                        's_dag_area_g'        => $dags->applied_ganda,
                        's_dag_area_kr'       => $dags->applied_kranti,

                    );

                    $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                    if ($insSetDag != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRQHM0003: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                        $errors = "#MRQHM0003: Registration failed for case no : ".$application_no;
                        $this->session->set_flashdata('error', $errors);
                        redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);

                    }
                }

                // basundhar_application insertation
                $basundhara=array(
                    'dharitree'    => $case_no['case_no'],
                    'basundhara'   => $application_no,
                    'date_reg'     => date('Y-m-d'),
                    'reg_by'       => $user_code,
                    'app_status'   => 'M',
                    'pending_with' => $forwardTo
                );
                $basundhar_app = $this->db->insert('basundhar_application',$basundhara);
                if ($basundhar_app != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRQHM0004: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $errors = "#MRQHM0004: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }


                // proceeding
                $proceeding_id = $this->RelinquishmentCommonModel->getOfflineProceedingId($case_no['case_no']);

                $insPetProceed = [
                    'case_no'              => $case_no['case_no'],
                    'proceeding_id'        => $proceeding_id,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => $this->input->post('lm_remark_additional'). "\n" .$this->input->post('lm_remark_text'),
                    'status'               => 'W',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => 'LM',
                    'office_to'            => $forwardTo,
                    'task'                 => 'LM note submitted'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRQHM055: Insertion failed in settlement_proceeding Case No '.$application_no);
                    $errors = "#MRQHM055: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }

                $insPetProceed2 = [
                    'case_no'              => $case_no['case_no'],
                    'proceeding_id'        => $proceeding_id+1,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => $remarks,
                    'status'               => 'Z',
                    'user_code'            => $user_code,
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => $userDegCode,
                    'office_to'            => $forwardTo,
                    'task'                 => 'Application Forward to '. $forwardTo
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed2);
                if ($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRQHM0005: Insertion failed in settlement_proceeding Case No '.$application_no);
                    $errors = "#MRQHM0005: Registration failed for case no : ".$application_no;
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
                }

                $comment = addslashes($this->input->post('lm_note'));

                $lmnote=array(
                    'user_code'            => $this->session->userdata('user_code'),
                    'chitha_verified'      => $this->input->post('chitha_verified'),
                    'trace_map_copy'       =>'NA',
                    'chitha_copy'          =>'NA',
                    'lm_note'              => $comment,
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'case_no'              => $case_no['case_no'],
                    'status'               =>'W',
                    'lm_remark_text'       => $this->input->post('lm_remark_text'),
                    'total_bigha'          => $this->UtilsModel->defaultValue(trim($this->input->post('total_applied_bigha')),0),
                    'total_Katha'          => $this->UtilsModel->defaultValue(trim($this->input->post('total_applied_katha')),0),
                    'total_lessa'          => $this->UtilsModel->defaultValue(trim($this->input->post('total_applied_lessa')),0),
                    'total_ganda'          => $this->UtilsModel->defaultValue(trim($this->input->post('total_applied_ganda')),0),
                    'lm_remark_additional' => $this->input->post('lm_remark_additional'),
                    'lm_rejected_remarks'  => null,

                );

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
            else
            {
                $errors = "Application Already Processed";
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
            }
            else
            {
                //////////////POST To basundhara/////////////////////
                $rmk    = 'Case Registered and Forwarded to CO';
                $status = 'M';
                $task   = 'LM';
                $pen    = 'CO';
                $case   = $case_no['case_no'];
                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                // dd($rtps_status);
                $rtps_status = json_decode($rtps_status);

                //var_dump($rtps_status);
                if (trim($rtps_status) !="y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #MRLQAPI00: Application not submitted case no # $case");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                    $errors = "Application (".$application_no.") Successfully Register & Forwarded to CO";
                    $this->session->set_flashdata('success', $errors);
                    redirect(base_url() .'index.php/RelinquishmentRegisterController/unRegisterRelinquishmentAppList');
                }

            }
        }
        else
        {
            $errors = "You are not Authorized for this process";
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/RelinquishmentRegisterController/viewUnRegisterCaseDetails?app='.$app);
        }

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



}