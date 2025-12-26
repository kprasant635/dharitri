<?php
class OfflineSettlementRegisterController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->load->model('OfflineSettlementModel/OfflineCommonModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->offlineutility->dbSwitchSession();


    }


    //// ******************* 17-04-2024 / Masud Reza *************************


    //// ******************* Online Settlement Application Register  *************************


    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }


    // application register view page
    public function registerOfflineCaseCommonKhas()
    {
        $dist_code   = $this->session->userdata('dist_code');
        $this->offlineutility->checkUserAccessForOnlineProcessCommon();
        $this->offlineutility->checkUserAccessForOnlineRegistration();
        $allDistrict = $this->UtilsModel->getAllDistrictList();
        $allSubDist  = $this->UtilsModel->getAllSubDivName($dist_code);


        $applicationCount = 1;

        $data['dist_code']         = $dist_code;
        $data['districts']         = $allDistrict;
        $data['subDistricts']      = $allSubDist;
        $data['applicationCount']  = $applicationCount;
        $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();


        $data['_view'] = 'OfflineSettlement/Common/register_offline_settlement_case_khas';
        $this->load->view('layouts/main', $data);

    }


    // get Mouza list
    public function getMouzaList()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dis', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir', 'Circle', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MROSK0001: There is some problem. Kindly contact system administrator',

            ));
            return;
        }

        $data   = [];
        $dis    = trim($this->input->post('dis'));
        $subdiv = trim($this->input->post('subdiv'));
        $cir    = trim($this->input->post('cir'));

        $this->session->set_userdata('cir_code',$cir);
        $allMouza = $this->UtilsModel->getMouzaList($dis,$subdiv,$cir);

        $data['test'] = $allMouza;

        echo json_encode($data);
    }


    // get village list
    public function getVillageList()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dis', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mza', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot', 'Lot', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MROSA0001: There is some problem. Kindly contact system administrator',

            ));
            return;
        }

        $data   = [];
        $dis    = trim($this->input->post('dis'));
        $subdiv = trim($this->input->post('subdiv'));
        $cir    = trim($this->input->post('cir'));
        $mza    = trim($this->input->post('mza'));
        $lot    = trim($this->input->post('lot'));

        $this->session->set_userdata('lot_no',$lot);
        $allVillage = $this->UtilsModel->getVillageList($dis,$subdiv,$cir,$mza,$lot);
        $data['test'] = $allVillage;

        echo json_encode($data);
    }


    // get Dag list
    public function getDagList()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dis', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mza', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill', 'Village', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MROSA0002: There is some problem. Kindly contact system administrator',

            ));
            return;
        }
        $data   = [];
        $dis    = trim($this->input->post('dis'));
        $subdiv = trim($this->input->post('subdiv'));
        $cir    = trim($this->input->post('cir'));
        $mza    = trim($this->input->post('mza'));
        $lot    = trim($this->input->post('lot'));
        $vill   = trim($this->input->post('vill'));

        // $dagList = $this->UtilsModel->getDagList($dis,$subdiv,$cir,$mza,$lot,$vill);

        $q = "select dag_no, dag_no_int from   chitha_basic where
            dist_code=? and subdiv_code=? and
            cir_code=? and mouza_pargona_code=? and lot_no=?
            and vill_townprt_code=? and patta_type_code in (Select type_code from patta_code where jamabandi='n')
            and patta_no='0' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
        $sqlData = $this->db->query($q,array($dis,$subdiv,$cir,$mza,$lot,$vill));
        $dagList = $sqlData->result();

        $data['test'] = $dagList;

        echo json_encode($data);
    }


    // get area details
    public function getAreaDetails()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dis', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mza', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill', 'Village', 'trim|required');
        $this->form_validation->set_rules('dag', 'Dag', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MROSA0003: There is some problem. Kindly contact system administrator',

            ));
            return;
        }
        $data   = [];
        $dis    = trim($this->input->post('dis'));
        $subdiv = trim($this->input->post('subdiv'));
        $cir    = trim($this->input->post('cir'));
        $mza    = trim($this->input->post('mza'));
        $lot    = trim($this->input->post('lot'));
        $vill   = trim($this->input->post('vill'));
        $dag_no = trim($this->input->post('dag'));

        $this->session->set_userdata('dist_code',$dis);

        $data = $this->UtilsModel->getAreaDetail($dis,$subdiv,$cir,$mza,$lot,$vill,$dag_no);
        $temp = $data[0]->land_class_code;
        $land_type = $this->UtilsModel->getLandTypeName($temp);
        $land_type_present = $this->UtilsModel->getLandTypePresent($temp);

        $json = array();
        foreach ($data as $object)
        {
            $json = array(
                'bigha'             => trim($object->dag_area_b),
                'katha'             => trim($object->dag_area_k),
                'lessa'             => trim($object->dag_area_lc),
                'ganda'             => trim($object->dag_area_g),
                'kranti'            => trim($object->dag_area_kr),
                'land_type'         => trim($land_type->land_type),
                'land_code'         => trim($land_type->class_code),
                'patta_type_code'   => trim($object->patta_type_code),
                'patta_no'          => trim($object->patta_no),
                'land_type_present' => $land_type_present
            );
        }
        echo json_encode($json);
    }


    // get pattadar details
    public function getAllPattadarInDag()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dis', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mza', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill', 'Village', 'trim|required');
        $this->form_validation->set_rules('dag', 'Dag', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode(array(
                'responseType' => 1,
                'message'  => '#MROSA0003: There is some problem. Kindly contact system administrator',

            ));
            return;
        }
        $data       = [];
        $dis        = trim($this->input->post('dis'));
        $subdiv     = trim($this->input->post('subdiv'));
        $cir        = trim($this->input->post('cir'));
        $mza        = trim($this->input->post('mza'));
        $lot        = trim($this->input->post('lot'));
        $vill       = trim($this->input->post('vill'));
        $dag_no_int = trim($this->input->post('dag'));
        $this->session->set_userdata('dist_code',$dis);

        $patta_result = $this->UtilsModel->getChithaPattaDetails($dis, $subdiv, $cir, $mza,$lot, $vill, $dag_no_int);
        if (!count($patta_result))
        {
            echo "";
            return;
        }
        $patta_no = $patta_result[0]->patta_no;
        $patta_type_code = $patta_result[0]->patta_type_code;
        $dag_no = $patta_result[0]->dag_no;

        // $data = $this->UtilsModel->getChithaPattadarList($dis,$subdiv,$cir,$mza,$lot,$vill,$patta_type_code,trim($patta_no)
        //            ,$dis,$subdiv,$cir,$mza,$lot,$vill,$patta_type_code,trim($patta_no),$dag_no);

        $data = $this->UtilsModel->getChithaPattadarListFromLandBank($dis,$subdiv,$cir,$mza,$lot,$vill,$dag_no);


        echo json_encode($data);
    }



    // submit application
    public function submitOfflineApplicationKhas()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub-division', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza', 'trim|required');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village', 'trim|required');

        $this->form_validation->set_rules('dag_no', 'Dag Number', 'trim|required');
        $this->form_validation->set_rules('land_code', 'Land Code ', 'trim|required');
        $this->form_validation->set_rules('land_type', 'Land Type', 'trim|required');
        $this->form_validation->set_rules('nature_of_land', 'Nature of Land', 'trim|required');
        $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');


        $this->form_validation->set_rules('typeOfHouse', 'Type of House', 'trim|required|xss_clean');
        $this->form_validation->set_rules('natureOfPossession', 'Period & Nature of Possession', 'trim|required|xss_clean');
        $this->form_validation->set_rules('checklistSubmitted', 'Checklist Submitted', 'trim|required|xss_clean');
        $this->form_validation->set_rules('landPolicy', 'Whether eligible as per Clause 14.4 of Land Policy', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sdlacRecommendation', 'Sdlac/Cdlac Recommendation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sdlacRecommendationDate', 'Sdlac/Cdlac Recommendation Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('recommendation', 'Accepted / Recommendation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zonalValue', 'Zonal valuation', 'trim|required|xss_clean|greater_than[-1]');
        $this->form_validation->set_rules('premium', 'Rate of premium', 'trim|required|greater_than[-1]');
        $this->form_validation->set_rules('concession', 'Concession', 'trim|xss_clean|max_length[299]');

        $applyFor = trim($this->input->post('applyFor'));
        $distCode = $this->session->userdata('dist_code');
        if($applyFor == 'individual')
        {
            $nature_of_land = trim($this->input->post('nature_of_land'));
        }
        elseif($applyFor == 'institution')
        {
            $nature_of_land = HOMESTEAD;
            $this->form_validation->set_rules('newLandClass', 'Application Apply for ', 'required|trim|xss_clean');
            $this->form_validation->set_rules('proposedLandClass', 'Category of the Proposed Land Class ', 'required|trim|xss_clean');
            $this->form_validation->set_rules('institutionName', 'Name of the Institution ', 'required|trim|xss_clean');
            $this->form_validation->set_rules('departmentName', 'Department Name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('directorateName', 'Directorate Name ', 'required|trim|xss_clean');
            $this->form_validation->set_rules('entityOf', 'Entity of ', 'required|trim|xss_clean');
        }
        else
        {
            $errors = '#MROFK000-1: Application Apply for is missing !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        $appAreaMoreThanDagA     = 0;
        $dagAreaLessaValidation  = 0;
        $homeAreaLessaValidation = 0;
        $agrAreaLessaValidation  = 0;

        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $this->form_validation->set_rules('dag_area_b', 'Total Chitha Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Chitha Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Chitha Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('dag_area_g', 'Total Chitha Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_lc'), 0);
            $gandaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_g'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;

            if($nature_of_land == HOMESTEAD)
            {
                $this->form_validation->set_rules('hBigha', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('hKathaBarak', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('hLessa', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('hGanda', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
                $kathaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKathaBarak'), 0);
                $lessaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);
                $gandaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hGanda'), 0);

                $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                if($homeAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total applied Homestead area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $homeAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_HOMESTEAD * 6400 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
            }
            elseif ($nature_of_land == AGRICULTURAL)
            {
                $this->form_validation->set_rules('aBigha', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('aKathaBarak', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('aLessa', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('aGanda', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
                $kathaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKathaBarak'), 0);
                $lessaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);
                $gandaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aGanda'), 0);

                $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
                if($agrAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total applied Agriculture area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $agrAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 6400 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }
            else
            {
                $this->form_validation->set_rules('hBigha', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('hKathaBarak', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('hLessa', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('hGanda', 'Total applied Area Home (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('aBigha', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('aKathaBarak', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('aLessa', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('aGanda', 'Total applied Area Agriculture (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
                $kathaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKathaBarak'), 0);
                $lessaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);
                $gandaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hGanda'), 0);
                $bighaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
                $kathaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKathaBarak'), 0);
                $lessaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);
                $gandaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aGanda'), 0);

                $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
                $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                if($agrAreaLessaValidation + $homeAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total Applied (Homestead + Agriculture) area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_HOMESTEAD * 6400 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 6400 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }
        }
        else
        {
            $this->form_validation->set_rules('dag_area_b', 'Total Chitha Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Chitha Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Chitha Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_lc'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;

            if($nature_of_land == HOMESTEAD)
            {
                $this->form_validation->set_rules('hBigha', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('hKatha', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('hLessa', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
                $kathaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKatha'), 0);
                $lessaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);

                $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;

                if($homeAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total applied Homestead area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $homeAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_HOMESTEAD * 100 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
            }
            elseif ($nature_of_land == AGRICULTURAL)
            {
                $this->form_validation->set_rules('aBigha', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('aKatha', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('aLessa', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
                $kathaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKatha'), 0);
                $lessaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);

                $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                if($agrAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total applied Agriculture area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $agrAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 100 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }
            else
            {
                $this->form_validation->set_rules('hBigha', 'Total applied Area Home (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('hKatha', 'Total applied Area Home (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('hLessa', 'Total applied Area Home (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $this->form_validation->set_rules('aBigha', 'Total applied Area Agriculture (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('aKatha', 'Total applied Area Agriculture (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('aLessa', 'Total applied Area Agriculture (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
                $kathaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKatha'), 0);
                $lessaValidationHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);
                $bighaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
                $kathaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKatha'), 0);
                $lessaValidationAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);

                $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                if($agrAreaLessaValidation + $homeAreaLessaValidation == 0)
                {
                    $this->form_validation->set_rules('appliedAreaZero','Total Applied (Homestead + Agriculture) area should not be Zero ', 'required');
                }
                if ($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }
                if (OFFLINE_KHAS_MAX_HOMESTEAD * 100 < $homeAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Homestead area should not be more than ' . OFFLINE_KHAS_MAX_HOMESTEAD . ' Bigha !', 'required');
                }
                if (OFFLINE_KHAS_MAX_AGRICULTURE * 100 < $agrAreaLessaValidation)
                {
                    $this->form_validation->set_rules('maxArea','Total applied Agriculture area should not be more than ' . OFFLINE_KHAS_MAX_AGRICULTURE . ' Bigha !', 'required');
                }
            }
        }

        // chitha Area Zero
        if($dagAreaLessaValidation == 0)
        {
            $this->form_validation->set_rules('chithaAreaZero','Total Chitha area can not be Zero ', 'required');
        }

        // Applied area more than chitha Area
        if($appAreaMoreThanDagA == 1)
        {
            $this->form_validation->set_rules('appliedAreaZero','Total Applied area should not be more than Chitha area ', 'required');
        }


        $this->form_validation->set_rules('applicantNameEng', 'Applicant name in English', 'required|trim|xss_clean|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('applicantNameAss', 'Applicant name in Assamese', 'required|trim|xss_clean|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('guardNameEng', 'Guardian name in english', 'required|trim|xss_clean|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('guardNameAss', 'Guardian name in assamese', 'required|trim|xss_clean|min_length[2]|max_length[70]');
        $this->form_validation->set_rules('guardianRelation', 'Guardian Relation', 'required|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('mobileNo', 'Mobile No', 'required|min_length[10]|max_length[10]|xss_clean');

        if($applyFor == 'individual')
        {
            $this->form_validation->set_rules('dob', 'Date of birth', 'required|trim|xss_clean');
            $this->form_validation->set_rules('castCategory', 'Community', 'required|trim|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('maritalStatus', 'Marital Status', 'required|trim|xss_clean');
            $castCategory = trim($this->input->post('castCategory'));
            if($castCategory == 6)
            {
                $this->form_validation->set_rules('protectedCategory', 'Fall Under Protected Category', 'trim|xss_clean');

            }
        }


        $this->form_validation->set_rules('address1', 'Present Address', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('city1', 'Present City', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('district1', 'Present District', 'trim|required');
        $this->form_validation->set_rules('pinCode1', 'Present Pin Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('address2', 'Permanent Address', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('city2', 'Permanent City', 'trim|required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('district2', 'Permanent District', 'trim|required');
        $this->form_validation->set_rules('pinCode2', 'Permanent Pin Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('remarks', 'Upload File', 'trim||max_length[4000]');

        $maritalStatus = trim($this->input->post('maritalStatus'));



        // validation for file type and file size
        $masterKeyFile = array();
        foreach ($_FILES as $key=>$val)
        {
            $masterKeyFile[] = $key;
        }
        $fileCount = trim($this->input->post('fileCounter'));
        $validation = array();
        for($i = 1; $i <= $fileCount; $i++)
        {
            $indexFile = 'uploadFile'.$i;
            if(!in_array($indexFile,$masterKeyFile))
            {
                continue;
            }
            if($this->input->post('document'.$i) == null || $this->input->post('document'.$i) == '')
            {
                $this->form_validation->set_rules('fileError', 'Document'.$i. ' Title is missing', 'required');
            }
            if($this->input->post('uploadFile'.$i) != 'undefined')
            {
                $name = $_FILES['uploadFile'.$i]['name'];
                $size = $_FILES['uploadFile'.$i]['size'];

                $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];

                if($name != NULL)
                {
                    if($ext == NULL)
                    {
                        $this->form_validation->set_rules('fileError', 'uploadFile'.$i. ' File extension required', 'required');
                    }
                    if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                    {
                        $this->form_validation->set_rules('fileError', 'uploadFile'.$i. ' Only JPG/PNG/PDF file', 'required');
                    }
                    if($size > UPLOAD_MAX_SIZE)
                    {
                        $this->form_validation->set_rules('fileError', 'uploadFile'.$i. ' Maximum 2MB file size', 'required');
                    }
                }
                else
                {
                    $this->form_validation->set_rules('fileError', 'uploadFile'.$i. ' File Name Required', 'required');

                }
            }
            else
            {
                $this->form_validation->set_rules('fileError', 'Document'.$i. ' Title is missing', 'required');
            }
        }



        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $dist_code   = $this->session->userdata('dist_code');
            $this->offlineutility->checkUserAccessForOnlineRegistration();
            $allDistrict = $this->UtilsModel->getAllDistrictList();
            $allSubDist  = $this->UtilsModel->getAllSubDivName($dist_code);

            $applicationCount = 1;

            $data['error']             = $errors;
            $data['dist_code']         = $dist_code;
            $data['districts']         = $allDistrict;
            $data['subDistricts']      = $allSubDist;
            $data['applicationCount']  = $applicationCount;
            $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();
//             redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
            $data['_view'] = 'OfflineSettlement/Common/register_offline_settlement_case_khas';
            $this->load->view('layouts/main', $data);
            return false;
        }



        $this->offlineutility->checkUserAccessForOnlineRegistration();
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $bighaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_lc'), 0);
            $gandaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_g'), 0);
            $bighaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
            $kathaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKathaBarak'), 0);
            $lessaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);
            $gandaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hGanda'), 0);
            $bighaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
            $kathaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKathaBarak'), 0);
            $lessaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);
            $gandaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aGanda'), 0);
        }
        else
        {
            $bighaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaDag  = $this->OfflineCommonModel->defaultValue($this->input->post('dag_area_lc'), 0);
            $gandaDag  = 0;
            $bighaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hBigha'), 0);
            $kathaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hKatha'), 0);
            $lessaHome = $this->OfflineCommonModel->defaultValue($this->input->post('hLessa'), 0);
            $gandaHome = 0;
            $bighaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aBigha'), 0);
            $kathaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aKatha'), 0);
            $lessaAgr  = $this->OfflineCommonModel->defaultValue($this->input->post('aLessa'), 0);
            $gandaAgr  = 0;
        }

        if($applyFor == 'individual')
        {
            $dob                       = trim($this->input->post('dob'));
            $castCategory              = trim($this->input->post('castCategory'));
            $protectedCategory         = trim($this->input->post('protectedCategory'));
            $maritalStatus             = trim($this->input->post('maritalStatus'));
            $applicantNameEng_spouse   = trim($this->input->post('applicantNameEng_spouse'));
            $applicantNameAss_spouse   = trim($this->input->post('applicantNameAss_spouse'));
            $guardNameEng_spouse       = trim($this->input->post('guardNameEng_spouse'));
            $guardNameAss_spouse       = trim($this->input->post('guardNameAss_spouse'));
            $guardianRelation_spouse   = trim($this->input->post('guardianRelation_spouse'));
            $gender_spouse             = trim($this->input->post('gender_spouse'));
            $dob_spouse                = trim($this->input->post('dob_spouse'));
            $mobileNo_spouse           = trim($this->input->post('mobileNo_spouse'));
            $castCategory_spouse       = trim($this->input->post('castCategory_spouse'));
            $protectedCategory_spouse  = trim($this->input->post('protectedCategory_spouse'));

            $newLandClass              = 0;
            $proposedLandClass         = 0;
            $institutionName           = '';
            $departmentName            = '';
            $directorateName           = '';
            $entityOf                  = '';
        }
        if($applyFor == 'institution')
        {
            $newLandClass              = trim($this->input->post('newLandClass'));
            $proposedLandClass         = trim($this->input->post('proposedLandClass'));
            $institutionName           = trim($this->input->post('institutionName'));
            $departmentName            = trim($this->input->post('departmentName'));
            $directorateName           = trim($this->input->post('directorateName'));
            $entityOf                  = trim($this->input->post('entityOf'));
            $dob                       = '';
            $castCategory              = 0;
            $protectedCategory         = 0;
            $maritalStatus             = 0;
            $applicantNameEng_spouse   = '';
            $applicantNameAss_spouse   = '';
            $guardNameEng_spouse       = '';
            $guardNameAss_spouse       = '';
            $guardianRelation_spouse   = '';
            $gender_spouse             = '';
            $dob_spouse                = '';
            $mobileNo_spouse           = '';
            $castCategory_spouse       = 0;
            $protectedCategory_spouse  = '';
        }

        $dist_code                 = trim($this->input->post('dist_code'));
        $subdiv_code               = trim($this->input->post('subdiv_code'));
        $cir_code                  = trim($this->input->post('cir_code'));
        $mouza_pargona_code        = trim($this->input->post('mouza_pargona_code'));
        $lot_no                    = trim($this->input->post('lot_no'));
        $vill_townprt_code         = trim($this->input->post('vill_townprt_code'));
        $dag_noH                   = trim($this->input->post('dag_no'));
        $land_code                 = trim($this->input->post('land_code'));
        $land_type                 = trim($this->input->post('land_type'));
        $patta_no                  = trim($this->input->post('patta_no'));
        $patta_type_code           = trim($this->input->post('patta_type_code'));
        $applicantNameEng          = trim($this->input->post('applicantNameEng'));
        $applicantNameAss          = trim($this->input->post('applicantNameAss'));
        $guardNameEng              = trim($this->input->post('guardNameEng'));
        $guardNameAss              = trim($this->input->post('guardNameAss'));
        $guardianRelation          = trim($this->input->post('guardianRelation'));
        $gender                    = trim($this->input->post('gender'));
        $mobileNo                  = trim($this->input->post('mobileNo'));
        $address1                  = trim($this->input->post('address1'));
        $city1                     = trim($this->input->post('city1'));
        $district1                 = trim($this->input->post('district1'));
        $pinCode1                  = trim($this->input->post('pinCode1'));
        $address2                  = trim($this->input->post('address2'));
        $city2                     = trim($this->input->post('city2'));
        $district2                 = trim($this->input->post('district2'));
        $pinCode2                  = trim($this->input->post('pinCode2'));
        $is_urban                  = trim($this->input->post('is_urban'));
        $split                     = explode("@",$dag_noH);
        $dag_no                    = $split[0];
        $dag_no_int                = $split[1];
        $typeOfHouse               = trim($this->input->post('typeOfHouse'));
        $natureOfPossession        = trim($this->input->post('natureOfPossession'));
        $checklistSubmitted        = trim($this->input->post('checklistSubmitted'));
        $sdlacRecommend            = trim($this->input->post('sdlacRecommendation'));
        $sdlacRecommendDate        = trim($this->input->post('sdlacRecommendationDate'));
        $recommendation            = trim($this->input->post('recommendation'));
        $zonalValue                = trim($this->input->post('zonalValue'));
        $premium                   = trim($this->input->post('premium'));
        $concession                = trim($this->input->post('concession'));
        $remarks                   = trim($this->input->post('remarks'));
        $landPolicyStatus          = trim($this->input->post('landPolicy'));

        $generatedDistCirName = $this->OfflineCommonModel->generateOfflineCaseName($dist_code,$subdiv_code,$cir_code);
        if($generatedDistCirName == '' or $generatedDistCirName == NULL)
        {
            $errors = '#MROFK0001: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        //generate case no
        $petitionNo = $this->OfflineCommonModel->generateOfflineSettlementPetitionNo();
        if($petitionNo == '' or $petitionNo == NULL)
        {
            $errors = '#MROFK0002: There is some problem. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        $caseNo = $generatedDistCirName . $petitionNo . "/" . OFFLINE_KHAS_LAND_NAME;

        // checking for duplicate
        $checkCase = $this->OfflineCommonModel->checkDupOfflineSettlementCaseNo($caseNo);
        if($checkCase != 0)
        {
            $errors = '#MROFK0003: Case no already exists. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }


        //uuid from location table
        $uuidFromLoc = $this->OfflineCommonModel->getUuidFromLocation($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);


        // get pattadar cron number
        $cron_no = $this->OfflineCommonModel->getPdarCronNoForOffline($caseNo);


        $this->db->trans_begin();


        // save application in settlement basic dada
        $settlement_basic = [
            'dist_code'            => $dist_code,
            'subdiv_code'          => $subdiv_code,
            'cir_code'             => $cir_code,
            'mouza_pargona_code'   => $mouza_pargona_code,
            'lot_no'               => $lot_no,
            'vill_townprt_code'    => $vill_townprt_code,
            'service_code'         => OFFLINE_KHAS_LAND_ID,
            'case_no'              => $caseNo,
            'trans_code'           => 'F',
            'petition_no'          => $petitionNo,
            'year_no'              => date('Y'),
            'date_entry'           => date('Y-m-d G:i:s'),
            'status'               => 'Z',
            'remarks'              => $remarks,
            'submission_date'      => date('Y-m-d G:i:s'),
            'applid'               => $caseNo,
            'is_offline'           => 1,
            'caste'                => $castCategory,
            'uuid'                 => $uuidFromLoc,
            'user_code'            => $this->session->userdata('user_code'),
            'co_code'              => $this->session->userdata('user_code'),
            'pending_office'       => MB_DEPUTY_COMM,
            'pending_officer'      => MB_DEPUTY_COMM,
            'from_office'          => $this->session->userdata('user_desig_code'),
        ];
        $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);
        if ($settlement_basic_insertion != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0004: Insertion failed in settlement_basic for Case No ' . $caseNo . ' and query is ' . $this->db->last_query());
            $errors = '#MROFK0004: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }



        $this->form_validation->set_rules('proposalDoc', 'Copy of the proposal', 'required');
        $this->form_validation->set_rules('minutesDoc', 'Copy of the Minutes of Sdlac/Cdlac Meeting', 'required');


        // save file (minute)
        $file_minute_path   = NULL;
        if(isset($_FILES['minutesDoc']['name']))
        {
            $_FILES['file']['name']     = $_FILES['minutesDoc']['name'];
            $_FILES['file']['type']     = $_FILES['minutesDoc']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['minutesDoc']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['minutesDoc']['error'];
            $_FILES['file']['size']     = $_FILES['minutesDoc']['size'];

            $mime = mime_content_type($_FILES['minutesDoc']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];
            $fileNameMi =  $this->UUID4() . '-OFF-MI.' . $onlyExtension;

            // Upload Minutes
            $config['upload_path']   = UPLOAD_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = UPLOAD_MAX_SIZE;;
            $config['file_name']     = $fileNameMi;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $file_minute_path = UPLOAD_DIR . $fileNameMi;
            }
            else
            {
                $error =$this->upload->display_errors();
                $this->db->trans_rollback();
                $errors = '#MROFK0011: '. $error;
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
            }
        }
        else
        {
            $this->db->trans_rollback();
            $errors = '#MROFK0010: Registration of Offline settlement failed. Missing copy of the Minutes';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        // save file (proposal)
        $file_proposal_path = NULL;
        if(isset($_FILES['proposalDoc']['name']))
        {
            $_FILES['file']['name']     = $_FILES['proposalDoc']['name'];
            $_FILES['file']['type']     = $_FILES['proposalDoc']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['proposalDoc']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['proposalDoc']['error'];
            $_FILES['file']['size']     = $_FILES['proposalDoc']['size'];

            $mime = mime_content_type($_FILES['proposalDoc']['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];
            $fileNamePro =  $this->UUID4() . '-OFF-PR.' . $onlyExtension;

            // Upload Minutes
            $config['upload_path']   = UPLOAD_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = UPLOAD_MAX_SIZE;;
            $config['file_name']     = $fileNamePro;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $file_proposal_path = UPLOAD_DIR . $fileNamePro;
            }
            else
            {
                $error =$this->upload->display_errors();
                $this->db->trans_rollback();
                $errors = '#MROFK0012: '. $error;
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
            }
        }
        else
        {
            $this->db->trans_rollback();
            $errors = '#MROFK0013: Registration of Offline settlement failed. Missing copy of the Minutes';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }


        // save case details

        if($applyFor == 'individual')
        {
            $caseDetails = [
                'case_no'              => $caseNo,
                'house_type'           => $typeOfHouse,
                'nature_of_possession' => $natureOfPossession,
                'checklist'            => $checklistSubmitted,
                'sdlac_rec'            => $sdlacRecommend,
                'sdlac_rec_date'       => $sdlacRecommendDate,
                'recommendation'       => $recommendation,
                'zonal_value'          => $zonalValue,
                'premium'              => $premium,
                'status'               => 1,
                'remarks'              => $remarks,
                'minutes_doc'          => $file_minute_path,
                'proposal_doc'         => $file_proposal_path,
                'concession'           => $concession,
                'land_policy_status'   => $landPolicyStatus,
                'created_at'           => date('Y-m-d G:i:s'),
                'applied_for'          => $applyFor,
                'land_code'            => $land_code,
                'land_type'            => $land_type,
                'community'            => $castCategory_spouse,
            ];
        }
        if($applyFor == 'institution')
        {
            $caseDetails = [
                'case_no'              => $caseNo,
                'house_type'           => $typeOfHouse,
                'nature_of_possession' => $natureOfPossession,
                'checklist'            => $checklistSubmitted,
                'sdlac_rec'            => $sdlacRecommend,
                'sdlac_rec_date'       => $sdlacRecommendDate,
                'recommendation'       => $recommendation,
                'zonal_value'          => $zonalValue,
                'premium'              => $premium,
                'status'               => 1,
                'remarks'              => $remarks,
                'minutes_doc'          => $file_minute_path,
                'proposal_doc'         => $file_proposal_path,
                'concession'           => $concession,
                'land_policy_status'   => $landPolicyStatus,
                'created_at'           => date('Y-m-d G:i:s'),
                'applied_for'          => $applyFor,
                'land_class'           => $newLandClass,
                'proposed_land'        => $proposedLandClass,
                'ins_name'             => $institutionName,
                'dept_name'            => $departmentName,
                'directorate_name'     => $directorateName,
                'entity'               => $entityOf,
                'land_code'            => $land_code,
                'land_type'            => $land_type,
                'community'            => $castCategory_spouse,
            ];
        }

        $settlement_basic_insertion = $this->db->insert('offline_settlement_case_details', $caseDetails);
        if ($settlement_basic_insertion != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0004: Insertion failed in offline_settlement_case_details for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
            $errors = '#MROFK0009: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        // save dag details
        $encroachment_area = [
            'homestead'  => [
                'bigha'  => $bighaHome,
                'katha'  => $kathaHome,
                'lessa'  => $lessaHome,
                'ganda'  => $gandaHome,
                'kranti' => 0,
            ],
            'agriculture' => [
                'bigha'  => $bighaAgr,
                'katha'  => $kathaAgr,
                'lessa'  => $lessaAgr,
                'ganda'  => $gandaAgr,
                'kranti' => 0,
            ],
        ];

        $dagDetails = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_townprt_code,
            'year_no'            => date('Y'),
            'petition_no'        => $petitionNo,
            'dag_no'             => $dag_no,
            'patta_no'           => $patta_no,
            'patta_type_code'    => $patta_type_code,
            'revenue'            => 0,
            'user_code'          => $this->session->userdata('user_code'),
            'date_entry'         => date('Y-m-d G:i:s'),
            'operation'          => 'E',
            'case_no'            => $caseNo,
            'land_type'          => $nature_of_land,
            'is_urban'           => $is_urban,
            'encroachement_area' => json_encode($encroachment_area)
        ];

        $dagDetails['dag_area_b']  = $bighaDag;
        $dagDetails['dag_area_k']  = $kathaDag;
        $dagDetails['dag_area_lc'] = $lessaDag;
        $dagDetails['dag_area_g']  = $gandaDag ;
        $dagDetails['dag_area_kr'] = 0;
        $dagDetails['home_b']      = $bighaHome;
        $dagDetails['home_k']      = $kathaHome;
        $dagDetails['home_lc']     = $lessaHome;
        $dagDetails['home_g']      = $gandaHome;
        $dagDetails['home_kr']     = 0;
        $dagDetails['agri_b']      = $bighaAgr;
        $dagDetails['agri_k']      = $kathaAgr;
        $dagDetails['agri_lc']     = $lessaAgr;
        $dagDetails['agri_g']      = $gandaAgr;
        $dagDetails['agri_kr']     = 0;


        //************Total Area Calculation  ******************
        if (in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            //******for Barak valley */
            $areaHomeLessa  = $this->offlineutility->Total_ganda($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc'],$dagDetails['home_g'],$dagDetails['home_kr']);
            $areaAgrLessa   = $this->offlineutility->Total_ganda($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc'],$dagDetails['agri_g'],$dagDetails['agri_kr']);
            $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgrLessa;
            $totalAreaArr   = $this->offlineutility->Total_Bigha_Katha_Lessa2($totalAreaGanda);

            //*************left out area Home*****************
            $leftOutAreaHomeLessa = (float)$areaHomeLessa - (float)$areaHomeLessa;
            $leftOutAreaHomeArr   = $this->offlineutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeLessa);

            //*************left out area agriculture*****************
            $leftOutAreaAgriLessa = (float)$areaAgrLessa - (float)$areaAgrLessa;
            $leftOutAreaAgriArr   = $this->offlineutility->Total_Bigha_Katha_Lessa2($leftOutAreaAgriLessa);

            //**********Total left out area***************
            $totalLeftOutArealessa = (float)$totalAreaGanda - (float)$totalAreaGanda;
            $totalLeftOutAreaArr   = $this->offlineutility->Total_Bigha_Katha_Lessa2($totalLeftOutArealessa);

        }
        else
        {
            $areaHomeLessa  = $this->offlineutility->Total_Lessa($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc']);
            $areaAgrLessa   = $this->offlineutility->Total_Lessa($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc']);
            $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgrLessa;
            $totalAreaArr   = $this->offlineutility->Total_Bigha_Katha_Lessa($totalAreaLessa);

            //*************left out area Home*****************
            $leftOutAreaHomeLessa = (float)$areaHomeLessa - (float)$areaHomeLessa;
            $leftOutAreaHomeArr   = $this->offlineutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

            //*************left out area agriculture*****************
            $leftOutAreaAgriLessa = (float)$areaAgrLessa - (float)$areaAgrLessa;
            $leftOutAreaAgriArr   = $this->offlineutility->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

            //**********Total left out area***************
            $totalLeftOutArealessa = (float)$totalAreaLessa - (float)$totalAreaLessa;
            $totalLeftOutAreaArr   = $this->offlineutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
        }

        $dagDetails['s_dag_area_b']  = $totalAreaArr[0];
        $dagDetails['s_dag_area_k']  = $totalAreaArr[1];
        $dagDetails['s_dag_area_lc'] = $totalAreaArr[2];
        $dagDetails['s_dag_area_g']  = $totalAreaArr[3];
        $dagDetails['s_dag_area_kr'] = 0;

        $insSetDag = $this->db->insert('settlement_dag_details', $dagDetails);
        if ($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0005: Insertion failed in settlement_dag_details for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
            $errors = '#MROFK0005: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');

        }


        $settlementAreaHistoryArr = [
            'application_no'                        => $caseNo,
            'case_no'                               => $caseNo,
            'dag_no'                                => $dag_no,
            'uuid'                                  => $uuidFromLoc,
            'created_at'                            => date('Y-m-d'),
            'applied_area_home_bigha'               => $dagDetails['home_b'],
            'applied_area_home_katha'               => $dagDetails['home_k'],
            'applied_area_home_lessa'               => $dagDetails['home_lc'],
            'applied_area_home_ganda'               => $dagDetails['home_g'],
            'applied_area_home_kranti'              => 0,
            'applied_area_agri_bigha'               => $dagDetails['agri_b'],
            'applied_area_agri_katha'               => $dagDetails['agri_k'],
            'applied_area_agri_lessa'               => $dagDetails['agri_lc'],
            'applied_area_agri_ganda'               => $dagDetails['agri_g'],
            'applied_area_agri_kranti'              => 0,
            'actual_encroachment_area_home_bigha'   => $dagDetails['home_b'],
            'actual_encroachment_area_home_katha'   => $dagDetails['home_k'],
            'actual_encroachment_area_home_lessa'   => $dagDetails['home_lc'],
            'actual_encroachment_area_home_ganda'   => $dagDetails['home_g'],
            'actual_encroachment_area_home_kranti'  => 0,
            'actual_encroachment_area_agri_bigha'   => $dagDetails['agri_b'],
            'actual_encroachment_area_agri_katha'   => $dagDetails['agri_k'],
            'actual_encroachment_area_agri_lessa'   => $dagDetails['agri_lc'],
            'actual_encroachment_area_agri_ganda'   => $dagDetails['agri_g'],
            'actual_encroachment_area_agri_kranti'  => 0,
            'total_actual_encroachment_area_bigha'  => $totalAreaArr[0],
            'total_actual_encroachment_area_katha'  => $totalAreaArr[1],
            'total_actual_encroachment_area_lessa'  => $totalAreaArr[2],
            'total_actual_encroachment_area_ganda'  => $totalAreaArr[3],
            'total_actual_encroachment_area_kranti' => 0,
            'settlement_area_home_bigha'            => $dagDetails['home_b'],
            'settlement_area_home_katha'            => $dagDetails['home_k'],
            'settlement_area_home_lessa'            => $dagDetails['home_lc'],
            'settlement_area_home_ganda'            => $dagDetails['home_g'],
            'settlement_area_home_kranti'           => $dagDetails['home_kr'],
            'settlement_area_agri_bigha'            => $dagDetails['agri_b'],
            'settlement_area_agri_katha'            => $dagDetails['agri_k'],
            'settlement_area_agri_lessa'            => $dagDetails['agri_lc'],
            'settlement_area_agri_ganda'            => $dagDetails['agri_g'],
            'settlement_area_agri_kranti'           => $dagDetails['agri_kr'],
            'total_settlement_area_bigha'           => $totalAreaArr[0],
            'total_settlement_area_katha'           => $totalAreaArr[1],
            'total_settlement_area_lessa'           => $totalAreaArr[2],
            'total_settlement_area_ganda'           => $totalAreaArr[3],
            'total_settlement_area_kranti'          => 0,
            'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
            'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
            'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
            'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
            'leftout_area_home_kranti'              => 0,
            'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
            'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
            'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
            'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
            'leftout_area_agri_kranti'              => 0,
            'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
            'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
            'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
            'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
            'total_leftout_area_kranti'             => 0,
        ];
        $insertAreaHistory = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
        if ($insertAreaHistory != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0006: Insertion failed in settlement_area_history for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
            $errors = '#MROFK0006: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        if($applyFor == 'individual')
        {
            $insApplicant = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'case_no'            => $caseNo,
                'petition_no'        => $petitionNo,
                'year_no'            => date('Y'),
                'user_code'          => $this->session->userdata('user_code'),
                'operation'          => 'E',
                'dag_no'             => $dag_no,
                'patta_no'           => $patta_no,
                'patta_type_code'    => $patta_type_code,
                'date_entry'         => date('Y-m-d'),
                'pdar_id'            => '-1',
                'pdar_cron_no'       => $cron_no,
                'pdar_name'          => $applicantNameAss,
                'eng_pdar_name'      => $applicantNameEng,
                'eng_pdar_guardian'  => $guardNameEng,
                'pdar_guardian'      => $guardNameAss,
                'pdar_rel_guar'      => $guardianRelation,
                'pdar_gender'        => $gender,
                'pdar_mobile'        => $mobileNo,
                'dob'                => $dob,
                'marital_status'     => $maritalStatus,
                'protected_category' => $protectedCategory,
                'pdar_type'          => 'B',
                'is_applicant'       => 1,
                'pdar_add1'          => $address1.', City - '.$city1.', Dist - '.$district1 .', Pin - '.$pinCode1,
                'pdar_add2'          => $address2.', City - '.$city2.', Dist - '.$district2 .', Pin - '.$pinCode2,

            ];
        }
        if($applyFor == 'institution')
        {
            $insApplicant = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'case_no'            => $caseNo,
                'petition_no'        => $petitionNo,
                'year_no'            => date('Y'),
                'user_code'          => $this->session->userdata('user_code'),
                'operation'          => 'E',
                'dag_no'             => $dag_no,
                'patta_no'           => $patta_no,
                'patta_type_code'    => $patta_type_code,
                'date_entry'         => date('Y-m-d'),
                'pdar_id'            => '-1',
                'pdar_cron_no'       => $cron_no,
                'pdar_name'          => $applicantNameAss,
                'eng_pdar_name'      => $applicantNameEng,
                'eng_pdar_guardian'  => $guardNameEng,
                'pdar_guardian'      => $guardNameAss,
                'pdar_rel_guar'      => $guardianRelation,
                'pdar_gender'        => $gender,
                'pdar_mobile'        => $mobileNo,
                'pdar_type'          => 'B',
                'is_applicant'       => 1,
                'pdar_add1'          => $address1.', City - '.$city1.', Dist - '.$district1 .', Pin - '.$pinCode1,
                'pdar_add2'          => $address2.', City - '.$city2.', Dist - '.$district2 .', Pin - '.$pinCode2,

            ];
        }

        // save main applicant

        $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);
        if ($applicantDetail != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0007: Insertion failed in settlement_applicant for Case No ' . $caseNo . ' and query is ' . $this->db->last_query());
            $errors = '#MROFK0007: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        if($maritalStatus == '1')
        {
            $insApplicantSpouse = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'case_no'            => $caseNo,
                'petition_no'        => $petitionNo,
                'year_no'            => date('Y'),
                'user_code'          => $this->session->userdata('user_code'),
                'operation'          => 'E',
                'dag_no'             => $dag_no,
                'patta_no'           => $patta_no,
                'patta_type_code'    => $patta_type_code,
                'date_entry'         => date('Y-m-d'),
                'pdar_id'            => '-1',
                'pdar_cron_no'       => $cron_no,
                'pdar_name'          => $applicantNameAss_spouse,
                'eng_pdar_name'      => $applicantNameEng_spouse,
                'eng_pdar_guardian'  => $guardNameEng_spouse,
                'pdar_guardian'      => $guardNameAss_spouse,
                'pdar_rel_guar'      => $guardianRelation_spouse,
                'pdar_gender'        => $gender_spouse,
                'dob'                => $dob_spouse,
                'pdar_mobile'        => $mobileNo_spouse,
                'marital_status'     => $maritalStatus,
                'pdar_type'          => 'B',
                'is_applicant'       => 0,
                'protected_category' => $protectedCategory_spouse,
                'pdar_add1'          => $address1.', City - '.$city1.', Dist - '.$district1 .', Pin - '.$pinCode1,
                'pdar_add2'          => $address2.', City - '.$city2.', Dist - '.$district2 .', Pin - '.$pinCode2,

            ];
            $applicantDetailSpouse = $this->db->insert('settlement_applicant', $insApplicantSpouse);
            if ($applicantDetailSpouse != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK000721: Insertion failed in settlement_applicant for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
                $errors = '#MROFK000721: Registration of Offline settlement failed. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
            }
        }


        // upload additional file
        for($i = 1; $i <= $fileCount; $i++)
        {
            $indexFile = 'uploadFile'.$i;
            if(!in_array($indexFile,$masterKeyFile))
            {
                continue;
            }
            $_FILES['file']['name']     = $_FILES['uploadFile'.$i]['name'];
            $_FILES['file']['type']     = $_FILES['uploadFile'.$i]['type'];
            $_FILES['file']['tmp_name'] = $_FILES['uploadFile'.$i]['tmp_name'];
            $_FILES['file']['error']    = $_FILES['uploadFile'.$i]['error'];
            $_FILES['file']['size']     = $_FILES['uploadFile'.$i]['size'];

            $mime = mime_content_type($_FILES['uploadFile'.$i]['tmp_name']);
            $exp  = explode("/",$mime);
            $onlyExtension  = $exp[1];

            $fileRename =  $this->UUID4() . 'OFF.' . $onlyExtension;

            $config['upload_path']   = UPLOAD_DIR;
            $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
            $config['max_size']      = UPLOAD_MAX_SIZE;;
            $config['file_name']     = $fileRename;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $document= array(
                    'case_no'         => $caseNo,
                    'file_name'       => $this->input->post('document'.$i),
                    'user_code'       => $this->session->userdata('user_code'),
                    'fetch_file_name' => $this->input->post('document'.$i),
                    'file_type'       => $_FILES['file']['type'],
                    'file_path'       => UPLOAD_DIR . $fileRename,
                    'date_entry'      => date('Y-m-d h:i:s'),
                    'mut_type'        => OFFLINE_KHAS_LAND_ID,
                );

                // save data in attachment file
                $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                if($addMoreDocQuery != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#MROFK0010: Insertion failed in supportive_document for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
                    $errors = '#MROFK0010: Registration of Offline settlement failed. Kindly contact system administrator';
                    $this->session->set_flashdata('error', $errors);
                    redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');

                }
            }
            else
            {
                $this->db->trans_rollback();
                log_message('error', '#MROFK0011: upload file failed for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
                $errors = '#MROFK0011: Registration of Offline settlement failed. Kindly contact system administrator';
                $this->session->set_flashdata('error', $errors);
                redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');

            }
        }


        // insertion in backup table
        $phase_count = $this->db->query("SELECT COUNT(*) as ct FROM settlement_backup_json WHERE applid = '$caseNo' AND from_office = 'LM'")->row()->ct;
        $phase_count = (int)$phase_count+1;
        $backup_array_lm = [
            'applid'      => $caseNo,
            'case_no'     => $caseNo,
            'from_office' => $this->session->userdata('user_desig_code'),
            // 'to_office'   => MB_ADD_DEPUTY_COMM,
            'to_office'   => MB_DEPUTY_COMM,
            'status'      => 'Z',
            'phase'       => $this->session->userdata('user_desig_code').'_'.$phase_count,
            'data'        => json_encode($_POST)
        ];
        $backup_insertion_lm = $this->db->insert('settlement_backup_json', $backup_array_lm);
        if($backup_insertion_lm != 1){
            $this->db->trans_rollback();
            log_message('error', '#BACKUPF001: Insertion failed in settlement_backup_json Case No '.$caseNo);
            $errors = '#BACKUPF001: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        // save application proceeding
        $proceeding_data = [
            'case_no'              => $caseNo,
            'proceeding_id'        => 1,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => "Requested for Offline Settlement by ".$this->session->userdata('user_desig_code'),
            'status'               => 'Z',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->offlineutility->get_client_ip(),
            'office_from'          => $this->session->userdata('user_desig_code'),
            'office_to'            => MB_DEPUTY_COMM,
            'task'                 => "Requested for Offline Settlement",
        ];
        $proceedingStatus = $this->db->insert("settlement_proceeding", $proceeding_data);

        if($proceedingStatus != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0012: Insertion failed in settlement_proceeding for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
            $errors = '#MROFK0012: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }

        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            log_message('error', '#MROFK0013: Insertion failed in petition_proceeding for Case No ' . $caseNo . 'and query is ' . $this->db->last_query());
            $errors = '#MROFK0013: Registration of Offline settlement failed. Kindly contact system administrator';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas');
        }
        else
        {

            $application_no = $this->offlineutility->encryptJwtcase($caseNo);
            $this->db->trans_commit();
            redirect(base_url() .'index.php/OfflineSettlementCommonController/getOfflineApplicationSuccessfullySubmittedMsg?app='.$application_no);
        }

    }



}