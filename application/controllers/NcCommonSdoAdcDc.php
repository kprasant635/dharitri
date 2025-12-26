<?php

class NcCommonSdoAdcDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('NcModel/NcMeetingDcModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('NcModel/NcCommonSdoModel');
        $this->load->model('NcModel/NcCommonAdcModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('NcModel/NcPullModel');
        $this->load->model('UtilsModel');

        if(HOLD_All_MB3_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB3_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 3.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $allowed = ['DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

    }


    // NC code by Masud Reza (01/02/2024)

    //////////////// *************** **************** ////////////////




    // get Village name
    function NcVillageListCommon()
    {
        $subDiv = trim($this->input->post('subdiv_code'));
        $circle = trim($this->input->post('cir_code'));

        $villageName = $this->NcCommonSdoAdcDcModel->getVillageNameForNc($subDiv,$circle);

        echo json_encode(array(
            'responseType' => 1,
            'location'     => $villageName,
        ));
        return;
    }


    // application put under consideration DC/Adc/Sdo
    public function applicationPutUnderConsideration()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('reason', 'Consideration Reason', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('remark', 'Additional Note', 'trim|max_length[295]');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $case_no      = trim($this->input->post('caseNo'));
            $reason       = trim($this->input->post('reason'));
            $remark       = trim($this->input->post('remark'));
            $dist_code    = $this->session->userdata('dist_code');
            $userDesg     = $this->session->userdata('user_desig_code');
            $caseCount    = $this->NcCommonSdoAdcDcModel->countNcApplicationDetailsByCaseNoCommon($case_no,$dist_code);
            $caseDetails  = $this->NcCommonSdoAdcDcModel->getNcApplicationBasic($case_no);
            $service_code = trim($caseDetails['service_code']);

            if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRPULL000101: You are not authorized for this case # $case_no");
                redirect(base_url() . "index.php/home");
                return false;
            }

            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR02085: Application already send to SDLAC Committee ! Kindly contact system administrator',

                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR02094: Application not found ! Kindly contact system administrator',
                ));
                return;
            }
            else
            {

                $updateData = array(
                    'status'             => MB_UNDER_CONSIDERATION,
                    'dc_proceeding'      => 0,
                    'consideration_code' => $reason,
                    'consideration_note' => $remark,
                );


                $this->db->trans_begin();
                if($this->NcCommonSdoAdcDcModel->updateNcBasicDataDcAdcSdo($case_no,$dist_code,$service_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR02126: Updation failed in settlement_basic '. $this->db->last_query());
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => '#ERMR02126: Unable to process. Kindly contact system administrator !!!!',
                    ));
                    return;
                }
                else
                {

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
                        'status' => MB_UNDER_CONSIDERATION,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry'=> date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'note_on_order' => 'Under SDLAC Consideration',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => $userDesg,
                        'office_to' => $userDesg,
                        'task' => 'Under SDLAC Consideration'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERMR02164: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
                            'message'      => '#ERMR02164: Unable to process. Kindly contact system administrator !!!!',
                        ));
                        return;
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                        ));
                        return;
                    }
                    //////proceeding end//////
                }
            }
        }

    }


    // get SDLAC Committee
    public function getSdlacCommitteeCommon()
    {
        $userData  = $this->session->userdata;
        $dist_code = $userData['dist_code'];

        $memberDetails = $this->NcCommonSdoAdcDcModel->fetchSdlacMemberList($dist_code);
        $data['committeeCount'] = $memberDetails->num_rows();
        $data['committeeList']  = $memberDetails->result();

        $data['_view'] = 'NcVillageService/DcAdcSdoCommon/sdlac_committee_list_nc';

        $this->load->view('layouts/main', $data);
    }


    // set SDLAC Committee
    public function updateMemberPriority()
    {
        $sdlc_code = $this->input->post('user_code');
        $priority  = $this->input->post('priority');
        $dist_code = $this->session->userdata('dist_code');
        $this->db->trans_begin();
        if(isset($priority) && !empty($priority))
        {
            for ($i=0; $i < count($sdlc_code); $i++)
            {
                $updated = $this->NcCommonSdoAdcDcModel->updateSdlacComFlag($dist_code,$sdlc_code[$i],$priority[$i]);
                if($updated == 3){
                    echo json_encode(array(
                        'responseType' => 3,
                        'message' => "#ERROR0987: User details not found"
                    ));
                    return;
                }else if($updated == 0){
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'      => "#ERROR0988: Updated error,Something went wrong"
                    ));
                    return;
                }

            }
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType' => 2,
                'message'      => "Updated Successfully"
            ));
            return;
        }else{
            echo json_encode(array(
                'responseType' => 1,
                'message'      => "#ERROR0989: Priority already set"
            ));
            return;
        }


    }


    //insert new nominee of SDLAC/CDLAC Member`s
    public function insertNomineeDetailOfSdlacMember()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('sdlac_mem', 'SDLAC/CDLAC Member', 'trim|required');
        $this->form_validation->set_rules('nominee_name', 'Nominee Name', 'trim|required');
        $this->form_validation->set_rules('nominee_cont', 'Nominee Contact No', 'trim|required|max_length[10]|is_natural');
        $this->form_validation->set_rules('nominee_email', 'Nominee Email', 'trim|valid_email');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'      => 'Wrong data entered',
            ));
            return;
        }
        else
        {
            $created_at   = date('Y-m-d h:i:s');
            $updated_at   = date('Y-m-d h:i:s');
            $sdlac_mem    = $this->input->post('sdlac_mem');
            $nom_name     = $this->input->post('nominee_name');
            $nom_contact  = $this->input->post('nominee_cont');
            $nom_email    = $this->input->post('nominee_email');

            $insNominee = [
                'nominee_name'    => $nom_name,
                'district'        => $this->session->userdata('dist_code'),
                'sdlac_user_code' => $sdlac_mem,
                'email'           => $nom_email,
                'mobile_no'       => $nom_contact,
                'nominee_status'  => NOMINEE_STATUS_ENABLE,
                'nc'              => 1,
                'created_at'      => $created_at,
                'updated_at'      => $updated_at,
            ];
            $insert = $this->db->insert('sdlac_nominee_list', $insNominee);
            if($insert != 1 || $insert != true) {
                log_message('warning', '#ERROR4013: Insertion failed in sdlac_nominee_list '.
                    $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'      => '#ERROR4013: Something went wrong on adding nominee detail. 
                        Kindly contact system administrator',
                ));
                return;
            }

            echo json_encode(array(
                'responseType' => 2,
                'message'      => 'Nominee detail successfully added',
            ));
            return;
        }
    }


    // view SDLAC notice
    public function getProposalNotice()
    {
        $id = $this->input->get('case');
        $sql = "SELECT * from settlement_proposal_list WHERE id = ?";
        $result_row = $this->db->query($sql, $id)->row();

        if(!file_exists($result_row->file_path))
        {
            $parts = explode("uploads".UPLOAD_SEPARATOR, $result_row->file_path, 2);
            if (count($parts) > 1)
            {
                $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
            }
            else
            {
                $path = $result_row->file_path;
            }

            if(!file_exists($path))
            {
                $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
            }
            if(!file_exists($path))
            {
                return false;
            }
        }
        else
        {
            $path = $result_row->file_path;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file,filesize($path));
        fclose($open_notice_file);

        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file
        ];

        $data['_view'] = 'NcVillageService/DcAdcSdoCommon/sdlac_notice_print';

        $this->load->view('layouts/main',$data);
    }


    // download case list/Area details with proposal id
    public function downloadCasesWithProposalId()
    {
        $ProposalNo = trim($this->input->get('case'));
        $file_name  = time()."_proposal.xlsx";

        $data = $this->NcCommonSdoAdcDcModel->getAllProCaseForDownload($ProposalNo);

        $this->UtilsModel->downloadExcelReport($file_name,$data);

    }


    // application revert to co from proposal list
    public function applicationRemoveFromProposal()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applicationNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('proCaseId', 'Proposal Case Id', 'trim|required');
        $this->form_validation->set_rules('selectProposalId', 'Proposal No', 'trim|required');
        $this->form_validation->set_rules('revertRemarks', 'Revert Remarks', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $proposalCaseId  = trim($this->input->post('proCaseId'));
            $revertRemarks   = trim($this->input->post('revertRemarks'));
            $case_no         = trim($this->input->post('applicationNo'));
            $proposalId      = trim($this->input->post('selectProposalId'));
            $dist_code       = $this->session->userdata('dist_code');
            $user_code       = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');

            if($this->NcCommonSdoAdcDcModel->countSettlementProposalList($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002249: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002257: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002265: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
            if($caseDetails->status != MB_SEND_TO_SDLAC)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002275: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }

            // proposal in meeting or not
            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id != '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002286: Proposal already assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->NcCommonSdoAdcDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
            if($deleteCase->id != $proposalCaseId)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002296: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $this->db->trans_begin();

            $checkReqMod = 0;
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->NcPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0001177: Case not found in Modification Request  ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $user_code,
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002318: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002318: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->NcCommonSdoAdcDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002334: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002334: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'pull_request'    => 0,

            );
            if($this->NcCommonSdoAdcDcModel->updateNcBasicDataDcAdcSdo($case_no,$dist_code,$caseDetails->service_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002353: Updation failed in settlement_basic for case no :'. $case_no .' error:'. $this->db->last_query());
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002353: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }
            else
            {
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
                    'status'      => MB_REVERT,
                    'user_code'   => $user_code,
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $user_desig_code,
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002390: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR002390: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->where('nc',1);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRPULL002400: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002400:  Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $revertRemarks,
                            'status'               => 'MR',
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002470: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002470: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = $caseDetails->applid;
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $user_desig_code;
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;
                    $rtps_status = $this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI002411: Reverted failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        echo json_encode(array(
                            'responseType' => 2,
                            'message'  => 'Application Successfully Reverted to CO',

                        ));
                        return;
                    }


                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message'  => 'Application Successfully Reverted to CO',

                    ));
                    return;

                }
            }
        }
    }


    // application revert to co from proposal list
    public function applicationRemoveFromRevertedProposal()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applicationNo', 'Case Number', 'trim|required');
        $this->form_validation->set_rules('proCaseId', 'Proposal Case Id', 'trim|required');
        $this->form_validation->set_rules('selectProposalId', 'Proposal No', 'trim|required');
        $this->form_validation->set_rules('revertRemarks', 'Revert Remarks', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => $error,
            ));
            return;
        }
        else
        {
            $proposalCaseId  = trim($this->input->post('proCaseId'));
            $revertRemarks   = trim($this->input->post('revertRemarks'));
            $case_no         = trim($this->input->post('applicationNo'));
            $proposalId      = trim($this->input->post('selectProposalId'));
            $dist_code       = $this->session->userdata('dist_code');
            $user_code       = trim($this->session->userdata('user_code'));
            $user_desig_code = trim($this->session->userdata('user_desig_code'));

            if($this->NcCommonSdoAdcDcModel->countSettlementProposalList($proposalId) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002443: Application not found in proposal ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002451: Application not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002459: Application not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
            if($caseDetails->status != MB_REVERT)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002469: Application already Processed ! Kindly contact system administrator',
                ));
                return;
            }
            $checkReqMod = 0;
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->NcPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002572: Case not found in Modification Request ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            // proposal in meeting or not
            $proposalDetails = $this->NcCommonSdoAdcDcModel->getProposalDetailsByProId($proposalId);
            if($proposalDetails->proposal_meeting_id == '')
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002480: Proposal not assigned with meeting ! Kindly contact system administrator',
                ));
                return;
            }

            $deleteCase = $this->NcCommonSdoAdcDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
            if($deleteCase->id != $proposalCaseId)
            {
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002490: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $this->db->trans_begin();
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $user_code,
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002512: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002512: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $deleteProCase = $this->NcCommonSdoAdcDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERMR002525: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002525: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->NcCommonSdoAdcDcModel->updateNcBasicDataDcAdcSdo($case_no,$dist_code,$caseDetails->service_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR002547: Application unable to Revert ! Kindly contact system administrator',

                ));
                return;
            }
            else
            {
                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if($proceeding_id==null)
                {
                    $proceeding_id=1;
                }
                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id'   => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'status'      => MB_REVERT,
                    'user_code'   => $user_code,
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $user_desig_code,
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR002584: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR002584: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1)
                        {
                            log_message('error', '#MRPULL002713: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002713:  Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order' => $revertRemarks,
                            'status'        => 'MR',
                            'user_code'     => $user_code,
                            'date_entry'    => date('Y-m-d h:i:s'),
                            'operation'     => 'E',
                            'ip'            => $this->utilityclass->get_client_ip(),
                            'office_from'   => $user_desig_code,
                            'office_to'     => MB_CIRCLE_OFFICER,
                            'task'          => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002741: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002741: Application unable to Revert ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }

                    $application_no = trim($caseDetails->applid);
                    $rmk    = 'Reverted to CO';
                    $status = 'M';
                    $task   = $user_desig_code;
                    $pen    = MB_CIRCLE_OFFICER;
                    $case   = $case_no;
                    $rtps_status = $this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                    if(trim($rtps_status)!="y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #MRAPI002621: Reverted failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }

                    $this->db->trans_commit();
                    echo json_encode(array(
                        'responseType' => 2,
                        'message'  => 'Application Successfully Reverted to CO',

                    ));
                    return;
                }
            }
        }
    }



    // Bulk Revert cases from reverted meeting
    public function bulkRevertCasesInRevertedMeeting()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $revertBulkPull   = $this->input->post('revertBulkPull');
        $revertBulkChitha = $this->input->post('revertBulkChitha');
        $dist_code        = $this->session->userdata('dist_code');
        $user_code        = $this->session->userdata('user_code');
        $user_desig_code  = $this->session->userdata('user_desig_code');
        $arrayM = array_unique(array_merge($revertBulkPull,$revertBulkChitha));

        if (empty($arrayM))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRBR0003846: Revert request cancelled...! cases missing ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $row_count = 0;
        foreach ($arrayM as $arrayS)
        {
            $case_no = $arrayS;
            $row_count++;
            $tmp_st_time = microtime(true);
            if($this->NcCommonSdoAdcDcModel->countSettlementProposalPendingCaseByCaseNo($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003859: Application ('.$case_no.') not found in Proposal Cases ! Kindly contact system administrator',
                ));
                return;
            }
            if($this->NcCommonSdoAdcDcModel->countSettlementAppDetailsByCaseNo($case_no) != 1)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003867: Application ('.$case_no.') not found ! Kindly contact system administrator',
                ));
                return;
            }

            $caseDetails = $this->NcCommonSdoAdcDcModel->getNcBasicDetails($case_no);
            if($caseDetails->status != MB_REVERT)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003882: Application ('.$case_no.') already Processed ! Kindly contact system administrator',
                ));
                return;
            }

            if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#ERMR090909: You cannot Revert application ('.$case_no.') here ! Kindly contact system administrator',
                ));
                return false;
            }

            $getProposalID = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
            $proposalId    = trim($getProposalID->proposal_id);
            $checkReqMod   = 0;
            $revertRemarks = '';
            if($caseDetails->pull_request != 0)
            {
                $revertRemarks = 'Reverted as requested by CO for Modification';
            }
            else
            {
                $revertRemarks = 'Reverted as settlement area is exceeding Chitha area ';
            }
            if($caseDetails->pull_request != 0)
            {
                $requested = $this->NcPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$caseDetails->service_code);
                if($requested->num_rows() == 0)
                {
                    $checkReqMod = 0;
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRBR0003909: Application ('.$case_no.') not found in Modification Request ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $requestedData = $requested->row();
                $checkReqMod   = 1;
            }

            $deleteCase = $this->NcCommonSdoAdcDcModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
            $insertIntoDeletedTable = array(
                'proposal_id' => $proposalId,
                'case_no'     => $deleteCase->case_no,
                'status'      => $deleteCase->status,
                'ip'          => $deleteCase->ip,
                'created_at'  => $deleteCase->created_at,
                'updated_at'  => $deleteCase->updated_at,
                'co_submit'   => $deleteCase->co_submit,
                'deleted_by'  => $this->session->userdata('user_code'),
            );

            $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
            if($insertDeleteData != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRBR0003933: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003933: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                ));
                return;
            }
            $deleteProCase = $this->NcCommonSdoAdcDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
            if($deleteProCase != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRBR0003945: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003945: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }

            $updateData = array(
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $this->session->userdata('user_desig_code'),
                'dc_proceeding'   => 0,
                'pull_request'    => 0,
            );
            if($this->NcCommonSdoAdcDcModel->updateNcBasicDataDcAdcSdo($case_no,$dist_code,$caseDetails->service_code,$updateData)== 0)
            {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'responseType' => 1,
                    'message'  => '#MRBR0003966: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                ));
                return false;
            }
            else
            {
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
                    'status'      => MB_REVERT,
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => $this->session->userdata('user_desig_code'),
                    'office_to'   => MB_CIRCLE_OFFICER,
                    'task'        => 'Reverted to CO',
                    'note_on_order' => $revertRemarks
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if($insertProceeding != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MRBR0003996: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#MRBR0003996: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',

                    ));
                    return;
                }
                else
                {
                    if($checkReqMod == 1)
                    {
                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $revertRemarks,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$requestedData->id);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRBR0004027: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0004027:  Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order' => $revertRemarks,
                            'status'        => 'MR',
                            'user_code'     => $this->session->userdata('user_code'),
                            'date_entry'    => date('Y-m-d h:i:s'),
                            'operation'     => 'E',
                            'ip'            => $this->utilityclass->get_client_ip(),
                            'office_from'   => $user_desig_code,
                            'office_to'     => MB_CIRCLE_OFFICER,
                            'task'          => 'Modification Request Accepted'
                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRBR0004051: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRBR0004051: Reverted failed case no #'. $case_no.' ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                    }
                }
            }
            log_message('error','Time taken: '.(microtime(true)-$tmp_st_time).', count='.$row_count);
        }

        if (isset($arrayM) && count($arrayM)>0)
        {
            $caseAppUrban = $this->NcCommonSdoAdcDcModel->convertLiteral($arrayM);
            $caseAppUrbanSql = "select string_agg(applid,',') as applids from settlement_basic where case_no in ($caseAppUrban)";
            $allAPICasesUrbanIds = $this->db->query($caseAppUrbanSql)->row()->applids;

            $rmk    = 'Reverted to CO';
            $status = 'M';
            $task   = $this->session->userdata('user_desig_code');
            $pen    = MB_CIRCLE_OFFICER;
            $rtps_status=$this->NcApiModel->applicationStatusUpdateBulk($allAPICasesUrbanIds,'NA',$rmk,$status,$task,$pen);
            if($rtps_status!="y")
            {
                $this->db->trans_rollback();
                log_message('error', '#MRAPI104213: Issue in API Call'
                    .$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 3,
                    'message'      => '#MRAPI104213: Unable to process for final approval.
                                               Kindly contact system administration !!!',
                ));
                return;
            }
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'responseType' => 2,
            'message'  => 'Application Successfully Reverted to CO',
        ));
        return false;


    }






    // decode for showing file
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


    // view Digital Minutes
    public function getDigitalMinutesWithMeetingId()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->encode_pdf_dir_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->encode_pdf_dir_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->encode_pdf_dir_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->encode_pdf_dir_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    return false;
                }
            }
            else
            {
                $path = $meetingDetails->encode_pdf_dir_path;
            }
            $mainfile = file_get_contents($meetingDetails->encode_pdf_dir_path);
            $conType  = mime_content_type($meetingDetails->encode_pdf_dir_path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // view SDLAC Uploaded Minute
    public function viewSdlacUploadedMinute()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->file_minute_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->file_minute_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_minute_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_minute_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    return false;
                }
            }
            else
            {
                $path = $meetingDetails->file_minute_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);
            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }


    // view SDLAC Attendance
    public function viewSdlacAttendance()
    {
        $meetingId = trim($this->input->get('meetingId'));
        $meetingDetails = $this->NcMeetingDcModel->getPendingMeetingDetailByMeetingID($meetingId)->row();

        if($meetingDetails->file_attendance_path == '')
        {
            die("Unable to open file !");
        }
        else
        {

            if(!file_exists($meetingDetails->file_attendance_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->file_attendance_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->file_attendance_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    return false;
                }
            }
            else
            {
                $path = $meetingDetails->file_attendance_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }





}