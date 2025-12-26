
<?php
class ChithaUpdateForMutationModel extends CI_Model {
    // var $globalPdarIDs = null;
    public function __construct() {
        parent::__construct();
        $this->load->model('SettlementModel/SettlementApModel');
    }

    public function ChithaUpdateForField($params,$globalPdarID,$globalPdarIDs)
    {

        log_message('error','FIELD MUTATION PARAMS============='.json_encode($params));
        $dist_code =$params['dist_code'];
        $subdiv_code = $params['subdiv_code'];
        $cir_code = $params['cir_code'];
        $mouza_pargona_code =  $params['mouza_pargona_code'];
        $lot_no = $params['lot_no'];
        $vill_code = $params['vill_townprt_code'];
        $petition_no = $params['petition_no'];
        $dag_no = $params['dag_no'];
        $is_multigeneration = $params['is_multigeneration'];    

        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        $generation_pdar_id=false;
        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
        $t_data_order = $this->db->query($t_order_data_query);
        if ($t_data_order == null || $t_data_order->num_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error","#ERR001 No data found in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
            return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
        }
        $t_data_order = $t_data_order->result();
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            $tstatus1=$this->db->insert("chitha_col8_order", $data); //************************************************************************************************ insert query
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," #ERR002 could not insert chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }

            //Checking for occupents
            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error","#ERR003 No data found in t_chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }
            $t_occup_data = $t_occup_data->result();

            $totalPattadarCount = count($t_occup_data);

            //updating t_chitha_col8_order iscorrected_inco status
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and "
                    . "dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //********************************************************************************************* insert query
            if ($this->db->affected_rows()<=0 )
            {
                $this->db->trans_rollback();
                log_message("error","#ERR004 Could not update iscorrected_inco in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }                                
                       
            $chitha_basic_update = FALSE;
            // occupants details starts here
            $isGlobalSet = false;
            $countingPattadar = 1;
            foreach ($t_occup_data as $occ) {

                
                // $sql = "update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                //         . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                // $this->db->query($sql); //************************************************************************************************ update query

                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    // To replicate TRIM in SQL, trim the value in PHP:
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                // Then update:
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result <=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR005 Could not update jama_yn in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                    return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }  
                
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                
                $tstatus2 = $this->db->insert("chitha_col8_occup", $data); //************************************************************************************************ insert query
                if ($tstatus2 != 1 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR006 Could not insert in chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                    return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;
                
                if ($ord->order_type_code == '02') {
                    // Order Type Code 02 iIs For Field Partition. and 01 is For Field Mutation
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and "
                            . "TRIM(patta_no)=trim('$occ->new_patta_no')")->row()->pdar_id;
                }
                
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //echo $pdar_id;
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no'] = $occ->new_dag_no;
                } else {
                    $dag_pattadar['dag_no'] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                if(MULTIGENERATION_ACTIVE==1 && $is_multigeneration == 'M')
                {
                    log_message('error',$occ->dag_no.'===globalPdarID-1111----'.json_encode($globalPdarID));
                    log_message('error','generation_pdar_id-----'.json_encode($generation_pdar_id));
                    if($generation_pdar_id==false && $globalPdarID == false)
                    {
                        
                        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')")->row()->cp;
                        // log_message('error','09--'.$this->db->last_query());
                        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')")->row()->jp;
                        // log_message('error','010--'.$this->db->last_query());
                        $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no') and dag_no='$occ->dag_no'")->row()->dp;
                        // log_message('error','011--'.$this->db->last_query());
                        if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
                            if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                                $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                            }else{
                                $mgen_pdar_id= $pattadars_in_chitha_pattadar;
                            }
                        }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                            $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                        }else{
                            $mgen_pdar_id= $pattadars_in_jama_pattadar;
                        }
                        if($mgen_pdar_id=== null){
                            $mgen_pdar_id=1;
                        }
                        $generation_pdar_id=true;
                        // $globalPdarIDs = $mgen_pdar_id;
                        log_message('error','SETGLOBAL_PDAR_ID mgen_pdar_id=========='.$mgen_pdar_id);
                        if($mgen_pdar_id != 1)
                        {
                            $globalPdarIDs = $mgen_pdar_id-1;
                        }
                        else
                        {
                            $globalPdarIDs = $mgen_pdar_id;
                        }
                        log_message('error','SETGLOBAL_PDAR_ID=========='.$globalPdarIDs);
                    }
                    else
                    {
                        // if($globalPdarID == true)
                        // {
                        //     $globalPdarIDs = $globalPdarIDs+ 1;
                        //     $mgen_pdar_id = $globalPdarIDs;
                            
                        // }
                        // else
                        // {
                        //     $mgen_pdar_id = $mgen_pdar_id+ 1;
                        // }

                        if($globalPdarID == true && $isGlobalSet == false)
                        {
                            log_message('error',$dag_no.'ENTRYDONE===globalPdarIDsssssssss-1111----'.json_encode($globalPdarIDs));
                            
                            $mgen_pdar_id = $globalPdarIDs;
                            $mgen_pdar_id = $mgen_pdar_id+ 1;
                            $isGlobalSet = true;
                            
                        }
                        else
                        {
                            $mgen_pdar_id = $mgen_pdar_id+ 1;
                        }
                        
                    }
                    $dag_pattadar['pdar_id']=$mgen_pdar_id;
                    $pdar_id = $mgen_pdar_id;
                }
                log_message('error',$occ->dag_no.'===globalPdarID-----'.json_encode($globalPdarID));
                log_message('error',$occ->dag_no.'===globalPdarIDssss-----'.json_encode($globalPdarIDs));
                log_message('error',$occ->dag_no.'===pdar_id-----'.json_encode($mgen_pdar_id));
                
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                if(MULTIGENERATION_ACTIVE==1 && $is_multigeneration == 'M')
                {
                    $dag_pattadar['p_flag'] = $occ->pdar_strike;
                }
                log_message('error',$occ->dag_no.'PDAR_STRIKE==========='.json_encode($dag_pattadar['p_flag']));
                
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //////////////////////////
                $chitha_pattadar['pdar_name_eng'] = $occ->pdar_name_eng;
                $chitha_pattadar['pdar_guard_eng'] = $occ->pdar_guard_eng;
                //newly added aadhaar details to chitha pattadar----
                $flagAadhaar = null;
                $flagPan = null;
                if($occ->auth_type == 'AADHAAR'){
                    $chitha_pattadar['pdar_aadharno'] = $occ->id_ref_no;
                    $flagAadhaar = $occ->id_ref_no;
                    $flagPan = null;
                }else if($occ->auth_type == 'PAN'){
                    $chitha_pattadar['pdar_pan_no'] = $occ->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $occ->id_ref_no;
                }

                $chitha_pattadar['pdar_photo'] = $occ->photo;
                //end-----------


                $chitha_basic_query = "select land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                        . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                $result = $this->db->query($chitha_basic_query)->row();
                
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->user_code;
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                //Partition to new dag
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;
                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no and dag_no='$dag_no' ";
                    $this->db->query($q); //************************************************************************************************ update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR007 Could not update new_dag_no in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no')";
                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;
                $chitha_basic['operation'] = "E";
                //var_dump($dag_pattadar);
                
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {
                    // This Block Is For Field Partition
                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from   chitha_basic where dist_code='$occ->dist_code' and "
                            . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                            . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    $data = $this->db->query($sql)->row();
                    
                       ////// BARAK VALLEY CODE START ////////////
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                       $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc*20 + $ord->mut_land_area_g) / 6400.0);

                    }
                    else
                    {
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    }

                    
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    
                    // $tstatus_ch = $this->db->insert("chitha_basic", $chitha_basic); //************************************************************************************************ insert query
                    $tstatus_ch = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if ($tstatus_ch != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR008 Could not insert in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    }
                    

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    $tstatus_ord = $this->db->insert("chitha_col8_order", $dataNew); //************************************************************************************************ insert query
                    if ($tstatus_ord != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR009 Could not insert in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    }

                ////// BARAK VALLEY CODE START ////////////
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){

                $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                $remaining_lessa = $sourcelessa - $mutationlessa;
                $left_b = floor($remaining_lessa / 6400);
                $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320)/20);
                $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                $left_kr = 0;
                }
                else{
                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                }
                   

                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue; 
                    
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update,dag_area_b=$left_b,dag_area_k=$left_k,"
                    //         . "dag_area_lc=$left_lc,dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' where dist_code='$occ->dist_code' and "
                    //         . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                    //         . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    // $this->db->query($sql); //************************************************************************************************ update query

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'         => null,
                        'dag_revenue'     => $dag_revenue_updates,
                        'dag_local_tax'   => $dag_local_tax_update,
                        'dag_area_b'      => $left_b,
                        'dag_area_k'      => $left_k,
                        'dag_area_lc'     => $left_lc,
                        'dag_area_g'      => $left_g,
                        'dag_area_kr'     => $left_kr,
                        'date_entry'      => $d,        // Assuming $d is already a formatted date string
                        'operation'       => 'M',
                    ];

                    // For WHERE conditions:
                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->patta_no),  // Use PHP trim here
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    // Then call your model update method, e.g.:
                    $resulto = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($resulto<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR010 Could not update  jama_yn=null in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 
                }
                
                $p_id = $dag_pattadar['pdar_id'];
                
                if ($ord->order_type_code == '02') {
                    // This Block Is For Field Partition
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->new_patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    // This Block Is For Field Mutation
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                            . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                //var_dump($dag_pattadar);
                $occ->new_pattadar; // for partition it will always be new pattadar
                if(($occ->new_pattadar!='N') && $occ->auth_type != null){
                    $p_id=$occ->pdar_id;
                    // $query = "update chitha_pattadar set pdar_aadharno = '$flagAadhaar',pdar_pan_no = '$flagPan', pdar_photo ='$photo' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                    //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                    //         . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    // $this->db->query($query);

                    $table = 'chitha_pattadar';

                    $params = [
                        'pdar_aadharno' => $flagAadhaar,
                        'pdar_pan_no'   => $flagPan,
                        'pdar_photo'    => $photo,
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                        'pdar_id'            => $p_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result <=0 )
                    {
                        log_message('error',$this->db->last_query());
                        $this->db->trans_rollback();
                        log_message("error","#ERR013 Could not update aadhaar details in chitha_pattadar with district: ".$dist_code
                                    .", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 
                }

                if (($occ->new_pattadar=='N')){

                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $tstatus3 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                    $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    // log_message('error','111--'.$this->db->last_query());
                    $countingPattadar++;
                    //************************************************* insert query
                    if ($tstatus3 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR011 Could not insert in  chitha_dag_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    }
                    if(($cPattadarExists == 0)){
                        if($globalPdarID == false)
                        {
                            // $tstatus4 = $this->db->insert("chitha_pattadar", $chitha_pattadar);//************************************************************************************************ insert query
                            $chitha_pattadar['f1_case_no']=$case_no;
                            $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                            if ($tstatus4 != 1 )
                            {
                                $this->db->trans_rollback();
                                log_message("error","#ERR012 Could not insert in  chitha_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                            }
                        }
                        
                    }
                }
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//*********************************************************************************** update query
                if ($this->db->affected_rows()<=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR013 Could not update iscorrected_inco in t_chitha_col8_occup with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                    return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                } 
            }
            // occupants details ends here

            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//************************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $occup->pdar_id,
                    ];

                    // Example usage in a model
                    $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR014 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 
                }
            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {

                 $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
                $t_inplace_data = $this->db->query($t_inplace_query); 
                
                if (($ord->order_type_code == '01') && ($t_inplace_data == null || $t_inplace_data->num_rows() <=0))
                {
                    $this->db->trans_rollback();
                     log_message("error","#ERR015 Could not find data in t_chitha_col8_inplace with district: "
                        .$dist_code.", petition_no: ". $petition_no);
                    return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }
                $t_inplace_data = $t_inplace_data->result();

                foreach ($t_inplace_data as $inplace) {
                    $data = array();

                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);


                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->user_code;
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = date('E');
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );

                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and "
                            . "col8order_cron_no='$data[col8order_cron_no]' and inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                    {
                        $tstatus5 = $this->db->insert("chitha_col8_inplace", $data);//********************************************** insert query
                        if ($tstatus5 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error","#ERR016 Could not insert in chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                            return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                        }
                    }

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                    $p_flag = '1';
                    $corrected = date('Y-m-d G:i:s');
                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',date_entry='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    
                    // $this->db->query($update_query);//************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag'      => $p_flag,
                        'date_entry'  => $corrected,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR017 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 

                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and "
                            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' "
                            . "and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);//*********************************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR018 Could not update iscorrected_inco in t_chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 

                    $date_of_order=date('Y-m-d');
                    $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);//***************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #ERR019 Could not update order_passed in field_mut_basic with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    } 
                }
            }
        }        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error","#ERR020 Could not complet autoUpdate for chitha with district: ".$dist_code
                                .", petition_no: ". $petition_no);
            return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
        }
        return $response = array('responseType' => 2,'globalPdarID'=>$globalPdarIDs );
    }

    // Added by Abhijit --2024-05-02
    public function ChithaUpdateForFieldForMultiDag($params)
    {    
        $dist_code =$params['dist_code'];
        $subdiv_code = $params['subdiv_code'];
        $cir_code = $params['cir_code'];
        $mouza_pargona_code =  $params['mouza_pargona_code'];
        $lot_no = $params['lot_no'];
        $vill_code = $params['vill_townprt_code'];
        $petition_no = $params['petition_no'];
        $dag_no = $params['dag_no'];
        $is_multigeneration = $params['is_multigeneration'];    
    
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        $generation_pdar_id=false;
        $year_no = year_no;
    
        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
        $t_data_order = $this->db->query($t_order_data_query);
        if ($t_data_order == null || $t_data_order->num_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error","#ERR001 No data found in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
            return false;
        }
        $t_data_order = $t_data_order->result();
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            $tstatus1=$this->db->insert("chitha_col8_order", $data); //************************************************************************************************ insert query
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," #ERR002 could not insert chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }
    
            //Checking for occupents
            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error","#ERR003 No data found in t_chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }
            $t_occup_data = $t_occup_data->result();
    
            //updating t_chitha_col8_order iscorrected_inco status
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and "
                    . "dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //********************************************************************************************* insert query
            if ($this->db->affected_rows()<=0 )
            {
                $this->db->trans_rollback();
                log_message("error","#ERR004 Could not update iscorrected_inco in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }                                
                        
            $chitha_basic_update = FALSE;
            // occupants details starts here
            foreach ($t_occup_data as $occ) {
                
                // $sql = "update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                //         . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                // $this->db->query($sql); //************************************************************************************************ update query
                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    // Since SQL uses TRIM(), we trim here in PHP for exact matching
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                // Then call your model's update method:
                $result_cb = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result_cb<=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR005 Could not update jama_yn in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }  
                
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                
                $tstatus2 = $this->db->insert("chitha_col8_occup", $data); //************************************************************************************************ insert query
                if ($tstatus2 != 1 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR006 Could not insert in chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }
    
                $dag_pattadar = array();
                $chitha_pattadar = array();
    
                $pdar_id = $occ->pdar_id;
                
                if ($ord->order_type_code == '02') {
                    // Order Type Code 02 iIs For Field Partition. and 01 is For Field Mutation
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and "
                            . "TRIM(patta_no)=trim('$occ->new_patta_no')")->row()->pdar_id;
                }
                
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //echo $pdar_id;
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no'] = $occ->new_dag_no;
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['dag_no'] = $dag_no;
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                
                $dag_pattadar['p_flag'] = '0';
                
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;
    
                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');
    
                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;
    
                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //////////////////////////
                $chitha_pattadar['pdar_name_eng'] = $occ->pdar_name_eng;
                $chitha_pattadar['pdar_guard_eng'] = $occ->pdar_guard_eng;
                //newly added aadhaar details to chitha pattadar----
                $flagAadhaar = null;
                $flagPan = null;
                if($occ->auth_type == 'AADHAAR'){
                    $chitha_pattadar['pdar_aadharno'] = $occ->id_ref_no;
                    $flagAadhaar = $occ->id_ref_no;
                    $flagPan = null;
                }else if($occ->auth_type == 'PAN'){
                    $chitha_pattadar['pdar_pan_no'] = $occ->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $occ->id_ref_no;
                }
    
                $chitha_pattadar['pdar_photo'] = $occ->photo;
                //end-----------
    
    
                $chitha_basic_query = "select land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                        . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                $result = $this->db->query($chitha_basic_query)->row();
                
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->user_code;
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;
    
                //Partition to new dag
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;
                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no and dag_no='$dag_no' ";
                    $this->db->query($q); //************************************************************************************************ update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR007 Could not update new_dag_no in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    } 
                } else {
                    $chitha_basic['dag_no'] = $dag_no;
    
                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no')";
                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;
    
                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;
                $chitha_basic['operation'] = "E";
                //var_dump($dag_pattadar);
                
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {
                    // This Block Is For Field Partition
                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from   chitha_basic where dist_code='$occ->dist_code' and "
                            . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                            . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    $data = $this->db->query($sql)->row();
                    
                        ////// BARAK VALLEY CODE START ////////////
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc*20 + $ord->mut_land_area_g) / 6400.0);
    
                    }
                    else
                    {
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    }
    
                    
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    
                    // $tstatus_ch = $this->db->insert("chitha_basic", $chitha_basic); //************************************************************************************************ insert query
                    $tstatus_ch = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if ($tstatus_ch != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR008 Could not insert in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }
                    
    
                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    $tstatus_ord = $this->db->insert("chitha_col8_order", $dataNew); //************************************************************************************************ insert query
                    if ($tstatus_ord != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR009 Could not insert in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }
    
                ////// BARAK VALLEY CODE START ////////////
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
    
                $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                $remaining_lessa = $sourcelessa - $mutationlessa;
                $left_b = floor($remaining_lessa / 6400);
                $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320)/20);
                $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                $left_kr = 0;
                }
                else{
                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $remaining_lessa = $sourcelessa - $mutationlessa;
    
                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                }
                    
    
                    $d = date('Y-m-d G:i:s');
    
                    $dag_revenue_updates = $data->dag_revenue; 
                    
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update,dag_area_b=$left_b,dag_area_k=$left_k,"
                    //         . "dag_area_lc=$left_lc,dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' where dist_code='$occ->dist_code' and "
                    //         . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                    //         . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    // $this->db->query($sql); //************************************************************************************************ update query

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'       => null,
                        'dag_revenue'   => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b'    => $left_b,
                        'dag_area_k'    => $left_k,
                        'dag_area_lc'   => $left_lc,
                        'dag_area_g'    => $left_g,
                        'dag_area_kr'   => $left_kr,
                        'date_entry'    => $d,        // assuming $d is already in correct date format string
                        'operation'     => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        // Since you have TRIM in SQL, trim in PHP here:
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    // Call your model update function:
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR010 Could not update  jama_yn=null in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    } 
                }
                
                $p_id = $dag_pattadar['pdar_id'];
                
                if ($ord->order_type_code == '02') {
                    // This Block Is For Field Partition
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->new_patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;
    
                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    // This Block Is For Field Mutation
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;
    
                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                            . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                //var_dump($dag_pattadar);
                $occ->new_pattadar; // for partition it will always be new pattadar
                if(($occ->new_pattadar!='N') && $occ->auth_type != null){
                    $p_id=$occ->pdar_id;
                    // $query = "update chitha_pattadar set pdar_aadharno = '$flagAadhaar',pdar_pan_no = '$flagPan', pdar_photo ='$photo' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                    //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                    //         . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    // $this->db->query($query);

                    $table = 'chitha_pattadar';

                    $params = [
                        'pdar_aadharno' => $flagAadhaar,
                        'pdar_pan_no'   => $flagPan,
                        'pdar_photo'    => $photo,
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                        'pdar_id'            => $p_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result<=0 )
                    {
                        log_message('error',$this->db->last_query());
                        $this->db->trans_rollback();
                        log_message("error","#ERR013 Could not update aadhaar details in chitha_pattadar with district: ".$dist_code
                                    .", petition_no: ". $petition_no);
                        return false;
                    } 
                }
    
                if (($occ->new_pattadar=='N')){
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $tstatus3 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                    $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    log_message('error','111--'.$this->db->last_query());
                    //************************************************* insert query
                    if ($tstatus3 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR011 Could not insert in  chitha_dag_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }
                    if(($cPattadarExists == 0)){
                        // $tstatus4 = $this->db->insert("chitha_pattadar", $chitha_pattadar);//************************************************************************************************ insert query
                        $chitha_pattadar['f1_case_no']=$case_no;
                        $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                        if ($tstatus4 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error","#ERR012 Could not insert in  chitha_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                            return false;
                        }
                    }
                }
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//*********************************************************************************** update query
                if ($this->db->affected_rows()<=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR013 Could not update iscorrected_inco in t_chitha_col8_occup with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                    return false;
                } 
            }
            // occupants details ends here
    
            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//************************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $occup->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result <=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERRMULD014 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
                }
            }
    
            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {
    
                    $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
                $t_inplace_data = $this->db->query($t_inplace_query); 
                
                if (($ord->order_type_code == '01') && ($t_inplace_data == null || $t_inplace_data->num_rows() <=0))
                {
                    $this->db->trans_rollback();
                        log_message("error","#ERR015 Could not find data in t_chitha_col8_inplace with district: "
                        .$dist_code.", petition_no: ". $petition_no);
                    return false;
                }
                $t_inplace_data = $t_inplace_data->result();
    
                foreach ($t_inplace_data as $inplace) {
                    $data = array();
    
                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);
    
    
                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->user_code;
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = date('E');
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );
    
                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and "
                            . "col8order_cron_no='$data[col8order_cron_no]' and inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                    {
                        $tstatus5 = $this->db->insert("chitha_col8_inplace", $data);//********************************************** insert query
                        if ($tstatus5 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error","#ERR016 Could not insert in chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                            return false;
                        }
                    }
    
                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                    $p_flag = '1';
                    $corrected = date('Y-m-d G:i:s');
                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',date_entry='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    
                    // $this->db->query($update_query);//************************************************************************************ update query

                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag'      => $p_flag,
                        'date_entry'  => $corrected,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR017 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
    
                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and "
                            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' "
                            . "and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);//*********************************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR018 Could not update iscorrected_inco in t_chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
    
                    $date_of_order=date('Y-m-d');
                    $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);//***************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #ERR019 Could not update order_passed in field_mut_basic with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
                }
            }
        }        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error","#ERR020 Could not complet autoUpdate for chitha with district: ".$dist_code
                                .", petition_no: ". $petition_no);
            return false;
        }
        return true;
    }


    public function maxPdarIdForMultiDag($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$org_patta_type_code,$org_patta_no,$dag_no){

        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->cp;

          $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
           . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
           . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->jp;
          $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
           . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
           . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no') and dag_no='$dag_no'")->row()->dp;
            if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar)
            {
                if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                    $pdar_id= $pattadars_in_chithaDag_pattadar;
                }else{
                    $pdar_id= $pattadars_in_chitha_pattadar;
                }
            }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                $pdar_id= $pattadars_in_chithaDag_pattadar;
            }else{
                $pdar_id= $pattadars_in_jama_pattadar;
            }
            if ($pdar_id == null) {
                $pdar_id = 1;
            }
            return $pdar_id;
    }

    public function autoUpdateOfcMultiGen($is_multigeneration,$dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $dag_no,$globalPdarID,$globalPdarIDs)
    {
        log_message('error','PARAMS=========='.json_encode($dag_no.$globalPdarID.$globalPdarIDs));
        // $db=  $this->session->userdata('db');
        // $this->db->trans_begin();
        $record_count = 0;
        $generation_pdar_id=false;
        $patta_no = "";
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

        $ord_cron_no = $this->db->query($q)->row()->c1;
        $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
        $rmk_type_hist_no = $this->db->query($q)->row()->c2;

        if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where "
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' and dag_no='$dag_no' and iscorrected_inco is null  and petition_no=$petition_no ";
        $orders = $this->db->query($order_query);
        if ($orders == null || $orders->num_rows()<=0)
        {
            $this->db->trans_rollback();
            log_message("error"," #OMAUTO003 could not get t_chitha_rmk_ordbasic data 
             district: ".$dist_code.", petition_no: ". $petition_no);
            return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
        }

        $orders = $orders->result();
        $case_no = null;
        foreach ($orders as $order) 
        {
            $case_no = $order->ord_no;
                //copy alongwith information from    transaction to chitha
            $record_count++;

            $alongwith_q = "select * from  t_chitha_rmk_alongwith where ord_no='$order->ord_no' and dag_no='$dag_no'";
            $alongwith_d = $this->db->query($alongwith_q);
            $alongwith_d_count = $alongwith_d->num_rows();
            

            $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no' and dag_no='$dag_no'";
            $inplace_d = $this->db->query($inplace_q);
            $inplace_d_count = $inplace_d->num_rows();
            

            if ($alongwith_d_count <=0 && $inplace_d_count <=0)
            {
             $this->db->trans_rollback();
             log_message("error"," #OMAUTO005 inplace/alongwih data not found 
                district: ".$dist_code.", petition_no: ". $petition_no);
             return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }
            $alongwith_d = $alongwith_d->result();
            $inplace_d= $inplace_d->result();


            foreach ($alongwith_d as $along) 
            {
                $ord_cron_no = $ord_cron_no;
                unset($along->year_no);
                unset($along->petition_no);
                unset($along->iscorrected_inco);
                unset($along->iscorrected_inco_date);
                unset($along->iscorrected_rkg_record);
                unset($along->iscorrected_rkg_date);
                unset($along->make_mdb);
                $along->rmk_type_hist_no = $rmk_type_hist_no;
                $along->ord_cron_no = $ord_cron_no;
                $along->user_code = $this->user_code;
                $along->operation = 'E';
                $along->date_entry = date('Y-m-d G:i:s');
                //var_dump($along);
                $tstatus1 = $this->db->insert("chitha_rmk_alongwith", $along); //*****************
                if ($tstatus1 != 1)
                {
                  $this->db->trans_rollback();
                  log_message("error"," #OMAUTO004 could not insert t_chitha_rmk_alongwith
                     district: ".$dist_code.", petition_no: ". $petition_no);
                  return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }
            }            

            foreach ($inplace_d as $inplace) 
            {
                $petition_no = $inplace->petition_no;
                $ord_cron_no = $ord_cron_no;
                unset($inplace->year_no);
                unset($inplace->petition_no);
                unset($inplace->iscorrected_inco);
                unset($inplace->iscorrected_inco_date);
                unset($inplace->iscorrected_rkg_record);
                unset($inplace->iscorrected_rkg_date);
                unset($inplace->make_mdb);

                $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                $inplace->ord_cron_no = $ord_cron_no;
                $inplace->user_code = $this->user_code;
                $inplace->operation = 'E';
                $inplace->date_entry = date('Y-m-d G:i:s');
                    //var_dump($inplace);

                    $tstatus2 = $this->db->insert("chitha_rmk_inplace_of", $inplace); //**************
                    if ($tstatus2 != 1)
                    {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO005 could not insert t_chitha_rmk_inplace_of
                         district: ".$dist_code.", petition_no: ". $petition_no);
                      return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    }

                  $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and dag_no='$dag_no'  and $this->base_query")->row();

                //   $update_query = "update  chitha_dag_pattadar set p_flag='1' where "
                //   . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                //   . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                //   . " lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                //   . " TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' "
                //   . " and pdar_id=$inplace->pdar_id ";
                //     //echo $update_query;;
                //   $patta_no = trim($details->patta_no);
                //   $this->db->query($update_query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dist_code'          => $inplace->dist_code,
                    'subdiv_code'        => $inplace->subdiv_code,
                    'cir_code'           => $inplace->cir_code,
                    'mouza_pargona_code' => $inplace->mouza_pargona_code,
                    'lot_no'             => $inplace->lot_no,
                    'vill_townprt_code'  => $inplace->vill_townprt_code,
                    'dag_no'             => $details->dag_no,
                    'patta_type_code'    => $details->patta_type_code,
                    'pdar_id'            => $inplace->pdar_id,
                    'patta_no'           => trim($details->patta_no),
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                  log_message('error',$result);
                  if ($this->db->affected_rows() <=0)
                  {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO006 could not update chitha_dag_pattadar
                         district: ".$dist_code.", petition_no: ". $petition_no);
                        log_message('error', '#OMAUTO006 Last query => ' . $this->db->last_query());
                      return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                  }
            }

            $infavour_q = "select * from  t_chitha_rmk_infavor_of where ord_no='$order->ord_no' and dag_no='$dag_no' order by infavor_of_id asc";
            $infavour_d = $this->db->query($infavour_q);
            if ($infavour_d == null || $infavour_d->num_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMAUTO007 could not find data in t_chitha_rmk_infavor_of
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }
            $infavour_d = $infavour_d->result();
            $is_pdar_id_set=FALSE;
            $isGlobalSet = false;
            // $globalPdarID = false;
            
            // $multiple_pattadar_count_tot = count($infavour_d);
            // $multiple_pattadar_count = 1;
            // log_message('error','multiple_pattadar_entry_status=='.$dag_no.'==='.$multiple_pattadar_entry);
            foreach ($infavour_d as $infavour)
            {

                    
                
                
                
                $infavour->user_code = $this->user_code;
                $infavour->operation = 'E';
                $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                $infavour->ord_cron_no = $ord_cron_no;
                $infavour->date_entry = date('Y-m-d G:i:s');
                unset($infavour->year_no);
                unset($infavour->petition_no);
                unset($infavour->iscorrected_inco);
                unset($infavour->iscorrected_inco_date);
                unset($infavour->iscorrected_rkg_record);
                unset($infavour->iscorrected_rkg_date);
                unset($infavour->make_mdb);
                unset($infavour->pdar_id);
                unset($infavour->revenue);
                unset($infavour->infavor_is_copdar);
                $new_pattadar = $infavour->new_pattadar;
                unset($infavour->new_pattadar);
                $this->db->insert("chitha_rmk_infavor_of", $infavour);
                $newObj = clone $infavour;
                $pattadar = array();
                $pattadar = array_merge($pattadar, $locationData);
                unset($pattadar['application_no']);

                $org_patta_no=$infavour->patta_no;
                $org_patta_type_code=$infavour->patta_type_code;
                // if($is_pdar_id_set==FALSE)
                // {

                //     // $pdar_id = $this->ChithaUpdateForMutationModel->maxPdarIdForMultiDag($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$org_patta_type_code,$org_patta_no,$dag_no);
                  
                //     $is_pdar_id_set=TRUE;
                // }
                // else
                // {
                //     $pdar_id = $pdar_id+1;
                // }
                
                log_message('error',$dag_no.'===globalPdarID-1111----'.json_encode($globalPdarID));
                log_message('error',$dag_no.'===globalPdarIDsssssssss-1111----'.json_encode($globalPdarIDs));
                log_message('error','generation_pdar_id-----'.json_encode($generation_pdar_id));
                if($generation_pdar_id == false && $globalPdarID == false)
                {

                    $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->cp;

                    $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->jp;
                    $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no') and dag_no='$dag_no'")->row()->dp;
                  
                    if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
                            if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                                $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                            }else{
                                $mgen_pdar_id= $pattadars_in_chitha_pattadar;
                            }
                        }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                            $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                        }else{
                            $mgen_pdar_id= $pattadars_in_jama_pattadar;
                        }
                        if($mgen_pdar_id=== null){
                            $mgen_pdar_id=1;
                        }
                        log_message('error',$dag_no.'SET globalPdarID mgen_pdar_id=============='.json_encode($mgen_pdar_id));
                        $generation_pdar_id=true;
                        if($mgen_pdar_id != 1){
                            $globalPdarIDs = $mgen_pdar_id-1;
                        }
                        else
                        {
                            $globalPdarIDs = $mgen_pdar_id;
                        }
                        log_message('error',$dag_no.'SET globalPdarID =============='.json_encode($globalPdarIDs));
                }
                else
                {


                    if($globalPdarID == true && $isGlobalSet == false)
                    {
                        log_message('error',$dag_no.'ENTRYDONE===globalPdarIDsssssssss-1111----'.json_encode($globalPdarIDs));
                        
                        $mgen_pdar_id = $globalPdarIDs;
                        $mgen_pdar_id = $mgen_pdar_id+ 1;
                        $isGlobalSet = true;
                        
                    }
                    else
                    {
                        $mgen_pdar_id = $mgen_pdar_id+ 1;
                    }
                  
                }
                $pdar_id = $mgen_pdar_id;
                log_message('error',$dag_no.'===globalPdarID-----'.json_encode($globalPdarID));
                log_message('error',$dag_no.'===globalPdarIDssss-----'.json_encode($globalPdarIDs));
                log_message('error',$dag_no.'===pdar_id-----'.json_encode($mgen_pdar_id));
                    // $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where "
                    //         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    //         . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
                    //         . " and TRIM(patta_no)=trim('$infavour->patta_no') and patta_type_code='$infavour->patta_type_code'";
                    // $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

                    // //echo $pdar_id_query;
                    // if ($pdar_id == null) {
                    //     $pdar_id = 1;
                    // }


                //newly added aadhaar details to chitha pattadar----10052023
                $flagAadhaar = null;
                $flagPan = null;
                if($infavour->auth_type == 'AADHAAR'){
                    $pdar_aadharno = $infavour->id_ref_no;
                    $flagAadhaar = $infavour->id_ref_no;
                    $flagPan = null;
                }else if($infavour->auth_type == 'PAN'){
                    $pdar_pan_no = $infavour->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $infavour->id_ref_no;
                }

                $pdar_photo = $infavour->photo;
                $other_data = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'pdar_name' => $infavour->infavor_of_name,
                    'pdar_father' => $infavour->infavor_of_guardian,
                    'pdar_add1' => $infavour->infavor_of_add1,
                    'pdar_add2' => $infavour->infavor_of_add2,
                    'pdar_add3' => "",
                    'user_code' => $infavour->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                    'new_pdar_name' => $new_pattadar,
                    'pdar_aadharno' => $flagAadhaar,
                    'pdar_pan_no'   => $flagPan,
                    'pdar_photo'    => $pdar_photo,
                    'pdar_name_eng' => $infavour->pdar_name_eng,
                    'pdar_guard_eng' => $infavour->pdar_guard_eng,
                );

                $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and $this->base_query")->row();
                $patta_no = trim($details->patta_no);
                $pattadar = array_merge($pattadar, $other_data);

                if($globalPdarID == false)
                {
                    
                    // $tstatus4 = $this->db->insert("chitha_pattadar", $pattadar);
                    $chitha_pattadar['f1_case_no']=$case_no;
                    $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);
                    log_message('error','ENTRY_PATTADAR_COUNT'.$this->db->last_query());
                    if ($tstatus4 != 1)
                    {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO008 could not insert chitha_pattadar
                         district: ".$dist_code.", petition_no: ". $petition_no);
                      return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                    }
                }
                
                // if($multiple_pattadar_count_tot == $multiple_pattadar_count)
                // {
                //     $multiple_pattadar_entry = true;
                // }
                
                // log_message('error','multiple_pattadar_count_tot =='.$dag_no.'==='.$multiple_pattadar_count_tot.' multiple_pattadar_entry=='.$multiple_pattadar_entry."  multiple_pattadar_count==".$multiple_pattadar_count);

                // $multiple_pattadar_count++;
                
                

                $dag_pattadar = array();
                $dag_pattadar = array_merge($dag_pattadar, $locationData);
                unset($dag_pattadar['application_no']);

                $dag_pattadar_other = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'dag_por_b' => $infavour->land_area_b,
                    'dag_por_k' => $infavour->land_area_k,
                    'dag_por_lc' => $infavour->land_area_lc,
                    'dag_por_g' => $infavour->land_area_g,
                    'dag_por_kr' => $infavour->land_area_kr,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'dag_no' => $infavour->dag_no,
                    'p_flag' => 0,
                );
                if(MULTIGENERATION_ACTIVE==1 && $is_multigeneration == 'M')
                {
                    $dag_pattadar_other['p_flag'] = $infavour->pdar_strike;
                }
                $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                // $tstatus5 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                $tstatus5 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                if ($tstatus5 != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO009 could not insert chitha_dag_pattadar
                     district: ".$dist_code.", petition_no: ". $petition_no);
                    return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }

            //     $q = "update  chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //         . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
            //   . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

            //     $this->db->query($q);

            $table = 'chitha_basic';

            $params = [
                'jama_yn' => null,
            ];

            $where = [
                'dist_code'          => $dist_code,
                'subdiv_code'        => $subdiv_code,
                'cir_code'           => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'             => $lot_no,
                'vill_townprt_code'  => $vill_code,
                'dag_no'             => $infavour->dag_no,
                // For patta_no, since you want to trim both sides, trim it before passing:
                'patta_no'           => trim($infavour->patta_no),
            ];

            // Now assuming your model has update method similar to this:
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result <=0)
                {
                  $this->db->trans_rollback();
                  log_message("error"," #OMAUTO010 could not update chitha_basic
                     district: ".$dist_code.", petition_no: ". $petition_no);
                  return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
                }
            }

            $order->user_code = $this->user_code;
            $order->date_entry = date('Y-m-d G:i:s');
            $order->operation = 'E';
            $order->user_code = $this->user_code;
                    //var_dump($order);
            unset($order->year_no);
            unset($order->petition_no);
            unset($order->year_no);
            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->isdataposted_torkg_db);
            unset($order->isorder_cancelled);
            unset($order->ifyes_reason1);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason4);
            unset($order->make_mdb);
            unset($order->min_revenue);
            unset($order->make_mdb);

            $rmk_gen = array(
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'jama_updated' => 'N',
                'patta_no' => trim($patta_no)
            );
            $rmk_gen = array_merge($locationData, $rmk_gen);
            unset($rmk_gen['application_no']);

            $tstatus6 = $this->db->insert("chitha_rmk_gen", $rmk_gen);
            if ($tstatus6 != 1)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMAUTO011 could not insert chitha_rmk_gen
                district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_type_hist_no;
                    //var_dump($rmk_gen);
            $tstatus7 = $this->db->insert("chitha_rmk_ordbasic", $order);
            if ($tstatus7 != 1)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMAUTO012 could not insert chitha_rmk_ordbasic
                district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }

            $q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
            $this->db->query($q);
            if ($this->db->affected_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMAUTO013 could not update t_chitha_rmk_ordbasic
                district: ".$dist_code.", petition_no: ". $petition_no);
                return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
            }
            $rmk_type_hist_no++;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $response = array('responseType' => 1,'globalPdarID'=>$globalPdarIDs );
        } else {            
            return $response = array('responseType' => 2,'globalPdarID'=>$globalPdarIDs );
        }
    }
}
?>