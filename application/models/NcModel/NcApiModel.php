<?php
class NcApiModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    function searchBasundharaLink($case_no){
        $sql="Select basundhara from  basundhar_application where dharitree='$case_no' ";
        $linkAvail=$this->db->query($sql)->row();
        if($linkAvail){
            $linkAvail=$linkAvail->basundhara;
            $caseRtpsBasu=$this->checkRtpsService($linkAvail);
            $apilink=API_LINK_NC;
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
        $url = API_LINK_NC."serviceWiseRecordsCO/$service/$dist_code/$subdiv_code/$cir_code" ;
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

    /////////////////////
    function QueryPost($case_no){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."QueryReturn");
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
            $this->postApiBasundhara($linkAvail,$case,$rmk,$status,$task,$pen);
        }
    }
    function payqueryRequest($basundhara,$amount){
        $caseRtpsBasu=$this->checkRtpsService($basundhara);

        $apilink=API_LINK_NC;

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
            'ip'=> $_SERVER['SERVER_ADDR'],
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

        $apilink=API_LINK_NC;
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."paymentStatus");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $basundhara,
            'ip'=> $_SERVER['SERVER_ADDR'],
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
        $url = API_LINK_NC."serviceWiseRecords/$ru/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no" ;
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
                . " cir_code = '$c' and user_code='$u->user_code' ";
            $mutation[] = $this->db->query("select user_code,username from users where " . $query_string)->row();
        }
        return $mutation;
    }
    function postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen){
        // $caseRtpsBasu=$this->checkRtpsService($application_no);
        // $apilink=API_LINK_NC;
        // return "y"; die;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."applicationStatusUpdate");
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
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        if($httpcode != 200){
            log_message("error", " Curl-Error in api: ".API_LINK_NC."applicationStatusUpdate with json_data: "
                .json_encode(array(
                    'application' => $application_no,
                    'dharitree' => $case,
                    'rmk' => $rmk,
                    'status' => $status,
                    'task' => $task,
                    'pen'=>$pen
                )));
            return false;
        }
        curl_close($curl_handle);
        return $result;

        //echo $result;
    }


    function RejectOrder()
    {
        $order=$_POST['order'];
        $application_no=$_POST['application_no'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."applicationStatusUpdate");
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
                $url = API_LINK_NC."serviceResponse?application_no=" . $linkAvail ;
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
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."rest/getrejectapp");
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
    ///////////////////////
    function getRejectedApplications($conditions){
        $curl_handle = curl_init();
        //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getRejectedApplications");
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
            'page_no'=>$conditions['page_no'],
            'ip'=> $_SERVER['SERVER_ADDR'],
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

            $apilink=API_LINK_NC;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."manualPayStatus");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'query_from_officer'=>$this->session->userdata('user_code'),
                'ip'=> $_SERVER['SERVER_ADDR'],
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

        $apilink=API_LINK_NC;
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
            'rejected_ctgs'=>$rejectedCtgs,
            'ip'=> $_SERVER['SERVER_ADDR'],
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
        $apilink=API_LINK_NC;
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
            'rejected_ctgs'=>$rejectedCtgs,
            'ip'=> $_SERVER['SERVER_ADDR'],
        )));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }

    function applicationStatusUpdateBulk($application_no,$case,$rmk,$status,$task,$pen){
        $apilink=API_LINK_NC;
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdateBulk");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application' => $application_no,
            'dharitree' => $case,
            'rmk'       => $rmk,
            'status' => $status,
            'task' => $task,
            'pen'=>$pen,
            'ip'=> $_SERVER['SERVER_ADDR'],
        )));
        $result = curl_exec($curl_handle);
        //var_dump(json_decode($result));
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            return false;
        }
        return json_decode($result);
    }




    ////// settlement start ///////
    function fileManualValidation($file_details){
        log_message("error","file details: ".json_encode($file_details));
        $allowed_file_types= explode('|',$file_details->allowed_types);
        $name_pattern = "/^[A-Za-z0-9 ._()]+$/";
        if($file_details->required=='1' && !isset($_FILES[$file_details->file_name])){
            return array('status'=>1,'validation'=> array('field' => $file_details->file_name, 'message' => $file_details->file_details." document is required"));
        }else if(isset($_FILES[$file_details->file_name]) || ($file_details->required=='1' && isset($_FILES[$file_details->file_name]))){
            // FILE NAME SANITIZE
            if(!preg_match($name_pattern, $_FILES[$file_details->file_name]['name'])){
                return array('status'=>1,'validation'=>array('field' => $file_details->file_name, 'message' => "file name should be alpha numeric only eg. docname.pdf"));
            }else{
                log_message("error","allowed types of fie".json_encode($allowed_file_types));
                log_message("error","file_details".json_encode($file_details));
                $mime =  mime_content_type($_FILES[$file_details->file_name]['tmp_name']);
                $ext  =  explode("/",$mime)[1];
                log_message("error","file name".json_decode($file_details->file_name)." has ext: ".json_encode($ext));
                // FILE CONTENT TYPE AND ENTENSIONS CHECK
                if(!in_array($ext,$allowed_file_types)){
                    return array('status'=>1,'validation'=>array('field' => $file_details->file_name, 'message' => "file format not supported, required formats are ".$file_details->allowed_types));
                }else{
                    // FILE SIZE CHECK
                    if($_FILES[$file_details->file_name]['size'] > (int)$file_details->size*1024){
                        // TO CHECK MAX SIZE
                        $validation= array('field' => $file_details->file_name, 'message' => $file_details->file_details." has exceeded allowed file size limit of ".round($file_details->size/1024,2)."mb");
                        return array('status'=>1,'validation'=>$validation);
                    }else if($_FILES[$file_details->file_name]['size'] < 10*1024){
                        // TO CHECK MIN SIZE SO THAT EXCLUDE NULL BYTE FILES
                        $validation= array('field' => $file_details->file_name, 'message' => $file_details->file_details." is below the allowed file size limit of 100kb");
                        return array('status'=>1,'validation'=>$validation);
                    }else{
                        $meta_data= array('file_name'=>$file_details->file_name,'file_details'=>$file_details->file_details,'content_type' => $mime, 'extension' => $ext);
                        log_message("error","meta data of file".json_encode($meta_data));
                        return array('status'=>2,'data'=>$meta_data);
                    }
                }
            }
        }else{
            return;
        }
    }

    function genearteSettlementPetitionNo(){
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }


    public function getUploadConfig($full_config, $key_config){
        foreach($full_config as $config){
            if($config->file_details == $key_config){
                return $config;
            }
        }
        return NULL;
    }

    function fileManualValidationUpdate($file_details, $id){
        log_message("error","file details: ".json_encode($file_details));
        $allowed_file_types= explode('|',$file_details->allowed_types);
        $name_pattern = "/^[A-Za-z0-9 ._()]+$/";

        // var_dump($_FILES["file_name".$id]);

        if($file_details->required=='1' && !isset($_FILES["file_name".$id])){
            return array('status'=>1,'validation'=> array('field' => "file_name".file_name.$id, 'message' => $file_details->file_details." document is required"));
        }else if(isset($_FILES["file_name".$id]) || ($file_details->required=='1' && isset($_FILES["file_name".$id]))){
            // FILE NAME SANITIZE
            if(!preg_match($name_pattern, $_FILES["file_name".$id]['name'])){
                return array('status'=>1,'validation'=>array('field' => "file_name".$id, 'message' => "file name should be alpha numeric only eg. docname.pdf"));
            }else{
                log_message("error","allowed types of fie".json_encode($allowed_file_types));
                log_message("error","file_details".json_encode($file_details));
                $mime =  mime_content_type($_FILES["file_name".$id]['tmp_name']);
                $ext  =  explode("/",$mime)[1];
                log_message("error","file name".json_decode("file_name".$id)." has ext: ".json_encode($ext));
                // FILE CONTENT TYPE AND ENTENSIONS CHECK
                if(!in_array($ext,$allowed_file_types)){
                    return array('status'=>1,'validation'=>array('field' => "file_name".$id, 'message' => "file format not supported, required formats are ".$file_details->allowed_types));
                }else{
                    // FILE SIZE CHECK
                    if($_FILES["file_name".$id]['size'] > (int)$file_details->size*1024){
                        // TO CHECK MAX SIZE
                        $validation= array('field' => "file_name".$id, 'message' => $file_details->file_details." has exceeded allowed file size limit of ".round($file_details->size/1024,2)."mb");
                        return array('status'=>1,'validation'=>$validation);
                    }else if($_FILES["file_name".$id]['size'] < 10*1024){
                        // TO CHECK MIN SIZE SO THAT EXCLUDE NULL BYTE FILES
                        $validation= array('field' => "file_name".$id, 'message' => $file_details->file_details." is below the allowed file size limit of 100kb");
                        return array('status'=>1,'validation'=>$validation);
                    }else{
                        $meta_data= array('file_name'=>"file_name".$id,'file_details'=>$file_details->file_details,'content_type' => $mime, 'extension' => $ext);
                        log_message("error","meta data of file".json_encode($meta_data));
                        return array('status'=>2,'data'=>$meta_data);
                    }
                }
            }
        }else{
            return;
        }
    }


    function insertNewDag($application_no, $dag_no, $encroacher_id, $patta_no, $patta_code){

        $apilink=API_LINK_NC;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."modificationInBasundharaOnDagChange");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
            'dag_no' =>  $dag_no,
            'encroacher_id'=>$encroacher_id,
            'patta_no' => $patta_no,
            'patta_code'=>$patta_code,
            'ip'=> $_SERVER['SERVER_ADDR'],
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


    function reReportGeoTag($application_no){

        $apilink=API_LINK_NC;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."reuploadGeoTag");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
            'ip'=> $_SERVER['SERVER_ADDR'],
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




    /////// settlement end ////
}
?>