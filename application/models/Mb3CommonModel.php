<?php
class Mb3CommonModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
    }

    // count application id by case no for DC
    public function countSettlementApplicationDetailsByCaseNo($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }

    // count application by case no for DC in sdlac proposal list
    public function countSettlementApplicationByCaseNoInSdlacProList($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // case Under Dept Or DC By WetLand for DC
    public function caseUnderDeptOrDCByWetLand($case_no)
    {
        $data = array();
        $wetLand = 0;
        $sql = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no,
                    (select wet_land from chitha_dag_all_flag_details_final  where
                     dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code
                     and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no)
                    from settlement_dag_details s
                     where case_no = ?', array($case_no));

        $data = $sql->result();

        if (!empty($data)) {
            if (in_array(6, array_column($data, 'wet_land'))) {
                $wetLand = 1;
            }
        }

        return $wetLand;
    }

    // get Settlement Basic Details by case no
    public function getSettlementBasicDetails($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();
    }

    // modification request check with Session
    public function checkCaseInModificationRequestWithSession($caseNo)
    {
        $modificationRequest = 0;
        $user_desig_code = $this->session->userdata('user_desig_code');
        $basic = $this->getSettlementBasicDetails($caseNo);
        if($basic->pull_request == 1)
        {
            $service_code = $basic->service_code;
            $pendingWith  = $basic->pending_officer;
            if($pendingWith == $user_desig_code)
            {
                if($user_desig_code == MB_SUB_DIV_COMM)
                {
                    $modificationRequest = 1;
                }
                elseif($user_desig_code == MB_ADD_DEPUTY_COMM)
                {
                    $modificationRequest = 1;
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #MRPULL000111: There is modification request for this case # $caseNo by CO");
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
            else
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRPULL000222: There is modification request for this case # $caseNo by CO");
                redirect(base_url() . "index.php/home");
                return false;
            }
        }

        return $modificationRequest;
    }

    public function getAppliedSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get basic details with case no
    public function getSettlementBasicData($case_no){
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    // get chitha dag details
    public function getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
            ->get('chitha_basic')
            ->row();
    }

    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
        FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
        and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
        and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
        JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
        mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
        and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=1) settlement_basic
        ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }

    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationNotSubmit($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {
        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
        FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
        and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
        and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
        JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
        mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
        and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=0) settlement_basic
        ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }

    // area reservation on chitha by dc application wise
    public function chithaReserveAreaCheckWithCaseNo($application_no)
    {
        $dags                           = $this->getSettlementDag($application_no);
        $totalAreaInChitha[]            = 0;
        $appAreaInApplication           = 0;
        $totalAreaInApplication         = 0;
        $totalAppliedAreaInApplication  = 0;
        $areaCheck                      = 0;
        $appliedDags                    = $this->getAppliedSettlementDag($application_no);
        $basic                          = $this->getSettlementBasicData($application_no);
        foreach ($dags as $dag)
        {
            $totalAreaInApplication        = 0;
            $totalAreaInLMApplication      = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict  = $dag->dist_code;
            $appSubDiv    = $dag->subdiv_code;
            $appCircle    = $dag->cir_code;
            $appMouza     = $dag->mouza_pargona_code;
            $appLot       = $dag->lot_no;
            $appVillage   = $dag->vill_townprt_code;
            $appDag       = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta     = $dag->patta_no;

            $chithaDag          = $this->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);
            $allApplicationDags = $this->getAllDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);
            $allLmProcess       = $this->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;
                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }

            }
            else
            {
                // chitha
                $bighaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha       = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp          = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;
                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp          = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;
                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea         = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }
                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }
            }
        }

        return $areaCheck;

    }


    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }

}