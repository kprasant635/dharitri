<?php
class Mb3CommonController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mb3CommonModel');
    }

    public function getSelfDocApi(){

        $case_no = $this->input->post('case_no');

        $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
        $basundhara = $this->db->query($sql)->row();
        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
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
        $lmdata['document']=$output->documents;
        $lmdata['query']=$output->query;
        $lmdata['property']=$output->property;
        $lmdata['aadhar']=$output->aadhar;
        $lmdata['nextKin']=$output->nextKin;
        // $selfDeclarationDetails=[];
        foreach($output->selfDeclaration as $selfDec){
            // $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            $selfDeclarationDetails=json_decode($selfDec->dec_details);
        }
        if($output){
            $data = array(
                'responseType' => 2,
                'selfDeclarationDetails' => $selfDeclarationDetails,
                'document' => $output->documents,
                'aadhar' => $output->aadhar
            );
            echo json_encode($data);
        }
        else {
            $data = array(
                'responseType' => 0,
                'msg' => "#LMRPT006887: Case not found against case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }
    }


    // Mark as SDLAC ADC
    public function markApplicationForSDLAC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('caseNo', 'Case Number', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
            ));
            return;
        }
        else
        {
            $this->db->trans_begin();
            $case_no             = $this->input->post('caseNo');
            $dist_code           = $this->session->userdata('dist_code');
            $user_code           = $this->session->userdata('user_code');
            $this->utilityclass->checkUserAuthForCaseForAdc($case_no);
            $modificationRequest = $this->Mb3CommonModel->checkCaseInModificationRequestWithSession($case_no);
            if($modificationRequest == 1)
            {
                echo json_encode(array(
                    'responseType' => 101,
                    'response'     => 101,
                    'message'      => '#MRPULL00101 : There is a Modification request from CO for this case ',
                ));
                return false;
            }
            $caseCount           = $this->Mb3CommonModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $caseIdSdlacProposal = $this->Mb3CommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            $checkArea           = $this->Mb3CommonModel->chithaReserveAreaCheckWithCaseNo($case_no);
            if($checkArea != 0)
            {
                echo json_encode(array(
                    'responseType' => 10,
                ));
                return;
            }
            if($caseIdSdlacProposal != 0)
            {
                echo json_encode(array(
                    'responseType' => 9,
                ));
                return;
            }
            if($caseCount == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                ));
                return;
            }
            else
            {
                $wedLandStatus = $this->Mb3CommonModel->caseUnderDeptOrDCByWetLand($case_no);
                if($wedLandStatus == 1)
                {
                    $updateData = array(
                        'is_wed_land'   => 1,
                        'approve_by'    => 'GOVT',
                        'status'        => MB_MARK_AS_SDLAC,
                        'dc_code'       => $user_code,
                        'dc_proceeding' => 1,
                    );
                }
                else
                {
                    $updateData = array(
                        'status'  => MB_MARK_AS_SDLAC,
                        'dc_code' => $user_code,
                        'dc_proceeding' => 1,
                    );
                }

                if($this->Mb3CommonModel->updateSettlementBasicData($case_no,$dist_code,$updateData)== 0)
                {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'responseType' => 1,
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
                        'case_no'              => $case_no,
                        'proceeding_id'        => $proceeding_id,
                        'date_of_hearing'      => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'status'               => MB_MARK_AS_SDLAC,
                        'user_code'            => $this->session->userdata('user_code'),
                        'date_entry'           => date('Y-m-d h:i:s'),
                        'operation'            => 'E',
                        'note_on_order'        => 'Recommended for SDLAC',
                        'ip'                   => $this->utilityclass->get_client_ip(),
                        'office_from'          => MB_ADD_DEPUTY_COMM,
                        'office_to'            => MB_ADD_DEPUTY_COMM,
                        'task'                 => 'Recommended for SDLAC'
                    ];
                    $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                    if($insertProceeding != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MR00891: Insertion failed in settlement_proceeding for case no :'. $case_no);
                        echo json_encode(array(
                            'responseType' => 1,
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

}
