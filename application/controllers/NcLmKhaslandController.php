<?php
class NcLmKhaslandController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('AES');
        $this->ncutility->dbSwitchSession();

        //*******models */
        $this->load->model('NcModel/tableModels/BasundharApplicationModel');
        $this->load->model('NcModel/lm/NcLmKhaslandModel');
        $this->load->model('NcModel/tableModels/SettlementApplicantModel');
        $this->load->model('NcModel/tableModels/SettlementBasicModel');
        $this->load->model('NcModel/tableModels/ChithaBasicModel');
        $this->load->model('NcModel/tableModels/SettlementDagDetailsModel');

        $this->load->model('NcModel/NcApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('NcModel/NcServiceModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
        $this->load->model('NcModel/tableModels/LandbankModel');

    }





    public function firstProceeding()
    {
        $application_no = $this->input->get('an');
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $applicants     = $this->SettlementApplicantModel->get($application_no);
        if($applicants->num_rows() <= 0)
        {
            $data['applicants'] = false;
        }
        else
        {
            $data['applicants'] = $applicants->result();
        }

        $encroachers = $this->SettlementApplicantModel->getEncroachers($application_no);
//        $encroachers = $this->SettlementApplicantModel->getEncroachersWithDagDetails($application_no);

        $appView = 0;
        if($encroachers->num_rows() <= 0)
        {
            $data['encroachers'] = NULL;
        }
        else
        {
            $data['encroachers'] = $encroachers->result();

            foreach ($data['encroachers'] as $en)
            {

                if($en->is_applicant == 0 && $en->dag_no != 0)
                {
                    $appView = 1;
                }
            }
        }

        $data['appView'] = $appView;
        $basic = $this->SettlementBasicModel->get($application_no);

        if($basic->num_rows() <= 0)
        {
            $data['basic'] = false;
        }
        else
        {
            $data['basic'] = $basic->row();
        }

        $aadhaar = $this->NcLmKhaslandModel->getAadhaarPhoto($application_no);
        $data['aadhaar_photo'] = '<img src = data:'.$this->ncutility->decodeBase64($aadhaar).';base64,'.$aadhaar.' class="img-thumbnail" alt="Aadhaar Photo" width="170" height="200">';
        $getAPIData = $this->NcLmKhaslandModel->getSelfDocAPIData($application_no);

        if($getAPIData['responseType'] != 2)
        {
            echo json_encode($getAPIData);
            return false;
        }

        foreach($getAPIData['data']->selfDeclaration as $selfDec)
        {
            $data['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
        }


        $data['application_no'] = $application_no;

        //*****error handling */
        $data['fetch_err'] = '<span class="alert-danger"><strong>Unable to fetch data</strong></span>';
        $data['_view'] = 'NcVillageService/NcKhas/NcKhaslandFirstProceedingView';
        $this->load->view('layouts/main',$data);
    }



    //*****Registering the application in Dharitree by generating a dharitree case_no*/
    public function registration()
    {
        $application_no = trim($this->input->post('application_no'));
        $application_no = $this->ncutility->decryptJwtCase($application_no);

        //*********getting the data from API */
        $curl_data = $this->NcLmKhaslandModel->getSelfDocAPIData($application_no);

        if($curl_data['responseType'] != 2)
        {
            $resp = $this->ncutility->errorResp('ERRJS564744', 'Unable to fetch data from Basundhara API!');
            echo json_encode($resp);
            return false;
        }

        $recordExist = $this->NcApiModel->checkExistDharitree($application_no);
        if(!$recordExist)
        {
            $this->db->trans_begin();
            //*****If already not registered then register */
            $createResp = $this->NcLmKhaslandModel->createRegistration($application_no, $curl_data['data'], NC_KHAS_LAND_ID, NC_KHAS_LAND);
            if($createResp['responseType'] == 0)
            {
                $this->db->trans_rollback();
                echo json_encode($createResp);
                return false;
            }
            if($this->db->trans_status() != true)
            {
                $errResp = $this->ncutility->errorResp('ERRJS091034', 'Transaction failed! Unable to process...', true);
                echo json_encode($errResp);
                return false;
            }

            $this->db->trans_commit();
        }
        $sucResp = $this->ncutility->successResp('SUCSJS091139', 'Application successfully registered...', true);
        echo json_encode($sucResp);
    }




    public function getIsApplicant()
    {
        $application_no = trim($this->input->post('application_no'));
        $is_applicant   = $this->NcLmKhaslandModel->getIsApplicant($application_no);
        if($is_applicant['responseType'] != 2)
        {
            echo json_encode($is_applicant);
            return false;
        }
        echo json_encode($is_applicant);
    }

    public function getJointApplicants()
    {
        $application_no = trim($this->input->post('application_no'));
        $jointApplicant = $this->NcLmKhaslandModel->getJointApplicants($application_no);
        if($jointApplicant['responseType'] != 2)
        {
            echo json_encode($jointApplicant);
            return false;
        }
        echo json_encode($jointApplicant);
    }

    public function getEncroachers()
    {
        $application_no = trim($this->input->post('application_no'));
        $encroachers    = $this->NcLmKhaslandModel->getEncroachers($application_no);
        if($encroachers['responseType'] != 2)
        {
            echo json_encode($encroachers);
            return false;
        }
        echo json_encode($encroachers);
    }

    public function getDagDetailsData()
    {
        $application_no = trim($this->input->post('application_no'));
        $application_no = $this->ncutility->decryptJwtCase($application_no);
        $basicExe       = $this->SettlementBasicModel->get($application_no);

        if($basicExe->num_rows() <= 0){
            $errR = $this->ncutility->errorResp('ERRJS13020420', 'Basic data not found!');
            echo json_encode($errR);
            return false;
        }

        $basicReq = $basicExe->row();

        $location = '<table class="table table-bordered">
                        <tr>
                            <th style="50%">District :</th>
                            <td style="50%">'.$this->ncutility->getDistrictName($basicReq->dist_code).'</td>
                       
                            <th style="50%">Sub division :</th>
                            <td style="50%">'.$this->ncutility->getSubDivName($basicReq->dist_code, $basicReq->subdiv_code).'</td>
                        </tr>
                        <tr>
                            <th>Circle :</th>
                            <td>'.$this->ncutility->getCircleName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code).'</td>
                        
                            <th>Mouza :</th>
                            <td>'.$this->ncutility->getMouzaName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code).'</td>
                        </tr>
                        <tr>
                            <th>Lot :</th>
                            <td>'.$this->ncutility->getLotName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no).'</td>
                        
                            <th>Village :</th>
                            <td>'.$this->ncutility->getVillageName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no, $basicReq->vill_townprt_code).'</td>
                        </tr>
                    </table>';

        $nc_dags = $this->NcLmKhaslandModel->getDagsFromChitha($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no, $basicReq->vill_townprt_code);
        if($nc_dags['responseType'] != 2){
            echo json_encode($nc_dags);
            return false;
        }
        $nc_dags['location_name'] = $location;
        echo json_encode(array_merge($nc_dags));
    }

    public function getEncroachersInDag()
    {
        $dist_code   = trim($this->input->post('dist_code'));
        $subdiv_code = trim($this->input->post('subdiv_code'));
        $cir_code    = trim($this->input->post('cir_code'));
        $lot_no      = trim($this->input->post('lot_no'));
        $dag_no      = trim($this->input->post('dag_no'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));

        $encroachersInDag = $this->NcLmKhaslandModel->getEncroachersInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no);

        if($encroachersInDag['responseType'] != 2){
            echo json_encode($encroachersInDag);
            return false;
        }

        echo json_encode($encroachersInDag);
    }


    // save dag details for encroacher
    public function saveDagInfo()
    {
        $distCode = $this->session->userdata('dist_code');

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('subdiv_code', 'Sub Div', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required|min_length[1]|max_length[6]');
        $this->form_validation->set_rules('vill_townprt_code', 'Village', 'trim|required|min_length[1]|max_length[7]');

        $this->form_validation->set_rules('application_no', 'Application No', 'trim|required');
        $this->form_validation->set_rules('encroacher_id', 'Encroacher Name', 'trim|required|is_natural|greater_than[-1]');
        $this->form_validation->set_rules('dag_no', 'Dag No', 'trim|required|is_natural|greater_than[-1]');

        // for barak valley
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $this->form_validation->set_rules('bigha', 'Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha', 'Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('lessa', 'Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('ganda', 'Settlement Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');

            $this->form_validation->set_rules('bigha_agri', 'Settlement Agriculture Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha_agri', 'Settlement Agriculture Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('lessa_agri', 'Settlement Agriculture Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('ganda_agri', 'Settlement Agriculture Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');

            $this->form_validation->set_rules('road_bigha', 'Road/river side Reservation Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('road_katha', 'Road/river side Reservation Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('road_lessa', 'Road/river side Reservation Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('road_ganda', 'Road/river side Reservation Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('bigha', 'Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha', 'Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('lessa', 'Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('bigha_agri', 'Settlement Agriculture Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha_agri', 'Settlement Agriculture Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('lessa_agri', 'Settlement Agriculture Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('road_bigha', 'Road/river side Reservation Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('road_katha', 'Road/river side Reservation Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('road_lessa', 'Road/river side Reservation Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        }
        if ($this->form_validation->run() == false)
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#MRDAG0001: "  . validation_errors(),
            );
            echo json_encode($data);
            return false;
        }

        $application_no     = trim($this->input->post('application_no'));
        $application_no     = $this->ncutility->decryptJwtCase($application_no);
        $dag_no             = trim($this->input->post('dag_no'));
        $encroacher_Id      = trim($this->input->post('encroacher_id'));
        $dist_code          = trim($this->input->post('dist_code'));
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $cir_code           = trim($this->input->post('cir_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));

        $chita_area = $this->ChithaBasicModel->getChitaArea($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no);
        if($chita_area->num_rows() <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAG0002', 'Chitha area not found for this dag no!');
            echo json_encode($err);
            return false;
        }

        $chita_area          =  $chita_area->row();
        $totalHomestead      = 0;
        $totalAgriculture    = 0;
        $totalReservation    = 0;
        $totalSettlementArea = 0;
        $totalChithaArea     = 0;
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $bigha       = $this->ncutility->defaultValue(trim($this->input->post('bigha')), 0);
            $katha       = $this->ncutility->defaultValue(trim($this->input->post('katha')), 0);
            $lessa       = $this->ncutility->defaultValue(trim($this->input->post('lessa')), 0);
            $ganda       = $this->ncutility->defaultValue(trim($this->input->post('ganda')), 0);
            $kranti      = 0;
            $bigha_agri  = $this->ncutility->defaultValue(trim($this->input->post('bigha_agri')), 0);
            $katha_agri  = $this->ncutility->defaultValue(trim($this->input->post('katha_agri')), 0);
            $lessa_agri  = $this->ncutility->defaultValue(trim($this->input->post('lessa_agri')), 0);
            $ganda_agri  = $this->ncutility->defaultValue(trim($this->input->post('ganda_agri')), 0);
            $kranti_agri = 0;
            $road_bigha  = $this->ncutility->defaultValue(trim($this->input->post('road_bigha')), 0);
            $road_katha  = $this->ncutility->defaultValue(trim($this->input->post('road_katha')), 0);
            $road_lessa  = $this->ncutility->defaultValue(trim($this->input->post('road_lessa')), 0);
            $road_ganda  = $this->ncutility->defaultValue(trim($this->input->post('road_ganda')), 0);
            $road_kranti = 0;

            $totalHomestead   = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
            $totalAgriculture = ($bigha_agri * 6400) + ($katha_agri * 320) + ($lessa_agri * 20) + $ganda_agri;
            $totalReservation = ($road_bigha * 6400) + ($road_katha * 320) + ($road_lessa * 20) + $road_ganda;
            $totalChithaArea  = ($chita_area->dag_area_b * 6400) + ($chita_area->dag_area_k * 320) + ($chita_area->dag_area_lc * 20) + $chita_area->dag_area_g;

        }
        else
        {
            $bigha       = $this->ncutility->defaultValue(trim($this->input->post('bigha')), 0);
            $katha       = $this->ncutility->defaultValue(trim($this->input->post('katha')), 0);
            $lessa       = $this->ncutility->defaultValue(trim($this->input->post('lessa')), 0);
            $ganda       = 0;
            $kranti      = 0;
            $bigha_agri  = $this->ncutility->defaultValue(trim($this->input->post('bigha_agri')), 0);
            $katha_agri  = $this->ncutility->defaultValue(trim($this->input->post('katha_agri')), 0);
            $lessa_agri  = $this->ncutility->defaultValue(trim($this->input->post('lessa_agri')), 0);
            $ganda_agri  = 0;
            $kranti_agri = 0;
            $road_bigha  = $this->ncutility->defaultValue(trim($this->input->post('road_bigha')), 0);
            $road_katha  = $this->ncutility->defaultValue(trim($this->input->post('road_katha')), 0);
            $road_lessa  = $this->ncutility->defaultValue(trim($this->input->post('road_lessa')), 0);
            $road_ganda  = 0;
            $road_kranti = 0;

            $totalHomestead   = ($bigha * 100) + ($katha * 20) + $lessa;
            $totalAgriculture = ($bigha_agri * 100) + ($katha_agri * 20) + $lessa_agri;
            $totalReservation = ($road_bigha * 100) + ($road_katha * 20) + $road_lessa;
            $totalChithaArea  = ($chita_area->dag_area_b * 100) + ($chita_area->dag_area_k * 20) + $chita_area->dag_area_lc ;

        }

        $totalSettlementArea = $totalHomestead + $totalAgriculture;

        if($totalSettlementArea <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAG0003', 'Settlement area cannot be zero!');
            echo json_encode($err);
            return false;
        }

        if($totalSettlementArea - $totalReservation <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAG0004', 'Settlement area cannot be zero!');
            echo json_encode($err);
            return false;
        }
        if($totalSettlementArea > $totalChithaArea)
        {
            $err = $this->ncutility->errorResp('MRDAG0005', 'Total Settlement area should not be more than total Dag Area!');
            echo json_encode($err);
            return false;
        }

        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            if(NC_KHAS_MAX_BOTH * 6400 < ($totalSettlementArea + $totalReservation))
            {
                $err = $this->ncutility->errorResp('MRDAG0006', 'Total Settlement + Reservation area should not be more than'. NC_KHAS_MAX_BOTH. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_HOMESTEAD * 6400 < $totalHomestead)
            {
                $err = $this->ncutility->errorResp('MRDAG0007', 'Total Settlement Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_AGRICULTURE * 6400 < $totalAgriculture)
            {
                $err = $this->ncutility->errorResp('MRDAG0008', 'Total Settlement Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha!');
                echo json_encode($err);
                return false;
            }
        }
        else
        {
            if(NC_KHAS_MAX_BOTH * 100 < ($totalSettlementArea + $totalReservation))
            {
                $err = $this->ncutility->errorResp('MRDAG0009', 'Total Settlement + Reservation area should not be more than '. NC_KHAS_MAX_BOTH. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_HOMESTEAD * 100 < $totalHomestead)
            {
                $err = $this->ncutility->errorResp('MRDAG0010', 'Total Settlement Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_AGRICULTURE * 100 < $totalAgriculture)
            {
                $err = $this->ncutility->errorResp('MRDAG00011', 'Total Settlement Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha!');
                echo json_encode($err);
                return false;
            }
        }

        $landTypeUpdate = 0;
        if($totalHomestead > 0 && $totalAgriculture > 0)
        {
            $landTypeUpdate = 3;
        }
        else if($totalHomestead > 0)
        {
            $landTypeUpdate = 1;
        }
        else if($totalAgriculture > 0)
        {
            $landTypeUpdate = 2;
        }

        $basic = $this->SettlementBasicModel->get($application_no);
        if($basic->num_rows() <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAG00012', 'Application not found ! Please contact System Admin !');
            echo json_encode($err);
            return false;
        }
        else
        {
            $basic = $basic->row();
        }

        if($basic->pending_officer == 'LM' && $basic->status == 'Z')
        {
            $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = ?";
            $result = $this->db->query($sql,$basic->case_no);
            if($result->num_rows() > 0)
            {
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }
            else
            {
                $cron_no = 1;
            }


            //************Total Area Calculation ******************
            if (in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                //******for Barak valley */
                $areaHomeLessa  = $this->ncutility->Total_ganda($bigha,$katha,$lessa,$ganda,$kranti);
                $areaAgriLessa  = $this->ncutility->Total_ganda($bigha_agri,$katha_agri,$lessa_agri,$ganda_agri,$katha_agri);
                $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;
                $totalAreaArr   = $this->ncutility->Total_Bigha_Katha_Lessa2($totalAreaGanda);
            }
            else
            {
                $areaHomeLessa  = $this->ncutility->Total_Lessa($bigha,$katha,$lessa);
                $areaAgriLessa  = $this->ncutility->Total_Lessa($bigha_agri,$katha_agri,$lessa_agri);
                $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
                $totalAreaArr   = $this->ncutility->Total_Bigha_Katha_Lessa($totalAreaLessa);
            }

            $encroachment_area = [
                'homestead'  => [
                    'bigha'  => $bigha,
                    'katha'  => $katha,
                    'lessa'  => $lessa,
                    'ganda'  => $ganda,
                    'kranti' => $kranti,
                ],
                'agriculture' => [
                    'bigha'  => $bigha_agri,
                    'katha'  => $katha_agri,
                    'lessa'  => $lessa_agri,
                    'ganda'  => $ganda_agri,
                    'kranti' => $kranti_agri,
                ],
            ];

            $user_code = $this->session->userdata('user_code');
            $encroach  = $this->LandbankModel->getEncroacherByEncroachId($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$encroacher_Id);
            if($encroach->num_rows() <= 0)
            {
                $err = $this->ncutility->errorResp('MRDAG0013', 'Encroacher not found for this dag no!');
                echo json_encode($err);
                return false;
            }


            // check encroacher already exist or not
            $dagCount = $this->SettlementDagDetailsModel->checkDagAlreadyExistOrNot($dist_code,$dag_no,$basic->case_no);
            if($dagCount != 0)
            {
                $err = $this->ncutility->errorResp('MRDAG0014', 'Selected dag already Added!');
                echo json_encode($err);
                return false;
            }

            $encroacher = $encroach->row();

            $this->db->trans_begin();

            // Save data settlement_dag_details
            $saveSetDag = [
                'dist_code'           => $dist_code,
                'subdiv_code'         => $subdiv_code,
                'cir_code'            => $cir_code,
                'mouza_pargona_code'  => $mouza_pargona_code,
                'lot_no'              => $lot_no,
                'vill_townprt_code'   => $vill_townprt_code,
                'year_no'             => date('Y'),
                'petition_no'         => $basic->petition_no,
                'is_urban'            => $basic->nc_is_urban,
                'dag_no'              => $chita_area->dag_no,
                'patta_no'            => $chita_area->patta_no,
                'patta_type_code'     => $chita_area->patta_type_code,
                'revenue'             => 0,
                'user_code'           => $user_code,
                'date_entry'          => date('Y-m-d'),
                'operation'           => 'E',
                'case_no'             => $basic->case_no,
                'new_land_class_code' => $chita_area->land_class_code,
                'land_type'           => $landTypeUpdate,
                'encroachement_area'  => json_encode($encroachment_area),
                'dag_area_b'          => $chita_area->dag_area_b,
                'dag_area_k'          => $chita_area->dag_area_k,
                'dag_area_lc'         => $chita_area->dag_area_lc,
                'dag_area_g'          => $chita_area->dag_area_g,
                'dag_area_kr'         => $chita_area->dag_area_kr,
                'home_b'              => $bigha,
                'home_k'              => $katha,
                'home_lc'             => $lessa,
                'home_g'              => $ganda,
                'home_kr'             => $kranti,
                'agri_b'              => $bigha_agri,
                'agri_k'              => $katha_agri,
                'agri_lc'             => $lessa_agri,
                'agri_g'              => $ganda_agri,
                'agri_kr'             => $kranti_agri,
                's_dag_area_b'        => $totalAreaArr[0],
                's_dag_area_k'        => $totalAreaArr[1],
                's_dag_area_lc'       => $totalAreaArr[2],
                's_dag_area_g'        => $totalAreaArr[3],
                's_dag_area_kr'       => 0,
            ];
            $insSetDag = $this->db->insert('settlement_dag_details', $saveSetDag);
            if ($insSetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRDAG0015: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);

                $err = $this->ncutility->errorResp('MRDAG0015', 'Adding of Dag Details failed ! Please Contact System Admin');
                echo json_encode($err);
                return false;
            }

            // Save data settlement_area_history
            $settlementAreaHistoryArr = [
                'application_no'               => $application_no,
                'case_no'                      => $basic->case_no,
                'dag_no'                       => $chita_area->dag_no,
                'uuid'                         => $basic->uuid,
                'created_at'                   => date('Y-m-d'),
                'applied_area_home_bigha'      => $bigha,
                'applied_area_home_katha'      => $katha,
                'applied_area_home_lessa'      => $lessa,
                'applied_area_home_ganda'      => $ganda,
                'applied_area_home_kranti'     => $kranti,
                'applied_area_agri_bigha'      => $bigha_agri,
                'applied_area_agri_katha'      => $katha_agri,
                'applied_area_agri_lessa'      => $lessa_agri,
                'applied_area_agri_ganda'      => $ganda_agri,
                'applied_area_agri_kranti'     => $kranti_agri,
                'settlement_area_home_bigha'   => $bigha,
                'settlement_area_home_katha'   => $katha,
                'settlement_area_home_lessa'   => $lessa,
                'settlement_area_home_ganda'   => $ganda,
                'settlement_area_home_kranti'  => $kranti,
                'settlement_area_agri_bigha'   => $bigha_agri,
                'settlement_area_agri_katha'   => $katha_agri,
                'settlement_area_agri_lessa'   => $lessa_agri,
                'settlement_area_agri_ganda'   => $ganda_agri,
                'settlement_area_agri_kranti'  => $kranti_agri,
                'total_settlement_area_bigha'  => $totalAreaArr[0],
                'total_settlement_area_katha'  => $totalAreaArr[1],
                'total_settlement_area_lessa'  => $totalAreaArr[2],
                'total_settlement_area_ganda'  => $totalAreaArr[3],
                'total_settlement_area_kranti' => 0,
                'leftout_area_home_bigha'      => 0,
                'leftout_area_home_katha'      => 0,
                'leftout_area_home_lessa'      => 0,
                'leftout_area_home_ganda'      => 0,
                'leftout_area_home_kranti'     => 0,
                'leftout_area_agri_bigha'      => 0,
                'leftout_area_agri_katha'      => 0,
                'leftout_area_agri_lessa'      => 0,
                'leftout_area_agri_ganda'      => 0,
                'leftout_area_agri_kranti'     => 0,
                'total_leftout_area_bigha'     => 0,
                'total_leftout_area_katha'     => 0,
                'total_leftout_area_lessa'     => 0,
                'total_leftout_area_ganda'     => 0,
                'total_leftout_area_kranti'    => 0,
                'actual_encroachment_area_home_bigha'   => $bigha,
                'actual_encroachment_area_home_katha'   => $katha,
                'actual_encroachment_area_home_lessa'   => $lessa,
                'actual_encroachment_area_home_ganda'   => $ganda,
                'actual_encroachment_area_home_kranti'  => $kranti,
                'actual_encroachment_area_agri_bigha'   => $bigha_agri,
                'actual_encroachment_area_agri_katha'   => $katha_agri,
                'actual_encroachment_area_agri_lessa'   => $lessa_agri,
                'actual_encroachment_area_agri_ganda'   => $ganda_agri,
                'actual_encroachment_area_agri_kranti'  => $kranti_agri,
                'total_actual_encroachment_area_bigha'  => $totalAreaArr[0],
                'total_actual_encroachment_area_katha'  => $totalAreaArr[1],
                'total_actual_encroachment_area_lessa'  => $totalAreaArr[2],
                'total_actual_encroachment_area_ganda'  => $totalAreaArr[3],
                'total_actual_encroachment_area_kranti' => 0,
            ];
            $insertAreaHis = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
            if ($insertAreaHis != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRDAG0016: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                $err = $this->ncutility->errorResp('MRDAG0016', 'Adding of Dag Details failed ! Please Contact System Admin');
                echo json_encode($err);
                return false;
            }

            // Save Encroacher in settlement_applicant
            $applicant = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'year_no'            => date('Y'),
                'petition_no'        => $basic->petition_no,
                'dag_no'             => $chita_area->dag_no,
                'patta_no'           => $chita_area->patta_no,
                'patta_type_code'    => $chita_area->patta_type_code,
                'pdar_id'            => '-1',
                'is_applicant'       => 0,
                'pdar_cron_no'       => (int)$cron_no++,
                'date_entry'         => date('Y-m-d'),
                'operation'          => 'E',
                'pdar_type'          => 'EN',
                'user_code'          => $user_code,
                'case_no'            => $basic->case_no,
                'pdar_name'          => $encroacher->name,
                'pdar_guardian'      => $encroacher->fathers_name,
                'pdar_gender'        => $encroacher->gender,
                'pdar_rel_guar'      => 0,
                'enc_id'             => $encroacher->id,
                'period_possession'  => $encroacher->encroachment_from,
            ];
            $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
            if ($insSetApplicant != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#MRDAG0017: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $err = $this->ncutility->errorResp('MRDAG0017', 'Adding of Dag Details failed ! Please Contact System Admin');
                echo json_encode($err);
                return false;
            }

            // save data settlement_reservation
            $reservedArea = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_townprt_code,
                'dag_no'             => $chita_area->dag_no,
                'patta_no'           => $chita_area->patta_no,
                'case_no'            => $basic->case_no,
                'lm_code'            => $user_code,
                'date_entry'         => date('Y-m-d h:i:s'),
                'date_update'        => date('Y-m-d h:i:s'),
                'type'               => 'R',
                'applid'             => $basic->applid,
                'bigha'              => $road_bigha,
                'katha'              => $road_katha,
                'lessa'              => $road_lessa,
                'ganda'              => $road_ganda,
                'kranti'             => $road_kranti
            ];
            $reserveData = $this->db->insert('settlement_reservation', $reservedArea);
            if ($reserveData != 1) {
                $this->db->trans_rollback();
                log_message('error', '#MRDAG0018: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                $err = $this->ncutility->errorResp('MRDAG0018', 'Adding of Dag Details failed ! Please Contact System Admin');
                echo json_encode($err);
                return false;
            }


            $this->db->trans_commit();
            $err = $this->ncutility->successResp('MRDAG0000', 'Dag Details successfully Added');
            echo json_encode($err);
            return false;
        }
        else
        {
            $this->db->trans_rollback();
            log_message('error', '#MRDAGA0010: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
            $err = $this->ncutility->errorResp('MRDAGA0010', 'Application already processed');
            echo json_encode($err);
            return false;
        }

    }


    public function getChitaArea()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');

        $chita_area = $this->ChithaBasicModel->getChitaArea($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no);

        if($chita_area->num_rows() <= 0){
            $err = $this->ncutility->errorResp('ERRJS131220', 'Chitha area not found for this dag no!');
            echo json_encode($err);
            return false;
        }

        $sucs = $this->ncutility->successResp('SUJS140140', 'Chita area details fetched successfully...',false, 2, $chita_area->row());
        echo json_encode($sucs);
    }



    //  view applicant (Encroacher) details with dag id
    public function getApplicantDetailsWithDagId()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('app_id', 'Application Details', 'trim|required|is_natural|greater_than[-1]');
        if ($this->form_validation->run() == false)
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#MRDAGD0001: "  . validation_errors(),
            );
            echo json_encode($data);
            return false;
        }

        $appId    = trim($this->input->post('app_id'));
        $distCode = $this->session->userdata('dist_code');
        $applicantData = $this->SettlementApplicantModel->applicantDetailsWithAppId($distCode,$appId);
        if($applicantData->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGD0002', 'Applicant Details data not found!');
            echo json_encode($errR);
            return false;
        }
        $applicant = $applicantData->row();
        $nc_dag    = $this->SettlementDagDetailsModel->getSelectedDagDetailsWith($applicant->dist_code,$applicant->dag_no, $applicant->case_no);
        if($nc_dag->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGD0003', 'Dag Details data not found!');
            echo json_encode($errR);
            return false;
        }
        $dagDetails = $nc_dag->row();
        $nc_res_dag    = $this->SettlementDagDetailsModel->getReservationDagDetails($applicant->dist_code,$applicant->dag_no, $applicant->case_no);
        if($nc_res_dag->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGD0004', 'Reservation Dag Details data not found!');
            echo json_encode($errR);
            return false;
        }
        $reservationDag  = $nc_res_dag->row();
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $location = '<div class="row col-md-12 reza-title" style=""  align="left">
                        Location Details
                    </div> 
                    <table class="table table-bordered">
                        <tr>
                            <th style="50%">District :</th>
                            <td style="50%">'.$this->ncutility->getDistrictName($applicant->dist_code).'</td>
                       
                            <th style="50%">Sub division :</th>
                            <td style="50%">'.$this->ncutility->getSubDivName($applicant->dist_code, $applicant->subdiv_code).'</td>
                        </tr>
                        <tr>
                            <th>Circle :</th>
                            <td>'.$this->ncutility->getCircleName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code).'</td>
                        
                            <th>Mouza :</th>
                            <td>'.$this->ncutility->getMouzaName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code).'</td>
                        </tr>
                        <tr>
                            <th>Lot :</th>
                            <td>'.$this->ncutility->getLotName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code, $applicant->lot_no).'</td>
                        
                            <th>Village :</th>
                            <td>'.$this->ncutility->getVillageName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code, $applicant->lot_no, $applicant->vill_townprt_code).'</td>
                        </tr>
                        <tr>
                            <th>Dag No. :</th>
                            <td>'.$applicant->dag_no.'</td>
                        
                            <th>Patta No. :</th>
                            <td>'.$applicant->patta_no.'</td>
                        </tr>
                    </table>
                    <div class="row col-md-12 reza-title" style="margin-top: 15px"  align="left">
                        Settlement Area Details 
                    </div></h2>
                    <table class="table table-bordered">
                        <tr>
                            <th style="28%">Area </th>
                            <th style="18%">Bigha</th>
                            <th style="18%">Katha</th>
                            <th style="18%">Lessa</th>
                            <th style="18%">Ganda</th>
                        </tr>
                        <tr>
                            <th style="28%">Area in Chitha </th>
                            <td style="">'.$dagDetails->dag_area_b.'</td>
                            <td style="">'.$dagDetails->dag_area_k.'</td>
                            <td style="">'.$dagDetails->dag_area_lc.'</td>
                            <td style="">'.$dagDetails->dag_area_g.'</td>                       
                        </tr>
                        <tr>
                            <th style="20%">Settlement Homestead area </th>
                            <td style="">'.$dagDetails->home_b.'</td>
                            <td style="">'.$dagDetails->home_k.'</td>
                            <td style="">'.$dagDetails->home_lc.'</td>
                            <td style="">'.$dagDetails->home_g.'</td>                       
                        </tr>
                        <tr>
                            <th style="20%"> Settlement Agriculture area</th>
                            <td style="">'.$dagDetails->agri_b.'</td>
                            <td style="">'.$dagDetails->agri_k.'</td>
                            <td style="">'.$dagDetails->agri_lc.'</td>
                            <td style="">'.$dagDetails->agri_g.'</td>                       
                        </tr>
                        <tr>
                            <th style="20%"> Total settlement area</th>
                            <td style="">'.$dagDetails->s_dag_area_b.'</td>
                            <td style="">'.$dagDetails->s_dag_area_k.'</td>
                            <td style="">'.$dagDetails->s_dag_area_lc.'</td>
                            <td style="">'.$dagDetails->s_dag_area_lc.'</td>                       
                        </tr>
                        <tr>
                            <th style="20%"> Reservation  area</th>
                            <td style="">'.$reservationDag->bigha.'</td>
                            <td style="">'.$reservationDag->katha.'</td>
                            <td style="">'.$reservationDag->lessa.'</td>
                            <td style="">'.$reservationDag->ganda.'</td>                       
                        </tr>
                    </table>';
        }
        else
        {
            $location = '<div class="row col-md-12 reza-title" style=""  align="left">
                        Location Details
                    </div> 
                    <table class="table table-bordered">
                        <tr>
                            <th style="50%">District :</th>
                            <td style="50%">'.$this->ncutility->getDistrictName($applicant->dist_code).'</td>
                       
                            <th style="50%">Sub division :</th>
                            <td style="50%">'.$this->ncutility->getSubDivName($applicant->dist_code, $applicant->subdiv_code).'</td>
                        </tr>
                        <tr>
                            <th>Circle :</th>
                            <td>'.$this->ncutility->getCircleName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code).'</td>
                        
                            <th>Mouza :</th>
                            <td>'.$this->ncutility->getMouzaName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code).'</td>
                        </tr>
                        <tr>
                            <th>Lot :</th>
                            <td>'.$this->ncutility->getLotName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code, $applicant->lot_no).'</td>
                        
                            <th>Village :</th>
                            <td>'.$this->ncutility->getVillageName($applicant->dist_code, $applicant->subdiv_code, $applicant->cir_code,$applicant->mouza_pargona_code, $applicant->lot_no, $applicant->vill_townprt_code).'</td>
                        </tr>
                        <tr>
                            <th>Dag No. :</th>
                            <td>'.$applicant->dag_no.'</td>
                        
                            <th>Patta No. :</th>
                            <td>'.$applicant->patta_no.'</td>
                        </tr>
                    </table>
                    <div class="row col-md-12 reza-title" style="margin-top: 15px"  align="left">
                        Settlement Area Details 
                    </div></h2>
                    <table class="table table-bordered">
                        <tr>
                            <th style="40%">Area </th>
                            <th style="20%">Bigha</th>
                            <th style="20%">Katha</th>
                            <th style="20%">Lessa</th>
                        </tr>
                        <tr>
                            <th style="40%">Area in Chitha </th>
                            <td style="20%">'.$dagDetails->dag_area_b.'</td>
                            <td style="20%">'.$dagDetails->dag_area_k.'</td>
                            <td style="20%">'.$dagDetails->dag_area_lc.'</td>
                       
                        </tr>
                        <tr>
                            <th style="40%">Settlement Homestead area </th>
                            <td style="">'.$dagDetails->home_b.'</td>
                            <td style="">'.$dagDetails->home_k.'</td>
                            <td style="">'.$dagDetails->home_lc.'</td>
                       
                        </tr>
                        <tr>
                            <th style="40%"> Settlement Agriculture area</th>
                            <td style="">'.$dagDetails->agri_b.'</td>
                            <td style="">'.$dagDetails->agri_k.'</td>
                            <td style="">'.$dagDetails->agri_lc.'</td>
                       
                        </tr>
                        <tr>
                            <th style="40%"> Total settlement area</th>
                            <td style="">'.$dagDetails->s_dag_area_b.'</td>
                            <td style="">'.$dagDetails->s_dag_area_k.'</td>
                            <td style="">'.$dagDetails->s_dag_area_lc.'</td>                       
                        </tr>
                        <tr>
                            <th style="40%"> Reservation  area</th>
                            <td style="">'.$reservationDag->bigha.'</td>
                            <td style="">'.$reservationDag->katha.'</td>
                            <td style="">'.$reservationDag->lessa.'</td>
                        </tr>
                    </table>';
        }


        $nc_dags['responseType']   = 2;
        $nc_dags['location_name']  = $location;
        $nc_dags['applicant']      = $applicant;
        $nc_dags['dagDetails']     = $dagDetails;
        $nc_dags['reservationDag'] = $reservationDag;

        echo json_encode(array_merge($nc_dags));
    }


    //  update applicant (Encroacher) details with dag id
    public function updateApplicantDetailsWithDagId()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('app_id', 'Application Details', 'trim|required|is_natural|greater_than[-1]');
        if ($this->form_validation->run() == false)
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#MRDAGD0001: "  . validation_errors(),
            );
            echo json_encode($data);
            return false;
        }

        $appId    = trim($this->input->post('app_id'));
        $distCode = $this->session->userdata('dist_code');
        $applicantData = $this->SettlementApplicantModel->applicantDetailsWithAppId($distCode,$appId);
        if($applicantData->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGD0002', 'Applicant Details data not found!');
            echo json_encode($errR);
            return false;
        }

        $applicant = $applicantData->row();
        $basicExe  = $this->SettlementBasicModel->get($applicant->case_no);
        if($basicExe->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('ERRJS13020420', 'Basic data not found!');
            echo json_encode($errR);
            return false;
        }


        $basicReq = $basicExe->row();
        $location = '<table class="table table-bordered">
                        <tr>
                            <td style="20%">District :</td>
                            <td style="30%">'.$this->ncutility->getDistrictName($basicReq->dist_code).'</td>
                       
                            <td style="20%">Sub division :</td>
                            <td style="30%">'.$this->ncutility->getSubDivName($basicReq->dist_code, $basicReq->subdiv_code).'</td>
                        </tr>   
                        <tr>
                            <td>Circle :</td>
                            <td>'.$this->ncutility->getCircleName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code).'</td>
                        
                            <td>Mouza :</td>
                            <td>'.$this->ncutility->getMouzaName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code).'</td>
                        </tr>
                        <tr>
                            <td>Lot :</td>
                            <td>'.$this->ncutility->getLotName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no).'</td>
                        
                            <td>Village :</td>
                            <td>'.$this->ncutility->getVillageName($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no, $basicReq->vill_townprt_code).'</td>
                        </tr>
                        <tr>
                            <td>Name of the Encroacher :</td>
                            <td>'.$applicant->pdar_name.'</td>
                        
                            <td>Name of Guardian :</td>
                            <td>'.$applicant->pdar_guardian.'</td>
                        </tr>
                    </table>';

        $nc_dags = $this->NcLmKhaslandModel->getDagsFromChitha($basicReq->dist_code, $basicReq->subdiv_code, $basicReq->cir_code,$basicReq->mouza_pargona_code, $basicReq->lot_no, $basicReq->vill_townprt_code);
        if($nc_dags['responseType'] != 2)
        {
            echo json_encode($nc_dags);
            return false;
        }
        $nc_dags['location_name_update'] = $location;
        $nc_dags['application_no']       = $applicant->case_no;
        $nc_dags['encroach_id']          = $appId;
        echo json_encode(array_merge($nc_dags));

    }


    // update Dag Details Info For Encroacher
    public function updateDagInfoForEncroacher()
    {
        $distCode = $this->session->userdata('dist_code');

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('dist_code', 'District', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('subdiv_code', 'Sub Div', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('cir_code', 'Circle', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza', 'trim|required|min_length[1]|max_length[4]');
        $this->form_validation->set_rules('lot_no', 'Lot', 'trim|required|min_length[1]|max_length[6]');
        $this->form_validation->set_rules('vill_townprt_code', 'Village', 'trim|required|min_length[1]|max_length[7]');

        $this->form_validation->set_rules('application_no', 'Application No', 'trim|required');
        $this->form_validation->set_rules('selected_encroacher_id', 'Encroacher Name', 'trim|required|is_natural|greater_than[-1]');
        $this->form_validation->set_rules('dag_no', 'Dag No', 'trim|required|is_natural|greater_than[-1]');
        $this->form_validation->set_rules('updated_encroach_id', 'Encroacher', 'trim|required|is_natural|greater_than[-1]');

        // for barak valley
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $this->form_validation->set_rules('bigha', 'Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha', 'Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('lessa', 'Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('ganda', 'Settlement Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');

            $this->form_validation->set_rules('bigha_agri', 'Settlement Agriculture Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha_agri', 'Settlement Agriculture Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('lessa_agri', 'Settlement Agriculture Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('ganda_agri', 'Settlement Agriculture Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');

            $this->form_validation->set_rules('road_bigha', 'Road/river side Reservation Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('road_katha', 'Road/river side Reservation Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('road_lessa', 'Road/river side Reservation Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
            $this->form_validation->set_rules('road_ganda', 'Road/river side Reservation Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[320]|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('bigha', 'Settlement Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha', 'Settlement Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('lessa', 'Settlement Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('bigha_agri', 'Settlement Agriculture Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('katha_agri', 'Settlement Agriculture Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('lessa_agri', 'Settlement Agriculture Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $this->form_validation->set_rules('road_bigha', 'Road/river side Reservation Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('road_katha', 'Road/river side Reservation Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('road_lessa', 'Road/river side Reservation Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

        }
        if ($this->form_validation->run() == false)
        {
            $data = array(
                'responseType' => 0,
                'msg' => "#MRDAGU0001: "  . validation_errors(),
            );
            echo json_encode($data);
            return false;
        }

        $application_no     = trim($this->input->post('application_no'));
        $dag_no             = trim($this->input->post('dag_no'));
        $dist_code          = trim($this->input->post('dist_code'));
        $subdiv_code        = trim($this->input->post('subdiv_code'));
        $cir_code           = trim($this->input->post('cir_code'));
        $mouza_pargona_code = trim($this->input->post('mouza_pargona_code'));
        $lot_no             = trim($this->input->post('lot_no'));
        $vill_townprt_code  = trim($this->input->post('vill_townprt_code'));
        $updated_encroach_id    = trim($this->input->post('updated_encroach_id'));
        $selected_encroacher_Id = trim($this->input->post('selected_encroacher_id'));

        $chita_area = $this->ChithaBasicModel->getChitaArea($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no);
        if($chita_area->num_rows() <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU0002', 'Chitha area not found for this dag no!');
            echo json_encode($err);
            return false;
        }

        $chita_area          =  $chita_area->row();
        $totalHomestead      = 0;
        $totalAgriculture    = 0;
        $totalReservation    = 0;
        $totalSettlementArea = 0;
        $totalChithaArea     = 0;
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $bigha       = $this->ncutility->defaultValue(trim($this->input->post('bigha')), 0);
            $katha       = $this->ncutility->defaultValue(trim($this->input->post('katha')), 0);
            $lessa       = $this->ncutility->defaultValue(trim($this->input->post('lessa')), 0);
            $ganda       = $this->ncutility->defaultValue(trim($this->input->post('ganda')), 0);
            $kranti      = 0;
            $bigha_agri  = $this->ncutility->defaultValue(trim($this->input->post('bigha_agri')), 0);
            $katha_agri  = $this->ncutility->defaultValue(trim($this->input->post('katha_agri')), 0);
            $lessa_agri  = $this->ncutility->defaultValue(trim($this->input->post('lessa_agri')), 0);
            $ganda_agri  = $this->ncutility->defaultValue(trim($this->input->post('ganda_agri')), 0);
            $kranti_agri = 0;
            $road_bigha  = $this->ncutility->defaultValue(trim($this->input->post('road_bigha')), 0);
            $road_katha  = $this->ncutility->defaultValue(trim($this->input->post('road_katha')), 0);
            $road_lessa  = $this->ncutility->defaultValue(trim($this->input->post('road_lessa')), 0);
            $road_ganda  = $this->ncutility->defaultValue(trim($this->input->post('road_ganda')), 0);
            $road_kranti = 0;

            $totalHomestead   = ($bigha * 6400) + ($katha * 320) + ($lessa * 20) + $ganda;
            $totalAgriculture = ($bigha_agri * 6400) + ($katha_agri * 320) + ($lessa_agri * 20) + $ganda_agri;
            $totalReservation = ($road_bigha * 6400) + ($road_katha * 320) + ($road_lessa * 20) + $road_ganda;
            $totalChithaArea  = ($chita_area->dag_area_b * 6400) + ($chita_area->dag_area_k * 320) + ($chita_area->dag_area_lc * 20) + $chita_area->dag_area_g;

        }
        else
        {
            $bigha       = $this->ncutility->defaultValue(trim($this->input->post('bigha')), 0);
            $katha       = $this->ncutility->defaultValue(trim($this->input->post('katha')), 0);
            $lessa       = $this->ncutility->defaultValue(trim($this->input->post('lessa')), 0);
            $ganda       = 0;
            $kranti      = 0;
            $bigha_agri  = $this->ncutility->defaultValue(trim($this->input->post('bigha_agri')), 0);
            $katha_agri  = $this->ncutility->defaultValue(trim($this->input->post('katha_agri')), 0);
            $lessa_agri  = $this->ncutility->defaultValue(trim($this->input->post('lessa_agri')), 0);
            $ganda_agri  = 0;
            $kranti_agri = 0;
            $road_bigha  = $this->ncutility->defaultValue(trim($this->input->post('road_bigha')), 0);
            $road_katha  = $this->ncutility->defaultValue(trim($this->input->post('road_katha')), 0);
            $road_lessa  = $this->ncutility->defaultValue(trim($this->input->post('road_lessa')), 0);
            $road_ganda  = 0;
            $road_kranti = 0;

            $totalHomestead   = ($bigha * 100) + ($katha * 20) + $lessa;
            $totalAgriculture = ($bigha_agri * 100) + ($katha_agri * 20) + $lessa_agri;
            $totalReservation = ($road_bigha * 100) + ($road_katha * 20) + $road_lessa;
            $totalChithaArea  = ($chita_area->dag_area_b * 100) + ($chita_area->dag_area_k * 20) + $chita_area->dag_area_lc ;

        }

        $totalSettlementArea = $totalHomestead + $totalAgriculture;

        if($totalSettlementArea <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU0003', 'Settlement area cannot be zero!');
            echo json_encode($err);
            return false;
        }

        if($totalSettlementArea - $totalReservation <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU0004', 'Settlement area cannot be zero!');
            echo json_encode($err);
            return false;
        }
        if($totalSettlementArea > $totalChithaArea)
        {
            $err = $this->ncutility->errorResp('MRDAGU0005', 'Total Settlement area should not be more than total Dag Area!');
            echo json_encode($err);
            return false;
        }

        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            if(NC_KHAS_MAX_BOTH * 6400 < ($totalSettlementArea + $totalReservation))
            {
                $err = $this->ncutility->errorResp('MRDAGU0006', 'Total Settlement + Reservation area should not be more than'. NC_KHAS_MAX_BOTH. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_HOMESTEAD * 6400 < $totalHomestead)
            {
                $err = $this->ncutility->errorResp('MRDAGU0007', 'Total Settlement Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_AGRICULTURE * 6400 < $totalAgriculture)
            {
                $err = $this->ncutility->errorResp('MRDAGU0008', 'Total Settlement Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha!');
                echo json_encode($err);
                return false;
            }
        }
        else
        {
            if(NC_KHAS_MAX_BOTH * 100 < ($totalSettlementArea + $totalReservation))
            {
                $err = $this->ncutility->errorResp('MRDAGU0009', 'Total Settlement + Reservation area should not be more than '. NC_KHAS_MAX_BOTH. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_HOMESTEAD * 100 < $totalHomestead)
            {
                $err = $this->ncutility->errorResp('MRDAGU0010', 'Total Settlement Homestead area should not be more than '. NC_KHAS_MAX_HOMESTEAD. ' Bigha!');
                echo json_encode($err);
                return false;
            }
            if(NC_KHAS_MAX_AGRICULTURE * 100 < $totalAgriculture)
            {
                $err = $this->ncutility->errorResp('MRDAGU00011', 'Total Settlement Agriculture area should not be more than '. NC_KHAS_MAX_AGRICULTURE. ' Bigha!');
                echo json_encode($err);
                return false;
            }
        }

        $landTypeUpdate = 0;
        if($totalHomestead > 0 && $totalAgriculture > 0)
        {
            $landTypeUpdate = 3;
        }
        else if($totalHomestead > 0)
        {
            $landTypeUpdate = 1;
        }
        else if($totalAgriculture > 0)
        {
            $landTypeUpdate = 2;
        }


        $basic = $this->SettlementBasicModel->get($application_no);
        if($basic->num_rows() <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU00012', 'Application not found ! Please contact System Admin !');
            echo json_encode($err);
            return false;
        }
        else
        {
            $basic = $basic->row();
        }

        $applicantData = $this->SettlementApplicantModel->applicantDetailsWithAppId($distCode,$updated_encroach_id);
        if($applicantData->num_rows() <= 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGU0002', 'Applicant Details data not found!');
            echo json_encode($errR);
            return false;
        }


        $updatedApplicant = $applicantData->row();
        if($updatedApplicant->dag_no != 0)
        {
            $errR = $this->ncutility->errorResp('MRDAGU0002', 'Applicant Details data already updated!');
            echo json_encode($errR);
            return false;
        }

        //************Total Area Calculation ******************
        if (in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            //******for Barak valley */
            $areaHomeLessa  = $this->ncutility->Total_ganda($bigha,$katha,$lessa,$ganda,$kranti);
            $areaAgriLessa  = $this->ncutility->Total_ganda($bigha_agri,$katha_agri,$lessa_agri,$ganda_agri,$katha_agri);
            $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;
            $totalAreaArr   = $this->ncutility->Total_Bigha_Katha_Lessa2($totalAreaGanda);
        }
        else
        {
            $areaHomeLessa  = $this->ncutility->Total_Lessa($bigha,$katha,$lessa);
            $areaAgriLessa  = $this->ncutility->Total_Lessa($bigha_agri,$katha_agri,$lessa_agri);
            $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;
            $totalAreaArr   = $this->ncutility->Total_Bigha_Katha_Lessa($totalAreaLessa);
        }

        $encroachment_area = [
            'homestead'  => [
                'bigha'  => $bigha,
                'katha'  => $katha,
                'lessa'  => $lessa,
                'ganda'  => $ganda,
                'kranti' => $kranti,
            ],
            'agriculture' => [
                'bigha'  => $bigha_agri,
                'katha'  => $katha_agri,
                'lessa'  => $lessa_agri,
                'ganda'  => $ganda_agri,
                'kranti' => $kranti_agri,
            ],
        ];

        $user_code = $this->session->userdata('user_code');
        $encroach  = $this->LandbankModel->getEncroacherByEncroachId($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no,$selected_encroacher_Id);
        if($encroach->num_rows() <= 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU0013', 'Encroacher not found for this dag no!');
            echo json_encode($err);
            return false;
        }

        // check encroacher already exist or not
        $dagCount = $this->SettlementDagDetailsModel->checkDagAlreadyExistOrNot($dist_code,$dag_no,$basic->case_no);
        if($dagCount != 0)
        {
            $err = $this->ncutility->errorResp('MRDAGU0014', 'Selected dag already Added!');
            echo json_encode($err);
            return false;
        }

        $encroacher = $encroach->row();
        $this->db->trans_begin();

        // Save data settlement_dag_details
        $saveSetDag = [
            'dist_code'           => $dist_code,
            'subdiv_code'         => $subdiv_code,
            'cir_code'            => $cir_code,
            'mouza_pargona_code'  => $mouza_pargona_code,
            'lot_no'              => $lot_no,
            'vill_townprt_code'   => $vill_townprt_code,
            'year_no'             => date('Y'),
            'petition_no'         => $basic->petition_no,
            'is_urban'            => $basic->nc_is_urban,
            'dag_no'              => $chita_area->dag_no,
            'patta_no'            => $chita_area->patta_no,
            'patta_type_code'     => $chita_area->patta_type_code,
            'revenue'             => 0,
            'user_code'           => $user_code,
            'date_entry'          => date('Y-m-d'),
            'operation'           => 'E',
            'case_no'             => $basic->case_no,
            'new_land_class_code' => $chita_area->land_class_code,
            'land_type'           => $landTypeUpdate,
            'encroachement_area'  => json_encode($encroachment_area),
            'dag_area_b'          => $chita_area->dag_area_b,
            'dag_area_k'          => $chita_area->dag_area_k,
            'dag_area_lc'         => $chita_area->dag_area_lc,
            'dag_area_g'          => $chita_area->dag_area_g,
            'dag_area_kr'         => $chita_area->dag_area_kr,
            'home_b'              => $bigha,
            'home_k'              => $katha,
            'home_lc'             => $lessa,
            'home_g'              => $ganda,
            'home_kr'             => $kranti,
            'agri_b'              => $bigha_agri,
            'agri_k'              => $katha_agri,
            'agri_lc'             => $lessa_agri,
            'agri_g'              => $ganda_agri,
            'agri_kr'             => $kranti_agri,
            's_dag_area_b'        => $totalAreaArr[0],
            's_dag_area_k'        => $totalAreaArr[1],
            's_dag_area_lc'       => $totalAreaArr[2],
            's_dag_area_g'        => $totalAreaArr[3],
            's_dag_area_kr'       => 0,
        ];
        $insSetDag = $this->db->insert('settlement_dag_details', $saveSetDag);
        if ($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRDAGU0015: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);

            $err = $this->ncutility->errorResp('MRDAGU0015', 'Adding of Dag Details failed ! Please Contact System Admin');
            echo json_encode($err);
            return false;
        }

        // Save data settlement_area_history
        $settlementAreaHistoryArr = [
            'application_no' => $application_no,
            'case_no'        => $basic->case_no,
            'dag_no'         => $chita_area->dag_no,
            'uuid'           => $basic->uuid,
            'created_at'     => date('Y-m-d'),
            'applied_area_home_bigha'      => $bigha,
            'applied_area_home_katha'      => $katha,
            'applied_area_home_lessa'      => $lessa,
            'applied_area_home_ganda'      => $ganda,
            'applied_area_home_kranti'     => $kranti,
            'applied_area_agri_bigha'      => $bigha_agri,
            'applied_area_agri_katha'      => $katha_agri,
            'applied_area_agri_lessa'      => $lessa_agri,
            'applied_area_agri_ganda'      => $ganda_agri,
            'applied_area_agri_kranti'     => $kranti_agri,
            'settlement_area_home_bigha'   => $bigha,
            'settlement_area_home_katha'   => $katha,
            'settlement_area_home_lessa'   => $lessa,
            'settlement_area_home_ganda'   => $ganda,
            'settlement_area_home_kranti'  => $kranti,
            'settlement_area_agri_bigha'   => $bigha_agri,
            'settlement_area_agri_katha'   => $katha_agri,
            'settlement_area_agri_lessa'   => $lessa_agri,
            'settlement_area_agri_ganda'   => $ganda_agri,
            'settlement_area_agri_kranti'  => $kranti_agri,
            'total_settlement_area_bigha'  => $totalAreaArr[0],
            'total_settlement_area_katha'  => $totalAreaArr[1],
            'total_settlement_area_lessa'  => $totalAreaArr[2],
            'total_settlement_area_ganda'  => $totalAreaArr[3],
            'total_settlement_area_kranti' => 0,
            'leftout_area_home_bigha'      => 0,
            'leftout_area_home_katha'      => 0,
            'leftout_area_home_lessa'      => 0,
            'leftout_area_home_ganda'      => 0,
            'leftout_area_home_kranti'     => 0,
            'leftout_area_agri_bigha'      => 0,
            'leftout_area_agri_katha'      => 0,
            'leftout_area_agri_lessa'      => 0,
            'leftout_area_agri_ganda'      => 0,
            'leftout_area_agri_kranti'     => 0,
            'total_leftout_area_bigha'     => 0,
            'total_leftout_area_katha'     => 0,
            'total_leftout_area_lessa'     => 0,
            'total_leftout_area_ganda'     => 0,
            'total_leftout_area_kranti'    => 0,
            'actual_encroachment_area_home_bigha'   => $bigha,
            'actual_encroachment_area_home_katha'   => $katha,
            'actual_encroachment_area_home_lessa'   => $lessa,
            'actual_encroachment_area_home_ganda'   => $ganda,
            'actual_encroachment_area_home_kranti'  => $kranti,
            'actual_encroachment_area_agri_bigha'   => $bigha_agri,
            'actual_encroachment_area_agri_katha'   => $katha_agri,
            'actual_encroachment_area_agri_lessa'   => $lessa_agri,
            'actual_encroachment_area_agri_ganda'   => $ganda_agri,
            'actual_encroachment_area_agri_kranti'  => $kranti_agri,
            'total_actual_encroachment_area_bigha'  => $totalAreaArr[0],
            'total_actual_encroachment_area_katha'  => $totalAreaArr[1],
            'total_actual_encroachment_area_lessa'  => $totalAreaArr[2],
            'total_actual_encroachment_area_ganda'  => $totalAreaArr[3],
            'total_actual_encroachment_area_kranti' => 0,
        ];
        $insertAreaHis = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);
        if ($insertAreaHis != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRDAGU0016: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
            $err = $this->ncutility->errorResp('MRDAGU0016', 'Adding of Dag Details failed ! Please Contact System Admin');
            echo json_encode($err);
            return false;
        }


        // Update Encroacher in settlement_applicant
        $applicantUpdateArray = [
            'dag_no'             => $chita_area->dag_no,
            'patta_no'           => $chita_area->patta_no,
            'patta_type_code'    => $chita_area->patta_type_code,
            'date_entry'         => date('Y-m-d'),
            'pdar_gender'        => $encroacher->gender,
            'pdar_rel_guar'      => 0,
            'enc_id'             => $encroacher->id,
            'period_possession'  => $encroacher->encroachment_from,
            'pdar_name'          => $encroacher->name,
            'pdar_guardian'      => $encroacher->fathers_name,
        ];

        $this->db->where('id', $updated_encroach_id);
        $this->db->where('case_no', $application_no);
        $this->db->where('pdar_type', 'EN');
        $updateSetApplicant = $this->db->update('settlement_applicant', $applicantUpdateArray);
        if ($updateSetApplicant != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRDAGU0017: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
            $err = $this->ncutility->errorResp('MRDAGU0017', 'Adding of Dag Details failed ! Please Contact System Admin');
            echo json_encode($err);
            return false;
        }

        // save data settlement_reservation
        $reservedArea = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_townprt_code,
            'dag_no'             => $chita_area->dag_no,
            'patta_no'           => $chita_area->patta_no,
            'case_no'            => $basic->case_no,
            'lm_code'            => $user_code,
            'date_entry'         => date('Y-m-d h:i:s'),
            'date_update'        => date('Y-m-d h:i:s'),
            'type'               => 'R',
            'applid'             => $basic->applid,
            'bigha'              => $road_bigha,
            'katha'              => $road_katha,
            'lessa'              => $road_lessa,
            'ganda'              => $road_ganda,
            'kranti'             => $road_kranti
        ];
        $reserveData = $this->db->insert('settlement_reservation', $reservedArea);
        if ($reserveData != 1) {
            $this->db->trans_rollback();
            log_message('error', '#MRDAGU0018: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
            $err = $this->ncutility->errorResp('MRDAGU0018', 'Adding of Dag Details failed ! Please Contact System Admin');
            echo json_encode($err);
            return false;
        }


        $this->db->trans_commit();
        $err = $this->ncutility->successResp('MRDAGU0000', 'Encroacher Details successfully Updated');
        echo json_encode($err);
        return false;
    }





































}