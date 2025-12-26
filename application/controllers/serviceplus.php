<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

 #PLB0004:Improvement in jamabandi service
 */

class Serviceplus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->helper(array('form', 'url'));
    }

    public function dbswitch(){
       if($this->session->userdata('dist_code') == "02"){
        $this->db=$this->load->database('dha3', TRUE);    
    } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$this->load->database('dha1', TRUE);    
    } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$this->load->database('dha24', TRUE);       
    } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$this->load->database('dha2', TRUE);    
    }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$this->load->database('dha4', TRUE);    
    }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$this->load->database('dha5', TRUE);    
    }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$this->load->database('dha6', TRUE);    
    }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$this->load->database('dha7', TRUE);    
    }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$this->load->database('dha8', TRUE);    
    }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$this->load->database('dha9', TRUE);    
    }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
    }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$this->load->database('dha10', TRUE);   
    }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$this->load->database('dha11', TRUE);   
    }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$this->load->database('dha12', TRUE);   
    }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
    }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$this->load->database('dha14', TRUE);   
    }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$this->load->database('dha15', TRUE);   
    }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$this->load->database('dha16', TRUE);   
    }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$this->load->database('dha17', TRUE);   
    }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$this->load->database('dha18', TRUE);   
    }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$this->load->database('dha19', TRUE);   
    }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$this->load->database('dha20', TRUE);   
    }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$this->load->database('dha21', TRUE);   
    }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$this->load->database('dha22', TRUE);   
    }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$this->load->database('dha23', TRUE);   
    }                                                                                                                                                                                                            
}

/* --------------- Jamabandi --------------- */
public function ror_cases() {
    $dis = $this->session->userdata('dist_code');
    $sub = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');

    $url = RTPS_LINK."ror/recieve_ror_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
    //$url = RTPS_LINK."mutation_order/recieve_mutation_order_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);

    $data = array();
    if(!empty($output)){
        foreach ($output as $d) {
            $data[] = array(
                'dist_code' => $d->dist_code,
                'id' => $d->id,
                'application_ref_no' => $d->application_ref_no,
                'applid' => $d->applId,
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'fee_amount' => $d->fee_amount,
                'patta_no' => $d->patta_no,
                'patta_type_code' => $d->patta_type_code,
                'appln_name' => $d->appln_name,
                //'appln_name' => $d->dharitree_case_no,
                'apply_date' => $d->apply_date,
                'status' => $d->status,
                'registered_date_entry' => $d->registered_date_entry,
                'co_comment' => $d->co_comment,
                'comment_date' => $d->comment_date,
                'reason_pending' => $d->reason_pending,
                'pending_date' => $d->pending_date,
                'attachment1' => '',
            );
        }
    }
    $datas['result'] = $data;
    $datas['_view'] = 'serviceplus/ror_cases';
    $this->load->view('layouts/main',$datas);
}

public function register_ror_applicant() {
    $application_ref_no = $this->input->get('application_ref_no');
    $applid = $this->input->get('applid');

    $url = RTPS_LINK."ror/ror_case_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);

    $data = array();
    foreach ($output as $d) {

        $data['dist_code'] = $d->dist_code;
        $data['id'] = $d->id;
        $data['application_ref_no'] = $d->application_ref_no;
        $data['applid'] = $d->applId;
        $data['dist_code'] = $d->dist_code;
        $data['subdiv_code'] = $d->subdiv_code;
        $data['cir_code'] = $d->cir_code;
        $data['mouza_pargona_code'] = $d->mouza_pargona_code;
        $data['lot_no'] = $d->lot_no;
        $data['vill_townprt_code'] = $d->vill_townprt_code;
        $data['fee_amount'] = $d->fee_amount;
        $data['patta_no'] = $d->patta_no;
        $data['patta_type_code'] = $d->patta_type_code;
        $data['appln_name'] = $d->appln_name;
        $data['apply_date'] = $d->apply_date;
        $data['status'] = $d->status;
        $data['registered_date_entry'] = $d->registered_date_entry;
        $data['co_comment'] = $d->co_comment;
        $data['comment_date'] = $d->comment_date;
        $data['reason_pending'] = $d->reason_pending;
        $data['pending_date'] = $d->pending_date;
        $name=str_replace("'", "", $d->appln_name);

        $sql = "Select pdar_id,pdar_name,pdar_father,pdar_aadharno,pdar_mobile,pdar_pan_no,pdar_gender from jama_pattadar WHERE "
        . "dist_code = '$d->dist_code' and subdiv_code = '$d->subdiv_code' and cir_code = '$d->cir_code' and mouza_pargona_code = '$d->mouza_pargona_code' "
        . "and lot_no = '$d->lot_no' and vill_townprt_code = '$d->vill_townprt_code' and patta_type_code='$d->patta_type_code' and "
        . "TRIM(patta_no)='$d->patta_no' and pdar_name like '%$name%' and (p_flag!='1' or p_flag is null) order by cast(pdar_id as int) ASC limit 1";

        $data['pattaDar'] = $this->db->query($sql)->result();

        $sql = "Select * from patta_code where type_code='$d->patta_type_code'";
        $data['patttype'] = $this->db->query($sql)->result();
        $data['attachments'] = $d->attachment;
    }

    $sql = "select * from cert_type where cert_code = '01'";
    $data['certtype'] = $this->db->query($sql)->result();

    $sql = "Select * from master_guard_rel";
    $data['guardRel'] = $this->db->query($sql)->result();

    $data['_view'] = 'serviceplus/register_ror_applicant';
    $this->load->view('layouts/main',$data);
}

public function applicant_recipet() {
    $data = array();
    $data['pdar_name'] = $pdar_name = $this->input->post('pdar_name');
    $data['guard_rel'] = $guard_rel = $this->input->post('guard_rel');
    $data['relation'] = $relation = $this->input->post('relation');
    $data['pdar_mobile'] = $this->input->post('mobile_no');
    $pdar_id = $this->input->post('pdar_id');
    $pdar_aadhar = $this->input->post('aadhar_no');
    $pdar_mobile = $this->input->post('mobile_no');
    $pdar_pan = $this->input->post('pan_no');
    $fee_amount = $this->input->post('cert_fees');

    $dist_code = $this->input->post('dist_code');
    $subdiv_code = $this->input->post('subdiv_code');
    $cir_code = $this->input->post('circle_code');
    $lot_no = $this->input->post('lot_no');
    $vill_townprt_code = $this->input->post('vill_code');
    $mouza_pargona_code = $this->input->post('mouza_code');
        $cert_type = '01'; // this is for jamabandi / ror
        $year_no = date('Y');

        $application_ref_no = $this->input->post('application_ref_no');
        $applid = $this->input->post('applId');

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_code');
        $apply_date = date('Y-m-d G:i:s');
        $due_date = $this->utilityclass->getDaysAfter($this->session->userdata('delivery_date'));
        $receipt_gen_yn = 'Y';
        $status = 'M';
        $user_code = $this->session->userdata('user_code');
        $date_entry = date('Y-m-d G:i:s');
        $rev_yn = $this->session->userdata('revenue');
        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $cername = $this->utilityclass->getCertCode($cert_type);
        $rev_name = $this->utilityclass->getRevenuLoc($dist_code, $subdiv_code, $cir_code);
        $case_name=$this->basundharamodel->genearteCaseName();
        $petition_no=$this->basundharamodel->genearteCertPetitionNo();
        $appln_no = $cername . "/" . $petition_no . "/" . $year_no;
        $data['cert_no']=$cert_no =$case_name.$petition_no."/".$cername;
        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'case_no' => $appln_no,
            'date_entry' => $date_entry,
            'cert_type_name' => 'জমাবন্দীৰ নকল',
            'fee_amount' => $fee_amount,
            'application_ref_no' => $application_ref_no
        );

        $q = "Select count(*) as id from cert_application where dist_code='$dist_code' 
        and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $num_rows = $this->db->query($q)->row()->id;

        if ($num_rows != 0) {
            $msg = "Error Found in processing. Please Try Again. Duplicate Entry found with the application no $appln_no !!";
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php/home');
            exit;
        }
        $insert = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'cert_type' => $cert_type,
            'appln_no' => $appln_no,
            'cert_no' => $cert_no,
            'year_no' => $year_no,
            'fee_amount' => $fee_amount,
            'patta_no' => trim($patta_no),
            'patta_type_code' => $patta_type_code,
            'pdar_id' => $pdar_id,
            'appln_name' => $pdar_name,
            'appln_guard' => $guard_rel,
            'guard_reln' => $relation,
            'apply_date' => $apply_date,
            'next_due_date' => $due_date,
            'receipt_gen_yn' => $receipt_gen_yn,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'rev_yn' => $rev_yn,
            'pdar_aadharno' => $this->session->userdata('aadhar_no'),
            'pdar_mobile' => $this->session->userdata('mobileNo'),
            'pdar_pan' => $this->session->userdata('pdar_pan'),
            'mode_of_registration' => 'citizen',
            'application_ref_no' => $this->input->post('application_ref_no'),
            'applid' => $this->input->post('applId'),
        );
        $this->db->insert('cert_application', $insert);    
        $rows = $this->db->affected_rows();
        
        if ($rows == 1) {
            $msgg = "Application has been successfully registered for Jamabandi/ROR Copy. Application No :" . $cert_no;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_status_update.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applid,
                'application_ref_no' => $application_ref_no,
                'rmk' => $msgg,
                'status' => 'S',
                'task' => 'AST',
            )));
            $result = curl_exec($curl_handle);

            $data['_view'] = 'serviceplus/applicant_receipt_probationary';
            $this->load->view('layouts/main',$data);
        }
    }
    function manualHit(){
        $msgg = "Application has been successfully registered for Jamabandi/ROR Copy. ";
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => 18430689,//$applid,
                'application_ref_no' => 'RTPS-ROR/2021/00005',//$application_ref_no,
                'rmk' => $msgg,
                'status' => 'S',
                'task' => 'AST',
            )));
        $result = curl_exec($curl_handle);
        var_dump($result);
    }

    public function save_citizen_centric() {
        $cert_no = $this->input->post('cert_no');
        $msg = "Application has been successfully registered Successfully. Application No :" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }

    public function CircleOfficerPrintCert() {
        $cert_no = $this->input->get('cert_no');
        $cert_type = $this->input->get('cert_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $data = array();
        $sql = "Select ca.*,ba.basundhara from cert_application ca left join basundhar_application ba on ba.dharitree=ca.cert_no where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
        $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
        $mouza_pargona_code = $certDtls->mouza_pargona_code;
        $lot_no = $certDtls->lot_no;
        $vill_townprt_code = $certDtls->vill_townprt_code;
        $tot_price = 0;
        //#START PLB
        if($certDtls->application_ref_no)
        {
            $url = RTPS_LINK."ror/ror_attachments.php?application_ref_no=" . $certDtls->application_ref_no . "&applid=" . $certDtls->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);
            $data['attachments']=$output;
        }
        //#END PLB
        

        $sql = "Select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
        $name = $this->db->query($sql)->result();
        foreach ($name as $n) {
            $q = "select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
            and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
            $data['users'] = $this->db->query($q)->result();
        }

        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
        . "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

        $dataCNT = $this->db->query($sqlCNT)->row();

        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 
        );
        $this->load->helper('qrcode');
        $base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
        $data['qrcode'] = $base_64;
        //#START PLB
        $data['certPenDtls'] =null;
        $sql = "Select * from cert_pending  where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' ";
        $data['certPenDtls'] = $certPenDtls = $this->db->query($sql)->row();

        $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($cert_no);
        
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->rtpsmodel->checkExistBasundhar($cert_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($cert_no);
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($cert_no))->result();
            $data['query']=$this->rtpsmodel->QueryPost($basundharaExist);
        }

        //#END PLB

        $data['_view'] = 'serviceplus/CoPrintCertJB';
        $this->load->view('layouts/main',$data);
    }

    public function saveJamabandi() {
        if (isset($_POST['Submit'])) {
            $cert_no = $this->input->post('cert_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $pdar_alignment = '1';
            if ($cert_no != null) {
                $t_reclassification = $this->db->query("Select * from cert_application where cert_no = '$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;
                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = $t_reclassification->patta_no;
                $comment_date = $t_reclassification->comment_date;
                $couser_code = $this->session->userdata('user_code');
                $user_code = $this->session->userdata('user_code');
                $application_ref_no = $t_reclassification->application_ref_no;
            }
            $this->load->helper('qrcode');
            $main = array();
            $jamainfo = array();
            $pattatype = array(
                'patta_type' => $pattatypeCode,
                'patta_no' => $patta_no,
                'case_no' => $cert_no,
                'submission_date' => $comment_date
            );


            $this->session->set_userdata($pattatype);
            $this->load->model('misreport/MisModel');

            $districtdata = $this->MisModel->getDistrictName($dist_code);
            $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
            $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
            $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
            $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
            $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
            $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
            $maindata['pattainfo'] = $pattatype;
            $main['application_ref_no'] = $application_ref_no;
            $maindata['username'] = $username;
            $pno = $patta_no;
            $main['daginfo'] = array();

            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from "
            . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
            . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
            . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
            $main['daginfo'] = $daginfo = $this->db->query($query)->result();
            foreach ($daginfo as $p) {
                $b = $p->dag_area_b;
                $k = $p->dag_area_k;
                $lc = round($p->dag_area_lc, 2);
                $g=$p->dag_area_g;
            }
            $daginfo_counted = count($main['daginfo']);

            $main['sort_pdar_by'] = '1';
            if ($daginfo_counted != "") {

                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                    $q = $this->db->query($query)->result();

                    $q1 = array();
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                    $q = $this->db->query($query)->result();

                    $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                    $q1 = $this->db->query($query1)->result();
                }
                $main['pattadarinf'] = array_merge($q, $q1);

                $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                $main['remarkinf'] = $this->db->query($query)->result();
                $query = "select old_patta_no from jama_patta WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') ";

                $main['oldpno'] = $this->db->query($query)->result();

                $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
                $pattadarname = $this->db->query($q)->row();
                $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

                $base_64 = printQR($pname);
                $main['qrcode'] = $base_64;

                $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
                $main['qrBasic'] = $basic;

                $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
                $main['qrCONAME'] = $coQR;

                $main = array_merge($maindata, $main);
                $main['sort_pdar_by'] = 1;

                //#START PLB

                $dist_code = $this->session->userdata('dist_code');
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print_kar';
                }
                else{
                     $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print';   
                }
                
                //#END PLB

                //$main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print';
                $this->load->view('layouts/main',$main);
            } else {
                $data['_view'] = 'serviceplus/no_jamabandi';
                $this->load->view('layouts/main',$data);
            }
        }
    }
    
    public function mpdf(){
        $htmlstring_text=$this->input->post('htmlstring_text');
        $json=array(
            'htmlString'=>$htmlstring_text
        );          
        $json = json_encode($json);     
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('access-control-allow-credentials: true');
        //header('content-type: application/pdf;charset=ISO-8859-1');
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, LINK_33_800.'get_pdf/pdf.php/');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($curl_handle);
        $data['jsonEncode']=$result;
        $data['_view'] = 'serviceplus/digiSign';
        $this->load->view('layouts/main',$data);

    }
    
    public function mpdfOS(){
        $htmlstring_text=$this->input->post('htmlstring_text');
        $json=array(
            'htmlString'=>$htmlstring_text
        );          
        $json = json_encode($json);     
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('access-control-allow-credentials: true');
        //header('content-type: application/pdf;charset=ISO-8859-1');
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, LINK_33_800.'get_pdf/pdf.php/');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($curl_handle);
        $data['jsonEncode']=$result;
        $data['_view'] = 'serviceplus/digiSignOS';
        $this->load->view('layouts/main',$data);

    }

    public function UploadCertificate() {
        $cert_no = $this->input->get('cert_no');
        $cert_type = $this->input->get('certtype');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $data = array();
        $sql = "Select * from cert_application where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
        $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
        $mouza_pargona_code = $certDtls->mouza_pargona_code;
        $lot_no = $certDtls->lot_no;
        $vill_townprt_code = $certDtls->vill_townprt_code;
        $tot_price = 0;
        if ($cert_type != '03' and $cert_type != '01' and $cert_type != '04' and $cert_type != '07') {
            $sql = "Select * from cert_dag_details where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
            $data['dagDtls'] = $certDag = $this->db->query($sql)->result();
            foreach ($certDag as $certDag) {
                $bigha = $certDag->a_dag_area_b;
                $katha = $certDag->a_dag_area_k;
                $lessa = $certDag->a_dag_area_lc;
                $lv_katha_price = $certDtls->lv_katha_price;
                $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
                $tot_price = round($tot_katha * $lv_katha_price, 2);
            }
            $sql = "Select * from chitha_basic where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
            . "patta_type_code='$certDtls->patta_type_code'  ";
            $data['cb'] = $this->db->query($sql)->row();
        }
        //$cntDag=0;
        //$sqlstr="( ";
        if ($cert_type == '04') {
            $sql = "Select * from cert_dag_details where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$certDtls->cert_no' ";
            $data['dagDtls'] = $certDag = $this->db->query($sql)->row();
            //foreach($certDag as $certDag){
            $bigha = $certDag->a_dag_area_b;
            $katha = $certDag->a_dag_area_k;
            $lessa = $certDag->a_dag_area_lc;
            $lv_katha_price = $certDtls->lv_katha_price;
            $tot_katha = ($bigha * 5) + $katha + ($lessa / 20);
            $tot_price = round($tot_katha * $lv_katha_price, 2);
            //}
            $sql = "Select * from chitha_basic where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$certDag->dag_no' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
            . "patta_type_code='$certDtls->patta_type_code'  ";
            $data['cb'] = $this->db->query($sql)->row();
        }

        $sql = "Select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
        $name = $this->db->query($sql)->result();
        foreach ($name as $n) {
            $q = "select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
            and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
            $data['users'] = $this->db->query($q)->result();
            //$data['users'] = $data->result();
        }


        //$data['users'] = $this->db->query($sql)->result();
        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //The following line added by Bijoy Mazumder, DIO, Bongaigaon on 26/04/2017 to count no of Pattadar against a Patta No.
        $sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
        . "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

        $dataCNT = $this->db->query($sqlCNT)->row();
        //$dataCNT = $this->db->query($sqlstr)->row();
        //-------------------------------------------------------------------------
        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 //added by Bijoy
        );
        //$this->load->view('../views/header');
        $this->load->helper('qrcode');
        $base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
        $data['qrcode'] = $base_64;
        if ($cert_type == '01') {
            //$this->load->view('../views/serviceplus/UploadCertificate', $data);

            $data['_view'] = 'serviceplus/UploadCertificate';
            $this->load->view('layouts/main',$data);
        }elseif ($cert_type == '07') {
           // $this->load->view('../views/serviceplus/UploadCertificateOS', $data);

            $data['_view'] = 'serviceplus/UploadCertificateOS';
            $this->load->view('layouts/main',$data);
        } else {
            redirect(base_url() . 'index.php/home');
            exit();
        }
        //$this->load->view('../views/footer');
    }

    public function UpdateJamaBondi() {
        //var_dump($_POST);
        $file = file_get_contents($_FILES['myFile']['tmp_name']);
        $file_upload = base64_encode($file);
        $cert_no = $this->input->post('cert_no');
        $fee_amount = $this->input->post('fee_amt');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from cert_application where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $result = $this->db->query($q)->row();
        $cername = $this->utilityclass->getCertName($result->cert_type);
        $data = array(
            'status' => 'D',
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->next_due_date,
            'number_of_pages' => $this->input->post('number_of_pages'),
            'total_fee_amt' => $this->input->post('fee_amt'),
            'cert_no' => $cert_no,
            'applicant_name' => $result->appln_name,
            'appln_guard' => $result->appln_guard,
            'cert_type' => $cername,
            'district' => $dist,
            'circle' => $cir,
            'mobile_no' => $result->pdar_mobile,
        );
        
        //exit();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_co_order.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $result->applid,
            'application_ref_no' => $result->application_ref_no,
            //'fee_amount' => '20',
            'file_upload' => $file_upload,
            'remark' => 'Order Passed',
        )));
        $result = curl_exec($curl_handle);
        
        $arr = array(
            'status' => 'D',
            'user_code' => $user_code,
            'co_checked_yn' => 'Y'
        );
        
        $this->db->where('cert_no', $cert_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);    
        
        $msg = "Certificate Delivered. Application No. ##" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
        
        /*$this->load->view('../views/header');
        $this->load->view('../views/serviceplus/applicant_receipet_jamabandi', $data);
        $this->load->view('../views/footer');*/
    }
    
    public function UpdateJamaBondiDeliver() {
        //var_dump($_POST);
        //$file = file_get_contents($_FILES['myFile']['tmp_name']);
        $file_upload = $this->input->post('signedPdfData');//base64_encode($file);
        $cert_no = $this->input->post('cert_no');
        $fee_amount = $this->input->post('fee_amt');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from cert_application where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $result = $this->db->query($q)->row();
        $cername = $this->utilityclass->getCertName($result->cert_type);
        $data = array(
            'status' => 'D',
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->next_due_date,
            'number_of_pages' => $this->input->post('number_of_pages'),
            'total_fee_amt' => $this->input->post('fee_amt'),
            'cert_no' => $cert_no,
            'applicant_name' => $result->appln_name,
            'appln_guard' => $result->appln_guard,
            'cert_type' => $cername,
            'district' => $dist,
            'circle' => $cir,
            'mobile_no' => $result->pdar_mobile,
        );
        
        //exit();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_co_order.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $result->applid,
            'application_ref_no' => $result->application_ref_no,
            //'fee_amount' => '20',
            'file_upload' => $file_upload,
            'remark' => 'Order Passed',
        )));
        $result = curl_exec($curl_handle);
        
        $arr = array(
            'status' => 'D',
            'user_code' => $user_code,
            'co_checked_yn' => 'Y'
        );
        
        $this->db->where('cert_no', $cert_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);
        $this->UploadDocFolder($cert_no,$file_upload);
        
        
        
        $msg = "Certificate Delivered. Application No. ##" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
        
        /*$this->load->view('../views/header');
        $this->load->view('../views/serviceplus/applicant_receipet_jamabandi', $data);
        $this->load->view('../views/footer');*/
    }
    
    function UploadDocFolder($id,$data) {
        if ($data != null || $data != "") {
            $id=str_replace("/","-",$id);
            $dir_name = $id ;
            $file_name=$id ;
            // $folder = 'digiSignDeliverRTPS/';
            // $path = "E:\\dharitree_programs\\wamp64\\www\\digiSignDeliverRTPS\\" . $dir_name;
            $path = UPLOAD_BASE_DIFI_SIGN_DELIVER . UPLOAD_SEPARATOR . $dir_name;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $binary = base64_decode($data);
            file_put_contents($path . "/" . $file_name . ".pdf", $binary);
            return $file_name . ".pdf";
        }
    }
    
    public function CaseDelivered() {
        // var_dump($this->session->all_userdata());
        $case_no = $_GET['cert_no'];
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $arr = array(
            'status' => 'D',
            'user_code' => $user_code
        );
        $this->db->where('cert_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        //var_dump($arr);
        $this->db->update('cert_application', $arr);
        $msg = "Certificate Delivered. Application No. ##" . $case_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
        exit();
    }
    
    /* --------------- Office Mutation ------------------ */
    public function office_mutation_cases() {
        //var_dump($this->session->all_userdata());
        $dis = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $url = RTPS_LINK."mutation/recieve_mutation_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        
        $data = array();
        if(!empty($output)){
            foreach ($output as $d) {

                $data[] = array(
                    'dist_code' => $d->dist_code,
                    'id' => $d->id,
                    'application_ref_no' => $d->application_ref_no,
                    'applid' => $d->applId,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'patta_no' => $d->patta_no,
                    'patta_type_code' => $d->patta_type_code,
                    'dag_no' => $d->dag_no,
                    'apply_date' => $d->date_entry,
                    'status' => $d->status,
                    'registered_date_entry' => $d->date_entry,
                );
            }
        }
        $datas['result'] = $data;
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/mutation_cases', $datas);
        // $this->load->view('../views/footer');

        $datas['_view'] = 'serviceplus/mutation_cases';
        $this->load->view('layouts/main',$datas);
    }

    public function mutation_register() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $application_ref_no = $this->input->get('application_ref_no');
        $applid = $this->input->get('applid');

        $url = RTPS_LINK."mutation/mutation_case_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        
        $data['result'] = $output;
        //var_dump($data);
        $q = "select * from loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and priv='adm' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
            . " cir_code = '$cir_code' and user_code='$u->user_code' ";

            $data['user'][] = $this->db->query("select * from users where " . $query_string)->row();
        }
        $data['application_ref_no'] = $application_ref_no;
        $data['applid'] = $applid;
        $data['_view'] = 'serviceplus/register_mutation';
        $this->load->view('layouts/main',$data);
    }

    public function save_office_mutation() {
        //var_dump($this->input->post());
        $mb = 0;
        $mk = 0;
        $mlc = 0;
        $this->db->trans_begin();
        $year_no = year_no;
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $lot_no = $this->input->post('lot_no');
        $dag_no = $this->input->post('dag_no');
        $patta_no = $this->input->post('patta_no');
        $patta_type_code = $this->input->post('patta_type');
        $application_ref_no = $this->input->post('application_ref_no');
        $applId = $this->input->post('applid');
        $case_name=$this->basundharamodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $sql="Select * from petition_basic where application_ref_no=?";
        $countCaseNo=$this->db->query($sql,array($application_ref_no));
        if($countCaseNo->num_rows>0){
            log_message('error',$application_ref_no ."###".$this->db->last_query());
            $this->session->set_flashdata('message',"Case has been already registered with case no:".$countCaseNo->row()->case_no);
            redirect('/home');
            die;
        }
        //$petition_no=$this->basundharamodel->genearteOfficePetitionNo();
        //$case_no=$case_name.$petition_no."/OMUT";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_no=$case_name.$petition_no."/OMUT";

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type');
        $transfer_type = $this->input->post('transfer_type');
        if ($this->input->post('reg_deed_no') !=null) {
            $petition_basic = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '03',
                'trans_code' => $this->input->post('transfer_type'),
                'add_off_name' => $this->input->post('add_of_name'),
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'mode_of_registration' => 'citizen',
                'application_ref_no' => $application_ref_no,
                'applid' => $applId,
                'deed_no' => $this->input->post('reg_deed_no'),
                'deed_value' => $this->input->post('reg_deed_value'),
                'deed_date' => date('Y-m-d', strtotime($this->input->post('reg_deed_date'))),
            );
        } else {
            $petition_basic = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '03',
                'trans_code' => $this->input->post('transfer_type'),
                'add_off_name' => $this->input->post('add_of_name'),
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'mode_of_registration' => 'citizen',
                'application_ref_no' => $application_ref_no,
                'applid' => $applId,
            );
        }
        //var_dump($petition_basic);
        $this->db->insert('petition_basic', $petition_basic); //************

        $count_applicants = count($this->input->post('applicant_name'));
        $applicant_name = $this->input->post('applicant_name');
        $guardian = $this->input->post('guardian');
        $guard_rel = $this->input->post('guard_rel');
        $add_1 = $this->input->post('add_1');
        $add_2 = $this->input->post('add_2');
        $add_of_name = $this->input->post('add_of_name');
        $new_pattadar = $this->input->post('new_pattadar');
        $pet_gender = $this->input->post('pet_gender');
        $pet_mother = $this->input->post('pet_mother');
        $pet_minor_yn = $this->input->post('pet_minor_yn');
        $pdar_mobile = $this->input->post('pdar_mobile');
        $pet_minor_dob = $this->input->post('pet_minor_dob');
        $pid = 1;

        for ($i = 0; $i < $count_applicants; $i++) {
            if ($pet_minor_dob[$i] != null) {
                $date = date('Y-m-d', strtotime($pet_minor_dob[$i]));
            } else {
                $date = null;
            }
            $date = null;
            if($applicant_name[$i]==null || $guardian[$i]==null){
                $this->session->set_flashdata('Applicant Name or Gurdian Name Information can not be Blank.');
                $this->db->trans_rollback();
                redirect('/home');
            }
            if($applicant_name[$i]!=null){
                    $petitioner_data = array(
                    'dist_code' => $this->input->post('dist_code'),
                    'subdiv_code' => $this->input->post('subdiv_code'),
                    'cir_code' => $this->input->post('cir_code'),
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'pet_id' => $pid++,
                    'guard_name' => $guardian[$i],
                    'guard_rel' => $guard_rel[$i],
                    'pet_name' => $applicant_name[$i],
                    //'pet_is_copdar' => $p['pet_is_copdar'],
                    'add1' => $add_1[$i],
                    //'add2' => $add_2[$i],
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'new_pattadar' => $new_pattadar[$i],
                    'pet_gender' => $pet_gender[$i],
                    'pet_mother' => $pet_mother[$i],
                    'pet_minor_yn' => $pet_minor_yn[$i],
                    'pet_minor_dob' => $date,
                    'pdar_mobile' => $pdar_mobile[$i],
                    'applied_b' => '0',
                    'applied_k' => '0',
                    'applied_lc' => '0',
                    'applied_g' => '0',
                );
                //var_dump($petitioner_data);
                $this->db->insert('petitioner', $petitioner_data); //************
            }
        }

        $dags_data = array(
            'dist_code' => $this->input->post('dist_code'),
            'subdiv_code' => $this->input->post('subdiv_code'),
            'cir_code' => $this->input->post('cir_code'),
            'mouza_pargona_code' => $this->input->post('mouza_code'),
            'lot_no' => $this->input->post('lot_no'),
            'vill_townprt_code' => $this->input->post('vill_townprt_code'),
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'm_dag_area_b' => $this->input->post('m_dag_area_b'),
            'm_dag_area_k' => $this->input->post('m_dag_area_k'),
            'm_dag_area_lc' => $this->input->post('m_dag_area_lc'),
            'm_dag_area_g' => $this->input->post('m_dag_area_g'),
            'dag_area_b' => $this->input->post('dag_area_b'),
            'dag_area_k' => $this->input->post('dag_area_k'),
            'dag_area_lc' => $this->input->post('dag_area_lc'),
            'dag_area_g' => $this->input->post('dag_area_g'),
            'dag_area_kr' => '0',
            'm_dag_area_kr' => '0',
            'patta_no' => trim($this->input->post('patta_no')),
            'patta_type_code' => $this->input->post('patta_type'),
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dag_no' => $this->input->post('dag_no')
        );

        $count_pattadars = count($this->input->post('pdar_id'));
        $cron_no = 1;

        for ($j = 0; $j < $count_pattadars; $j++) {

            $pdar_id = $this->input->post('pdar_id')[$j];
            $striked_out=$this->input->post('striked_out')[$j];
            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and TRIM(p.patta_no)=TRIM(d.patta_no) and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' and p.pdar_id=$pdar_id";

            $data = $this->db->query($query)->result();
            $values = array();
            $count = 0;

            foreach ($data as $value) {

                $relation = "u";
                if ($value->pdar_guard_reln != null)
                    $relation = $value->pdar_guard_reln;

                $other_data = array(
                    'dist_code' => $this->input->post('dist_code'),
                    'subdiv_code' => $this->input->post('subdiv_code'),
                    'cir_code' => $this->input->post('cir_code'),
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_id' => $pdar_id,
                    'pdar_cron_no' => $cron_no++,
                    'pdar_name' => $value->pdar_name,
                    'pdar_guardian' => $value->pdar_father,
                    'pdar_rel_guar' => $relation,
                    'pdar_add1' => $value->pdar_add1,
                    'pdar_add2' => $value->pdar_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'striked_out'=> $striked_out==null?0:$striked_out,
                );
                //var_dump($other_data);
                $this->db->insert('petition_pattadar', $other_data); //************
            }
        }
        //var_dump($dags_data);
        $this->db->insert('petition_dag_details', $dags_data); //************

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            
            // $curl_handle = curl_init();
            // curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation/mutation_status_update.php");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            //     'applid' => $applId,
            //     'application_ref_no' => $application_ref_no,
            //     'rmk' => 'Appliction Cannot Be Registered',
            //     'status' => 'F',
            //     'task' => 'AST',
            // )));
            // $result = curl_exec($curl_handle);
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
            $msgg = "Application has been successfully registered for office mutation of property ownership. Application No :" . $case_no;
            
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation/mutation_status_update.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applId,
                'application_ref_no' => $application_ref_no,
                'rmk' => $msgg,
                'status' => 'AST',
                'task' => 'AST',
            )));
            $result = curl_exec($curl_handle);
            
            $this->session->set_userdata(array('case_no' => $case_no));

            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
               redirect(base_url() . "index.php/serviceplus/applicant_receipet_kar");
            }
            else{
               redirect(base_url() . "index.php/serviceplus/applicant_receipet");
            }
            
        }
    }

    public function applicant_receipet() {
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        
        $q = "Select * from petition_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();

        $mutation_type_name = $this->db->query("select order_type as mut_name from master_office_mut_type where order_type_code = '$result->mut_type'")->row()->mut_name;
        $mut_type = $result->mut_type;

        $applicant_name = $this->db->query("select * from petitioner where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
            . "petition_no='$result->petition_no'")->result();

        $amount_fees = '0'; // amount to be paid will be nill if its by inheritance.
        
        //        mutationtype.getValue()
        //if((mutationtype.getValue()=='03') || (mutationtype.getValue()=='07') || (mutationtype.getValue()=='08') || (mutationtype.getValue()=='10')){
        //paymentObject.setHidePayment(true);
        //}

        //        If ($result->trans_code == '03') || ($result->trans_code == '07') || ($result->trans_code == '08') || ($result->trans_code == '10') then no fee required.
        
        $data = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
            'applicant_name' => $applicant_name
        );
        //var_dump();
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/applicant_receipet', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/applicant_receipet';
        $this->load->view('layouts/main',$data);
    }

     public function applicant_receipet_kar() {
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        
        $q = "Select * from petition_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();

        $mutation_type_name = $this->db->query("select order_type as mut_name from master_office_mut_type where order_type_code = '$result->mut_type'")->row()->mut_name;
        $mut_type = $result->mut_type;

        $applicant_name = $this->db->query("select * from petitioner where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
            . "petition_no='$result->petition_no'")->result();

        $amount_fees = '0'; // amount to be paid will be nill if its by inheritance.
        
        //        mutationtype.getValue()
        //if((mutationtype.getValue()=='03') || (mutationtype.getValue()=='07') || (mutationtype.getValue()=='08') || (mutationtype.getValue()=='10')){
        //paymentObject.setHidePayment(true);
        //}

        //        If ($result->trans_code == '03') || ($result->trans_code == '07') || ($result->trans_code == '08') || ($result->trans_code == '10') then no fee required.
        
        $data = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
            'applicant_name' => $applicant_name
        );
        //var_dump();
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/applicant_receipet', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/applicant_receipet_kar';
        $this->load->view('layouts/main',$data);
    }
    
    public function part_applicant_receipet() {
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        
        $q = "Select * from petition_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();

        $mutation_type_name = $this->db->query("select order_type as mut_name from master_office_mut_type where order_type_code = '04'")->row()->mut_name;
        $mut_type = $result->mut_type;
        
        $data['applicant_name'] = $this->db->query("select * from petitioner_part where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and "
            . "petition_no='$result->petition_no'")->result();

        $amount_fees = '0'; // amount to be paid will be nill if its by inheritance.
        
        //        mutationtype.getValue()
        //if((mutationtype.getValue()=='03') || (mutationtype.getValue()=='07') || (mutationtype.getValue()=='08') || (mutationtype.getValue()=='10')){
        //paymentObject.setHidePayment(true);
        //}

        //        If ($result->trans_code == '03') || ($result->trans_code == '07') || ($result->trans_code == '08') || ($result->trans_code == '10') then no fee required.
        //var_dump($data);
        $data['data'] = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
           // 'applicant_name' => $applicant_name
        );
        //var_dump();
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/part_applicant_receipet', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/part_applicant_receipet';
        $this->load->view('layouts/main',$data);
    }
    
    public function writeOfficeReport() {
         //xss & security validation starts
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST, [], [], ['report_on_possession' => true]);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            $resp = checkRequestValidQuery($_POST, [], ['report_on_possession' => true]);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }    
            if($errorMessageStr != ''){
                $this->session->set_flashdata('message', $errorMessageStr);
                //print_r($_POST);die;
                return redirect($_SERVER['HTTP_REFERER']);
            }
         //xss & security validation ends 
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
            unset($data['case_no']);
            unset($data['inplacAlong']);
            unset($data['pattadar']);
            $petition_no = $this->input->post('petition_no');
            for($i=0;$i<sizeof($_POST['pattadar']);$i++){
                $striked_out=$_POST['inplacAlong'][$i];
                $pdar_id=$_POST['pattadar'][$i];
                $update_pattadar = "update petition_pattadar set striked_out='$striked_out' where petition_no = $petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pdar_id=$pdar_id ";
                $this->db->query($update_pattadar);
            }
            $m_dag_area_b = trim($this->input->post('mut_b'));
            $m_dag_area_k = trim($this->input->post('mut_k'));
            $m_dag_area_lc = trim($this->input->post('mut_lc'));
            $m_dag_area_g = trim($this->input->post('mut_g'));
            $m_dag_area_kr = trim($this->input->post('mut_kr'));
            
            $q = "update petition_dag_details set m_dag_area_b='$m_dag_area_b', m_dag_area_k='$m_dag_area_k',"
            . " m_dag_area_lc='$m_dag_area_lc', m_dag_area_g='$m_dag_area_g',m_dag_area_kr='$m_dag_area_kr' where"
            . " petition_no = $petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $this->db->query($q);
            $data['lm_code'] = $this->session->userdata('user_code');
            $data['user_code'] = $this->session->userdata('user_code');
            $data['lm_sign_yn'] = 'Y';
            $data['operation'] = 'E';
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['year_no'] = year_no;
            // echo "select count(note_no)+1 as note_no from petition_lm_note where "
                            // . " petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $note_no = $this->db->query("select count(note_no)+1 as note_no from petition_lm_note where "
                . " petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->note_no;
            $data['note_no'] = $note_no;
            $data['lm_sign_date'] = date('Y-m-d G:i:s');
            unset($data['mode_of_registration']);
            unset($data['application_ref_no']);
            unset($data['applid']);
            
            
            $this->db->insert('petition_lm_note', $data);
            // var_dump($data);
            // EXIT;
            $updateLmNote = "update petition_basic set lm_note_yn='Y',lm_note_date='" . date('Y-m-d G:i:s') . "' "
            . " where petition_no = $petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $this->db->query($updateLmNote);
            $case_no = $this->input->post('case_no');
            
            $mode_of_registration = $this->input->post('mode_of_registration');
            
            if($mode_of_registration == 'citizen'){
                $application_ref_no = $this->input->post('application_ref_no');
                $applid = $this->input->post('applid');
                
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation/mutation_status_update.php");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'applid' => $applid,
                    'application_ref_no' => $application_ref_no,
                    'rmk' => 'Appliction Forwarded To Supervisor Kanango',
                    'status' => 'LM',
                    //'status' => 'S',
                    'task' => 'LM',
                    
                )));
                $result = curl_exec($curl_handle);
            }
            $this->session->set_flashdata("message", "LM Report for Office Mutation Case No." . $case_no . " recorded");
            redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $query = "select * from petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
            $petition = $this->db->query($query)->row();
            $petition_no = $petition->petition_no;
            $dags_query = "select * from petition_dag_details where petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$petition->mouza_pargona_code' and lot_no='$petition->lot_no' and vill_townprt_code='$petition->vill_townprt_code' and date_entry>='$define_date'";
            $dags = $this->db->query($dags_query)->row();

            $data['field_mut_petitioner'] = $this->db->query("select * from petitioner where petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$petition->mouza_pargona_code' and lot_no='$petition->lot_no' and vill_townprt_code='$petition->vill_townprt_code' and date_entry>='$define_date'")->result();
            $data['field_mut_pattadar'] = $this->db->query("select * from petition_pattadar where petition_no=$petition_no and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$petition->mouza_pargona_code' and lot_no='$petition->lot_no' and vill_townprt_code='$petition->vill_townprt_code' and date_entry>='$define_date'")->result();

            $data['dags'] = $dags;
            $data['petition'] = $petition;
            
            $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $petition->application_ref_no . "&applid=" . $petition->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);

            $data['attachment'] = $output;

            // $this->load->view('../views/header');
            // $this->load->view('../views/serviceplus/officereport', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'serviceplus/officereport';
            $this->load->view('layouts/main',$data);
        }
    }
    
    public function print_pdf(){
        $refNo=$_GET['refNo'];
        $type=$_GET['type'];
        $doc_type=$_GET['data'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."view_attachments.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'doc_type' => $doc_type,
            'application_ref_no' => $refNo,
            'type' => $type,
            
        )));
        $result = curl_exec($curl_handle);
        $output=base64_decode($result);
        header('Content-type: application/pdf');
        echo $output;
    }
    
    /* --------------- Mut Order Sheet --------------- */
    public function os_cases() {
        $dis = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        //$url = RTPS_LINK."ror/recieve_ror_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
        $url = RTPS_LINK."mutation_order/recieve_mutation_order_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data = array();
        if(!empty($output)){
            foreach ($output as $d) {
            //var_dump($d);
                $data[] = array(
                    'dist_code' => $d->dist_code,
                    'id' => $d->id,
                    'application_ref_no' => $d->application_ref_no,
                    'applid' => $d->applId,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'fee_amount' => $d->fee_amount,
                    'patta_no' => $d->patta_no,
                    'patta_type_code' => $d->patta_type_code,
                //'appln_name' => $d->appln_name,
                    'appln_name' => $d->dharitree_case_no,
                //'apply_date' => $d->apply_date,
                    'status' => $d->status,
                //'registered_date_entry' => $d->registered_date_entry,
                //'co_comment' => $d->co_comment,
                //'comment_date' => $d->comment_date,
                //'reason_pending' => $d->reason_pending,
                //'pending_date' => $d->pending_date,
                    'attachment1' => '',
                );
            }
        }
        //var_dump($data);
        $datas['result'] = $data;
        // $this->load->view('../views/header');
        // //$this->load->view('../views/serviceplus/ror_cases', $datas);
        // $this->load->view('../views/serviceplus/mut_order_cases', $datas);
        // $this->load->view('../views/footer');

        $datas['_view'] = 'serviceplus/mut_order_cases';
        $this->load->view('layouts/main',$datas);
    }
    
    public function mut_order_cases() {
        $dis = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $url = RTPS_LINK."mutation_order/recieve_mutorder_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data = array();
        //var_dump($output);
        if(!empty($output)){
            foreach ($output as $d) {
                $data[] = array(
                    'dist_code' => $d->dist_code,
                    'id' => $d->id,
                    'application_ref_no' => $d->application_ref_no,
                    'applid' => $d->applId,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'fee_amount' => $d->fee_amount,
                    'patta_no' => $d->patta_no,
                    'patta_type_code' => $d->patta_type_code,
                    'appln_name' => $d->appln_name,
                    'apply_date' => $d->apply_date,
                    'status' => $d->status,
                    'registered_date_entry' => $d->registered_date_entry,
                    'co_comment' => $d->co_comment,
                    'comment_date' => $d->comment_date,
                    'reason_pending' => $d->reason_pending,
                    'pending_date' => $d->pending_date,
                    'attachment1' => '',
                );
            }
        }
        $datas['result'] = $data;
        //var_dump($data);
        //$this->load->view('../views/header');
        //$this->load->view('../views/serviceplus/ror_cases', $datas);
        //$this->load->view('../views/footer');

        $datas['_view'] = 'serviceplus/ror_cases';
        $this->load->view('layouts/main',$datas);
    }
    
    public function register_mutorder_applicant() {
        $data = array();
        $application_ref_no = $this->input->get('application_ref_no');
        $applid = $this->input->get('applid');

        $url = RTPS_LINK."mutation_order/mutation_order_case_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $data['rtpsData']=$output = json_decode($output);
        //var_dump($output);
        //$data['appln_name']= $d->appln_name;
        foreach ($output as $d) {

            $data['dist_code'] = $d->dist_code;
            $data['id'] = $d->id;
            $data['application_ref_no'] = $d->application_ref_no;
            $data['applid'] = $d->applId;
            $data['dist_code'] = $d->dist_code;
            $data['subdiv_code'] = $d->subdiv_code;
            $data['cir_code'] = $d->cir_code;
            $data['mouza_pargona_code'] = $d->mouza_pargona_code;
            $data['lot_no'] = $d->lot_no;
            $data['vill_townprt_code'] = $d->vill_townprt_code;
            $data['fee_amount'] = $d->fee_amount;
            $data['mutationCaseNo'] = $d->dharitree_case_no;
            $data['patta_no'] = $d->patta_no;
            $data['patta_type_code'] = $d->patta_type_code;
            $data['appln_name'] = $d->appln_name;
            $data['apply_date'] = $d->date_entry;
            $data['status'] = $d->status;
            //echo  $data['appln_name'] ;
            //$data['registered_date_entry'] = $d->registered_date_entry;
            //$data['co_comment'] = $d->co_comment;
            // $data['comment_date'] = $d->comment_date;
            // $data['reason_pending'] = $d->reason_pending;
            //$data['pending_date'] = $d->pending_date;
            
            $this->session->userdata('mouza_pargona_code',$d->mouza_pargona_code);
            $this->session->userdata('lot_no',$d->lot_no);
            $this->session->userdata('vill_townprt_code',$d->vill_townprt_code);
            $this->session->userdata('patta_no',$d->patta_no);
            $this->session->userdata('patta_type_code',$d->patta_type_code);
            

            $sql = "Select pdar_id,pdar_name,pdar_father,pdar_aadharno,pdar_mobile,pdar_pan_no from jama_pattadar WHERE "
            . "dist_code = '$d->dist_code' and subdiv_code = '$d->subdiv_code' and cir_code = '$d->cir_code' and mouza_pargona_code = '$d->mouza_pargona_code' "
            . "and lot_no = '$d->lot_no' and vill_townprt_code = '$d->vill_townprt_code' and patta_type_code='$d->patta_type_code' and "
            . "TRIM(patta_no)='$d->patta_no' and pdar_name like '%$data[appln_name]%'  order by cast(pdar_id as int) ASC";

            $data['pattaDar'] = $this->db->query($sql)->row();
            
            $sql = "Select * from patta_code where type_code='$d->patta_type_code'";
            $data['patttype'] = $this->db->query($sql)->result();
            $data['attachments'] = $d->attachment;
        }
        //var_dump($data['pattaDar']);
        $sql = "select * from cert_type where cert_code = '07'";
        $data['certtype'] = $this->db->query($sql)->result();

        $sql = "Select * from master_guard_rel";
        $data['guardRel'] = $this->db->query($sql)->result();
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/register_mutorder_applicant', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/register_mutorder_applicant';
        $this->load->view('layouts/main',$data);
    }
    
    public function saveMutOrder() {
        //var_dump($_POST);
        $data = array();
        $data['pdar_name'] = $pdar_name = $this->input->post('pdar_name');
        $data['guard_rel'] = $guard_rel = $this->input->post('guard_rel');
        $data['relation'] = $relation = $this->input->post('relation');
        $data['pdar_mobile'] = $this->input->post('mobile_no');
        $pdar_id = $this->input->post('pdar_id');
        $pdar_aadhar = $this->input->post('aadhar_no');
        $pdar_mobile = $this->input->post('mobile_no');
        $pdar_pan = $this->input->post('pan_no');
        $fee_amount = $this->input->post('cert_fees');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $cert_type = '07'; // this is for jamabandi / ror
        $year_no = date('Y');

        $application_ref_no = $this->input->post('application_ref_no');
        $mutation_caseNo = $this->input->post('mutation_caseNo');
        $applid = $this->input->post('applId');

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_code');
        $apply_date = date('Y-m-d G:i:s');
        $due_date = $this->utilityclass->getDaysAfter($this->session->userdata('delivery_date'));
        $receipt_gen_yn = 'Y';
        $status = 'M';
        $user_code = $this->session->userdata('user_code');
        $date_entry = date('Y-m-d G:i:s');
        $rev_yn = $this->session->userdata('revenue');
        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $cername = $this->utilityclass->getCertCode($cert_type);
        $rev_name = $this->utilityclass->getRevenuLoc($dist_code, $subdiv_code, $cir_code);

        // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        // $abbrname = $this->db->query($q)->row();
        // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;

        // $q = "select count(*)+1 as c from cert_application where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_type='$cert_type' and year_no='$year_no' ";
        // $dataa = $this->db->query($q)->row()->c;
        // //var_dump($dataa);
        // //$appln_no_explode = explode('/', $dataa);
        // $increment_appln_no = $dataa + 1;
        // $appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;

        // $check_status = TRUE;

        // while ($check_status == TRUE) {

        //     $appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;
        //     $check_existance = $this->db->query("select count(*) as c from cert_application where appln_no='$appln_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_type='$cert_type'  and year_no='$year_no'")->row()->c;
        //     if ($check_existance <= '0') {
        //         $appln_no = $cername . "/" . $increment_appln_no . "/" . $year_no;
        //         $check_status = FALSE;
        //     } else {
        //         $increment_appln_no = $increment_appln_no + 1;
        //     }
        // }
        // $appln_no;
        // $data['cert_no'] = $cert_no = $cir_dist_name . "/" . $appln_no;
        $case_name=$this->basundharamodel->genearteCaseName();
       // $petition_no=$this->basundharamodel->genearteCertPetitionNo();

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteCertPetitionNo();

        $appln_no = $cername . "/" . $petition_no . "/" . $year_no;
        $data['cert_no']=$cert_no =$case_name.$petition_no."/".$cername;

        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'case_no' => $appln_no,
            'date_entry' => $date_entry,
            'cert_type_name' => 'Order Sheet',
            'fee_amount' => $fee_amount,
            'application_ref_no' => $application_ref_no
        );

        $q = "Select count(*) as id from cert_application where dist_code='$dist_code' 
        and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $num_rows = $this->db->query($q)->row()->id;

        if ($num_rows != 0) {
            $msg = "Error Found in processing. Please Try Again. Duplicate Entry found with the application no $appln_no !!";
            $this->session->set_flashdata('message', $msg);     
            /*$status = 'F';
            $url = RTPS_LINK."ror/ror_status_update.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid . "&rmk=" . $msg . "&status=" . $status;
            //echo $url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_close($ch);*/
            redirect(base_url() . 'index.php/home');
            exit;
        }
        $insert = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'cert_type' => $cert_type,
            'appln_no' => $appln_no,
            'cert_no' => $cert_no,
            'year_no' => $year_no,
            'fee_amount' => $fee_amount,
            'patta_no' => trim($patta_no),
            'patta_type_code' => $patta_type_code,
            'pdar_id' => $pdar_id,
            'appln_name' => $data['pdar_name'],
            'appln_guard' => $data['guard_rel'],
            'guard_reln' => $data['relation'],
            'apply_date' => $apply_date,
            'next_due_date' => $due_date,
            'receipt_gen_yn' => $receipt_gen_yn,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'rev_yn' => $rev_yn,
            'lm_checked_yn'=>'Y',
            'pdar_aadharno' => $this->session->userdata('aadhar_no'),
            'pdar_mobile' => $this->session->userdata('mobileNo'),
            'pdar_pan' => $this->session->userdata('pdar_pan'),
            'mode_of_registration' => 'citizen',
            'application_ref_no' => $this->input->post('application_ref_no'),
            'applid' => $this->input->post('applId'),
            'mut_case_no' => $this->input->post('mutation_caseNo'),
        );
        //echo"<pre>";
        ////var_dump($insert);
        $this->db->insert('cert_application', $insert);
        echo ($this->db->_error_message());
        $rows = $this->db->affected_rows();
        //exit;
        if ($rows == 1) {
            $msgg = "Application has been successfully registered for office mutation order certificate. Application No :" . $cert_no;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation_order/mutation_order_status_update.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applid,
                'application_ref_no' => $application_ref_no,
                'rmk' => $msgg,
                'status' => 'AST',
                'task' => 'AST',
                'file' => ''
            )));
            
            $result = curl_exec($curl_handle);

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/serviceplus/applicant_receipt_probationaryOS', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'serviceplus/applicant_receipt_probationaryOS';
            $this->load->view('layouts/main',$data);
        }
    }
    
    public function os_enclosure_query() {
        $applid=$this->input->post('applId');
        $application_ref_no=$this->input->post('application_ref_no');//"RTPS-ORDCT/2020/00043";
        $msgg=$this->input->post('query');
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation_order/mutation_order_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $applid,
            'application_ref_no' => $application_ref_no,
            'rmk' => $msgg,
            'status' => 'QS',
            'task' => 'AST',
            'file' => ''
        )));
        $result = curl_exec($curl_handle);
        $msg = "Application has been sent back to applicant for enclosure query";
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }
    
    public function CircleOfficerPrintOS() {
        $cert_no = $this->input->get('cert_no');
        $cert_type = $this->input->get('cert_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $data = array();
        $sql = "Select * from cert_application where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
        $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
        $mouza_pargona_code = $certDtls->mouza_pargona_code;
        $lot_no = $certDtls->lot_no;
        $vill_townprt_code = $certDtls->vill_townprt_code;
        $tot_price = 0;
        
        $url = RTPS_LINK."MUTATION_ORDER/mutation_order_attachment_details.php?application_ref_no=" . $certDtls->application_ref_no . "&applid=" . $certDtls->applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['attachments']=$output;
        //var_dump($output);
        

        $sql = "Select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
        $name = $this->db->query($sql)->result();
        foreach ($name as $n) {
            $q = "select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
            and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
            $data['users'] = $this->db->query($q)->result();
        }

        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
        . "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

        $dataCNT = $this->db->query($sqlCNT)->row();

        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 
        );
        //var_dump($data);
        //$this->load->view('../views/header');
        $this->load->helper('qrcode');
        $base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
        $data['qrcode'] = $base_64;
        // $this->load->view('../views/serviceplus/CoPrintCertMutOrder', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/CoPrintCertMutOrder';
        $this->load->view('layouts/main',$data);
    }
    
    public function GenerateOS() {
        $cert_no = $this->input->post('cert_no');
        $cert_type = $this->input->post('certtype');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $this->session->set_userdata('case_no', $cert_no);
        $data = array();
        $sql = "Select * from cert_application where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no' and apply_date >='$define_date' ";
        $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
        $mouza_pargona_code = $certDtls->mouza_pargona_code;
        $lot_no = $certDtls->lot_no;
        $vill_townprt_code = $certDtls->vill_townprt_code;
        $tot_price = 0;
        
        //$cntDag=0;
        //$sqlstr="( ";
        if ($cert_type == '07') {
            $query = "select * from petition_proceeding where case_no = '$certDtls->mut_case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
            . "and cir_code='$cir_code'";
            $data['cases'] = $this->db->query($query)->result();
            //var_dump($data);
        }
        

        $sql = "Select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
        $name = $this->db->query($sql)->result();
        foreach ($name as $n) {
            $q = "select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
            and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
            $data['users'] = $this->db->query($q)->result();
            //$data['users'] = $data->result();
        }


        //$data['users'] = $this->db->query($sql)->result();
        $location = $this->utilityclass->getLocationFromSession();
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //The following line added by Bijoy Mazumder, DIO, Bongaigaon on 26/04/2017 to count no of Pattadar against a Patta No.
        $sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
        . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
        . "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

        $dataCNT = $this->db->query($sqlCNT)->row();
        //$dataCNT = $this->db->query($sqlstr)->row();
        //-------------------------------------------------------------------------
        $data['location'] = array(
            'distname' => $dist,
            'subname' => $sub,
            'cirname' => $cir,
            'mouza_pargona_code' => $mouza_name,
            'lot_no' => $lotname,
            'vill_townprt_code' => $vill_name,
            'tot_price' => $tot_price,
            'tot_pdar' => $dataCNT->c1 
        );
        //$this->load->view('../views/header');
        //$this->load->helper('qrcode');
       // $base_64 = printQR($certDtls->cert_no . "\n" . $certDtls->appln_name . "\n" . $cir . "-" . $vill_name . "-" . date('d/m/Y'));
       // $data['qrcode'] = $base_64;
        // $this->load->view('../views/Serviceplus/PrintCertOS', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'Serviceplus/PrintCertOS';
        $this->load->view('layouts/main',$data);
    }
    
    function dscSign(){
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/Upload');
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/Upload';
        $this->load->view('layouts/main',$data);
    }

    public function UpdateOSDeliver() {
        //var_dump($_POST);
        //$file = file_get_contents($_FILES['myFile']['tmp_name']);
        $file_upload = $this->input->post('signedPdfData');
        $cert_no = $this->input->post('cert_no');
        $fee_amount = $this->input->post('fee_amt');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from cert_application where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $result = $this->db->query($q)->row();
        $cername = $this->utilityclass->getCertName($result->cert_type);

        
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation_order/mutation_order_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $result->applid,
            'application_ref_no' => $result->application_ref_no,
            'rmk' => 'Application Delivered',
            'status' => 'D',
            'task' => 'CO',
            'file' => $file_upload,
        )));
        // var_dump(array(
            // 'applid' => $result->applid,
            // 'application_ref_no' => $result->application_ref_no,
            // //'fee_amount' => '20',
            // 'file_upload' => $file_upload,
            // 'msg' => 'Application Delivered',
            // 'status' => 'D',
        // ));
        $result = curl_exec($curl_handle);
        
        $arr = array(
            'status' => 'D',
            'user_code' => $user_code,
            'co_checked_yn' => 'Y'
        );
        
        $this->db->where('cert_no', $cert_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);
        $this->UploadDocFolder($cert_no,$file_upload);
        
        
        $msg = "Certificate Delivered. Application No. ##" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
        
        /*$this->load->view('../views/header');
        $this->load->view('../views/serviceplus/applicant_receipet_jamabandi', $data);
        $this->load->view('../views/footer');*/
    }
    
    public function UpdateOS() {
        //var_dump($_POST);
        $file = file_get_contents($_FILES['myFile']['tmp_name']);
        $file_upload = base64_encode($file);
        $cert_no = $this->input->post('cert_no');
        $fee_amount = $this->input->post('fee_amt');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $q = "Select * from cert_application where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and cert_no='$cert_no' ";
        $result = $this->db->query($q)->row();
        $cername = $this->utilityclass->getCertName($result->cert_type);
        $data = array(
            'status' => 'D',
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->next_due_date,
            'number_of_pages' => $this->input->post('number_of_pages'),
            'total_fee_amt' => $this->input->post('fee_amt'),
            'cert_no' => $cert_no,
            'applicant_name' => $result->appln_name,
            'appln_guard' => $result->appln_guard,
            'cert_type' => $cername,
            'district' => $dist,
            'circle' => $cir,
            'mobile_no' => $result->pdar_mobile,
        );
        
        //exit();

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation_order/mutation_order_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $result->applid,
            'application_ref_no' => $result->application_ref_no,
            'rmk' => 'Application Delivered',
            'status' => 'D',
            'task' => 'CO',
            'file' => $file_upload,
        )));
        
        $result = curl_exec($curl_handle);
        
        $arr = array(
            'status' => 'D',
            'user_code' => $user_code,
            'co_checked_yn' => 'Y'
        );
        
        $this->db->where('cert_no', $cert_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);
        
        $msg = "Certificate Delivered. Application No. ##" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }
    
    /* --------------- Office Partition --------------- */
    public function office_partition_cases() {
        //var_dump($this->session->all_userdata());
        $dis = $this->session->userdata('dist_code');
        $sub = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $url = RTPS_LINK."partition/recieve_partition_cases.php?dist=" . $dis . "&sub=" . $sub . "&cir=" . $cir_code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        
        $data = array();
        if(!empty($output)){
            foreach ($output as $d) {

                $data[] = array(
                    'dist_code' => $d->dist_code,
                    'id' => $d->id,
                    'application_ref_no' => $d->application_ref_no,
                    'applid' => $d->applId,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'patta_no' => $d->patta_no,
                    'patta_type_code' => $d->patta_type_code,
                    'dag_no' => $d->dag_no,
                    'apply_date' => $d->date_entry,
                    'status' => $d->status,
                    'registered_date_entry' => $d->date_entry,
                );
            }
        }
        $datas['result'] = $data;
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/partition_cases', $datas);
        // $this->load->view('../views/footer');


        $datas['_view'] = 'serviceplus/partition_cases';
        $this->load->view('layouts/main',$datas);
    }
    
    public function partition_register() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $application_ref_no = $this->input->get('application_ref_no');
        $applid = $this->input->get('applid');

        $url = RTPS_LINK."partition/partition_case_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['result'] = $output;
        $sql = "Select * from master_guard_rel";
        $data['guardRel'] = $this->db->query($sql)->result();
        $q = "select * from loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and priv='adm' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
            . " cir_code = '$cir_code' and user_code='$u->user_code' ";

            $data['user'][] = $this->db->query("select * from users where " . $query_string)->row();
        }
        $data['application_ref_no'] = $application_ref_no;
        $data['applid'] = $applid;
        
        //var_dump($data);
        
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/register_partition', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/register_partition';
        $this->load->view('layouts/main',$data);
    }
    
    public function save_office_partition() {
        $mb = 0;
        $mk = 0;
        $mlc = 0;
        $this->db->trans_begin();
        $year_no = year_no;
        $location = $this->utilityclass->getLocationFromSession();
        
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $dag_no = $this->input->post('dag_no');
        $patta_no = $this->input->post('patta_no');
        $patta_type_code = $this->input->post('patta_type');
        $application_ref_no = $this->input->post('application_ref_no');
        $applId = $this->input->post('applid');
        $case_name=$this->basundharamodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $sql="Select * from petition_basic where application_ref_no=?";
        $countCaseNo=$this->db->query($sql,array($application_ref_no));
        if($countCaseNo->num_rows>0){
            log_message('error',$application_ref_no ."###".$this->db->last_query());
            $this->session->set_flashdata('message',"Case has been already registered with case no:".$countCaseNo->row()->case_no);
            redirect('/home');
            die;
        }
        //$petition_no=$this->basundharamodel->genearteOfficePetitionNo();
        //$case_no=$case_name.$petition_no."/OPART";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_no=$case_name.$petition_no."/OPART";

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type');
        $transfer_type = $this->input->post('transfer_type'); 
        
        if ($this->input->post('deed_no') != null) {
            $petition_basic = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '04',
                'trans_code' => $this->input->post('transfer_type'),
                'add_off_name' => $this->input->post('add_of_name'),
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'co_user_code'=>$this->input->post('add_of_name'),
                'mode_of_registration' => 'citizen',
                'deed_no' => $this->input->post('reg_deed_no'),
                'deed_value' => $this->input->post('reg_deed_value'),
                'deed_date' => date('Y-m-d', strtotime($this->input->post('reg_deed_date'))),
                'application_ref_no' => $application_ref_no,
                'applid' => $applId,
            );
        } else {
            $petition_basic = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'case_no' => $case_no,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '04',
                'trans_code' => $this->input->post('transfer_type'),
                'add_off_name' => $this->input->post('add_of_name'),
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'co_user_code'=>$this->input->post('add_of_name'),
                'operation' => 'E',
                
                'mode_of_registration' => 'citizen',
                'application_ref_no' => $application_ref_no,
                'applid' => $applId,
            );
        }
        //var_dump($petition_basic);
        $this->db->insert('petition_basic', $petition_basic); //************
        //$this->db->last_query();

        $dags_data = array(
            'dist_code' => $this->input->post('dist_code'),
            'subdiv_code' => $this->input->post('subdiv_code'),
            'cir_code' => $this->input->post('cir_code'),
            'mouza_pargona_code' => $this->input->post('mouza_code'),
            'lot_no' => $this->input->post('lot_no'),
            'vill_townprt_code' => $this->input->post('vill_townprt_code'),
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'm_dag_area_b' => $this->input->post('p_dag_area_b'),
            'm_dag_area_k' => $this->input->post('p_dag_area_k'),
            'm_dag_area_lc' => $this->input->post('p_dag_area_lc'),
            'm_dag_area_g' => $this->input->post('p_dag_area_g'),
            'm_dag_area_kr' => $this->input->post('p_dag_area_kr'),
            'dag_area_b' => $this->input->post('dag_area_b'),
            'dag_area_k' => $this->input->post('dag_area_k'),
            'dag_area_lc' => $this->input->post('dag_area_lc'),
            'dag_area_g' => $this->input->post('dag_area_g'),
            'dag_area_kr' => $this->input->post('dag_area_kr'),
            'patta_no' => trim($this->input->post('patta_no')),
            'patta_type_code' => $this->input->post('patta_type'),
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dag_no' => $this->input->post('dag_no'),
            'case_no' => $case_no
        );
        
        $count_pattadars = count($this->input->post('pdar_id'));
        $cron_no = 1;
        for ($j = 0; $j < $count_pattadars; $j++) {

            $pdar_id = $this->input->post('pdar_id')[$j];
            $pdar_mobile = $this->input->post('pdar_mobile')[$j];
            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and TRIM(p.patta_no)=TRIM(d.patta_no) and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and TRIM(p.patta_no)='$patta_no' 
            and p.patta_type_code='$patta_type_code' and p.pdar_id=$pdar_id";

            $data = $this->db->query($query)->result();
            $values = array();
            $count = 0;

            foreach ($data as $value) {

                $relation = "u";
                if ($value->pdar_guard_reln != null)
                    $relation = $value->pdar_guard_reln;

                $other_data = array(
                    'dist_code' => $this->input->post('dist_code'),
                    'subdiv_code' => $this->input->post('subdiv_code'),
                    'cir_code' => $this->input->post('cir_code'),
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_id' => $pdar_id,
                    'pdar_cron_no' => $cron_no++,
                    'pdar_name' => $value->pdar_name,
                    'pdar_guardian' => $value->pdar_father,
                    'pdar_rel_guar' => $relation,
                    'pdar_add1' => $value->pdar_add1,
                    'pdar_add2' => $value->pdar_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'case_no' => $case_no,
                    'pdar_mobile'=>$pdar_mobile
                );
                $this->db->insert('petitioner_part', $other_data); //************
            }
        }
        $this->db->insert('petition_dag_details', $dags_data); //************
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Registered. Contact Help Desk with Location Details");
            // $curl_handle = curl_init();
            // curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_status_update.php");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            //     'applid' => $applId,
            //     'application_ref_no' => $application_ref_no,
            //     'rmk' => 'Appliction Cannot Be Registered',
            //     'status' => 'F',
            //     'task' => 'AST',
            //     'file' => ''
            // )));
            // $result = curl_exec($curl_handle);
            redirect(base_url() . "index.php/home");
        } else {            
            $this->db->trans_commit();
            $msgg = "Application has been successfully registered for office Partition . Dharitree Application No :" . $case_no ;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_status_update.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applId,
                'application_ref_no' => $application_ref_no,
                'rmk' => $msgg,
                'status' => 'AST',
                'task' => 'AST',
                'file' => ''
            )));
            $result = curl_exec($curl_handle);
            $this->session->set_userdata(array('case_no' => $case_no));
            redirect(base_url() . "index.php/serviceplus/part_applicant_receipet");
        }
    }
    
    public function partition_enclosure_query() {
        $type=$this->input->post('queryop');
        if($type=='q'){
        $applid=$_POST['applId'];//"20129";
        $application_ref_no=$_POST['application_ref_no'];//"RTPS-OP/2020/00036";
        $msgg=$_POST['query'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $applid,
            'application_ref_no' => $application_ref_no,
            'rmk' => $msgg,
            'status' => 'QS',
            'task' => 'AST',
            'file' => ''
        )));
        $result = curl_exec($curl_handle);
        $msg = "Application has been sent back to applicant for enclosure query";
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }else{
        $fee=$this->input->post('fee');
            $applid=$_POST['applId'];//"20129";
            $application_ref_no=$_POST['application_ref_no'];//"RTPS-OP/2020/00036";
            $msgg=$_POST['query'];
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_add_pay_query.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applid,
                'application_ref_no' => $application_ref_no,
                'msg' => $msgg,
                'byaipark_fee' => $fee,
                'status' => 'FRS',
            )));
            $result = curl_exec($curl_handle);
            $msg = "Application has been sent back to applicant for payment query";
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php/home');
        }
    }
    
    public function payment_enclosure_query() {
        $applid=$_POST['applId'];//"20129";
        $application_ref_no=$_POST['application_ref_no'];//"RTPS-OP/2020/00036";
        $msgg=$_POST['query'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $applid,
            'application_ref_no' => $application_ref_no,
            'rmk' => $msgg,
            'status' => 'QS',
            'task' => 'AST',
            'file' => ''
        )));
        
        echo $result = curl_exec($curl_handle);
        //$msg = "Application has been sent back to applicant for enclosure query";
        //$this->session->set_flashdata('message', $msg);
        //redirect(base_url() . 'index.php/home');
    }
    
    function paymentQuery(){
        $case = $this->input->get('case');
        $applid = $this->input->get('applid');
        

        
        $sql="Select * from petition_basic where case_no='$case'";
        $data['payment']=$this->db->query($sql)->row();
        
        $url = RTPS_LINK."partition/recieve_partition_fee_status.php?application_ref_no=" . 
        $data['payment']->application_ref_no ."&applid=". $data['payment']->applid ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['status']=$output;
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/paymentConfirm',$data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'serviceplus/paymentConfirm';
        $this->load->view('layouts/main',$data);
    }
    
    function ConfirmPayment(){
        //var_dump($_POST);
        //exit;
        $data = array('if_paid' => 'Y');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $petition_no = $this->input->post('petition_no');
        $this->db->where('petition_no', $petition_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('petition_byayprak', $data);
        $data = array('pay_notice_gen_yn' => 'Y');
        $this->db->where('petition_no', $petition_no);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->update('petition_basic', $data);
        redirect('/home');
    }
    function PrintForAsts(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $cert_no = $_GET['cert_no'];
        $co_comment = 'ApproveForPrint';
        $user_code = $this->session->userdata('user_code');
        $comment_date = date('Y-m-d G:i:s');
        $arr = array(
            'co_checked_yn' => 'Y',
            'status' => 'B',
            'user_code' => $user_code,
            'co_comment' => $co_comment,
            'comment_date' => $comment_date,
            'service_status'=>'R'
        );

         //#STRAT PLB
        $basundhara=$basundharaExist=$this->rtpsmodel->checkExistBasundhar($cert_no);
        if($basundhara){
            $rmk='Forwarded to Assistant';
            $status='M';
            $task='CO';
            $pen='AST';
            $case=$cert_no;
            $this->rtpsmodel->postApiBasundhara($basundhara,$case,$rmk,$status,$task,$pen);
        }
        //#END PLB
        $this->db->where('cert_no', $cert_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);

        $msg = "Certificate is ready Now. Forwarded it to the Assistant For Print and Upload in RTPS End. Application No. ##" . $cert_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }
    function AssttPrint(){
        $cert_no = $this->input->get('cert_no');
        $cert_type = $this->input->get('certtype');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //exit;
        if($cert_type=='01'){
            //$cert_no = $this->input->post('cert_no');

            $pdar_alignment = '1';
            if ($cert_no != null) {
                // echo "adadas";
                $t_reclassification = $this->db->query("Select * from cert_application where cert_no = '$cert_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
                //var_dump($t_reclassification);
                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;
                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = $t_reclassification->patta_no;
                $comment_date = $t_reclassification->comment_date;
                $couser_code = $t_reclassification->user_code;
                $application_ref_no=$t_reclassification->application_ref_no;
                $user_code = $this->input->post('user_code');
            }
            $this->load->helper('qrcode');
            $main = array();
            $jamainfo = array();
            $pattatype = array(
                'patta_type' => $pattatypeCode,
                'patta_no' => $patta_no,
                'case_no' => $cert_no,
                'submission_date' => $comment_date,
                'application_ref_no'=>$application_ref_no
            );


            $this->session->set_userdata($pattatype);
            $this->load->model('misreport/MisModel');

            $districtdata = $this->MisModel->getDistrictName($dist_code);
            //echo $districtdata[0]->district;
            $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
            //var_dump($subdivdata);
            $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
            //var_dump($circledata);
            $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

            $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
            $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
            $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
            //var_dump($username);
            //$maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);

            $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
            $maindata['pattainfo'] = $pattatype;
            $maindata['username'] = $username;
            //print_r($maindata['namedata']);
            $pno = $patta_no;
            $main['daginfo'] = array();

            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from "
            . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
            . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
            . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
            $main['daginfo'] = $daginfo = $this->db->query($query)->result();
            foreach ($daginfo as $p) {
                $b = $p->dag_area_b;
                $k = $p->dag_area_k;
                $lc = round($p->dag_area_lc, 2);
            }
            $daginfo_counted = count($main['daginfo']);
            
            $main['sort_pdar_by']='1';
            if ($daginfo_counted != "") {

//                $query = "select patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_sl_no "
//                        . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
//                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
//                        . "patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') order by pdar_sl_no ";
//                //echo $query . "<br>";
//                $main['pattadarinf'] = $this->db->query($query)->result();

                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                    $q = $this->db->query($query)->result();

                    $q1 = array();

                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                    $q = $this->db->query($query)->result();

                    $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                    . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                    $q1 = $this->db->query($query1)->result();
                }
                $main['pattadarinf'] = array_merge($q,$q1);

                $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                //echo $query . "<br>";
                $main['remarkinf'] = $this->db->query($query)->result();
                $query = "select old_patta_no from jama_patta WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)=TRIM('$pno') ";
                //echo $query . "<br>";
                $main['oldpno'] = $this->db->query($query)->result();

                $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
                //echo $q;
                $pattadarname = $this->db->query($q)->row();
                //var_dump($pattadarname);
                $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

                $base_64 = printQR($pname);
                $main['qrcode'] = $base_64;

                $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
                $main['qrBasic'] = $basic;

                $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
                $main['qrCONAME'] = $coQR;

                $main = array_merge($maindata, $main);
                $main['sort_pdar_by']=1;
                $this->load->helper('html');
                $this->load->view('header');
                $this->load->view('serviceplus/save_jamabandi_by_selecting_pattano_print_ast', $main);
                $this->load->view('../views/footer');
            }
        }elseif($cert_type=='07'){
            $this->session->set_userdata('case_no',$cert_no);
            
            $sql = "Select * from cert_application where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and cert_no='$cert_no'  ";
            $data['certDtls'] = $certDtls = $this->db->query($sql)->row();
            $mouza_pargona_code = $certDtls->mouza_pargona_code;
            $lot_no = $certDtls->lot_no;
            $vill_townprt_code = $certDtls->vill_townprt_code;
            $tot_price = 0;

        //$cntDag=0;
        //$sqlstr="( ";
            if ($cert_type == '07') {
                $query = "select * from petition_proceeding where case_no =trim('$certDtls->mut_case_no') and dist_code='$dist_code' and subdiv_code='$subdiv_code' "
                . "and cir_code='$cir_code'";
                $data['cases'] = $this->db->query($query)->result();
            //var_dump($data);
            }


            $sql = "Select * from loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  priv='adm' and dis_enb_option='E'  ";
            $name = $this->db->query($sql)->result();
            foreach ($name as $n) {
                $q = "select * from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
                and cir_code='$cir_code' and user_desig_code='CO' and user_code='$n->user_code' ";
                $data['users'] = $this->db->query($q)->result();
            //$data['users'] = $data->result();
            }


        //$data['users'] = $this->db->query($sql)->result();
            $location = $this->utilityclass->getLocationFromSession();
            $dist = $this->utilityclass->getDistrictName($dist_code);
            $sub = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
            $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
            $lotname = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $vill_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //The following line added by Bijoy Mazumder, DIO, Bongaigaon on 26/04/2017 to count no of Pattadar against a Patta No.
            $sqlCNT = "Select count(*) as c1 from jama_pattadar where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$certDtls->patta_no') and "
            . "patta_type_code='$certDtls->patta_type_code' and p_flag!='1' ";

            $dataCNT = $this->db->query($sqlCNT)->row();
        //$dataCNT = $this->db->query($sqlstr)->row();
        //-------------------------------------------------------------------------
            $data['location'] = array(
                'distname' => $dist,
                'subname' => $sub,
                'cirname' => $cir,
                'mouza_pargona_code' => $mouza_name,
                'lot_no' => $lotname,
                'vill_townprt_code' => $vill_name,
                'tot_price' => $tot_price,
                'tot_pdar' => $dataCNT->c1 ,
                'application_ref_no'=>$certDtls->application_ref_no
            );
        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/Serviceplus/PrintCertOS_print', $data);
        // $this->load->view('../views/footer');

            $data['_view'] = 'serviceplus/PrintCertOS_print';
            $this->load->view('layouts/main',$data);
        }
    }
    function AssttPrintPage(){
        //var_dump($_GET);
        $case_no = $this->input->get('cert_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $arr = array(
            'status' => 'B',
            //'user_code' => $user_code,
            'service_status'=>'R'
        );
        $this->db->where('cert_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('cert_application', $arr);
        //exit;
        $msg = "Please sign the Copy by CO and Upload in the Portal. Application No. ##" . $case_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }
    function tot_file(){
       $dist_code = $this->session->userdata('dist_code');
       $subdiv_code = $this->session->userdata('subdiv_code');
       $cir_code = $this->session->userdata('cir_code');
       //#START PLB
       $sql="(select t.dist_code,t.subdiv_code,t.application_ref_no as application_ref_no,t.cert_no, t.cir_code,
        t.mouza_pargona_code,t.lot_no,t.vill_townprt_code,t.appln_name,t.cert_type,t.patta_no, t.basundhara as basundhara,t.applid as applid
        from
        (
        (Select distinct on (application_ref_no) application_ref_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,appln_name,cert_type,patta_no, ba.basundhara as basundhara,ca.applid as applid,cert_no from Cert_Application ca 
         left join basundhar_application ba on ba.dharitree=ca.cert_no where dist_code=? and subdiv_code=? and
         cir_code=? and status='B' and service_status='R' ) 
        union 
        (Select application_ref_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,appln_name,cert_type,patta_no, basundhara ,ca.applid as applid,cert_no from Cert_Application ca left join basundhar_application ba 
         on ba.dharitree=ca.cert_no where dist_code=? and subdiv_code=? and cir_code=? and status='B' 
         and service_status='R' and ba.basundhara is not null )
         ) t)";
       //#END PLB
       $data['tot_case']=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$dist_code,$subdiv_code,$cir_code))->result();
       $data['_view'] = 'serviceplus/tot_file';
       $this->load->view('layouts/main',$data);

   }
   function uploadFile(){
      $data=array('error'=>'');
      $data['_view'] = 'serviceplus/uploadfile';
      $this->load->view('layouts/main',$data);

  }
  function do_upload(){
    $file = file_get_contents($_FILES['file']['tmp_name']);
    $file_upload = base64_encode($file);
    $application_ref_no=$this->input->post('application_ref_no');
    $application_no=$this->input->post('application_no');
    $case_no=$this->input->post('case_no');
    $applid=$this->input->post('applid');
    $type=$this->input->post('type');
    $curl_handle = curl_init();
    if($type=='01'){
        //#START PLB
        if($application_ref_no)
        {
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_co_order_sp.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $applid,
                'application_ref_no' => $application_ref_no,
                //'fee_amount' => '20',
                'file_upload' => $file_upload,
                'remark' => 'Order Passed',
            )));
            $result = curl_exec($curl_handle);
            $result=json_decode($result);
            $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            curl_close($curl_handle);
            if($httpcode != 200){
                $msg = "Error in Uploading. Please Try Again. Application No. ##" . $application_ref_no.$application_no;
                $this->session->set_flashdata('message', $msg);
                redirect(base_url() . 'index.php/home');
            }
        }
        elseif($application_no)
        {
            $rmk='Uploads certificate';
            $status='F';
            $task='AST';
            $pen='NA';
            $case=$case_no;
            $result= $this->rtpsmodel->postApiDocBasundhara($application_no,$case,$rmk,$status,$task,$pen,$file_upload);
        }
    }else{
            //curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_co_order.php");
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."mutation_order/mutation_order_status_update.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => $applid,
            'application_ref_no' => $application_ref_no,
            'rmk' => 'Application Delivered',
            'status' => 'D',
            'task' => 'CO',
            'file' => $file_upload,
        )));
        $result = curl_exec($curl_handle);
        $result=json_decode($result);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode != 200){
            $msg = "Error in Uploading. Please Try Again. Application No. ##" . $application_ref_no.$application_no;
            $this->session->set_flashdata('message', $msg);
            redirect(base_url() . 'index.php/home');
        }
    }
    if(($result->status=='true') or ($result->status=='Invalid Data')){
        $arr = array(
            'service_status' => 'D',
        );

        if($application_no)
        {
            $this->db->where('cert_no', $case_no);
            $this->db->update('cert_application', $arr);
        }
        elseif($application_ref_no)
        {
            $this->db->where('application_ref_no', $application_ref_no);
            $this->db->update('cert_application', $arr);
        }

        $msg = "File Uploaded Successfully. Application No. ##" . $application_ref_no.$application_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }else{
        $msg = "Error in Uploading. Please Try Again. Application No. ##" . $application_ref_no.$application_no;
        $this->session->set_flashdata('message', $msg);
        redirect(base_url() . 'index.php/home');
    }
    //#END PLB
}
    // function QueryBox(){
        // $this->load->view('../views/header');
        // $this->load->view('../views/serviceplus/querybox');
        // $this->load->view('../views/footer');
    // }
    // function ResultQuery(){
            // $sql=ucfirst(trim($this->input->post('sql')));
            // if ( strstr( $sql, 'Select' ) ) {                  
                    // $data['data']=$this->db->query($sql)->result();
                    // $data['field']=$this->db->query($sql)->list_fields();
                    // //var_dump($data);
                    // if($data['data']){
                        // $this->load->view('../views/header');
                        // $this->load->view('../views/serviceplus/queryresult',$data);
                        // $this->load->view('../views/footer');
                    // }else{
                        // redirect('/Serviceplus/QueryBox');
                        // exit;
                    // }

                // } else {
                 // redirect('/Serviceplus/QueryBox');
                 // exit;
                // }    
        // //}
    // }
    ///////////////Regenerate JB Copy/////////////////////
function regenratejbCopy(){
    $data['_view'] = 'serviceplus/regenratejbcopy';
    $this->load->view('layouts/main',$data);
} 
function regenerateJB(){
    $cert_no = trim($this->input->post('cert_no'));
        $sql="Select count(*) as c from cert_application where (cert_no='$cert_no' or application_ref_no='$cert_no' ) and  status='B' and service_status='R'  ";//and status=''
        $count=$this->db->query($sql)->row()->c;
        if($count==0){
            $this->session->set_flashdata('message',"Case no not Found.");
            redirect('/home');
        }
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $pdar_alignment = '1';
        if ($cert_no != null) {
            $t_reclassification = $this->db->query("Select * from cert_application where (cert_no='$cert_no' or application_ref_no='$cert_no' ) and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
            $dist_code = $t_reclassification->dist_code;
            $subdiv_code = $t_reclassification->subdiv_code;
            $circle_code = $t_reclassification->cir_code;
            $mouza_code = $t_reclassification->mouza_pargona_code;
            $lot_no = $t_reclassification->lot_no;
            $vill_code = $t_reclassification->vill_townprt_code;
            $pattatypeCode = $t_reclassification->patta_type_code;
            $patta_no = $t_reclassification->patta_no;
            $comment_date = $t_reclassification->comment_date;
            $couser_code = $t_reclassification->user_code;
            $application_ref_no=$t_reclassification->application_ref_no;
            $cert_no=$t_reclassification->cert_no;
            $user_code = $this->input->post('user_code');
        }
        $this->load->helper('qrcode');
        $main = array();
        $jamainfo = array();
        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no,
            'case_no' => $cert_no,
            'submission_date' => $comment_date,
            'application_ref_no'=>$application_ref_no
        );


        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        $maindata['username'] = $username;
        $pno = $patta_no;
        $main['daginfo'] = array();

        $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from "
        . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
        . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
        . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
        $main['daginfo'] = $daginfo = $this->db->query($query)->result();
        foreach ($daginfo as $p) {
            $b = $p->dag_area_b;
            $k = $p->dag_area_k;
            $lc = round($p->dag_area_lc, 2);
        }
        $daginfo_counted = count($main['daginfo']);           
        $main['sort_pdar_by']='1';
        if ($daginfo_counted != "") {

            if ($pdar_alignment == '0') {
                $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                $q = $this->db->query($query)->result();

                $q1 = array();

            }
            if ($pdar_alignment == '1') {
                $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                $q = $this->db->query($query)->result();

                $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                $q1 = $this->db->query($query1)->result();
            }
            $main['pattadarinf'] = array_merge($q,$q1);

            $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
            . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
            . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
            . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
                //echo $query . "<br>";
            $main['remarkinf'] = $this->db->query($query)->result();
            $query = "select old_patta_no from jama_patta WHERE "
            . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
            . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
            . "TRIM(patta_no)=TRIM('$pno') ";
            $main['oldpno'] = $this->db->query($query)->result();

            $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
            . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
            $pattadarname = $this->db->query($q)->row();
            $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

            $base_64 = printQR($pname);
            $main['qrcode'] = $base_64;

            $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
            $main['qrBasic'] = $basic;

            $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
            $main['qrCONAME'] = $coQR;

            $main = array_merge($maindata, $main);
            $main['sort_pdar_by']=1;
            $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print_ast';
            $this->load->view('layouts/main',$main);
        }
        
    }

    function forceUpdate(){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."ror/ror_co_order.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'applid' => '18474062',
            'application_ref_no' => 'RTPS-ROR/2021/00179',
            'rmk' => $msgg,
                //'fee_amount' => '20',
            'file_upload' => $file_upload,
            'remark' => 'Order Passed',
        )));
        $result = curl_exec($curl_handle);
    }
    function regenerateJB_Copy(){
        $cert_no = trim($this->input->get('cert_no'));
        $sql="Select count(*) as c from cert_application where (cert_no='$cert_no' or application_ref_no='$cert_no' ) and  status='B' and service_status='R' and user_code like 'CO%'  ";//and status=''
        $count=$this->db->query($sql)->row()->c;
        if($count==0){
            $this->session->set_flashdata('message',"Case no not Found.");
            redirect('/home');
        }
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $pdar_alignment = '1';
        if ($cert_no != null) {
            //#START PLB
           $t_reclassification = $this->db->query("Select ca.*,ba.basundhara from Cert_Application ca left join basundhar_application ba on ba.dharitree=ca.cert_no  where (cert_no='$cert_no' or application_ref_no='$cert_no' ) and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ")->row();
            $dist_code = $t_reclassification->dist_code;
            $subdiv_code = $t_reclassification->subdiv_code;
            $circle_code = $t_reclassification->cir_code;
            $mouza_code = $t_reclassification->mouza_pargona_code;
            $lot_no = $t_reclassification->lot_no;
            $vill_code = $t_reclassification->vill_townprt_code;
            $pattatypeCode = $t_reclassification->patta_type_code;
            $patta_no = $t_reclassification->patta_no;
            $comment_date = $t_reclassification->comment_date;
            $couser_code = $t_reclassification->user_code;
            $application_ref_no=$t_reclassification->application_ref_no;
            $cert_no=$t_reclassification->cert_no;
            $user_code = $this->input->post('user_code');
            $basundhara=$t_reclassification->basundhara;
        }
        $this->load->helper('qrcode');
        $main = array();
        $jamainfo = array();
        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no,
            'case_no' => $cert_no,
            'submission_date' => $comment_date,
            'application_ref_no'=>$application_ref_no
        );


        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);

        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $circle_code, $couser_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        $maindata['username'] = $username;
        $main['basundhara']=$basundhara;
        $pno = $patta_no;
        $main['daginfo'] = array();

        $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from "
        . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
        . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
        . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
        $main['daginfo'] = $daginfo = $this->db->query($query)->result();
        foreach ($daginfo as $p) {
            $b = $p->dag_area_b;
            $k = $p->dag_area_k;
            $lc = round($p->dag_area_lc, 2);
            $g = $p->dag_area_g;
        }
        $daginfo_counted = count($main['daginfo']);           
        $main['sort_pdar_by']='1';
        if ($daginfo_counted != "") {

            if ($pdar_alignment == '0') {
                $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                $q = $this->db->query($query)->result();

                $q1 = array();

            }
            if ($pdar_alignment == '1') {
                $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                $q = $this->db->query($query)->result();

                $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                . "from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";

                $q1 = $this->db->query($query1)->result();
            }
            $main['pattadarinf'] = array_merge($q,$q1);

            $query = "select patta_no,remark,rmk_line_no from jama_remark WHERE "
            . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
            . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
            . "TRIM(patta_no)=TRIM('$pno') order by rmk_line_no";
        
            $main['remarkinf'] = $this->db->query($query)->result();
            $query = "select old_patta_no from jama_patta WHERE "
            . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
            . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
            . "TRIM(patta_no)=TRIM('$pno') ";
         
            $main['oldpno'] = $this->db->query($query)->result();

            $q = " select pdar_name,pdar_father,pdar_add1 from jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' "
            . "and cir_code='$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)=TRIM('$pno') and pdar_id='$t_reclassification->pdar_id'   ";
       
            $pattadarname = $this->db->query($q)->row();
           
            $pname = "à¦†à¦¬à§‡à¦¦à¦¨à¦•à¦¾à§°à§€à§° à¦¨à¦¾à¦® :" . $pattadarname->pdar_name . "," . $pattadarname->pdar_father . "," . $pattadarname->pdar_add1 . "(à¦¬à¦¿-à¦•-à¦²à§‡)" . "-" . $b . "-" . $k . "-" . $lc;

            $base_64 = printQR($pname);
            $main['qrcode'] = $base_64;

            $basic = printQR($districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-" . $mouzadata[0]->mouza . "-" . $lotdata[0]->lot_no . "-" . $villagedata[0]->village . "à¦ªà¦¾à¦Ÿà§?à¦Ÿà¦¾ à¦¨à¦‚ " . $patta_no);
            $main['qrBasic'] = $basic;

            $coQR = printQR("à¦šà¦•à§?à§° à¦¬à¦¿à¦·à¦¯à¦¼à¦¾ - " . $username->username . "-" . $districtdata[0]->district . "-" . $subdivdata[0]->subdiv . "-" . $circledata[0]->circle . "-Sign dated :" . $comment_date);
            $main['qrCONAME'] = $coQR;

            $main = array_merge($maindata, $main);
            $main['sort_pdar_by']=1;


            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
               $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print_ast_kar';
            }
            else{
                 $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print_ast';
            }

           // $main['_view'] = 'serviceplus/save_jamabandi_by_selecting_pattano_print_ast';
            $this->load->view('layouts/main',$main);
        }
        
    }
    function rtpsPart(){
        $application_ref_no='RTPS-OP/2022/00199';
        $applid='19170617';
        $case_no='LAK/DHA/2021-22/23846/OPART';
        $petition_no='23846';
        $user_code='AS3';
        $date=date('2022-04-19 11:26:07');
        $year_no='2021';
        ////////////////////////////////////////
        $url = RTPS_LINK."partition/partition_case_details.php?application_ref_no=" . $application_ref_no . "&applid=" . $applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        echo "<pre>";
        
        $pattaDar=$output[0]->pattadar_details;
        $cron_no=1;
        foreach($pattaDar as $pataadarList){
            $other_data = array(
                'dist_code' => $pataadarList->dist_code,
                'subdiv_code' => $pataadarList->subdiv_code,
                'cir_code' => $pataadarList->cir_code,
                'mouza_pargona_code' => $pataadarList->mouza_pargona_code,
                'lot_no' => $pataadarList->lot_no,
                'vill_townprt_code' => $pataadarList->vill_townprt_code,
                'year_no' => $year_no,
                'petition_no' => $petition_no,
                'dag_no' => $pataadarList->dag_no/100,
                'patta_no' => $pataadarList->patta_no,
                'patta_type_code' => $pataadarList->patta_type_code,
                'pdar_id' => $pataadarList->pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pataadarList->pdar_name,
                'pdar_guardian' => $pataadarList->pdar_guardian,
                'pdar_rel_guar' => $pataadarList->pdar_rel_guar,
                    // 'pdar_name' => 'শ্ৰী মতী বিনীতা বৰা',
                    // 'pdar_guardian' => 'স্বামী-শ্ৰী নীলকান্ত ',
                    // 'pdar_rel_guar' => 'h',
                'pdar_add1' => $pataadarList->pdar_add1,
                'pdar_add2' => $pataadarList->pdar_add2,
                'user_code' => $user_code,
                'date_entry' => $date,
                'operation' => 'E',
                'case_no' => $case_no
            );
        }
    }



    function rejectCOJB()
    {
        $cert_no=$this->input->post('cert_no');
        $co_report=$this->input->post('co_report');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $cir_code=$this->input->post('cir_code');

        $this->form_validation->set_rules('co_report', 'Remark', 'trim|required');

        if($this->form_validation->run()==false)
           {
                $text=str_ireplace('<\/p>','',validation_errors());
                $text=str_ireplace('<p>','',$text);
                $text=str_ireplace('</p>','',$text);
                echo json_encode(array('msg'=>$text, 'st'=>0));
                return;
           }

        else
        {

            $this->db->trans_begin();

            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from    petition_proceeding where case_no='$cert_no'")->row()->pid;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
         
            $proceeding = array(
                'case_no' => $cert_no,
                'proceeding_id' =>  $proceeding_id,
                'date_of_hearing' => date("Y-m-d h:i:s"),
                'co_order' => $co_report,
                'next_date_of_hearing' => null,
                'status' => '0',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date("Y-m-d h:i:s"),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' =>$subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip(),
            );
            $proceeding1 = $this->db->insert('petition_proceeding', $proceeding);
            if ($proceeding1 == false) {
                $data = array(
                    'msg' => "Case Cannot Be Registered. Unable to save data. [##RJCTJB001]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##RJCTJB001. Unable to save data into 
                            petition_proceeding. case no. $cert_no");
                return $data;
            }


            $update_jb = array(
                'status' => 'R',
                'co_checked_yn' => 'Y',
                'service_status' => 'R'
            );

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('cert_no', $cert_no);
            $this->db->update('cert_application', $update_jb);
            if($this->db->affected_rows() != 1){
            $this->db->trans_rollback();
            log_message("error"," #ERRJB00002: Updation failed in cert_application 
                for case no: ". $cert_no);            
            $this->session->set_flashdata('message',"#ERRJB00002: Final Submission failed 
                for case no : ".$cert_no);
            redirect(base_url() . 'index.php/home');
            return false;    
            }

            $basundharaExist=$this->rtpsmodel->checkExistBasundhar($cert_no);
            if($basundharaExist)
            {
                $rmk=addslashes($this->input->post('co_report'));
                $status='R';
                $task='CO';
                $pen='NA';
                $case=$cert_no;
                $api_data = $this->rtpsmodel->postApiBasundharaJB($case,$rmk,$status,$task,$pen);
                if($api_data == false || $api_data == 'false')
                {
                    $this->db->trans_rollback();
                    log_message('error','#ERREJ0003: Basundhara API failed.');
                    $this->session->set_flashdata('message',"#ERRJB00003:Rejection failed 
                for case no : ".$cert_no);
                    redirect(base_url() . 'index.php/home');
                    return false;   
                }

                else
                {
                    $this->db->trans_commit();
                    //$this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Case $cert_no is Rejected.");
                    redirect(base_url() . 'index.php/home');
                }

            }

            else
            {
                $this->db->trans_commit();
                //$this->db->trans_rollback();
                $this->session->set_flashdata('message', "Case $cert_no is Rejected.");
                redirect(base_url() . 'index.php/home');
            }
        }
    }
}
