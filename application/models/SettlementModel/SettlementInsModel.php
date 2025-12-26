<?php
class SettlementInsModel extends CI_Model {
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
            ->where_in('pdar_type', ['P','GP','GGP'])
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
        $applicaiton_no = $this->utilityclass->getApplidFromCaseNo($case);
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
            ->where('pdar_type', 'B')
            ->where('is_applicant', '1')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_applicant');
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

    // get all (B,O,EN,P,GP,GGP) applicant
    public function getInstitutionDetails($case)
    {
        $applicants = $this->db->query("select sid.*,imc.category_name from settlement_institution_details sid join  ins_master_category imc
            on sid.ins_cat_type_co ::int = imc.id
         where case_no='$case'")->row();
        return $applicants;
    }


    public function getLandGroups()
    {
        $applicants = $this->db->select()
            ->where('id !=',20)
            ->get('land_class_groups');
        return $applicants->result();
    }

    public function checkDagPgrVgrUnreservedTea($case_no)
    {
        $response = array('response' => 2);
        $dagDetails = $this->db->query("select * from settlement_dag_details where case_no = ?",array($case_no))->result();
        if(!empty($dagDetails))
        {
            foreach ($dagDetails as $key => $value)
            {

                //check c_land_bank_details///////////
                $chithaDagCheck = $this->db->query("select * from c_land_bank_details where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? and nature_of_reservation in ('7','8')",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no))->num_rows();
                if($chithaDagCheck <= 0 )
                {
                    log_message('error','#checkDagPgrVgrUnreservedTea========'.$this->db->last_query());
                    $response['response'] = 1;
                    return $response;
                }
                else
                {
                    return $response;
                }

            }
        }
        else
        {
            $response['response'] = 1;
            return $response;
        }




    }


    public function checkDagPgrVgrUnreservedTeaAdc($case_no)
    {
        $response = array('response' => 2);
        $dagDetails = $this->db->query("select * from settlement_dag_details where case_no = ?",array($case_no))->result();
        if(!empty($dagDetails))
        {
            foreach ($dagDetails as $key => $value)
            {
                //check c_land_bank_details///////////
                $chithaDagCheck = $this->db->query("select * from c_land_bank_details where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? and nature_of_reservation in ('7','8')",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no))->num_rows();
                if($chithaDagCheck <= 0 )
                {
                    log_message('error','#checkDagPgrVgrUnreservedTea========'.$this->db->last_query());
                    $response['response'] = 1;
                    $response['msg'] = "DAG is not classified under GOVT-LAND therefore, the application has been placed under reservation.";
                    return $response;
                }
                else
                {
                    return $response;
                }

            }
        }
        else
        {
            $response['response'] = 1;
            return $response;
        }




    }


    public function getPaymentConfirmationCo($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }



    public function checkChithaFlagUpdatePremiumAreaExceptSocioCultureEdu($case_no)
    {
        $response   = array('response' => 2,'msg' => null);
        $basic      = $this->db->query("select * from settlement_basic where case_no = ?",array($case_no))->row();
        $insDetails = $this->db->query("select * from settlement_institution_details where case_no = ?",array($case_no))->row();
        $lmNote     = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();
        $dagDetails = $this->db->query("select * from settlement_dag_details where case_no = ?",array($case_no))->result();

        if($basic->service_code == SLIJE_ID)
        {
            if(!empty($dagDetails))
            {
                $this->db->trans_begin();
                foreach ($dagDetails as $key => $value)
                {
                    ////////////check c_land_bank_details///////////
                    $chithaDagCheck = $this->db->query("select * from chitha_dag_all_flag_details_final where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? ",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no));
                    if($chithaDagCheck->num_rows() <= 0 )
                    {
                        // chitha flag missing/

                        log_message('error','#checkChithaFlag========'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $response['response'] = 1;
                        $response['msg'] = "Chitha dag flag not found, please flag the dag using chitha dag flag module before proceedings ";
                        return $response;
                    }
                    else
                    {
                        $premiumdataCheck = $this->db->query("select * from settlement_premium where case_no = ? and dag_no =? and is_final=1 ",array($case_no,$value->dag_no));
                        if($premiumdataCheck->num_rows() <= 0)
                        {
                            // chitha flag missing/

                            log_message('error','#checkChithaFlag========'.$this->db->last_query());
                            $this->db->trans_rollback();
                            $response['response'] = 1;
                            $response['msg'] = "Premium details not found, please revert to LRA for re-report!!!";
                            return $response;
                        }
                        $premiumdataCheckData = $premiumdataCheck->row();
                        $flagData = $chithaDagCheck->row();
                        $chithaDagFlag = $flagData->area_flag;
                        $premiumUpdateLRA = $premiumdataCheckData->premium_update_lra;
                        if($insDetails->ins_cat_type_co == 8)
                        {

                            ///////////update premium table with area flag and level of approval/////////////
                            //update settlement_premium
                            if($value->is_urban == 'N' && in_array($flagData->area_flag,RURAL_AREA_NJS))
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 9)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $lmNote->already_alloted == 'N' && $insDetails->state_warehousing_corporation == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }
                        if($insDetails->ins_cat_type_co == 10)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_health_education_skill_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 11)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_cwc_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]   = 'GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 12 && $insDetails->purpose_land_allot_co == 'education')
                        {
                            ///////////update premium table with area flag and level of approval/////////////
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';
                        }

                        if($insDetails->ins_cat_type_co == 12 && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
                        {
                            if($premiumUpdateLRA == null && $value->is_urban == 'N' && in_array($flagData->area_flag,URBAN_AREA_NJS))
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report');
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report';
                                return $response;
                            }
                            ///////////update premium table with area flag and level of approval/////////////
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';


                        }
                        if($premiumdataCheckData->area_name == null || $premiumdataCheckData->area_name == '')
                        {
                            $updatePrem = [
                                'approve_by' => $dag_by_approve,
                                'area_name'  => $chithaDagFlag,
                            ];
                            $this->db->where('case_no', $case_no);
                            $this->db->where('dag_no', $value->dag_no);
                            $this->db->where('is_final', 1);
                            $this->db->update('settlement_premium', $updatePrem);
                            if ($this->db->affected_rows() != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG0202: Failed to forward to DC '. $this->db->last_query());
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG0202: Failed to forward to DC';
                                return $response;
                            }
                        }
                    }
                }

                $approved_by = null;
                $approved_by_status = 0;
                if ($dag_by_approve != '' || $dag_by_approve != null )
                {
                    foreach ($dag_arraay as $array)
                    {
                        if($array == 'GOVT')
                        {
                            $approved_by_status = 1;
                        }
                    }
                }

                if($approved_by_status == 0)
                {
                    $approved_by = 'DC';
                }
                else
                {
                    $approved_by = 'GOVT';
                }

                $wedLandStatus = $this->caseUnderDeptOrDCByWetLand($case_no);
                if($wedLandStatus == 1)
                {
                    $approved_by = 'GOVT';
                }

                $updateBasicDat = [
                    'approve_by' => $approved_by
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateBasicDat);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                
                if($this->db->trans_status() == FALSE)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                else
                {
                    $this->db->trans_commit();
                    log_message('error', '#ERRCOCHITHAFLAG0202556: Failed to forward to DC');
                    $response['response'] = 2;
                    $response['msg'] = '#ERRCOCHITHAFLAG0202556: SUCCESS';
                    return $response;
                }
            }
            else
            {
                $response['response'] = 1;
                return $response;
            }
        }
        else
        {
            $response['response'] = 2;
            return $response;
        }


    }



    // for Adc by Masud
    public function checkChithaFlagUpdatePremiumAreaExceptSocioCultureEduWithGovtDag($case_no)
    {
        $response   = array('response' => 2,'msg' => null);
        $basic      = $this->db->query("select * from settlement_basic where case_no = ?",array($case_no))->row();
        $insDetails = $this->db->query("select * from settlement_institution_details where case_no = ?",array($case_no))->row();
        $lmNote     = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();
        $dagDetails = $this->db->query("select * from settlement_dag_details where case_no = ?",array($case_no))->result();

        if($basic->service_code == SLIJE_ID)
        {
            if(!empty($dagDetails))
            {
                $this->db->trans_begin();
                foreach ($dagDetails as $key => $value)
                {

                    //check c_land_bank_details///////////
                    $chithaDagCheckGovtLand = $this->db->query("select * from c_land_bank_details where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? and nature_of_reservation in ('7','8')",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no))->num_rows();
                    if($chithaDagCheckGovtLand <= 0 )
                    {
                        log_message('error','#checkDagPgrVgrUnreservedTea========'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $response['response'] = 1;
                        $response['msg'] = "DAG is not classified under GOVT-LAND therefore, the application has been placed under reservation.";
                        return $response;
                    }


                    ////////////check c_land_bank_details///////////
                    $chithaDagCheck = $this->db->query("select * from chitha_dag_all_flag_details_final where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? ",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no));
                    if($chithaDagCheck->num_rows() <= 0 )
                    {
                        // chitha flag missing/

                        log_message('error','#checkChithaFlag========'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $response['response'] = 1;
                        $response['msg'] = "Chitha dag flag not found, please flag the dag using chitha dag flag module before proceedings ";
                        return $response;
                    }
                    else
                    {
                        $premiumdataCheck = $this->db->query("select * from settlement_premium where case_no = ? and dag_no =? and is_final=1 ",array($case_no,$value->dag_no));
                        if($premiumdataCheck->num_rows() <= 0 )
                        {
                            // chitha flag missing/

                            log_message('error','#checkChithaFlag========'.$this->db->last_query());
                            $this->db->trans_rollback();
                            $response['response'] = 1;
                            $response['msg'] = "Premium details not found, please revert to LRA for re-report!!!";
                            return $response;
                        }
                        $premiumdataCheckData = $premiumdataCheck->row();
                        $flagData = $chithaDagCheck->row();
                        $chithaDagFlag = $flagData->area_flag;
                        $premiumUpdateLRA = $premiumdataCheckData->premium_update_lra;
                        if($insDetails->ins_cat_type_co == 8)
                        {
                            ///////////update premium table with area flag and level of approval/////////////
                            //update settlement_premium
                            if($value->is_urban == 'N' && in_array($flagData->area_flag,RURAL_AREA_NJS))
                            {
                                $dag_arraay[]   = 'DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]   = 'GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 9)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $lmNote->already_alloted == 'N' && $insDetails->state_warehousing_corporation == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 10)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_health_education_skill_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 11)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_cwc_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]   = 'GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 12 && $insDetails->purpose_land_allot_co == 'education')
                        {
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';
                        }

                        if($insDetails->ins_cat_type_co == 12 && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
                        {
                            if($premiumUpdateLRA == null && $value->is_urban == 'N' && in_array($flagData->area_flag,URBAN_AREA_NJS))
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report');
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report';
                                return $response;
                            }
                            ///////////update premium table with area flag and level of approval/////////////
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';


                        }

                        if($premiumdataCheckData->area_name == null || $premiumdataCheckData->area_name == '')
                        {
                            $updatePrem = [
                                'approve_by' => $dag_by_approve,
                                'area_name'  => $chithaDagFlag,
                            ];
                            $this->db->where('case_no', $case_no);
                            $this->db->where('dag_no', $value->dag_no);
                            $this->db->where('is_final', 1);
                            $this->db->update('settlement_premium', $updatePrem);
                            if ($this->db->affected_rows() != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG0202: Failed to forward to DC '. $this->db->last_query());
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG0202: Failed to forward to DC';
                                return $response;
                            }
                        }
                    }
                }

                $approved_by = null;
                $approved_by_status = 0;
                if ($dag_by_approve != '' || $dag_by_approve != null )
                {
                    foreach ($dag_arraay as $array)
                    {
                        if($array == 'GOVT')
                        {
                            $approved_by_status = 1;
                        }
                    }
                }

                if($approved_by_status == 0)
                {
                    $approved_by = 'DC';
                }
                else
                {
                    $approved_by = 'GOVT';
                }

                $wedLandStatus = $this->caseUnderDeptOrDCByWetLand($case_no);
                if($wedLandStatus == 1)
                {
                    $approved_by = 'GOVT';
                }


                $updateBasicDat = [
                    'approve_by' => $approved_by
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateBasicDat);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                if($this->db->trans_status() == FALSE)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                else
                {
                    $this->db->trans_commit();
                    log_message('error', '#ERRCOCHITHAFLAG0202556: Failed to forward to DC');
                    $response['response'] = 2;
                    $response['msg'] = '#ERRCOCHITHAFLAG0202556: SUCCESS';
                    return $response;
                }
            }
            else
            {
                $response['response'] = 1;
                return $response;
            }
        }
        else
        {
            $response['response'] = 2;
            return $response;
        }

    }


    // for ADC Adc by Masud
    public function checkChithaFlagUpdatePremiumAreaExceptSocioCultureEduWithoutTran($case_no)
    {
        $response   = array('response' => 2,'msg' => null);
        $basic      = $this->db->query("select * from settlement_basic where case_no = ?",array($case_no))->row();
        $insDetails = $this->db->query("select * from settlement_institution_details where case_no = ?",array($case_no))->row();
        $lmNote     = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();
        $dagDetails = $this->db->query("select * from settlement_dag_details where case_no = ?",array($case_no))->result();

        if($basic->service_code == SLIJE_ID)
        {
            if(!empty($dagDetails))
            {
                foreach ($dagDetails as $key => $value)
                {

                    //check c_land_bank_details///////////
                    $chithaDagCheckGovtLand = $this->db->query("select * from c_land_bank_details where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? and nature_of_reservation in ('7','8')",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no))->num_rows();
                    if($chithaDagCheckGovtLand <= 0 )
                    {
                        log_message('error','#checkDagPgrVgrUnreservedTea========'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $response['response'] = 1;
                        $response['msg'] = "DAG is not classified under GOVT-LAND therefore, the application has been placed under reservation.";
                        return $response;
                    }

                    ////////////check c_land_bank_details///////////
                    $chithaDagCheck = $this->db->query("select * from chitha_dag_all_flag_details_final where dist_code = ? and subdiv_code =? and cir_code = ? and mouza_pargona_code = ?  and lot_no= ? and vill_townprt_code=? and dag_no = ? ",array($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code,$value->dag_no));
                    if($chithaDagCheck->num_rows() <= 0 )
                    {
                        // chitha flag missing/
                        log_message('error','#checkChithaFlag========'.$this->db->last_query());
                        $this->db->trans_rollback();
                        $response['response'] = 1;
                        $response['msg'] = "Chitha dag flag not found, please flag the dag using chitha dag flag module before proceedings ";
                        return $response;
                    }
                    else
                    {
                        $premiumdataCheck = $this->db->query("select * from settlement_premium where case_no = ? and dag_no =? and is_final=1 ",array($case_no,$value->dag_no));
                        if($premiumdataCheck->num_rows() <= 0 )
                        {

                            log_message('error','#checkChithaFlag========'.$this->db->last_query());
                            $this->db->trans_rollback();
                            $response['response'] = 1;
                            $response['msg'] = "Premium details not found, please revert to LRA for re-report!!!";
                            return $response;
                        }
                        $premiumdataCheckData = $premiumdataCheck->row();
                        $flagData = $chithaDagCheck->row();
                        $chithaDagFlag = $flagData->area_flag;
                        $premiumUpdateLRA = $premiumdataCheckData->premium_update_lra;

                        if($insDetails->ins_cat_type_co == 8)
                        {

                            ///////////update premium table with area flag and level of approval/////////////
                            //update settlement_premium
                            if($value->is_urban == 'N' && in_array($flagData->area_flag,RURAL_AREA_NJS))
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 9)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $lmNote->already_alloted == 'N' && $insDetails->state_warehousing_corporation == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 10)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_health_education_skill_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]='GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 11)
                        {
                            if(in_array($flagData->area_flag,RURAL_AREA_NJS) && $insDetails->central_cwc_sector == 'Y')
                            {
                                $dag_arraay[]='DC';
                                $dag_by_approve = 'DC';
                            }
                            else
                            {
                                $dag_arraay[]   = 'GOVT';
                                $dag_by_approve = 'GOVT';
                            }

                        }

                        if($insDetails->ins_cat_type_co == 12 && $insDetails->purpose_land_allot_co == 'education')
                        {
                            ///////////update premium table with area flag and level of approval/////////////
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';
                        }

                        if($insDetails->ins_cat_type_co == 12 && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
                        {
                            if($premiumUpdateLRA == null && $value->is_urban == 'N' && in_array($flagData->area_flag,URBAN_AREA_NJS))
                            {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report');
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC as premium mismatch so please revert the application to LRA for re-report';
                                return $response;
                            }
                            ///////////update premium table with area flag and level of approval/////////////
                            $dag_arraay[]   = 'GOVT';
                            $dag_by_approve = 'GOVT';


                        }

                        if($premiumdataCheckData->area_name == null || $premiumdataCheckData->area_name == '')
                        {
                            $updatePrem = [
                                'approve_by' => $dag_by_approve,
                                'area_name'  => $chithaDagFlag,
                            ];
                            $this->db->where('case_no', $case_no);
                            $this->db->where('dag_no', $value->dag_no);
                            $this->db->where('is_final', 1);
                            $this->db->update('settlement_premium', $updatePrem);
                            if ($this->db->affected_rows() != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERRCOCHITHAFLAG0202: Failed to forward to DC '. $this->db->last_query());
                                $response['response'] = 1;
                                $response['msg'] = '#ERRCOCHITHAFLAG0202: Failed to forward to DC';
                                return $response;
                            }
                        }
                    }
                }
                $approved_by = null;
                $approved_by_status = 0;
                if ($dag_by_approve != '' || $dag_by_approve != null )
                {
                    foreach ($dag_arraay as $array)
                    {
                        if($array == 'GOVT')
                        {
                            $approved_by_status = 1;
                        }
                    }
                }

                if($approved_by_status == 0)
                {
                    $approved_by = 'DC';
                }
                else
                {
                    $approved_by = 'GOVT';
                }


                $wedLandStatus = $this->caseUnderDeptOrDCByWetLand($case_no);
                if($wedLandStatus == 1)
                {
                    $approved_by = 'GOVT';
                }


                $updateBasicDat = [
                    'approve_by' => $approved_by
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateBasicDat);
                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                if($this->db->trans_status() == FALSE)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOCHITHAFLAG02025: Failed to forward to DC');
                    $response['response'] = 1;
                    $response['msg'] = '#ERRCOCHITHAFLAG02025: Failed to forward to DC';
                    return $response;
                }
                else
                {
                    log_message('error', '#ERRCOCHITHAFLAG0202556: Failed to forward to DC');
                    $response['response'] = 2;
                    $response['msg'] = '#ERRCOCHITHAFLAG0202556: SUCCESS';
                    return $response;
                }
            }
            else
            {

                $response['response'] = 1;
                return $response;
            }
        }
        else
        {
            $response['response'] = 2;
            return $response;
        }
    }



    // case Under Dept Or DC By WetLand for DC
    public function caseUnderDeptOrDCByWetLand($case_no)
    {
        $data = array();
        $wetLand = 0;
        $sql = $this->db->query('select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,
                    (select wet_land from chitha_dag_all_flag_details_final  where
                     dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code
                     and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no)
                    from settlement_dag_details s
                     where case_no = ?', array($case_no));

        $data = $sql->result();

        if (!empty($data))
        {
            if (in_array(6, array_column($data, 'wet_land')))
            {
                $wetLand = 1;
            }
        }

        return $wetLand;
    }

    public function premiumReCalculationForIns($case_no)
    {
        $response = array('status' => 2, 'message' => null);
        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        if ($insDetails->num_rows() > 0) 
        {
            $insDetails = $insDetails->row();
            /////////////for state government case///////no premium//////
            if($insDetails->ins_cat_type_co == '8')
            {
                $response = $this->stateGovernment($case_no);
            }
            else if($insDetails->ins_cat_type_co == '9')
            {
                $response = $this->stateGovernmentUndertaking($case_no);
            }
            else if($insDetails->ins_cat_type_co == '10')
            {
                $response = $this->centralGovernment($case_no); 
            }
            else if($insDetails->ins_cat_type_co == '11')
            {
                $response = $this->centralGovernmentUndertaking($case_no);
                
            }
            else if($insDetails->ins_cat_type_co == '12')
            {
                $response = $this->nonGovernmentSocioEduRel($case_no);   
            }
            return $response;
        } 
        else 
        {
            return array('status' => 1, 'message' => 'Institution details not found...case no' . $case_no);
        }

    }

    private function stateGovernment($case_no)
    {
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRstateGovernment01 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRstateGovernment02 Dag not found..case no' . $case_no);
        }
        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;

            } else {

                return array('status' => 1, 'message' => '#ERRstateGovernment03 Last premium not available for cases...Case no.' . $case_no);
            }


            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);


            $sumMbAmount += 0;
            $sumMbArea += 0;

            if ($amount_dag != $finalamount) 
            {
                return array('status' => 1, 'message' => '#ERRstateGovernment04 :Premium Data or Selected Area mismatch for cases...Case no.' . $case_no);

            }

        }


        if ($due_amount != $sumMbAmount) {
            return array('status' => 1, 'message' => '#ERRstateGovernment06 : Premium mismatch for cases...Case no.' . $case_no);
        }
    }

    private function stateGovernmentUndertaking($case_no)
    {
        $apLmnote = $this->db->query("SELECT * from settlement_ap_lmnote where case_no = ? order by id desc limit 1", array($case_no));
        if ($apLmnote->num_rows() > 0) 
        {
            $apLmnote = $apLmnote->row();
        } 
        else
        {
            return array('status' => 1, 'message' => '#stateGovernmentUndertaking01 LRA report not found..case no' . $case_no);
        }

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#stateGovernmentUndertaking02 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#stateGovernmentUndertaking03 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();

        $sb = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", array($case_no));
        $sbDetails = $sb->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#stateGovernmentUndertaking04 Last premium not available for cases...Case no.' . $case_no);
            }

            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            $reclass_transfer = 0;
            if(RECLASSIFICATION_USE_FOR_ALLOTMENT == 1)
            {
                if($insDetails->commercial_purpose_govt == 'Y')
                {
                    $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                    foreach ($reclPremium as $key => $value) {
                        $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                    }
                    $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                    $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                    $reclass_transfer = $value->rate; 
                }
            }
            else
            {
                if($apLmnote->already_alloted == 'Y' && $insDetails->commercial_purpose_govt == 'Y')
                {
                    $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                    foreach ($reclPremium as $key => $value) {
                        $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                    }
                    $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                    $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                    $reclass_transfer = $value->rate; 
                }
            }
            

            $amount = $prem_area * $prem_zonal / 100;
            if($apLmnote->already_alloted == 'Y')
            {   
                $amount = $amount;
            }
            else
            {
                $amount = $amount / 2;
            }
            $finalamount = $amount + $reclassification_amount;


            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);



            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount)
            {
                log_message('error', '##stateGovernmentUndertaking05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                if(RECLASSIFICATION_USE_FOR_ALLOTMENT == 1)
                {
                  
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $premData->zonal_valuation,
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );

                    
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRREPREM900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRREPREM900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '##stateGovernmentUndertaking05 : Something went wrong for case no..' . $case_no);
                }

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);



        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount)
        {

            log_message('error', '##stateGovernmentUndertaking06: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            // return array('status' => 1, 'message' => '##stateGovernmentUndertaking06: Something went wrong Case No..' . $case_no);
            if(RECLASSIFICATION_USE_FOR_ALLOTMENT == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
                }

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => 'Premium updated due to policy changed',
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated',
                    'note_type' => 'Premium updated due to policy changed',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP45333: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#ERRORPP45333: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '##stateGovernmentUndertaking06: Something went wrong Case No..' . $case_no);
            }
        }
    }

    private function centralGovernment($case_no)
    {

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRcentralGovernment01 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRcentralGovernment02 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRcentralGovernment03 Last premium not available for cases...Case no.' . $case_no);
            }

            $area_flag = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            if($insDetails->commercial_purpose_govt == 'Y' && $reclassification_amount_used_or_not == 'Y')
            {
                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
            }

            $amount      = $prem_area * $prem_zonal / $area_in_bigha;
            $finalamount = $amount + ceil($land_revenue_years) + $reclassification_amount;
            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);

            // log_message('error','amount======'.$premiumdags->dag_no.'--'.$amount);
            // log_message('error','land_revenue_years======'.$premiumdags->dag_no.'--'.$land_revenue_years);
            // log_message('error','reclassification_amount======'.$premiumdags->dag_no.'--'.$reclassification_amount);
            
            // log_message('error','dagno======'.$premiumdags->dag_no.'--'.$finalamount);
            // log_message('error','dagno======'.$premiumdags->dag_no.'--'.$amount_dag);

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;


            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount) {
                log_message('error', '##ERRcentralGovernment05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                return array('status' => 1, 'message' => '##ERRcentralGovernment05 : Something went wrong Case No..' . $case_no);

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);

        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount) {

            log_message('error', '##ERRcentralGovernment06 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            return array('status' => 1, 'message' => '##ERRcentralGovernment06 : Something went wrong Case No..' . $case_no);
            
        }
    }

    private function centralGovernmentUndertaking($case_no)
    {

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertaking01 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertaking02 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertaking03 Last premium not available for cases...Case no.' . $case_no);
            }

            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            if($insDetails->commercial_purpose_govt == 'Y' && $reclassification_amount_used_or_not == 'Y')
            {
                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
            }

            $amount      = $prem_area * $prem_zonal / $area_in_bigha;
            $finalamount = $amount + ceil($land_revenue_years) + $reclassification_amount;

            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;




            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount) {
                log_message('error', '##ERRcentralGovernmentUndertaking04 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                return array('status' => 1, 'message' => '##ERRcentralGovernmentUndertaking04 : Something went wrong Case No..' . $case_no);

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);

        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount) {

            log_message('error', '##ERRcentralGovernmentUndertaking05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            return array('status' => 1, 'message' => '##ERRcentralGovernmentUndertaking05 : Something went wrong Case No..' . $case_no);
            
        }
    }

    private function nonGovernmentSocioEduRel($case_no)
    {
        $apLmnote = $this->db->query("SELECT * from settlement_ap_lmnote where case_no = ? order by id desc limit 1", array($case_no));
        if ($apLmnote->num_rows() > 0) 
        {
            $apLmnote = $apLmnote->row();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRNONGOVT01 LRA report not found..case no' . $case_no);
        }
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRNONGOVT02 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRNONGOVT03 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        
        $sb = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", array($case_no));
        $sbDetails = $sb->row();
        
        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_flag  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRNONGOVT04 Last premium not available for cases...Case no.' . $case_no);
            }
     

            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            if(RECLASSIFICATION_USE_FOR_ALLOTMENT ==1)
            {
                if($insDetails->commercial_purpose_non_govt == 'N' && $apLmnote->already_alloted == 'N' && ($insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'education' || $insDetails->purpose_land_allot_co == 'religious'))
                {
                    $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                    foreach ($reclPremium as $key => $value) {
                        $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                    }
                    $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                    $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                    $reclassYesNo = true;
                    $reclass_transfer = $value->rate; 

                }
            }
            else
            {
                if($insDetails->commercial_purpose_non_govt == 'N' && $apLmnote->already_alloted == 'Y' && ($insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'education' || $insDetails->purpose_land_allot_co == 'religious'))
                {

                    $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                    foreach ($reclPremium as $key => $value) {
                        $reclassification_amount += ($prem_zonal * $value->rate) / 100;
                    }
                    $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                    $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                    $reclassYesNo = true;
                    $reclass_transfer = $value->rate; 
                }
            }
            

            if($insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'religious')
            {
                log_message('error','TYPE===========socioculture');
                if($premiumdags->is_urban == 'Y')
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_flag == 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 500;
                    }
                    else
                    {
                        $rate_per_bigha = 250;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_flag != 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }

                $per_lessa_rate = $rate_per_bigha / $area_in_bigha;
                $finalamount = ceil($per_lessa_rate * $prem_area);

            }
            else if($insDetails->non_govt_profit_making_yes_no == 'N' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == null || $insDetails->under_venture_school == 'NO'))
            {
                log_message('error','TYPE===========education1');
                $amount = $prem_area * $prem_zonal / $area_in_bigha;
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->non_govt_profit_making_yes_no == 'Y' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == null || $insDetails->under_venture_school == 'NO'))
            {
                log_message('error','TYPE===========education2');
                $amount = $prem_area * $prem_zonal / $area_in_bigha;
                $amount = ceil($amount * 30 / 100);
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'unrecognised_venture')
            {
                log_message('error','TYPE===========education3');
                $amount = $prem_area * $prem_zonal / $area_in_bigha;
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'govt_aided_venture')
            {
                log_message('error','TYPE===========education4');
                if($premiumdags->is_urban == 'Y')
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_flag == 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 500;
                    }
                    else
                    {
                        $rate_per_bigha = 250;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_flag != 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }


                $per_lessa_rate = $rate_per_bigha / $area_in_bigha;
                $finalamount = ceil($per_lessa_rate * $prem_area);

            }

            

            $finalamount = $finalamount + $reclassification_amount;

            // log_message('error','area_flag==='.$area_flag);
            // log_message('error','area_name==='.$area_name);
            log_message('error','reclassification_amount==='.$reclassification_amount);
            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);
            

            $sumMbAmount += $finalamount;
            // $sumMbArea += $prem_area;


            if (((ceil($amount_dag) != ceil($finalamount)) && (intval($amount_dag) != $finalamount))) {
                log_message('error', '#ERRSET900316661266: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                if(RECLASSIFICATION_USE_FOR_ALLOTMENT == 1)
                {
                  
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $premData->zonal_valuation,
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );

                    
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#nonGovernmentSocioEduRel000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#nonGovernmentSocioEduRel900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '#ERRSET9003166612: Something went wrong Case No..' . $case_no);
                }
                

            }

        }


        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);
        if (((ceil($due_amount) != ceil($sumMbAmount) && intval($due_amount) != $sumMbAmount))) {

            // log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            if(RECLASSIFICATION_USE_FOR_ALLOTMENT == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#nonGovernmentSocioEduRel1855: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel1855: Something went wrong Case No..' . $case_no);
                }

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => 'Premium updated due to policy changed',
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated',
                    'note_type' => 'Premium updated due to policy changed',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#nonGovernmentSocioEduRel1885: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel1885: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
            }
            
            
        }
    }

    public function getRateForServerCalWithTrasfer($proc_lc_code,$exist_code)
    {

        $prop_lc_det = $this->db->query("select landclass_category_id from land_class_groups where id=?",array($proc_lc_code))->row();
        $proc_lc_cat_code = $prop_lc_det->landclass_category_id;

        $lands = $this->db->query("select prid,rate from reclass_cum_transfer_premium_rate where exist_code='$exist_code' and prop_code='$proc_lc_cat_code' order by prid");

        $data = $lands->result();
        return $data;
        
    }
    public function locationSelectIns($service_code, $status)
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $Query = "";
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO')
        {
            $lot_string = $this->caseListUnderMappingLot();
            if ($lot_string != null) {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }
        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM 
                settlement_basic WHERE service_code = $service_code  and pending_officer = 'CO' AND status ='$status' 
                AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code =
                 '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code,
                  mouza_pargona_code, lot_no";

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

    public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

    public function premiumReCalculationForInsApprovePremCases($case_no,$reason_for_recalculate)
    {
        $response = array('status' => 2, 'message' => null);
        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        if ($insDetails->num_rows() > 0) 
        {
            $insDetails = $insDetails->row();
            /////////////for state government case///////no premium//////
            if($insDetails->ins_cat_type_co == '8')
            {
                $response = $this->stateGovernment($case_no);
            }
            else if($insDetails->ins_cat_type_co == '9')
            {
                $response = $this->stateGovernmentUndertakingApprovePremiumCases($case_no,$reason_for_recalculate);
            }
            else if($insDetails->ins_cat_type_co == '10')
            {
                $response = $this->centralGovernmentApprovePremiumCases($case_no,$reason_for_recalculate); 
            }
            else if($insDetails->ins_cat_type_co == '11')
            {
                $response = $this->centralGovernmentUndertakingApprovePremiumCases($case_no,$reason_for_recalculate);
                
            }
            else if($insDetails->ins_cat_type_co == '12')
            {
                $response = $this->nonGovernmentSocioEduRelApprovePremiumCases($case_no,$reason_for_recalculate);   
            }
            return $response;
        } 
        else 
        {
            return array('status' => 1, 'message' => 'Institution details not found...case no' . $case_no);
        }

    }

    private function stateGovernmentUndertakingApprovePremiumCases($case_no,$reason_for_recalculate)
    {
        $apLmnote = $this->db->query("SELECT * from settlement_ap_lmnote where case_no = ? order by id desc limit 1", array($case_no));
        if ($apLmnote->num_rows() > 0) 
        {
            $apLmnote = $apLmnote->row();
        } 
        else
        {
            return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases01 LRA report not found..case no' . $case_no);
        }

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases02 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases03 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();

        $sb = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", array($case_no));
        $sbDetails = $sb->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases04 Last premium not available for cases...Case no.' . $case_no);
            }

            $prem_zonal_updated = $this->utilityclass->getZonalValue($premiumdags->dist_code,$sbDetails->uuid,$premiumdags->dag_no);
            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            $reclass_transfer = 0;
            
            if($apLmnote->already_alloted == 'Y' && $insDetails->commercial_purpose_govt == 'Y')
            {
                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal_updated * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                $reclass_transfer = $value->rate; 
            }
            
            $amount = $prem_area * $prem_zonal_updated / 100;
            if($apLmnote->already_alloted == 'Y')
            {   
                $amount = $amount;
            }
            else
            {
                $amount = $amount / 2;
            }
            $finalamount = $amount + $reclassification_amount;


            log_message('error','stateGovernmentUndertakingApprovePremiumCasesamount_dag==='.$amount_dag);
            log_message('error','stateGovernmentUndertakingApprovePremiumCasesfinalamount==='.$finalamount);



            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;

            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount)
            {
                log_message('error', '##stateGovernmentUndertakingApprovePremiumCases05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
                {
                  
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $prem_zonal_updated, //////updated zonal value insert instead of old
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );

                    
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRREPREM900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRREPREM900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '##stateGovernmentUndertakingApprovePremiumCases05 : Something went wrong for case no..' . $case_no);
                }

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);



        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount)
        {

            log_message('error', '##stateGovernmentUndertakingApprovePremiumCases06: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            // return array('status' => 1, 'message' => '##stateGovernmentUndertakingApprovePremiumCases06: Something went wrong Case No..' . $case_no);
            if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);

                if ($this->db->affected_rows() == 0) {
                    // $this->db->trans_rollback();
                    log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
                }

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $reason_for_recalculate,
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated by CO',
                    'note_type' => $reason_for_recalculate,
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    // $this->db->trans_rollback();
                    log_message('error', '#stateGovernmentUndertakingApprovePremiumCases2276: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases2276: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '#stateGovernmentUndertakingApprovePremiumCases06: Something went wrong Case No..' . $case_no);
            }
        }
    }

    private function centralGovernmentApprovePremiumCases($case_no,$reason_for_recalculate)
    {

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRcentralGovernmentApprovePremiumCases01 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRcentralGovernmentApprovePremiumCases02 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRcentralGovernmentApprovePremiumCases03 Last premium not available for cases...Case no.' . $case_no);
            }

            $prem_zonal_updated = $this->utilityclass->getZonalValue($premiumdags->dist_code,$sbDetails->uuid,$premiumdags->dag_no);
            $area_flag = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            $reclass_transfer= 0;

            if($insDetails->commercial_purpose_govt == 'Y' && $reclassification_amount_used_or_not == 'Y')
            {
                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal_updated * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                $reclass_transfer = $value->rate; 
            }

            $amount      = $prem_area * $prem_zonal_updated / $area_in_bigha;
            $finalamount = $amount + ceil($land_revenue_years) + $reclassification_amount;
            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);

            // log_message('error','amount======'.$premiumdags->dag_no.'--'.$amount);
            // log_message('error','land_revenue_years======'.$premiumdags->dag_no.'--'.$land_revenue_years);
            // log_message('error','reclassification_amount======'.$premiumdags->dag_no.'--'.$reclassification_amount);
            
            // log_message('error','dagno======'.$premiumdags->dag_no.'--'.$finalamount);
            // log_message('error','dagno======'.$premiumdags->dag_no.'--'.$amount_dag);

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;


            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount) {
                log_message('error', '##ERRcentralGovernmentApprovePremiumCases05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
                {
                  
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $prem_zonal_updated, //////updated zonal value insert instead of old
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );

                    
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRREPREM900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRREPREM900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '##ERRcentralGovernmentApprovePremiumCases05 : Something went wrong Case No..' . $case_no);
                }
                

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);

        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount) {

            log_message('error', '##ERRcentralGovernmentApprovePremiumCases06 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);
                if ($this->db->affected_rows() == 0) {
                    // $this->db->trans_rollback();
                    log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
                }
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }
                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $reason_for_recalculate,
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated by CO',
                    'note_type' => $reason_for_recalculate,
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    // $this->db->trans_rollback();
                    log_message('error', '#centralGovernmentApprovePremiumCases2276: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#centralGovernmentApprovePremiumCases2276: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '##ERRcentralGovernmentApprovePremiumCases06 : Something went wrong Case No..' . $case_no);
            }
            
            
        }
    }

    private function centralGovernmentUndertakingApprovePremiumCases($case_no,$reason_for_recalculate)
    {

        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertakingApprovePremiumCases01 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertakingApprovePremiumCases02 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        

        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_name  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRcentralGovernmentUndertakingApprovePremiumCases03 Last premium not available for cases...Case no.' . $case_no);
            }

            $prem_zonal_updated = $this->utilityclass->getZonalValue($premiumdags->dist_code,$sbDetails->uuid,$premiumdags->dag_no);

            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            $reclass_transfer = 0; 

            if($insDetails->commercial_purpose_govt == 'Y' && $reclassification_amount_used_or_not == 'Y')
            {
                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal_updated * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                $reclass_transfer = $value->rate; 
            }

            $amount      = $prem_area * $prem_zonal_updated / $area_in_bigha;
            $finalamount = $amount + ceil($land_revenue_years) + $reclassification_amount;

            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);

            $sumMbAmount += $finalamount;
            $sumMbArea += $prem_area;




            if (ceil($amount_dag) != $finalamount && intval($amount_dag) != $finalamount) {
                log_message('error', '##ERRcentralGovernmentUndertakingApprovePremiumCases04 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
                {
                  
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $prem_zonal_updated, //////updated zonal value insert instead of old
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );

                    
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRSET000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRSET000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#ERRREPREM900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#ERRREPREM900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '##ERRcentralGovernmentUndertakingApprovePremiumCases04 : Something went wrong Case No..' . $case_no);
                }

            }

        }

        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);

        if (ceil($due_amount) != $sumMbAmount && intval($due_amount) != $sumMbAmount) {

            log_message('error', '##ERRcentralGovernmentUndertakingApprovePremiumCases05 : Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);
                if ($this->db->affected_rows() == 0) {
                    // $this->db->trans_rollback();
                    log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
                }
                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }
                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $reason_for_recalculate,
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated by CO',
                    'note_type' => $reason_for_recalculate,
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    // $this->db->trans_rollback();
                    log_message('error', '#centralGovernmentApprovePremiumCases2276: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#centralGovernmentUndertakingApprovePremiumCases2686: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '##ERRcentralGovernmentUndertakingApprovePremiumCases05 : Something went wrong Case No..' . $case_no);
            }
            
            
        }
    }

    private function nonGovernmentSocioEduRelApprovePremiumCases($case_no,$reason_for_recalculate)
    {
        $apLmnote = $this->db->query("SELECT * from settlement_ap_lmnote where case_no = ? order by id desc limit 1", array($case_no));
        if ($apLmnote->num_rows() > 0) 
        {
            $apLmnote = $apLmnote->row();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRnonGovernmentSocioEduRelApprovePremiumCases01 LRA report not found..case no' . $case_no);
        }
        $dagsCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));
        if ($dagsCheck->num_rows() > 0) 
        {
            $dagCheck = $dagsCheck->result();
        } 
        else
        {
            return array('status' => 1, 'message' => '#ERRnonGovernmentSocioEduRelApprovePremiumCases02 Dag not found..case no' . $case_no);
        }

        $basic = $this->getSettlementBasic($case_no);
        if(empty($basic))
        {
             return array('status' => 1, 'message' => '#ERRnonGovernmentSocioEduRelApprovePremiumCases03 Dag not found..case no' . $case_no);
        }

        $insDetails = $this->db->query("SELECT * FROM settlement_institution_details WHERE case_no = ?", array($case_no));
        $insDetails = $insDetails->row();
        
        $sb = $this->db->query("SELECT * FROM settlement_basic WHERE case_no = ?", array($case_no));
        $sbDetails = $sb->row();
        
        $sumMbAmount = 0;
        $sumMbArea = 0;
        $finalamount = 0;
        foreach ($dagCheck as $premiumdags) 
        {

            $lastId = '';
            $findLastPremium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $premiumdags->dag_no, 1));
            if ($findLastPremium->num_rows() > 0) 
            {
                $premData = $findLastPremium->row();
                $lastId     = $premData->pid;
                $prem_zonal = $premData->zonal_valuation;
                $prem_rate  = $premData->rate;
                $concession_rate = 0;
                $prem_area  = $premData->total_lessa;
                $area_flag  = $premData->area_name;
                $rate_type  = $premData->rate_type;
                $amount_dag = $premData->amount_dag;
                $due_amount = $premData->due_amount;
                $ins_reclass_amount = $premData->ins_reclass_amount;
                $ins_reclass_per    = $premData->ins_reclass_per;
                $ins_reclass_proposed = $premData->ins_reclass_proposed;
                $reclassification_amount_used_or_not = $premData->reclassification_amount_used_or_not;
                $land_revenue_years = $premData->land_revenue_years;
                $premium_update_lra = $premData->premium_update_lra;
                
            } else {
                return array('status' => 1, 'message' => '#ERRnonGovernmentSocioEduRelApprovePremiumCases04 Last premium not available for cases...Case no.' . $case_no);
            }
        
            $prem_zonal_updated = $this->utilityclass->getZonalValue($premiumdags->dist_code,$sbDetails->uuid,$premiumdags->dag_no);
            $area_name = $this->utilityclass->getAreaCategory($premiumdags->dist_code, $premiumdags->subdiv_code, $premiumdags->cir_code, $premiumdags->mouza_pargona_code, $premiumdags->lot_no, $premiumdags->vill_townprt_code, $premiumdags->dag_no);

            /////////premium recalculation////////////
            if (in_array($basic["dist_code"], json_decode(BARAK_VALLEY))){
                $area_in_bigha=6400;
            }else{
                $area_in_bigha=100;
            }
            $reclassification_amount = 0;
            $reclass_transfer = $ins_reclass_per;
            
            if($insDetails->commercial_purpose_non_govt == 'N' && $apLmnote->already_alloted == 'Y' && ($insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'education' || $insDetails->purpose_land_allot_co == 'religious'))
            {

                $reclPremium = $this->getRateForServerCalWithTrasfer($ins_reclass_proposed,$rate_type);
                foreach ($reclPremium as $key => $value) {
                    $reclassification_amount += ($prem_zonal_updated * $value->rate) / 100;
                }
                $recl_per_lessa_rate =  $reclassification_amount / $area_in_bigha;
                $reclassification_amount = ceil($recl_per_lessa_rate * $prem_area);
                $reclassYesNo = true;
                $reclass_transfer = $value->rate; 
            }
        
            

            if($insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'religious')
            {
                log_message('error','TYPE===========socioculture');
                if($premiumdags->is_urban == 'Y')
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_name == 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 500;
                    }
                    else
                    {
                        $rate_per_bigha = 250;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_name != 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }

                $per_lessa_rate = $rate_per_bigha / $area_in_bigha;
                $finalamount = ceil($per_lessa_rate * $prem_area);

            }
            else if($insDetails->non_govt_profit_making_yes_no == 'N' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == null || $insDetails->under_venture_school == 'NO'))
            {
                log_message('error','TYPE===========education1');
                $amount = $prem_area * $prem_zonal_updated / $area_in_bigha;
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->non_govt_profit_making_yes_no == 'Y' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == null || $insDetails->under_venture_school == 'NO'))
            {
                log_message('error','TYPE===========education2');
                $amount = $prem_area * $prem_zonal_updated / $area_in_bigha;
                $amount = ceil($amount * 30 / 100);
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'unrecognised_venture')
            {
                log_message('error','TYPE===========education3');
                $amount = $prem_area * $prem_zonal_updated / $area_in_bigha;
                if($apLmnote->already_alloted == 'Y')
                {   
                    $amount = $amount;
                }
                else
                {
                    $amount = $amount / 2;
                }
                $finalamount = $amount;

            }
            else if($insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'govt_aided_venture')
            {
                log_message('error','TYPE===========education4');
                if($premiumdags->is_urban == 'Y')
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_name == 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 500;
                    }
                    else
                    {
                        $rate_per_bigha = 250;
                    }
                }
                else if($premiumdags->is_urban == 'N' && $area_name != 10)
                {
                    if($apLmnote->already_alloted == 'Y')
                    {
                        $rate_per_bigha = 50000;
                    }
                    else
                    {
                        $rate_per_bigha = 25000;
                    }
                }


                $per_lessa_rate = $rate_per_bigha / $area_in_bigha;
                $finalamount = ceil($per_lessa_rate * $prem_area);

            }

            

            $finalamount = $finalamount + $reclassification_amount;

            // log_message('error','area_flag==='.$area_flag);
            // log_message('error','area_name==='.$area_name);
            log_message('error','reclassification_amount==='.$reclassification_amount);
            log_message('error','amount_dag==='.$amount_dag);
            log_message('error','finalamount==='.$finalamount);
            

            $sumMbAmount += $finalamount;
            // $sumMbArea += $prem_area;


            if (((ceil($amount_dag) != ceil($finalamount)) && (intval($amount_dag) != $finalamount))) 
            {
                log_message('error', '#nonGovernmentSocioEduRelApprovePremiumCasesERRSET900316661266: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
                {
                    
                    $premiumdata = array(
                        'case_no'           => $case_no,
                        'user_code'         => $this->session->userdata('user_code'),
                        'uuid'              => $sbDetails->uuid,
                        'dag_no'            => $premData->dag_no,
                        'zonal_valuation'   => $prem_zonal_updated,
                        'area_name'         => $area_name,
                        'land_type'         => $premData->land_type,
                        'rate_type'         => $rate_type,
                        'rate'              => $prem_rate,
                        'concession'        => $premData->concession,
                        'amount_dag'        => $finalamount,
                        'final_amount'      => null,
                        'due_amount'        => null,
                        'total_lessa'       => $prem_area,
                        'is_full_pay'       => $premData->is_full_pay,
                        'is_final'          =>   1,
                        'date_entry'        => date('Y-m-d h:i:s'),
                        'approve_by'        => $premData->approve_by,
                        'land_revenue_years'   => $land_revenue_years,
                        'ins_reclass_proposed' => $ins_reclass_proposed,
                        'ins_reclass_amount'   =>  $reclassification_amount,
                        'ins_reclass_per'      =>  $reclass_transfer,
                        'reclassification_amount_used_or_not' => $reclassification_amount_used_or_not,
                        'prem_updt_bfr_pay_not' => 'YES',
                    );
                    $reInsPremium = $this->db->insert('settlement_premium', $premiumdata);
                    if ($reInsPremium != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#nonGovernmentSocioEduRelApprovePremiumCases000102: Updation failed in settlement_premium Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel000102: Something went wrong Case No ' . $case_no);
                    }

                    $sqlprem = "update settlement_premium set is_final=0  WHERE case_no = '$case_no' and pid='$lastId'";
                    $updatePrem = $this->db->query($sqlprem);

                    if ($this->db->affected_rows() != 1) {
                        // $this->db->trans_rollback();
                        log_message('error', '#nonGovernmentSocioEduRelApprovePremiumCases900311: Updation failed in settlement_premium RTPS Case No ' . $case_no);
                        return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel900311: Something went wrong for case no  ' . $case_no);
                    }
                }
                else
                {
                    return array('status' => 1, 'message' => '#ERRSET9003166612: Something went wrong Case No..' . $case_no);
                }
            }

        }


        log_message('error','due_amount==='.$due_amount);
        log_message('error','sumMbAmount==='.$sumMbAmount);
        if (((ceil($due_amount) != ceil($sumMbAmount) && intval($due_amount) != $sumMbAmount))) {

            // log_message('error', '#ERRSET900316661: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
            if(RECALCULATE_PREMIUM_FOR_APPROVE_CASES == 1)
            {
                $sqlPremUpdate = "update settlement_premium set final_amount='$sumMbAmount',due_amount='$sumMbAmount'  WHERE case_no = '$case_no' and is_final=1";
                $updatePremium = $this->db->query($sqlPremUpdate);

                if ($this->db->affected_rows() == 0) {
                    // $this->db->trans_rollback();
                    log_message('error', '#nonGovernmentSocioEduRelApprovePremiumCases1855: Updation failed in settlement_premium66666 RTPS Case No ' . $case_no);
                    return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel1855: Something went wrong Case No..' . $case_no);
                }

                //////proceeding start//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $reason_for_recalculate,
                    'status' => 'M',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Premium updated',
                    'note_type' => $reason_for_recalculate,
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    // $this->db->trans_rollback();
                    log_message('error', '#nonGovernmentSocioEduRel1885: Insertion failed in settlement_proceeding for case no :' . $case_no);
                    return array('status' => 1, 'message' => '#nonGovernmentSocioEduRel1885: Failed to forward the case for Case No : ' . $case_no);
                }
                //////proceeding end//////
            }
            else
            {
                return array('status' => 1, 'message' => '#ERRSET900316661: Something went wrong Case No..' . $case_no);
            }
        }
    }

}