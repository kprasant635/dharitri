<?php



class SettlementManualController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('SettlementMb/SettlementMbADCModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementTribalAdcModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');

        if (HOLD_All_MB2_CASES_STATUS == 1) {
            if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

    }


    // update chitha dag flag
    public function updateBulkChithaDagFlagCaseWiseManual()
    {

        $user_desig_code = trim($this->session->userdata('user_desig_code'));
        $dist_code       = trim($this->session->userdata('dist_code'));
        $user_code       = trim($this->session->userdata('user_code'));
        $serviceCode     = 16;
        $userAccess      = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];

        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRCHU004437: You are not authorized for this process.! ',
            ]);
            return false;
        }
        if(CHITHA_DAG_FLAG_DIST_CODE != $dist_code)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRCHU004444: You are not authorized for this process.! ',
            ]);
            return false;
        }

        // all updated cases define in constants
        $allCases = CHITHA_FLAG_UPDATE_CASES;

        foreach ($allCases as $case)
        {
            $case_no = trim($case);
            $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
            if($caseCount == 0 || $caseCount == '')
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRCHU004453: Case No '.$case_no.' not found ! ',
                ]);
                return false;
            }

            $caseUpdateEn = $this->SettlementCommonModel->wetlandUpdateToDoByCase($case_no);
            $caseUpdate = json_decode($caseUpdateEn);

            if($caseUpdate->responseType != 2)
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => $caseUpdate->msg,
                ]);
                return false;
            }
        }


        echo json_encode([
            'responseType' => 2,
            'message' => 'All Chitha dag flag successfully updated',
        ]);
        return false;


    }


}
