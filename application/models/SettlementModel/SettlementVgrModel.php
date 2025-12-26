<?php
class SettlementVgrModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no){
        $get_riotees = $this->db->select()
            ->where('dist_code',$d)
            ->where('subdiv_code',$s)
            ->where('cir_code',$c)
            ->where('mouza_pargona_code',$m)
            ->where('lot_no',$l)
            ->where('vill_townprt_code',$v)
            ->where('dag_no',$dag)
            ->where('khatian_no',$khatian_no)

            ->get('chitha_tenant');

        return $get_riotees->result();
    }

    // get all settlement basic
    public function getSettlementBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_basic');
        return $basic->row_array();
    }

    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant encroacher
    public function getAllApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // get all applicant riotee nok
    public function getAllApplicantRioteeNok($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where_in('pdar_type', ['GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get all settlement tenant lm note
    public function getSettlementTenantLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_ap_lmnote');

        return $lmnotes->result();
    }

    // get all settlement proceeding
    public function getSettlementProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getDocuments($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }

    public function getVillageList($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
        //$db=  $this->session->userdata('db');
        $village = $this->db->query("select loc_name AS village, vill_townprt_code AS vill_code, uuid from location where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code <> '00000'");
        return $village->result();
    }

    // get all settlement reservation
    public function getSettlementReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted', 0)
            ->get('settlement_reservation');

        return $lmnotes->result();
    }

    public function getSettlementVgrReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_vgr_pgr_reservation');
        return $lmnotes->row();
    }

    // get all settlement reservation roadside
    public function getSettlementReservationRoad($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted', 0)
            ->where('type', 'R')
            ->get('settlement_reservation');

        return $lmnotes->result();
    }

    // get all settlement proceeding
    public function getAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_additional_property');

        return $property->result();
    }

    public function getClusterCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code)
    {
        return $sqlProcessedCount = $this->db->query('select * from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ? and status in (\'AA\', \'D\', \'F\',\'N\',\'M\') AND pending_officer IN (\'CO\')', array($dist_code, $subdiv_code, $cir_code, (string)$mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code,));
    }

    public function getForwardedFromCO($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code)
    {
        return $forwardFromCoSql = $this->db->query('select * from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ? AND pending_officer NOT IN (\'LM\', \'SK\', \'CO\') AND status NOT IN (\'D\', \'F\')', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code));
        // echo $this->db->last_query();
    }

    public function getVillageClusters($dist_code, $subdiv_code, $cir_code, $status, $service_code)
    {
        $sql = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and status = ? and service_code = ? group by dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code', array($dist_code, $subdiv_code, $cir_code, $status, $service_code));

        if($sql->num_rows() <= 0)
        {
            return false;
        }

        //*******getting the cases in the cluster  */

        $result = $sql->result();

        $clusterList = array();

        foreach($result as $re)
        {
            $clusterCases = $this->getClusterCases($re->dist_code, $re->subdiv_code, $re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code,  $service_code);

            $getForwardedFromCO = $this->getForwardedFromCO($re->dist_code, $re->subdiv_code, $re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code,  $service_code);

            $url = API_LINK_MB2.'getCaseCountByVillage/'.$re->dist_code.'/'.$re->subdiv_code.'/'.$re->cir_code.'/'.$re->mouza_pargona_code.'/'.$re->lot_no.'/'.$re->vill_townprt_code.'/'.$service_code;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: ci_session=p7qii4c6rijf4sujchqe2h8vc87u41lb'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $total_application = 0;
            if($response != null)
            {
                $apiToalCase = json_decode($response);
                $total_application = (int)$apiToalCase[0]->total;
                $total_processed = (int)$clusterCases->num_rows() + (int)$getForwardedFromCO->num_rows();
            }

            $clusterList[] = (object)[
                'dist_code' => $re->dist_code,
                'subdiv_code' => $re->subdiv_code,
                'cir_code' => $re->cir_code,
                'mouza_pargona_code' => $re->mouza_pargona_code,
                'lot_no' => $re->lot_no,
                'vill_townprt_code' => $re->vill_townprt_code,
                'total_api_case' => $total_application,
                'total_clustered' => $total_processed,
                'mouza_name' => $this->utilityclass->getMouzaName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code),
                'lot_name' => $this->utilityclass->getLotName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code, $re->lot_no),
                'village_name' => $this->utilityclass->getVillageName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code),

                'completed_out_of' => $total_processed.'/'.$total_application,
            ];
        }

        return $clusterList;
    }

    public function getNoticeData($case_no)
    {
        return $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', array($case_no, 'GN'));
    }

    public function getNoticeDataReservation($case_no)
    {
        return $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', array($case_no, 'GNR'));
    }

    public function getTotalVgrReservationInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $message = array();

        $totalChitaLessa = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS chitha_total_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no))->row()->chitha_total_lessa;
        

        $sqlReservation = $this->db->query("select  string_agg(CONCAT('''', case_no, ''''), ',') as case_nos from settlement_vgr_pgr_reservation where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

        if($sqlReservation->num_rows() > 0)
        {
            $reservCaseNos = $sqlReservation->row()->case_nos;

            if($reservCaseNos != null)
            {
                $getTotalReservArea = $this->db->query("SELECT SUM(b.s_dag_area_b*100 + b.s_dag_area_k*20 + b.s_dag_area_lc) AS reserve_total_lessa FROM settlement_dag_details b join settlement_basic a on b.case_no = a.case_no WHERE a.case_no in ($reservCaseNos) and a.status != ?", array('D'));

                if($getTotalReservArea->num_rows() <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Reservation dag not found in chitha!</b></h5>'
                    );
                }
                else
                {
                    $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;

                    if($getTotalReservArea > $totalChitaLessa)
                    {
                        $message = array(
                            'responseType' => 0,
                            'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                        );
        
                    }
                    else
                    {
                        $message = array(
                            'responseType' => 2,
                        );
                    }
                }
            }
            else
            {
                if($totalChitaLessa <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                    );
    
                }
                else
                {
                    $message = array(
                        'responseType' => 2,
                    );
                }
            }
           
        }
        else
        {
            if($totalChitaLessa <= 0)
            {
                $message = array(
                    'responseType' => 0,
                    'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                );

            }
            else
            {
                $message = array(
                    'responseType' => 2,
                );
            }
        }

        return $message;
    }

    public function getTotalVgrReservationInDagSubmitCheck($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $total_applied_lessa)
    {
        $message = array();

        $totalChitaLessa = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS chitha_total_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no))->row()->chitha_total_lessa;
        

        $sqlReservation = $this->db->query("select  string_agg(CONCAT('''', case_no, ''''), ',') as case_nos from settlement_vgr_pgr_reservation where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

        if($sqlReservation->num_rows() > 0)
        {
            $reservCaseNos = $sqlReservation->row()->case_nos;

            if($reservCaseNos != null)
            {
                $getTotalReservArea = $this->db->query("SELECT SUM(b.s_dag_area_b*100 + b.s_dag_area_k*20 + b.s_dag_area_lc) AS reserve_total_lessa FROM settlement_dag_details b join settlement_basic a on b.case_no = a.case_no WHERE a.case_no in ($reservCaseNos) and a.status != ?", array('D'));

                if($getTotalReservArea->num_rows() <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Reservation dag not found in chitha!</b></h5>'
                    );
                }
                else
                {
                    $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;
    
                    if($getTotalReservArea + $total_applied_lessa > $totalChitaLessa)
                    {
                        $message = array(
                            'responseType' => 0,
                            'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                        );
        
                    }
                    else
                    {
                        $message = array(
                            'responseType' => 2,
                        );
                    }
                }   
            }
            else
            {
                if($total_applied_lessa > $totalChitaLessa)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                    );
    
                }
                else
                {
                    $message = array(
                        'responseType' => 2,
                    );
                }
            }
           
        }
        else
        {
            // $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;

            if($total_applied_lessa > $totalChitaLessa)
            {
                $message = array(
                    'responseType' => 0,
                    'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                );

            }
            else
            {
                $message = array(
                    'responseType' => 2,
                );
            }
        }

        return $message;
    }

}