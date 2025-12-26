<?php
class SettlementMbModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function get_settlementTenantPending()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PENDING);
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    public function firstproceedingcount(){

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PENDING);
        echo $this->db->result();
    }

    public function get_paymentNotice()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }



    public function getSettlementCoFirstPending($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        // $status=array(MB_PENDING, 'W');
        // $this->db->select('*');
        // $this->db->from('settlement_basic');
        // $this->db->where('service_code', $service_code);
        // $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
        // $this->db->where_in('status', $status);
        // // $this->db->where($array);
        // $this->db->where('dist_code', $this->session->userdata('dist_code'));
        // $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        // $this->db->where('cir_code', $this->session->userdata('cir_code'));
        // return $this->db->get()->result_array();
    }


    public function getSettlementCoApFirstPending($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        // $status=array(MB_PENDING, 'W');
        // $this->db->select('*');
        // $this->db->from('settlement_basic');
        // $this->db->where('service_code', $service_code);
        // $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
        // $this->db->where_in('status', $status);
        // $this->db->where('notice_generated_yn', NULL);
        // // $this->db->where($array);
        // $this->db->where('dist_code', $this->session->userdata('dist_code'));
        // $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        // $this->db->where('cir_code', $this->session->userdata('cir_code'));
        // return $this->db->get()->result_array();
    }


    public function getSettlementCoApSecondPending($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        // $status=array(MB_PENDING, 'W');
        // $this->db->select('*');
        // $this->db->from('settlement_basic');
        // $this->db->where('service_code', $service_code);
        // $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
        // $this->db->where_in('status', $status);
        // $this->db->where('notice_generated_yn', 'Y');
        // // $this->db->where($array);
        // $this->db->where('dist_code', $this->session->userdata('dist_code'));
        // $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        // $this->db->where('cir_code', $this->session->userdata('cir_code'));
        // return $this->db->get()->result_array();
        
    }

    public function getSettlementSkFirstPending($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $status=array(MB_PENDING, 'W');
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_SUPERVISOR_KANANGU);
        $this->db->where_in('status', $status);
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }




    public function getSettlementApPending()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $status=array(MB_PENDING, 'X');
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', SETTLEMENT_AP_TRANSFER_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where_in('status', $status);
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }



    public function getDcRevertedCases()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        // $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where_in('status', 'R');
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    function updateChithaTenant(){
        return false;
        die();
        $case=$this->input->post('case_no');
        $user_code=$this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        if($user_desig_code!='CO')
            redirect('/home');
        $this->db->db_debug = FALSE;

        ////////////////////////
        $this->db->trans_begin();
        try {
            $sql="Select * from settlement_basic where case_no=?  ";
            $main=$this->db->query($sql,array($case))->row_array();
            if(empty($main))
                redirect('/home');

            $sql1="Select * from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql1,array($case))->row_array();

            if(empty($dagDetails))
                redirect('/home');
            //echo '<pre>';
            //var_dump($dagDetails);
            $sql2="Select * from settlement_applicant where case_no=? and pdar_type in ('B','O')";
            $applicant=$this->db->query($sql2,array($case))->result_array();
            if(empty($applicant))
                redirect('/home');
            //var_dump($applicant);
            //var_dump($lmNote);
            $sql="select inplace_alongwith from settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
            $alongwithOwner=$this->db->query($sql,$case)->num_rows();
            if($alongwithOwner==0){
                $chitha_new_entry=true;
                $new_dag=$_POST['new_dag'];
                $new_patta_type=$_POST['new_patta_type'];
                $new_patta=$_POST['new_patta'];
                ////////////Update In dag Details///////////////
                $updateNewdagPatta=array(
                    'new_dag_no'=>$new_dag,
                    'new_patta_no'=>$_POST['new_patta'],
                    'new_patta_type_code'=>$_POST['new_patta_type'],
                );
                $this->db->where('case_no',$case);
                $this->db->update('settlement_dag_details',$updateNewdagPatta);
                ////////////////////////////////
                if($new_patta==0)
                    redirect('/home');
                //////////////////////////////
                $pdar_id=$this->MaxpdarIdCheckSelectDagWise($case,$new_dag,$new_patta_type,$new_patta);
                //////////////For NEW Remarks///////////////////
                $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$main[dist_code]' and subdiv_code='$main[subdiv_code]' and "
                    . "cir_code='$main[cir_code]' and lot_no='$main[lot_no]' and mouza_pargona_code='$main[mouza_pargona_code]' and vill_townprt_code='$main[vill_townprt_code]' and dag_no='$new_dag'")->row()->cron_no;
                if ($col8order_cron_no == null) {
                    $newcol8order_cron_no = 1;
                }
                //////////////////////
                $location = array(
                    'dist_code' => $main['dist_code'],
                    'subdiv_code' => $main['subdiv_code'],
                    'cir_code' => $main['cir_code'],
                    'mouza_pargona_code' => $main['mouza_pargona_code'],
                    'lot_no' => $main['lot_no'],
                    'vill_townprt_code' => $main['vill_townprt_code'],
                    'dag_no' => $new_dag
                );
                /////////////Insert Into chitha/////////////////
                $cb = array(
                    'dag_no_int' => $_POST['new_dag'] . '00',
                    'old_patta_no'=>$dagDetails['patta_no'],
                    'old_dag_no'=>$dagDetails['dag_no'],
                    'patta_type_code' => $_POST['new_patta_type'],
                    'patta_no' => $_POST['new_patta'],
                    'dag_area_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                    'dag_area_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                    'dag_area_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                    'dag_area_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                    'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                    'dag_area_are' => 0,
                    'land_class_code' =>$this->landClassCode($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['dag_no']),
                    'dag_revenue' => '15',//$_POST['revenue'],
                    'dag_local_tax' => '2.5',//$_POST['local_tax'],
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'jama_yn' => null,
                );
                $chitha_basic = array_merge($location, $cb);
                // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);
                $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                if($tstatusChitha != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"ErrorInCode(#SLPCB001)". $this->db->last_query());
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                    redirect(base_url() . "index.php/home");
                }
                //////////////////////////
                //////////Substract From Original Dag Land area ////////////
                $cb="select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $landAreacb = $this->db->query($cb,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['dag_no']));
                if($landAreacb->num_rows()>0){
                    $landAreacb=$landAreacb->row();
                }
                $total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
                $converArea=$this->utilityclass->Total_Lessa($this->utilityclass->assToeng($dagDetails['s_dag_area_b']),$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']));
                $remanLanArea=$total-$converArea;
                $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
                $bigha=$remanLanArea[0];
                $katha=$remanLanArea[1];
                $lessa=$remanLanArea[2];
                // $cbArray=array(
                //     'dag_area_b' => $bigha,
                //     'dag_area_k' => $katha,
                //     'dag_area_lc' => $lessa,
                //     'user_code' => $user_code,
                //     'date_entry' => date('Y-m-d'),
                //     'jama_yn'=>null
                // );
                // $this->db->where('dist_code', $main['dist_code']);
                // $this->db->where('subdiv_code', $main['subdiv_code']);
                // $this->db->where('cir_code', $main['cir_code']);
                // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                // $this->db->where('lot_no', $main['lot_no']);
                // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                // $this->db->where('dag_no', $dagDetails['dag_no']);
                // $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
                $table = 'chitha_basic';

                $params = [
                    'dag_area_b'   => $bigha,
                    'dag_area_k'   => $katha,
                    'dag_area_lc'  => $lessa,
                    'user_code'    => $user_code,
                    'date_entry'   => date('Y-m-d'),
                    'jama_yn'      => null,
                ];

                $where = [
                    'dist_code'           => $main['dist_code'],
                    'subdiv_code'         => $main['subdiv_code'],
                    'cir_code'            => $main['cir_code'],
                    'mouza_pargona_code'  => $main['mouza_pargona_code'],
                    'lot_no'              => $main['lot_no'],
                    'vill_townprt_code'   => $main['vill_townprt_code'],
                    'dag_no'              => $dagDetails['dag_no'],
                ];

                $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

                if($tstatusChithaOld <= 0 || $tstatusChithaOld > 1  )
                {
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"ErrorInCode(#SLTCB004!1)". $this->db->last_query());
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLTCB004!1)");
                    redirect(base_url() . "index.php/home");
                }
                /////////////////////
                $col8Insert=array
                (
                    'dag_no'=>$new_dag,
                    'col8order_cron_no'=>$newcol8order_cron_no,
                    'order_pass_yn'=>$main['co_code']?'Y':null,
                    'order_type_code'=>$main['service_code'],
                    'lm_code'=>$main['lm_code'],
                    'lm_sign_yn'=>$main['lm_code']?'y':null,
                    'lm_note_date'=>$main['lm_note_date'],
                    'co_code'=>$main['co_code'],
                    'co_sign_yn'=>$main['co_code']?'y':null,
                    'co_ord_date'=>date('Y-m-d'),
                    'user_code'=>$main['co_code'],
                    'date_entry'=>date('Y-m-d'),
                    'operation'=>'E',
                    'mut_land_area_b'=>$dagDetails['s_dag_area_b'],
                    'mut_land_area_k'=>$dagDetails['s_dag_area_k'],
                    'mut_land_area_lc'=>$dagDetails['s_dag_area_lc'],
                    'mut_land_area_g'=>$dagDetails['s_dag_area_g'],
                    'mut_land_area_kr'=>$dagDetails['s_dag_area_kr'],
                    'land_area_left_b'=>$dagDetails['dag_area_b'],
                    'land_area_left_k'=>$dagDetails['dag_area_k'],
                    'land_area_left_lc'=>$dagDetails['dag_area_lc'],
                    'land_area_left_g'=>$dagDetails['dag_area_g'],
                    'land_area_left_kr' =>$dagDetails['dag_area_kr'],
                    'case_no' =>$case
                );
                $chitha_col8_order = array_merge($location, $col8Insert);
                $tsatusC8=$this->db->insert("chitha_col8_order", $chitha_col8_order);
                if($tsatusC8!=1){
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"Error Code(#SLPCTENT001)".$this->db->last_query());
                    $this->session->set_flashdata('message', 'Error in Chitha Updation');
                    redirect(base_url() . 'index.php/home');
                }
                ///////////////
                $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$main[dist_code]' and subdiv_code='$main[subdiv_code]' and "
                    . "cir_code='$main[cir_code]' and lot_no='$main[lot_no]' and mouza_pargona_code='$main[mouza_pargona_code]' and vill_townprt_code='$main[vill_townprt_code]' and dag_no='$dagDetails[dag_no]'")->row()->cron_no;
                if ($col8order_cron_no == null) {
                    $col8order_cron_no = 1;
                }
                $pdar_id=$this->MaxpdarIdCheckDagWise($case);
                $chitha_col8_order['col8order_cron_no'] =$col8order_cron_no;
                $chitha_col8_order['dag_no'] =$dagDetails['dag_no'];
                $tsatusC8=$this->db->insert("chitha_col8_order", $chitha_col8_order);
                if($tsatusC8!=1){
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"Error Code(#SLPCTENT001!1)".$this->db->last_query());
                    $this->session->set_flashdata('message', 'Error in Chitha Updation');
                    redirect(base_url() . 'index.php/home');
                }

            }else{
                $chitha_new_entry=false;
                $pdar_id=$this->MaxpdarIdCheckDagWise($case);
                $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$main[dist_code]' and subdiv_code='$main[subdiv_code]' and "
                    . "cir_code='$main[cir_code]' and lot_no='$main[lot_no]' and mouza_pargona_code='$main[mouza_pargona_code]' and vill_townprt_code='$main[vill_townprt_code]' and dag_no='$dagDetails[dag_no]'")->row()->cron_no;
                if ($col8order_cron_no == null) {
                    $col8order_cron_no = 1;
                }
                //////////////////////
                $location = array(
                    'dist_code' => $main['dist_code'],
                    'subdiv_code' => $main['subdiv_code'],
                    'cir_code' => $main['cir_code'],
                    'mouza_pargona_code' => $main['mouza_pargona_code'],
                    'lot_no' => $main['lot_no'],
                    'vill_townprt_code' => $main['vill_townprt_code'],
                    'dag_no' => $dagDetails['dag_no']
                );
                $col8Insert=array
                (
                    'dag_no'=>$dagDetails['dag_no'],
                    'col8order_cron_no'=>$col8order_cron_no,
                    'order_pass_yn'=>$main['co_code']?'Y':null,
                    'order_type_code'=>$main['service_code'],
                    'lm_code'=>$main['lm_code'],
                    'lm_sign_yn'=>$main['lm_code']?'y':null,
                    'lm_note_date'=>$main['lm_note_date'],
                    'co_code'=>$main['co_code'],
                    'co_sign_yn'=>$main['co_code']?'y':null,
                    'co_ord_date'=>date('Y-m-d'),
                    'user_code'=>$user_code,
                    'date_entry'=>date('Y-m-d'),
                    'operation'=>'E',
                    'mut_land_area_b'=>$dagDetails['s_dag_area_b'],
                    'mut_land_area_k'=>$dagDetails['s_dag_area_k'],
                    'mut_land_area_lc'=>$dagDetails['s_dag_area_lc'],
                    'mut_land_area_g'=>$dagDetails['s_dag_area_g'],
                    'mut_land_area_kr'=>$dagDetails['s_dag_area_kr'],
                    'land_area_left_b'=>$dagDetails['dag_area_b'],
                    'land_area_left_k'=>$dagDetails['dag_area_k'],
                    'land_area_left_lc'=>$dagDetails['dag_area_lc'],
                    'land_area_left_g'=>$dagDetails['dag_area_g'],
                    'land_area_left_kr' =>$dagDetails['dag_area_kr'],
                    'case_no' =>$case
                );
                $chitha_col8_order = array_merge($location, $col8Insert);
                $tsatusC8=$this->db->insert("chitha_col8_order", $chitha_col8_order);
                if($tsatusC8!=1){
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"Error Code(#SLPCTENT001)".$this->db->last_query());
                    $this->session->set_flashdata('message', 'Error in Chitha Updation');
                    redirect(base_url() . 'index.php/home');
                }
            }
            $pattdarIdCheck=TRUE;
            foreach($applicant as $row)
            {
                ////////////////Applicant//////////////////////
                $chitha_col8_tenant=[
                    'dag_no'=>$chitha_new_entry==true?$new_dag:$dagDetails['dag_no'],
                    'col8order_cron_no'=>$chitha_new_entry==true?$newcol8order_cron_no:$col8order_cron_no,
                    'tenant_id'=>$row['pdar_cron_no'],
                    'tenant_name'=> $row['pdar_name'],
                    'tenant_guard_name'=>$row['pdar_guardian'],
                    'tenant_add1'=>$row['pdar_add1'],
                    'tenant_add2'=>$row['pdar_add2'],
                    'tenant_gender' =>($row['pdar_gender']==1)? 'm' : (($row['pdar_gender']==2)? 'f' : 'o'),
                    'land_area_b'=>$dagDetails['s_dag_area_b'],
                    'land_area_k'=>$dagDetails['s_dag_area_k'],
                    'land_area_lc'=>$dagDetails['s_dag_area_lc'],
                    'land_area_g'=>$dagDetails['s_dag_area_g'],
                    'land_area_kr'=>$dagDetails['s_dag_area_kr'],
                    'user_code'=>$main['co_code'],
                    'date_entry'=>date('Y-m-d'),
                    'operation'=>'E',
                    'khatian_no'=>$row['khatian_no'],
                    'inplace_alongwith'=>($row['inplace_alongwith']=='i')? 'i' : (($row['inplace_alongwith']=='a')? 'a' : null),
                    'original_padar_id'=>$row['pdar_id'],
                    'pdar_type'=>$row['pdar_type'],
                    'case_no'=>$case
                ];
                $chitha_col_tenant = array_merge($location, $chitha_col8_tenant);
                $tsatusC8=$this->db->insert("chitha_col8_tenant", $chitha_col_tenant);
                if($tsatusC8!=1){
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"Error Code(#SLPCTENT0011)".$this->db->last_query());
                    $this->session->set_flashdata('message', 'Error in Chitha Updation');
                    redirect(base_url() . 'index.php/home');
                }
                if($chitha_new_entry==true){
                    $chitha_col_tenant['dag_no']=$dagDetails['dag_no'];
                    $chitha_col_tenant['col8order_cron_no']=$col8order_cron_no;
                    $tsatusC8=$this->db->insert("chitha_col8_tenant", $chitha_col_tenant);
                    if($tsatusC8!=1){
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLPCTENT0011!1)".$this->db->last_query());
                        $this->session->set_flashdata('message', 'Error in Chitha Updation');
                        redirect(base_url() . 'index.php/home');
                    }
                }
                //////////Strike from old Dag/////////
                if($row['pdar_type']=='O')
                {
                    // $updateOldPattadar=array(
                    //     'user_code' => $user_code,
                    //     'date_entry' => date('Y-m-d'),
                    //     'operation' => 'E',
                    //     'p_flag' => '1',
                    // );
                    // $this->db->where('dist_code', $main['dist_code']);
                    // $this->db->where('subdiv_code', $main['subdiv_code']);
                    // $this->db->where('cir_code', $main['cir_code']);
                    // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                    // $this->db->where('lot_no', $main['lot_no']);
                    // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                    // $this->db->where('dag_no', $dagDetails['dag_no']);
                    // $this->db->where('patta_no', $dagDetails['patta_no']);
                    // $this->db->where('patta_type_code', $dagDetails['patta_type_code']);
                    // $this->db->where('pdar_id', $row['pdar_id']);
                    // $tstatusCdP = $this->db->update('chitha_dag_pattadar',$updateOldPattadar);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'user_code'  => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation'  => 'E',
                        'p_flag'     => '1',
                    ];

                    $where = [
                        'dist_code'         => $main['dist_code'],
                        'subdiv_code'       => $main['subdiv_code'],
                        'cir_code'          => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no'            => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'dag_no'            => $dagDetails['dag_no'],
                        'patta_no'          => $dagDetails['patta_no'],
                        'patta_type_code'   => $dagDetails['patta_type_code'],
                        'pdar_id'           => $row['pdar_id'],
                    ];

                    $tstatusCdP = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if($tstatusCdP != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"SLPTENT006".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPTENT006)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                else if($row['pdar_type']=='B')
                {
                    // echo $pdar_id.$pattdarIdCheck;
                    // echo "===============<br>";
                    $final_pdarId=$pattdarIdCheck===TRUE?$pdar_id:$pdar_id+1;
                    $c_d_p = array(
                        'pdar_id' =>$final_pdarId,
                        'patta_no' =>$chitha_new_entry==true?$new_patta:$dagDetails['patta_no'],
                        'patta_type_code' =>$chitha_new_entry==true?$new_patta_type:$dagDetails['patta_type_code'],
                        'dag_por_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                        'dag_por_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                        'dag_por_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                        'dag_por_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                        'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'p_flag' => '0',
                        'jama_yn' => 'N',
                    );
                    $chitha_dag_p = array_merge($location, $c_d_p);
                    //var_dump($chitha_dag_p);
                    // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                    $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);
                    // echo $this->db->last_query();
                    // echo "<br>";
                    if($tstatus2 != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLPTENT001)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPTENT001)");
                        redirect(base_url() . "index.php/home");
                    }
                    /////////////Chitha Pattadar////////////////
                    $chitha_pattadar = array(
                        'dist_code' => $main['dist_code'],
                        'subdiv_code' => $main['subdiv_code'],
                        'cir_code' => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no' => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'patta_no' => $chitha_new_entry==true?$new_patta:$dagDetails['patta_no'],
                        'patta_type_code' => $chitha_new_entry==true?$new_patta_type:$dagDetails['patta_type_code'],
                        'pdar_id' => $final_pdarId,
                        'pdar_name' => $row['pdar_name'],
                        'pdar_father' => $row['pdar_guardian'],
                        'pdar_add1' => $row['pdar_add1'],
                        'pdar_add2' => $row['pdar_add2'],
                        //'pdar_pan_no' => $alp->alotee_pan_card,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'pdar_guard_reln' => $this->utilityclass->relationByID($row['pdar_rel_guar']),
                        'pdar_gender' =>($row['pdar_gender']==1)? 'm' : (($row['pdar_gender']==2)? 'f' : 'o'),
                        'pdar_minor_yn' => null,
                        'pdar_minor_dob' => null,
                        'pdar_mother' => $row['pdar_mother'],
                        'pdar_aadharno' => null,
                        'pdar_mobile' => $row['pdar_mobile'],
                        'new_pdar_name'=>'N'
                    );
                    //var_dump($chitha_pattadar);
                    // $tstatusChPat=$this->db->insert('chitha_pattadar', $chitha_pattadar);
                    $chitha_pattadar['f1_case_no']=$case;
                    $tstatusChPat=$this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    if($tstatusChPat != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLPTENT0005)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPTENT0005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $pdar_id++;
                $pattdarIdCheck=false;
            }
            /////////////strike out from chitha_tenant//////////////////
            $applicants = $this->db->select()
                ->where('case_no',$case)
                ->where_in('pdar_type', ['P','GP','EN'])
                ->get('settlement_applicant');
            $allStrikepattadar=$applicants->result();
            foreach($allStrikepattadar as $strike){
                $updateStrike=array(
                    'p_flag'=>'1'
                );
                $this->db->where('dist_code', $main['dist_code']);
                $this->db->where('subdiv_code', $main['subdiv_code']);
                $this->db->where('cir_code', $main['cir_code']);
                $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                $this->db->where('lot_no', $main['lot_no']);
                $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                $this->db->where('dag_no', $dagDetails['dag_no']);
                $this->db->where('khatian_no', $strike->khatian_no);
                $this->db->where('tenant_id', $strike->riotee_id);
                $this->db->update('chitha_tenant',$updateStrike);
                if($this->db->affected_rows()!=1){
                    $this->db->trans_rollback();
                    log_message('error',"Error Code(#SLPTENTP00100)".$this->db->last_query());
                    $this->session->set_flashdata('message', 'Error in Final Updation');
                    redirect(base_url() . 'index.php/home');
                }
            }
            //////////////End Applicant ////////////////////////////
            $updateSettlement=array(
                'status'=>'F',
                'from_office'=>'CO',
                'pending_officer'=>null,
                'co_chitha_corrected_yn'=>'y',
                'co_chitha_corrected_date'=>date('Y-m-d H:i:s')
            );
            $this->db->where('case_no',$case);
            $this->db->update('settlement_basic',$updateSettlement);
            if($this->db->affected_rows()<=0){
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"Error Code(#SLPTENTP007)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
                redirect(base_url() . 'index.php/home');
            } else {
                //////////////POST To basundhara/////////////////////
                $this->db->trans_commit();
                return true;
                // $rmk='Chitha Updated';
                // $status='F';
                // $task='CO';
                // $pen='NA';
                // $rtps_status=$this->basundharamodel->postApiBasundhara($main['applid'],$case,$rmk,$status,$task,$pen);
                // $rtps_status=json_decode($rtps_status);
                // //var_dump($rtps_status);
                // if($rtps_status===false || $rtps_status===0){
                //     $this->db->trans_rollback();
                //     $this->session->set_flashdata('message', "Error #ERRAPP0011: Unable to update chitha, case no # $case_no");
                //     redirect(base_url() . "index.php/home");
                // }else{
                //     $this->db->trans_commit();
                //     return true;
                // }
            }

        }catch (error $e) {
            log_message('error',$this->db->db_debug);
        }

    }
    function updateChithaAP(){
        $case=$this->input->post('case_no');
        $user_code=$this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        if($user_desig_code!='CO')
            redirect('/home');
        $this->db->db_debug = FALSE;
        ////////////////////////
        $sql="Select * from settlement_dag_details where case_no=?";
        $dagDetailsCheck=$this->db->query($sql,array($case))->row_array();
        if($dagDetailsCheck['dag_no']){
            //////////////Check for all village data for completed or not with same dag/////////////////
            $sql="Select * from settlement_dag_details where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
            and lot_no=? and vill_townprt_code=? and dag_no=? and new_dag_no is not null";
            $dagDetailsValidate=$this->db->query($sql,array($dagDetailsCheck['dist_code'],$dagDetailsCheck['subdiv_code'],$dagDetailsCheck['cir_code'],$dagDetailsCheck['mouza_pargona_code'],$dagDetailsCheck['lot_no'],$dagDetailsCheck['vill_townprt_code'],$dagDetailsCheck['dag_no']));
            if($dagDetailsValidate->num_rows()>0){
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB00799)". $this->db->last_query());
                $this->session->set_flashdata('message', "NR has been already Completed. Error Code(#SLPCB00799)");
                redirect(base_url() . "index.php/home");
            }
        }
        ////////////////////////
        $updateNewdagPatta=array(
            'new_dag_no'=>$_POST['new_dag'],
            'new_patta_no'=>$_POST['new_patta'],
            'new_patta_type_code'=>$_POST['new_patta_type'],
            'new_dag_revenue'=>$_POST['revenue'],
            'new_land_class_code'=>$_POST['land_class'],
            'new_local_tax'=>$_POST['local_tax'],
        );
        $this->db->where('case_no',$case);
        $this->db->update('settlement_dag_details',$updateNewdagPatta);
        ////////////////////////
        $this->db->trans_begin();
        try {
            $sql="Select * from settlement_basic where case_no=? and status=? and from_office=? and 
            pending_officer=? ";
            $main=$this->db->query($sql,array($case,'C','DC','CO'))->row_array();
            if(empty($main))
                redirect('/home');

            $sql1="Select * from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql1,array($case))->row_array();
            if(empty($dagDetails))
                redirect('/home');
            //echo '<pre>';
            //var_dump($dagDetails);
            $sql2="Select * from settlement_applicant where case_no=?";
            $applicant=$this->db->query($sql2,array($case))->result_array();
            if(empty($applicant))
                redirect('/home');
            //var_dump($applicant);
            $sql3="Select * from settlement_ap_lmnote where case_no=? order by id desc";
            $lmNote=$this->db->query($sql3,array($case))->row_array();
            //var_dump($lmNote);

            $q="Select max(rmk_type_hist_no)+1 as c from chitha_rmk_gen where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
            $histNo = $this->db->query($q,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['dag_no']))->row();
            if($histNo->c==null){
                $rmk_type_hist_no = 1;
            }else{
                $rmk_type_hist_no = $histNo->c;
            }
            $ord_cron_no = 1;
            $location = array(
                'dist_code' => $main['dist_code'],
                'subdiv_code' => $main['subdiv_code'],
                'cir_code' => $main['cir_code'],
                'mouza_pargona_code' => $main['mouza_pargona_code'],
                'lot_no' => $main['lot_no'],
                'vill_townprt_code' => $main['vill_townprt_code'],
                'dag_no' => $_POST['new_dag']
            );
            /////////////14-03-23///////////////////
            if($dagDetails['dag_no']==$_POST['new_dag'])
                $fullorpartial='F';
            else
                $fullorpartial=null;
            //////////////////////////
            $cb = array(
                'dag_no_int' => $_POST['new_dag'] . '00',
                'patta_type_code' => $_POST['new_patta_type'],
                'patta_no' => $_POST['new_patta'],
                'dag_area_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                'dag_area_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                'dag_area_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                'dag_area_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                'dag_area_are' => 0,
                'land_class_code' => $_POST['land_class'],
                'dag_revenue' => $_POST['revenue'],
                'dag_local_tax' => $_POST['local_tax'],
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_yn' => null,
            );
            $chitha_basic = array_merge($location, $cb);
            // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);
            $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
            if($tstatusChitha != 1)
            {
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB001)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                redirect(base_url() . "index.php/home");
            }
            //////////////////////////
            $r_gen = array(
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => $_POST['new_patta']
            );
            $rmk_gen = array_merge($location, $r_gen);
            $tstatusRmk= $this->db->insert('chitha_rmk_gen',$rmk_gen);
            if($tstatusRmk != 1)
            {
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB002)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB002)");
                redirect(base_url() . "index.php/home");
            }
            $o_basic = array(
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'ord_no' => $main['case_no'],
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => $main['service_code'],
                'ord_cron_no' => $ord_cron_no,
                'case_no' => $main['case_no'],
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $user_desig_code,
                //'lm_code' => $lmNote['user_code'],
                'lm_sign_yn' => 'Y',
                //'lm_sign_date' => $lmNote['date_entry'],
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => date('Y-m-d'),
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                'm_dag_area_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                'm_dag_area_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                'm_dag_area_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                'area_left_b' => '0',
                'area_left_k' => '0',
                'area_left_lc' => '0',
                'area_left_g' => '0',
                'full_partial'=> $fullorpartial,
                'rural_urban' =>$dagDetails['is_urban']
            );
            $ord_basic = array_merge($location, $o_basic);
            $tstatusOrd= $this->db->insert('chitha_rmk_ordbasic',$ord_basic);
            if($tstatusOrd != 1)
            {
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB003)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB003)");
                redirect(base_url() . "index.php/home");
            }
            //////////Substract From Original Dag Land area ////////////
            $cb="select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
            $landAreacb = $this->db->query($cb,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['dag_no']));
            if($landAreacb->num_rows()>0){
                $landAreacb=$landAreacb->row();
            }
            $total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
            $converArea=$this->utilityclass->Total_Lessa($this->utilityclass->assToeng($dagDetails['s_dag_area_b']),$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']));
            $remanLanArea=$total-$converArea;
            $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
            $bigha=$remanLanArea[0];
            $katha=$remanLanArea[1];
            $lessa=$remanLanArea[2];
            // $cbArray=array(
            //     'dag_area_b' => $bigha,
            //     'dag_area_k' => $katha,
            //     'dag_area_lc' => $lessa,
            //     'user_code' => $user_code,
            //     'date_entry' => date('Y-m-d'),
            //     'jama_yn'=>null
            // );
            // $this->db->where('dist_code', $main['dist_code']);
            // $this->db->where('subdiv_code', $main['subdiv_code']);
            // $this->db->where('cir_code', $main['cir_code']);
            // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
            // $this->db->where('lot_no', $main['lot_no']);
            // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
            // $this->db->where('dag_no', $dagDetails['dag_no']);
            // $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
            $table = 'chitha_basic';

            $params = [
                'dag_area_b'   => $bigha,
                'dag_area_k'   => $katha,
                'dag_area_lc'  => $lessa,
                'user_code'    => $user_code,
                'date_entry'   => date('Y-m-d'),
                'jama_yn'      => null,
            ];

            $where = [
                'dist_code'           => $main['dist_code'],
                'subdiv_code'         => $main['subdiv_code'],
                'cir_code'            => $main['cir_code'],
                'mouza_pargona_code'  => $main['mouza_pargona_code'],
                'lot_no'              => $main['lot_no'],
                'vill_townprt_code'   => $main['vill_townprt_code'],
                'dag_no'              => $dagDetails['dag_no'],
            ];

            $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

            if($tstatusChithaOld <= 0 || $tstatusChithaOld > 1  )
            {
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB004)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB004)");
                redirect(base_url() . "index.php/home");
            }
            /////////////////////
            $pattdarIdCheck=TRUE;
            foreach ($applicant as $slp) {
                $allotee = array(
                    'dist_code' =>$slp['dist_code'],
                    'subdiv_code' =>$slp['subdiv_code'],
                    'cir_code' =>$slp['cir_code'],
                    'mouza_pargona_code' =>$slp['mouza_pargona_code'],
                    'lot_no' =>$slp['lot_no'],
                    'vill_townprt_code' =>$slp['vill_townprt_code'],
                    'dag_no' =>$_POST['new_dag'],
                    'rmk_type_hist_no'=>$rmk_type_hist_no,
                    'ord_no' =>$slp['case_no'],
                    'ord_date' => date('Y-m-d'),
                    'ord_cron_no' =>$ord_cron_no,
                    'settlement_id' =>$slp['pdar_cron_no'],
                    'settlement_name'  =>$slp['pdar_name'],
                    'settlement_guardian'=> $slp['pdar_guardian'],
                    'settlement_guar_relation'=> $slp['pdar_rel_guar'],
                    'settlement_gender'=> $slp['pdar_gender'],
                    'settlement_mother'=> $slp['pdar_mother'],
                    //'settlement_dob'=> $slp[''],
                    //'settlement_type_code'=> $slp[''],
                    //'settlement_land_code'=> $slp[''],
                    'settlement_land_b' =>$slp['i_area_b'],
                    'settlement_land_k' =>$slp['i_area_k'],
                    'settlement_land_lc' =>$slp['i_area_lc'],
                    'settlement_land_g' =>$slp['i_area_g'],
                    'settlement_land_kr' =>$slp['i_area_kr'],
                    'user_code' =>$user_code,
                    'date_entry' =>date('Y-m-d H:i:s'),
                    'operation' =>'E',
                    'case_no' =>$slp['case_no'],
                    'patta_no' =>$_POST['new_patta'],
                    'old_patta_no' =>$slp['patta_no'],
                    'old_dag' =>$slp['dag_no'],
                    'new_dag' =>$_POST['new_dag'],
                    'new_patta_type' =>$_POST['new_patta_type'],
                    'pdar_type' =>$slp['pdar_type'],
                    'inplace_along_with'=>null
                );
                //var_dump($allotee);
                $tstatusallotee= $this->db->insert('chitha_settlement_allottee',$allotee);
                if($tstatusallotee != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"ErrorInCode(#SLPCB005)". $this->db->last_query() );
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB005)");
                    redirect(base_url() . "index.php/home");
                }
                /////////////////
                //Insert query
                /////////////////
                if($pattdarIdCheck===TRUE){
                    $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
                    dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->cp;
                    ///echo $this->db->last_query();
                    $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and 
                        TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->jp;
                    //echo $this->db->last_query();
                    $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
                        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no=?",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta'],$_POST['new_dag']))->row()->dp;
                    //echo $this->db->last_query();
                    if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
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
                    if($pdar_id== null){
                        $pdar_id=1;
                    }
                    $pattdarIdCheck=false;
                }
                /////////////////////////////////////
                if($slp['pdar_type']=='B'){
                    $final_pdarId=$pattdarIdCheck==TRUE?$pdar_id:$pdar_id+1;
                    $c_d_p = array(
                        'pdar_id' => $final_pdarId,
                        'patta_no' => $_POST['new_patta'],
                        'patta_type_code' => $_POST['new_patta_type'],
                        'dag_por_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                        'dag_por_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                        'dag_por_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                        'dag_por_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                        'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'p_flag' => '0',
                        'jama_yn' => 'N',
                    );
                    $chitha_dag_p = array_merge($location, $c_d_p);
                    // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                    $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);
                    if($tstatus2 != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLP001)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLP001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //var_dump($chitha_dag_p);
                    $chitha_pattadar = array(
                        'dist_code' => $main['dist_code'],
                        'subdiv_code' => $main['subdiv_code'],
                        'cir_code' => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no' => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'patta_no' => $_POST['new_patta'],
                        'patta_type_code' => $_POST['new_patta_type'],
                        'pdar_id' => $final_pdarId,
                        'pdar_name' => $slp['pdar_name'],
                        'pdar_father' => $slp['pdar_guardian'],
                        'pdar_add1' => $slp['pdar_add1'],
                        'pdar_add2' => $slp['pdar_add2'],
                        //'pdar_pan_no' => $alp->alotee_pan_card,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'pdar_guard_reln' => $this->utilityclass->relationByID($slp['pdar_rel_guar']),
                        'pdar_gender' =>($slp['pdar_gender']==1)? 'm' : (($slp['pdar_gender']==2)? 'f' : 'o'),
                        'pdar_minor_yn' => null,
                        'pdar_minor_dob' => null,
                        'pdar_mother' => $slp['pdar_mother'],
                        'pdar_aadharno' => null,
                        'pdar_mobile' => $slp['pdar_mobile'],
                        'new_pdar_name'=>'N'
                    );
                    //var_dump($chitha_pattadar);
                    // $tstatusChPat=$this->db->insert('chitha_pattadar', $chitha_pattadar);
                    $chitha_pattadar['f1_case_no']=$case;
                    $tstatusChPat=$this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    if($tstatusChPat != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLPCP005)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCP005)");
                        redirect(base_url() . "index.php/home");
                    }
                    //echo $this->db->last_query();  
                }else if($slp['pdar_type']=='O'){
                    // $updateOldPattadar=array(
                    //     'user_code' => $user_code,
                    //     'date_entry' => date('Y-m-d'),
                    //     'operation' => 'E',
                    //     'p_flag' => ($slp['inplace_alongwith'] == 'i' ) ? 1 : (( $slp['inplace_alongwith'] == 'a' ) ? 0 : 0),
                    // );
                    // $this->db->where('dist_code', $main['dist_code']);
                    // $this->db->where('subdiv_code', $main['subdiv_code']);
                    // $this->db->where('cir_code', $main['cir_code']);
                    // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                    // $this->db->where('lot_no', $main['lot_no']);
                    // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                    // $this->db->where('dag_no', $dagDetails['dag_no']);
                    // $this->db->where('patta_no', $dagDetails['patta_no']);
                    // $this->db->where('patta_type_code', $dagDetails['patta_type_code']);
                    // $this->db->where('pdar_id', $slp['pdar_id']);
                    // $tstatusCdP = $this->db->update('chitha_dag_pattadar',$updateOldPattadar);
                    //echo $this->db->last_query();
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'user_code'  => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation'  => 'E',
                        'p_flag'     => ($slp['inplace_alongwith'] == 'i') ? 1 : 0,
                    ];

                    $where = [
                        'dist_code'         => $main['dist_code'],
                        'subdiv_code'       => $main['subdiv_code'],
                        'cir_code'          => $main['cir_code'],
                        'mouza_pargona_code'=> $main['mouza_pargona_code'],
                        'lot_no'            => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'dag_no'            => $dagDetails['dag_no'],
                        'patta_no'          => $dagDetails['patta_no'],
                        'patta_type_code'   => $dagDetails['patta_type_code'],
                        'pdar_id'           => $slp['pdar_id'],
                    ];

                    $tstatusCdP = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if($tstatusCdP != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SLPCDP006)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCDP006)");
                        redirect(base_url() . "index.php/home");
                    }
                    //echo $this->db->last_query();   
                }
            }
            $updateSettlement=array(
                'status'=>'F',
                'from_office'=>'CO',
                'pending_officer'=>null,
                'co_chitha_corrected_yn'=>'y',
                'co_chitha_corrected_date'=>date('Y-m-d H:i:s')
            );
            $this->db->where('case_no',$case);
            $this->db->update('settlement_basic',$updateSettlement);
            if($this->db->affected_rows()<=0){
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"Error Code(#SLPCDP007)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
                redirect(base_url() . 'index.php/home');
            } else {


                //////////////POST To basundhara/////////////////////
                $rmk='Chitha Updated';
                $status='F';
                $task='CO';
                $pen='NA';
                $rtps_status=$this->basundharamodel->postApiBasundhara($main['applid'],$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if($rtps_status===false || $rtps_status===0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Unable to update chitha, case no # $case");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    return true;
                }
            }
        }////end of try
        catch (error $e) {
            //echo $e;
            //var_dump($this->db->db_debug);
            log_message('error',$this->db->db_debug);
        }
    }
    function updateChithaAPNR(){
        return false;
        die();
        $case=$this->input->post('case_no');
        $total=0;
        $user_code=$this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        if($user_desig_code!='CO')
            redirect('/home');
        $this->db->db_debug = FALSE;
        ////////////////////////
        $updateNewdagPatta=array(
            'new_patta_no'=>$_POST['new_patta'],
            'dag_no'=>$_POST['dag_no'],
            'new_patta_type_code'=>$_POST['new_patta_type'],
            'new_dag_revenue'=>$_POST['revenue'],
            'new_local_tax'=>$_POST['local_tax'],
        );
        $this->db->where('case_no',$case);
        $this->db->update('settlement_dag_details',$updateNewdagPatta);
        ////////////////////////
        $this->db->trans_begin();
        try {
            $sql="Select * from settlement_basic where case_no=? and status=? and from_office=? and 
            pending_officer=? ";
            $main=$this->db->query($sql,array($case,'N','CO','CO'))->row_array();
            if(empty($main))
                redirect('/home');

            $sql1="Select * from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql1,array($case))->row_array();
            if(empty($dagDetails))
                redirect('/home');
            //echo '<pre>';
            //var_dump($dagDetails);
            $sql2="Select * from settlement_applicant where case_no=?";
            $applicant=$this->db->query($sql2,array($case))->result_array();
            if(empty($applicant))
                redirect('/home');
            //var_dump($applicant);
            $sql3="Select * from settlement_ap_lmnote where case_no=? order by id desc";
            $lmNote=$this->db->query($sql3,array($case))->row_array();
            //var_dump($lmNote);
            //////////////////////////
            ////////////////////////////
            $payment_date=date('Y-m-d',strtotime($this->input->post('payment_date')));
            $this->db->where('case_no',$case);
            $this->db->where('notice_type','PN');
            $this->db->update('settlement_notice',array('payment_completed_date'=>$payment_date));
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                log_message('error',"Error Code(#SLP00023)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }
            $insertArr = [
                'case_no' => $case,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'Payment Cofirmed/Chitha Update',
                'status' => 'P',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Payment Confirmed'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc !=1){
                $this->db->trans_rollback();
                log_message('error',"Error Code(#SAPNR00025)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            //////////////Newly Modified///////////////
            if($_POST['dag_no']!=$dagDetails['new_dag_no']){
                $response=$this->dagNoCreate($case,$_POST['dag_no']);
                if($response!=true){
                    $this->session->set_flashdata('message', 'Error in Final Updation');
                    redirect(base_url() . 'index.php/home');
                }
                $sql1="Select * from settlement_dag_details where case_no=?";
                $dagDetails=$this->db->query($sql1,array($case))->row_array();
                if(empty($dagDetails))
                    redirect('/home');
            }
            ////////////End Modified///////////////
            $q="Select max(rmk_type_hist_no)+1 as c from chitha_rmk_gen where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
            $histNo = $this->db->query($q,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['new_dag_no']))->row();
            if($histNo->c==null){
                $rmk_type_hist_no = 1;
            }else{
                $rmk_type_hist_no = $histNo->c;
            }
            $ord_cron_no = 1;
            $location = array(
                'dist_code' => $main['dist_code'],
                'subdiv_code' => $main['subdiv_code'],
                'cir_code' => $main['cir_code'],
                'mouza_pargona_code' => $main['mouza_pargona_code'],
                'lot_no' => $main['lot_no'],
                'vill_townprt_code' => $main['vill_townprt_code'],
                'dag_no' => $dagDetails['new_dag_no'],
            );
            //////////////////////////
            $r_gen = array(
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => $_POST['new_patta']
            );
            $rmk_gen = array_merge($location, $r_gen);
            $tstatusRmk= $this->db->insert('chitha_rmk_gen',$rmk_gen);
            if($tstatusRmk != 1)
            {
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SAPNR002)". $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR002)");
                redirect(base_url() . "index.php/home");
            }
            //////////Substract From Original Dag Land area ////////////
            $reserveAreaRoad=0;
            $roadside="Select CASE
                            WHEN dist_code ='21' THEN (bigha*6400 + katha*320 + lessa *20 +ganda )
                            when dist_code !='21' then (bigha*100 + katha*20 + lessa  )
                          END 
                          AS total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? and type='R' group by dag_no,dist_code,bigha,katha,lessa,ganda ";
            $roadSideQuery=$this->db->query($roadside,array($main['case_no'],$dagDetails['dag_no']));
            //echo $this->db->last_query();
            if($roadSideQuery->num_rows()>0){
                $reserveAreaRoad=$roadSideQuery->row()->total_lessa;
            }
            if($reserveAreaRoad!=0){
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $applied=$dagDetails['s_dag_area_b']*6400+$dagDetails['s_dag_area_k']*320+$dagDetails['s_dag_area_lc']*20+$dagDetails['s_dag_area_g'];
                    $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa2($applied-$reserveAreaRoad);
                }else{
                    $applied=$dagDetails['s_dag_area_b']*100+$dagDetails['s_dag_area_k']*20+$dagDetails['s_dag_area_lc'];
                    $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa($applied-$reserveAreaRoad);
                }
                $bigha_substract=$areaSubstract[0];
                $katha_substract=$areaSubstract[1];
                $lessa_substract=$areaSubstract[2];
                $ganda_substract=$areaSubstract[3];
            }
            ////////////////////////////////////////
            $o_basic = array(
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'ord_no' => $main['case_no'],
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => $main['service_code'],
                'ord_cron_no' => $ord_cron_no,
                'case_no' => $main['case_no'],
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $user_desig_code,
                //'lm_code' => $lmNote['user_code'],
                'lm_sign_yn' => 'Y',
                //'lm_sign_date' => $lmNote['date_entry'],
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => date('Y-m-d'),
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $reserveAreaRoad!=0?$bigha_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                'm_dag_area_k' => $reserveAreaRoad!=0?$katha_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                'm_dag_area_lc' => $reserveAreaRoad!=0?$lessa_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                'm_dag_area_g' => $reserveAreaRoad!=0?$ganda_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                'area_left_b' => '0',
                'area_left_k' => '0',
                'area_left_lc' => '0',
                'area_left_g' => '0'
            );
            $ord_basic = array_merge($location, $o_basic);
            $tstatusOrd= $this->db->insert('chitha_rmk_ordbasic',$ord_basic);
            if($tstatusOrd != 1)
            {
                log_message('error',"ErrorInCode(#SAPNR003)". $this->db->last_query());
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR003)");
                redirect(base_url() . "index.php/home");
            }
            //////////Update Dag Details ////////////
            $cb="select CASE
                            WHEN dist_code ='21' THEN (dag_area_b *6400 + dag_area_k *320 + dag_area_lc *20 + dag_area_g )
                            when dist_code !='21' then (dag_area_b *100 + dag_area_k *20 + dag_area_lc  )
                          END 
                          AS total from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? group by dist_code,dag_area_b,dag_area_k,dag_area_lc,dag_area_g";
            $landAreacb = $this->db->query($cb,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$dagDetails['dag_no']));
            if($landAreacb->num_rows()>0){
                $landAreacb=$landAreacb->row();
                $total=$landAreacb->total;
            }
            //$total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
            if($reserveAreaRoad!=0){
                $total=$total+$reserveAreaRoad;
                /////////////////////
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$roadSideQuery->row()->bigha. " বিঘা ".$roadSideQuery->row()->katha." কঠা ".$roadSideQuery->row()->lessa." লেচা ". $roadSideQuery->row()->ganda ." গোণ্ডা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                }else{
                    $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$roadSideQuery->row()->bigha. " বিঘা ".$roadSideQuery->row()->katha." কঠা ".$roadSideQuery->row()->lessa." লেচা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                }
                $insert = array(
                    'dist_code' => $main['dist_code'],
                    'subdiv_code' => $main['subdiv_code'],
                    'cir_code' => $main['cir_code'],
                    'mouza_pargona_code' => $main['mouza_pargona_code'],
                    'lot_no' => $main['lot_no'],
                    'vill_townprt_code' => $main['vill_townprt_code'],
                    'patta_no' => $dagDetails['patta_no'],
                    'patta_type_code' => $dagDetails['patta_type_code'],
                    'dag_no' => $dagDetails['dag_no'],
                    'dag_no_int' => $dagDetails['dag_no'].'00',
                    'remark' => addslashes($rmk),
                    'category' => 2,
                    'date_entry' => date('Y-m-d'),
                    'user_code' => $user_code,
                );
                $this->db->insert('backlog_orders', $insert);
                if($this->db->affected_rows()!=1){
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                    redirect(base_url() . "index.php/home");
                }
                /////////////////////
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa2($total);
                }else{
                    $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($total);
                }
                $bigha=$remanLanArea[0];
                $katha=$remanLanArea[1];
                $lessa=$remanLanArea[2];
                $ganda=$remanLanArea[3];
                // $cbArray=array(
                //     'dag_area_b' => $bigha,
                //     'dag_area_k' => $katha,
                //     'dag_area_lc' => $lessa,
                //     'dag_area_g' => $ganda,
                //     'user_code' => $user_code,
                //     'date_entry' => date('Y-m-d'),
                //     'jama_yn'=>null
                // );
                // $this->db->where('dist_code', $main['dist_code']);
                // $this->db->where('subdiv_code', $main['subdiv_code']);
                // $this->db->where('cir_code', $main['cir_code']);
                // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                // $this->db->where('lot_no', $main['lot_no']);
                // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                // $this->db->where('dag_no', $dagDetails['dag_no']);
                // $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
                $table = 'chitha_basic';

                $params = [
                    'dag_area_b'   => $bigha,
                    'dag_area_k'   => $katha,
                    'dag_area_lc'  => $lessa,
                    'dag_area_g'   => $ganda,
                    'user_code'    => $user_code,
                    'date_entry'   => date('Y-m-d'),
                    'jama_yn'      => null,
                ];

                $where = [
                    'dist_code'           => $main['dist_code'],
                    'subdiv_code'         => $main['subdiv_code'],
                    'cir_code'            => $main['cir_code'],
                    'mouza_pargona_code'  => $main['mouza_pargona_code'],
                    'lot_no'              => $main['lot_no'],
                    'vill_townprt_code'   => $main['vill_townprt_code'],
                    'dag_no'              => $dagDetails['dag_no'],
                ];

                $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

                log_message('error',"ErrorInCode(#SAPNR00412)". $this->db->last_query());
                if($tstatusChithaOld <= 0 || $tstatusChithaOld > 1  )
                {
                    log_message('error',"ErrorInCode(#SAPNR00412)". $this->db->last_query());
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00412)");
                    redirect(base_url() . "index.php/home");
                }
            }
            /////////////////////////////////////
            // $cbArray=array(
            //     'dag_area_b'=>$reserveAreaRoad!=0?$bigha_substract:$dagDetails['s_dag_area_b'],
            //     'dag_area_k'=>$reserveAreaRoad!=0?$katha_substract:$dagDetails['s_dag_area_k'],
            //     'dag_area_lc'=>$reserveAreaRoad!=0?$lessa_substract:$dagDetails['s_dag_area_lc'],
            //     'dag_area_g'=>$reserveAreaRoad!=0?$ganda_substract:$dagDetails['s_dag_area_g'],
            //     'patta_no' => $dagDetails['new_patta_no'],
            //     'patta_type_code' => $dagDetails['new_patta_type_code'],
            //     'dag_revenue' => $dagDetails['new_dag_revenue'],
            //     'dag_local_tax' => $dagDetails['new_local_tax'],
            //     'user_code' => $user_code,
            //     'date_entry' => date('Y-m-d'),
            //     'jama_yn'=>null
            // );
            // $this->db->where('dist_code', $main['dist_code']);
            // $this->db->where('subdiv_code', $main['subdiv_code']);
            // $this->db->where('cir_code', $main['cir_code']);
            // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
            // $this->db->where('lot_no', $main['lot_no']);
            // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
            // $this->db->where('dag_no', $dagDetails['new_dag_no']);
            // $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
            $table = 'chitha_basic';

            $params = [
                'dag_area_b'       => $reserveAreaRoad != 0 ? $bigha_substract : $dagDetails['s_dag_area_b'],
                'dag_area_k'       => $reserveAreaRoad != 0 ? $katha_substract : $dagDetails['s_dag_area_k'],
                'dag_area_lc'      => $reserveAreaRoad != 0 ? $lessa_substract : $dagDetails['s_dag_area_lc'],
                'dag_area_g'       => $reserveAreaRoad != 0 ? $ganda_substract : $dagDetails['s_dag_area_g'],
                'patta_no'         => $dagDetails['new_patta_no'],
                'patta_type_code'  => $dagDetails['new_patta_type_code'],
                'dag_revenue'      => $dagDetails['new_dag_revenue'],
                'dag_local_tax'    => $dagDetails['new_local_tax'],
                'user_code'        => $user_code,
                'date_entry'       => date('Y-m-d'),
                'jama_yn'          => null,
            ];

            $where = [
                'dist_code'           => $main['dist_code'],
                'subdiv_code'         => $main['subdiv_code'],
                'cir_code'            => $main['cir_code'],
                'mouza_pargona_code'  => $main['mouza_pargona_code'],
                'lot_no'              => $main['lot_no'],
                'vill_townprt_code'   => $main['vill_townprt_code'],
                'dag_no'              => $dagDetails['new_dag_no'],
            ];

            $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

            log_message('error',"ErrorInCode(#SAPNR004)". $this->db->last_query());
            if($tstatusChithaOld <= 0 || $tstatusChithaOld > 1  )
            {
                log_message('error',"ErrorInCode(#SAPNR004)". $this->db->last_query());
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR004)");
                redirect(base_url() . "index.php/home");
            }
            $pattdarIdCheck=TRUE;
            if($pattdarIdCheck===TRUE){
                $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
                    dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->cp;
                ///echo $this->db->last_query();
                $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and 
                        TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->jp;
                //echo $this->db->last_query();
                $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
                        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no=?",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta'],$dagDetails['new_dag_no']))->row()->dp;
                //echo $this->db->last_query();
                if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
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
                if($pdar_id== null){
                    $pdar_id=1;
                }
                $pattdarIdCheck=false;
            }
            foreach ($applicant as $slp) {
                $allotee = array(
                    'dist_code' =>$slp['dist_code'],
                    'subdiv_code' =>$slp['subdiv_code'],
                    'cir_code' =>$slp['cir_code'],
                    'mouza_pargona_code' =>$slp['mouza_pargona_code'],
                    'lot_no' =>$slp['lot_no'],
                    'vill_townprt_code' =>$slp['vill_townprt_code'],
                    'dag_no' =>$dagDetails['new_dag_no'],
                    'rmk_type_hist_no'=>$rmk_type_hist_no,
                    'ord_no' =>$slp['case_no'],
                    'ord_date' => date('Y-m-d'),
                    'ord_cron_no' =>$ord_cron_no,
                    'settlement_id' =>$slp['pdar_cron_no'],
                    'settlement_name'  =>$slp['pdar_name'],
                    'settlement_guardian'=> $slp['pdar_guardian'],
                    'settlement_guar_relation'=> $slp['pdar_rel_guar'],
                    'settlement_gender'=> $slp['pdar_gender'],
                    'settlement_mother'=> $slp['pdar_mother'],
                    //'settlement_dob'=> $slp[''],
                    //'settlement_type_code'=> $slp[''],
                    //'settlement_land_code'=> $slp[''],
                    'settlement_land_b' =>0,
                    'settlement_land_k' =>0,
                    'settlement_land_lc' =>0,
                    'settlement_land_g' =>0,
                    'settlement_land_kr' =>0,
                    'user_code' =>$user_code,
                    'date_entry' =>date('Y-m-d H:i:s'),
                    'operation' =>'E',
                    'case_no' =>$slp['case_no'],
                    'patta_no' =>$_POST['new_patta'],
                    'old_patta_no' =>$slp['patta_no'],
                    'old_dag' =>$dagDetails['dag_no'],
                    'new_dag' =>$dagDetails['new_dag_no'],
                    'new_patta_type' =>$_POST['new_patta_type'],
                    'pdar_type' =>$slp['pdar_type'],
                    'inplace_along_with'=>($slp['inplace_alongwith'] == 'i' ) ? 1 : (( $slp['inplace_alongwith'] == 'a' ) ? 0 : 0)
                );
                $tstatusallotee= $this->db->insert('chitha_settlement_allottee',$allotee);
                log_message('error',$this->db->last_query());
                if($tstatusallotee != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    log_message('error',"ErrorInCode(#SAPNR005)". $this->db->last_query() );
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR005)");
                    redirect(base_url() . "index.php/home");
                }
                /////////////////
                //Insert query
                /////////////////
                /////////////////////////////////////
                if($slp['pdar_type']=='B'){
                    $final_pdarId=$pattdarIdCheck==false?$pdar_id:$pdar_id+1;
                    $c_d_p = array(
                        'pdar_id' => $final_pdarId,
                        'patta_no' => $_POST['new_patta'],
                        'patta_type_code' => $_POST['new_patta_type'],
                        'dag_por_b' => $reserveAreaRoad!=0?$bigha_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                        'dag_por_k' => $reserveAreaRoad!=0?$katha_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                        'dag_por_lc' => $reserveAreaRoad!=0?$lessa_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                        'dag_por_g' => $reserveAreaRoad!=0?$ganda_substract:$this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                        'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'p_flag' => '0',
                        'jama_yn' => 'N',
                    );
                    // $this->db->where('dist_code', $main['dist_code']);
                    // $this->db->where('subdiv_code', $main['subdiv_code']);
                    // $this->db->where('cir_code', $main['cir_code']);
                    // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                    // $this->db->where('lot_no', $main['lot_no']);
                    // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                    // $this->db->where('dag_no', $dagDetails['new_dag_no']);
                    $chitha_dag_p = array_merge($location, $c_d_p);
                    // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                    $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);
                    if($tstatus2 != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"Error Code(#SAPNR001)".$this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //var_dump($chitha_dag_p);
                    $chitha_pattadar = array(
                        'dist_code' => $main['dist_code'],
                        'subdiv_code' => $main['subdiv_code'],
                        'cir_code' => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no' => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'patta_no' => $_POST['new_patta'],
                        'patta_type_code' => $_POST['new_patta_type'],
                        'pdar_id' => $final_pdarId,
                        'pdar_name' => $slp['pdar_name'],
                        'pdar_father' => $slp['pdar_guardian'],
                        'pdar_add1' => $slp['pdar_add1'],
                        'pdar_add2' => $slp['pdar_add2'],
                        //'pdar_pan_no' => $alp->alotee_pan_card,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'pdar_guard_reln' => $this->utilityclass->relationByID($slp['pdar_rel_guar']),
                        'pdar_gender' =>($slp['pdar_gender']==1)? 'm' : (($slp['pdar_gender']==2)? 'f' : 'o'),
                        'pdar_minor_yn' => null,
                        'pdar_minor_dob' => null,
                        'pdar_mother' => $slp['pdar_mother'],
                        'pdar_aadharno' => null,
                        'pdar_mobile' => $slp['pdar_mobile'],
                        'new_pdar_name'=>'N'
                    );
                    //var_dump($chitha_pattadar);
                    // $tstatusChPat=$this->db->insert('chitha_pattadar', $chitha_pattadar);
                    $chitha_pattadar['f1_case_no']=$case;
                    $tstatusChPat=$this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    if($tstatusChPat != 1)
                    {
                        log_message('error',"Error Code(#SAPNR005)".$this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR005)");
                        redirect(base_url() . "index.php/home");
                    }
                    //echo $this->db->last_query(); 
                    $pattdarIdCheck=true;
                }else if($slp['pdar_type']=='O'){
                    // $updateOldPattadar=array(
                    //     'user_code' => $user_code,
                    //     'date_entry' => date('Y-m-d'),
                    //     'operation' => 'E',
                    //     'p_flag' => ($slp['inplace_alongwith'] == 'i' ) ? 1 : (( $slp['inplace_alongwith'] == 'a' ) ? 0 : 0),
                    // );
                    // $this->db->where('dist_code', $main['dist_code']);
                    // $this->db->where('subdiv_code', $main['subdiv_code']);
                    // $this->db->where('cir_code', $main['cir_code']);
                    // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                    // $this->db->where('lot_no', $main['lot_no']);
                    // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                    // $this->db->where('dag_no', $dagDetails['dag_no']);
                    // $this->db->where('patta_no', $dagDetails['patta_no']);
                    // $this->db->where('patta_type_code', $dagDetails['patta_type_code']);
                    // $this->db->where('pdar_id', $slp['pdar_id']);
                    // $tstatusCdP = $this->db->update('chitha_dag_pattadar',$updateOldPattadar);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'user_code'  => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation'  => 'E',
                        'p_flag'     => ($slp['inplace_alongwith'] == 'i') ? 1 : 0,
                    ];

                    $where = [
                        'dist_code'         => $main['dist_code'],
                        'subdiv_code'       => $main['subdiv_code'],
                        'cir_code'          => $main['cir_code'],
                        'mouza_pargona_code'=> $main['mouza_pargona_code'],
                        'lot_no'            => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'dag_no'            => $dagDetails['dag_no'],
                        'patta_no'          => $dagDetails['patta_no'],
                        'patta_type_code'   => $dagDetails['patta_type_code'],
                        'pdar_id'           => $slp['pdar_id'],
                    ];

                    $tstatusCdP = $this->Chitha_basic_model->update_table($table, $params, $where);

                    //echo $this->db->last_query();
                    if($tstatusCdP != 1)
                    {
                        log_message('error',"Error Code(#SAPNR006)".$this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR006)");
                        redirect(base_url() . "index.php/home");
                    }
                    //echo $this->db->last_query();   
                }
            }
            $updateSettlement=array(
                'status'=>'F',
                'from_office'=>'CO',
                'pending_officer'=>null,
                'co_chitha_corrected_yn'=>'y',
                'co_chitha_corrected_date'=>date('Y-m-d H:i:s')
            );
            $this->db->where('case_no',$case);
            $this->db->update('settlement_basic',$updateSettlement);
            if($this->db->affected_rows()<=0){
                log_message('error',"Error Code(#SAPNR007)".$this->db->last_query());
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////////////////////////
            //Update into settlement_premium table dharitree
            $insertSettlementPremiumArr = [
                'total_premium' => $this->input->post('total_premium'),
                'paid_amount' => $this->input->post('paid_amount'),
                'remaining_amount' => $this->input->post('remaining_amount')==null?'0':$this->input->post('remaining_amount'),
                'tenure' => $this->input->post('tenure')==null?'0':$this->input->post('tenure'),
                'installment_amount' => $this->input->post('installment_amount')==null?'0':$this->input->post('installment_amount'),
                'installment_amount' => $this->input->post('installment_amount')==null?'0':$this->input->post('installment_amount'),
                'payment_date' => $this->input->post('payment_date')==null?'0':$this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_premium', $insertSettlementPremiumArr);
            ////////////////////////////////////////////
            if ($this->db->affected_rows() == 0) {
                log_message('error',"Error Code(#SLPCDP444007)".$this->db->last_query());
                //log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////Notice Date update///////////////
            $insertSettlementnotice = [

                'paid_amount' => $this->input->post('paid_amount'),
                'payment_completed_date' => $this->input->post('payment_date')==null?'0':$this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_notice', $insertSettlementnotice);
            ///////////////////////////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
                redirect(base_url() . 'index.php/home');
            } else {
                $this->db->trans_commit();
                return true;

                //////////////POST To basundhara/////////////////////
                // $rmk='Chitha Updated';
                // $status='F';
                // $task='CO';
                // $pen='NA';
                // $rtps_status=$this->basundharamodel->postApiBasundhara($main['applid'],$case,$rmk,$status,$task,$pen);
                // $rtps_status=json_decode($rtps_status);
                // //var_dump($rtps_status);
                // if($rtps_status===false || $rtps_status===0){
                //     $this->db->trans_rollback();
                //     $this->session->set_flashdata('message', "Error #ERRAPP0011: Unable to update chitha, case no # $case_no");
                //     redirect(base_url() . "index.php/home");
                // }else{
                //     $this->db->trans_commit();
                //     return true;
                // }
            }
        }////end of try
        catch (error $e) {
            //echo $e;
            //var_dump($this->db->db_debug);
            log_message('error',$this->db->db_debug);
        }
    }
    function updateChitha(){
        //var_dump($_POST);
        $case=$this->input->post('case_no');
        $user_code=$this->session->userdata('user_code');
        $user_desig_code=$this->session->userdata('user_desig_code');
        if($user_desig_code!='CO')
            redirect('/home');
        $this->db->db_debug = FALSE;
        ////////////////////////
        $this->db->trans_begin();
        try {
            $sql="Select * from settlement_basic where case_no=? and status!=? ";
            $main=$this->db->query($sql,array($case,'F'))->row_array();
            if(empty($main))
                redirect('/home');

            $sql1="Select * from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql1,array($case))->result_array();
            if(empty($dagDetails))
                redirect('/home');
            //echo '<pre>';
            //var_dump($dagDetails);
            $sql2="Select * from settlement_applicant where case_no=? and pdar_type=?";
            $applicant=$this->db->query($sql2,array($case,'B'))->result_array();
            if(empty($applicant))
                redirect('/home');
            //var_dump($applicant);
            $sql3="Select * from settlement_ap_lmnote where case_no=? order by id desc";
            $lmNote=$this->db->query($sql3,array($case))->row_array();
            //var_dump($lmNote);
            $pdar_id=$this->MaxpdarIdCheck($case,$_POST['new_dag']);
            $converArea=0;
            ////////////////////////////
            $payment_date=date('Y-m-d',strtotime($this->input->post('payment_date')));
            $this->db->where('case_no',$case);
            $this->db->update('settlement_notice',array('payment_completed_date'=>$payment_date));
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                log_message('error',"Error Code(#SLP00023)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }
            $insertArr = [
                'case_no' => $case,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => 'Payment Cofirmed/Chitha Update',
                'status' => 'P',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'DC',
                'task' => 'Payment Confirmed'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc !=1){
                $this->db->trans_rollback();
                log_message('error',"Error Code(#SLP00025)".$this->db->last_query());
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////////////////////
            foreach($_POST['new_dag'] as $key=>$newPostedDags){
                $old_dag=$_POST['old_dag'][$key];
                $partitionType=$_POST['partitionType'][$key];
                $new_land_class=$_POST['land_class'][$key];
                $revenue=$_POST['revenue'][$key];
                $localTax=$_POST['local_tax'][$key];
                $new_dag=$newPostedDags;
                /////////////14-03-23///////////////////
                if($new_dag==$old_dag)
                    $fullorpartial='F';
                else
                    $fullorpartial=null;
                ///////////////////////////////
                if($_POST['new_patta']==0)
                    redirect('/home');
                ////////////Update In dag Details///////////////
                $updateNewdagPatta=array(
                    'new_dag_no'=>$new_dag,
                    'new_patta_no'=>$_POST['new_patta'],
                    'new_patta_type_code'=>$_POST['new_patta_type'],
                    'new_dag_revenue'=>$revenue,
                    'new_land_class_code'=>$new_land_class,
                    'new_local_tax'=>$localTax,
                );
                $this->db->where('case_no',$case);
                $this->db->where('dag_no',$old_dag);
                $this->db->update('settlement_dag_details',$updateNewdagPatta);
                //////////////////////New Query//////////////////////////////////
                $q="Select max(rmk_type_hist_no)+1 as c from chitha_rmk_gen where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
                $histNo = $this->db->query($q,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$new_dag))->row();
                if($histNo->c==null){
                    $rmk_type_hist_no = 1;
                }else{
                    $rmk_type_hist_no = $histNo->c;
                }
                $ord_cron_no = 1;
                $location = array(
                    'dist_code' => $main['dist_code'],
                    'subdiv_code' => $main['subdiv_code'],
                    'cir_code' => $main['cir_code'],
                    'mouza_pargona_code' => $main['mouza_pargona_code'],
                    'lot_no' => $main['lot_no'],
                    'vill_townprt_code' => $main['vill_townprt_code'],
                    'dag_no' => $new_dag
                );
                //////////////////////////
                $sql1="Select * from settlement_dag_details where case_no=? and dag_no=?";
                $dagDetails=$this->db->query($sql1,array($case,$old_dag))->row_array();
                if(empty($dagDetails))
                    redirect('/home');

                ///////////For Only HOME/////////////////
                $reserveAreaRoad=0;
                if($partitionType=='1'){
                    //////////////Minus land area Both family and road side if reserve exists///////////////
                    $roadside="SELECT dist_code,
                              CASE
                                WHEN dist_code ='21' THEN (bigha*6400 + katha*320 + lessa *20 +ganda )
                                when dist_code !='21' then (bigha*100 + katha*20 + lessa  )
                              END 
                              AS total_lessa
                            FROM settlement_reservation where case_no=? and dag_no=? 
                            group by dist_code,bigha,katha,lessa,ganda";
                    $roadSideQuery=$this->db->query($roadside,array($main['case_no'],$old_dag)) ;
                    if($roadSideQuery->num_rows()>0){
                        $reserved=$roadSideQuery->row();
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $applied=$dagDetails['home_b']*6400+$dagDetails['home_k']*320+$dagDetails['home_lc']*20 + $dagDetails['home_g'];
                            $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa2($applied-$reserved->total_lessa);
                        }else{
                            $applied=$dagDetails['home_b']*100+$dagDetails['home_k']*20+$dagDetails['home_lc'];
                            $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa($applied-$reserved->total_lessa);
                        }

                        $bigha=$areaSubstract[0];
                        $katha=$areaSubstract[1];
                        $lessa=$areaSubstract[2];
                        $gonda=$areaSubstract[3];
                        $reserveAreaRoad=1;
                    }
                    ///////////////////////////////                  
                    $dagDetails['s_dag_area_b']= $reserveAreaRoad!=0?$bigha:$dagDetails['home_b'];
                    $dagDetails['s_dag_area_k']= $reserveAreaRoad!=0?$katha:$dagDetails['home_k'];
                    $dagDetails['s_dag_area_lc']= $reserveAreaRoad!=0?$lessa:$dagDetails['home_lc'];
                    $dagDetails['s_dag_area_g']= $reserveAreaRoad!=0?$gonda:$dagDetails['home_g'];
                    $dagDetails['s_dag_area_kr']= $dagDetails['home_kr'];
                    $cb = array(
                        'dag_no_int' => $new_dag . '00',
                        'old_dag_no' => $old_dag,
                        'patta_type_code' => $_POST['new_patta_type'],
                        'patta_no' => $_POST['new_patta'],
                        'dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$bigha:$dagDetails['s_dag_area_b']),
                        'dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$katha:$dagDetails['s_dag_area_k']),
                        'dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$lessa:$dagDetails['s_dag_area_lc']),
                        'dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$gonda:$dagDetails['s_dag_area_g']),
                        'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'dag_area_are' => 0,
                        'land_class_code' => $new_land_class,
                        'dag_revenue' => $revenue,
                        'dag_local_tax' => $localTax,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => null,
                        'dag_status'=>($this->input->post('total_premium')-$this->input->post('paid_amount'))==0?'G':null
                    );

                    $chitha_basic = array_merge($location, $cb);
                    // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);
                    $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if($tstatusChitha != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB001)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //////////////////////////
                    $r_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $_POST['new_patta']
                    );
                    $rmk_gen = array_merge($location, $r_gen);
                    $tstatusRmk= $this->db->insert('chitha_rmk_gen',$rmk_gen);
                    if($tstatusRmk != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB002)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB002)");
                        redirect(base_url() . "index.php/home");
                    }
                    $o_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $main['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $main['service_code'],
                        'ord_cron_no' => $ord_cron_no,
                        'case_no' => $main['case_no'],
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $user_desig_code,
                        //'lm_code' => $lmNote['user_code'],
                        'lm_sign_yn' => 'Y',
                        //'lm_sign_date' => $lmNote['date_entry'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$bigha:$dagDetails['s_dag_area_b']),
                        'm_dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$katha:$dagDetails['s_dag_area_k']),
                        'm_dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$lessa:$dagDetails['s_dag_area_lc']),
                        'm_dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$gonda:$dagDetails['s_dag_area_g']),
                        'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'rural_urban' => $dagDetails['is_urban'],
                        'full_partial' =>$fullorpartial,
                    );
                    $ord_basic = array_merge($location, $o_basic);
                    $tstatusOrd= $this->db->insert('chitha_rmk_ordbasic',$ord_basic);
                    if($tstatusOrd != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB003)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB003)");
                        redirect(base_url() . "index.php/home");
                    }
                    if($converArea==0){
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $converArea=$this->utilityclass->Total_ganda($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc'],$dagDetails['home_g']);
                        }else{
                            $converArea=$this->utilityclass->Total_Lessa($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc']);
                        }
                    }else{
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $newArea=$this->utilityclass->Total_ganda($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc'],$dagDetails['home_g']);
                        }else{
                            $newArea=$this->utilityclass->Total_Lessa($dagDetails['home_b'],$dagDetails['home_k'],$dagDetails['home_lc']);
                        }
                        $converArea=$converArea+$newArea;
                    }
                }
                ///////////For Only AGRI///////////////

                else if($partitionType=='2'){
                    $reserveAreaRoad=0;
                    //////////////Minus land area Both family and road side if reserve exists///////////////
                    // $roadside="Select sum(bigha*100 + katha*20 + lessa) total_lessa from settlement_reservation where case_no=? and dag_no=? ";
                    $roadside="SELECT dist_code,
                              CASE
                                WHEN dist_code ='21' THEN sum(bigha*6400 + katha*320 + lessa *20 +ganda)
                                when dist_code !='21' then sum(bigha*100 + katha*20 + lessa)
                              END 
                              AS total_lessa
                            FROM settlement_reservation where case_no=? and dag_no=? 
                            group by dist_code,bigha,katha,lessa,ganda";
                    $roadSideQuery=$this->db->query($roadside,array($main['case_no'],$old_dag)) ;
                    //echo $this->db->last_query();
                    //echo "<br> ----------------";
                    // $roadside="Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? ";
                    // $roadSideQuery=$this->db->query($roadside,array($main['case_no'])); 
                    if($roadSideQuery->num_rows()>0){
                        $reserved=$roadSideQuery->row();
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $applied=$dagDetails['agri_b']*6400+$dagDetails['agri_k']*320+$dagDetails['agri_lc']*20 + $dagDetails['agri_g'];
                            $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa2($applied-$reserved->total_lessa);
                        }else{
                            $applied=$dagDetails['agri_b']*100+$dagDetails['agri_k']*20+$dagDetails['agri_lc'];
                            $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa($applied-($reserved->total_lessa));
                        }
                        //var_dump($areaSubstract);
                        $bigha=$areaSubstract[0];
                        $katha=$areaSubstract[1];
                        $lessa=$areaSubstract[2];
                        $gonda=$areaSubstract[3];
                        $reserveAreaRoad=1;
                    }
                    // echo "<br> ----------------";
                    ///////////////////////////////  
                    $dagDetails['s_dag_area_b']= $reserveAreaRoad!=0?$bigha:$dagDetails['agri_b'];
                    $dagDetails['s_dag_area_k']= $reserveAreaRoad!=0?$katha:$dagDetails['agri_k'];
                    $dagDetails['s_dag_area_lc']= $reserveAreaRoad!=0?$lessa:$dagDetails['agri_lc'];
                    $dagDetails['s_dag_area_g']= $reserveAreaRoad!=0?$gonda:$dagDetails['agri_g'];
                    $dagDetails['s_dag_area_kr']= $dagDetails['agri_kr'];
                    $cb = array(
                        'dag_no_int' => $new_dag . '00',
                        'old_dag_no' => $old_dag,
                        'patta_type_code' => $_POST['new_patta_type'],
                        'patta_no' => $_POST['new_patta'],
                        'dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$bigha:$dagDetails['s_dag_area_b']),
                        'dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$katha:$dagDetails['s_dag_area_k']),
                        'dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$lessa:$dagDetails['s_dag_area_lc']),
                        'dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$gonda:$dagDetails['s_dag_area_g']),
                        'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'dag_area_are' => 0,
                        'land_class_code' => $new_land_class,
                        'dag_revenue' => $revenue,
                        'dag_local_tax' => $localTax,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_yn' => null,
                        'dag_status'=>($this->input->post('total_premium')-$this->input->post('paid_amount'))==0?'G':null
                    );
                    $chitha_basic = array_merge($location, $cb);
                    // $tstatusChitha=$this->db->insert('chitha_basic',$chitha_basic);

                    $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    if($tstatusChitha != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB001)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB001)");
                        redirect(base_url() . "index.php/home");
                    }
                    //////////////////////////
                    $r_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $_POST['new_patta']
                    );
                    $rmk_gen = array_merge($location, $r_gen);
                    $tstatusRmk= $this->db->insert('chitha_rmk_gen',$rmk_gen);
                    if($tstatusRmk != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB002)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB002)");
                        redirect(base_url() . "index.php/home");
                    }
                    $o_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $main['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $main['service_code'],
                        'ord_cron_no' => $ord_cron_no,
                        'case_no' => $main['case_no'],
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $user_desig_code,
                        //'lm_code' => $lmNote['user_code'],
                        'lm_sign_yn' => 'Y',
                        //'lm_sign_date' => $lmNote['date_entry'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$bigha:$dagDetails['s_dag_area_b']),
                        'm_dag_area_k' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$katha:$dagDetails['s_dag_area_k']),
                        'm_dag_area_lc' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$lessa:$dagDetails['s_dag_area_lc']),
                        'm_dag_area_g' => $this->utilityclass->assToeng($reserveAreaRoad!=0?$gonda:$dagDetails['s_dag_area_g']),
                        'm_dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'rural_urban' => $dagDetails['is_urban'],
                        'full_partial' =>$fullorpartial,
                    );
                    $ord_basic = array_merge($location, $o_basic);
                    $tstatusOrd= $this->db->insert('chitha_rmk_ordbasic',$ord_basic);
                    if($tstatusOrd != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB003)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB003)");
                        redirect(base_url() . "index.php/home");
                    }
                    if($converArea==0){
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $converArea=$this->utilityclass->Total_ganda($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc'],$dagDetails['agri_g']);
                        }else{
                            $converArea=$this->utilityclass->Total_Lessa($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc']);
                        }
                    }else{
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $newArea=$this->utilityclass->Total_ganda($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc'],$dagDetails['agri_g']);
                        }else{
                            $newArea=$this->utilityclass->Total_Lessa($dagDetails['agri_b'],$dagDetails['agri_k'],$dagDetails['agri_lc']);
                        }
                        $converArea=$converArea+$newArea;
                    }
                }

                //////////Substract From Original Dag Land area (Only Road Side) ////////////
                $reserveAreaRoad=0;
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $roadside="Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? and (type='R')";
                }else{
                    $roadside="Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? and dag_no=? and (type='R')";
                }
                $roadSideQuery=$this->db->query($roadside,array($main['case_no'],$old_dag));
                //echo $this->db->last_query();
                if($roadSideQuery->num_rows()>0){
                    $reserveAreaRoad=$roadSideQuery->row()->total_lessa;
                }
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $totalReserve="Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? ";
                }else{
                    $totalReserve="Select (bigha*100 + katha*20 + lessa) total_lessa, bigha,katha,lessa from settlement_reservation where case_no=? and dag_no=? ";
                }
                $totalReserve=$this->db->query($totalReserve,array($main['case_no'],$old_dag));
                //echo $this->db->last_query();
                if($totalReserve->num_rows()>0){
                    $reserveAreaRoadFamily=$totalReserve->row()->total_lessa;
                }
                $cb="select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $landAreacb = $this->db->query($cb,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$old_dag));
                if($landAreacb->num_rows()>0){
                    $landAreacb=$landAreacb->row();
                }
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $total=$this->utilityclass->Total_ganda($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc,$landAreacb->dag_area_g);
                }else{
                    $total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
                }

                if($reserveAreaRoad){
                    $total=$total+$reserveAreaRoad;
                    /////////////////////
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                        $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$roadSideQuery->row()->bigha. " বিঘা ".$roadSideQuery->row()->katha." কঠা ".$roadSideQuery->row()->lessa." চাটক ".$roadSideQuery->row()->ganda." গোণ্ডা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }else{
                        $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$roadSideQuery->row()->bigha. " বিঘা ".$roadSideQuery->row()->katha." কঠা ".$roadSideQuery->row()->lessa." লেচা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }
                    $insert = array(
                        'dist_code' => $main['dist_code'],
                        'subdiv_code' => $main['subdiv_code'],
                        'cir_code' => $main['cir_code'],
                        'mouza_pargona_code' => $main['mouza_pargona_code'],
                        'lot_no' => $main['lot_no'],
                        'vill_townprt_code' => $main['vill_townprt_code'],
                        'patta_no' => $dagDetails['patta_no'],
                        'patta_type_code' => $dagDetails['patta_type_code'],
                        'dag_no' => $old_dag,
                        'dag_no_int' => $old_dag.'00',
                        'remark' => addslashes($rmk),
                        'category' => 2,
                        'date_entry' => date('Y-m-d'),
                        'user_code' => $user_code,
                    );
                    $this->db->insert('backlog_orders', $insert);
                    if($this->db->affected_rows()!=1){
                        log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                        redirect(base_url() . "index.php/home");
                    }
                    /////////////////////
                }
                //echo $total."###".$converArea ."<br>";
                $remanLanArea=$total-$converArea;
                if($remanLanArea<0){
                    $this->db->trans_rollback();
                    log_message('error',"#####CaseNo".$case."######TotalArea".$total ."MinusLandArea".$converArea ."#reserved".$reserveAreaRoad);
                    $this->session->set_flashdata('message', "Remaining Land Area less than 0");
                    redirect(base_url() . "index.php/home");
                }
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa2($remanLanArea);
                }else{
                    $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
                }
                log_message('error',"#####CaseNo".$case."######TotalArea".$total ."MinusLandArea".$converArea);
                $bigha=$remanLanArea[0];
                $katha=$remanLanArea[1];
                $lessa=$remanLanArea[2];
                $gonda=$remanLanArea[3];
                // $cbArray=array(
                //     'dag_area_b' => $bigha,
                //     'dag_area_k' => $katha,
                //     'dag_area_lc' => $lessa,
                //     'dag_area_g' => $gonda,
                //     'user_code' => $user_code,
                //     'date_entry' => date('Y-m-d'),
                //     'jama_yn'=>null
                // );
                // $this->db->where('dist_code', $main['dist_code']);
                // $this->db->where('subdiv_code', $main['subdiv_code']);
                // $this->db->where('cir_code', $main['cir_code']);
                // $this->db->where('mouza_pargona_code' ,$main['mouza_pargona_code']);
                // $this->db->where('lot_no', $main['lot_no']);
                // $this->db->where('vill_townprt_code', $main['vill_townprt_code']);
                // $this->db->where('dag_no', $old_dag);
                // $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
                // $this->db->trans_rollback();
                // die;

                $table = 'chitha_basic';

                $params = [
                    'dag_area_b'   => $bigha,
                    'dag_area_k'   => $katha,
                    'dag_area_lc'  => $lessa,
                    'dag_area_g'   => $gonda, // assuming this was intended as 'gonda', not 'ganda'
                    'user_code'    => $user_code,
                    'date_entry'   => date('Y-m-d'),
                    'jama_yn'      => null,
                ];

                $where = [
                    'dist_code'           => $main['dist_code'],
                    'subdiv_code'         => $main['subdiv_code'],
                    'cir_code'            => $main['cir_code'],
                    'mouza_pargona_code'  => $main['mouza_pargona_code'],
                    'lot_no'              => $main['lot_no'],
                    'vill_townprt_code'   => $main['vill_townprt_code'],
                    'dag_no'              => $old_dag,
                ];

                $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

                if($tstatusChithaOld <= 0 || $tstatusChithaOld > 1  )
                {
                    log_message('error',"ErrorInCode(#SLPCB004)". $this->db->last_query());
                    log_message('error',"ErrorInCode" . $this->db->db_debug);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB004)");
                    redirect(base_url() . "index.php/home");
                }
                $pattdarIdCheck=TRUE;
                foreach ($applicant as $slp)
                {
                    $allotee = array(
                        'dist_code' =>$slp['dist_code'],
                        'subdiv_code' =>$slp['subdiv_code'],
                        'cir_code' =>$slp['cir_code'],
                        'mouza_pargona_code' =>$slp['mouza_pargona_code'],
                        'lot_no' =>$slp['lot_no'],
                        'vill_townprt_code' =>$slp['vill_townprt_code'],
                        'dag_no' =>$new_dag,
                        'rmk_type_hist_no'=>$rmk_type_hist_no,
                        'ord_no' =>$slp['case_no'],
                        'ord_date' => date('Y-m-d'),
                        'ord_cron_no' =>$ord_cron_no,
                        'settlement_id' =>$slp['pdar_cron_no'],
                        'settlement_name'  =>$slp['pdar_name'],
                        'settlement_guardian'=> $slp['pdar_guardian'],
                        'settlement_guar_relation'=> $slp['pdar_rel_guar'],
                        'settlement_gender'=> $slp['pdar_gender'],
                        'settlement_mother'=> $slp['pdar_mother'],
                        'settlement_land_b' =>0,
                        'settlement_land_k' =>0,
                        'settlement_land_lc' =>0,
                        'settlement_land_g' =>0,
                        'settlement_land_kr' =>0,
                        'user_code' =>$this->session->userdata('user_code'),
                        'date_entry' =>date('Y-m-d H:i:s'),
                        'operation' =>'E',
                        'case_no' =>$slp['case_no'],
                        'patta_no' =>$_POST['new_patta'],
                        'old_patta_no' =>$slp['patta_no'],
                        'old_dag' =>$old_dag,
                        'new_dag' =>$new_dag,
                        'new_patta_type' =>$_POST['new_patta_type'],
                        'pdar_type' =>$slp['pdar_type'],
                        'lm_code' =>$main['lm_code'],
                        'dc_code' =>$main['dc_code'],
                        'inplace_along_with'=>null
                    );
                    //var_dump($allotee);
                    $tstatusallotee= $this->db->insert('chitha_settlement_allottee',$allotee);
                    if($tstatusallotee != 1)
                    {
                        log_message('error',"ErrorInCode(#SLPCB005)". $this->db->last_query() );
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB005)");
                        redirect(base_url() . "index.php/home");
                    }
                    //Insert query/////////////////
                    /////////////////////////////////////
                    if($slp['pdar_type']=='B'){
                        $final_pdarId=$pdar_id;
                        $c_d_p = array(
                            'pdar_id' => $final_pdarId,
                            'patta_no' => $_POST['new_patta'],
                            'patta_type_code' => $_POST['new_patta_type'],
                            'dag_por_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                            'dag_por_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                            'dag_por_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                            'dag_por_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                            'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                            'user_code' => $user_code,
                            'date_entry' => date('Y-m-d'),
                            'operation' => 'E',
                            'p_flag' => '0',
                            'jama_yn' => 'N',
                        );
                        $chitha_dag_p = array_merge($location, $c_d_p);
                        //var_dump($chitha_dag_p);
                        // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                        $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);
                        //echo $this->db->last_query();
                        if($tstatus2 != 1)
                        {
                            log_message('error',"Error Code(#SLP001)".$this->db->last_query());
                            log_message('error',"ErrorInCode" . $this->db->db_debug);
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLP001)");
                            redirect(base_url() . "index.php/home");
                        }
                        /////////////Chitha Pattadar////////////////
                        if($pattdarIdCheck===TRUE){
                            $chitha_pattadar = array(
                                'dist_code' => $main['dist_code'],
                                'subdiv_code' => $main['subdiv_code'],
                                'cir_code' => $main['cir_code'],
                                'mouza_pargona_code' => $main['mouza_pargona_code'],
                                'lot_no' => $main['lot_no'],
                                'vill_townprt_code' => $main['vill_townprt_code'],
                                'patta_no' => $_POST['new_patta'],
                                'patta_type_code' => $_POST['new_patta_type'],
                                'pdar_id' => $final_pdarId,
                                'pdar_name' => $slp['pdar_name'],
                                'pdar_father' => $slp['pdar_guardian'],
                                'pdar_add1' => $slp['pdar_add1'],
                                'pdar_add2' => $slp['pdar_add2'],
                                //'pdar_pan_no' => $alp->alotee_pan_card,
                                'user_code' => $user_code,
                                'date_entry' => date('Y-m-d'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'pdar_guard_reln' => $this->utilityclass->relationByID($slp['pdar_rel_guar']),
                                'pdar_gender' =>($slp['pdar_gender']==1)? 'm' : (($slp['pdar_gender']==2)? 'f' : 'o'),
                                'pdar_minor_yn' => null,
                                'pdar_minor_dob' => null,
                                'pdar_mother' => $slp['pdar_mother'],
                                'pdar_aadharno' => null,
                                'pdar_mobile' => $slp['pdar_mobile'],
                                'new_pdar_name'=>'N'
                            );
                            //var_dump($chitha_pattadar);
                            // $tstatusChPat=$this->db->insert('chitha_pattadar', $chitha_pattadar);
                            $chitha_pattadar['f1_case_no']=$case;
                            $tstatusChPat=$this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                            if($tstatusChPat != 1)
                            {
                                log_message('error',"Error Code(#SLPCP005)".$this->db->last_query());
                                log_message('error',"ErrorInCode" . $this->db->db_debug);
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCP005)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        $pdar_id++;
                    }
                }
                $pattdarIdCheck=FALSE;
            }
            /////////////////////////////////////////
            if($main['service_code']==SETTLEMENT_PGR_VGR_LAND_ID){
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $vgr="Select (bigha*6400 + katha*320 + lessa*20 + ganda) total_lessa, * from settlement_reservation where case_no=? and type='V'";
                }else{
                    $vgr="Select (bigha*100 + katha*20 + lessa) total_lessa, * from settlement_reservation where case_no=? and type='V'";
                }
                $vgrQuery=$this->db->query($vgr,array($main['case_no']));
                //echo $this->db->last_query();
                if($vgrQuery->num_rows()>0){
                    $reserveforVgr=$vgrQuery->row();
                    //$reserveforVgr=$vgrQuery->row()->total_lessa;
                }
                $cb="select dag_area_b,dag_area_k,dag_area_lc,dag_area_g from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                $landAreacb = $this->db->query($cb,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$reserveforVgr->dag_no));
                if($landAreacb->num_rows()>0){
                    $landAreacb=$landAreacb->row();
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                        $total=$this->utilityclass->Total_ganda($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc,$landAreacb->dag_area_g);
                    }else{
                        $total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
                    }
                }
                //////////////////
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $existVgrLand="select sum(bigha*6400+katha*320+lessa*20+ganda) as applied from chitha_reservation_vgr where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                }else{
                    $existVgrLand="select sum(bigha*100+katha*20+lessa) as applied from chitha_reservation_vgr where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
                }
                $landAreaVgr = $this->db->query($existVgrLand,array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$reserveforVgr->dag_no));
                if($landAreaVgr->num_rows()>0){
                    $landAreaVgr=$landAreaVgr->row();
                    $sumArea=$landAreaVgr->applied + $reserveforVgr->total_lessa;
                    if($sumArea > $total){
                        $this->db->trans_rollback();
                        log_message('error',"#SLVGR500 ErrorInCode Already Applied##" . $landAreaVgr->applied ."##Present Apply:". $reserveforVgr->total_lessa . "##Chitha Total:".$total ."##case".$case);
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLVGR500)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                if($reserveforVgr){
                    /////////////////////
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                        $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$reserveforVgr->bigha. " বিঘা ".$reserveforVgr->katha." কঠা ".$reserveforVgr->lessa." চাটক ". $reserveforVgr->ganda ." গোণ্ডা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ভিজিআৰ/পিজিআৰ ৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }else{
                        $rmk="চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ ".$reserveforVgr->bigha. " বিঘা ".$reserveforVgr->katha." কঠা ".$reserveforVgr->lessa." লেচা মিছন বাসুন্ধৰা-2.0 ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case ." নং ৰ অধীনত ভিজিআৰ/পিজিআৰ ৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }

                    $insert = array(
                        'dist_code' => $reserveforVgr->dist_code,
                        'subdiv_code' => $reserveforVgr->subdiv_code,
                        'cir_code' => $reserveforVgr->cir_code,
                        'mouza_pargona_code' => $reserveforVgr->mouza_pargona_code,
                        'lot_no' => $reserveforVgr->lot_no,
                        'vill_townprt_code' => $reserveforVgr->vill_townprt_code,
                        'patta_no' => $reserveforVgr->patta_no,
                        'patta_type_code' => $reserveforVgr->patta_type_code,
                        'dag_no' => $reserveforVgr->dag_no,
                        'dag_no_int' => $reserveforVgr->dag_no.'00',
                        'remark' => addslashes($rmk),
                        'category' => 2,
                        'date_entry' => date('Y-m-d'),
                        'user_code' => $user_code,
                    );
                    $this->db->insert('backlog_orders', $insert);
                    if($this->db->affected_rows()!=1){
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode" . $this->db->db_debug);
                        log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                        redirect(base_url() . "index.php/home");
                    }
                    /////////////////////
                    unset($insert['dag_no_int']);
                    $insert['bigha']=$reserveforVgr->bigha;
                    $insert['katha']=$reserveforVgr->katha;
                    $insert['lessa']=$reserveforVgr->lessa;
                    $insert['ganda']=$reserveforVgr->ganda;
                    $insert['case_no']=$main['case_no'];
                    $this->db->insert('chitha_reservation_vgr', $insert);
                    if($this->db->affected_rows()!=1){
                        $this->db->trans_rollback();
                        log_message('error',"ErrorInCode(#SLDVGR00499)". $this->db->last_query());
                        $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLDVGR00499)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ////////////////End for VGR //////////////////
            $updateSettlement=array(
                'status'=>'F',
                'from_office'=>'CO',
                'pending_officer'=>null,
                'co_chitha_corrected_yn'=>'y',
                'co_chitha_corrected_date'=>date('Y-m-d H:i:s')
            );
            $this->db->where('case_no',$case);
            $this->db->update('settlement_basic',$updateSettlement);
            if($this->db->affected_rows()<=0){
                log_message('error',"Error Code(#SLPCDP007)".$this->db->last_query());
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }

            //Update into settlement_premium table dharitree
            $insertSettlementPremiumArr = [
                'total_premium' => $this->input->post('total_premium'),
                'paid_amount' => $this->input->post('paid_amount'),
                'remaining_amount' => $this->input->post('remaining_amount')==null?'0':$this->input->post('remaining_amount'),
                'tenure' => $this->input->post('tenure')==null?'0':$this->input->post('tenure'),
                'installment_amount' => $this->input->post('installment_amount')==null?'0':$this->input->post('installment_amount'),
                'installment_amount' => $this->input->post('installment_amount')==null?'0':$this->input->post('installment_amount'),
                'payment_date' => $this->input->post('payment_date')==null?'0':$this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_premium', $insertSettlementPremiumArr);
            ////////////////////////////////////////////
            if ($this->db->affected_rows() == 0) {
                log_message('error',"Error Code(#SLPCDP444007)".$this->db->last_query());
                //log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }
            /////////////Notice Date update///////////////
            $insertSettlementnotice = [

                'paid_amount' => $this->input->post('paid_amount'),
                'payment_completed_date' => $this->input->post('payment_date')==null?'0':$this->input->post('payment_date'),
            ];
            $this->db->where('case_no', $this->input->post('case_no'));
            $this->db->update('settlement_notice', $insertSettlementnotice);
            ////////////////////////////////////////////
            if ($this->db->affected_rows() == 0) {
                log_message('error',"Error Code(#SLPCDP444009)".$this->db->last_query());
                //log_message('error',"ErrorInCode" . $this->db->db_debug);
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Final Updation');
                redirect(base_url() . 'index.php/home');
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
                redirect(base_url() . 'index.php/home');
            } else {
                //////////////POST To basundhara/////////////////////
                $rmk='Chitha Updated';
                $status='F';
                $task='CO';
                $pen='NA';
                //////////////Generate PATTA-ORDER COPY///////////////////
                if($this->input->post('total_premium')==$this->input->post('paid_amount')){
                    $return =1;
                }else{
                    $return =2;
                }
                ////////////////////////////////
                $this->db->trans_commit();

                return $return;
                // $rtps_status=$this->basundharamodel->postApiBasundhara($main['applid'],$case,$rmk,$status,$task,$pen);
                // $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                // if($rtps_status===false || $rtps_status===0){
                //     $this->db->trans_rollback();
                //     $this->session->set_flashdata('message', "Error #ERRAPP0011: Unable to update chitha, case no # $case_no");
                //     redirect(base_url() . "index.php/home");
                // }else{
                //     $this->db->trans_commit();
                //     return true;
                // }
            }
        }////end of try
        catch (error $e) {
            //echo $e;
            //var_dump($this->db->db_debug);
            log_message('error',$this->db->db_debug);
        }
    }
    function MaxpdarIdCheck($case_no,$postData){
        $i=0;
        $newPostedDag1="'";
        //var_dump($postData);
        foreach($postData as $newPostedDags){
            if ($i <count($postData)-1)
                $newPostedDag1 = $newPostedDag1 .$newPostedDags."','" ;
            else
                $newPostedDag1 = $newPostedDag1 .$newPostedDags."'" ;
            $i++;
        }
        //var_dump(expression)
        // die;
        $sql1="Select * from settlement_dag_details where case_no=? ";
        $main=$this->db->query($sql1,array($case_no))->row_array();
        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
                dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->cp;
        ///echo $this->db->last_query();
        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and 
                    TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->jp;
        //echo $this->db->last_query();
        $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
                    dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no in  ($newPostedDag1)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$_POST['new_patta_type'],$_POST['new_patta']))->row()->dp;
        //echo $this->db->last_query();
        if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
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
        if($pdar_id== null){
            $pdar_id=1;
        }

        return $pdar_id;
    }
    function MaxpdarIdCheckDagWise($case_no){
        $i=0;
        $sql1="Select * from settlement_dag_details where case_no=? ";
        $main=$this->db->query($sql1,array($case_no))->row_array();
        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$main['patta_type_code'],$main['patta_no']))->row()->cp;
        ///echo $this->db->last_query();
        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and 
            TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$main['patta_type_code'],$main['patta_no']))->row()->jp;
        //echo $this->db->last_query();
        $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no =? ",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$main['patta_type_code'],$main['patta_no'],$main['dag_no']))->row()->dp;
        if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
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
        if($pdar_id== null){
            $pdar_id=1;
        }
        return $pdar_id;
    }
    function MaxpdarIdCheckSelectDagWise($case_no,$dag,$pp,$pno){
        $i=0;
        $sql1="Select * from settlement_dag_details where case_no=? ";
        $main=$this->db->query($sql1,array($case_no))->row_array();
        $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
        dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$pp,$pno))->row()->cp;
        ///echo $this->db->last_query();
        $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and 
            TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$pp,$pno))->row()->jp;
        //echo $this->db->last_query();
        $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no =? ",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$pp,$pno,$dag))->row()->dp;
        if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
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
        if($pdar_id== null){
            $pdar_id=1;
        }
        return $pdar_id;
    }

    public function getPaymentNoticeCo($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_REQUEST);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    function checkRtpsService($case){
        $sql="SELECT basundhara FROM basundhar_application WHERE basundhara=? and (basundhara is not null or basundhara='') ";
        $dataFound=$this->db->query($sql, $case)->row();
        if($dataFound){
            $data = $dataFound->basundhara;
            $var = explode('/', $data);
            $service = $var['0'];
        }else{
            $service = null;
        }
        return $service;
    }
    function paymentRequest($basundhara,$amount){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."payqueryRequest");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $basundhara,
            'query' =>  "Please make payment",
            'payment_amount'=>$amount,
            'type' => '1',
            'query_from_officer'=>$this->session->userdata('user_code'),
            'query_from_office'=>'CO Office'
        )));

        // return curl_exec($curl_handle);
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return 'n';
        }
        return $result;
    }
    function paymentConfirmation($basundhara){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."paymentStatus");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $basundhara,
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
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

    public function getLmVerificationCases($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('chitha_processing_details', 1);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    public function getPaymentConfirmationDc($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_NOTICE);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        // $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        // $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    public function getPaymentReceivedApplicant($service_code)
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->where('status', MB_PAYMENT_RECEIVED);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        // $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        // $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }


    // get all settlement reservation
    public function getSettlementReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted != 1')
            ->get('settlement_reservation');
        return $lmnotes->result();
    }
    // function updateChithaNR($case_no){
    //     $user_code=$this->session->userdata('user_code');
    //     $sql="Select * from settlement_basic where case_no=? and pending_officer=? and status=? ";
    //     $data=$this->db->query($sql,array($case_no,'DC','G'));
    //     if($data->num_rows()==1){
    //         $caseData=$data->row();
    //         $newDag=$this->utilityclass->maxdag($caseData->dist_code,$caseData->subdiv_code,$caseData->cir_code,$caseData->mouza_pargona_code,$caseData->lot_no,$caseData->vill_townprt_code
    //         );
    //         $sql="Select * from settlement_dag_details where case_no=?";
    //         $dagDetails=$this->db->query($sql,array($case_no))->row_array();
    //         /////////////////////////
    //         $cb = array(
    //             'dist_code' => $dagDetails['dist_code'],
    //             'subdiv_code' => $dagDetails['subdiv_code'],
    //             'cir_code' => $dagDetails['cir_code'],
    //             'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
    //             'lot_no' => $dagDetails['lot_no'],
    //             'vill_townprt_code' => $dagDetails['vill_townprt_code'],
    //             'dag_no' => $newDag,
    //             'dag_no_int' => $newDag . '00',
    //             'old_dag_no' => $dagDetails['dag_no'],
    //             'patta_type_code' => '0209',
    //             'patta_no' => '0',
    //             'dag_area_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
    //             'dag_area_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
    //             'dag_area_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
    //             'dag_area_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
    //             'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
    //             'dag_area_are' => 0,
    //             'land_class_code' => $dagDetails['new_land_class_code'],
    //             'dag_revenue' => 0,
    //             'dag_local_tax' => 0,
    //             'user_code' => $user_code,
    //             'date_entry' => date('Y-m-d'),
    //             'operation' => 'E',
    //             'jama_yn' => null,
    //         );
    //         $tstatusChitha=$this->db->insert('chitha_basic',$cb);
    //         if($this->db->affected_rows()!=1){
    //             log_message('error',"ErrorInCode(#SAPNR00012)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //             // $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00012)");
    //             //    redirect(base_url() . "index.php/home");
    //         }
    //         //////////Substract Area/////////////
    //         $cb="select  CASE
    //                         WHEN dist_code ='21' THEN (dag_area_b*6400 + dag_area_k*320 + dag_area_lc *20 +dag_area_g )
    //                         when dist_code !='21' then (dag_area_b*100 + dag_area_k*20 + dag_area_lc  )
    //                       END 
    //                       AS total_lessa,* from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //         $landAreacb = $this->db->query($cb,array($dagDetails['dist_code'],$dagDetails['subdiv_code'],$dagDetails['cir_code'],$dagDetails['mouza_pargona_code'],$dagDetails['lot_no'],$dagDetails['vill_townprt_code'],$dagDetails['dag_no']));
    //         if($landAreacb->num_rows()>0){
    //             $landAreacb=$landAreacb->row();
    //         }
    //         $total=$landAreacb->total_lessa;
    //         //$total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);
    //         if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
    //             $converArea=$this->utilityclass->Total_ganda($this->utilityclass->assToeng($dagDetails['s_dag_area_b']),$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),$this->utilityclass->assToeng($dagDetails['s_dag_area_g']));
    //             $remanLanArea=$total-$converArea;
    //             $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa2($remanLanArea);
    //         }else{
    //             $converArea=$this->utilityclass->Total_Lessa($this->utilityclass->assToeng($dagDetails['s_dag_area_b']),$this->utilityclass->assToeng($dagDetails['s_dag_area_k']),$this->utilityclass->assToeng($dagDetails['s_dag_area_lc']));
    //             $remanLanArea=$total-$converArea;
    //             $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
    //         }
    //         /////////////////////
    //         $bigha=$remanLanArea[0];
    //         $katha=$remanLanArea[1];
    //         $lessa=$remanLanArea[2];
    //         $ganda=$remanLanArea[3];
    //         $cbArray=array(
    //             'dag_area_b' => $bigha,
    //             'dag_area_k' => $katha,
    //             'dag_area_lc' => $lessa,
    //             'dag_area_g' => $ganda,
    //             'user_code' => $user_code,
    //             'date_entry' => date('Y-m-d'),
    //             'jama_yn'=>null
    //         );
    //         $this->db->where('dist_code', $dagDetails['dist_code']);
    //         $this->db->where('subdiv_code', $dagDetails['subdiv_code']);
    //         $this->db->where('cir_code', $dagDetails['cir_code']);
    //         $this->db->where('mouza_pargona_code' ,$dagDetails['mouza_pargona_code']);
    //         $this->db->where('lot_no', $dagDetails['lot_no']);
    //         $this->db->where('vill_townprt_code', $dagDetails['vill_townprt_code']);
    //         $this->db->where('dag_no', $dagDetails['dag_no']);
    //         $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
    //         if($this->db->affected_rows()!=1){
    //             log_message('error',"ErrorInCode(#SAPNR00011)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //             $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00011)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //         $c_d_p = array(
    //             'dist_code' => $dagDetails['dist_code'],
    //             'subdiv_code' => $dagDetails['subdiv_code'],
    //             'cir_code' => $dagDetails['cir_code'],
    //             'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
    //             'lot_no' => $dagDetails['lot_no'],
    //             'vill_townprt_code' => $dagDetails['vill_townprt_code'],
    //             'dag_no' => $newDag,
    //             'patta_type_code' => '0209',
    //             'patta_no' => '0',
    //             'pdar_id' =>1,
    //             'dag_por_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
    //             'dag_por_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
    //             'dag_por_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
    //             'dag_por_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
    //             'dag_por_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
    //             'user_code' => $user_code,
    //             'date_entry' => date('Y-m-d'),
    //             'operation' => 'E',
    //             'p_flag' => '0',
    //             'jama_yn' => 'N',
    //         );
    //         $tstatus2=$this->db->insert('chitha_dag_pattadar', $c_d_p);
    //         if($tstatus2 != 1)
    //         {
    //             log_message('error',"ErrorInCode(#SLPCB00222)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //         }
    //         //////////////////////////
    //         if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
    //             $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ".$dagDetails['s_dag_area_b']. " বিঘা ".$dagDetails['s_dag_area_k']." কঠা ".$dagDetails['s_dag_area_lc']." চাটক ". $dagDetails['s_dag_area_g'] ." গোণ্ডা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
    //         }else{
    //             $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ".$dagDetails['s_dag_area_b']. " বিঘা ".$dagDetails['s_dag_area_k']." কঠা ".$dagDetails['s_dag_area_lc']." লেচা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
    //         }
    //         $insert = array(
    //             'dist_code' => $dagDetails['dist_code'],
    //             'subdiv_code' => $dagDetails['subdiv_code'],
    //             'cir_code' => $dagDetails['cir_code'],
    //             'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
    //             'lot_no' => $dagDetails['lot_no'],
    //             'vill_townprt_code' => $dagDetails['vill_townprt_code'],
    //             'patta_no' => $dagDetails['patta_no'],
    //             'patta_type_code' => $dagDetails['patta_type_code'],
    //             'dag_no' => $dagDetails['dag_no'],
    //             'dag_no_int' => $dagDetails['dag_no'].'00',
    //             'remark' => addslashes($rmk),
    //             'category' => 2,
    //             'date_entry' => date('Y-m-d'),
    //             'user_code' => $user_code,
    //         );
    //         $this->db->insert('backlog_orders', $insert);
    //         if($this->db->affected_rows()!=1){
    //             log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //             $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //         //////////Old Status Change///////////
    //         $updateStatus=array(
    //             'nr_update_yn'=>'Y',
    //             'status'=>'Y',
    //             'pending_officer'=>'CO',
    //             'from_office'=>'DC',
    //         );
    //         $this->db->where('case_no',$case_no);
    //         $this->db->update('settlement_basic',$updateStatus);
    //         if($this->db->affected_rows()!=1){
    //             log_message('error',"ErrorInCode(#SAPNR00499)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //             $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00499)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //         $updateStatus=array(
    //             'new_dag_no'=>$newDag,
    //         );
    //         $this->db->where('case_no',$case_no);
    //         $this->db->update('settlement_dag_details',$updateStatus);
    //         if($this->db->affected_rows()!=1){
    //             log_message('error',"ErrorInCode(#SAPNR00500)". $this->db->last_query());
    //             $this->db->trans_rollback();
    //             return false;
    //             $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00500)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //         return true;
    //         /////////////////////
    //     }else{
    //         return false;
    //     }
    // }


    function updateChithaNR($case_no){
        $user_code=$this->session->userdata('user_code');
        $sql="Select * from settlement_basic where case_no=? and pending_officer=? and status=? ";
        $data=$this->db->query($sql,array($case_no,'DC','G'));
        if($data->num_rows()==1){
            $caseData=$data->row();

            ////////////////////////////////
             ////////////////////////
            $sql="Select * from settlement_dag_details where case_no=?";
            $dagDetailsCheck=$this->db->query($sql,array($case_no))->row_array();
            // if($dagDetailsCheck['dag_no']){
            //     //////////////Check for all village data for completed or not with same dag/////////////////
            //     $sql="Select * from settlement_dag_details where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
            //     and lot_no=? and vill_townprt_code=? and dag_no=? and case_no=? and new_dag_no is not null";
            //     $dagDetailsValidate=$this->db->query($sql,array($dagDetailsCheck['dist_code'],$dagDetailsCheck['subdiv_code'],$dagDetailsCheck['cir_code'],$dagDetailsCheck['mouza_pargona_code'],$dagDetailsCheck['lot_no'],$dagDetailsCheck['vill_townprt_code'],$dagDetailsCheck['dag_no'],$case_no));
            //     if($dagDetailsValidate->num_rows()>0){
            //         log_message('error',"ErrorInCode" . $this->db->db_debug);
            //         log_message('error',"ErrorInCode(#SLPCB00799)". $this->db->last_query());
            //         $this->session->set_flashdata('message', "NR has been already Completed. Error Code(#SLPCB00799)");
            //         // redirect(base_url() . "index.php/home");
                   
            //         return false;
            //     }
            // }
            ////////////////////////
            //////////////applied area////////////////////

            $sql="Select CASE
                            WHEN dist_code ='21' THEN (s_dag_area_b*6400 + s_dag_area_k*320 + s_dag_area_lc *20 +s_dag_area_g )
                            when dist_code !='21' then (s_dag_area_b*100 + s_dag_area_k*20 + s_dag_area_lc  )
                          END 
                          AS applied_lessa,* from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql,array($case_no))->row_array();
            $totalAppliedLand=$dagDetails['applied_lessa'];          
            //////////Total main Substract Area/////////////
            $cb="select  CASE
                            WHEN dist_code ='21' THEN (dag_area_b*6400 + dag_area_k*320 + dag_area_lc *20 +dag_area_g )
                            when dist_code !='21' then (dag_area_b*100 + dag_area_k*20 + dag_area_lc  )
                          END 
                          AS total_lessa,* from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
            $landAreacb = $this->db->query($cb,array($dagDetails['dist_code'],$dagDetails['subdiv_code'],$dagDetails['cir_code'],$dagDetails['mouza_pargona_code'],$dagDetails['lot_no'],$dagDetails['vill_townprt_code'],$dagDetails['dag_no']));
            if($landAreacb->num_rows()>0){
                $landAreacb=$landAreacb->row();
            }
            $chithatotal=$landAreacb->total_lessa;
            /////////////////////
            //////////Substract From Original Dag Land area ////////////
            // $reserveAreaRoad=0;
            // $roadside="Select CASE
            //                 WHEN dist_code ='21' THEN (bigha*6400 + katha*320 + lessa *20 +ganda )
            //                 when dist_code !='21' then (bigha*100 + katha*20 + lessa  )
            //               END 
            //               AS total_lessa, bigha,katha,lessa,ganda from settlement_reservation where case_no=? and dag_no=? and type='R' group by dag_no,dist_code,bigha,katha,lessa,ganda ";
            // $roadSideQuery=$this->db->query($roadside,array($case_no,$dagDetails['dag_no']));
            // //echo $this->db->last_query();
            // if($roadSideQuery->num_rows()>0){
            //     $reserveAreaRoad=$roadSideQuery->row()->total_lessa;
            // }
            // if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            //     $applied=$dagDetails['s_dag_area_b']*6400+$dagDetails['s_dag_area_k']*320+$dagDetails['s_dag_area_lc']*20+$dagDetails['s_dag_area_g'];
            // }else{
            //     $applied=$dagDetails['s_dag_area_b']*100+$dagDetails['s_dag_area_k']*20+$dagDetails['s_dag_area_lc'];
            // }
            // if($areaSubstract<=0)
            //     return false;
            //////////////old chitha area////////////////////
            // echo "****************";
            // var_dump($totalAppliedLand);
            // echo "****************";
            // var_dump($reserveAreaRoad);
            // echo "****************";
            // var_dump($chithatotal);
            // echo "****************";  
            ////////////////////////////
            if(($chithatotal > $totalAppliedLand)){
                $final=$chithatotal-($totalAppliedLand);
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa2($final);
                    $newareaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa2($totalAppliedLand);
                }else{
                    $areaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa($final);
                    $newareaSubstract=$this->utilityclass->Total_Bigha_Katha_Lessa($totalAppliedLand);
                }
                if($areaSubstract<0)
                    return false;
                ///////////Old Area//////////////
                $bigha_substract=$areaSubstract[0];
                $katha_substract=$areaSubstract[1];
                $lessa_substract=$areaSubstract[2];
                $ganda_substract=$areaSubstract[3];
                /////////////New Area///////////////////
                $new_bigha_substract=$newareaSubstract[0];
                $new_katha_substract=$newareaSubstract[1];
                $new_lessa_substract=$newareaSubstract[2];
                $new_ganda_substract=$newareaSubstract[3];
                ///////////Create new Dag//////////////
                $newDag=$this->utilityclass->maxdag($caseData->dist_code,$caseData->subdiv_code,$caseData->cir_code,$caseData->mouza_pargona_code,$caseData->lot_no,$caseData->vill_townprt_code
                );
                //////////////New chitha area///////////////////////
                ////////////Insert if area is partial/////////////////////////////////////////
                $cb = array(
                    'dist_code' => $dagDetails['dist_code'],
                    'subdiv_code' => $dagDetails['subdiv_code'],
                    'cir_code' => $dagDetails['cir_code'],
                    'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
                    'lot_no' => $dagDetails['lot_no'],
                    'vill_townprt_code' => $dagDetails['vill_townprt_code'],
                    'dag_no' => $newDag,
                    'dag_no_int' => $newDag . '00',
                    'old_dag_no' => $dagDetails['dag_no'],
                    'patta_type_code' => '0209',
                    'patta_no' => '0',
                    'dag_area_b' => $this->utilityclass->assToeng($new_bigha_substract),
                    'dag_area_k' => $this->utilityclass->assToeng($new_katha_substract),
                    'dag_area_lc' => $this->utilityclass->assToeng($new_lessa_substract),
                    'dag_area_g' => $this->utilityclass->assToeng($new_ganda_substract),
                    'dag_area_kr' => 0,
                    'dag_area_are' => 0,
                    'land_class_code' => $dagDetails['new_land_class_code'],
                    'dag_revenue' => 0,
                    'dag_local_tax' => 0,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'jama_yn' => null,
                );
                // $tstatusChitha=$this->db->insert('chitha_basic',$cb);
                $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$cb);
                if($this->db->affected_rows()!=1){
                    log_message('error',"ErrorInCode(#SAPNR00012)". $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                    // $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00012)");
                    //    redirect(base_url() . "index.php/home");
                }
                ///////////////////////////////
                //   $cbArray=array(
                //       'dag_area_b'=>$bigha_substract,
                //       'dag_area_k'=>$katha_substract,
                //       'dag_area_lc'=>$lessa_substract,
                //       'dag_area_g'=>$ganda_substract,
                //       'user_code' => $user_code,
                //       'date_entry' => date('Y-m-d'),
                //       'jama_yn'=>null
                //   );
                //   $this->db->where('dist_code', $dagDetails['dist_code']);
                //   $this->db->where('subdiv_code', $dagDetails['subdiv_code']);
                //   $this->db->where('cir_code', $dagDetails['cir_code']);
                //   $this->db->where('mouza_pargona_code' ,$dagDetails['mouza_pargona_code']);
                //   $this->db->where('lot_no', $dagDetails['lot_no']);
                //   $this->db->where('vill_townprt_code', $dagDetails['vill_townprt_code']);
                //   $this->db->where('dag_no', $dagDetails['dag_no']);
                //   $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
                $table = 'chitha_basic';

                $params = [
                    'dag_area_b'   => $bigha_substract,
                    'dag_area_k'   => $katha_substract,
                    'dag_area_lc'  => $lessa_substract,
                    'dag_area_g'   => $ganda_substract,
                    'user_code'    => $user_code,
                    'date_entry'   => date('Y-m-d'),
                    'jama_yn'      => null,
                ];

                $where = [
                    'dist_code'           => $dagDetails['dist_code'],
                    'subdiv_code'         => $dagDetails['subdiv_code'],
                    'cir_code'            => $dagDetails['cir_code'],
                    'mouza_pargona_code'  => $dagDetails['mouza_pargona_code'],
                    'lot_no'              => $dagDetails['lot_no'],
                    'vill_townprt_code'   => $dagDetails['vill_townprt_code'],
                    'dag_no'              => $dagDetails['dag_no'],
                ];

                $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

                  if($tstatusChithaOld!=1){
                      log_message('error',"ErrorInCode(#SAPNR00011)". $this->db->last_query());
                      $this->db->trans_rollback();
                      return false;
                      $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00011)");
                      redirect(base_url() . "index.php/home");
                  }
                ////////////////////////////
                $c_d_p = array(
                    'dist_code' => $dagDetails['dist_code'],
                    'subdiv_code' => $dagDetails['subdiv_code'],
                    'cir_code' => $dagDetails['cir_code'],
                    'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
                    'lot_no' => $dagDetails['lot_no'],
                    'vill_townprt_code' => $dagDetails['vill_townprt_code'],
                    'dag_no' => $newDag,
                    'patta_type_code' => '0209',
                    'patta_no' => '0',
                    'pdar_id' =>1,
                    'dag_por_b' => $this->utilityclass->assToeng($new_bigha_substract),
                    'dag_por_k' => $this->utilityclass->assToeng($new_katha_substract),
                    'dag_por_lc' => $this->utilityclass->assToeng($new_lessa_substract),
                    'dag_por_g' => $this->utilityclass->assToeng($new_ganda_substract),
                    'dag_por_kr' => 0,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                );
                // $tstatus2=$this->db->insert('chitha_dag_pattadar', $c_d_p);
                $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$c_d_p);
                if($tstatus2 != 1)
                {
                    log_message('error',"ErrorInCode(#SLPCB00222)". $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                ///////////////////////////
                $sql="Select * from settlement_applicant where case_no=? and pdar_type=? ";
                $applicant=$this->db->query($sql,array($case_no,'O'));
                if($applicant->num_rows()==0)
                    return false;
                $ownerpattadar=$applicant->result_array();
                // log_message('error',"Error Code(#SLPCDP006)".json_encode($ownerpattadar));
                foreach($ownerpattadar as $slp){
                        // $updateOldPattadar=array(
                        //     'user_code' => $user_code,
                        //     'date_entry' => date('Y-m-d'),
                        //     'operation' => 'E',
                        //     'p_flag' => ($slp['inplace_alongwith'] == 'i' ) ? 1 : (( $slp['inplace_alongwith'] == 'a' ) ? 0 : 0),
                        // );
                        // $this->db->where('dist_code', $slp['dist_code']);
                        // $this->db->where('subdiv_code', $slp['subdiv_code']);
                        // $this->db->where('cir_code', $slp['cir_code']);
                        // $this->db->where('mouza_pargona_code' ,$slp['mouza_pargona_code']);
                        // $this->db->where('lot_no', $slp['lot_no']);
                        // $this->db->where('vill_townprt_code', $slp['vill_townprt_code']);
                        // $this->db->where('dag_no', $dagDetails['dag_no']);
                        // $this->db->where('patta_no', $dagDetails['patta_no']);
                        // $this->db->where('patta_type_code', $dagDetails['patta_type_code']);
                        // $this->db->where('pdar_id', $slp['pdar_id']);
                        // $tstatusCdP = $this->db->update('chitha_dag_pattadar',$updateOldPattadar);
                        // log_message('error',"Error Code(#SLPCDP006)".$this->db->last_query());
                        // echo $this->db->last_query();
                        $table = 'chitha_dag_pattadar';

                        $params = [
                            'user_code'  => $user_code,
                            'date_entry' => date('Y-m-d'),
                            'operation'  => 'E',
                            'p_flag'     => ($slp['inplace_alongwith'] == 'i') ? 1 : 0,
                        ];

                        $where = [
                            'dist_code'         => $slp['dist_code'],
                            'subdiv_code'       => $slp['subdiv_code'],
                            'cir_code'          => $slp['cir_code'],
                            'mouza_pargona_code'=> $slp['mouza_pargona_code'],
                            'lot_no'            => $slp['lot_no'],
                            'vill_townprt_code' => $slp['vill_townprt_code'],
                            'dag_no'            => $dagDetails['dag_no'],
                            'patta_no'          => $dagDetails['patta_no'],
                            'patta_type_code'   => $dagDetails['patta_type_code'],
                            'pdar_id'           => $slp['pdar_id'],
                        ];

                        // Call the model's update function
                        $tstatusCdP = $this->Chitha_basic_model->update_table($table, $params, $where);

                        if($tstatusCdP != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error',"ErrorInCode" . $this->db->db_debug);
                            log_message('error',"Error Code(#SLPCDP006)".$this->db->last_query());
                            return false;
                            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCDP006)");
                            redirect(base_url() . "index.php/home");
                        }
                }
                //////////Road side riverside Reserve Land a note aganist the order//////////////
            }
            if($chithatotal == $totalAppliedLand){
              // $bigha=$remanLanArea[0];
              // $katha=$remanLanArea[1];
              // $lessa=$remanLanArea[2];
              // $ganda=$remanLanArea[3];
              $new_bigha_substract=$dagDetails['s_dag_area_b'];
              $new_katha_substract=$dagDetails['s_dag_area_k'];
              $new_lessa_substract=$dagDetails['s_dag_area_lc'];
              $new_ganda_substract=$dagDetails['s_dag_area_g'];
              $newDag=$dagDetails['dag_no'];
            //   $cbArray=array(
            //       'patta_type_code'=>'0209',
            //       'patta_no'=>'0',
            //       'user_code' => $user_code,
            //       'date_entry' => date('Y-m-d'),
            //       'jama_yn'=>null
            //   );
            //   $this->db->where('dist_code', $dagDetails['dist_code']);
            //   $this->db->where('subdiv_code', $dagDetails['subdiv_code']);
            //   $this->db->where('cir_code', $dagDetails['cir_code']);
            //   $this->db->where('mouza_pargona_code' ,$dagDetails['mouza_pargona_code']);
            //   $this->db->where('lot_no', $dagDetails['lot_no']);
            //   $this->db->where('vill_townprt_code', $dagDetails['vill_townprt_code']);
            //   $this->db->where('dag_no', $dagDetails['dag_no']);
            //   $tstatusChithaOld= $this->db->update('chitha_basic', $cbArray);
            $table = 'chitha_basic';

            $params = [
                'patta_type_code' => '0209',
                'patta_no'        => '0',
                'user_code'       => $user_code,
                'date_entry'      => date('Y-m-d'),
                'jama_yn'         => null,
            ];

            $where = [
                'dist_code'           => $dagDetails['dist_code'],
                'subdiv_code'         => $dagDetails['subdiv_code'],
                'cir_code'            => $dagDetails['cir_code'],
                'mouza_pargona_code'  => $dagDetails['mouza_pargona_code'],
                'lot_no'              => $dagDetails['lot_no'],
                'vill_townprt_code'   => $dagDetails['vill_townprt_code'],
                'dag_no'              => $dagDetails['dag_no'],
            ];

            $tstatusChithaOld = $this->Chitha_basic_model->update_table($table, $params, $where);

              // echo $this->db->last_query();
              if($this->db->affected_rows()!=1){
                  log_message('error',"ErrorInCode(#SAPNR00011)". $this->db->last_query());
                  $this->db->trans_rollback();
                  return false;
                  $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00011)");
                  redirect(base_url() . "index.php/home");
              }
            }
            //////////////////////////

            //////////////////////////
            if($chithatotal > $totalAppliedLand){
                $msg="ৰ অংশ নতুন দাগ ". $newDag ." ত ";
            }else{
                $msg=null;
            }
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ". $msg .$new_bigha_substract. " বিঘা ".$new_katha_substract." কঠা ".$new_lessa_substract." চাটক ". $new_ganda_substract ." গোণ্ডা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
            }else{
                $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ".$msg . $new_bigha_substract. " বিঘা ".$new_katha_substract." কঠা ".$new_lessa_substract." লেচা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
            }
            $insert = array(
                'dist_code' => $dagDetails['dist_code'],
                'subdiv_code' => $dagDetails['subdiv_code'],
                'cir_code' => $dagDetails['cir_code'],
                'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
                'lot_no' => $dagDetails['lot_no'],
                'vill_townprt_code' => $dagDetails['vill_townprt_code'],
                'patta_no' => '0',
                'patta_type_code' => '0209',
                'dag_no' => $newDag,
                'dag_no_int' => $newDag.'00',
                'remark' => addslashes($rmk),
                'category' => 2,
                'date_entry' => date('Y-m-d'),
                'user_code' => $user_code,
            );
            $this->db->insert('backlog_orders', $insert);
            // log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
            if($this->db->affected_rows()!=1){
                log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
                $this->db->trans_rollback();
                return false;
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                redirect(base_url() . "index.php/home");
            }
            
            if($newDag != $dagDetails['dag_no']){
                // log_message('error','sdcfvgb'.json_encode($dagDetails));
                $insert['patta_no']=$dagDetails['patta_no'];
                $insert['patta_type_code']=$dagDetails['patta_type_code'];
                $insert['dag_no']=$dagDetails['dag_no'];
                $insert['dag_no_int']=$dagDetails['dag_no'].'00';
                $this->db->insert('backlog_orders', $insert);
                if($this->db->affected_rows()!=1){
                    log_message('error',"ErrorInCode(#SLPCB00500)". $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                    $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00499)");
                    redirect(base_url() . "index.php/home");
                }
            }
            //////////Old Status Change///////////
            $updateStatus=array(
                'nr_update_yn'=>'Y',
                'status'=>'Y',
                'pending_officer'=>'CO',
                'from_office'=>'DC',
            );
            $this->db->where('case_no',$case_no);
            $this->db->update('settlement_basic',$updateStatus);
            if($this->db->affected_rows()!=1){
                log_message('error',"ErrorInCode(#SAPNR00499)". $this->db->last_query());
                $this->db->trans_rollback();
                return false;
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00499)");
                redirect(base_url() . "index.php/home");
            }
            $updateStatus=array(
                'new_dag_no'=>$newDag,
            );
            $this->db->where('case_no',$case_no);
            $this->db->update('settlement_dag_details',$updateStatus);
            if($this->db->affected_rows()!=1){
                log_message('error',"ErrorInCode(#SAPNR00500)". $this->db->last_query());
                $this->db->trans_rollback();
                return false;
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SAPNR00500)");
                redirect(base_url() . "index.php/home");
            }
            return true;
            /////////////////////
        }else{
            return false;
        }
    }
    function dagNoCreate($case_no,$dagno){
            $sql="Select * from settlement_dag_details where case_no=?";
            $dagDetails=$this->db->query($sql,array($case_no))->row_array();
            ///////////////////
            //////////////////
            $cb = array(
                'dist_code'=>$dagDetails['dist_code'],
                'subdiv_code'=>$dagDetails['subdiv_code'],
                'cir_code'=>$dagDetails['cir_code'],
                'mouza_pargona_code'=>$dagDetails['mouza_pargona_code'],
                'lot_no'=>$dagDetails['lot_no'],
                'vill_townprt_code'=>$dagDetails['vill_townprt_code'],
                'old_dag_no' => $dagDetails['dag_no'],
                'dag_no' => $dagno,
                'dag_no_int' => $dagno . '00',
                'patta_type_code' => '0209',
                'patta_no' => 0,
                'dag_area_b' => $this->utilityclass->assToeng($dagDetails['s_dag_area_b']),
                'dag_area_k' => $this->utilityclass->assToeng($dagDetails['s_dag_area_k']),
                'dag_area_lc' => $this->utilityclass->assToeng($dagDetails['s_dag_area_lc']),
                'dag_area_g' => $this->utilityclass->assToeng($dagDetails['s_dag_area_g']),
                'dag_area_kr' => $this->utilityclass->assToeng($dagDetails['s_dag_area_kr']),
                'dag_area_are' => 0,
                'land_class_code' => $this->landClassCode($dagDetails['dist_code'],$dagDetails['subdiv_code'],$dagDetails['cir_code'],$dagDetails['mouza_pargona_code'],$dagDetails['lot_no'],$dagDetails['vill_townprt_code'],$dagDetails['dag_no']),
                'dag_revenue' => 0,
                'dag_local_tax' => 0,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_yn' => null,
            );
            // $chitha_basic = array_merge($location, $cb);
            // $tstatusChitha=$this->db->insert('chitha_basic',$cb);
            $tstatusChitha=$this->Chitha_basic_model->insert_table('chitha_basic',$cb);
            if($tstatusChitha != 1)
            {
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB00999)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00999)");
                redirect(base_url() . "index.php/home");
            }
            $sqlUpdate="Update settlement_dag_details set new_dag_no='$dagno' where case_no='$case_no' ";
            $this->db->query($sqlUpdate);
            if($this->db->affected_rows()!=1){
                $this->db->trans_rollback();
                log_message('error',"ErrorInCode" . $this->db->db_debug);
                log_message('error',"ErrorInCode(#SLPCB0989)". $this->db->last_query());
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB0989)");
                redirect(base_url() . "index.php/home");
            }
            //////////////////////////
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ". $dagDetails['s_dag_area_b'] . " বিঘা ".$dagDetails['s_dag_area_k']." কঠা ".$dagDetails['s_dag_area_lc']." চাটক ". $dagDetails['s_dag_area_g'] ." গোণ্ডা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
            }else{
                $rmk="মিছন বসুন্ধৰা আঁচনিৰ অধীনত হস্তান্তৰিত একচনা পট্টাভুক্ত ভূমিৰ অনবীকৰণ আৰু পট্টন সেৱাৰ বাবে এই দাগৰ ". $dagDetails['s_dag_area_b'] . " বিঘা ".$dagDetails['s_dag_area_k']." কঠা ".$dagDetails['s_dag_area_lc']." লেচা জমিত অনবীকৰণ গোচৰৰ প্ৰস্তাৱৰ মৰ্মে ".date('d/m/Y')." তাৰিখৰ হুকুম ". $case_no ." নং ৰ অধীনত একচনাৰ পৰা চৰকাৰী কৰা হয়।";
            }
            $insert = array(
                'dist_code' => $dagDetails['dist_code'],
                'subdiv_code' => $dagDetails['subdiv_code'],
                'cir_code' => $dagDetails['cir_code'],
                'mouza_pargona_code' => $dagDetails['mouza_pargona_code'],
                'lot_no' => $dagDetails['lot_no'],
                'vill_townprt_code' => $dagDetails['vill_townprt_code'],
                'patta_no' => $dagDetails['patta_no'],
                'patta_type_code' => $dagDetails['patta_type_code'],
                'dag_no' => $dagDetails['dag_no'],
                'dag_no_int' => $dagDetails['dag_no'].'00',
                'remark' => addslashes($rmk),
                'category' => 2,
                'date_entry' => date('Y-m-d'),
                'user_code' => $user_code,
            );
            $this->db->insert('backlog_orders', $insert);
            // log_message('error',"ErrorInCode(#SLPCB00499)". $this->db->last_query());
            if($this->db->affected_rows()!=1){
                log_message('error',"ErrorInCode(#SLPCB00555)". $this->db->last_query());
                $this->db->trans_rollback();
                return false;
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#SLPCB00555)");
                redirect(base_url() . "index.php/home");
            }
            ///////////////////////////
            return true;
    }
    function landClassCode($d,$s,$c,$m,$l,$v,$dag){
        $sql="Select land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $numRows=$this->db->query($sql,array($d,$s,$c,$m,$l,$v,$dag));
        if($numRows==0){
            log_message('error','LANDCLASSCODE_NOT_FOUND_NEW_DAG_CREATE_SETTLEMENT'.$this->db->last_query());
            return false;
        }
        return $numRows->row()->land_class_code;
    }

    public function getCoRevertedCases()
    {
        // $array = array('service_code' => SETTLEMENT_TENANT_ID, 'pending_officer' => MB_CIRCLE_OFFICER, 'status' => MB_PENDING);
        $this->db->select('*');
        $this->db->from('settlement_basic');
        // $this->db->where('service_code', SETTLEMENT_TENANT_ID);
        $this->db->where('pending_officer', MB_LOT_MONDOL);
        $this->db->where_in('status', 'R');
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

}