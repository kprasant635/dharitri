<?php
class RtpsModel extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		function searchBasundharaLink($case_no){
            $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
             $linkAvail=$this->db->query($sql)->row();
            if($linkAvail){
                $linkAvail=$linkAvail->basundhara;
                if($linkAvail){
                $url = RTPS_API_LINK."uploadfileName?case=" . $linkAvail;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                return $output = json_decode($output); 
                }else {
                    return false;
                }
            }
            
        }
        function checkExistBasundhar($case){
            $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
            $dataFound=$this->db->query($sql)->row();
            //var_dump($dataFound);
            if($dataFound){
                $dataFound=$dataFound->basundhara;
            }else{
                $dataFound=null;
            }
            return $dataFound;
        }


        function checkExistDharitree($case_basu){
            $sql="Select count(*) as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
            $dataFound=$this->db->query($sql)->row();
            //echo json_encode($dataFound);
            if($dataFound->c >0){
                $dataFound=$dataFound->c;
            }else{
                $dataFound=null;
            }
            return $dataFound;
        }
        public function allCORequest($service){
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $ru=$this->session->userdata('user_desig_code');
            $url = RTPS_API_LINK."serviceWiseRecordsCO/$service/$dist_code/$subdiv_code/$cir_code" ;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            $district = json_decode($output);
            return $district;
        }
        //////////////////////
        public function allCORequest1($conditions){
            //var_dump($conditions);
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."serviceWiseRecordsCOPage");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($conditions));
            $data=curl_exec($curl_handle);
            return json_decode($data);
        }
        
        /////////////////////
        function QueryPost($case_no){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."QueryReturn");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $case_no,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
          $data=curl_exec($curl_handle);
          return json_decode($data);
        }
        function SroPost($case_no){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getSroVerification");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $case_no,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
          $data=curl_exec($curl_handle);
          return json_decode($data);
        }

        // function postApiBasundharaSec($case,$rmk,$status,$task,$pen){
        //     $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        //     $linkAvail=$this->db->query($sql)->row()->basundhara;
        //     $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
        // }
        function postApiBasundharaSec($case,$rmk,$status,$task,$pen){
            $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
            $linkAvail=$this->db->query($sql)->num_rows();
            if($linkAvail>0)
            {                
                $linkAvail = $this->db->query($sql)->row()->basundhara;
                $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
            }
        }

        function postApiBasundharaJB($case,$rmk,$status,$task,$pen){
            $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
            $linkAvail=$this->db->query($sql)->num_rows();
            if($linkAvail>0)
            {                
                $linkAvail = $this->db->query($sql)->row()->basundhara;
                return $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
            }
        }


        function payqueryRequest($basundhara,$amount){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."payqueryRequest");
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
                'query_from_office'=>'DC Office',
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
          return curl_exec($curl_handle);
        }
        function paymentConfirmation($basundhara){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."paymentStatus");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
          return curl_exec($curl_handle);
        }
        public function allLmRequest($service){
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $ru=$this->session->userdata('user_desig_code');
            $url = RTPS_API_LINK."serviceWiseRecords/$ru/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no" ;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); // setting 30 seconds
            $output = curl_exec($ch);
            curl_close($ch);
            $district = json_decode($output);
            return $district;
        }
        //////////////////////
        function usersForOffice($d,$s,$c){
            $q = "select * from loginuser_table  where dist_code = ? and subdiv_code=? and  cir_code=? and dis_enb_option=? and priv=? ";
            $users = $this->db->query($q, array($d, $s, $c, 'E', 'adm'))->result();
            foreach ($users as $u) {
                $query_string = "dist_code = ? and subdiv_code=? and"
                        . " cir_code = ? and user_code=? ";
                $mutation[] = $this->db->query("select user_code,username from users where " . $query_string, array($d, $s, $c, $u->user_code))->row_array();
            }
            return $mutation;
        }

        function nameCorrCoValidation($d, $s, $c, $uc){
            $q="SELECT * FROM users WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND user_code=?";
            $result = $this->db->query($q, array($d, $s, $c, $uc))->row_array();
            return $result;
        }

        function postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case,
                'rmk' => $rmk,
                'status' => $status,
                'task' => $task,
                'pen'=>$pen,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $result = curl_exec($curl_handle);
            return $result;
            //echo $result;
        }
        /////////Pallabi///////////
        function RejectOrder(){
            $order=$_POST['order'];
            $application_no=$_POST['application_no'];
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => 'NA',
                'rmk' => $order,
                'status' => 'R',
                'task' => $this->session->userdata('user_desig_code'),
                'pen'=>'NA',
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $result = curl_exec($curl_handle);
            $this->db->trans_commit();
            $this->session->set_flashdata('message',"Basundhara Application Rejected : $application_no ");
            redirect('/home');
    }
        //////////////////////
		//////////////////////
        function generateAllomentcase(){
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code=$this->session->userdata('cir_code');
            $year_no = year_no;
            $q = "Select max(petition_no)+1 as p from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' ";
            $petition_no = $this->db->query($q)->row()->p;
            if ($petition_no == null) {
                $petition_no = $petition_no + 1;
            }
            $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
            $abbrname = $this->db->query($q)->row();
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/ACPP";
            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
            return $return;
        }
        //////////////////
        function genearteOfcCaseNo($type){
            if($type=='03'){
                $mut='OMUT';
            }else if($type=='01'){
                $mut='CONV';
            }else if($type=='04'){
                $mut='OPART';
            }  
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code=$this->session->userdata('cir_code');
            $year_no = year_no;
            $define_date = CHANGE_DATE;
            $petition_no = $this->db->query("select max(petition_no) as count from petition_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row()->count;
            if ($petition_no == null) {
                $petition_no = 1;
            } else {
                $petition_no+=1;
            }
            $petition_no_case = $this->db->query("select count(petition_no)+1 as count from petition_basic where dist_code = '$dist_code' and "
                        . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mut_type='$type'  ")->row()->count;
            if ($petition_no_case == null) {
                $petition_no_case = 1;
            }
            $i = 1;
            $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
            $abbrname = $this->db->query($q)->row();
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $check_status = TRUE;
            while($check_status == TRUE){

                $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/" . $mut;
                $check_existance = $this->db->query("select count(*) as c from petition_basic where case_no='$case_no'")->row()->c;
                if($check_existance<='0'){
                    $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/" . $mut;
                    $check_status = FALSE;
                }
                else{
                    $petition_no_case = $petition_no_case+1;
                }
            }
            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
            return $return;
        }
        ////////////////////////
		function genearteCaseNo($mut){
		$dist_code=$this->session->userdata('dist_code');
		$subdiv_code=$this->session->userdata('subdiv_code');
		$cir_code=$this->session->userdata('cir_code');
		$year_no = year_no;
        $define_date = CHANGE_DATE;
		$q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
        //echo "here";
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $case_no = 0;
        if ($mut == '01') {
            $petition_no_new = $this->db->query("select max(petition_no) as petition_no from field_mut_basic where petition_no is not null and dist_code='$dist_code' and "
                    . "subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row()->petition_no;
            
            $case_append = $this->db->query("select count(petition_no)+1 as petition_no from field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and date(date_entry) >='$define_date' and year_no='$year_no' and mut_type='01'")->row()->petition_no;
            //echo $case_append;
            if ($petition_no_new == null) {
                $petition_no_new = 1;
            } else {
                $petition_no_new += 1;
            }
            if ($case_append == null) {
                $case_append = 1;
            }
            
            $check_status = TRUE;

            while($check_status == TRUE){
                
                $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $case_append . "/" . "FMUT";
                $check_existance = $this->db->query("select count(*) as c from field_mut_basic where case_no='$case_no'")->row()->c;
                if($check_existance<='0'){
                    $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $case_append . "/" . "FMUT";
                    $check_status = FALSE;
                }
                else{
                    $case_append = $case_append+1;
                    //$appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;
                }
            }
            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no_new);
            return $return;
        }else if ($mut == '02') {
            $petition_no_new = $this->db->query("select max(petition_no) as petition_no from field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code'")->row()->petition_no;
            
            $case_append = $this->db->query("select count(petition_no)+1 as petition_no from field_mut_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and date(date_entry) >='$define_date' and year_no='$year_no' and mut_type='02'")->row()->petition_no;
            if ($petition_no_new == null) {
                $petition_no_new = 1;
            } else {
                $petition_no_new += 1;
            }
            if ($case_append == null) {
                $case_append = 1;
            }
            $check_status = TRUE;
            while($check_status == TRUE){
                $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $case_append . "/" . "FPART";
                $check_existance = $this->db->query("select count(*) as c from field_mut_basic where case_no='$case_no'")->row()->c;
                if($check_existance<='0'){
                    $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $case_append . "/" . "FPART";
                    $check_status = FALSE;
                }
                else{
                    $case_append = $case_append+1;
                    //$appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;
                }
            }
            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no_new);
            return $return;
        }

        else if ($mut == '04') {
        
        $petition_no = $this->db->query("select max(proposal_no) as count from t_reclassification where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row()->count;
        if ($petition_no == null) {
                $petition_no = 1;
            } else {
                $petition_no+=1;
            }
        $petition_no_case = $this->db->query("select count(proposal_no) as petition_no from t_reclassification where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                    . "and cir_code = '$cir_code'")->row()->petition_no;
        $petition_no_case = $petition_no_case + 1;
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $case_no = $cir_dist_name."/".$financialyeardate."/".$petition_no_case."/RECLASS";

                
        $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
        return $return;


            }

        else if ($mut == '07') {
        
         $petition_no = $this->db->query("select max(proposal_no) as count from    t_legacyupdation where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                        . "and cir_code = '$cir_code' ")->row()->count;

        if ($petition_no == null) {
            $petition_no = 1;
        } else {
            $petition_no+=1;
        }
        $petition_no_case = $this->db->query("select count(proposal_no) as petition_no from    t_legacyupdation where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                        . "and cir_code = '$cir_code'")->row()->petition_no;
        $petition_no_case = $petition_no_case + 1;
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no_case . "/LDU";

                
        $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
        return $return;


            }


     else if ($mut == '06') {
        
         $petition_no = $this->db->query("select max(misc_case_petition_no)+1 as count from    misc_case_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                            . "and cir_code = '$cir_code' ")->row()->count;


//            echo "select max(misc_case_petition_no) as count from    misc_case_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
//                    . "and cir_code = '$cir_code' and date(submission_date) >='$define_date' and year_no='$year_no'";
            if ($petition_no == null) {
                $petition_no = 1;
            } 
            $petition_no_case = $this->db->query("select count(misc_case_petition_no)+1 as petition_no from misc_case_basic where dist_code = '$dist_code' and "
                            . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and date(submission_date) >='$define_date' "
                            . "and misc_case_type='06'")->row()->petition_no;
        


            if($petition_no_case==null){
                $petition_no_case = 1;
            }
            
            $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/MiNC";

            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
            return $return;


            }


        else if ($mut == '08') {

            $petition_no = $this->db->query("select max(misc_case_petition_no)+1 as count from    misc_case_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ")->row()->count;

            if ($petition_no == null) {
                $petition_no = 1;
            } 
            $petition_no_case = $this->db->query("select count(misc_case_petition_no)+1 as petition_no from    misc_case_basic where dist_code = '$dist_code' and "
                            . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code'
                            and  misc_case_type='07' ")->row()->petition_no;


            if($petition_no_case==null){
                $petition_no_case = 1;
            }
            $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/MiND";

            $return=array('case_no'=>$case_no, 'petition_no'=>$petition_no);
            return $return;
            }
        }


        ///////////Case no using sequence//////////////

        function genearteCaseName(){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        
        
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
            {
                $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
                return $case_no;
            }
            return false;
    
        }


         function genearteOfficePetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_office') as count ")->row()->count;
            return $petition_no;

         }

          function genearteFieldPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_field') as count ")->row()->count;
            return $petition_no;
         }

          function genearteMiscPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_misc') as count ")->row()->count;
            return $petition_no;
         }

          function genearteAlotPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_allotment') as count ")->row()->count;
            return $petition_no;
         }

         function genearteReclassPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_reclass') as count ")->row()->count;
            return $petition_no;
         }

         function genearteLegacyPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_legacy') as count ")->row()->count;
            return $petition_no;
         }

         function genearteCertPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_cert') as count ")->row()->count;
            return $petition_no;
         }

         function genearteApcancelPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_apcancel') as count ")->row()->count;
            return $petition_no;

         }

         function generateNGCorrectionPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_ngcor') as count ")->row()->count;
            return $petition_no;

         }

         //#START PLB
        function genearteTracemapPetitionNo(){
            $petition_no = $this->db->query("select nextval('seq_max_trace') as count ")->row()->count;
            return $petition_no;
        }
         //#END PLB
/////////////////////////////
    function maxProceedingID($case_no){
        $proceeding_id=$this->db->query("Select count(*) as c from petition_proceeding_dc_adc where case_no='$case_no' ");
        if($proceeding_id==false){
            $proceeding_id=1;
        }else{
           $proceeding_id =$proceeding_id->row()->c;
        }
        return $proceeding_id;
    }

 function searchBasundharaLinkApp($case_no){
            $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
            $linkAvail=$this->db->query($sql)->row();
            if($linkAvail){
                $linkAvail=$linkAvail->basundhara;
                if($linkAvail){
                $url = RTPS_API_LINK."serviceResponse?application_no=" . $linkAvail ;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                curl_close($ch);
                // $data['appNo']=$application_no;
                return $output = json_decode($output); 
                }else {
                    return false;
                }
            }
            
    }
    ////////////Insert proceeding///////////////
    function maxFieldProID($case){
        //echo "Select max(proceeding_id)+1 as c from petition_proceeding where case_no='$case' ";
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from petition_proceeding where case_no='$case' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }
        return $proceeding_id;
    }
    function insertproceeding($case,$pro){
        $user_code=$this->session->userdata('user_code');
        $prID=$this->maxFieldProID($case);
        $params=array(
            'case_no' => $case,
            'proceeding_id'=>$prID,
            'co_order'=>$pro,
            'user_code'=>$user_code,
            'date_entry'=>date('Y-m-d'),
            'operation'=>'E',
            'dist_code'=>$this->session->userdata('dist_code'),
            'subdiv_code'=>$this->session->userdata('subdiv_code'),
            'cir_code'=>$this->session->userdata('cir_code'),
             );
        //var_dump($params);
        $this->db->insert('petition_proceeding',$params);
    }
    /////////18-12-21/////////////////
    function adcRejectList(){
            $curl_handle = curl_init();
            //echo RTPS_API_LINK;
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."rest/getrejectapp");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'dist_code' => 14,
                'service_code'=>1,
                'required_response'=>'COUNT',
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $data=curl_exec($curl_handle);
            var_dump(json_decode($data));
    }
    //////////////////////////
    function pushSro(){
        $dharitree=$this->input->get('c');
        $basundhara=$this->input->get('app');
        $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."forcePushToSro");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'dhar_case'=>$dharitree,
                'pending_with_officer' =>  "SRO",
                'pending_at_office'=>'DC',
                'user'=>$this->session->userdata('user_code'),
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
          $data=curl_exec($curl_handle);
          return $data;
    }
    ///////////////////////

    //////////30-03-22/////////
    //check the basundhara service
    function checkBasundharaService($case){
        $sql="SELECT basundhara FROM basundhar_application WHERE dharitree=? and dharitree is not null";
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

      function postApiDocBasundharaTM($application_no,$case,$rmk,$status,$task,$pen,$encoded_file){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."traceMapUpload");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'dharitree_case' => $case,
                'remark' => $rmk,
                'status' => $status,
                'user_code' => $task,
                'pending_with_officer'=>$pen,
                'encoded_file'=>$encoded_file,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $result = curl_exec($curl_handle);
            $result=json_decode($result);
            return $result;
          
        }

        //#START PLB

        function postApiDocBasundhara($application_no,$case,$rmk,$status,$task,$pen,$encoded_file){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."deliveryDocsUpload");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                'dharitree_case' => $case,
                'remark' => $rmk,
                'status' => $status,
                'user_code' => $task,
                'pending_with_officer'=>$pen,
                'encoded_file'=>$encoded_file,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $result = curl_exec($curl_handle);
            $result=json_decode($result);
            return $result;
          
        }
    //#END PLB
        public function allVilageAndStatus($dist_code, $subdiv_code, $cir_code, $service_code)
        {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."locationAndStatusByCircle");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'dist_code' => $dist_code,
                'cir_code' =>  $cir_code,
                'subdiv_code'=>$subdiv_code,
                'service_code' =>  $service_code,
                'ip'=> $_SERVER['SERVER_ADDR'],
            )));
            $data=curl_exec($curl_handle);
            return json_decode($data);
        }
        //Validate before state change
        public function pre_post_validate_pattadar($validate_in_db,$validate_pattadar_data)
        {   if(is_array($validate_pattadar_data)) 
            {   $return[]='';
                foreach($validate_pattadar_data as $validate_pattadar_value)
                {
                   $return=$this->validate_pattadars_existance($validate_in_db,$validate_pattadar_value);
                   return  $return;
                }
                
            }
            else
            {
                return -2;
            }
        }
        //Validate Pattadar exists or not
        public function validate_pattadars_existance($db,$validate_pattadar_data)
        {           
            $chitha_pattadar_query ='';
            $chitha_pattadar_query =  $this->db->query("select count(*) as count from  chitha_dag_pattadar  where dist_code=? and 
                        subdiv_code=? and cir_code=? and mouza_pargona_code=? and
                        lot_no=? and vill_townprt_code=?
                        and trim(dag_no)=? and TRIM(patta_no)=? and
                        patta_type_code=? and pdar_id=?", $validate_pattadar_data);
                         
            $PattadarExists = $chitha_pattadar_query->result();

            $dag_pattadar_query ='';
            unset($validate_pattadar_data['dag_no']);
            $dag_pattadar_query = $this->db->query("select count(*) as count from  chitha_pattadar  where dist_code=? and 
            subdiv_code=? and cir_code=? and mouza_pargona_code=? and
            lot_no=? and vill_townprt_code=?
            and TRIM(patta_no)=? and
            patta_type_code=? and pdar_id=?", $validate_pattadar_data);
            $DagPattadarExists = $dag_pattadar_query->result();

            if ($DagPattadarExists[0]->count==1 and $PattadarExists[0]->count==1)
            {
                return 1;
            }
            else if($DagPattadarExists[0]->count<1 and $PattadarExists[0]->count<1)
            {
                return 0;
            }
            else
            {
                return -1;
            }

        }
        //Get chitha area, based on location
        public function getChithaAreaPreValidation($db,$validate_chitha_location_data)
        {
            $area_details ='';
            $data = '';
            $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no, 
            patta_type_code from chitha_basic where dist_code=? and cir_code=? and 
            subdiv_code=? and vill_townprt_code=? and mouza_pargona_code=? 
            and lot_no=? and trim(dag_no)=?", $validate_chitha_location_data);
            $data = $area->result();
            foreach ($data as $object) {
            $type = $this->db->query("select patta_type from patta_code 
                where type_code=?",$object->patta_type_code)->row()->patta_type;
            $area_details = array(
                'bigha' => trim($object->dag_area_b), 
                'katha' => trim($object->dag_area_k), 
                'lessa' => trim($object->dag_area_lc), 
                'ganda' => trim($object->dag_area_g), 
                'kranti' => trim($object->dag_area_kr), 
                'patta_no' => trim($object->patta_no),
                'patta_type' => $type,
                'patta_code' => trim($object->patta_type_code),
            );
         }
           return  $area_details;
       }

    function checkExistCaseInFieldMutBasic($case_basu){
        $sql="Select count(*) as c from  field_mut_basic where case_no=?";
        $dataFound=$this->db->query($sql,array($case_basu))->row();
        if($dataFound->c >0){
            $dataFound=$dataFound->c;
        }else{
            $dataFound=null;
        }
        return $dataFound;
    }

    //get---multigeneration--flag from dharitree-------
    function checkMultigeneration($case_no){
        $sql="Select is_multigeneration from  field_mut_basic where case_no=?";
        $row=$this->db->query($sql,array($case_no))->row();
        if(isset($row) && $row->is_multigeneration){
            $m_flag=$row->is_multigeneration;
        }else{
            $m_flag=null;
        }
        return $m_flag;
    }

    function getcaseno($application_no)
    {
        $sql="Select dharitree from  basundhar_application where basundhara=?";
        $row=$this->db->query($sql,array($application_no))->row();
        if(isset($row) && $row->dharitree){
            $case_no=$row->dharitree;
        }else{
            $case_no=null;
        }
        return $case_no;
    }

     //newly added for MB3 Conversion by Hridayjit (05-11-2024)
    public function allLmRequestMb3($service){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $ru=$this->session->userdata('user_desig_code');
        $url = API_LINK_MB3."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // setting 30 seconds
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output);
        return $result;
    }

    public function getApplicationDetails($application_no) {
        // $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB3."getAppDetails";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'application_no=' . $application_no);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

    public function ins_list($dist_code, $subdiv_code, $cir_code)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."ins_list");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
         curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'dist_code' => $dist_code,
            'cir_code' =>  $cir_code,
            'subdiv_code'=>$subdiv_code,
            'service_code' =>  '45',
            'ip'=> $_SERVER['SERVER_ADDR'],
        )));
        $data=curl_exec($curl_handle);
        return json_decode($data);
    }

    function usersForOfficeMisc($d,$s,$c){
            $q = "select * from loginuser_table  where dist_code = ? and subdiv_code=? and  cir_code=? and dis_enb_option=? and priv=? and user_code like 'CO%' ";
            $users = $this->db->query($q, array($d, $s, $c, 'E', 'adm'))->result();
            foreach ($users as $u) {
                $query_string = "dist_code = ? and subdiv_code=? and"
                        . " cir_code = ? and user_code=? ";
                $mutation[] = $this->db->query("select user_code,username from users where " . $query_string, array($d, $s, $c, $u->user_code))->row_array();
            }
            return $mutation;
        }

}
?>