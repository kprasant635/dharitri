<?php
class reclassModel extends CI_Model {
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
            ->get('reclass_suite_basic');
        return $basic->row_array();
    }

    function getReclassBasicCo($case_no){
        $query = "SELECT * FROM reclass_suite_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    public function getCurrentBasicStatusReclass($case_no)
    {
        $sql = $this->db->query("SELECT status FROM reclass_suite_basic WHERE case_no = ?", array($case_no));

        if ($sql->num_rows() > 0) {
            return $sql->row()->status;
        } else {
            return 'n';
        }
    }

    public function getPartionInfo($case_no)
    {
        $sql = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and is_partition = ?", array($case_no,'Y'));

        if ($sql->num_rows()<=0) {
           return 'N';
        } else {
            return 'Y';
        }
    }

    public function getPartionInfoforCO($case_no)
    {
        $sql = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and co_is_partition = ?", array($case_no,'Y'));

        if ($sql->num_rows()<=0) {
           return 'N';
        } else {
            return 'Y';
        }
    }

    public function getWetLandInfo($case_no)
    {
        $sql = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and is_wet_land = ?", array($case_no,'Y'));
        if ($sql->num_rows()<=0) {
           return 'N';
        } else {
            return 'Y';
        }
    }

    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->order_by('is_applicant', 'desc')
            ->get('reclass_applicant');
        return $applicants->result();
    }

    // get all applicant buyers
    public function getAllReclassBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->get('reclass_cum_transfer_buyer');
        return $applicants->result();
    }

    // get all other data
    public function getAllReclassOtherData($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_cum_transfer_other_data');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('reclass_applicant');
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
            ->where_in('pdar_type', ['P','GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_dag_details');

        return $dags->result();
    }

    public function getSettlementDagPart($case)
    {
        $dags = $this->db->select()
            ->where('case_no', $case)
            ->where('is_eligible !=', 'N') // Add this condition
            ->get('reclass_dag_details');

        return $dags->result();
    }


    public function getSettlementDagforPartition($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->where('co_is_partition','Y')
            ->get('reclass_dag_details');

        return $dags->result();
    }

    public function getAllApplicantPartitionPartial($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_partition_info');
        return $applicants->result();
    }



    // get all settlement tenant lm note
    public function getSettlementTenantLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->order_by('id', 'DESC')
            ->limit(1)
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
        $applicaiton_no = $this->utilityclass->getApplidFromCaseNoReclass($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
            ->get('settlement_additional_property');

        return $property->result();
    }


    //17/01/2022
    // get main buyer applicant
    public function getMainApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->where('is_applicant', '1')
            ->get('reclass_applicant');
        return $applicants->row();
    }

     public function getMainApplicantPayment($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            // ->where('is_applicant', '1')
            ->get('reclass_applicant');
        return $applicants->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_applicant');
        return $applicants->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }

    public function getJsonDataFromBackup($case_no)
    {
        $sql = $this->db->query("SELECT data FROM settlement_backup_json WHERE case_no = ? AND status = ?", array($case_no, 'I'));
        if($sql->num_rows() > 0){
            return $sql->row();
        }
        else
        {
            return false;
        }
    }

    // get all settlement deleted dags
    public function getDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details_deleted');

        return $dags->result();
    }

    public function locationSelect($service_code, $status)
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM reclass_suite_basic WHERE service_code = $service_code  and pending_officer = 'CO' AND status = '$status' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql); //->num_rows()>0 ? $this->db->query($sql)->result() :null;
        if ($data->num_rows() > 0) {
            $result = $this->db->query($sql)->result();
        } else {
            $result = null;
        }
        return $result;

    }

    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql = "Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code));
        $lot_array = array();
        if ($data->num_rows() > 1) {
            $sql1 = "Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1 = $this->db->query($sql1, array($dist_code, $subdiv_code, $cir_code, $user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code . '_' . $value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if (!empty($lot_array) && $lot_array != null) {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error", "MB002: LOT STRING====FOR CIRCLE==D" . $dist_code . "S" . $subdiv_code . "C" . $cir_code . "==" . json_encode($lot_string));
        return $lot_string;
    }

    public function getAllApplicantDagDetails($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where("pdar_type IN ('EP','DA')")
            ->get('settlement_applicant');
        return $applicants->result();
    }

     public function getAllExistingPattadar($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EP')
            ->get('settlement_applicant');
        return $applicants->result();
    }

     public function getAllBuyer($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->get('reclass_cum_transfer_buyer');
        return $applicants->result();
    }

     public function getAllOtherLand($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_cum_transfer_other_data');
        return $applicants->result();
    }

    public function getDagEligibility($case,$dag)
    {
        $dag_data = $this->db->select()
            ->where('case_no',$case)
            ->where('dag_no', $dag)
            ->get('reclass_dag_eligibility');
        return $dag_data->result();
    }


    public function reclassNoticeCases()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = '14' AND (pending_officer = 'CO' or pending_officer = 'LM') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";
        $sql = "SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code FROM reclass_suite_basic WHERE service_code = '40' AND pending_officer = 'AST' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code";

        $data = $this->db->query($sql);

        return $data->result();

    }

     public function getPaymentNoticeCoReclass($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_REQUEST);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    ///for co settlements
    function getSettlementBasicCo($case_no){
        $query = "SELECT * FROM reclass_suite_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }


     public function getPaymentConfirmationCo($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $this->db->where('co_chitha_corrected_yn', null);
        $this->db->where('co_chitha_corrected_date', null);
        $this->db->where('order_passed', null);
        return $this->db->get()->result_array();
        // echo $this->db->last_query();
    }

     function getSettlementPremium($case_no){
        $query = "SELECT * FROM settlement_premium WHERE case_no = '$case_no' and is_final=1";
        $data = $this->db->query($query)->row();
        return $data;
    }
    

     public function getDcRevertedCases()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        // $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where_in('status', 'R');
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }


    public function getDagWiseCaseApprovalInfo($case_no)
    {

        $sql = $this->db->query("SELECT rdd.* FROM reclass_dag_details rdd join settlement_premium rde on rdd.case_no = rde.case_no WHERE rdd.case_no = ? and rde.penalty_rate = ? and rde.is_final = ?", array($case_no,5,1));


        if($sql->num_rows()>0)
        {
            $approval_by = 'GOVT';
            $is_dlc = 'Y';

            $approval_authority= [
                    'case_no' => $case_no,
                    'approval_by' => $approval_by,
                    'is_dlc' => $is_dlc,
                ];

                $approval_authority = $this->db->insert('reclass_approval_authority', $approval_authority);
                if($approval_authority != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#APPROVE001: Insertion failed in reclass_approval_authority RTPS Case No '.$case_no);

                    //$this->session->set_flashdata('message', "#APPROVE001: Registration of Reclassification failed for case no : ".$case_no);
                    //redirect(base_url() . "index.php/home");
                    return false;
                }

                else
                {
                    // return true;
                    $query = "SELECT * FROM reclass_approval_authority WHERE case_no = '$case_no' order by id desc";
                    $data = $this->db->query($query)->row();
                    return $data;
                }
        }


        else
        {

        // $sql = $this->db->query("SELECT rdd.* FROM reclass_dag_details rdd join reclass_dag_eligibility rde on rdd.case_no = rde.case_no WHERE rdd.case_no = ? and rde.is_agri_to_nonagri = ? and rde.status = ? and rde.is_not_culti_ten = ?", array($case_no,'Y',1,'N'));
        // if($sql->num_rows()>0)
        // {
        //     $approval_by = 'GOVT';
        //     $is_dlc = 'Y';

        //     $approval_authority= [
        //             'case_no' => $case_no,
        //             'approval_by' => $approval_by,
        //             'is_dlc' => $is_dlc,
        //         ];

        //         $approval_authority = $this->db->insert('reclass_approval_authority', $approval_authority);
        //         if($approval_authority != 1)
        //         {
        //             $this->db->trans_rollback();
        //             log_message('error', '#APPROVE001: Insertion failed in reclass_approval_authority RTPS Case No '.$case_no);

        //             //$this->session->set_flashdata('message', "#APPROVE001: Registration of Reclassification failed for case no : ".$case_no);
        //             //redirect(base_url() . "index.php/home");
        //             return false;
        //         }

        //         else
        //         {
        //             // return true;
        //             $query = "SELECT * FROM reclass_approval_authority WHERE case_no = '$case_no' order by id desc";
        //             $data = $this->db->query($query)->row();
        //             return $data;
        //         }
        // }

        // else
        // {

            $sql = $this->db->query("SELECT exit_lc_by_lm FROM reclass_dag_details  WHERE case_no = ? group by exit_lc_by_lm", array($case_no));

            if ($sql->num_rows()<=0) 
            {
               return 'N';
            } 
            else 
            {
                $data = $sql->result_array();
                $validValues = json_decode(NON_AGRI);

                $data_exist_lc = array_column($data, 'exit_lc_by_lm');
                $data_new= array_intersect($data_exist_lc, $validValues);

                // var_dump($data_new);exit;
                // if(!in_array($data, json_decode(NON_AGRI)))
                if(empty($data_new))
                {
                    //checking if residential or not
                    $sql_prop = $this->db->query("SELECT prop_lc_cat_id FROM reclass_dag_details  WHERE case_no = ? group by prop_lc_cat_id", array($case_no));
                    $data_prop = $sql_prop->result_array();

                    $validValuesnonresi = json_decode(NON_RESIDENTIAL);
                    $data_prop_lc = array_column($data_prop, 'prop_lc_cat_id');
                    $data_new_prop= array_intersect($data_prop_lc, $validValuesnonresi);

                    if(empty($data_new_prop))
                    {
                        //checking land area more than 1 bigha or not//
                        $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? ", array($case_no));
                        $data2 = $sql2->result();

                        $sum_area = 0;
                        foreach($data2 as $d)
                        {
                        
                            if($d->co_is_partition=='Y' && $d->co_is_full_partition=='N')
                            {
                                if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                                {
                                $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                                }
                                else
                                {
                                $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                                }

                                $sum_area+= $dag_area->sarea;
                            }

                            else
                            {
                                if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                                {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                                }
                                else
                                {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                                }

                                $sum_area+= $dag_area->sarea;

                            }

                        }

                        $sql_basic = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ?", array($case_no));

                        $sql_basic_data = $sql_basic->row();

                        if($sql_basic_data->applicant_type =='I')
                        {

                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {
                                if($sum_area <= 6400)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'N';
                                }

                                else if($sum_area > 6400 && $sum_area <= 64000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 64000 && $sum_area <= 320000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 320000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                            else
                            {
                                if($sum_area <= 100)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'N';
                                }

                                else if($sum_area > 100 && $sum_area <= 1000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 1000 && $sum_area <= 5000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 5000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }

                        }

                        else if($sql_basic_data->applicant_type =='N')
                        {
                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {

                                if($sum_area <= 6400)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'N';
                                }

                                else if($sum_area > 6400 && $sum_area < 32000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area >= 32000 && $sum_area <= 640000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 640000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                            else
                            {

                                if($sum_area <= 100)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'N';
                                }

                                else if($sum_area > 100 && $sum_area < 5000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area >= 5000 && $sum_area <= 10000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 10000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }

                        }

                        else
                        {
                            $approval_by = 'DC';
                            $is_dlc = 'Y';
                        }
                    }

                    else if(!empty($data_new_prop))
                    {
                        $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? ", array($case_no));

                        $data2 = $sql2->result();

                        $sum_area = 0;
                        foreach($data2 as $d)
                        {
                            

                            if($d->is_partition=='Y' && $d->is_full_partition=='N')
                            {
                                if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                                {
                                $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                                }
                                else
                                {
                                $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                                    from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                                }

                                $sum_area+= $dag_area->sarea;
                            }

                            else
                            {
                                if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                                {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                                }
                                else
                                {
                                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                                }

                                $sum_area+= $dag_area->sarea;
                            }
                        }


                        $sql_basic = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ?", array($case_no));

                        $sql_basic_data = $sql_basic->row();

                        if($sql_basic_data->applicant_type =='I')
                        {
                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {
                                if($sum_area <= 6400)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 6400 && $sum_area <= 64000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 64000 && $sum_area <= 320000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 320000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                            else
                            {
                                if($sum_area <= 100)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 100 && $sum_area <= 1000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 1000 && $sum_area <= 5000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 5000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                        }

                        else if($sql_basic_data->applicant_type =='N')
                        {
                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {
                                if($sum_area <= 6400)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 6400 && $sum_area < 320000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area >= 320000 && $sum_area <= 640000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 640000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                            else
                            {
                                if($sum_area <= 100)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 100 && $sum_area < 5000)
                                {
                                    $approval_by = 'DC';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area >= 5000 && $sum_area <= 10000)
                                {
                                    $approval_by = 'DLR';
                                    $is_dlc = 'Y';
                                }

                                else if($sum_area > 10000)
                                {
                                    $approval_by = 'GOVT';
                                    $is_dlc = 'Y';
                                }
                            }
                        }
                    }
                }

                // else if(in_array($data, json_decode(NON_AGRI)))
                else if(!empty($data_new))
                {
                    //checking land area more than 1 bigha or not//
                    $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? ", array($case_no));
                    $data2 = $sql2->result();

                    $sum_area = 0;
                    foreach($data2 as $d)
                    {
                        

                        if($d->co_is_partition=='Y' && $d->co_is_full_partition=='N')
                        {
                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {
                            $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                                from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                            }
                            else
                            {
                            $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                                from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                            }

                            $sum_area+= $dag_area->sarea;
                        }
                        else
                        {
                            if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                            {
                            $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                            }
                            else
                            {
                            $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                            }
                            $sum_area+= $dag_area->sarea;
                        }
                    }

                    $sql_basic = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ?", array($case_no));

                    $sql_basic_data = $sql_basic->row();

                    if($sql_basic_data->applicant_type =='I')
                    {
                        if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                        {
                            if($sum_area <= 6400)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 6400 && $sum_area <= 320000)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 320000)
                            {
                                $approval_by = 'GOVT';
                                $is_dlc = 'Y';
                            }
                        }
                        else
                        {
                            if($sum_area <= 100)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 100 && $sum_area <= 5000)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 5000)
                            {
                                $approval_by = 'GOVT';
                                $is_dlc = 'Y';
                            }
                        }

                    }

                    else if($sql_basic_data->applicant_type =='N')
                    {
                        if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                        {
                            if($sum_area <= 6400)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 6400 && $sum_area <= 320000)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area >= 320000 && $sum_area <= 640000)
                            {
                                $approval_by = 'DLR';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 640000)
                            {
                                $approval_by = 'GOVT';
                                $is_dlc = 'Y';
                            }
                        }

                        else
                        {
                            if($sum_area <= 100)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 100 && $sum_area <= 5000)
                            {
                                $approval_by = 'DC';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area >= 5000 && $sum_area <= 10000)
                            {
                                $approval_by = 'DLR';
                                $is_dlc = 'Y';
                            }

                            else if($sum_area > 10000)
                            {
                                $approval_by = 'GOVT';
                                $is_dlc = 'Y';
                            }
                        }
                    }
                }


                $approval_authority= [
                    'case_no' => $case_no,
                    'approval_by' => $approval_by,
                    'is_dlc' => $is_dlc,
                    'sum_area_lessa' => $sum_area
                ];

                $approval_authority = $this->db->insert('reclass_approval_authority', $approval_authority);
                if($approval_authority != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#APPROVE001: Insertion failed in reclass_approval_authority RTPS Case No '.$case_no);

                    //$this->session->set_flashdata('message', "#APPROVE001: Registration of Reclassification failed for case no : ".$case_no);
                    //redirect(base_url() . "index.php/home");
                    return false;
                }

                else
                {
                    // return true;
                    $query = "SELECT * FROM reclass_approval_authority WHERE case_no = '$case_no' order by id desc";
                    $data = $this->db->query($query)->row();
                    return $data;
                }
            }
        }
    }


    public function insertPartialdata($case_no,$dag_no,$dags_data,$uuid,$prem_rate_section,$co_penalty)
    {

     $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data[0]->dist_code, $dags_data[0]->subdiv_code, $dags_data[0]->cir_code, $dags_data[0]->mouza_pargona_code, $dags_data[0]->lot_no, $dags_data[0]->vill_townprt_code, $dag_no))->row();
                            
      $tot_bigha = $dag_area->dag_area_b;
      $tot_katha = $dag_area->dag_area_k;
      $tot_lessa = $dag_area->dag_area_lc;
      $tot_ganda = $dag_area->dag_area_g;

        if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
        {

            $bigha_part_co = $this->input->post('bigha_part_co'.$dag_no);
            $katha_part_co = $this->input->post('katha_part_co'.$dag_no);
            $lessa_part_co = $this->input->post('lessa_part_co'.$dag_no);
            $ganda_part_co = $this->input->post('ganda_part_co'.$dag_no);


            $total_dag_area = ($tot_bigha * 6400) + ($tot_katha * 320) + ($tot_lessa * 20) + $tot_ganda;
            $total_dag_area_in_lessa = ($total_dag_area/6400);

            $total_p_dag_area = ($bigha_part_co * 6400) + ($katha_part_co * 320) + ($lessa_part_co * 20) + $ganda_part_co; //total area
            $total_p_dag_in_lessa = ($total_p_dag_area/6400);

            if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
            {
                $this->db->trans_rollback();
                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);
                $data = array(
                'error' => "#PART0013: For Partial reclass, Applied area and total area of Dag can not be equal..You can choose Full reclass with Partition",
                );
                echo json_encode($data);
                return false;
            }
            if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
            {
                $this->db->trans_rollback();
                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);
                $data = array(
                'error' => "#PART0013: For Partial reclass, Applied area can not be more than total area of Dag..You can choose Full reclass with Partition",
                );
                echo json_encode($data);
                return false;
            }

            $co_area_b = $bigha_part_co;
            $co_area_k = $katha_part_co;
            $co_area_lc = $lessa_part_co;
            $co_area_g = $ganda_part_co;
        }
        else
        {

            $bigha_part_co = $this->input->post('bigha_part_co'.$dag_no);
            $katha_part_co = $this->input->post('katha_part_co'.$dag_no);
            $lessa_part_co = $this->input->post('lessa_part_co'.$dag_no);

            $total_dag_area = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa; //total area
            $total_dag_area_in_lessa = ($total_dag_area/100);

            $total_p_dag_area = ($bigha_part_co * 100) + ($katha_part_co * 20) + $lessa_part_co; //total area
            $total_p_dag_in_lessa = ($total_p_dag_area/100);

            if($total_dag_area_in_lessa == $total_p_dag_in_lessa)
            {
                $this->db->trans_rollback();
                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);
                $data = array(
                'error' => "#PART0013: For Partial reclass applied area and total area of Dag can not be equal..You can choose Full reclass with Partition",
                );
                echo json_encode($data);
                return false;
            }

            if($total_dag_area_in_lessa < $total_p_dag_in_lessa)
            {
                $this->db->trans_rollback();
                log_message('error', '#PART0013: Insertion failed in reclass_partition_info RTPS Case No '.$case_no);
                $data = array(
                'error' => "#PART0013: For Partial reclass applied area can not be more than total area of Dag..You can choose Full reclass with Partition",
                );
                echo json_encode($data);
                return false;
            }
            $co_area_b = $bigha_part_co;
            $co_area_k = $katha_part_co;
            $co_area_lc = $lessa_part_co;
            $co_area_g = 0;
        }


        $is_partion = 'Y';
        $is_full_partition = 'N';

        $fmddata= [
                    'date_entry' => date('Y-m-d'),
                    'co_is_partition' => $is_partion,
                    'co_is_full_partition' => $is_full_partition,
                    'co_area_b' =>$co_area_b,
                    'co_area_k' =>$co_area_k,
                    'co_area_lc'=>$co_area_lc,
                    'co_area_g' =>$co_area_g,
                    'penalty_rate'=>$prem_rate_section,
                    'co_penalty' =>$co_penalty
                ];
        $this->db->where('case_no', $case_no);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('reclass_dag_details', $fmddata);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
            $data = array(
                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }

        //premium calculation//

          $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and dag_no ='$dag_no' and user_code like 'M%' order by pid desc limit 1")->row();
          $district['premiumData'] = $premiumData;

          $reclass_dag_data = $this->db->query("Select * from reclass_dag_details where case_no='$case_no' and dag_no ='$dag_no'")->row();

            // var_dump($premiumData->rate);exit;

          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
          {
              $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
              from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
          }
          else
          {
              $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
              from reclass_dag_details where dag_no = ? and case_no = ?",array($dag_no,$case_no))->row();
          }

          $sum_area = $dag_area->sarea;

          // var_dump($sum_area);exit;

          $prem_zonal1 = $this->utilityclass->getZonalValue($dist_code,$uuid,$dag_no);
          // $ratepr = $premiumData->rate;


           if($premiumData->rate_type==1 && $reclass_dag_data->prop_lc_cat_id==2)
            {
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($sum_area<=6400)
                    {
                        $ratepr = 0;
                    }
                    else
                    {
                         $ratepr = $premiumData->rate;
                    }
                }
                else
                {
                    if($sum_area<=100)
                    {
                        $ratepr = 0;
                    }
                    else
                    {
                         $ratepr = $premiumData->rate;
                    }
                }
            }
            else
            {
                $ratepr = $premiumData->rate;
            }

          $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
          }
          else
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
          }

          $sumMbAmount = $sum_area * $premium_zonal_per_lessa;
          //$sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;

          if($reclass_dag_data->is_penalty == 'Y')
          {
            $premium_without_penalty = $sumMbAmount;
          }

          else
          {
            $premium_without_penalty = null;
          }


              $fmd=array(
                  'case_no'=>$case_no,
                  'user_code'=>$this->session->userdata('user_code'),
                  'uuid'=>$uuid,
                  'dag_no'=>$dag_no,
                  'zonal_valuation'=>$premiumData->zonal_valuation,
                  'land_type'=>$premiumData->land_type,
                  'rate_type'=>$premiumData->rate_type,
                  'rate'=>$premiumData->rate,
                  'amount_dag'=>$sumMbAmount,
                  // 'final_amount'=>$sumMbAmountTotal,
                  // 'due_amount'=>$sumMbAmountTotal,
                  'total_lessa'=>$sum_area,
                  //'is_full_pay'=>$this->input->post('paymode'),
                  'is_final'=>1,
                  'date_entry'=>date('Y-m-d h:i:s'),
                  'penalty_rate' => $prem_rate_section,
                  'premium_without_penalty' => $premium_without_penalty

              );

              $insPremium = $this->db->insert('settlement_premium', $fmd);

              if ($insPremium != 1) {
                  $this->db->trans_rollback();
                  log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                  $data = array(
                      'error'=>"#ERRSET000101: Registration of Reclassification failed for case no : ".$application_no
                  );
                  echo json_encode($data);
                  return false;
              }

              $data = array('response'=>'true',
                'sumMbAmount'=>$sumMbAmount);

        return $data;


    }


    public function insertFullReclasswithPartitiondata($case_no,$dag_no,$dags_data,$uuid,$prem_rate_section)
    {
       // var_dump($dags_data->dist_code);exit;

        $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
                            
        $tot_bigha = $dag_area->dag_area_b;
        $tot_katha = $dag_area->dag_area_k;
        $tot_lessa = $dag_area->dag_area_lc;
        $tot_ganda = $dag_area->dag_area_g;

        $is_partion = 'Y';
        $is_full_partition = 'Y';

        $co_area_b = $tot_bigha;
        $co_area_k = $tot_katha;
        $co_area_lc = $tot_lessa;
        $co_area_g = $tot_ganda;

        $fmddata= [
                    'date_entry' => date('Y-m-d'),
                    'co_is_partition' => $is_partion,
                    'co_is_full_partition' => $is_full_partition,
                    'co_area_b' =>$co_area_b,
                    'co_area_k' =>$co_area_k,
                    'co_area_lc'=>$co_area_lc,
                    'co_area_g' =>$co_area_g,
                    'penalty_rate' => $prem_rate_section
                ];
        $this->db->where('case_no', $case_no);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('reclass_dag_details', $fmddata);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
            $data = array(
                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }

        //premium calculation//

          $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and dag_no ='$dag_no' and user_code like 'M%' order by pid desc limit 1")->row();
          $district['premiumData'] = $premiumData;


          $reclass_dag_data = $this->db->query("Select * from reclass_dag_details where case_no='$case_no' and dag_no ='$dag_no'")->row();

          //  var_dump($premiumData->rate);exit;

          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
            }
            else
            {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
            }

          $sum_area = $dag_area->sarea;

          

          $prem_zonal1 = $this->utilityclass->getZonalValue($dist_code,$uuid,$dag_no);

            if($premiumData->rate_type==1 && $reclass_dag_data->prop_lc_cat_id==2)
            {
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($sum_area<=6400)
                    {
                        $ratepr = 0;
                    }
                    else
                    {
                         $ratepr = $premiumData->rate;
                    }
                }
                else
                {
                    if($sum_area<=100)
                    {
                        $ratepr = 0;
                    }
                    else
                    {
                         $ratepr = $premiumData->rate;
                    }
                }
            }
            else
            {
                $ratepr = $premiumData->rate;
            }

          $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
          }
          else
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
          }

          $sumMbAmount = $sum_area * $premium_zonal_per_lessa;
          //$sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;

          if($reclass_dag_data->is_penalty == 'Y')
          {
            $premium_without_penalty = $sumMbAmount;
          }

          else
          {
            $premium_without_penalty = null;
          }


              $fmd=array(
                  'case_no'=>$case_no,
                  'user_code'=>$this->session->userdata('user_code'),
                  'uuid'=>$uuid,
                  'dag_no'=>$dag_no,
                  'zonal_valuation'=>$premiumData->zonal_valuation,
                  'land_type'=>$premiumData->land_type,
                  'rate_type'=>$premiumData->rate_type,
                  'rate'=>$premiumData->rate,
                  'amount_dag'=>$sumMbAmount,
                  // 'final_amount'=>$sumMbAmountTotal,
                  // 'due_amount'=>$sumMbAmountTotal,
                  'total_lessa'=>$sum_area,
                  //'is_full_pay'=>$this->input->post('paymode'),
                  'is_final'=>1,
                  'date_entry'=>date('Y-m-d h:i:s'),
                  'penalty_rate' => $prem_rate_section,
                  'premium_without_penalty' => $premium_without_penalty

              );

              $insPremium = $this->db->insert('settlement_premium', $fmd);

              if ($insPremium != 1) {
                  $this->db->trans_rollback();
                  log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                  $data = array(
                      'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$application_no
                  );
                  echo json_encode($data);
                  return false;
              }

              $data = array('response'=>'true',
                'sumMbAmount'=>$sumMbAmount);

        return $data;

    }

    public function insertFullReclassdata($case_no,$dag_no,$dags_data,$uuid,$prem_rate_section,$co_penalty)
    {
       // var_dump($prem_rate_section);$this->db->trans_rollback();exit;

        $dag_area = $this->db->query("SELECT dag_no,dag_revenue, dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
                            
        $tot_bigha = $dag_area->dag_area_b;
        $tot_katha = $dag_area->dag_area_k;
        $tot_lessa = $dag_area->dag_area_lc;
        $tot_ganda = $dag_area->dag_area_g;

        $is_partion = 'N';
        $is_full_partition = 'N';

        $co_area_b = null;
        $co_area_k = null;
        $co_area_lc = null;
        $co_area_g = null;

        $fmddata= [
                    'date_entry' => date('Y-m-d'),
                    'co_is_partition' => $is_partion,
                    'co_is_full_partition' => $is_full_partition,
                    'co_area_b' =>$co_area_b,
                    'co_area_k' =>$co_area_k,
                    'co_area_lc'=>$co_area_lc,
                    'co_area_g' =>$co_area_g,
                    'penalty_rate'=>$prem_rate_section,
                    'co_penalty' => $co_penalty
                ];
        $this->db->where('case_no', $case_no);
        $this->db->where('dag_no', $dag_no);
        $this->db->update('reclass_dag_details', $fmddata);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0012: Updation failed in settlement_dag_details RTPS Case No '.$case_no);
            $data = array(
                'error'=>"#ERROR0012: Registration of Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }

        //premium calculation//

          $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and dag_no ='$dag_no' and user_code like 'M%' order by pid desc limit 1")->row();
          $district['premiumData'] = $premiumData;
          
          $reclass_dag_data = $this->db->query("Select * from reclass_dag_details where case_no='$case_no' and dag_no ='$dag_no'")->row();

          //  var_dump($premiumData->rate);exit;

          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
            }
            else
            {
                $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dags_data->dist_code, $dags_data->subdiv_code, $dags_data->cir_code, $dags_data->mouza_pargona_code, $dags_data->lot_no, $dags_data->vill_townprt_code, $dag_no))->row();
            }

          $sum_area = $dag_area->sarea;

          

          $prem_zonal1 = $this->utilityclass->getZonalValue($dist_code,$uuid,$dag_no);
          // $ratepr = $premiumData->rate;

          if($premiumData->rate_type==1 && $reclass_dag_data->prop_lc_cat_id==2)
            {
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    if($sum_area<=6400)
                    {
                        $ratepr = 0;
                    }
                    else
                    {
                         $ratepr = $premiumData->rate;
                    }
                }
                else
                {
                    if($sum_area<=100)
                    {
                        $ratepr = 0;
                    }

                    else
                    {
                        $ratepr = $premiumData->rate;
                    }
                }
            }
            else
            {
                $ratepr = $premiumData->rate;
            }



          $sumMbAmountperzonal = ($prem_zonal1 * $ratepr) / 100;


          $dist_code = $this->session->userdata('dist_code');
          if(in_array($dist_code, json_decode(BARAK_VALLEY)))
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 6400;
          }
          else
          {
              $premium_zonal_per_lessa = $sumMbAmountperzonal / 100;
          }

          $sumMbAmount = $sum_area * $premium_zonal_per_lessa;
          //$sumMbAmountTotal += $sum_area * $premium_zonal_per_lessa;
          // var_dump($reclass_dag_data->dag_no);$this->db->trans_rollback();exit;

          if($reclass_dag_data->is_penalty == 'Y')
          {
            $premium_without_penalty = $sumMbAmount;
          }

          else
          {
            $premium_without_penalty = null;
          }

              $fmd=array(
                  'case_no'=>$case_no,
                  'user_code'=>$this->session->userdata('user_code'),
                  'uuid'=>$uuid,
                  'dag_no'=>$dag_no,
                  'zonal_valuation'=>$premiumData->zonal_valuation,
                  'land_type'=>$premiumData->land_type,
                  'rate_type'=>$premiumData->rate_type,
                  'rate'=>$premiumData->rate,
                  'amount_dag'=>$sumMbAmount,
                  // 'final_amount'=>$sumMbAmountTotal,
                  // 'due_amount'=>$sumMbAmountTotal,
                  'total_lessa'=>$sum_area,
                  //'is_full_pay'=>$this->input->post('paymode'),
                  'is_final'=>1,
                  'date_entry'=>date('Y-m-d h:i:s'),
                  'penalty_rate' => $prem_rate_section,
                  'premium_without_penalty' => $premium_without_penalty

              );

              $insPremium = $this->db->insert('settlement_premium', $fmd);

              if ($insPremium != 1) {
                  $this->db->trans_rollback();
                  log_message('error', '#ERRSET000101: Insertion failed in settlement_premium RTPS Case No '.$application_no);
                  $data = array(
                      'error'=>"#ERRSET000101: Registration of Settlement failed for case no : ".$application_no
                  );
                  echo json_encode($data);
                  return false;
              }

              $data = array('response'=>'true',
                'sumMbAmount'=>$sumMbAmount);

        return $data;

    }


    public function getDagWiseCaseApprovalInfoJDS($case_no)
    {
        $sql = $this->db->query("SELECT * from reclass_suite_basic rsb WHERE rsb.case_no = ? and rsb.wet_land = ?", array($case_no,'Y'));
        if($sql->num_rows()>0)
        {
            $sql = $this->db->query("SELECT rdd.* FROM reclass_dag_details rdd join settlement_premium rde on rdd.case_no = rde.case_no WHERE rdd.case_no = ? and rde.penalty_rate = ? and rde.is_final = ?", array($case_no,5,1));
            if($sql->num_rows()>0)
            {
                $approval_by = 'GOVT';
                $is_dlc = 'Y';

                $approval_authority= [
                        'case_no' => $case_no,
                        'approval_by' => $approval_by,
                        'is_dlc' => $is_dlc,
                    ];

                    $approval_authority = $this->db->insert('reclass_approval_authority', $approval_authority);
                    if($approval_authority != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#APPROVE001: Insertion failed in reclass_approval_authority RTPS Case No '.$case_no);

                        //$this->session->set_flashdata('message', "#APPROVE001: Registration of Reclassification failed for case no : ".$case_no);
                        //redirect(base_url() . "index.php/home");
                        return false;
                    }

                    else
                    {
                        // return true;
                        $query = "SELECT * FROM reclass_approval_authority WHERE case_no = '$case_no' order by id desc";
                        $data = $this->db->query($query)->row();
                        return $data;
                    }
            }
            
            else
            {
                $sql2 = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? ", array($case_no));
                $data2 = $sql2->result();

                $sum_area = 0;
                foreach($data2 as $d)
                {

                    if($d->co_is_partition=='Y' && $d->co_is_full_partition=='N')
                    {
                        if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                        {
                        $dag_area =$this->db->query("SELECT sum(co_area_b*6400+co_area_k*320+co_area_lc*20+co_area_g) as sarea
                            from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                        }
                        else
                        {
                        $dag_area =$this->db->query("SELECT sum(co_area_b*100+co_area_k*20+co_area_lc) as sarea
                            from reclass_dag_details where dag_no = ? and case_no = ?",array($d->dag_no,$case_no))->row();
                        }

                        $sum_area+= $dag_area->sarea;
                    }

                    else
                    {
                        if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                        {
                        $dag_area = $this->db->query("SELECT sum(dag_area_b*6400+dag_area_k*320+dag_area_lc*20+dag_area_g) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                        }
                        else
                        {
                        $dag_area = $this->db->query("SELECT sum(dag_area_b*100+dag_area_k*20+dag_area_lc) as sarea FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no))->row();
                        }

                        $sum_area+= $dag_area->sarea;

                    }

                }

                $sql_basic = $this->db->query("SELECT * FROM reclass_suite_basic  WHERE case_no = ?", array($case_no));

                $sql_basic_data = $sql_basic->row();

                if($sql_basic_data->applicant_type =='I')
                {
                    if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        if($sum_area < 64000)
                        {
                            $approval_by = 'DC';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area >= 64000 && $sum_area <= 320000)
                        {
                            $approval_by = 'DLR';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area > 320000)
                        {
                            $approval_by = 'GOVT';
                            $is_dlc = 'Y';
                        }
                    }
                    else
                    {
                        if($sum_area < 1000)
                        {
                            $approval_by = 'DC';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area >= 1000 && $sum_area <= 5000)
                        {
                            $approval_by = 'DLR';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area > 5000)
                        {
                            $approval_by = 'GOVT';
                            $is_dlc = 'Y';
                        }
                    }

                }

                else if($sql_basic_data->applicant_type =='N')
                {
                    if(in_array($d->dist_code, json_decode(BARAK_VALLEY)))
                    {

                        if($sum_area < 320000)
                        {
                            $approval_by = 'DC';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area >= 320000 && $sum_area < 640000)
                        {
                            $approval_by = 'DLR';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area > 640000)
                        {
                            $approval_by = 'GOVT';
                            $is_dlc = 'Y';
                        }
                    }
                    else
                    {

                        if($sum_area < 5000)
                        {
                            $approval_by = 'DC';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area >= 5000 && $sum_area < 10000)
                        {
                            $approval_by = 'DLR';
                            $is_dlc = 'Y';
                        }

                        else if($sum_area >= 10000)
                        {
                            $approval_by = 'GOVT';
                            $is_dlc = 'Y';
                        }
                    }

                }

                else
                {
                    $approval_by = 'DC';
                    $is_dlc = 'Y';
                }

            $approval_authority= [
                    'case_no' => $case_no,
                    'approval_by' => $approval_by,
                    'is_dlc' => $is_dlc,
                    'sum_area_lessa' => $sum_area
                ];

                $approval_authority = $this->db->insert('reclass_approval_authority', $approval_authority);
                if($approval_authority != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#APPROVE001: Insertion failed in reclass_approval_authority RTPS Case No '.$case_no);

                    //$this->session->set_flashdata('message', "#APPROVE001: Registration of Reclassification failed for case no : ".$case_no);
                    //redirect(base_url() . "index.php/home");
                    return false;
                }

                else
                {
                    // return true;
                    $query = "SELECT * FROM reclass_approval_authority WHERE case_no = '$case_no' order by id desc";
                    $data = $this->db->query($query)->row();
                    return $data;
                }
            }
        }
    }




    ///////07032025////////
    public function getSettlementDagPenalty($case_no)
    {
        $sql = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and is_penalty = ? and co_penalty is null", array($case_no,'Y'));
        if ($sql->num_rows()<=0) {
           return 'N';
        } else {
            return 'Y';
        }
    }

     public function getSettlementDagPenaltyRate($case_no)
    {
        $sql = $this->db->query("SELECT * FROM reclass_dag_details  WHERE case_no = ? and is_penalty = ? and penalty_rate is not null", array($case_no,'Y'));
        if ($sql->num_rows()<=0) {
           return 'N';
        } else {
            return 'Y';
        }
    }


    public function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }


    public function locationSelectReGeotagReclass($service_code, $status)
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }
        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM reclass_suite_basic WHERE service_code = $service_code AND status != '$status' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";
        $data = $this->db->query($sql);
        return $data->result();

    }

     public function getLandcLassdetails($case)
    {
       $query = $this->db->query("
            SELECT 
                STRING_AGG(DISTINCT exist_land_class_name, ', ') AS exist_land_classes,
                STRING_AGG(DISTINCT proposed_land_class_name, ', ') AS proposed_land_classes
            FROM 
                reclass_dag_details
            WHERE 
                case_no = '$case'
        ");

        return $query->row();
    }


    public function update_dag_entry(array $row) 
    {
        $this->db
             ->where('case_no', $row['case_no'])
             ->where('dag_no',   $row['dag_no'])
             ->update('reclass_dag_details', [
                 'proposed_land_rev'  => $row['proposed_land_rev'],
                 'proposed_local_tax' => $row['proposed_local_tax']
             ]);

        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR0012: Updation failed in reclass_dag_details RTPS Case No '.$row['case_no'].$this->db->last_query());
            $data = array(
                'error'=>"#ERROR0012: Registration of Reclassification failed for case no : ".$row['case_no']
            );
            echo json_encode($data);
            return false;
        }


                //////proceeding start//////
                $case_no = $row['case_no'];

                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => 'Revenue and local tax updated',
                    'note_on_order' => 'Revenue and local tax updated for Dag :'.$row['dag_no'],
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'task' => 'Revenue and local tax updated by CO',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
                /////////////

        else
        {
            return true;
        }
    }


    public function fecthArea($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no)
    {
        $sql = $this->db->query("SELECT dag_area_b,dag_area_k,dag_area_lc,dag_area_g FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dag_no=?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));
        return $sql->row();
    }

    // get all settlement proceeding
    public function getSettlementProceedingbyLM($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->like('user_code', 'M', 'after')
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->row();
    }


    // get all settlement dag
    public function getElligibleDags($case)
    {
        $this->db->select('rdd.*');
        $this->db->from('reclass_dag_details rdd');
        $this->db->join(
            'reclass_dag_eligibility rde',
            'rdd.case_no = rde.case_no AND rdd.dag_no = rde.dag_no'
        );
        $this->db->where('rdd.case_no', $case);
        $this->db->where('rde.is_eligible', 'Y');
        $this->db->where('rde.status', 1);

        $query = $this->db->get();
        return $query->result();

    }

    public function getAllEligibleApplicantPartitionPartial($case)
    {
        $this->db->select('rdd.*');
        $this->db->from('reclass_partition_info rdd');
        $this->db->join(
            'reclass_dag_eligibility rde',
            'rdd.case_no = rde.case_no AND rdd.dag_no = rde.dag_no'
        );
        $this->db->where('rdd.case_no', $case);
        $this->db->where('rde.is_eligible', 'Y');
        $this->db->where('rde.status', 1);

        $query = $this->db->get();
        return $query->result();
    }

}