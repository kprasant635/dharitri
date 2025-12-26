<?php
class Basundharamodel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    function searchBasundharaLink($case_no){
        $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
        $linkAvail=$this->db->query($sql)->row();
        if($linkAvail){
            $linkAvail=$linkAvail->basundhara;
            $caseRtpsBasu=$this->checkRtpsService($linkAvail);
            if($caseRtpsBasu=='RTPS'){
                $apilink=RTPS_API_LINK;
            }
            else{
                $apilink=API_LINK;
            }
            $url = $apilink."uploadfileName?case=" . $linkAvail;
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
        //echo $dataFound;
        return $dataFound;
    }
    public function allCORequest($service){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $ru=$this->session->userdata('user_desig_code');
        $url = API_LINK."serviceWiseRecordsCO/$service/$dist_code/$subdiv_code/$cir_code" ;
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
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK."serviceWiseRecordsCOPage");
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
        $caseRtpsBasu=$this->checkRtpsService($case_no);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."QueryReturn");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $case_no,
        )));
        $data=curl_exec($curl_handle);
        return json_decode($data);
    }
    function SroPost($case_no){
        $caseRtpsBasu=$this->checkRtpsService($case_no);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."getSroVerification");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $case_no,
        )));
        $data=curl_exec($curl_handle);
        return json_decode($data);
    }
    function postApiBasundharaSec($case,$rmk,$status,$task,$pen){
        $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        $linkAvail=$this->db->query($sql)->num_rows();
        if($linkAvail>0)
        {
            $linkAvail = $this->db->query($sql)->row()->basundhara;
            $statusResponse = $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
            $result = json_decode($statusResponse);
            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                return "y";
            }else{
                return "n";
            }

        }
        else
        {
            return "y";
        }
    }
    function payqueryRequest($basundhara,$amount){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."payqueryRequest");
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
            'query_from_office'=>'DC Office'
        )));
        // return curl_exec($curl_handle);
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }
    function fetchDharitree($case_basu){
        $sql="Select dharitree as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
        $dataFound=$this->db->query($sql)->row()->c;
        //echo json_encode($dataFound);
        // if($dataFound->c >0){
        //     $dataFound=$dataFound->c;
        // }else{
        //     $dataFound=null;
        // }
        return $dataFound;
    }
    function paymentConfirmation($basundhara){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."paymentStatus");
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
        return $result;
    }
    public function allLmRequest($service){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $ru=$this->session->userdata('user_desig_code');
        $url = API_LINK."serviceWiseRecords/$ru/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no" ;
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
    function usersForOffice($d,$s,$c){
        $q = "select * from loginuser_table where dist_code = '$d' and subdiv_code='$s' and  cir_code='$c' and dis_enb_option='E' and priv='adm' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$d' and subdiv_code='$s' and"
                . " cir_code = '$c' and user_code='$u->user_code' and status='O' ";
            $mutation[] = $this->db->query("select user_code,username from users where " . $query_string)->row();
        }
        return $mutation;
    }
    function postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen){
        $parts = explode('/', $application_no);
        $result = $parts[0] . '/' . $parts[1] . '/';
        if($result=='RTPS/APPP/'){
            $apilink=API_LINK_MB3;
        }
        else
        {
            $caseRtpsBasu=$this->checkRtpsService($application_no);
            if($caseRtpsBasu=='RTPS'){
                $apilink=RTPS_API_LINK;
            }
            else{
                $apilink=API_LINK;
            }
        }

            
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
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
            'pen'=>$pen
        )));
        $result = curl_exec($curl_handle);
        log_message('error','API827====='.$application_no."========".json_encode($result));
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            log_message("error", " Curl-Error in api: ".$apilink."applicationStatusUpdate with json_data: "
                .json_encode(array(
                        'application' => $application_no,
                        'dharitree' => $case,
                        'rmk' => $rmk,
                        'status' => $status,
                        'task' => $task,
                        'pen'=>$pen
                    )
                ));
            exit;
        }
        return $result;
        
    }
    /////////Pallabi///////////
    function RejectOrder(){
        $order=$_POST['order'];
        $application_no=$_POST['application_no'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK."applicationStatusUpdate");
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
            'pen'=>'NA'
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
                $url = API_LINK."serviceResponse?application_no=" . $linkAvail ;
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
        //echo API_LINK;
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK."rest/getrejectapp");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'dist_code' => 14,
            'service_code'=>1,
            'required_response'=>'COUNT'
        )));
        $data=curl_exec($curl_handle);
        //var_dump(json_decode($data));
    }
    //////////////////////////
    function pushSro(){
        $dharitree=$this->input->get('c');
        $basundhara=$this->input->get('app');
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK."forcePushToSro");
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
        )));
        $data=curl_exec($curl_handle);
        return $data;
    }
    ///////////////////////
    ///////////////////////
    function getRejectedApplications($conditions){
        $curl_handle = curl_init();
        //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK."getRejectedApplications");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
            'dist_code' => $conditions['dist_code'],
            'service_code'=>$conditions['service_code'],
            'required_response'=>$conditions['required_response'],
            'page_size'=>$conditions['page_size'],
            'page_no'=>$conditions['page_no']
        ]));
        $data=curl_exec($curl_handle);
        $data= json_decode($data);
        if($data->responseType==2){
            $data=$data->data;
        }else{
            $data=null;
        }
        return $data;
    }
    function postApiManualPayment($case,$task){
        $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        $linkAvail=$this->db->query($sql);
        if($linkAvail->num_rows()>0)
        {
            $basundhara=$linkAvail->row()->basundhara;
            $caseRtpsBasu=$this->checkRtpsService($basundhara);
            if($caseRtpsBasu=='RTPS'){
                $apilink=RTPS_API_LINK;
            }
            else{
                $apilink=API_LINK;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."manualPayStatus");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'query_from_officer'=>$this->session->userdata('user_code')
            )));
            // return curl_exec($curl_handle);
            $result = curl_exec($curl_handle);
            $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            curl_close($curl_handle);
            if($httpcode != 200){
                return false;
            }
            return json_decode($result);
        }
    }
    //////////////////////////
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
    ///////////////////////////////////////
    function postApiBasundharaForRejectedCase1st($case,$rmk,$status,$task,$pen,$rejectedCtgs){
        $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        $linkAvail=$this->db->query($sql)->num_rows();
        if($linkAvail>0)
        {
            $linkAvail = $this->db->query($sql)->row()->basundhara;
            return $this->postApiBasundharaForRejectedCase2nd($linkAvail,$case,$rmk,$status,$task,$pen,$rejectedCtgs);
        }
    }
    function postApiBasundharaForRejectedCase2nd($application_no,$case,$rmk,$status,$task,$pen,$rejectedCtgs){
        $caseRtpsBasu=$this->checkRtpsService($application_no);
        if($caseRtpsBasu=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        else{
            $apilink=API_LINK;
            return true;
		    exit;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
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
            'rejected_ctgs'=>$rejectedCtgs
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }
    function postApiBasundharaForRejectedCase3rd($application_no,$case,$rmk,$status,$task,$pen,$rejectedCtgs){
        $apilink=API_LINK;
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $application_no,
            'dharitree' => 'NA',
            'rmk' => $rmk,
            'status' => $status,
            'task' => $task,
            'pen'=>$pen,
            'rejected_ctgs'=>$rejectedCtgs
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }
    function queryReturn($application_no){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."QueryReturn");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $application_no,
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        $data= json_decode($result);
        return $data;
    }
    function attachedCO(){
        $user_code=$this->session->userdata('user_code');
        $d = $this->session->userdata('dist_code');
        $s = $this->session->userdata('subdiv_code');
        $c = $this->session->userdata('cir_code');
        $sql="Select status from users where dist_code=? and subdiv_code=? and cir_code=? and user_code=?";
        $data=$this->db->query($sql,array($d,$s,$c,$user_code));
        // log_message('error',$this->db->last_query());
        if($data->num_rows()>0)
            $status=$data->row()->status;
        else
            $status=null;
        return $status;
    }

    //newly added by Hridayjit for Mb3 (14-11-2024)
    function payqueryRequestMb3($basundhara,$amount){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        if($caseRtpsBasu=='RTPS'){
            $apilink=API_LINK_MB3;
        }
        else{
            $apilink=API_LINK_MB3;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."payqueryRequest");
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
            'query_from_office'=>'DC Office'
        )));
        // return curl_exec($curl_handle);
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }

    function postApiManualPaymentMb3($case,$task){
        $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        $linkAvail=$this->db->query($sql);
        if($linkAvail->num_rows()>0)
        {
            $basundhara=$linkAvail->row()->basundhara;
            $caseRtpsBasu=$this->checkRtpsService($basundhara);
            if($caseRtpsBasu=='RTPS'){
                $apilink=API_LINK_MB3;
            }
            else{
                $apilink=API_LINK_MB3;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."manualPayStatus");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'query_from_officer'=>$this->session->userdata('user_code')
            )));
            // return curl_exec($curl_handle);
            $result = curl_exec($curl_handle);
            $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            curl_close($curl_handle);
            if($httpcode != 200){
                return false;
            }
            return json_decode($result);
        }
    }

    function postApiBasundharaConvMb3($application_no,$case,$rmk,$status,$task,$pen){
        $statusResponse = $this->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
        $result = json_decode($statusResponse);
        if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
            return "y";
        }else{
            return "n";
        }
    }

    function paymentConfirmationMb3($basundhara){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);
        if($caseRtpsBasu=='RTPS'){
            $apilink=API_LINK_MB3;
        }
        else{
            $apilink=API_LINK_MB3;
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."paymentStatus");
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
        return $result;
    }
}
?>